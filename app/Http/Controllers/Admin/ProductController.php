<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCreateRequest;
use App\Http\Requests\Admin\ProductUpdateRequest;
use App\Models\Product;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
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

			$response       = Product::getProductModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value);
			
			
			if(!$response){
				$products      = [];
				$last_page  = 0;
			}
			else{
				$products      = $response['response'];
				$last_page     = $response['last_page'];
			}

			$productData = array();
			$i = 1;

			foreach ($products as $product) {

				$u['product_name']  = $product->name??'-';
				$u['business_name'] = $product->getUser->getCompany->name??'-';
				$u['user_id'] 		= $product->getUser->name??'-';
				$u['email'] 		= $product->getUser->email??'-';
				$u['price']         = '&#8377; '.number_format((float)$product->price,2,'.','')??'-';
				$u['batch_code']    = $product->batch_code??'-';
				$u['product_status']= $product->status??'-';
				$u['active']        = $product->active??'-';
				$u['date']     		 = date('M d, Y',strtotime($product->created_at));

				$actions            = view('admin.products.actions',['id' => $product->id]);
				$u['actions']       = $actions->render(); 

				$productData[] = $u;
				$i++;
				unset($u);
			}

			$return = [
				"last_page"		    =>  $last_page,
				"data"              =>  $productData
			];
			
			return $return;
		}
		return view('admin.products.index');
	}

	public function create()
	{
		return view('admin.products.create'); 
	}

	public function store(ProductCreateRequest $request)
	{
		try{
			$input   = $request->all();
			$product = new Product;

			$product->name = $input['name'];
			$product->slug = Str::slug($input['name']);
			$product->brand = $input['brand'];
			$product->price = $input['price'];
			$product->status = $input['status'];
			$product->unique_id = $input['unique_id'];
			$product->batch_code = $input['batch_code'];
			$product->gs1_code = $input['gs1_code'];
			$product->mfg_date = $input['mfg_date'];
			$product->exp_date = $input['exp_date'];
			$product->description = $input['description'];
			$product->user_id = Auth::id();

			if ($request->hasFile('file')) {
				$file = $request->file('file');
				$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
				$name = $timestamp . '-' . uniqid() . '-' . str_replace([' ', ':'], '-', $file->getClientOriginalName());

				Storage::putFileAs('public/products', $file, $name);
				$path = Storage::url('products/'.$name);

				$product->image_url = $path;

			}

			$product->save();

			return response(['message'=>'Product created successfully.'], 201);

		}catch(Exception $e){
			return response(['message'=>'Something went wrong.'], 503);
		}
	}

	public function edit($id)
	{	
		$id = decrypt($id);

		$product = Product::find($id);
		return view('admin.products.edit')->with('product',$product)->with('page_name', 'admin-products');
	}

	public function update(ProductUpdateRequest $request ,$id)
	{
		try{
			$id = decrypt($id);

			$input   = $request->all();
			$product = Product::find($id);

			$product->name = $input['name'];
			$product->slug = Str::slug($input['name']);
			$product->brand = $input['brand'];
			$product->price = $input['price'];
			$product->status = $input['status'];
			$product->unique_id = $input['unique_id'];
			$product->batch_code = $input['batch_code'];
			$product->gs1_code = $input['gs1_code'];
			$product->mfg_date = $input['mfg_date'];
			$product->exp_date = $input['exp_date'];
			$product->description = $input['description'];

			if ($request->hasFile('file')) {

				File::delete(public_path() .$product->image_url);

				$file = $request->file('file');
				$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
				$name = $timestamp . '-' . uniqid() . '-' . str_replace([' ', ':'], '-', $file->getClientOriginalName());

				Storage::putFileAs('public/products', $file, $name);
				$path = Storage::url('products/'.$name);

				$product->image_url = $path;

			}

			$product->save();

			return response(['message'=>'Product updated successfully.'], 201);

		}catch(Exception $e){
			return response(['message'=>'Something went wrong.'], 503);
		}
	}

	public function destroy($id)
	{
		try{
			$id = decrypt($id);

			$product = Product::find($id);

			if($product->image_url){
				File::delete(public_path() .$product->image_url);
			}

			$product->delete();
			
			return response(['message'=>'Product deleted successfully.'], 200);

		}catch(Exception $e){
			return response(['message'=>'Something went wrong.'], 503);
		}
	}
}
