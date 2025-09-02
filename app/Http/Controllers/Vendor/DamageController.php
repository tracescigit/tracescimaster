<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\CheckStampRequest;
use App\Models\Code;
use App\Models\Damage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class DamageController extends Controller
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

            $response  = Damage::getDamages($limit, $page, $orderby, $order, $search_field , $search_type, $search_value,Auth::user()->parent_id??Auth::id());

            if(!$response){
                $damages      = [];
                $last_page  = 0;
                $total = 0;
            }
            else{
                $damages      = $response['response'];
                $last_page     = $response['last_page'];
                $total     = $response['total'];
            }

            $damageData = array();
            $i = 1;

            foreach ($damages as $damage) {

                $u['lot_id']        = $damage->lot_id??'-';
                $u['total_stamps']  = $damage->total_stamps??'-';
                $u['reason']        = $damage->reason??'-';
                $u['created_at']    = date('M d, Y',strtotime($damage->created_at))??'-';
                $actions            = view('vendor.damages.actions',['id' => $damage->id]);
                $u['actions']       = $actions->render(); 

                $damageData[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                "last_page"         =>  $last_page,
                "data"              =>  $damageData,
                "total"              =>  $total
            ];

            return $return;
        }
        return view('vendor.damages.index');
    }

    public function create()
    {   
        return view('vendor.damages.create')->with('page_name','lost-damage'); 
    }

    public function show($id)
    {   
        $id    = decrypt($id);
        $damage = Damage::find($id);
        
        return view('vendor.damages.details')->with('damage',$damage)->with('page_name','lost-damage');
    }

    public function checkStamps(CheckStampRequest $request){
        $input = $request->all();

        $check = Code::where('user_id',Auth::user()->parent_id??Auth::id())->where('code_data',$input['stamp_sr_no'])->first();

        if(!$check){
            return response([
                'message' => 'Invalid data provided.',
                'errors' => ['stamp_sr_no' => ['Stamp does not belong to you.']]
            ], 400);
        }

        $lots = Damage::where('manufacturer_id',Auth::user()->parent_id??Auth::id())->get();

        $exists = false;


        if (count($lots)>0) {
            foreach ($lots as $key => $lot) {
                $stamps = json_decode($lot->stamps,true);

                if (in_array($input['stamp_sr_no'],$stamps)) {
                    $exists = true;
                }
            }       
        }

        if($exists == true){
            return response([
                'message' => 'Invalid data provided.',
                'errors' => ['stamp_sr_no' => ['Stamp already added in a lot.']]
            ], 400);
        }

        return response([
            'stamp' => $input['stamp_sr_no']
        ], 200);

    }

    public function store(Request $request){
        $input = $request->all();

        $check = Damage::where('manufacturer_id',Auth::user()->parent_id??Auth::id())->where('stamps',json_encode($input['stamps']))->first();

        if ($check) {
            return response([
                'message' => 'A lot is already created with these stamps.'
            ], 400);
        }

        $lot = new Damage;

        $lot->manufacturer_id = Auth::user()->parent_id??Auth::id();
        $lot->stamps  = json_encode($input['stamps']);
        $lot->reason  = $input['reason'];
        $lot->lot_id  = strtotime('now');
        $lot->total_stamps  = count($input['stamps']);

        $lot->save();

        return response([
            'message' => 'New lot created successfully.'
        ], 200);
    }

}
