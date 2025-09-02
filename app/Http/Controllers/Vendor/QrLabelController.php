<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Code;
use App\Models\Invoice;
use App\Models\LabelOrder;
use App\Models\LabelOrderLog;
use App\Models\LabelSize;
use App\Models\MaterialType;
use App\Models\PrintingCost;
use Auth;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Storage;

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

            $response       = LabelOrder::getLabelOrderModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value, Auth::user()->parent_id??Auth::id(),$start_date,$end_date);

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

                $actions            = view('vendor.qr_labels.actions',['order' => $order]);
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
        return view('vendor.qr_labels.index');
    }

    public function create()
    {
        $label_sizes    = LabelSize::where('status','1')->get();
        $printing_cost  = PrintingCost::first();
        $material_types = MaterialType::where('status','1')->get();

        return view('vendor.qr_labels.create')->with('label_sizes',$label_sizes)->with('printing_cost',$printing_cost)->with('material_types',$material_types); 
    }

    public function resources(Request $request){

        $input = $request->all();

        if (isset($input['key']) && $input['key']=='label_size') {
            return $this->labelSize($input);
        }

        if (isset($input['key']) && $input['key']=='material_type') {
            return $this->materialType($input);
        }

        if (isset($input['key']) && $input['key']=='code') {
            return $this->verifyCodeAndQuantity($input);
        }

        return response(['success'=>false,'message'=>'Something went wrong.'],400);
    }

    public function labelSize($input)
    {   
        $result = [
            'message' => 'Label size details fetched.'
        ];

        $label_size = LabelSize::find($input['value']);

        if ($label_size) {
            $result['width'] = $label_size->width;
            $result['height'] = $label_size->height;
            $result['url'] = asset($label_size->image_url);
        }

        return response($result,200);
    }

    public function materialType($input)
    {   
        $result = [
            'message' => 'Material type details fetched.'
        ];

        $material_type = MaterialType::find($input['value']);

        if ($material_type) {
            $result['material_cost'] = $material_type->cost;
            $result['material_gsm'] = $material_type->gsm;
        }

        return response($result,200);
    }

    public function verifyCodeAndQuantity($input)
    {
        $message = '';

        if (!$input['value']) {
            return response(['errors'=>['start_code_no'=>'Please enter serial number.']],400);
        }

        if (!$input['quantity']) {
            return response(['errors'=>['quantity'=>'Please specify quantity.']],400);
        }

        $check_serial = Code::where('code_data',$input['value'])->where('user_id',Auth::user()->parent_id??Auth::id())->where('order_id',NULL)->first();

        if (!$check_serial) {
            return response(['errors'=>['start_code_no'=>'This serial number does not exist.']],400);
        }

        $input['from_id'] = $check_serial->id;

        $codes = Code::orderBy('id','ASC')->where('user_id',Auth::user()->parent_id??Auth::id())->where('id','>=',$check_serial->id)->where('order_id',NULL)->limit($input['quantity'])->get();

        $count = count($codes);

        if ($count<$input['quantity']) {
            return response(['errors'=>['quantity'=>'Only '.$count.' QR codes are available.']],400);
        }

        $message = 'Added '.$count.' codes to this order.';

        return response(['success'=>true,'message'=>$message],200);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $order = new LabelOrder;

        $image_url= null;

        if (isset($input['label_size']) && $input['label_size']!='other') {
            $label_size = LabelSize::find($input['label_size']);
            $image_url = $label_size->image_url;
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
            $name = $timestamp . '-' . uniqid() . '-' . str_replace([' ', ':'], '-', $file->getClientOriginalName());
            Storage::putFileAs('public/qe_labels', $file, $name);
            $path = Storage::url('qe_labels/'.$name);
            $image_url = $path;
        }

        $order->user_id = Auth::user()->parent_id??Auth::id();
        $order->start_code_no   = $input['start_code_no'];
        $order->rate            = $input['rate'];
        $order->quantity        = $input['quantity'];
        $order->subtotal        = $input['subtotal'];
        $order->gst             = $input['gst'];
        $order->amount          = $input['total'];
        $order->rz_order_id     = $input['rz_order_id'];
        $order->payment_id      = $input['razorpayId'];
        $order->image_url       = $image_url;

        if (isset($input['material_type']) && $input['material_type']!='') {
            $material_type = MaterialType::find($input['material_type']);
            $input['material_type_name'] = $material_type->type;
        }

        if (isset($input['image'])) {
            unset($input['image']);
        }

        $order->description     = json_encode($input);

        if (isset($input['add_company_logo']) && $input['add_company_logo']=='on') {
            $order->add_company_logo      = '1';
        }

        if (isset($input['sr_no_below_2d_code']) && $input['sr_no_below_2d_code']=='on') {
            $order->sr_no_below_2d_code   = '1';
        }

        if (isset($input['full_cmyk_color_print']) && $input['full_cmyk_color_print']=='on') {
            $order->full_cmyk_color_print = '1';
        }

        $order->status = 'Paid';
        $order->save();

        $log = insertLabelOrderLogs($order->id,null,'Paid','Order placed.');

        $serial = Code::where('code_data',$input['start_code_no'])->where('user_id',Auth::user()->parent_id??Auth::id())->where('order_id',NULL)->first();
        $codes_update = Code::orderBy('id','ASC')->where('user_id',Auth::user()->parent_id??Auth::id())->where('id','>=',$serial->id)->where('order_id',NULL)->limit($input['quantity'])->update(['order_id'=>$order->id]);

        // one copy in invoices
        $invoice                = new Invoice;
        $invoice->user_id       = Auth::user()->parent_id??Auth::id();
        $invoice->amount_inr    = $order->amount;
        $invoice->amount_usd    = $order->amount;

        if (igstApplicable(Auth::id())==true) {
            $invoice->igst = taxPercentage();
        }else{
            $invoice->sgst = taxPercentage()/2;
            $invoice->cgst = taxPercentage()/2;
        }

        $invoice->payment_id    = $order->payment_id;
        $invoice->description   = $order->description;
        $invoice->status        = '1';
        $invoice->type          = '2';
        $invoice->save();
        // end copy of invoice

        return response(['success'=>true,'message'=>'Order placed successfully. Please wait.'],200);
    }

    public function show($id)
    {
        $id = decrypt($id);

        $order = LabelOrder::find($id);
        $logs = LabelOrderLog::where('reference',$order->id)->orderBy('created_at','DESC')->get();
        return view('vendor.qr_labels.view')->with('order',$order)->with('logs',$logs);
    }
}
