<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ScanHistory;
use Illuminate\Support\Facades\Auth;
use Http;

class ScanController extends Controller
{
	public function index(Request $request)
	{	

		if($request->ajax())
		{	
			$limit          = $request->input('size');
			$page           = $request->input('page');
			$search_field   = $request['filters']?$request['filters']['0']['field']:'';
			$search_type    = $request['filters']?$request['filters']['0']['type']:'';
			$search_value   = $request['filters']?$request['filters']['0']['value']:'';
			$orderby        = $request['sorters']?$request['sorters']['0']['field']:'';			
			$order          = $orderby != "" ? $request['sorters']['0']['dir'] : "";

			$response       = ScanHistory::getVendorScanModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value, Auth::user()->parent_id??Auth::id());



			if(!$response){
				$scans      = [];
				$last_page  = 0;
				$total = 0;
			}
			else{
				$scans      = $response['response'];
				$last_page     = $response['last_page'];
				$total     = $response['total'];
			}

			$scanData = array();
			$i = 1;

			foreach ($scans as $scan) {

				$u['product_name']          = $scan->getCode->getProduct->name??'-';
				$u['code_data']             = $scan->getCode->code_data??'-';
				$u['phone']     			= $scan->phone??'-';
				$u['ip_address']     		= $scan->ip_address??'-';
				$u['created_at']      		= date('M d, Y',strtotime($scan->created_at))??'-';
				$actions           			= view('vendor.scanhistory.actions',['id' => $scan->id]);
				$u['actions']      			= $actions->render(); 

				$genuine                    = view('vendor.scanhistory.genuine',['genuine' => $scan->genuine]);
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

		$full_address = null;

		if ($scandetail->location && $scandetail->location!='') {

			$location = json_decode($scandetail->location,true);

			if(isset($location['lat']) && isset($location['long'])){
				$response = Http::get('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$location['lat'].','.$location['long'].'&key=AIzaSyDkYcFk5rZMvW2Sf0JnCZm9YGvG-Zwgb2U');

				if($response->body())
				{
					$body= json_decode($response->body(),true);

					if ($body['results'] && $body['results'][0] && $body['results'][0]['formatted_address']) {
						$full_address = $body['results'][0]['formatted_address'];
					}
				}
			}
		}
		
		return view('vendor.scanhistory.details')->with('scandetail',$scandetail)->with('full_address',$full_address)->with('page_name','vendor-scanhistory');
	}


}
