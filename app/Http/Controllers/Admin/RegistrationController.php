<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RegistrationCreateRequest;
use App\Http\Requests\Admin\RegistrationUpdateRequest;
use App\Models\Company;
use App\Models\Credit;
use App\Models\Document;
use App\Models\Plan;
use App\Models\Sms;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use EmailProvider;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Str;

class RegistrationController extends Controller
{
    public function status($status){
        switch($status){
            case '1':
            $result = 'Active';
            break;
            case '0':
            $result = 'Inactive';
            break;
            default:
            $result = 'Pending';
        }

        return $result;

    }

    public function assertion($assert){
        switch($assert){
            case '1':
            $result = 'Yes';
            break;
            case '0':
            $result = 'No';
            break;
            default:
            $result = 'No';
        }

        return $result;
    }

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

            $response       = User::getManufacturerModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value,$start_date,$end_date);

            if(!$response){
                $users      = [];
                $last_page  = 0;
                $total = 0;
            }
            else{
                $users      = $response['response'];
                $last_page  = $response['last_page'];
                $total  = $response['total'];
            }

            $userData = array();
            $i = 1;

            foreach ($users as $user) {

                $u['name']          = $user->name;
                $u['email']         = $user->email??'-';
                $u['phone']         = $user->phone??'-';
                $u['status']        = $this->status($user->status);
                $u['active']        = $this->assertion($user->active);
                $u['company']       = $user->getCompany?$user->getCompany->name:'';

                $actions            = view('admin.registrations.actions',['user' => $user]);
                $u['actions']       = $actions->render(); 

                $u['company']       = $user->getCompany?$user->getCompany->name:'';
                $u['tax_number']    = $user->getCompany?$user->getCompany->gst:'';
                $u['city']          = $user->getCompany?$user->getCompany->city:'';
                $u['country']       = $user->getCompany?$user->getCompany->country:'';
                $u['created_at']    = date('M d, Y',strtotime($user->created_at));

                $userData[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                "last_page"         =>  $last_page,
                "data"              =>  $userData,
                "total"             =>  $total
            ];
            
            return $return;
        }
        
        return view('admin.registrations.index');
    }

    public function create()
    {
        $plans = Plan::where('parent_id',null)->get();
        return view('admin.registrations.create')->with('plans',$plans); 
    }

    public function edit($id)
    {   
        $id = decrypt($id);
        $user = User::find($id);
        $plans = Plan::where('parent_id',null)->get();
        return view('admin.registrations.edit')->with('plans',$plans)->with('user',$user)->with('page_name', 'admin-users');
    }

    public function store(RegistrationCreateRequest $request)
    {
        try{
            $input = $request->all();

            $user = new User;
            $user->email = $input['email'];
            $user->username = $input['email'];
            $password = Str::random(6);
            $user->password = bcrypt($password);
            $user->type  = '2';
            $user->name  = $input['name'];
            $user->status  = $input['allow_login'];
            $user->phone_code  = $input['phone_code']??'91';
            $user->phone  = $input['mobile'];
            $user->address_one  = $input['company_address'];
            $user->created_at = Carbon::now();
            $user->updated_at = Carbon::now();

            $user->save();

            if($user){
                $company = new Company;
                $company->user_id = $user->id;
                $company->name    = $input['company_name'];
                $company->address = $input['company_address'];
                $company->city = $input['city'];
                $company->country = $input['country'];
                $company->gst = $input['tax_registration_number'];
                $company->save();

                if ($request->hasFile('company_gst')) {
                    $file = $request->file('company_gst');
                    $add_doc = $this->attachDocument('Company GST','company_gst',$user->id,$file);
                }

                if ($request->hasFile('self_kyc')) {
                    $file = $request->file('self_kyc');
                    $add_doc = $this->attachDocument('Self KYC','self_kyc',$user->id,$file);
                }

                if ($request->hasFile('company_roc')) {
                    $file = $request->file('company_roc');
                    $add_doc = $this->attachDocument('Company ROC','company_roc',$user->id,$file);
                }


                if(isset($input['default_approve']) && $input['default_approve']=='on'){
                    $user->active = '1';
                    $user->save();

                    $approve_docs = Document::where('user_id',$user->id)->update(['status'=>'1']);
                }

            }

            if (isset($input['default_plan']) && $input['default_plan']!='') {
                $find_in_subscription = Subscription::where('user_id',$user->id)->where('plan_id',$input['default_plan'])->first();

                if(!$find_in_subscription){
                    $plan = Plan::find($input['default_plan']);
                    $subscribe = new Subscription;
                    $subscribe->user_id = $user->id;
                    $subscribe->plan_id = $plan->id;
                    $subscribe->plan_name = $plan->title;
                    $subscribe->credits = $plan->credits;
                    $subscribe->status = '1';
                    $subscribe->start_date = Carbon::now();
                    $subscribe->save();

                    $credit = new Credit;
                    $credit->amount  = $plan->price_inr;
                    $credit->credits = $plan->credits;
                    $credit->type    = '0';
                    $credit->plan_id = $plan->id;
                    $credit->user_id = $user->id;
                    $credit->plan_name = $plan->title;
                    $credit->status = '1';
                    $credit->save();

                }
            }

            if($user->phone){
                Sms::sendSms('TRCLogin', 
                    [   
                        'username' => $user->name??'User',
                        'phone' => $user->phone,
                        'code' => $user->phone_code??'91',
                        'email' => $user->email,
                        'password' => $password
                    ]
                );
            }

            if($user->email){

                EmailProvider::sendMail('user-credential-email',
                    [   
                        'username' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'password' => $password
                    ]
                );

            }

            return response(['message'=>'Registration created successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function attachDocument($docname,$type,$user_id,$file)
    {
        $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
        $name = $timestamp . '-' . uniqid() . '-' . str_replace([' ', ':'], '-', $file->getClientOriginalName());

        Storage::putFileAs('public/documents', $file, $name);
        $path = Storage::url('documents/'.$name);

        $document = new Document;
        $document->name = $docname;
        $document->type = $type;
        $document->user_id = $user_id;
        $document->doc_url = $path;
        $document->save();

        return true;

    }

    public function update(RegistrationUpdateRequest $request, $id)
    {
        try{
            $id = decrypt($id);
            $input = $request->all();

            $user = User::find($id);

            $oldactive = $user->status;

            if($user){
                $user->email = $input['email'];
                $user->username = $input['email'];
                $user->name  = $input['name'];
                $user->status  = $input['allow_login'];
                $user->phone_code  = $input['phone_code']??'91';
                $user->phone  = $input['mobile'];
                $user->address_one  = $input['company_address'];
                $user->updated_at = Carbon::now();

                $user->save();
            }

            $company = Company::where('user_id',$id)->first();

            if($company){
                $company->name    = $input['company_name'];
                $company->address = $input['company_address'];
                $company->city = $input['city'];
                $company->country = $input['country'];
                $company->gst = $input['tax_registration_number'];
                $company->save();
            }

            if ($request->hasFile('company_gst')) {
                $file = $request->file('company_gst');

                $doc = Document::where('user_id',$id)->where('type','company_gst')->first();

                if($doc){
                    File::delete(public_path() .$doc->doc_url);
                    $doc->delete();
                }

                $add_doc = $this->attachDocument('Company GST','company_gst',$user->id,$file);
            }

            if ($request->hasFile('self_kyc')) {
                $file = $request->file('self_kyc');

                $doc = Document::where('user_id',$id)->where('type','self_kyc')->first();

                if($doc){
                    File::delete(public_path() .$doc->doc_url);
                    $doc->delete();
                }

                $add_doc = $this->attachDocument('Self KYC','self_kyc',$user->id,$file);
            }

            if ($request->hasFile('company_roc')) {
                $file = $request->file('company_roc');
                $doc = Document::where('user_id',$id)->where('type','company_roc')->first();

                if($doc){
                    File::delete(public_path() .$doc->doc_url);
                    $doc->delete();
                }
                
                $add_doc = $this->attachDocument('Company ROC','company_roc',$user->id,$file);
            }

            if(isset($input['approve_company_gst']) && $input['approve_company_gst']=='on'){
                $status = Document::where('user_id',$id)->where('type','company_gst')->update(['status'=>'1']);
            }else{
                $status = Document::where('user_id',$id)->where('type','company_gst')->update(['status'=>'0']);
            }

            if(isset($input['approve_company_roc']) && $input['approve_company_roc']=='on'){
                $status = Document::where('user_id',$id)->where('type','company_roc')->update(['status'=>'1']);
            }else{
                $status = Document::where('user_id',$id)->where('type','company_roc')->update(['status'=>'0']);
            }

            if(isset($input['approve_self_kyc']) && $input['approve_self_kyc']=='on'){
                $status = Document::where('user_id',$id)->where('type','self_kyc')->update(['status'=>'1']);
            }else{
                $status = Document::where('user_id',$id)->where('type','self_kyc')->update(['status'=>'0']);
            }

            $user->active = '1';

            $docs  = Document::where('user_id',$id);

            $count = $docs->count();
            $inactive_doc = $docs->where('status','0')->first();

            if($count<=0 || $inactive_doc){
                $user->active = '0';
            }

            $user->save();

            if (isset($input['default_plan']) && $input['default_plan']!='') {
                $find_in_subscription = Subscription::where('user_id',$user->id)->where('plan_id',$input['default_plan'])->first();

                if(!$find_in_subscription){
                    $delete_other_subscription = Subscription::where('user_id',$user->id)->delete();

                    $plan = Plan::find($input['default_plan']);
                    $subscribe = new Subscription;
                    $subscribe->user_id = $user->id;
                    $subscribe->plan_id = $plan->id;
                    $subscribe->plan_name = $plan->title;
                    $subscribe->credits = $plan->credits;
                    $subscribe->status = '1';
                    $subscribe->start_date = Carbon::now();
                    $subscribe->save();

                    $credit = new Credit;
                    $credit->amount  = $plan->price_inr;
                    $credit->credits = $plan->credits;
                    $credit->type    = '0';
                    $credit->plan_id = $plan->id;
                    $credit->user_id = $user->id;
                    $credit->plan_name = $plan->title;
                    $credit->status = '1';
                    $credit->save();
                }
            }

            if($oldactive=='0' && $user->status=='1'){
                EmailProvider::sendMail('user-profile-approval', 
                    [   
                        'username' => $user->name,
                        'email' => $user->email
                    ]
                );
            }

            if($oldactive=='0' && $user->status=='0'){
                EmailProvider::sendMail('user-profile-rejection', 
                    [   
                        'username' => $user->name,
                        'email' => $user->email
                    ]
                );
            }



            return response(['message'=>'Company registration has been updated successfully.'], 200);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

}
