<?php

namespace App\Http\Controllers\Vendor;

use App\CustomClasses\EmailProvider;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\OfferCodeRequest;
use App\Models\Credit;
use App\Models\Invoice;
use App\Models\Offer;
use App\Models\Plan;
use App\Models\Sms;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use PDF;
use Response;

class CreditController extends Controller
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

			$response       = Credit::getCreditModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value, Auth::id(),$start_date,$end_date);

			if(!$response){
				$credits      = [];
				$last_page  = 0;
				$total = 0;
			}
			else{
				$credits      = $response['response'];
				$last_page    = $response['last_page'];
				$total  	  = $response['total'];
			}

			$creditData = array();
			$i = 1;

			foreach ($credits as $credit) {

				$u['credits']        = $credit->credits??'-';
				$u['payment_id']     = $credit->payment_id??'-';
				$u['plan_name']      = $credit->plan_name??'-';
				$u['status']         = $credit->status??'-';
				$u['created_at']     = date('M d, Y',strtotime($credit->created_at))??'-';
				$actions             = view('vendor.credits.actions',['id' => $credit->id,'amount' => $credit->amount]);
				$u['actions']        = $actions->render(); 

				$creditData[] = $u;
				$i++;
				unset($u);
			}

			$return = [
				"last_page"		    =>  $last_page,
				"data"              =>  $creditData,
				"total"=>$total
			];
			
			return $return;
		}
		return view('vendor.credits.index');
	}

	public function show($id)
	{	
		$id = decrypt($id);
		$credit = Credit::find($id);

		if(isset($_GET['download']) && $_GET['download']=='invoice'){

			$path = base_path('/public/pdf/receipts/');
			$pdfName = 'creditinvoice' . '.pdf';

			$pdf = PDF::loadView('vendor.pdf.creditinvoice', ['credit'=>$credit]);

			if (!\File::isDirectory($path)) {
				\File::makeDirectory($path, 493, true);
			}

			$pdf->save($path . $pdfName);
			$file= $path . $pdfName;

			$headers = array(
				'Content-Type: application/pdf',
			);

			return Response::download($file, ''.prepareInvoiceId($credit->getInvoice->id).'.pdf', $headers);

		}else{
			return view('vendor.credits.invoice')->with('credit',$credit)->with('page_name','vendor-credits');
		}
	}

	public function buy()
	{	
		if(isset($_GET['page']) && $_GET['page']=='success'){
			return view('vendor.credits.success')->with('page_name','vendor-credits');
		}else{
			$plans = Plan::where('id','!=',Auth::user()->getSubscription->plan_id)->where('parent_id',null)->where('status','1')->where('price_inr','>','0')->where('price_usd','>','0')->where('credits','>=',getUsedCredits(Auth::id()))->get();
			$topups = Plan::where('parent_id',Auth::user()->getSubscription->plan_id)->where('status','1')->where('price_inr','>','0')->where('price_usd','>','0')->get();
			return view('vendor.credits.buy')->with('topups',$topups)->with('plans',$plans)->with('page_name','vendor-credits');	
		}
	}

	public function payment($id)
	{
		$id   = decrypt($id);
		$plan = Plan::find($id);

		if($plan->price_inr<=0){
			return $this->free_transaction($plan->id);
		}

		return view('vendor.credits.payment')->with('plan',$plan)->with('page_name','vendor-credits');
	}

	public function free_transaction($plan_id)
	{
		$plan = Plan::find($plan_id);
		$credit = new Credit;
		$credit->amount = $plan->price_inr;
		$credit->credits = $plan->credits;
		$credit->type = '0';
		$credit->payment_id = Str::random(10);
		$credit->plan_id = $plan_id;
		$credit->user_id = Auth::id();
		$credit->plan_name = $plan->title;
		$credit->status = '1';

		$credit->save();

		return redirect('vendor/credits');

	}

	public function offer(OfferCodeRequest $request)
	{
		$input = $request->all();
		$code = $input['offer_code'];

		$offer = Offer::where('code',$code)->where('status','1')->first();

		$success = true;

		if(!$offer){
			$success = false;
		}

		if($offer && $offer->user_id!=null && $offer->user_id!=Auth::id()){
			$success = false;
		}

		if($success==false){
			return response(['errors'=>['offer_code'=>'Invalid Offer Code.']],400);
		}

		return response(['id'=>$offer->id,'type'=>$offer->type,'value'=>$offer->value,'code'=>$offer->code,'limit'=>$offer->limit],200);

	}

	public function order(Request $request)
	{
		$input = $request->all();

		$id    = decrypt($input['plan_id']);
		$plan  = Plan::find($id);

		$clear_pending = Credit::where('user_id',Auth::id())->where('status','0')->delete();

		$credit = new Credit;
		$credit->amount  = $plan->price_inr;
		$credit->credits = $plan->credits;
		$credit->type    = '0';
		$credit->plan_id = $plan->id;
		$credit->user_id = Auth::id();
		$credit->plan_name = $plan->title;
		$credit->status = '0';

		if(isset($input['offer_id']) && $input['offer_id']!=''){
			$credit->offer_id = $input['offer_id'];
			$credit->discounted_amount = $input['total'];
		}

		if (igstApplicable(Auth::id())==true) {
			$credit->igst = taxPercentage();
		}else{
			$credit->sgst = taxPercentage()/2;
			$credit->cgst = taxPercentage()/2;
		}

		$taxable = $credit->discounted_amount??$credit->amount;
		$payable = gstAmount($taxable);
		
		$credit->payable = $payable;

		$credit->save();	


		return response(['order_id'=>$credit->id,'total'=>$payable],200);		
	}

	public function transaction(Request $request)
	{
		$input = $request->all();

		$credit = Credit::find($input['order_id']);

		if(isset($input['razorpayId']) && $input['razorpayId']!=''){
			$credit->payment_id = $input['razorpayId'];
			$credit->status     = '1';

			if($credit->offer_id!=''){
				$offer = Offer::find($credit->offer_id);

				if($offer->limit>0){
					$offer->limit = $offer->limit-1;
					$offer->save();
				}
			}

			$plan = Plan::find($credit->plan_id);

			// one copy in invoices
			$invoice   = new Invoice;
			$invoice->user_id = Auth::id();
			$invoice->amount_inr = $credit->payable;
			$invoice->amount_usd = $credit->payable;
			$invoice->igst = $credit->igst;
			$invoice->sgst = $credit->sgst;
			$invoice->cgst = $credit->cgst;
			$invoice->payment_id = $credit->payment_id;
			$description = [];
			$description[0]['plan_id'] 		= $plan->id;
			$description[0]['plan'] 		= $plan->title;
			$description[0]['price_inr'] 	= $plan->price_inr;
			$description[0]['price_usd'] 	= $plan->price_usd;
			$description[0]['type'] 		= $plan->parent_id?'1':'0';
			$invoice->description 			= json_encode($description);
			$invoice->status 				= '1';
			$invoice->type 					= '1';
			$invoice->save();
			// end copy of invoice

			if($plan->parent_id!=''){
				$subscribe = new Subscription;
				$subscribe->user_id = Auth::id();
				$subscribe->type = '1';
				$subscribe->plan_id = $plan->id;
				$subscribe->plan_name = $plan->title;
				$subscribe->credits = $plan->credits;
				$subscribe->status = '1';
				$subscribe->start_date = Carbon::now();
				$subscribe->save();

				Sms::sendSms('TRCPlan', 
					[   
						'username' => Auth::user()->name??'User',
						'phone' => Auth::user()->phone,
						'code' => Auth::user()->phone_code??'91',
						'plan' => $plan->title
					]
				);

				EmailProvider::sendMail('user-new-plan-subscribe', 
					[   
						'username' => Auth::user()->name,
						'email' => Auth::user()->email,
						'plan' => $plan->title
					]
				);

			}else{
				$oldplan = Subscription::where('user_id',Auth::id())->first();
				$subscribe = new Subscription;
				$subscribe->user_id = Auth::id();
				$subscribe->plan_id = $plan->id;
				$subscribe->plan_name = $plan->title;
				$subscribe->credits = $plan->credits;
				$subscribe->status = '1';
				$subscribe->start_date = Carbon::now();
				
				Sms::sendSms('TRCPlanUpgrade', 
					[   
						'username' => Auth::user()->name??'User',
						'phone' => Auth::user()->phone,
						'code' => Auth::user()->phone_code??'91',
						'new_plan' => $plan->title ,
						'old_plan' => $oldplan->getPlan->title
					]
				);

				EmailProvider::sendMail('user-plan-switch', 
					[   
						'username' => Auth::user()->name,
						'email' => Auth::user()->email,
						'newplan' => $plan->title ,
						'oldplan' => $oldplan->getPlan->title
					]
				);

				$delete_other_subscription = Subscription::where('user_id',Auth::id())->delete();
				$subscribe->save();

			}
		}

		$credit->save();
		return response(['status'=>'success'],200);
	}
}
