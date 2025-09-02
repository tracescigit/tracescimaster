<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alert;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
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

            $response       = Alert::getReportModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value,Auth::id(),$start_date,$end_date);

            if(!$response){
                $reports      = [];
                $last_page  = 0;
                $total = 0;
            }
            else{
                $reports      = $response['response'];
                $last_page     = $response['last_page'];
                $total     = $response['total'];
            }

            $reportData = array();
            $i = 1;

            foreach ($reports as $report) {
                $u['id']                    = 'CASE#'.$report->id;
                $u['product_name']          = $report->product_name??'-';
                $u['batch']                 = $report->batch??'-';
                $u['issue_type']            = $report->issue_type??'-';
                $u['code_data']             = $report->getCode->code_data??'-';
                $u['user_name']             = $report->getUser->name??'-';
                $u['created_at']            = date('M d, Y',strtotime($report->created_at))??'-';
                $actions                    = view('vendor.reports.actions',['id' => $report->id]);
                $u['actions']               = $actions->render(); 

                $reportData[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                "last_page"         =>  $last_page,
                "data"              =>  $reportData,
                "total"             =>  $total
            ];
            
            return $return;
        }
        return view('vendor.reports.index');
    }

    public function show($id)
    {   
        $id = decrypt($id);
        $report = Alert::find($id);
        
        return view('vendor.reports.details')->with('report',$report)->with('page_name','vendor-reports');
    }

    public function assign(Request $request,$id)
    {   
        $input = $request->all();
        
        $report = Alert::where('id',$id)->first();
        
        $report->vendor_assigned_to = $input['assigned_to'];
        $report->manufacturer_assigned_to = $input['assigned_to'];
        $report->save();
    }

}

