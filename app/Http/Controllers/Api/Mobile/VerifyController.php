<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Api\ApiController;
use App\Models\Alert;
use App\Models\Code;
use App\Models\ScanHistory;
use Illuminate\Http\Request;

class VerifyController extends ApiController
{
    public function diagnose(Request $request)
    {
        $user = $this->requireUser($request);

        $this->validateInput($request, [
            'code' => 'required|string|max:255',
        ]);

        $raw = trim($request->input('code'));

        $code = Code::where('qr_code', $raw)->orWhere('code_data', $raw)->first();

        if (!$code) {
            return $this->verdict(
                'fake',
                'Not a genuine code',
                'This code is not registered with TraceSci. It may be counterfeit or copied from another pack.',
                $raw,
                null,
                true
            );
        }

        $product = $code->getProduct;
        $batch   = $code->getBatch;

        if (empty($code->batch_id)) {
            return $this->verdict(
                'not_activated',
                'Not activated yet',
                'This pack has not been released for sale. Buying it from a shop is unusual — please report where you found it.',
                $raw,
                $code,
                true
            );
        }

        if ((string) $code->status === '0') {
            $byBrand = !empty($code->deactivated_at) || !empty($code->deactivated_by);
            $reason  = trim((string) $code->deactivate_reason);

            $message = $byBrand
                ? 'The brand has withdrawn this pack from sale. Do not use it.'
                : 'This pack was withdrawn from sale by an official. Do not use it.';

            if ($reason !== '') {
                $message .= ' Reason given: ' . $reason;
            }

            return $this->verdict(
                $byBrand ? 'deactivated' : 'blocked',
                $byBrand ? 'Withdrawn by the brand' : 'Blocked by an inspector',
                $message,
                $raw,
                $code,
                true
            );
        }

        if ($batch && !empty($batch->exp_date) && strtotime($batch->exp_date) < time()) {
            return $this->verdict(
                'expired',
                'Past its expiry date',
                'This pack expired on ' . $this->date($batch->exp_date, 'M d, Y') . '. Do not consume it.',
                $raw,
                $code,
                true
            );
        }

        $scanCount = $this->consumerScanCount($code->id);

        if ($scanCount > 15) {
            return $this->verdict(
                'over_scanned',
                'Scanned unusually often',
                'This code has been scanned ' . $scanCount . ' times. Genuine packs are rarely scanned this much — the code may have been copied.',
                $raw,
                $code,
                true
            );
        }

        return $this->verdict(
            'genuine',
            'Looks genuine',
            'This pack is registered with ' . ($product && $product->brand ? $product->brand : 'the brand') . ' and is active.',
            $raw,
            $code,
            false
        );
    }

    protected function verdict($status, $title, $message, $raw, $code, $isProblem)
    {
        $product = $code ? $code->getProduct : null;
        $batch   = $code ? $code->getBatch : null;

        return $this->ok($title, [
            'status'      => $status,
            'title'       => $title,
            'message'     => $message,
            'is_problem'  => $isProblem,
            'can_report'  => true,
            'scanned_code' => $raw,
            'code_data'   => $code ? $code->code_data : $raw,
            'serial_number' => $code ? $code->code_data : $raw,
            'product'     => $product ? [
                'id'              => $product->id,
                'name'            => $product->name,
                'brand'           => $product->brand,
                'image'           => $this->assetUrl($product->image_url),
                'manufacturer'    => $code->getUser && $code->getUser->getCompany
                    ? $code->getUser->getCompany->name
                    : null,
                'batch_code'      => $batch ? $batch->code : null,
                'manufactured_on' => $batch ? $this->date($batch->mfg_date, 'M d, Y') : null,
                'expiry_on'       => $batch ? $this->date($batch->exp_date, 'M d, Y') : null,
            ] : null,
            'reason'      => $code && trim((string) $code->deactivate_reason) !== ''
                ? $code->deactivate_reason
                : null,
            'deactivated_on' => $code && !empty($code->deactivated_at)
                ? $this->date($code->deactivated_at, 'M d, Y')
                : null,
            'already_reported' => $code
                ? Alert::where('code_id', $code->id)->where('type', '1')->exists()
                : false,
        ]);
    }
}
