<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aggregation;
use App\Models\Cashback;
use App\Models\Code;
use App\Models\CouponCode;
use App\Models\ProductTemplate;
use App\Models\RewardOrder;
use App\Models\RewardScheme;
use App\Models\ScanHistory;
use App\Models\SupplyChainAction;
use App\Models\User;
use App\Models\Wallet;
use Exception;
use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http as FacadesHttp;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ScanController extends Controller
{
	public function show(Request $request, $scan_code)
	{
		$input = $request->all();

		Log::info('scan.show: entry', [
			'scan_code' => $scan_code,
			'input'     => $input,
			'ip'        => $request->ip(),
		]);

		$rules = [
			'token'       =>  'required'
		];

		$validator = Validator::make($input, $rules);

		if ($validator->fails()) {
			$errors = $validator->errors();

			Log::warning('scan.show: validation failed', [
				'scan_code' => $scan_code,
				'errors'    => $errors,
			]);

			return response([
				'success' => false,
				'message' => 'Invalid request',
				'errors' => $errors
			], 400);
		} else {
			$token = $input['token'];
			$latitude = data_get($input, 'location.lat');
			$longitude = data_get($input, 'location.long');

			$hasGpsLocation = is_numeric($latitude) && is_numeric($longitude);

			$location = null;

			if ($hasGpsLocation) {

				$location = [
					'source' => 'gps',
					'lat'    => $latitude,
					'lng'    => $longitude,
				];
			} else {

				// $ip = app()->environment('local')
				// 	? '8.8.8.8'
				// 	: $request->ip();

				$ip = $request->ip();
				$response = FacadesHttp::timeout(5)->get("http://ip-api.com/json/{$ip}");

				if ($response->successful()) {

					$data = $response->json();

					$location = [
						'source'  => 'ip',
						'ip'      => $ip,
						'lat'     => $data['lat'] ?? null,
						'lng'     => $data['lon'] ?? null,
						'city'    => $data['city'] ?? null,
						'region'  => $data['regionName'] ?? null,
						'country' => $data['country'] ?? null,
					];
				} else {

					$location = [
						'source' => 'ip',
						'ip' => $ip,
					];
				}
			}

			Log::info('scan.show: validation passed, attempting token decrypt', [
				'scan_code' => $scan_code,
			]);

			try {
				$id = decrypt($token);
				Log::info('scan.show: token decrypted successfully', [
					'scan_code'  => $scan_code,
					'decrypted_id' => $id,
				]);
			} catch (Exception $e) {
				Log::error('scan.show: token decryption failed', [
					'scan_code' => $scan_code,
					'message'   => $e->getMessage(),
				]);

				return response([
					'success' => false,
					'message' => 'Invalid token',
					'errors' => ['token' => ['Invalid token']]
				], 400);
			}

			$user = User::find($id);
			$code = Code::where('code_data', $scan_code)->first();

			Log::info('scan.show: user and code lookup', [
				'scan_code'   => $scan_code,
				'user_id'     => $id,
				'user_found'  => (bool) $user,
				'code_found'  => (bool) $code,
				'code_id'     => $code->id ?? null,
			]);

			$alert = array(
				'alert_message' => 'Suspicious Product',
				'product_name' => $scan_code,
			);


			if (!$user) {
				Log::warning('scan.show: user not found, aborting', [
					'scan_code' => $scan_code,
					'user_id'   => $id,
				]);

				return response([
					'success' => false,
					'message' => 'Invalid token',
					'errors' => ['token' => ['Invalid token']]
				], 400);
			}


			if (!$code) {

				Log::warning('scan.show: code not found for code_data, raising alert', [
					'scan_code' => $scan_code,
					'user_id'   => $user->id,
				]);

				$alert['scanned_by'] = $user->id;
				$alert['alert_message'] = "Fake product detected with below code data - '" . $scan_code . "'";

				if ($location) {
					$alert['location'] = json_encode($location);
				}

				$add_alert = addAlerts($alert);

				Log::info('scan.show: alert added for missing code', [
					'scan_code' => $scan_code,
					'alert_result' => $add_alert,
				]);

				return response([
					'success' => false,
					'message' => 'Product details not found. It may be suspicious product.',
					'errors' => ['product' => ['Product details not found. It may be suspicious product.']]
				], 400);
			}

			if ($code->batch_id == '') {

				Log::warning('scan.show: code has no batch_id (deactivated product), raising alert', [
					'scan_code' => $scan_code,
					'code_id'   => $code->id,
					'user_id'   => $user->id,
				]);

				$alert['scanned_by'] = $user->id;
				$alert['code_id'] = $code->id;
				$alert['alert_message'] = "Deactivated product scanned";

				if ($location) {
					$alert['location'] = json_encode($location);
				}

				$add_alert = addAlerts($alert);

				Log::info('scan.show: alert added for deactivated product', [
					'scan_code' => $scan_code,
					'alert_result' => $add_alert,
				]);

				return response([
					'success' => false,
					'message' => 'Product details not found. It may be suspicious product.',
					'errors' => ['product' => ['Product details not found. It may be suspicious product.']]
				], 400);
			}

			$response = [];

			Log::info('scan.show: proceeding to build product response', [
				'scan_code'    => $scan_code,
				'code_id'      => $code->id,
				'has_product'  => (bool) $code->getProduct,
			]);

			if ($code->getProduct) {
				$response['id'] = $code->getProduct->id ?? '';
				$response['name'] = $code->getProduct->name ?? '';
				$response['logo'] = $code->getProduct->logo ?? '';
				$response['brand'] = $code->getProduct->brand ?? '';
				$response['description'] = $code->getProduct->description ? $code->getProduct->description : '';
				$response['html_description'] = $code->getProduct->description ? $code->getProduct->description : '';
				$response['price'] = $code->getProduct->price ? ($code->getProduct->currency . ' ' . $code->getProduct->price) : '';

				Log::info('scan.show: base product fields populated', [
					'scan_code'    => $scan_code,
					'product_id'   => $response['id'],
					'product_name' => $response['name'],
				]);

				$duplicate_scan = ScanHistory::where('code_id', $code->id)->where('ip_address', '!=', $request->ip())->first();

				Log::info('scan.show: duplicate scan (different IP) check', [
					'code_id'         => $code->id,
					'current_ip'      => $request->ip(),
					'duplicate_found' => (bool) $duplicate_scan,
				]);

				if ($duplicate_scan) {
					$alert['product_id'] = $code->getBatch ? $code->getProduct->id : '';
					$alert['code_id'] = $code->id;
					$alert['batch_id'] = $code->getBatch ? $code->getBatch->id : '';
					$alert['scanned_by'] = $user->id;
					$alert['alert_message'] = "Scanned from Different IP";

					if ($location) {
						$alert['location'] = json_encode($location);
					}

					$add_alert = addAlerts($alert);

					Log::info('scan.show: alert added for different IP scan', [
						'scan_code' => $scan_code,
						'alert_result' => $add_alert,
					]);
				}

				$applied_offer = null;
				$find_with_same_ip = ScanHistory::where('code_id', $code->id)->where('ip_address', $request->ip())->where('scan_count', '1')->first();

				$cashback_offers = Cashback::where('status', 'Active')->where('from', '<=', date('Y-m-d'))->where('to', '>=', date('Y-m-d'))->get();

				Log::info('scan.show: evaluating cashback offers', [
					'code_id'              => $code->id,
					'active_offers_count'  => $cashback_offers->count(),
					'find_with_same_ip'    => (bool) $find_with_same_ip,
				]);

				foreach ($cashback_offers as $key => $cashback_offer) {

					$codes_in_cashback = array();
					$codes = json_decode($cashback_offer->codes, true);

					if (!empty($codes)) {
						foreach ($codes as $key_code) {
							$from = Code::where('user_id', $code->user_id)->where('code_data', $key_code['from'])->first();
							$to = Code::where('user_id', $code->user_id)->where('code_data', $key_code['to'])->first();

							if ($from && $to && $to->id > $from->id) {
								$between_codes = Code::where('user_id', $code->user_id)->where('id', '>=', $from->id)->where('id', '<=', $to->id)->get();

								if (!$between_codes->isEmpty()) {
									foreach ($between_codes as $between_code) {
										array_push($codes_in_cashback, $between_code->id);
									}
								}
							}
						}
					}

					if (in_array($code->id, $codes_in_cashback)) {
						$applied_offer = $cashback_offer;

						Log::info('scan.show: cashback offer matched', [
							'code_id'   => $code->id,
							'offer_id'  => $cashback_offer->id,
							'offer_title' => $cashback_offer->title ?? null,
						]);
					}
				}

				$scan_history = new ScanHistory;

				// dd($applied_offer);

				if ($applied_offer) {
					$response['applied_offer'] = ['title' => $applied_offer->title, 'description' => $applied_offer->description];
					$scan_history->cashback_id = $applied_offer->id;
				}


				$scan_history->phone_code = $user->phone_code;
				$scan_history->phone = $user->phone;
				$scan_history->code_id = $code->id;
				$scan_history->scanned_by = $user->id;
				$scan_history->scan_count = ($user->type != '0' || $find_with_same_ip || $applied_offer) ? '0' : '1';

				if ($location) {
					$scan_history->location = json_encode($location);
				}

				if ($request->ip()) {
					$scan_history->ip_address = $request->ip();
				}

				$response['scan_count'] = ScanHistory::where('code_id', $code->id)->where('scan_count', '1')->count();
				$scan_history->genuine = '1';

				Log::info('scan.show: scan_history prepared (pre-save)', [
					'code_id'         => $code->id,
					'user_id'         => $user->id,
					'computed_scan_count_flag' => $scan_history->scan_count,
					'response_scan_count'      => $response['scan_count'],
				]);

				if ($response['scan_count'] >= 1) {
					$second_last = ScanHistory::orderBy('created_at', 'DESC')->first();
					$response['last_scanned'] = date('M d, Y H:i:s', strtotime($second_last->created_at));
				} else {
					$response['last_scanned'] = '-';
				}

				$other_than_me_scans = ScanHistory::where('code_id', $code->id)->where('scan_count', '1')->where('scanned_by', '!=', $user->id)->exists();

				$more_than_ip =  ScanHistory::where('code_id', $code->id)->where('ip_address', '!=', '')->where('scan_count', '1')->distinct('ip_address')->count();

				Log::info('scan.show: genuineness checks', [
					'code_id'              => $code->id,
					'other_than_me_scans'  => $other_than_me_scans,
					'more_than_ip_count'   => $more_than_ip,
					'code_status'          => $code->status,
					'applied_offer'        => (bool) $applied_offer,
				]);

				if (($other_than_me_scans || $more_than_ip > 15 || $code->status == '0') && !$applied_offer) {
					$scan_history->genuine = '0';

					Log::info('scan.show: marking scan_history as NOT genuine', [
						'code_id' => $code->id,
					]);
				}

				try {
					$scan_history->save();
					Log::info('scan.show: scan_history saved successfully', [
						'scan_history_id' => $scan_history->id,
						'code_id'         => $code->id,
					]);
				} catch (\Throwable $e) {
					Log::error('scan.show: scan_history save failed', [
						'code_id' => $code->id,
						'message' => $e->getMessage(),
						'file'    => $e->getFile(),
						'line'    => $e->getLine(),
					]);
				}

				$response['batch'] = $code->getBatch ? $code->getBatch->id : '';
				$response['batch_code'] = $code->getBatch ? $code->getBatch->code : '';
				$response['code_data'] = $code->code_data ?? '';
				$response['code_data'] = $code->code_data ?? '';
				$response['manufacturer'] = $code->getUser->getCompany->name ?? '';
				$response['manufactured_on'] = $code->getBatch ? date('M d, Y H:i:s', strtotime($code->getBatch->mfg_date)) : '';
				$response['expiry_on'] = $code->getBatch ? date('M d, Y H:i:s', strtotime($code->getBatch->exp_date)) : '';
				$response['image'] = $code->getProduct ? ($code->getProduct->image_url ? asset($code->getProduct->image_url) : '') : '';
				$response['label_image'] = $code->getProduct ? ($code->getProduct->label_image_url ? asset($code->getProduct->label_image_url) : '') : '';
				$response['media'] = $code->getProduct ? ($code->getProduct->media ? asset($code->getProduct->media) : '') : '';
				$response['genuine_product'] = $scan_history->genuine == '1' ? true : false;
				$response['scan_id'] = $scan_history->id;

				Log::info('scan.show: full product response assembled', [
					'code_id'  => $code->id,
					'response' => $response,
				]);
			} else {
				Log::warning('scan.show: code has no related product (getProduct is null)', [
					'code_id' => $code->id,
				]);
			}

			if (!$code->getBatch) {
				Log::warning('scan.show: code has no related batch, expiry/mfg date checks below may fail', [
					'code_id' => $code->id,
				]);
			}

			if (strtotime('now') > strtotime($code->getBatch->exp_date)) {

				Log::warning('scan.show: expired product detected, raising alert', [
					'code_id' => $code->id,
					'exp_date' => $code->getBatch->exp_date ?? null,
				]);

				$alert['product_id'] = $code->getBatch ? $code->getProduct->id : '';
				$alert['code_id'] = $code->id;
				$alert['batch_id'] = $code->getBatch ? $code->getBatch->id : '';
				$alert['scanned_by'] = $user->id;
				$alert['alert_message'] = "Expired product found";

				if ($location) {
					$alert['location'] = json_encode($location);
				}

				$add_alert = addAlerts($alert);

				Log::info('scan.show: alert added for expired product', [
					'scan_code' => $scan_code,
					'alert_result' => $add_alert,
				]);
			}

			if (strtotime('now') < strtotime($code->getBatch->mfg_date)) {

				Log::warning('scan.show: manufacturing date mismatch detected, raising alert', [
					'code_id' => $code->id,
					'mfg_date' => $code->getBatch->mfg_date ?? null,
				]);

				$alert['product_id'] = $code->getBatch ? $code->getProduct->id : '';
				$alert['code_id'] = $code->id;
				$alert['batch_id'] = $code->getBatch ? $code->getBatch->id : '';
				$alert['scanned_by'] = $user->id;
				$alert['alert_message'] = "Suspicious Product, Manufactring Date mismatch.";

				if ($location) {
					$alert['location'] = json_encode($location);
				}

				$add_alert = addAlerts($alert);

				Log::info('scan.show: alert added for mfg date mismatch', [
					'scan_code' => $scan_code,
					'alert_result' => $add_alert,
				]);
			}

			if ($code->getUser->active == '0') {

				Log::warning('scan.show: manufacturer is banned, raising alert', [
					'code_id' => $code->id,
					'manufacturer_id' => $code->getUser->id ?? null,
				]);

				$alert['product_id'] = $code->getBatch ? $code->getProduct->id : '';
				$alert['code_id'] = $code->id;
				$alert['batch_id'] = $code->getBatch ? $code->getBatch->id : '';
				$alert['scanned_by'] = $user->id;
				$alert['alert_message'] = "Product from banned manufacturer.";

				if ($location) {
					$alert['location'] = json_encode($location);
				}

				$add_alert = addAlerts($alert);

				Log::info('scan.show: alert added for banned manufacturer', [
					'scan_code' => $scan_code,
					'alert_result' => $add_alert,
				]);
			}

			if ($code->status == '0') {

				Log::warning('scan.show: code status is inactive/fake, raising alert and aborting', [
					'code_id' => $code->id,
				]);

				$alert['scanned_by'] = $user->id;
				$alert['alert_message'] = "Fake product detected";
				$alert['product_id'] = $code->getBatch ? $code->getProduct->id : '';
				$alert['code_id'] = $code->id;
				$alert['batch_id'] = $code->getBatch ? $code->getBatch->id : '';

				if ($location) {
					$alert['location'] = json_encode($location);
				}

				$add_alert = addAlerts($alert);

				Log::info('scan.show: alert added for fake product, returning 400', [
					'scan_code' => $scan_code,
					'alert_result' => $add_alert,
				]);

				return response([
					'success' => false,
					'message' => 'Product details not found. It may be suspicious product.',
					'errors' => ['product' => ['Product details not found. It may be suspicious product.']]
				], 400);
			}

			$journey = null;

			Log::info('scan.show: checking aggregation for supply chain journey', [
				'code_id' => $code->id,
				'has_aggregation' => (bool) $code->getAggregation,
			]);

			if ($code->getAggregation) {
				$aggregation = Aggregation::find($code->getAggregation->id);
				if ($aggregation) {
					$journey = prepareSupplyChainScanHistory($aggregation->unique_id, $aggregation->user_id);

					Log::info('scan.show: journey prepared from aggregation', [
						'code_id'        => $code->id,
						'aggregation_id' => $aggregation->id,
						'journey_empty'  => empty($journey),
					]);
				} else {
					Log::warning('scan.show: aggregation id present but Aggregation::find returned null', [
						'code_id' => $code->id,
						'aggregation_id' => $code->getAggregation->id ?? null,
					]);
				}
			}

			if (!$code->getProduct || !$code->getProduct->getTemplate) {
				Log::error('scan.show: missing product or product template, permissions lookup will likely fail', [
					'code_id'          => $code->id,
					'has_product'      => (bool) $code->getProduct,
					'has_template_rel' => $code->getProduct ? (bool) $code->getProduct->getTemplate : null,
				]);
			}

			$permissions = ProductTemplate::where('id', $code->getProduct->getTemplate->id)->first();

			Log::info('scan.show: permissions/template lookup result', [
				'code_id'         => $code->id,
				'template_id'     => $code->getProduct->getTemplate->id ?? null,
				'permissions_found' => (bool) $permissions,
			]);

			try {
				$renderfile = view('web.scan.table', ['product' => $response, 'journey' => $journey, 'user' => $user, 'permissions' => $permissions]);
				$view = $renderfile->render();

				Log::info('scan.show: view rendered successfully', [
					'code_id' => $code->id,
				]);
			} catch (\Throwable $e) {
				Log::error('scan.show: view rendering failed', [
					'code_id' => $code->id,
					'message' => $e->getMessage(),
					'file'    => $e->getFile(),
					'line'    => $e->getLine(),
				]);

				throw $e;
			}

			Log::info('scan.show: returning success response', [
				'code_id' => $code->id,
				'scan_code' => $scan_code,
			]);

			return response([
				'success' => true,
				'message' => 'Product details fetched successfully',
				'product' => $response,
				'permissions' => $permissions,
				'journey' => $journey,
				'view'    => $view
			], 200);
		}
	}

	public function scanHistory(Request $request)
	{

		$input = $request->all();

		$rules = [
			'token'       =>  'required'
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

			$response = ScanHistory::where('scan_histories.scanned_by', $user->id)->leftJoin('codes', 'codes.id', '=', 'scan_histories.code_id')->leftJoin('products', 'products.id', '=', 'codes.product_id')->orderBy('scan_histories.created_at', 'DESC')->select(['scan_histories.id as scan_id', 'scan_histories.created_at as date', 'products.name as product', 'codes.code_data', 'scan_histories.code_id', 'scan_histories.genuine'])->get();

			if (count($response) > 0) {
				foreach ($response as $key => $scan_code) {
					$scan_code['url'] = url('api/scan-details/' . $scan_code->code_data);
					$scan_code['genuine_product'] = $scan_code->genuine == '1' ? true : false;
				}
			}

			return response([
				'success' => true,
				'message' => 'Scan history fetched successfully',
				'total' => count($response),
				'scans' => $response
			], 200);
		}
	}

	public function scanDetails(Request $request, $scan_code)
	{


		$input = $request->all();

		$rules = [
			'token'       =>  'required',
			'scan_id'     =>  'required'
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


			$code = Code::where('code_data', $scan_code)->first();

			if (!$code) {
				return response([
					'success' => false,
					'message' => 'It may be suspicious product.',
					'errors' => ['product' => ['It may be suspicious product.']]
				], 400);
			}

			$response = [];

			if ($code->getProduct) {
				$response['id'] = $code->getProduct->id ?? '';
				$response['name'] = $code->getProduct->name ?? '';
				$response['brand'] = $code->getProduct->brand ?? '';
				$response['description'] = $code->getProduct->description ? $code->getProduct->description : '';
				$response['price'] = $code->getProduct->price ? ($code->getProduct->currency . ' ' . $code->getProduct->price) : '';

				$response['scan_count'] = ScanHistory::where('code_id', $code->id)->where('scan_count', '1')->count();

				$last_scanned = ScanHistory::orderBy('created_at', 'DESC')->where('scan_count', '1')->first();

				$response['last_scanned'] = date('M d, Y H:i:s', strtotime($last_scanned->created_at));

				$response['genuine_product'] = false;
				$scan = ScanHistory::find($input['scan_id']);
				if ($scan && $scan->genuine == '1') {
					$response['genuine_product'] = true;
				}

				$response['manufacturer'] = $code->getUser->getCompany->name ?? '';
				$response['code_data'] = $code->code_data ?? '';
				$response['code_data'] = $code->code_data ?? '';
				$response['batch'] = $code->getBatch ? $code->getBatch->id : '';
				$response['batch_code'] = $code->getBatch ? $code->getBatch->code : '';
				$response['manufactured_on'] = $code->getBatch ? date('M d, Y H:i:s', strtotime($code->getBatch->mfg_date)) : '';
				$response['expiry_on'] = $code->getBatch ? date('M d, Y H:i:s', strtotime($code->getBatch->exp_date)) : '';
				$response['image'] = $code->getProduct ? ($code->getProduct->image_url ? asset($code->getProduct->image_url) : '') : '';
				$response['label_image'] = $code->getProduct ? ($code->getProduct->label_image_url ? asset($code->getProduct->label_image_url) : '') : '';
				$response['media'] = $code->getProduct ? ($code->getProduct->media ? asset($code->getProduct->media) : '') : '';
			}

			$journey = null;

			if ($code->getAggregation) {
				$aggregation = Aggregation::find($code->getAggregation->id);
				if ($aggregation) {
					$journey = prepareSupplyChainScanHistory($aggregation->unique_id, $aggregation->user_id);
				}
			}

			return response([
				'success' => true,
				'message' => 'Product details fetched successfully',
				'product' => $response,
				'journey' => $journey
			], 200);
		}
	}

	public function redeemPoints(Request $request)
	{
		$input = $request->all();
		$token = $input['token'];
		$id = decrypt($token);
		$user = User::find($id);

		if (!$user) {
			return response([
				'success' => false,
				'message' => 'Invalid session.'
			], 400);
		}

		$this->validate($request, [
			'coupon_code' => 'required|exists:coupon_codes,coupon_code'
		]);

		$scan_history = ScanHistory::find($input['scan_id']);
		$coupon = CouponCode::where('coupon_code', $input['coupon_code'])->first();

		if ($coupon->status == 'Redeemed') {
			return response([
				'success' => false,
				'message' => 'Coupon code is already redeemed.'
			], 400);
		}

		$code = Code::where('id', $scan_history->code_id)->first();
		$reward_scheme = RewardScheme::where('id', $coupon->reward_id)->where('status', 'Active')->first();

		if (!$reward_scheme) {
			return response([
				'success' => false,
				'message' => 'Invalid coupon code.'
			], 400);
		}

		if ($code->id != $coupon->code_id) {
			return response([
				'success' => false,
				'message' => 'Invalid coupon code.'
			], 400);
		}

		$create = new Wallet;
		$create->type = 'credit';
		$create->user_id = $user->id;
		$create->scan_id = $scan_history->id;
		$create->reward_id = $reward_scheme->id;
		$create->points = $reward_scheme->points;
		$create->brand = $code->getProduct->brand ?? NULL;
		$create->status = 'Success';
		$create->save();

		$coupon->status = 'Redeemed';
		$coupon->save();


		return response([
			'success' => true,
			'balance' => getWalletBalance($user->id, $code->getProduct->brand ?? null),
			'message' => 'Coupon code redeemed successfully.'
		], 200);
	}

	public function redeemRewards(Request $request)
	{
		$input = $request->all();
		$token = $input['token'];
		$id = decrypt($token);
		$user = User::find($id);

		if (!$user) {
			return response([
				'success' => false,
				'message' => 'Invalid session.'
			], 400);
		}

		if (getWalletBalance($user->id, $input['brand'] ?? null) <= 0) {
			return response([
				'success' => false,
				'message' => 'You do not have sufficient points to redeem this reward.'
			], 400);
		}

		$this->validate($request, [
			'upi_id' => 'required|min:5|max:100'
		]);

		$reward_scheme = RewardScheme::where('id', $input['scheme_id'])->where('status', 'Active')->first();

		if (!$reward_scheme) {
			return response([
				'success' => false,
				'message' => 'The scheme is not available.'
			], 400);
		}

		$amount = 0;

		$items = json_decode($reward_scheme->items, true);

		foreach ($items as $key => $item) {
			if ($item['points'] == $input['points'] && $item['type'] == 'amount') {
				$amount = $item['item'];
			}
		}

		if (getWalletBalance($user->id, $input['brand'] ?? null) < $input['points']) {
			return response([
				'success' => false,
				'message' => 'You do not have sufficient points to redeem this reward.'
			], 400);
		}

		$create_upi_response = createRazorpayXPayout($input['upi_id'], $amount);

		if ($create_upi_response['success'] === false) {
			return response([
				'success' => false,
				'message' => $create_upi_response['message']
			], 400);
		}

		$debit = new Wallet;
		$debit->type = 'debit';
		$debit->user_id = $user->id;
		$debit->reward_id = $reward_scheme->id;
		$debit->points = $input['points'];
		$debit->amount = $amount;
		$debit->data   = json_encode($input);
		$debit->brand = $input['brand'] ?? NULL;
		$debit->response = json_encode($create_upi_response['body']);
		$debit->status = 'Success';
		$debit->save();

		return response([
			'success' => true,
			'balance' => strval(getWalletBalance($user->id, $input['brand'] ?? null)),
			'message' => 'Reward points redeemed successfully.'
		], 200);
	}

	public function orderProduct(Request $request)
	{
		$input = $request->all();
		$token = $input['token'];
		$id = decrypt($token);
		$user = User::find($id);

		if (!$user) {
			return response([
				'success' => false,
				'message' => 'Invalid session.'
			], 400);
		}

		if (getWalletBalance($user->id, $input['brand'] ?? null) <= 0) {
			return response([
				'success' => false,
				'message' => 'You do not have sufficient points to redeem this reward.'
			], 400);
		}

		$this->validate($request, [
			'name' => 'required',
			'address' => 'required',
			'city' => 'required',
			'state' => 'required',
			'pin_code' => 'required|numeric'
		]);

		$reward_scheme = RewardScheme::where('id', $input['scheme_id'])->where('status', 'Active')->first();

		if (!$reward_scheme) {
			return response([
				'success' => false,
				'message' => 'The scheme is not available.'
			], 400);
		}

		$product = '';

		$items = json_decode($reward_scheme->items, true);

		foreach ($items as $key => $item) {
			if ($item['points'] == $input['points'] && $item['type'] == 'product') {
				$product = $item['item'];
			}
		}

		if (getWalletBalance($user->id, $input['brand'] ?? null) < $input['points']) {
			return response([
				'success' => false,
				'message' => 'You do not have sufficient points to redeem this reward.'
			], 400);
		}

		//create order here

		$order = new RewardOrder;
		$order->customer_id = $user->id;
		$order->reward_id = $reward_scheme->id;
		$order->phone = $user->phone;
		$order->name = $input['name'];
		$order->product = $product;
		$order->address = $input['address'];
		$order->city = $input['city'];
		$order->state = $input['state'];
		$order->pin_code = $input['pin_code'];
		$order->points = $input['points'];
		$order->dispatch_status = 'Pending';

		$history = [];
		$log_item = [
			'message' => 'Order has been placed',
			'date'    => date('M d, Y - h:i a', strtotime('now'))
		];
		array_push($history, $log_item);
		$order->history = json_encode($history);
		$order->save();

		$input['product'] = $product;

		$debit = new Wallet;
		$debit->type = 'debit';
		$debit->user_id = $user->id;
		$debit->reward_id = $reward_scheme->id;
		$debit->points = $input['points'];
		$debit->amount = NULL;
		$debit->data   = json_encode($input);
		$debit->brand = $input['brand'] ?? NULL;
		$debit->response = NULL;
		$debit->status = 'Success';
		$debit->save();

		return response([
			'success' => true,
			'balance' => strval(getWalletBalance($user->id, $input['brand'] ?? null)),
			'message' => 'Order placed successfully.'
		], 200);
	}
}
