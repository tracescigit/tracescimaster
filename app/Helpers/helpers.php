<?php

use App\Models\Aggregation;
use App\Models\Alert;
use App\Models\Code;
use App\Models\Company;
use App\Models\Country;
use App\Models\CouponCode;
use App\Models\Credit;
use App\Models\Document;
use App\Models\Invoice;
use App\Models\LabelOrderLog;
use App\Models\LabelOrderStatus;
use App\Models\Module;
use App\Models\Permission;
use App\Models\Plan;
use App\Models\Product;
use App\Models\RewardOrder;
use App\Models\RewardScheme;
use App\Models\ScanHistory;
use App\Models\Sms;
use App\Models\Subscription;
use App\Models\SupplyChainAction;
use App\Models\SupplyChainAlert;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Str;

if (! function_exists('getCreditAmount')) {
	function getCreditAmount($user_id)
	{
		$amount = Subscription::where('user_id',$user_id)->sum('credits');
		return $amount;
	}
}

if (! function_exists('getUsedCredits')) {
	function getUsedCredits($user_id)
	{
		$amount = Code::where('user_id',$user_id)->where('exported','1')->count();
		return $amount;
	}
}

if (! function_exists('getAvailableCredits')) {
	function getAvailableCredits($user_id)
	{
		$amount = getCreditAmount($user_id) - getUsedCredits($user_id);
		return $amount;
	}
}


if (! function_exists('getLatestCreditAmount')) {
	function getLatestCreditAmount($user_id)
	{
		$amount = 0;
		$credit = Credit::where('user_id',$user_id)->where('status','1')->orderBy('updated_at','DESC')->first();
		if($credit){
			$amount = $credit->credits;
		}
		return $amount;
	}
}

if (! function_exists('getDesignation')) {
	function getDesignation($user_id)
	{
		$designation = 'User';

		$user = User::find($user_id);

		if($user){
			switch ($user->type) {
				case '1':
				$designation = 'Administrator';
				break;
				
				case '2':
				$designation = 'Manufacturer';
				break;

				case '3':
				$designation = 'Inspector';
				break;

				case '4':
				$designation = 'Employee';
				break;

				case '5':
				$designation = 'Supply Chain User';
				break;

				default:
				$designation = 'User';
				break;
			}
		}

		return $designation;
	}
}

if(! function_exists('getAppUsersRoles')){
	function getAppUsersRoles($user_id){
		
		$role = "User";
		$user = User::find($user_id);

		if($user){

			if($user->type =='5'){
				$role = "Supply Chain User";
			}elseif($user->type=='2'){
				if($user->who_you_are=='Audit Team' || $user->who_you_are=='Management'){
					$role = "Authority";	
				}else{
					$role = "Vendor";
				}
				
			}else{
				$role = "User";
			}

		}
		return $role;
	}
}

if (! function_exists('getTotalProducts')) {
	function getTotalProducts($user_id=null)
	{
		$products = Product::where('id','!=','');

		if($user_id){
			$products->where('user_id',$user_id);
		}

		$count = $products->count();

		return $count;
	}
}

if (! function_exists('getTotalUsers')) {
	function getTotalUsers($user_id=null)
	{
		$users = User::where('id','!=','');

		if($user_id){
			$users->where('parent_id',$user_id);
		}

		$count = $users->count();

		return $count;
	}
}


if (! function_exists('getCodesGenerated')) {
	function getCodesGenerated($user_id=null)
	{

		$list = Product::join('codes', 'codes.product_id', '=', 'products.id')->select('codes.*');

		if($user_id){
			$list->where('codes.user_id',$user_id);
		}

		$count = $list->count();

		return $count;
	}
}


if (! function_exists('getMyUsers')) {
	function getMyUsers()
	{
		$users = User::where('id','!=','');

		if(Auth::user()->type=='1'){
			$users->where('type','2');
		}

		if(Auth::user()->type=='2'){
			$users->where('parent_id',Auth::id());
		}

		$count = $users->count();

		return $count;
	}
}

if (! function_exists('getApprovedProfiles')) {
	function getApprovedProfiles()
	{
		$count = User::where('id','!=','')->where('type','2')->where('status','1')->where('active','1')->count();

		return $count;
	}
}

if (! function_exists('myDashboard')) {
	function myDashboard()
	{
		$url = url('/');

		if(Auth::user()->type=='1' ){
			$url = route('admin');
		}

		if(Auth::user()->type=='2' ){
			$url = route('vendor');
		}


		return $url;
	}
}

if (! function_exists('getDocument')) {
	function getDocument($user_id,$type)
	{
		$doc = Document::where('user_id',$user_id)->where('type',$type)->first();
		return $doc;
	}
}

if (! function_exists('getPlans')) {
	function getPlan()
	{
		$plan = Plan::where('status','1')->where('parent_id',null)->get();
		return $plan;
	}
}

if (! function_exists('getSubscriptionPlan')) {
	function getSubscriptionPlan($user_id)
	{
		$plan = null;

		$subscription = Subscription::where('user_id',$user_id)->where('status','1')->where('type','0')->first();

		if ($subscription) {
			$plan = Plan::find($subscription->plan_id);
		}
		return $plan;
	}
}

if ( ! function_exists('limit_text'))
{
    /**
     * limit_text text
     *
     * Simply adds the http:// part if no scheme is included
     *
     * @param   string  the URL
     * @return  string
     */

    function limit_text($text, $limit) {
    	if (str_word_count($text, 0) > $limit) {
    		$words = str_word_count($text, 2);
    		$pos = array_keys($words);
    		$text = substr($text, 0, $pos[$limit]) . '...';
    	}
    	return $text;
    }
}

if (! function_exists('updateInvoices')) {
	function updateInvoices($user_id)
	{	

		$generated = Invoice::where('user_id',$user_id)->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

		$subscriptions = Subscription::where('user_id',$user_id)->get();
		$subscribe_month = Subscription::where('type','0')->whereMonth('created_at', Carbon::now()->month)->where('user_id',$user_id)->first();

		if($generated==0 && count($subscriptions)>0 && !$subscribe_month){

			$amount_inr = 0;
			$amount_usd = 0;
			$description= [];

			foreach ($subscriptions as $key => $subscription) {
				
				if($subscription->getPlan && ($subscription->getPlan->price_inr>0 || $subscription->getPlan->price_usd>0)){
					$amount_inr+=$subscription->getPlan->price_inr;
					$amount_usd+=$subscription->getPlan->price_usd;
					$description[$key]['plan_id']   = $subscription->getPlan->id;
					$description[$key]['plan']      = $subscription->getPlan->title;
					$description[$key]['price_inr'] = $subscription->getPlan->price_inr;
					$description[$key]['price_usd'] = $subscription->getPlan->price_usd;
					$description[$key]['credits']   = $subscription->getPlan->credits;
					$description[$key]['products']  = $subscription->getPlan->products;
					$description[$key]['users']   	= $subscription->getPlan->users;
					$description[$key]['type'] 		= $subscription->getPlan->parent_id?'1':'0';
				}

			}

			if(!empty($description)){
				$invoice   = new Invoice;
				$invoice->user_id = $user_id;
				$invoice->amount_inr = gstAmount($amount_inr);
				$invoice->amount_usd = gstAmount($amount_usd);

				if (igstApplicable($user_id)==true) {
					$invoice->igst = taxPercentage();
				}else{
					$invoice->sgst = taxPercentage()/2;
					$invoice->cgst = taxPercentage()/2;
				}

				$invoice->description = json_encode($description);
				$invoice->save();

				$user = User::where('id',$user_id)->first();

				EmailProvider::sendMail('user-invoice-generation-email', 
					[   
						'username' => $user->name,
						'email' => $user->email,
						'amount' => gstAmount($amount_inr), 
						'link' => url('/login'),
					]
				);
			}	
			
		}

		return true;
	}
}

if (! function_exists('taxPercentage')) {
	function taxPercentage()
	{
		return env('TAX',18);
	}
}

if (! function_exists('gstAmount')) {
	function gstAmount($amount)
	{
		return $amount + $amount*(taxPercentage()/100);
	}
}


if (! function_exists('igstApplicable')) {
	function igstApplicable($user_id)
	{
		$applicable = false;
		$company = Company::where('user_id',$user_id)->first();
		if($company && $company->gst){
			$state_code = mb_substr($company->gst, 0, 2);
			$applicable = $state_code == env('STATE_CODE',33);
		}

		return $applicable;
	}
}

if (! function_exists('paymentReminder')) {
	function paymentReminder($user_id)
	{
		$count    = 0;
		$critical = 0;
		$reminder = 0;

		$invoices = Invoice::where('user_id',$user_id)->where('status','0')->get();
		
		$count = count($invoices);

		if($count>0){
			foreach ($invoices as $key => $invoice) {
				$now = Carbon::now();
				$date = Carbon::parse($invoice->created_at);
				$diff = $date->diffInDays($now);

				if($diff>env('INVOICE_PENDING_DAYS',5)){
					$critical++;
				}else{
					$reminder++;	
				}
			}
		}



		return ['count'=>$count,'critical'=>$critical,'reminder'=>$reminder];
	}
}

function generateQR() {
	$code = Str::random(15);

	if (checkCodeExists($code)) {
		return generateQR();
	}

	return $code;
}

if (! function_exists('checkCodeExists')) {
	function checkCodeExists($code)
	{
		return Code::where('qr_code',$code)->exists();
	}
}

if (! function_exists('createOrUpdateUserAndAssignOtp')) {
	function createOrUpdateUserAndAssignOtp($phone_code,$phone,$sendsms=true)
	{
		$otp =  mt_rand(1000, 9999);

		if($phone_code==91 && $phone==9876543210){
			$otp = 1111;
		}
		
		$user = User::where('phone_code',$phone_code)->where('phone',$phone)->first();

		if (!$user) {
			$user = new User;
			$user->name = $phone;
			$user->phone_code = $phone_code;
			$user->phone = $phone;
			$user->status = '1';
			$user->active = '1';
			$user->type   = '0'; 
			$user->save();
		}

		$user->otp = $otp;
		$user->save();

		// if ($sendsms==true) {
		// 	Sms::sendSms('TRCOTP', 
		// 		[   
		// 			'otp' => $otp,
		// 			'username' => $user->name??'User',
		// 			'phone' => $phone,
		// 			'code' => $phone_code,
		// 		]
		// 	);
		// }
		
		return $user;

	}
}

if (! function_exists('sendEmail')) {
	function sendEmail($input)
	{
		$data['email_body'] 	= $input['email_body'];
		$data['email_subject'] 	= $input['email_subject'];
		$data['sender']        	= env('MAIL_FROM_ADDRESS', 'wecare@tracesci.in');
		$data['receiver']      	= $input['email'];
		$data['bcc']      	    = $input['bcc']??'';
		$data['appname']       	= env('APP_NAME', 'TRACESCI');

		$response = Http::post('https://www.vkreate.in/api/sendemail', $data);

		return true;
	}
}

if (! function_exists('sendFrontEmail')) {
	function sendFrontEmail($input)
	{
		$data['email_body'] 	= $input['email_body'];
		$data['email_subject'] 	= $input['email_subject'];
		$data['sender']        	= 'jetsciglobal@monotech.in';
		$data['receiver']      	= $input['email'];
		$data['bcc']      	    = $input['bcc']??'';
		$data['appname']       	= env('APP_NAME', 'TRACESCI');

		$response = Http::post('https://www.vkreate.in/api/sendemail', $data);

		return true;
	}
}

if ( ! function_exists('getAdminDetail'))
{
    /**
     *
     * @param   message to store , $request
     * @return  void
     */
    function getAdminDetail() {

    	return DB::table('users')
    	->select('users.*')
    	->where(['type' => '1'])
    	->first();
    }
}


if ( ! function_exists('getTotalAlerts')) {
	function getTotalAlerts()
	{
		$alerts = Alert::where('id','!=','')->where('type','0')->get();

		$count = $alerts->count();

		return $count;
	}
}


if ( ! function_exists('getTotalAlertsVendor')) {
	function getTotalAlertsVendor($user_id)
	{
		$alerts = Alert::where('type','0')->leftJoin('products','alerts.product_id','=','products.id')->where('user_id',Auth::user()->parent_id??$user_id);

		$count = $alerts->count();

		return $count;
	}
}

if ( ! function_exists('getInspector')) {
	function getInspector($user_id)
	{
		$inspectors = User::where('type','3')->where('parent_id',$user_id)->where('status','1')->get();

		return $inspectors;
	}
}

if (! function_exists('getUsersCount')) {
	function getUsersCount()
	{
		$users = User::where('id','!=','')->get();

		$userCount = count($users);

		return $userCount;
	}
}

if (! function_exists('getVendorsCount')) {
	function getVendorsCount()
	{
		$users = User::where('type','2')->get();

		$userCount = count($users);

		return $userCount;
	}
}

if (! function_exists('getCodesCount')) {
	function getCodesCount()
	{
		$codes = Code::where('id','!=','')->get();

		$codeCount = count($codes);

		return $codeCount;
	}
}

if (! function_exists('inAllowedPermissions')) {
	function inAllowedPermissions($user_id,$module_id,$permission)
	{
		$exists = Permission::where('user_id',$user_id)->where('module_id',$module_id)->where($permission,'1')->exists();	

		return $exists;

	}
}

if (! function_exists('inAllowedPermissionsByModuleSlug')) {
	function inAllowedPermissionsByModuleSlug($user_id,$module_slug,$permission,$type='2')
	{
		$exists = false;

		$user   = User::find($user_id);
		$module = Module::where('slug',$module_slug)->where('type',$type)->first();

		if ($module) {
			$exists = Permission::where('user_id',$user_id)->where('module_id',$module->id)->where($permission,'1')->exists();
		}

		if ($user->parent_id==NULL) {
			$exists = true;
		}

		if ($user->type=='2' && paymentReminder(Auth::id())['critical']==1 && $module_slug!='my-invoices') {
			$exists = false;
		}

		if ($user->status!='1') {
			$exists = false;
		}

		return $exists;

	}
}

if (! function_exists('hasRoutePermission')) {
	function hasRoutePermission($route,$user_id)
	{
		$proceed = false;
		$module =null;
		$user = User::find($user_id);
		$modules = Module::get();

		foreach($modules as $mod){
			$view_array = json_decode($mod->view_routes,true);
			$modify_array = json_decode($mod->modify_routes,true);

			if(in_array($route,$view_array) || in_array($route,$modify_array)){
				$module = $mod;
			}

		}

		if(!$module){
			return $proceed;
		}

		$permission = Permission::where('user_id',$user_id)->where('module_id',[$module->id])->first();

		if($permission){

			$find_in_view = false;
			$find_in_modify = false;

			foreach($modules as $mod){
				$view_array = json_decode($mod->view_routes,true);
				$modify_array = json_decode($mod->modify_routes,true);

				if(in_array($route,$view_array)){
					$find_in_view =true;
				}

				if(in_array($route,$modify_array)){
					$find_in_modify =true;
				}

			}

			if(($find_in_view && $permission->view=='1') || ($find_in_modify && $permission->modify=='1')){
				$proceed = true;
			}

		}

		if($user->parent_id=='' || $user->parent_id==null){
			$proceed = true;
		}


		return $proceed;
	}
}

if ( ! function_exists('getActiveAlerts')) {
	function getActiveAlerts()
	{
		$alerts = Alert::where('id','!=','')->where('type','0')->where('admin_assigned_to',null)->get();

		$count = $alerts->count();

		return $count;
	}
}

if ( ! function_exists('getActiveAlertsVendor')) {
	function getActiveAlertsVendor($user_id)
	{
		$alerts = Alert::where('type','0')->where('manufacturer_assigned_to',null)->leftJoin('products','alerts.product_id','=','products.id')->where('user_id',Auth::user()->parent_id??$user_id);

		$count = $alerts->count();

		return $count;
	}
}

if (! function_exists('addAlerts')) {
	function addAlerts($array)
	{	
		$array['created_at'] = Carbon::now();
		$array['updated_at'] = Carbon::now();
		$array['type'] = "0";
		$add = Alert::insert($array);
		return $add;
	}
}

if (! function_exists('addSupplyChainAlerts')) {
	function addSupplyChainAlerts($array)
	{	
		$array['created_at'] = Carbon::now();
		$array['updated_at'] = Carbon::now();
		$add = SupplyChainAlert::insert($array);
		return $add;
	}
}


if (! function_exists('companyAddress')) {
	function companyAddress($company=null)
	{
		$result = '';
		
		if($company->name){
			$result = $result.$company->name.', ';
		}	

		if($company->city){
			$result = $result.$company->city.', ';
		}	

		if($company->address){
			$result = $result.$company->address.', ';
		}	

		if($company->country){
			$result = $result.$company->country.', ';
		}	

		if($company->zip){
			$result = $result.$company->zip.' ';
		}	

		return $result;
	}
}

if (! function_exists('sendSms')) {
	function sendSms($code,$phone,$sms_id,$sms_body)
	{
		$response = Http::withHeaders([
			'authKey'  	=> env('SMS_AUTHKEY','253261A12Hw2jVy2MI5c209ad3')
		])->get('https://api.msg91.com/api/sendhttp.php', [
			'sender' 	=> env('SMS_SENDER','TRCSCI'),
			'route'  	=> env('SMS_ROUTE','4'),
			'authKey'  	=> env('SMS_AUTHKEY','253261A12Hw2jVy2MI5c209ad3'),
			'DLT_TE_ID' => $sms_id,
			'country'	=> $code,
			'mobiles'   => $phone,
			'message'   => $sms_body
		]);
		
		return true;
	}
}

if (! function_exists('getTotalQR')) {
	function getTotalQR($user_id=null)
	{
		$qrs = Code::whereMonth('created_at', Carbon::today()->month);

		if($user_id!=null){
			$qrs->where('user_id',$user_id);
		}

		$totalClone = clone $qrs;
		$activeClone = clone $qrs;
		$inActiveClone = clone $qrs;
		$uploadedTodayClone = clone $qrs;
		$activatedTodayClone = clone $qrs;

		$total = $totalClone->count();
		$active = $activeClone->where('status','1')->count();
		$inactive = $inActiveClone->where('status','0')->count();
		$uploaded_today = $uploadedTodayClone->whereDate('created_at', Carbon::today())->count();
		$activated_today = $activatedTodayClone->where('status','1')->where('batch_id','!=','')->whereDate('updated_at', Carbon::today())->count();

		$result = array(
			"total"=>$total,
			"active"=>$active,
			"inactive"=>$inactive,
			"uploaded_today"=>$uploaded_today,
			"activated_today"=>$activated_today,
		);

		return $result;
	}
}

if (! function_exists('getScansCount')) {
	function getScansCount($time=null)
	{
		$result = [];

		$authority_scans = ScanHistory::leftJoin('codes','codes.id','scan_histories.code_id')->where('scan_histories.scan_count','0');

		
		if($time=='month'){
			$authority_scans->whereMonth('scan_histories.created_at', Carbon::today()->month);	
		}

		$result['authority'] = $authority_scans->count(); 

		$consumer_scans = ScanHistory::leftJoin('codes','codes.id','scan_histories.code_id')->where('scan_histories.scan_count','1');

		if($time=='month'){
			$consumer_scans->whereMonth('scan_histories.created_at', Carbon::today()->month);	
		}

		$result['consumer'] = $consumer_scans->count(); 

		return $result;
	}
}

if (! function_exists('getReportAndAlertCount')) {
	function getReportAndAlertCount($time=null,$status=null)
	{
		$result = [];	

		$reports = Alert::where('type','1');	

		if($time=='month'){
			$reports->whereMonth('created_at', Carbon::today()->month);	
		}

		if($status!=null){
			$reports->where('status', $status);	
		}

		$result['reports'] = $reports->count();

		$alerts = Alert::where('type','0');	

		if($time=='month'){
			$alerts->whereMonth('created_at', Carbon::today()->month);	
		}

		if($status!=null){
			$alerts->where('status', $status);	
		}

		$result['alerts'] = $alerts->count();

		return $result;
	}
}

if (! function_exists('scanLocations')) {
	function scanLocations($user_id=null)
	{
		$result = [];

		$scans = ScanHistory::leftJoin('codes','codes.id','scan_histories.code_id')->where('scan_histories.location','!=','')->whereMonth('scan_histories.created_at', Carbon::today()->month);

		if($user_id!=null){
			$scans->where('codes.user_id',$user_id);
		}

		$scans = $scans->get();

		if(count($scans)>0){

			foreach ($scans as $key => $scan) {
				
				$location = json_decode($scan->location,true);

				if($location['lat'] && $location['long']){
					$result[$key]['user'] = $scan->phone??'User';
					$result[$key]['lat']  = $location['lat'];
					$result[$key]['long'] = $location['long'];
				}	

			}

		}

		return $result;
	}
}

if (! function_exists('codesSeizedThisMonth')) {
	function codesSeizedThisMonth($user_id=null)
	{
		$codes = Code::whereMonth('updated_at', Carbon::today()->month)->where('seized_by','!=','');

		if ($user_id!=null) {
			$codes->where('user_id',$user_id);
		}

		if(Auth::user()->who_you_are=="Province Governor"){
			$codes->whereIn('user_id',getMyProvinceUsers());
		}

		return $codes->count();
	}
}

if (! function_exists('codesSeized')) {
	function codesSeized($user_id=null)
	{
		$codes = Code::where('seized_by','!=','');

		if ($user_id!=null) {
			$codes->where('user_id',$user_id);
		}

		return $codes->count();
	}
}

if (! function_exists('totalScans')) {
	function totalScans($user_id=null,$month=null)
	{
		$codes = ScanHistory::leftJoin('codes','codes.id','scan_histories.code_id');

		if ($user_id!=null) {
			$codes->where('codes.user_id',$user_id);
		}

		if($month!=null && $month=='month'){
			$codes->whereMonth('scan_histories.created_at', Carbon::today()->month);
		}

		return $codes->count();
	}
}

if (! function_exists('totalAlerts')) {
	function totalAlerts($user_id=null)
	{
		$codes = Alert::where('alerts.status','0')->leftJoin('codes','codes.id','alerts.code_id');

		if ($user_id!=null) {
			$codes->where('codes.user_id',$user_id);
		}

		return $codes->count();
	}
}

if (! function_exists('getActivation')) {
	function getActivation($month,$user_id=null)
	{
		$result = [];

		$monthObj = Carbon::now();
		$month =  $monthObj->addMonth($month)->format('F');	
		$date  =  $monthObj->format('m');	

		$codes = Code::where('user_id',$user_id)->where('status','1')->whereMonth('updated_at', $date)->count();

		$result['month'] = $month;
		$result['count'] = $codes;

		return $result;
	}
}

if ( ! function_exists('getOperations')) {
	function getOperations($user_id)
	{
		$operations = User::where('parent_id',$user_id)->where('who_you_are','Operations')->where('status','1')->get();

		return $operations;
	}
}

if ( ! function_exists('countries')) {
	function countries()
	{
		$countries = Country::get();
		return $countries;
	}
}

if ( ! function_exists('currencies')) {
	function currencies()
	{
		$currencies = Country::where('currency','!=',NULL)->get();
		return $currencies;
	}
}

if ( ! function_exists('prepareInvoiceId')) {
	function prepareInvoiceId($invoiceId)
	{
		//IN2200001
		$id = 'IN'.date('y').'0000'.$invoiceId;
		return $id;
	}
}

if ( ! function_exists('prepareSupplyChainScanHistory')) {
	function prepareSupplyChainScanHistory($aggregation_unique_id,$user_id,$history=[])
	{		
		$actions = SupplyChainAction::where('user_id',$user_id)->where('aggregation_unique_id',$aggregation_unique_id)->orderBy('created_at','DESC')->get();

		foreach ($actions as $key => $action) {

			$item = [
				'code'          => $action->aggregation_unique_id,
				'type'          => $action->getAggregation->level,
				'action' 		=> ucfirst($action->action),
				'comment' 		=> $action->comment,
				'status' 		=> $action->status,
				'scanned_by'    => $action->getActionBy->name,
				'scanned_at'    => date('M d, Y h:i a',strtotime($action->created_at)),
				'location'		=> $action->getScan?json_decode($action->getScan->location,true):''	
			];

			if ($action->action_for) {
				$item['action_for'] = $action->getActionFor->name;
			}

			array_push($history, $item);

			if(($key==count($actions)-1) && $action->parent_aggregation_unique_id!=NULL){
				$history = prepareSupplyChainScanHistory($action->parent_aggregation_unique_id,$user_id,$history);
			}
		}		

		if(empty($history)){
			$aggregation = Aggregation::where('unique_id',$aggregation_unique_id)->where('user_id',$user_id)->first();
			if($aggregation->getParent){
				$history = prepareSupplyChainScanHistory($aggregation->getParent->unique_id,$user_id,$history);
			}
		}

		return $history;
	}
}

if ( ! function_exists('insertLabelOrderLogs'))
{
	function insertLabelOrderLogs($reference,$initial_status=null,$current_status=null,$remarks=null,$updated_by=null) {
		$log = new LabelOrderLog;
		$log->reference 		= $reference;
		$log->initial_status 	= $initial_status;
		$log->current_status 	= $current_status;
		$log->remarks 			= $remarks;
		$log->updated_by 		= $updated_by;
		$log->save();
		return true;
	}
}

if (! function_exists('getTotalCodes')) {
	function getTotalCodes($order_id)
	{
		$count = Code::where('order_id',$order_id)->count();	
		return $count;
	}
}

if (! function_exists('inFurtherAction')) {
	function inFurtherAction($status)
	{
		$result = LabelOrderStatus::where('code',$status)->where('further_action',true)->exists();

		return $result;
	}
}

if (! function_exists('statusComnination')) {
	function statusComnination($order)
	{
		$result = LabelOrderStatus::where('id','>',0);

		$last_log = LabelOrderLog::where('reference',$order->id)->orderBy('created_at','DESC')->first();

		$last_status = LabelOrderStatus::where('title',$last_log->initial_status)->first();

		switch($order->dispatch_status){
			case 7:
			$result->where('code','>',$last_status->code)->orWhere('title','Delayed');
			break;

			default:
			$result->where('code','>',$order->dispatch_status);
			break;
		}

		$array = $result->get();

		return $array;
	}
}

function getCouponCode() {
	$code = Str::random(6);

	if (checkCouponCodeExists($code)) {
		return getCouponCode();
	}

	return $code;
}

if (! function_exists('checkCouponCodeExists')) {
	function checkCouponCodeExists($code)
	{
		return CouponCode::where('coupon_code',$code)->exists();
	}
}

if (! function_exists('getWalletBalance')) {
	function getWalletBalance($user_id, $brand=null)
	{
		$credit_q = Wallet::where('type','credit')->where('user_id',$user_id)->where('status','Success');
		$debit_q = Wallet::where('type','debit')->where('user_id',$user_id)->where('status','Success');

		if ($brand!=null) {
			$credit_q->where('brand',$brand);
			$debit_q->where('brand',$brand);
		}

		$credit = $credit_q->sum('points');
		$debit = $debit_q->sum('points');

		$balance = $credit-$debit;

		return $balance>0?$balance:0;
	}
}

if (! function_exists('codeDataRewardScheme')) {
	function codeDataRewardScheme($code_data)
	{
		$reward_scheme = NULL;
		$code = Code::where('code_data',$code_data)->first();
		$coupon = CouponCode::where('code_id',$code->id)->first();

		if ($coupon) {
			$reward_scheme = RewardScheme::where('id',$coupon->reward_id)->where('status','Active')->first();
		}

		return $reward_scheme;
	}
}

if (! function_exists('createRazorpayXPayout')) {
	function createRazorpayXPayout($upi_id,$amount)
	{
		$data = [
			"account_number"=> env('RAZORPAYX_ACCOUNT_NUMBER'),
			"amount"=> round($amount*100,2),
			"currency"=> "INR",
			"mode"=> "UPI",
			"queue_if_low_balance"=> true,
			"purpose"=>"cashback",
			"fund_account"=> [
				"account_type"=> "vpa",
				"vpa"=> [
					"address"=> $upi_id
				],
				"contact"=> [
					"name"=> "Tracesci"
				]
			]
		];

		$response = Http::withBasicAuth(
			env('RAZORPAYX_KEY_ID'),env('RAZORPAYX_KEY_SECRET')
		)->post(env('RAZORPAYX_BASE_URL').'/payouts', $data);

		$body = json_decode($response->body(),true);

		$result = [];

		if ($response->failed()) {
			$result = [
				'success' => false,
				'message' => 'Invalid input given. Please check your upi id.'
			];
		}else{
			$result = [
				'success' => true,
				'message' => 'We have reached the request.',
				'body'	  => $body
			];
		}

		return $result;
	}
}

if (! function_exists('getWalletHistory')) {
	function getWalletHistory($user_id, $brand=null)
	{
		$wallets = Wallet::where('user_id',$user_id);
		if ($brand!=null) {
			$wallets->where('brand',$brand);
		}
		return $wallets->get();
	}
}

if (! function_exists('getWalletData')) {
	function getWalletData($user_id, $brand=null)
	{
		$credit_q = Wallet::where('type','credit')->where('user_id',$user_id)->where('status','Success');
		$debit_q = Wallet::where('type','debit')->where('user_id',$user_id)->where('status','Success');

		if ($brand!=null) {
			$credit_q->where('brand',$brand);
			$debit_q->where('brand',$brand);
		}

		$credit = $credit_q->sum('points');
		$debit = $debit_q->sum('points');

		$balance = $credit-$debit;

		return [
			'credit' => $credit,
			'debit'  => $debit,
			'balance' => $balance,
		];
	}
}
if (! function_exists('updatedbleOrderStatuses')) {
	function updatedbleOrderStatuses($status) 
	{	
		if($status=='Preparing Order'){
			return [
				'Preparing Order',
				'Ready to Ship'
			];
		}

		if($status=='Ready to Ship'){
			return [
				'Ready to Ship',
				'Shipped'
			];
		}

		if($status=='Shipped'){
			return [
				'Shipped',
				'Delivered'
			];
		}

		if($status=='Delivered'){
			return [
				
			];
		}

		return [
			'Preparing Order',
			'Ready to Ship',
			'Shipped',
			'Delivered'
		];
	}
}

if (! function_exists('updateOrderHistory')){
	function updateOrderHistory($input){
		
		$history = [];
		
		$order = RewardOrder::find($input['order_id']);

		if($order->history){
			$history = json_decode($order->history,true);
		}

		$item = [
			'message' => $input['message'],
			'date'    => date('M d, Y h:i')
		];

		array_push($history,$item);
		$order->history = json_encode($history);
		$order->save();
		return $order;

	}
}

?>