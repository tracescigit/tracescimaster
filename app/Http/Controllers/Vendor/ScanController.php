<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ScanHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ScanController extends Controller
{
	public function index(Request $request)
	{

		if ($request->ajax()) {
			$limit          = $request->input('size');
			$page           = $request->input('page');
			$search_field   = $request['filters'] ? $request['filters']['0']['field'] : '';
			$search_type    = $request['filters'] ? $request['filters']['0']['type'] : '';
			$search_value   = $request['filters'] ? $request['filters']['0']['value'] : '';
			$orderby        = $request['sorters'] ? $request['sorters']['0']['field'] : '';
			$order          = $orderby != "" ? $request['sorters']['0']['dir'] : "";

			$response       = ScanHistory::getVendorScanModel($limit, $page, $orderby, $order, $search_field, $search_type, $search_value, Auth::user()->parent_id ?? Auth::id());



			if (!$response) {
				$scans      = [];
				$last_page  = 0;
				$total = 0;
			} else {
				$scans      = $response['response'];
				$last_page     = $response['last_page'];
				$total     = $response['total'];
			}

			$scanData = array();
			$i = 1;

			foreach ($scans as $scan) {

				$u['product_name']          = $scan->getCode->getProduct->name ?? '-';
				$u['code_data']             = $scan->getCode->code_data ?? '-';
				$u['phone']     			= $scan->phone ?? '-';
				$u['ip_address']     		= $scan->ip_address ?? '-';
				$u['created_at']      		= date('M d, Y', strtotime($scan->created_at)) ?? '-';
				$actions           			= view('vendor.scanhistory.actions', ['id' => $scan->id]);
				$u['actions']      			= $actions->render();

				$genuine                    = view('vendor.scanhistory.genuine', ['genuine' => $scan->genuine]);
				$u['genuine']               = $genuine->render();

				$scanData[] = $u;
				$i++;
				unset($u);
			}

			$return = [
				"last_page"		    =>  $last_page,
				"data"              =>  $scanData,
				"total"             =>  $total
			];

			return $return;
		}
		return view('vendor.scanhistory.index');
	}



	public function show($id)
	{
		$id = decrypt($id);
		$scandetail = ScanHistory::find($id);
		$location = null;
		$full_address = null;

		if ($scandetail && !empty($scandetail->location)) {
			$location = is_array($scandetail->location)
				? $scandetail->location
				: json_decode($scandetail->location, true);

			$lat = $location['lat'] ?? null;
			$lng = $location['lng'] ?? $location['long'] ?? null;

			if (
				is_array($location) && is_numeric($lat) && is_numeric($lng)
				&& (empty($location['city']) || empty($location['region']) || empty($location['country']))
			) {
				$key = 'geo_' . md5(round($lat, 5) . ',' . round($lng, 5));
				$geo = Cache::get($key);

				if (!$geo) {
					try {
						// OpenStreetMap Nominatim: free, no key, commercial use allowed (max 1 req/s, cache results)
						$res = Http::timeout(10)
							->withHeaders(['User-Agent' => 'TracesciApp/1.0 (wecare@tracesci.in)'])
							->get('https://nominatim.openstreetmap.org/reverse', [
								'format' => 'json',
								'lat' => $lat,
								'long' => $lng,
								'addressdetails' => 1,
								'accept-language' => 'en',
							]);

						$a = $res->successful() ? ($res->json('address') ?? []) : [];

						if ($a) {
							$geo = [
								'full_address' => $res->json('display_name'),
								'city' => $a['city'] ?? $a['town'] ?? $a['municipality'] ?? $a['village']
									?? $a['city_district'] ?? $a['state_district'] ?? $a['county']
									?? $a['suburb'] ?? $a['hamlet'] ?? null,
								'region' => $a['state'] ?? $a['region'] ?? $a['province'] ?? $a['state_district'] ?? null,
								'country' => $a['country'] ?? null,
							];
							Cache::put($key, $geo, now()->addDays(30));
							
						}
					} catch (\Throwable $e) {
						Log::warning('Reverse geocoding failed', ['scan_history_id' => $id, 'error' => $e->getMessage()]);
					}
				}

				if ($geo) {
					$full_address = $geo['full_address'];

					foreach (['city', 'region', 'country'] as $k) {
						if (empty($location[$k])) {
							$location[$k] = $geo[$k];
						}
					}
				}
			}
		}

		return view('vendor.scanhistory.details')
			->with('scandetail', $scandetail)
			->with('location', $location)
			->with('full_address', $full_address)
			->with('page_name', 'vendor-scanhistory');
	}
}
