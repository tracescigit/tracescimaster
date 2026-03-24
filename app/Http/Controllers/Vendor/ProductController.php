<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\ProductCreateRequest;
use App\Http\Requests\Vendor\ProductUpdateRequest;
use App\Models\Product;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;

class ProductController extends Controller
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

			$response       = Product::getProductModel($limit, $page, $orderby, $order, $search_field, $search_type, $search_value, Auth::user()->parent_id ?? Auth::id());

			if (!$response) {
				$products      = [];
				$last_page  = 0;
				$total = 0;
			} else {
				$products      = $response['response'];
				$last_page     = $response['last_page'];
				$total     = $response['total'];
			}

			$productData = array();
			$i = 1;

			foreach ($products as $product) {

				$u['product_name']  = $product->name ?? '-';
				$u['price']         = $product->currency . ' ' . number_format((float)$product->price, 2, '.', '') ?? '-';
				$u['status']        = $product->status ?? '-';
				$u['active']        = $product->active ?? '-';
				$u['created_at']    = date('M d, Y', strtotime($product->created_at)) ?? '-';

				$actions            = view('vendor.products.actions', ['id' => $product->id]);
				$u['actions']       = $actions->render();

				$productData[] = $u;
				$i++;
				unset($u);
			}

			$return = [
				"last_page"		    =>  $last_page,
				"data"              =>  $productData,
				"total"             =>  $total
			];

			return $return;
		}
		return view('vendor.products.index');
	}

	public function create()
	{
		return view('vendor.products.create');
	}

	public function store(ProductCreateRequest $request)
	{
		try {
			$input   = $request->all();

			$products_count = getTotalProducts(Auth::user()->parent_id ?? Auth::id());
			$plan           = getSubscriptionPlan(Auth::user()->parent_id ?? Auth::id());

			if (!$plan || ($plan->products <= $products_count)) {
				return response(['message' => 'You have reached maximum product creation limit.'], 503);
			}

			$product = new Product;

			$product->name = $input['name'];
			$product->slug = Str::slug($input['name']);
			$product->brand = $input['brand'];
			$product->price = $input['price'];
			$product->currency = $input['currency'];
			$product->status = $input['status'];
			$product->auth_required = $input['auth_required'];
			$product->pin_required = $input['pin_required'];
			$product->description = $input['description'];
			$product->user_id = Auth::user()->parent_id ?? Auth::id();

			if ($request->hasFile('file')) {
				$file = $request->file('file');
				$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
				$name = $timestamp . '-' . uniqid() . '-' . str_replace([' ', ':'], '-', $file->getClientOriginalName());

				Storage::putFileAs('public/products', $file, $name);
				$path = Storage::url('products/' . $name);

				$product->image_url = $path;
			}

			if ($request->hasFile('product_label')) {
				$file = $request->file('product_label');
				$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
				$name = $timestamp . '-' . uniqid() . '-' . str_replace([' ', ':'], '-', $file->getClientOriginalName());

				Storage::putFileAs('public/products', $file, $name);
				$path = Storage::url('products/' . $name);

				$product->label_image_url = $path;
			}

			if ($request->hasFile('media')) {
				$file = $request->file('media');
				$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
				$name = $timestamp . '-' . uniqid() . '-' . str_replace([' ', ':'], '-', $file->getClientOriginalName());

				Storage::putFileAs('public/products', $file, $name);
				$path = Storage::url('products/' . $name);

				$product->media = $path;
			}

			$product->save();
			$product->product_hashed_code = Hashids::encode($product->id);
			$product->save();
			return response(['message' => 'Product created successfully.'], 201);
		} catch (Exception $e) {
			return response(['message' => 'Something went wrong.'], 503);
		}
	}

	public function edit($id)
	{
		$id = decrypt($id);

		$product = Product::find($id);
		return view('vendor.products.edit')->with('product', $product)->with('page_name', 'vendor-products');
	}

	public function update(ProductUpdateRequest $request, $id)
	{
		try {
			$id = decrypt($id);
			$input   = $request->all();
			$product = Product::find($id);

			$product->name = $input['name'];
			$product->slug = Str::slug($input['name']);
			$product->brand = $input['brand'];
			$product->currency = $input['currency'];
			$product->price = $input['price'];
			$product->status = $input['status'];
			$product->auth_required = $input['auth_required'];
			$product->pin_required = $input['pin_required'];
			$product->description = $input['description'];
			$product->user_id = Auth::user()->parent_id ?? Auth::id();

			if ($request->hasFile('file')) {

				File::delete(public_path() . $product->image_url);

				$file = $request->file('file');
				$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
				$name = $timestamp . '-' . uniqid() . '-' . str_replace([' ', ':'], '-', $file->getClientOriginalName());

				Storage::putFileAs('public/products', $file, $name);
				$path = Storage::url('products/' . $name);

				$product->image_url = $path;
			}

			if ($request->hasFile('product_label')) {

				File::delete(public_path() . $product->label_image_url);

				$file = $request->file('product_label');
				$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
				$name = $timestamp . '-' . uniqid() . '-' . str_replace([' ', ':'], '-', $file->getClientOriginalName());

				Storage::putFileAs('public/products', $file, $name);
				$path = Storage::url('products/' . $name);

				$product->label_image_url = $path;
			}

			if ($request->hasFile('media')) {
				$file = $request->file('media');
				$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
				$name = $timestamp . '-' . uniqid() . '-' . str_replace([' ', ':'], '-', $file->getClientOriginalName());

				Storage::putFileAs('public/products', $file, $name);
				$path = Storage::url('products/' . $name);

				$product->media = $path;
			}

			$product->save();

			return response(['message' => 'Product updated successfully.'], 201);
		} catch (Exception $e) {
			return response(['message' => 'Something went wrong.'], 503);
		}
	}

	public function destroy($id)
	{
		try {
			$id = decrypt($id);

			$product = Product::find($id);

			if ($product->image_url) {
				File::delete(public_path() . $product->image_url);
			}

			$product->delete();

			return response(['message' => 'Product deleted successfully.'], 200);
		} catch (Exception $e) {
			return response(['message' => 'Something went wrong.'], 503);
		}
	}
}
