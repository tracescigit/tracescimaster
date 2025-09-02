<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PlanCreateRequest;
use App\Http\Requests\Admin\PlanUpdateRequest;
use App\Models\Plan;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PlanController extends Controller
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

			$response       = Plan::getPlanModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value, Auth::id());

			if(!$response){
				$plans      = [];
				$last_page  = 0;
				$total = 0;
			}
			else{
				$plans      = $response['response'];
				$last_page  = $response['last_page'];
				$total      = $response['total'];
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
				
				$actions            = view('admin.plans.actions',['id' => $plan->id]);
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
		return view('admin.plans.index');
	}

	public function create()
	{
		return view('admin.plans.create')->with('page_name','admin-plans'); 
	}

	public function store(PlanCreateRequest $request)
	{
		try{
			$input   = $request->all();

			$find_free = Plan::where('price_inr','0')->orWhere('price_usd','0')->first();

			if ($find_free && ($input['price_inr']==0 || $input['price_usd']==0)) {

				$err_input = $input['price_inr']==0?'price_inr':'price_usd';

				return response(['errors'=>[$err_input=>'Only one free plan allowed.']],400);
			}


			
			$plan = new Plan;

			$plan->title = $input['title'];
			$plan->products = $input['allowed_products'];
			$plan->users = $input['allowed_users'];
			$plan->price_inr = $input['price_inr'];
			$plan->price_usd = $input['price_usd'];
			$plan->status = $input['status'];
			$plan->credits = $input['credits'];
			$plan->description = $input['description'];

			// if ($request->hasFile('file')) {
			// 	$file = $request->file('file');
			// 	$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
			// 	$name = $timestamp . '-' . uniqid() . '-' . str_replace([' ', ':'], '-', $file->getClientOriginalName());

			// 	Storage::putFileAs('public/plans', $file, $name);
			// 	$path = Storage::url('plans/'.$name);

			// 	$plan->image_url = $path;

			// }

			$plan->save();

			return response(['message'=>'Plan created successfully.'], 201);

		}catch(Exception $e){
			return response(['message'=>'Something went wrong.'], 503);
		}
	}

	public function edit($id)
	{	
		$id = decrypt($id);

		$plan = Plan::find($id);
		return view('admin.plans.edit')->with('plan',$plan)->with('page_name', 'admin-plans');
	}

	public function update(PlanUpdateRequest $request ,$id)
	{
		try{
			$id = decrypt($id);

			$input   = $request->all();
			$plan = Plan::find($id);

			$plan->title = $input['title'];
			$plan->products = $input['allowed_products'];
			$plan->users = $input['allowed_users'];
			$plan->price_inr = $input['price_inr'];
			$plan->price_usd = $input['price_usd'];
			$plan->status = $input['status'];
			$plan->credits = $input['credits'];
			$plan->description = $input['description'];
			
			$plan->save();

			return response(['message'=>'Plan updated successfully.'], 201);

		}catch(Exception $e){
			return response(['message'=>'Something went wrong.'], 503);
		}
	}

	public function destroy($id)
	{
		try{
			$id = decrypt($id);

			$plan = Plan::find($id);

			// if($plan->image_url){
			// 	File::delete(public_path() .$plan->image_url);
			// }

			$plan->delete();
			
			return response(['message'=>'Plan deleted successfully.'], 200);

		}catch(Exception $e){
			return response(['message'=>'Something went wrong.'], 503);
		}
	}
}
