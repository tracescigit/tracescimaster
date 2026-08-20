<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\Batch;
use App\Models\Code;
use App\Models\Product;
use App\Models\Report;
use App\Models\ScanHistory;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function report(Request $request)
    {

        $input = $request->all();

        $rules = [
            'token'       =>  'required',
            'product_id'  =>  'required',
            'batch'       =>  'nullable',
            'issue_type'  =>  'required',
            'description' =>  'required',
            'product_uic' =>  'required',
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response([
                'success' => false,
                'message' => 'Invalid request',
                'errors' => $errors
            ], 400);
        } else {
            $token = $input['token'];

            try {
                $id = decrypt($token);
            } catch (Exception $e) {
                return response([
                    'success' => false,
                    'message' => 'Invalid token',
                    'errors' => ['token' => ['Invalid token']]
                ], 400);
            }


            $user = User::find($id);

            if (!$user) {
                return response([
                    'success' => false,
                    'message' => 'Invalid token',
                    'errors' => ['token' => ['Invalid token']]
                ], 400);
            }


            $batch = Batch::find($input['batch']);
            $product = Product::find($input['product_id']);

            if ($product) {
                $check_old = Alert::where('type', '1')->where('reported_uic', $input['product_uic'])->where('scanned_by', $user->id)->exists();

                if ($check_old) {
                    return response([
                        'success' => false,
                        'message' => 'This product is already reported by you.',
                        'errors' => ['product' => ['Already reported.']]
                    ], 400);
                }
            }


            $report = new Alert;

            $report->scanned_by = $user->id;
            $report->product_id = $product->id ?? null;
            $report->product_name = $product ? ($product->name ?? $input['product_id']) : null;
            $report->reported_uic = $input['product_uic'] ?? null;
            $report->batch = $batch ? $batch->code : null;
            $report->batch_id = $batch ? $batch->id : null;
            $report->issue_type = $input['issue_type'];
            $report->alert_message = $input['description'];
            $report->type = "1";

            if (isset($input['code_data']) && $input['code_data'] != '') {

                $code = Code::where('code_data', $input['code_data'])->first();

                if ($code) {
                    $report->code_id = $code->id;
                }
            }

            if (!empty($request->image)) {

                $imageData = base64_decode($request->image);

                $folder = public_path('reports');

                if (!is_dir($folder)) {
                    mkdir($folder, 0755, true);
                }

                $fileName = 'report_' . uniqid() . '.png';
                $filePath = $folder . DIRECTORY_SEPARATOR . $fileName;

                file_put_contents($filePath, $imageData);

                $report->image = 'reports/' . $fileName;
            }

            if (isset($input['location'])) {

                $location = $input['location'];

                // GPS Location
                if (
                    isset($location['source']) &&
                    $location['source'] === 'gps' &&
                    !empty($location['lat']) &&
                    !empty($location['long'])
                ) {

                    $report->location = json_encode([
                        'source' => 'gps',
                        'lat'    => (float)$location['lat'],
                        'lng'    => (float)$location['long'],
                    ]);
                }

                // IP Location
                elseif (
                    isset($location['source']) &&
                    $location['source'] === 'ip'
                ) {

                    $ip = $request->ip();

                    // Skip localhost/private IPs
                    if (
                        filter_var(
                            $ip,
                            FILTER_VALIDATE_IP,
                            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
                        )
                    ) {

                        try {

                            $response = Http::timeout(5)
                                ->get("http://ip-api.com/json/{$ip}");

                            if (
                                $response->successful() &&
                                $response['status'] === 'success'
                            ) {

                                $report->location = json_encode([
                                    'source'  => 'ip',
                                    'ip'      => $ip,
                                    'lat'     => (float)$response['lat'],
                                    'lng'     => (float)$response['lon'],
                                    'city'    => $response['city'],
                                    'region'  => $response['regionName'],
                                    'country' => $response['country'],
                                ]);
                            }
                        } catch (\Exception $e) {
                            // Ignore location API failures
                        }
                    }
                }
            }

            $report->save();

            return response([
                'success' => true,
                'message' => 'Product has been reported successfully',
                'report'  => $report
            ], 200);
        }
    }
}
