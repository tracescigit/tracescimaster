<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MaterialTypeCreateRequest;
use App\Http\Requests\Admin\MaterialTypeUpdateRequest;
use App\Models\MaterialType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MaterialTypeController extends Controller
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

            $response       = MaterialType::getMaterialTypeModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value, Auth::id());

            if(!$response){
                $material_types      = [];
                $last_page        = 0;
                $total            = 0;
            }
            else{
                $material_types= $response['response'];
                $last_page  = $response['last_page'];
                $total      = $response['total'];
            }

            $material_typeData = array();
            $i = 1;

            foreach ($material_types as $material_type) {
                $u['type']          = $material_type->type??'-';
                $u['gsm']           = $material_type->gsm??'-';
                $u['cost']          = $material_type->cost??'-';
                $u['cost_usd']      = $material_type->cost_usd??'-';
                $u['status']        = $material_type->status??'-';
                $u['created_at']    = date('M d, Y',strtotime($material_type->created_at))??'-';
                
                $actions            = view('admin.material_types.actions',['id' => $material_type->id]);
                $u['actions']       = $actions->render(); 

                $material_typeData[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                "last_page"         =>  $last_page,
                "data"              =>  $material_typeData,
                "total"             =>  $total
            ];
            
            return $return;
        }
        return view('admin.material_types.index');
    }

    public function create()
    {
        return view('admin.material_types.create')->with('page_name','admin-material_types'); 
    }

    public function store(MaterialTypeCreateRequest $request)
    {
        try{
            $input   = $request->all();
            
            $material_type = new MaterialType;

            $material_type->type        = $input['type'];
            $material_type->gsm         = $input['gsm'];
            $material_type->cost        = $input['cost'];
            $material_type->cost_usd    = $input['cost_usd'];
            $material_type->status      = $input['status'];

            $material_type->save();

            return response(['message'=>'Material type created successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function edit($id)
    {   
        $id = decrypt($id);

        $material_type = MaterialType::find($id);
        return view('admin.material_types.edit')->with('material_type',$material_type)->with('page_name', 'admin-material_types');
    }

    public function update(MaterialTypeUpdateRequest $request ,$id)
    {
        try{
            $id = decrypt($id);

            $input   = $request->all();
            $material_type = MaterialType::find($id);

            $material_type->type        = $input['type'];
            $material_type->gsm         = $input['gsm'];
            $material_type->cost        = $input['cost'];
            $material_type->cost_usd    = $input['cost_usd'];
            $material_type->status      = $input['status'];

            $material_type->save();

            return response(['message'=>'Material type updated successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function destroy($id)
    {
        try{
            $id = decrypt($id);

            $material_type = MaterialType::find($id);

            // if($material_type->image_url){
            //  File::delete(public_path() .$material_type->image_url);
            // }

            $material_type->delete();

            return response(['message'=>'Material type deleted successfully.'], 200);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }
}
