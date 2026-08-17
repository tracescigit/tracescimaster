<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Api\ApiController;
use App\Models\Alert;
use App\Models\Batch;
use App\Models\Code;
use Illuminate\Http\Request;

class InspectorController extends ApiController
{
    public function dashboard(Request $request)
    {
        $user = $this->requireUser($request);
        $this->requireRole($user, [self::ROLE_INSPECTOR, self::ROLE_AUTHORITY, self::ROLE_ADMIN, self::ROLE_BRAND]);

        $open   = $this->scopedCases($user)->where('status', '0')->count();
        $closed = $this->scopedCases($user)->where('status', '1')->count();
        $today  = $this->scopedCases($user)->whereDate('created_at', date('Y-m-d'))->count();
        $fakes  = $this->scopedCases($user)->where('type', '0')->where('status', '0')->count();

        $recent = $this->scopedCases($user)->orderBy('updated_at', 'DESC')->limit(8)->get();

        $cards = [];

        foreach ($recent as $case) {
            $cards[] = $this->caseCard($case);
        }

        return $this->ok('Dashboard loaded successfully', [
            'stats' => [
                ['key' => 'open',       'label' => 'Open cases',      'value' => $open,   'icon' => 'folder_open', 'filter' => '0'],
                ['key' => 'closed',     'label' => 'Closed',          'value' => $closed, 'icon' => 'check_circle','filter' => '1'],
                ['key' => 'today',      'label' => 'Raised today',    'value' => $today,  'icon' => 'calendar',    'filter' => null],
                ['key' => 'suspicious', 'label' => 'Suspicious scans','value' => $fakes,  'icon' => 'alert',       'filter' => null],
            ],
            'recent_cases' => $cards,
        ]);
    }

    public function cases(Request $request)
    {
        $user = $this->requireUser($request);
        $this->requireRole($user, [self::ROLE_INSPECTOR, self::ROLE_AUTHORITY, self::ROLE_ADMIN, self::ROLE_BRAND]);

        $query = $this->scopedCases($user)->orderBy('updated_at', 'DESC');

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', '%' . $search . '%')
                  ->orWhere('batch', 'like', '%' . $search . '%')
                  ->orWhere('alert_message', 'like', '%' . $search . '%');
            });
        }

        $self = $this;

        list($items, $meta) = $this->paginate($query, $request, function ($case) use ($self) {
            return $self->publicCaseCard($case);
        });

        return $this->ok('Cases fetched successfully', [
            'cases' => $items,
        ], ['meta' => $meta]);
    }

    public function caseDetail(Request $request, $id)
    {
        $user = $this->requireUser($request);
        $this->requireRole($user, [self::ROLE_INSPECTOR, self::ROLE_AUTHORITY, self::ROLE_ADMIN, self::ROLE_BRAND]);

        $case = $this->scopedCases($user)->where('id', $id)->first();

        if (!$case) {
            return $this->fail('Case not found.', ['case' => ['Case not found']], 404);
        }

        $code    = $case->getCode;
        $product = $case->getProduct;
        $batch   = $case->getBatch;
        $reporter = $case->getUser;

        $manufacturer = null;

        if ($code && $code->getUser) {
            $company = $code->getUser->getCompany;

            $manufacturer = [
                'name'    => $company ? $company->name : $code->getUser->name,
                'email'   => $code->getUser->email,
                'phone'   => trim($code->getUser->phone_code . ' ' . $code->getUser->phone),
                'address' => $company ? companyAddress($company) : '',
            ];
        }

        $journey = [];

        if ($code && $code->aggregation_id && $code->getAggregation) {
            $journey = prepareSupplyChainScanHistory(
                $code->getAggregation->unique_id,
                $code->getAggregation->user_id
            );
        }

        return $this->ok('Case details fetched successfully', [
            'case' => [
                'id'          => $case->id,
                'reference'   => ($case->type === '1' ? 'RPT-' : 'ALT-') . str_pad($case->id, 6, '0', STR_PAD_LEFT),
                'kind'        => $case->type === '1' ? 'Consumer report' : 'System alert',
                'issue_type'  => $case->issue_type,
                'description' => $case->alert_message,
                'status'      => $case->status === '1' ? 'Closed' : 'Open',
                'is_open'     => $case->status !== '1',
                'image'       => $this->assetUrl($case->image),
                'location'    => $this->json($case->location, null),
                'created_at'  => $this->date($case->created_at),
                'created_ago' => $this->ago($case->created_at),
                'resolution'  => $case->status === '1'
                    ? ($case->manufacturer_comment ? $case->manufacturer_comment : $case->admin_comment)
                    : null,
            ],
            'product' => [
                'id'              => $case->product_id,
                'name'            => $case->product_name,
                'brand'           => $product ? $product->brand : null,
                'image'           => $product ? $this->assetUrl($product->image_url) : '',
                'code_data'       => $code ? $code->code_data : null,
                'code_status'     => $code ? ($code->status === '1' ? 'Active' : 'Deactivated') : null,
                'batch_code'      => $batch ? $batch->code : $case->batch,
                'manufactured_on' => $batch ? $this->date($batch->mfg_date, 'M d, Y') : '',
                'expiry_on'       => $batch ? $this->date($batch->exp_date, 'M d, Y') : '',
            ],
            'reported_by' => $reporter ? [
                'name'  => $reporter->name,
                'phone' => trim($reporter->phone_code . ' ' . $reporter->phone),
                'email' => $reporter->email,
            ] : null,
            'manufacturer' => $manufacturer,
            'journey'      => is_array($journey) ? $journey : [],
            'actions'      => [
                'can_close'      => $case->status !== '1',
                'can_deactivate' => $code && $code->status === '1',
            ],
        ]);
    }

    public function updateCase(Request $request, $id)
    {
        $user = $this->requireUser($request);
        $this->requireRole($user, [self::ROLE_INSPECTOR, self::ROLE_AUTHORITY, self::ROLE_ADMIN, self::ROLE_BRAND]);

        $this->validateInput($request, [
            'status'   => 'required|in:0,1',
            'comments' => 'required|string|max:200',
        ]);

        $case = $this->scopedCases($user)->where('id', $id)->first();

        if (!$case) {
            return $this->fail('Case not found.', ['case' => ['Case not found']], 404);
        }

        if ($case->status === '1') {
            return $this->fail('This case is already closed.', ['case' => ['Case closed']], 422);
        }

        $case->status = $request->input('status');

        if ((string) $user->type === '1') {
            $case->admin_comment = $request->input('comments');
        } else {
            $case->manufacturer_comment = $request->input('comments');
        }

        $case->save();

        return $this->ok('Case updated successfully', [
            'case' => [
                'id'     => $case->id,
                'status' => $case->status === '1' ? 'Closed' : 'Open',
            ],
        ]);
    }

    public function seize(Request $request)
    {
        $user = $this->requireUser($request);
        $this->requireRole($user, [self::ROLE_INSPECTOR, self::ROLE_AUTHORITY, self::ROLE_ADMIN, self::ROLE_BRAND]);

        $this->validateInput($request, [
            'type' => 'required|in:0,1',
            'code' => 'required|string|max:255',
        ]);

        if ($request->input('type') === '0' || $request->input('type') === 0) {
            $code = Code::where('code_data', $request->input('code'))
                ->orWhere('qr_code', $request->input('code'))
                ->first();

            if (!$code) {
                return $this->fail('This code was not found.', ['code' => ['Code not found']], 404);
            }

            $code->status    = '0';
            $code->seized_by = $user->id;
            $code->save();

            return $this->ok('The product has been deactivated.', [
                'affected'  => 1,
                'code_data' => $code->code_data,
            ]);
        }

        $batch = Batch::where('code', $request->input('code'))->first();

        if (!$batch) {
            return $this->fail('This batch was not found.', ['code' => ['Batch not found']], 404);
        }

        $affected = Code::where('batch_id', $batch->id)->update([
            'status'    => '0',
            'seized_by' => $user->id,
        ]);

        return $this->ok('The batch has been deactivated.', [
            'affected'   => $affected,
            'batch_code' => $batch->code,
        ]);
    }

    public function map(Request $request)
    {
        $user = $this->requireUser($request);
        $this->requireRole($user, [self::ROLE_INSPECTOR, self::ROLE_AUTHORITY, self::ROLE_ADMIN, self::ROLE_BRAND]);

        $query = $this->scopedCases($user)->whereNotNull('location');

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $points = [];

        foreach ($query->orderBy('created_at', 'DESC')->limit(300)->get() as $case) {
            $location = $this->json($case->location, null);

            if (!is_array($location)) {
                continue;
            }

            $lat = isset($location['latitude']) ? $location['latitude'] : (isset($location['lat']) ? $location['lat'] : null);
            $lng = isset($location['longitude']) ? $location['longitude'] : (isset($location['lng']) ? $location['lng'] : null);

            if ($lat === null || $lng === null) {
                continue;
            }

            $points[] = [
                'id'        => $case->id,
                'latitude'  => (float) $lat,
                'longitude' => (float) $lng,
                'title'     => $case->product_name,
                'subtitle'  => $case->alert_message,
                'status'    => $case->status === '1' ? 'Closed' : 'Open',
                'date'      => $this->date($case->created_at, 'M d, Y'),
            ];
        }

        return $this->okList('Map data fetched successfully', 'points', $points);
    }

    protected function scopedCases($user)
    {
        $query = Alert::query();

        if ((string) $user->type === '1') {
            $query->where('admin_assigned_to', $user->id);
        }

        if ((string) $user->type === '2') {
            $query->where(function ($q) use ($user) {
                $q->where('manufacturer_assigned_to', $user->id)
                  ->orWhere('vendor_assigned_to', $this->ownerId($user));
            });
        }

        return $query;
    }

    public function caseCard($case)
    {
        return [
            'id'          => $case->id,
            'reference'   => ($case->type === '1' ? 'RPT-' : 'ALT-') . str_pad($case->id, 6, '0', STR_PAD_LEFT),
            'kind'        => $case->type === '1' ? 'Consumer report' : 'System alert',
            'product_name' => $case->product_name,
            'batch'       => $case->batch,
            'issue_type'  => $case->issue_type,
            'description' => $case->alert_message,
            'status'      => $case->status === '1' ? 'Closed' : 'Open',
            'is_open'     => $case->status !== '1',
            'reported_by' => $case->getUser ? trim($case->getUser->phone_code . ' ' . $case->getUser->phone) : '',
            'location'    => $this->json($case->location, null),
            'created_at'  => $this->date($case->created_at),
            'created_ago' => $this->ago($case->created_at),
        ];
    }

    public function publicCaseCard($case)
    {
        return $this->caseCard($case);
    }
}
