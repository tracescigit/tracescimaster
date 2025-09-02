<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\RewardOrder;
use Illuminate\Http\Request;

class RewardOrderController extends Controller
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

            $response       = RewardOrder::getRewardOrderModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value);

            if(!$response){
                $orders      = [];
                $last_page  = 0;
                $total = 0;
            }
            else{
                $orders     = $response['response'];
                $last_page   = $response['last_page'];
                $total       = $response['total'];
            }

            $orderData = array();
            $i = 1;

            foreach ($orders as $order) {
                $u['id']      = '#'.$order->id??'-';
                $u['user']    = $order->name??'-';
                $u['phone']   = $order->getUser->phone??'-';
                $u['product'] = $order->product??'-';
                $u['points']  = $order->points??'-';
                $u['created_at']  = date('M d, Y',strtotime($order->created_at));
                $u['status']  = $order->dispatch_status??'-';
                $actions             = view('vendor.reward_orders.actions',['id' => $order->id]);
                $u['actions']        = $actions->render(); 

                $orderData[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                "last_page"         =>  $last_page,
                "data"              =>  $orderData,
                "total"             =>  $total
            ];

            return $return;
        }
        return view('vendor.reward_orders.index');
    }

    public function show($id)
    {   
        $id = decrypt($id);
        $order = RewardOrder::find($id);
        return view('vendor.reward_orders.view')->with('order',$order)->with('page_name','vendor-reward-orders');
    }

    public function update(Request $request, $id)
    {
        try{
            $this->validate($request,[
                'status' => 'required'
            ]);

            $input   = $request->all();

            $id      = decrypt($id);
            $order   = RewardOrder::find($id);
            
            $old_status    = $order->dispatch_status;
            $order->dispatch_status = $input['status'];
            $order->save();

            if($old_status!=$input['status']){
                $order = updateOrderHistory([
                    'order_id'   => $order->id,
                    'message'    => 'Order dispatch status was marked as '.$input['status']
                ]);
            }

            return response([
                'success'=> true,
                'message'=>'Order updated successfully.'
            ], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }
}
