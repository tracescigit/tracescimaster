<?php

namespace App\Http\Controllers;

use App\CustomClasses\EmailProvider;
use App\CustomClasses\SandEmail;
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
use Illuminate\Support\Facades\Log;
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

        $user = User::where('email', $request->email_or_phone)->orWhere('phone', $request->email_or_phone)->first();

        if (!$user) {
            $message = 'We could not found any account with these creadentials.';
            return response(['message' => $message, 'status' => 'failed', 'errors' => ['email_or_phone' => $message]], 400);
        }

        if ($user->status != '1') {
            $message = 'Your account approval is in progress. Please try again after sometime.';
            $status  = 'failed';
            $status_code = 400;
        } else {
            if (!\Auth::attempt([
                'email' => $request->email_or_phone,
                'password' => $request->password
            ]) && !\Auth::attempt([
                'phone' => $request->email_or_phone,
                'password' => $request->password
            ])) {
                $message = 'Incorrect username or password.';
                $status  = 'failed';
                $status_code = 400;
            }
        }

        $url = route('vendor');

        if ($user->type == '1') {
            $url = route('admin');
        }

        if ($user->type == '2' && $user->who_you_are == 'Brand User') {
            $url = url('vendor/scanhistory');
        }

        return response(['message' => $message, 'status' => $status, 'url' => $url], $status_code);
    }

    public function register(RegisterRequest $request)
    {

        try {
            $input = $request->all();

            if (Session::has('user')) {
                Session::forget('user');
            }

            $user  = [];
            $user = $input;
            Session::put('user', $user);

            $registration = User::where('email', $input['email'])->orWhere('phone', $input['mobile'])->first();

            if (!$registration) {
                $registration = new User;
            }

            $registration->email   = $input['email'];
            $registration->type    = '2';
            $registration->status  = '2';
            $registration->name    = $input['name'];
            $registration->phone_code  = $input['country_code'] ?? '91';
            $registration->phone   = $input['mobile'];
            $registration->save();


            return response(['message' => 'Please follow next step.'], 201);
        } catch (Exception $e) {
            return response(['message' => 'Something went wrong.'], 503);
        }
    }

    public function companyView()
    {
        if (Session::has('user') && Session::get('user') != '') {
            return view('login.company')->with('user', Session::get('user'))->with('layout', 'login');
        } else {
            return redirect('/register');
        }
    }

    public function company(CompanyRequest $request)
    {


        try {
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

            Session::put('user', $user);

            $code = $user['country_code'];
            $mobile = $user['mobile'];

            Sms::sendSms(
                'TRCOTP',
                [
                    'otp' => $user['otp'],
                    'username' => $user['name'],
                    'phone' => $mobile,
                    'code' => $code,
                ]
            );

            try {

                $mail_array = [];
                $mail_array['email_subject'] = 'Your Tracesci Verification OTP';
                $mail_array['email'] = $user['email'];

                $mail_array['email_body'] = '
        <p>Dear <strong>' . $user['name'] . '</strong>,</p>

        <p>Thank you for registering with <strong>Tracesci</strong>.</p>

        <p>Please use the following One-Time Password (OTP) to verify your email address:</p>

        <div style="margin:20px 0;padding:15px;background:#f4f4f4;border:1px solid #ddd;text-align:center;font-size:28px;font-weight:bold;letter-spacing:5px;">
            ' . $user['otp'] . '
        </div>

        <p>This OTP is valid for a limited time. Please do not share it with anyone for security reasons.</p>

        <p>If you did not request this verification, you may safely ignore this email.</p>

        <p>Regards,<br>
        <strong>Tracesci Team</strong></p>';

                Log::info('User OTP Mail Data', $mail_array);

                $result = SandEmail::sendDirectMail($mail_array);

                Log::info('User OTP Mail Result', [
                    'result' => $result
                ]);
            } catch (\Throwable $e) {

                Log::error('User OTP Mail Failed', [
                    'message' => $e->getMessage(),
                    'line'    => $e->getLine(),
                    'file'    => $e->getFile(),
                ]);
            }
            return response(['message' => 'Please follow next step.'], 201);
        } catch (Exception $e) {
            $message = 'Something went wrong. Please try again.';
            return response(['message' => $message], 503);
        }
    }

    public function otpView()
    {
        if (Session::has('user') && Session::get('user') != '') {
            return view('login.otp')->with('user', Session::get('user'))->with('layout', 'login');
        } else {
            return redirect('/register');
        }
    }

    public function otp(OtpRequest $request)
    {
        $input = $request->all();
        $session  = Session::get('user');

        if (!isset($session['otp']) || $input['otp'] != $session['otp']) {
            return response([
                'success' => false,
                'message' => 'Invalid otp',
                'errors' => ['otp' => ['Invalid otp. Please enter valid otp']]
            ], 400);
        }

        // $user = User::where('email',$session['email'])->first();

        // if($user){
        //     return response([
        //         'success'=> true,
        //         'message'=> 'You are successfully registered. We are verifying your details.'
        //     ],200);
        // }

        $user = User::where('email', $session['email'])->orWhere('phone', $session['mobile'])->first();

        if (!$user) {
            $user = new User;
        }

        $user->email = $session['email'];
        $user->username = $session['email'];
        $user->password = bcrypt('company1234');
        $user->type  = '2';
        $user->status  = '0';
        $user->name  = $session['name'];
        $user->phone_code  = $session['country_code'] ?? '91';
        $user->phone  = $session['mobile'];
        $user->address_one  = $session['company']['company_address'];
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();

        $user->save();

        if ($user) {
            $company = new Company;
            $company->user_id = $user->id;
            $company->name    = $session['company']['company_name'] ?? '';
            $company->address = $session['company']['company_address'] ?? '';
            $company->city    = $session['company']['company_city'] ?? '';
            $company->country = $session['company']['company_country'] ?? '';
            $company->gst     = $session['company']['tax_registration_number'] ?? '';
            $company->created_at = Carbon::now();
            $company->updated_at = Carbon::now();
            $company->save();

            if (isset($session['company']['gst_or_vat_certificate'])) {
                $add_doc = $this->attachDocumentByUrl('Company GST', 'company_gst', $user->id, $session['company']['gst_or_vat_certificate']);
            }

            if (isset($session['company']['identity_proof'])) {
                $add_doc = $this->attachDocumentByUrl('Self KYC', 'self_kyc', $user->id, $session['company']['identity_proof']);
            }

            if (isset($session['company']['registration_certificate'])) {
                $add_doc = $this->attachDocumentByUrl('Company ROC', 'company_roc', $user->id, $session['company']['registration_certificate']);
            }
        }

        Sms::sendSms(
            'TRCWelcome',
            [
                'username' => $user->name ?? 'User',
                'phone' => $user->phone,
                'code' => $user->phone_code ?? '91'
            ]
        );
        try {

            $mail_array = [];
            $mail_array['email_subject'] = 'Welcome to Tracesci';
            $mail_array['email'] = $user->email;

            $mail_array['email_body'] = '
        <p>Dear <strong>' . $user->name . '</strong>,</p>

        <p>Welcome to <strong>Tracesci</strong>! Your account has been successfully created.</p>

        <p>Your registered account details are:</p>

        <table border="0" cellpadding="5">
            <tr>
                <td><strong>Name</strong></td>
                <td>' . $user->name . '</td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td>' . $user->email . '</td>
            </tr>
        </table>

        <p>You can now log in and start using the Tracesci platform.</p>

        <p>If you did not create this account, please contact our support team immediately.</p>

        <p>Regards,<br>
        <strong>Tracesci Team</strong></p>';

            Log::info('User Welcome Mail Data', $mail_array);

            $result = SandEmail::sendDirectMail($mail_array);

            Log::info('User Welcome Mail Result', [
                'result' => $result
            ]);
        } catch (\Throwable $e) {

            Log::error('User Welcome Mail Failed', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ]);
        }

        try {

            $mail_array = [];
            $mail_array['email_subject'] = 'New User Registration';
            $mail_array['email'] = env('MAIL_FROM_ADDRESS', 'wecare@Tracesci.in');
            $mail_array['bcc'] = 'kunal.kothari@monotech.in';

            $mail_array['email_body'] = '
        <p>Dear Team,</p>

        <p>A new user has successfully registered on the <strong>Tracesci</strong> platform.</p>

        <table border="0" cellpadding="5">
            <tr>
                <td><strong>Name</strong></td>
                <td>' . $user->name . '</td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td>' . $user->email . '</td>
            </tr>
            <tr>
                <td><strong>Phone</strong></td>
                <td>' . ($user->phone ?? '-') . '</td>
            </tr>
            <tr>
                <td><strong>Company</strong></td>
                <td>' . ($session['company']['company_name'] ?? '-') . '</td>
            </tr>
            <tr>
                <td><strong>Plan</strong></td>
                <td>-</td>
            </tr>
            <tr>
                <td><strong>Amount</strong></td>
                <td>-</td>
            </tr>
        </table>

        <p>Please review the above registration details for your records.</p>

        <p>Regards,<br>
        <strong>Tracesci System</strong></p>';

            Log::info('Admin Registration Mail Data', $mail_array);

            $result = SandEmail::sendDirectMail($mail_array);

            Log::info('Admin Registration Mail Result', [
                'result' => $result
            ]);
        } catch (\Throwable $e) {

            Log::error('Admin Registration Mail Failed', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ]);
        }

        return response([
            'success' => true,
            'message' => 'You are successfully registered. We are verifying your details.'
        ], 200);
    }

    public function success()
    {
        if (Session::has('user') && Session::get('user') != '') {
            Session::forget('user');
            return view('login.success')->with('user', Session::get('user'))->with('layout', 'login');
        } else {
            return redirect('/register');
        }
    }

    public function getFilePath($file)
    {
        $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
        $name = $timestamp . '-' . uniqid() . '-' . str_replace([' ', ':'], '-', $file->getClientOriginalName());

        Storage::putFileAs('public/documents', $file, $name);
        $path = Storage::url('documents/' . $name);

        return $path;
    }

    public function attachDocument($docname, $type, $user_id, $file)
    {
        $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
        $name = $timestamp . '-' . uniqid() . '-' . str_replace([' ', ':'], '-', $file->getClientOriginalName());

        Storage::putFileAs('public/documents', $file, $name);
        $path = Storage::url('documents/' . $name);

        $document = new Document;
        $document->name = $docname;
        $document->type = $type;
        $document->user_id = $user_id;
        $document->doc_url = $path;
        $document->save();

        return true;
    }

    public function attachDocumentByUrl($docname, $type, $user_id, $url)
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

        $user = User::where('email', $request->email)->first();

        if ($user->status != '1' || $user->active != '1') {
            $message = 'Your account approval is in progress. Please try again after sometime.';
            $status  = 'failed';
            $status_code = 400;
        } else {
            $password = Str::random(6);

            Sms::sendSms(
                'TRCtemppassword',
                [
                    'username' => $user->name ?? 'User',
                    'phone' => $user->phone,
                    'code' => $user->phone_code ?? '91',
                    'password' => $password,
                ]
            );

            try {

                $mail_array = [];
                $mail_array['email_subject'] = 'Tracesci Support: Temporary Password';
                $mail_array['email'] = $user->email;

                $mail_array['email_body'] = '
        <p>Dear <strong>' . $user->name . '</strong>,</p>

        <p>Your password has been reset successfully as per your request.</p>

        <p>Your updated login credentials are as follows:</p>

        <table border="0" cellpadding="5">
            <tr>
                <td><strong>Email</strong></td>
                <td>' . $user->email . '</td>
            </tr>
            <tr>
                <td><strong>Temporary Password</strong></td>
                <td>' . $password . '</td>
            </tr>
        </table>

        <p>For security reasons, we strongly recommend that you log in and change your password immediately after signing in.</p>

        <p>If you did not request this password reset, please contact our support team immediately.</p>

        <p>Regards,<br>
        <strong>Tracesci Team</strong></p>';

                Log::info('Forgot Password Mail Data', $mail_array);

                $result = SandEmail::sendDirectMail($mail_array);

                Log::info('Forgot Password Mail Result', [
                    'result' => $result
                ]);
            } catch (\Throwable $e) {

                Log::error('Forgot Password Mail Failed', [
                    'message' => $e->getMessage(),
                    'line'    => $e->getLine(),
                    'file'    => $e->getFile(),
                ]);
            }

            $user->password = bcrypt($password);
            $user->save();
        }

        return response(['message' => $message, 'status' => $status], $status_code);
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
