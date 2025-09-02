<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\ForgotPassword;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\OtpRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Company;
use App\Models\Country;
use App\Models\Document;
use App\Models\Sms;
use App\Models\User;
use Carbon\Carbon;
use EmailProvider;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loginView()
    {
        return view('login/main', [
            'layout' => 'login'
        ]);
    }

    public function registerView()
    {   
        $countries = Country::get();
        return view('login/register', [
            'layout'    =>  'login',
            'countries' =>  $countries
        ]);
    }

    /**
     * Authenticate login user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {

        $message = 'Login successful. Please wait we are boarding you to the dashboard.';
        $status  = 'success';
        $status_code = 200;

        $user = User::where('email',$request->email_or_phone)->orWhere('phone',$request->email_or_phone)->first();

        if(!$user){
            $message = 'We could not found any account with these creadentials.';
            return response(['message'=>$message,'status'=>'failed','errors'=>['email_or_phone'=>$message]],400);
        }

        if($user->status!='1'){
            $message = 'Your account approval is in progress. Please try again after sometime.';
            $status  = 'failed';
            $status_code = 400;
        }else{
            if (!\Auth::attempt([
                'email' => $request->email_or_phone, 
                'password' => $request->password
            ]) && !\Auth::attempt([
                'phone' => $request->email_or_phone, 
                'password' => $request->password
            ])){
                $message = 'Incorrect username or password.';
                $status  = 'failed';
                $status_code = 400;
            }
        }

        $url = route('vendor');

        if($user->type == '1'){
            $url = route('admin');
        }

        if($user->type == '2' && $user->who_you_are=='Brand User'){
            $url = url('vendor/scanhistory');
        }

        return response(['message'=>$message,'status'=>$status,'url'=>$url],$status_code);

    }

    public function register(RegisterRequest $request)
    {   

        try{
            $input = $request->all();  

            if(Session::has('user')){
                Session::forget('user');
            }

            $user  = [];
            $user = $input;
            Session::put('user',$user);

            $registration = User::where('email',$input['email'])->orWhere('phone',$input['mobile'])->first();

            if(!$registration){
                $registration = new User;    
            }
            
            $registration->email   = $input['email'];
            $registration->type    = '2';
            $registration->status  = '2';
            $registration->name    = $input['name'];
            $registration->phone_code  = $input['country_code']??'91';
            $registration->phone   = $input['mobile'];
            $registration->save();


            return response(['message'=>'Please follow next step.'], 201);
        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }


    }

    public function companyView()
    {
        if(Session::has('user') && Session::get('user')!=''){
            return view('login.company')->with('user',Session::get('user'))->with('layout','login');
        }else{
            return redirect('/register');
        }
    }

    public function company(CompanyRequest $request)
    {
        try{
            $input = $request->all();
            $user  = Session::get('user');

            if ($request->hasFile('identity_proof')) {
                $file = $request->file('identity_proof');
                $input['identity_proof'] = $this->getFilePath($file);
            }

            if ($request->hasFile('registration_certificate')) {
                $file = $request->file('registration_certificate');
                $input['registration_certificate'] = $this->getFilePath($file);
            }

            if ($request->hasFile('gst_or_vat_certificate')) {
                $file = $request->file('gst_or_vat_certificate');
                $input['gst_or_vat_certificate'] = $this->getFilePath($file);
            }

            $user['otp']     =  mt_rand(1000, 9999);
            $user['company'] = $input;

            Session::put('user',$user);

            $code = $user['country_code'];
            $mobile = $user['mobile'];

            Sms::sendSms('TRCOTP', 
                [   
                    'otp' => $user['otp'],
                    'username' => $user['name'],
                    'phone' => $mobile,
                    'code' => $code,
                ]
            );

            EmailProvider::sendMail('user-otp-email', 
                [   
                    'otp' => $user['otp'],
                    'username' => $user['name'],
                    'email' => $user['email']
                ]
            );

            return response(['message'=>'Please follow next step.'], 201);
        }catch(Exception $e){
            $message = 'Something went wrong. Please try again.';
            return response(['message'=>$message], 503);
        }   
    }

    public function otpView()
    {   
        if(Session::has('user') && Session::get('user')!=''){
            return view('login.otp')->with('user',Session::get('user'))->with('layout','login');
        }else{
            return redirect('/register');
        }
    }

    public function otp(OtpRequest $request){
        $input = $request->all();
        $session  = Session::get('user');

        if(!isset($session['otp']) || $input['otp']!=$session['otp']){
            return response([
                'success'=> false,
                'message'=> 'Invalid otp',
                'errors' => ['otp'=>['Invalid otp. Please enter valid otp']]
            ],400);
        }

        // $user = User::where('email',$session['email'])->first();

        // if($user){
        //     return response([
        //         'success'=> true,
        //         'message'=> 'You are successfully registered. We are verifying your details.'
        //     ],200);
        // }

        $user = User::where('email',$session['email'])->orWhere('phone',$session['mobile'])->first();

        if(!$user){
            $user = new User;    
        }

        $user->email = $session['email'];
        $user->username = $session['email'];
        $user->password = bcrypt('company1234');
        $user->type  = '2';
        $user->status  = '0';
        $user->name  = $session['name'];
        $user->phone_code  = $session['country_code']??'91';
        $user->phone  = $session['mobile'];
        $user->address_one  = $session['company']['company_address'];
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();

        $user->save();

        if($user){
            $company = new Company;
            $company->user_id = $user->id;
            $company->name    = $session['company']['company_name']??'';
            $company->address = $session['company']['company_address']??'';
            $company->city    = $session['company']['company_city']??'';
            $company->country = $session['company']['company_country']??'';
            $company->gst     = $session['company']['tax_registration_number']??'';
            $company->created_at = Carbon::now();
            $company->updated_at = Carbon::now();
            $company->save();

            if (isset($session['company']['gst_or_vat_certificate'])) {
                $add_doc = $this->attachDocumentByUrl('Company GST','company_gst',$user->id,$session['company']['gst_or_vat_certificate']);
            }

            if (isset($session['company']['identity_proof'])) {
                $add_doc = $this->attachDocumentByUrl('Self KYC','self_kyc',$user->id,$session['company']['identity_proof']);
            }

            if (isset($session['company']['registration_certificate'])) {
                $add_doc = $this->attachDocumentByUrl('Company ROC','company_roc',$user->id,$session['company']['registration_certificate']);
            }

        }

        Sms::sendSms('TRCWelcome', 
            [   
                'username' => $user->name??'User',
                'phone' => $user->phone,
                'code' => $user->phone_code??'91'
            ]
        );

        EmailProvider::sendMail('user-welcome-email', 
            [   
                'username' => $user->name,
                'email' => $user->email
            ]
        );

        EmailProvider::sendMail('admin-user-registration-request', 
            [   
                'name' => $user->name,
                'username' => $user->name,
                'email' => env('MAIL_FROM_ADDRESS', 'jetsciglobal@gmail.com'),
                'phone' => $user->phone,
                'company' => $session['company']['company_name']??'',
                'plan' => '-',
                'amount' => '-',
            ]
        );

        return response([
            'success'=> true,
            'message'=> 'You are successfully registered. We are verifying your details.'
        ],200);
    }

    public function success()
    {
        if(Session::has('user') && Session::get('user')!=''){
            Session::forget('user');
            return view('login.success')->with('user',Session::get('user'))->with('layout','login');
        }else{
            return redirect('/register');
        }
    }    

    public function getFilePath($file)
    {
        $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
        $name = $timestamp . '-' . uniqid() . '-' . str_replace([' ', ':'], '-', $file->getClientOriginalName());

        Storage::putFileAs('public/documents', $file, $name);
        $path = Storage::url('documents/'.$name);

        return $path;

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

    public function attachDocumentByUrl($docname,$type,$user_id,$url)
    {

        $document = new Document;
        $document->name = $docname;
        $document->type = $type;
        $document->user_id = $user_id;
        $document->doc_url = $url;
        $document->save();
        return true;

    }

    public function forgotPasswordView()
    {
        return view('login/password', [
            'layout' => 'login'
        ]);
    }

    public function forgotPassword(ForgotPassword $request)
    {

        $message = 'Password is sent to your registered email.';
        $status  = 'success';
        $status_code = 200;

        $user = User::where('email',$request->email)->first();

        if($user->status!='1' || $user->active!='1'){
            $message = 'Your account approval is in progress. Please try again after sometime.';
            $status  = 'failed';
            $status_code = 400;
        }else{
            $password = Str::random(6);

            Sms::sendSms('TRCtemppassword', 
                [   
                    'username' => $user->name??'User',
                    'phone' => $user->phone,
                    'code' => $user->phone_code??'91',
                    'password' => $password,
                ]
            );

            EmailProvider::sendMail('user-forgot-password', 
                [   
                    'username' => $user->name,
                    'email' => $user->email,
                    'password' => $password, 
                ]
            );

            $user->password = bcrypt($password);
            $user->save();
        }

        return response(['message'=>$message,'status'=>$status],$status_code);

    }

    /**
     * Logout user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        \Auth::logout();
        return redirect('login');
    }
}
