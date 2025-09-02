<?php

namespace App\Http\Controllers\Vendor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alert;
use Illuminate\Support\Facades\Auth;

class AlertController extends Controller
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

            $start_date = $request['filters']?$request['filters']['1']['value']:'';
            $end_date = $request['filters']?$request['filters']['2']['value']:'';

            $response       = Alert::getAlerts($limit, $page, $orderby, $order, $search_field , $search_type, $search_value,Auth::id(),$start_date,$end_date);

            if(!$response){
                $alerts      = [];
                $last_page  = 0;
                $total = 0;
            }
            else{
                $alerts      = $response['response'];
                $last_page     = $response['last_page'];
                $total     = $response['total'];
            }

            $alertData = array();
            $i = 1;

            foreach ($alerts as $alert) {
                $u['id']                    = 'CASE#'.$alert->id;
                $u['product_name']          = $alert->getProduct->name??'-';
                $u['code_data']             = $alert->getCode->code_data??'-';
                $u['alert_message']         = $alert->alert_message??'-';
                $u['manufacturer_assigned_to']    = $alert->vendor_assigned_to!=null?'1':'0'??'-';
                $u['scanned_by']            = $alert->getUser->phone??'-';
                $u['action_taken']          = $alert->manufacturer_assigned_to!=null?'Yes':'No'??'-';
                $u['created_at']            = date('M d, Y',strtotime($alert->created_at))??'-';
                $actions                    = view('vendor.alerts.actions',['id' => $alert->id,'vendor_assigned_to'=>$alert->vendor_assigned_to]);
                $u['actions']               = $actions->render(); 

                $alertData[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                "last_page"         =>  $last_page,
                "data"              =>  $alertData,
                "total"             =>  $total
            ];

            return $return;
        }
        return view('vendor.alerts.index');
    }

    public function show($id)
    {   
        $id    = decrypt($id);
        $alert = Alert::find($id);
        
        return view('vendor.alerts.details')->with('alert',$alert)->with('page_name','vendor-alerts');
    }

    public function assign(Request $request,$id)
    {   
        $input = $request->all();
        
        $alert = Alert::where('id',$id)->first();

        $alert->vendor_assigned_to = $input['assigned_to'];
        $alert->manufacturer_assigned_to = $input['assigned_to'];
        $alert->save();
    }

}
