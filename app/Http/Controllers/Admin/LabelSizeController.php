<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LabelSizeCreateRequest;
use App\Http\Requests\Admin\LabelSizeUpdateRequest;
use App\Models\LabelSize;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LabelSizeController extends Controller
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

            $response       = LabelSize::getLabelSizeModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value, Auth::id());

            if(!$response){
                $label_sizes      = [];
                $last_page        = 0;
                $total            = 0;
            }
            else{
                $label_sizes= $response['response'];
                $last_page  = $response['last_page'];
                $total      = $response['total'];
            }

            $label_sizeData = array();
            $i = 1;

            foreach ($label_sizes as $label_size) {
                $u['width']          = $label_size->width??'-';
                $u['height']         = $label_size->height??'-';
                $u['status']         = $label_size->status??'-';
                $u['created_at']     = date('M d, Y',strtotime($label_size->created_at))??'-';
                
                $actions            = view('admin.label_sizes.actions',['id' => $label_size->id]);
                $u['actions']       = $actions->render(); 

                $label_sizeData[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                "last_page"         =>  $last_page,
                "data"              =>  $label_sizeData,
                "total"             =>  $total
            ];
            
            return $return;
        }
        return view('admin.label_sizes.index');
    }

    public function create()
    {
        return view('admin.label_sizes.create')->with('page_name','admin-label_sizes'); 
    }

    public function store(LabelSizeCreateRequest $request)
    {
        try{
            $input   = $request->all();

            $find = LabelSize::where('width',$input['width'])->where('height',$input['height'])->first();

            if ($find) {
                return response(['message'=>'This size combination is already taken.'], 400);
            }
            
            $label_size = new LabelSize;

            $label_size->width  = $input['width'];
            $label_size->height = $input['height'];
            $label_size->status = $input['status'];

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
                $name = $timestamp . '-' . uniqid() . '-' . str_replace([' ', ':'], '-', $file->getClientOriginalName());

                Storage::putFileAs('public/label_sizes', $file, $name);
                $path = Storage::url('label_sizes/'.$name);

                $label_size->image_url = $path;

            }

            $label_size->save();

            return response(['message'=>'Label size created successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function edit($id)
    {   
        $id = decrypt($id);

        $label_size = LabelSize::find($id);
        return view('admin.label_sizes.edit')->with('label_size',$label_size)->with('page_name', 'admin-label_sizes');
    }

    public function update(LabelSizeUpdateRequest $request ,$id)
    {
        try{
            $id = decrypt($id);

            $input   = $request->all();
            $label_size = LabelSize::find($id);

            $find = LabelSize::where('id','!=',$id)->where('width',$input['width'])->where('height',$input['height'])->first();

            if ($find) {
                return response(['message'=>'This size combination is already taken.'], 400);
            }

            $label_size->width  = $input['width'];
            $label_size->height = $input['height'];
            $label_size->status = $input['status'];

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
                $name = $timestamp . '-' . uniqid() . '-' . str_replace([' ', ':'], '-', $file->getClientOriginalName());

                Storage::putFileAs('public/label_sizes', $file, $name);
                $path = Storage::url('label_sizes/'.$name);

                $label_size->image_url = $path;

            }

            $label_size->save();

            return response(['message'=>'Label size updated successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function destroy($id)
    {
        try{
            $id = decrypt($id);

            $label_size = LabelSize::find($id);

            // if($label_size->image_url){
            //  File::delete(public_path() .$label_size->image_url);
            // }

            $label_size->delete();

            return response(['message'=>'Label size deleted successfully.'], 200);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }
}
