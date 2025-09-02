<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\BatchCreateRequest;
use App\Http\Requests\Vendor\BatchUpdateRequest;
use App\Models\Batch;
use App\Models\Product;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class BatchController extends Controller
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

            $response       = Batch::getBatchModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value, Auth::id());

            if(!$response){
                $batches      = [];
                $last_page  = 0;
                $total = 0;
            }
            else{
                $batches      = $response['response'];
                $last_page     = $response['last_page'];
                $total     = $response['total'];
            }

            $batchData = array();
            $i = 1;

            foreach ($batches as $batch) {
                $u['name']          = $batch->name??'-';
                $u['code']          = $batch->code??'-';
                $u['status']        = $batch->status??'-';
                $u['active']        = $batch->active??'-';
                $u['created_at']    = date('M d, Y',strtotime($batch->created_at))??'-';

                $actions            = view('vendor.batches.actions',['id' => $batch->id]);
                $u['actions']       = $actions->render(); 

                $batchData[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                "last_page"         =>  $last_page,
                "data"              =>  $batchData,
                "total"             =>  $total
            ];
            
            return $return;
        }
        return view('vendor.batches.index');
    }

    public function create()
    {   
        $products = Product::where('user_id',Auth::user()->parent_id??Auth::id())->where('status','1')->get();
        return view('vendor.batches.create')->with('products',$products); 
    }

    public function store(BatchCreateRequest $request)
    {
        try{
            $input   = $request->all();
            $batch = new Batch;
            $batch->code = $input['code'];
            $batch->product_id = $input['product'];
            $batch->gs1_code = $input['gs1_code'];
            $batch->mfg_date = $input['mfg_date'];
            $batch->exp_date = $input['exp_date'];
            $batch->status = $input['status'];
            $batch->remarks = $input['remarks'];

            $batch->save();

            return response(['message'=>'Batch created successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function edit($id)
    {   
        $id = decrypt($id);
        
        $products = Product::where('user_id',Auth::id())->where('status','1')->get();
        $batch = Batch::find($id);
        return view('vendor.batches.edit')->with('batch',$batch)->with('page_name', 'vendor-batches')->with('products',$products);
    }

    public function update(BatchUpdateRequest $request ,$id)
    {
        try{
            $id = decrypt($id);

            $input   = $request->all();
            $batch = Batch::find($id);
            $batch->code = $input['code'];
            $batch->product_id = $input['product'];
            $batch->gs1_code = $input['gs1_code'];
            $batch->mfg_date = $input['mfg_date'];
            $batch->exp_date = $input['exp_date'];
            $batch->status = $input['status'];
            $batch->remarks = $input['remarks'];
            $batch->save();

            return response(['message'=>'Batch updated successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function destroy($id)
    {
        try{
            $id = decrypt($id);
            $batch = Batch::find($id);
            $batch->delete();
            
            return response(['message'=>'Batch deleted successfully.'], 200);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }
}
