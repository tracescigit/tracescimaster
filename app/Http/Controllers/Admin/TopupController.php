<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TopupCreateRequest;
use App\Http\Requests\Admin\TopupUpdateRequest;
use App\Models\Plan;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TopupController extends Controller
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

			$response       = Plan::getTopupModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value, Auth::id());

			if(!$response){
				$plans      = [];
				$last_page  = 0;
				$total = 0;
			}
			else{
				$plans      = $response['response'];
				$last_page     = $response['last_page'];
				$total     = $response['total'];
			}

			$planData = array();
			$i = 1;

			foreach ($plans as $plan) {

				$u['title']          = $plan->title??'-';
				$u['price_inr']      = '&#8377; '.number_format((float)$plan->price_inr,2,'.','')??'-';
				$u['price_usd']      = '$ '.number_format((float)$plan->price_usd,2,'.','')??'-';
				$u['status']         = $plan->status??'-';
				$u['credits']        = $plan->credits??'-';
				$u['created_at']     = date('M d, Y',strtotime($plan->created_at))??'-';
				
				$actions            = view('admin.topups.actions',['id' => $plan->id]);
				$u['actions']       = $actions->render(); 

				$planData[] = $u;
				$i++;
				unset($u);
			}

			$return = [
				"last_page"		    =>  $last_page,
				"data"              =>  $planData,
				"total"             =>  $total
			];
			
			return $return;
		}
		return view('admin.topups.index');
	}

	public function create()
	{
		$plans = Plan::where('parent_id',null)->get();
		return view('admin.topups.create')->with('plans',$plans)->with('page_name','admin-topups'); 
	}

	public function store(TopupCreateRequest $request)
	{
		try{
			$input   = $request->all();
			$plan = new Plan;

			$plan->title = $input['title'];
			$plan->parent_id = $input['parent_plan'];
			$plan->price_inr = $input['price_inr'];
			$plan->price_usd = $input['price_usd'];
			$plan->status = $input['status'];
			$plan->credits = $input['credits'];
			$plan->description = $input['description'];

			$plan->save();

			return response(['message'=>'Topup created successfully.'], 201);

		}catch(Exception $e){
			return response(['message'=>'Something went wrong.'], 503);
		}
	}

	public function edit($id)
	{	
		$id = decrypt($id);
		$plans = Plan::where('parent_id',null)->get();
		$topup = Plan::find($id);
		return view('admin.topups.edit')->with('topup',$topup)->with('plans',$plans)->with('page_name', 'admin-topups');
	}

	public function update(TopupUpdateRequest $request ,$id)
	{
		try{
			$id = decrypt($id);

			$input   = $request->all();
			$plan = Plan::find($id);

			$plan->title = $input['title'];
			$plan->parent_id = $input['parent_plan'];
			$plan->price_inr = $input['price_inr'];
			$plan->price_usd = $input['price_usd'];
			$plan->status = $input['status'];
			$plan->credits = $input['credits'];
			$plan->description = $input['description'];
			$plan->save();
			return response(['message'=>'Topup updated successfully.'], 201);

		}catch(Exception $e){
			return response(['message'=>'Something went wrong.'], 503);
		}
	}

	public function destroy($id)
	{
		try{
			$id = decrypt($id);
			$plan = Plan::find($id);
			$plan->delete();
			return response(['message'=>'Topup deleted successfully.'], 200);

		}catch(Exception $e){
			return response(['message'=>'Something went wrong.'], 503);
		}
	}
}
