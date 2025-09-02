<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OfferCreateRequest;
use App\Http\Requests\Admin\OfferUpdateRequest;
use App\Models\Offer;
use App\Models\User;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OfferController extends Controller
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

			$response       = Offer::getOfferModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value);

			if(!$response){
				$offers      = [];
				$last_page  = 0;
				$total = 0;
			}
			else{
				$offers      = $response['response'];
				$last_page     = $response['last_page'];
				$total     = $response['total'];
			}

			$offerData = array();
			$i = 1;

			foreach ($offers as $offer) {

				$u['title']          = $offer->title??'-';
				$u['code']           = $offer->code??'-';
				$u['type']           = $offer->type=='0'?'Price':'Percentage';
				$u['status']         = $offer->status??'-';
				$u['created_at']     = date('M d, Y',strtotime($offer->created_at))??'-';
				
				$actions            = view('admin.offers.actions',['id' => $offer->id]);
				$u['actions']       = $actions->render(); 

				$offerData[] = $u;
				$i++;
				unset($u);
			}

			$return = [
				"last_page"		    =>  $last_page,
				"data"              =>  $offerData,
				"total"             =>  $total
			];
			
			return $return;
		}
		return view('admin.offers.index');
	}

	public function create()
	{	
		$companies = User::where('type','2')->get();
		return view('admin.offers.create')->with('page_name','admin-offers')->with('companies',$companies); 
	}

	public function store(OfferCreateRequest $request)
	{
		try{
			$input   = $request->all();
			$offer = new Offer;

			$offer->title = $input['title'];
			$offer->value = $input['value'];
			$offer->type  = $input['type'];
			$offer->status = $input['status'];
			$offer->user_id = $input['user'];
			$offer->limit = $input['limit'];
			$offer->code = $input['code'];
			$offer->description = $input['description'];

			$offer->save();

			return response(['message'=>'Offer created successfully.'], 201);

		}catch(Exception $e){
			return response(['message'=>'Something went wrong.'], 503);
		}
	}

	public function edit($id)
	{	
		$id = decrypt($id);

		$offer = Offer::find($id);
		$companies = User::where('type','2')->get();
		
		return view('admin.offers.edit')->with('offer',$offer)->with('page_name', 'admin-offers')->with('companies',$companies);
	}

	public function update(OfferUpdateRequest $request ,$id)
	{
		try{
			$id = decrypt($id);

			$input   = $request->all();
			$offer = Offer::find($id);

			$offer->title = $input['title'];
			$offer->value = $input['value'];
			$offer->type  = $input['type'];
			$offer->status = $input['status'];
			$offer->user_id = $input['user'];
			$offer->limit = $input['limit'];
			$offer->code = $input['code'];
			$offer->description = $input['description'];
			
			$offer->save();

			return response(['message'=>'Offer updated successfully.'], 201);

		}catch(Exception $e){
			return response(['message'=>'Something went wrong.'], 503);
		}
	}

	public function destroy($id)
	{
		try{
			$id = decrypt($id);

			$offer = Offer::find($id);
			$offer->delete();
			
			return response(['message'=>'Offer deleted successfully.'], 200);

		}catch(Exception $e){
			return response(['message'=>'Something went wrong.'], 503);
		}
	}
}
