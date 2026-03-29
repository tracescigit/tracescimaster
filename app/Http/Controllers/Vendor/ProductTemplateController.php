<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductTemplateController extends Controller
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

            $response       = ProductTemplate::getProductTemplateModel($limit, $page, $orderby, $order, $search_field, $search_type, $search_value, Auth::user()->parent_id ?? Auth::id());

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

                $u['product_name']  = $product->product_name ?? '-';
                $u['created_by']    = $product->user_name ?? '-';
                $u['company_name']  = $product->business_name ?? '-';
                $u['created_at']    = date('M d, Y', strtotime($product->created_at)) ?? '-';
                $actions            = view('vendor.product_template.actions', ['id' => $product->id]);
                $u['actions']       = $actions->render();

                $productData[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                "last_page"         =>  $last_page,
                "data"              =>  $productData,
                "total"             =>  $total
            ];

            return $return;
        }
        return view('vendor.product_template.index');
    }

    public function create()
    {

        $products = Product::where('status', '1')->select('name', 'id')->get();
        return view('vendor.product_template.create')->with('products', $products);
    }

    public function store(Request $request)
    {
        try {
            $input   = $request->all();
            $template = new ProductTemplate;
            $template->product_id = $input['product_id'];
            $template->field_name = json_encode($input['fields']);
            $template->user_id = Auth::user()->id;
            $template->status = 1;
            $template->save();
            return response(['message' => 'Template created successfully.'], 201);
        } catch (Exception $e) {
            return response(['message' => 'Something went wrong.'], 503);
        }
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $template = ProductTemplate::with('getProduct')->find($id);
        $products = Product::where('status', '1')->select('name', 'id')->get();
        return view('vendor.product_template.edit')->with('template', $template)->with('products', $products)->with('page_name', 'vendor-products-template');
    }

    public function update(Request $request, $id)
    {
        try {
            $id = decrypt($id);
            $input   = $request->all();
            dd($input);
            $template = new ProductTemplate;
            $template->product_id = $input['product_id'];
            $template->field_name = json_encode($input['fields']);
            $template->user_id = Auth::user()->id;
            $template->status = 1;
            $template->save();
            return response(['message' => 'Template updated successfully.'], 201);
        } catch (Exception $e) {
            return response(['message' => 'Something went wrong.'], 503);
        }
    }

    // public function destroy($id)
    // {
    //     try {
    //         $id = decrypt($id);

    //         $product = Product::find($id);

    //         if ($product->image_url) {
    //             File::delete(public_path() . $product->image_url);
    //         }

    //         $product->delete();

    //         return response(['message' => 'Product deleted successfully.'], 200);
    //     } catch (Exception $e) {
    //         return response(['message' => 'Something went wrong.'], 503);
    //     }
    // }
}
