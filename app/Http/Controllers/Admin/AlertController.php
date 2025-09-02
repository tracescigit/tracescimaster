<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alert;

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

            $response       = Alert::getAlerts($limit, $page, $orderby, $order, $search_field , $search_type, $search_value,null,$start_date,$end_date);


            if(!$response){
                $alerts      = [];
                $last_page  = 0;
                $total = 0;
            }
            else{
                $alerts      = $response['response'];
                $last_page     = $response['last_page'];
                $total      = $response['total'];
            }

            $alertData = array();
            $i = 1;

            foreach ($alerts as $alert) {
                $u['product_name']          = $alert->getProduct->name??'-';
                $u['alert_message']         = $alert->alert_message??'-';
                $u['code_data']             = $alert->getCode->code_data??'-';
                $u['action_taken']          = $alert->admin_assigned_to!=null?'Yes':'No'??'-';
                $u['scanned_by']            = $alert->getUser->phone??'-';
                $u['created_at']            = date('M d, Y',strtotime($alert->created_at))??'-';
                $actions                    = view('admin.alerts.actions',['id' => $alert->id,'admin_assigned_to'=>$alert->admin_assigned_to]);
                $u['actions']               = $actions->render(); 

                $alertData[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                "last_page"         =>  $last_page,
                "data"              =>  $alertData,
                "total"=>$total
            ];

            return $return;
        }
        return view('admin.alerts.index');
    }

    public function show($id)
    {   
        $id = decrypt($id);
        $alert = Alert::find($id);

        return view('admin.alerts.details')->with('alert',$alert)->with('page_name','admin-alerts');
    }

    public function assign(Request $request,$id)
    {   
        $input = $request->all();
        
        $alert = Alert::where('id',$id)->first();

        $alert->admin_assigned_to = $input['assigned_to'];
        $alert->save();
    }

}
