<?php

namespace App\Http\Controllers\Vendor;

use App\CustomClasses\EmailProvider;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceTemplate;
use App\Models\Plan;
use App\Models\Sms;
use App\Models\Subscription;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use PDF;

class InvoiceController extends Controller
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

            $response       = Invoice::getInvoiceModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value, Auth::id());

            if(!$response){
                $invoices      = [];
                $last_page  = 0;
                $total = 0;
            }
            else{
                $invoices      = $response['response'];
                $last_page     = $response['last_page'];
                $total     = $response['total'];
            }

            $invoiceData = array();
            $i = 1;

            foreach ($invoices as $invoice) {

                $u['id']             = prepareInvoiceId($invoice->id);
                $u['payment_id']     = $invoice->payment_id??'-';
                $u['created_at']     = date('M d, Y',strtotime($invoice->created_at));
                $u['status']         = $invoice->status??'-';
                $u['amount_inr']     = '&#8377; '.number_format((float)$invoice->amount_inr,2,'.','')??'-';
                $actions             = view('vendor.invoices.actions',['id' => $invoice->id,'status' => $invoice->status]);
                $u['actions']        = $actions->render(); 

                $invoiceData[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                "last_page"         =>  $last_page,
                "data"              =>  $invoiceData,
                "total"             =>  $total
            ];

            return $return;
        }

        $invoice = updateInvoices(Auth::user()->parent_id??Auth::id());
        return view('vendor.invoices.index');
    }

    public function show($id)
    {   
        $id = decrypt($id);
        $invoice = Invoice::find($id);
        return view('vendor.invoices.invoice')->with('invoice',$invoice)->with('page_name','vendor-invoices');
    }

    public function transaction(Request $request)
    {
        $input = $request->all();
        $invoice = Invoice::find($input['order_id']);

        if(isset($input['razorpayId']) && $input['razorpayId']!=''){
            $invoice->payment_id = $input['razorpayId'];
            $invoice->status     = '1';
        }

        $invoice->save();

        $invoiceDetail = Invoice::where('id',$invoice->id)->first();

        $invoice_des =  json_decode($invoiceDetail->description,true);

        Sms::sendSms('TRCPayment', 
            [   
                'amount' => $invoice->amount_inr,
                'username' => Auth::user()->name??'User',
                'phone' => Auth::user()->phone,
                'code' => Auth::user()->phone_code??'91',
                'invoice_no' => '#INV'.$invoice->id ,
                'order_id' => $input['order_id'],
                'transaction_no' => $input['razorpayId']
            ]
        );

        EmailProvider::sendMail('user-payment-confirmation', 
            [   
                'username' => Auth::user()->name,
                'email' => Auth::user()->email,
                'invoice_no' => '#INV'.$invoice->id ,
                'amount' => $invoice->amount_inr,
                'order_id' => $input['order_id'],
                'transaction_id' => $input['razorpayId']
            ]
        );


        return response(['status'=>'success'],200);
    }

    public function remove(Request $request)
    {
        try{

            $input = $request->all();

            $available_credit = getCreditAmount(Auth::id());
            $used_credit = getUsedCredits(Auth::id());  
            $remaining_credit = $available_credit-$used_credit;
            $plan = Plan::find($input['plan_id']);
            $plan_credits = $plan->credits;

            if($remaining_credit>=$plan_credits){

                $remove_subscription = Subscription::where('user_id',Auth::id())->where('plan_id',$input['plan_id'])->delete();

                $subscriptions = Subscription::where('user_id',Auth::id())->get();
                $invoice       = Invoice::find($input['invoice_id']);

                if(count($subscriptions)>0){

                    $amount_inr = 0;
                    $amount_usd = 0;
                    $description= [];

                    foreach ($subscriptions as $key => $subscription) {

                        if($subscription->getPlan && ($subscription->getPlan->price_inr>0 || $subscription->getPlan->price_usd>0)){
                            $amount_inr+=$subscription->getPlan->price_inr;
                            $amount_usd+=$subscription->getPlan->price_usd;
                            $description[$key]['plan_id'] = $subscription->getPlan->id;
                            $description[$key]['plan'] = $subscription->getPlan->title;
                            $description[$key]['price_inr'] = $subscription->getPlan->price_inr;
                            $description[$key]['price_usd'] = $subscription->getPlan->price_usd;
                            $description[$key]['type'] = $subscription->getPlan->parent_id?'1':'0';
                        }

                    }

                    if(!empty($description)){
                        $invoice->amount_inr = gstAmount($amount_inr);
                        $invoice->amount_usd = gstAmount($amount_usd);
                        $invoice->description = json_encode($description);
                        $invoice->save();
                    }   
                }

                return response(['status'=>true,'message'=>'Plan is successfully removed and prices are revised now.']);
            }else{
                return response(['status'=>false,'message'=>'You do not have enough remainig credits to remove this plan. Please delete some codes manually to achieve this.'], 503);
            }   

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }

    }

    public function downloadInvoice($id)
    {
        $invoiceId = decrypt($id);
        $invoice_no =prepareInvoiceId($invoiceId);
        
        $invoiceDetail = Invoice::where('id',$invoiceId)->with('getUser')->first();

        $invoice_des =  json_decode($invoiceDetail->description,true);

        $template = InvoiceTemplate::whereName('payment_slip')->first();
        $html = $template->html;

        $dynamic_values         = $template->variables;
        $dynamic_values         = array_map('trim', explode(',', $template->variables));

        $adminDetail = getAdminDetail();

        $html = view('vendor.invoices.download')->with('invoice',$invoiceDetail)->with('description',$invoice_des);

        $path = base_path('/public/pdf/receipts/');
        $pdfName = 'payment_slip' . '.pdf';

        $pdf = PDF::loadView('vendor.pdf.payment_slip', ['html'=>$html]);

        if (!\File::isDirectory($path)) {
            \File::makeDirectory($path, 493, true);
        }

        $pdf->save($path . $pdfName);
        $file= $path . $pdfName;

        $headers = array(
            'Content-Type: application/pdf',
        );

        return Response::download($file, ''.$invoice_no.'.pdf', $headers);
    }
}
