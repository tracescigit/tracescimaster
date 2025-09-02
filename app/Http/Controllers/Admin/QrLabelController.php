<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LabelOrder\UpdateLabelOrderRequest;
use App\Models\LabelOrder;
use App\Models\LabelOrderLog;
use App\Models\LabelOrderStatus;
use Illuminate\Http\Request;

class QrLabelController extends Controller
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

            $response       = LabelOrder::getLabelOrderModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value, null ,$start_date,$end_date);

            if(!$response){
                $orders      = [];
                $last_page  = 0;
                $total = 0;
            }
            else{
                $orders      = $response['response'];
                $last_page   = $response['last_page'];
                $total       = $response['total'];
            }

            $orderData = array();
            $i = 1;

            foreach ($orders as $order) {

                $u['id']             = 'ORDER'.$order->id;
                $u['payment_id']     = $order->payment_id??'-';
                $u['total_stamps']   = number_format(getTotalCodes($order->id),0,'',',');
                $u['created_at']     = date('M d, Y',strtotime($order->created_at));
                $u['status']         = $order->getCurrentStatusText->title;
                $u['amount']         = number_format($order->amount,2,'.',',').' '.env('CURRENCY');

                $actions            = view('admin.qr_labels.actions',['order' => $order]);
                $u['actions']       = $actions->render(); 

                $orderData[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                "last_page"         =>  $last_page,
                "data"              =>  $orderData,
                "total"=>$total
            ];

            return $return;
        }
        return view('admin.qr_labels.index');
    }

    public function show($id)
    {
        $id = decrypt($id);
        $order = LabelOrder::find($id);
        $logs = LabelOrderLog::where('reference',$order->id)->orderBy('created_at','DESC')->get();
        return view('admin.qr_labels.view')->with('order',$order)->with('logs',$logs);
    }

    public function update(UpdateLabelOrderRequest $request, $id){
        $id = decrypt($id);
        $order = LabelOrder::find($id);
        $input = $request->all();

        if($order->dispatch_status==$input['status']){
            return response(['message'=>'Invalid status change. Please select different status.'],400);
        }

        $init_status = LabelOrderStatus::where('code',$order->dispatch_status)->first();
        $status = LabelOrderStatus::where('code',$input['status'])->first();

        $log = insertLabelOrderLogs($order->id,$init_status->title,$status->title,$input['remarks']);

        $order->dispatch_status = $input['status'];
        $order->save();

        return response(['message'=>'Order status updated successfully.'],200);
    }
}
