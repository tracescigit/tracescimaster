<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\AggregationCreateRequest;
use App\Models\Aggregation;
use App\Models\Code;
use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AggregationController extends Controller
{
    public function index(Request $request)
    {
        $level = $request->level;
        if($request->ajax())
        {   
            $limit          = $request->input('size');
            $page           = $request->input('page');
            $search_field   = $request['filters']?$request['filters']['0']['field']:'';
            $search_type    = $request['filters']?$request['filters']['0']['type']:'';
            $search_value   = $request['filters']?$request['filters']['0']['value']:'';
            $orderby        = $request['sorters']?$request['sorters']['0']['field']:'';         
            $order          = $orderby != "" ? $request['sorters']['0']['dir'] : "";

            $response       = Aggregation::getAggregationModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value, Auth::user()->parent_id??Auth::id(),$level);

            if(!$response){
                $aggregations      = [];
                $last_page  = 0;
                $total = 0;
            }
            else{
                $aggregations  = $response['response'];
                $last_page     = $response['last_page'];
                $total         = $response['total'];
            }

            $aggregationData = array();
            $i = 1;

            foreach ($aggregations as $aggregation) {
                $u['id']            = $aggregation->id??'-';
                $u['unique_id']     = $aggregation->unique_id??'-';
                $u['quantity']      = strtolower($aggregation->level)=='primary'?count($aggregation->getCodes):count($aggregation->getChildren);
                $u['created_at']    = date('M d, Y',strtotime($aggregation->created_at))??'-';

                $actions            = view('vendor.aggregations.actions',['id' => $aggregation->id,'level' => $level]);
                $u['actions']       = $actions->render(); 

                $aggregationData[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                "last_page"         =>  $last_page,
                "data"              =>  $aggregationData,
                "total"             =>  $total
            ];
            
            return $return;
        }

        if($level=='All'){
            $aggregations = Aggregation::where('parent_id',NULL)->where('user_id',Auth::user()->parent_id??Auth::id())->orderby('created_at','DESC')->get();
            return view('vendor.aggregations.all')->with('aggregations',$aggregations);
        }else{
            return view('vendor.aggregations.index');
        }
    }

    public function store(AggregationCreateRequest $request)
    {
        $input   = $request->all();
        switch (strtolower($input['level'])) {
            case 'primary':
            return $this->primary($input);
            break;

            case 'secondary':
            return $this->secondary($input);
            break;

            case 'tertiary':
            return $this->tertiary($input);
            break;

            case 'pallette':
            return $this->pallette($input);
            break;
            
            default:
            return $this->primary($input);
            break;
        }
    }

    public function primary($input)
    {
        try{

            $check_from_serial = Code::where('code_data',$input['from_serial_no'])->where('product_id','>',0)->where('user_id',Auth::user()->parent_id??Auth::id())->first();

            if (!$check_from_serial) {
                return response(['errors'=>['from_serial_no'=>'This serial number does not exist or product is not asssigned.']],404);
            }

            $check_to_serial = Code::where('code_data',$input['to_serial_no'])->where('product_id','>',0)->where('user_id',Auth::user()->parent_id??Auth::id())->first();

            if (!$check_to_serial) {
                return response(['errors'=>['to_serial_no'=>'This serial number does not exist or product is not asssigned.']],404);
            }

            $available_quantity = Code::where('id','>=',$check_from_serial->id)->where('product_id','>',0)->where('id','<=',$check_to_serial->id)->where('aggregation_id',NULL)->where('user_id',Auth::user()->parent_id??Auth::id())->count();

            if($available_quantity<=0){
                return response(['errors'=>['quantity'=>'Not enough QR codes available.']],404);
            }

            if(fmod($available_quantity,$input['quantity'])==0){
                $loop_size = $available_quantity/$input['quantity'];
            }else{
                if($available_quantity<$input['quantity']){
                    $loop_size = 1;
                }else{
                    $loop_size = intval($available_quantity/$input['quantity']) + 1;
                }
            }

            $primary_size = $this->getAggregationSize('primary'); 

            $last_serial_number = $check_from_serial->id;
            for ($i=0; $i < $loop_size; $i++) {
                $aggregation = new Aggregation;
                $aggregation->user_id = Auth::user()->parent_id??Auth::id();
                $aggregation->level = $input['level'];
                $aggregation->created_at = Carbon::now();
                $aggregation->updated_at = Carbon::now();
                $primary_size += 1;
                $aggregation->unique_id = 'P'.(99+$primary_size).date('Y');  
                $aggregation->save();

                $update_codes = Code::where('id','>=',$last_serial_number)->where('id','<=',$check_to_serial->id)->where('product_id','>',0)->where('aggregation_id',NULL)->where('user_id',Auth::user()->parent_id??Auth::id())->limit($input['quantity'])->update(['aggregation_id'=>$aggregation->id]);
                $latest_created = Code::orderBy('created_at','DESC')->where('aggregation_id',$aggregation->id)->first();
                $last_serial_number = $latest_created->id;  
            }

            return response(['message'=>'Aggregation created successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function secondary($input)
    {
        try{

            $check_from_serial = Aggregation::where('unique_id',$input['from_serial_no'])->where('level','primary')->where('user_id',Auth::user()->parent_id??Auth::id())->first();

            if (!$check_from_serial) {
                return response(['errors'=>['from_serial_no'=>'This serial number does not exist.']],404);
            }

            $check_to_serial = Aggregation::where('unique_id',$input['to_serial_no'])->where('level','primary')->where('user_id',Auth::user()->parent_id??Auth::id())->first();

            if (!$check_to_serial) {
                return response(['errors'=>['to_serial_no'=>'This serial number does not exist.']],404);
            }

            $available_quantity = Aggregation::where('id','>=',$check_from_serial->id)->where('id','<=',$check_to_serial->id)->where('level','primary')->where('parent_id',NULL)->where('user_id',Auth::user()->parent_id??Auth::id())->count();

            if($available_quantity<=0){
                return response(['errors'=>['quantity'=>'Not enough aggregations available.']],404);
            }

            if(fmod($available_quantity,$input['quantity'])==0){
                $loop_size = $available_quantity/$input['quantity'];
            }else{
                if($available_quantity<$input['quantity']){
                    $loop_size = 1;
                }else{
                    $loop_size = intval($available_quantity/$input['quantity']) + 1;
                }
            }

            $secondary_size = $this->getAggregationSize('secondary'); 

            $last_serial_number = $check_from_serial->id;
            for ($i=0; $i < $loop_size; $i++) {
                $aggregation = new Aggregation;
                $aggregation->user_id = Auth::user()->parent_id??Auth::id();
                $aggregation->level = $input['level'];
                $aggregation->created_at = Carbon::now();
                $aggregation->updated_at = Carbon::now();
                $secondary_size += 1;
                $aggregation->unique_id = 'S'.(99+$secondary_size).date('Y');  
                $aggregation->save();
                $update_levels = Aggregation::where('id','>=',$last_serial_number)->where('id','<=',$check_to_serial->id)->where('level','primary')->where('parent_id',NULL)->where('user_id',Auth::user()->parent_id??Auth::id())->limit($input['quantity'])->update(['parent_id'=>$aggregation->id]);
                $latest_created = Aggregation::orderBy('created_at','DESC')->where('parent_id',$aggregation->id)->first();
                $last_serial_number = $latest_created->id;  
            }

            return response(['message'=>'Aggregation created successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function tertiary($input)
    {
        try{

            $check_from_serial = Aggregation::where('unique_id',$input['from_serial_no'])->where('level','secondary')->where('user_id',Auth::user()->parent_id??Auth::id())->first();

            if (!$check_from_serial) {
                return response(['errors'=>['from_serial_no'=>'This serial number does not exist.']],404);
            }

            $check_to_serial = Aggregation::where('unique_id',$input['to_serial_no'])->where('level','secondary')->where('user_id',Auth::user()->parent_id??Auth::id())->first();

            if (!$check_to_serial) {
                return response(['errors'=>['to_serial_no'=>'This serial number does not exist.']],404);
            }

            $available_quantity = Aggregation::where('id','>=',$check_from_serial->id)->where('id','<=',$check_to_serial->id)->where('level','secondary')->where('parent_id',NULL)->where('user_id',Auth::user()->parent_id??Auth::id())->count();

            if($available_quantity<=0){
                return response(['errors'=>['quantity'=>'Not enough aggregations available.']],404);
            }

            if(fmod($available_quantity,$input['quantity'])==0){
                $loop_size = $available_quantity/$input['quantity'];
            }else{
                if($available_quantity<$input['quantity']){
                    $loop_size = 1;
                }else{
                    $loop_size = intval($available_quantity/$input['quantity']) + 1;
                }
            }

            $tertiary_size = $this->getAggregationSize('tertiary'); 

            $last_serial_number = $check_from_serial->id;
            for ($i=0; $i < $loop_size; $i++) {
                $aggregation = new Aggregation;
                $aggregation->user_id = Auth::user()->parent_id??Auth::id();
                $aggregation->level = $input['level'];
                $aggregation->created_at = Carbon::now();
                $aggregation->updated_at = Carbon::now();
                $tertiary_size += 1;
                $aggregation->unique_id = 'T'.(99+$tertiary_size).date('Y');  
                $aggregation->save();
                $update_levels = Aggregation::where('id','>=',$last_serial_number)->where('id','<=',$check_to_serial->id)->where('level','secondary')->where('parent_id',NULL)->where('user_id',Auth::user()->parent_id??Auth::id())->limit($input['quantity'])->update(['parent_id'=>$aggregation->id]);
                $latest_created = Aggregation::orderBy('created_at','DESC')->where('parent_id',$aggregation->id)->first();
                $last_serial_number = $latest_created->id;  
            }

            return response(['message'=>'Aggregation created successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function pallette($input)
    {
        try{

            $check_from_serial = Aggregation::where('unique_id',$input['from_serial_no'])->where('level','!=','pallette')->where('user_id',Auth::user()->parent_id??Auth::id())->first();

            if (!$check_from_serial) {
                return response(['errors'=>['from_serial_no'=>'This serial number does not exist.']],404);
            }

            $check_to_serial = Aggregation::where('unique_id',$input['to_serial_no'])->where('level','!=','pallette')->where('user_id',Auth::user()->parent_id??Auth::id())->first();

            if (!$check_to_serial) {
                return response(['errors'=>['to_serial_no'=>'This serial number does not exist.']],404);
            }

            $available_quantity = Aggregation::where('id','>=',$check_from_serial->id)->where('level','!=','pallette')->where('id','<=',$check_to_serial->id)->where('parent_id',NULL)->where('user_id',Auth::user()->parent_id??Auth::id())->count();

            if($available_quantity<=0){
                return response(['errors'=>['quantity'=>'Not enough aggregations available.']],404);
            }

            if(fmod($available_quantity,$input['quantity'])==0){
                $loop_size = $available_quantity/$input['quantity'];
            }else{
                if($available_quantity<$input['quantity']){
                    $loop_size = 1;
                }else{
                    $loop_size = intval($available_quantity/$input['quantity']) + 1;
                }
            }

            $pallette_size = $this->getAggregationSize('pallette'); 

            $last_serial_number = $check_from_serial->id;
            for ($i=0; $i < $loop_size; $i++) {
                $aggregation = new Aggregation;
                $aggregation->user_id = Auth::user()->parent_id??Auth::id();
                $aggregation->level = $input['level'];
                $aggregation->created_at = Carbon::now();
                $aggregation->updated_at = Carbon::now();
                $pallette_size += 1;
                $aggregation->unique_id = 'PT'.(99+$pallette_size).date('Y');  
                $aggregation->save();
                $update_levels = Aggregation::where('id','>=',$last_serial_number)->where('id','<=',$check_to_serial->id)->where('level','!=','pallette')->where('parent_id',NULL)->where('user_id',Auth::user()->parent_id??Auth::id())->limit($input['quantity'])->update(['parent_id'=>$aggregation->id]);
                $latest_created = Aggregation::orderBy('created_at','DESC')->where('parent_id',$aggregation->id)->first();
                $last_serial_number = $latest_created->id;  
            }

            return response(['message'=>'Aggregation created successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $aggregation = Aggregation::find($id);
        return view('vendor.aggregations.edit')->with('aggregation',$aggregation)->with('page_name', 'vendor-aggregations');
    }

    public function show($id)
    {
        $id= decrypt($id);
        $aggregation = Aggregation::find($id);
        $view = view('vendor.aggregations.view',['aggregation'=>$aggregation]);
        return $view->render();
    }

    public function codeData($id)
    {
        $id= decrypt($id);
        $code = Code::find($id);
        $view = view('vendor.aggregations.code',['code'=>$code]);
        return $view->render();
    }

    public function getAggregationSize($level=null){

        return Aggregation::where('level',$level)->where('user_id',Auth::user()->parent_id??Auth::id())->count();

    }


}
