<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
    const DEV_OTP = '1234';

    const OTP_TTL_MINUTES = 10;

    public function consumerRequestOtp(Request $request)
    {
        $this->validateInput($request, [
            'phone_code' => 'required|regex:/^[0-9]+$/|max:5',
            'phone'      => 'required|regex:/^[0-9]+$/|min:8|max:15',
        ]);

        $phoneCode = $request->input('phone_code');
        $phone     = $request->input('phone');

        $user = User::where('phone_code', $phoneCode)->where('phone', $phone)->first();

        $isNew = false;

        if (!$user) {
            $user = new User;
            $user->name       = $phone;
            $user->phone_code = $phoneCode;
            $user->phone      = $phone;
            $user->type       = '0';
            $user->status     = '1';
            $user->active     = '1';
            $isNew = true;
        }

        if (!$isNew && (string) $user->type !== '0') {
            return $this->fail(
                'This number belongs to a ' . strtolower($this->roleLabel($user)) . ' account. Please use the Official tab to sign in.',
                ['phone' => ['Use official sign in']],
                422
            );
        }

        if ($user->status === '2') {
            return $this->fail('This account has been blocked.', ['account' => ['Blocked']], 403);
        }

        $user->otp = self::DEV_OTP;
        $user->save();

        return $this->ok($isNew ? 'Welcome! Enter the code to continue.' : 'Verification code sent.', [
            'phone_code'   => $phoneCode,
            'phone'        => $phone,
            'is_new_user'  => $isNew,
            'otp_length'   => 4,
            'dev_otp'      => self::DEV_OTP,
        ]);
    }

    public function consumerVerifyOtp(Request $request)
    {
        $this->validateInput($request, [
            'phone_code' => 'required|regex:/^[0-9]+$/|max:5',
            'phone'      => 'required|regex:/^[0-9]+$/|min:8|max:15',
            'otp'        => 'required|regex:/^[0-9]+$/|size:4',
        ]);

        $user = User::where('phone_code', $request->input('phone_code'))
            ->where('phone', $request->input('phone'))
            ->first();

        if (!$user) {
            return $this->fail('We could not find that number. Please request a code again.', ['phone' => ['Not found']], 404);
        }

        if ((string) $user->type !== '0') {
            return $this->fail(
                'Please use the Official tab to sign in.',
                ['phone' => ['Use official sign in']],
                422
            );
        }

        if ((string) $user->otp !== (string) $request->input('otp')) {
            return $this->fail('That code is not correct.', ['otp' => ['Invalid code']], 422);
        }

        $user->otp = null;
        $user->save();

        return $this->issueToken($user, 'Signed in successfully');
    }

    public function officialRequestOtp(Request $request)
    {
        $this->validateInput($request, [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return $this->fail('No account found for this email.', ['email' => ['Not registered']], 404);
        }

        if ((string) $user->type === '0') {
            return $this->fail(
                'This is a consumer account. Please sign in with your phone number.',
                ['email' => ['Use consumer sign in']],
                422
            );
        }

        if (empty($user->password) || !Hash::check($request->input('password'), $user->password)) {
            return $this->fail('Incorrect password.', ['password' => ['Incorrect password']], 401);
        }

        if ($user->status === '2') {
            return $this->fail('This account has been blocked.', ['account' => ['Blocked']], 403);
        }

        $user->otp = self::DEV_OTP;
        $user->save();

        return $this->ok('Verification code sent.', [
            'email'      => $user->email,
            'name'       => $user->name,
            'role'       => $this->role($user),
            'role_label' => $this->roleLabel($user),
            'otp_length' => 4,
            'dev_otp'    => self::DEV_OTP,
        ]);
    }

    public function officialVerifyOtp(Request $request)
    {
        $this->validateInput($request, [
            'email' => 'required|email',
            'otp'   => 'required|regex:/^[0-9]+$/|size:4',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return $this->fail('No account found for this email.', ['email' => ['Not registered']], 404);
        }

        if ((string) $user->otp !== (string) $request->input('otp')) {
            return $this->fail('That code is not correct.', ['otp' => ['Invalid code']], 422);
        }

        $user->otp = null;
        $user->save();

        return $this->issueToken($user, 'Signed in successfully');
    }

    protected function issueToken($user, $message)
    {
        return $this->ok($message, [
            'token'   => encrypt($user->id),
            'profile' => [
                'id'          => $user->id,
                'name'        => $user->name,
                'first_name'  => $user->first_name,
                'last_name'   => $user->last_name,
                'phone_code'  => $user->phone_code,
                'phone'       => $user->phone,
                'email'       => $user->email,
                'type'        => (string) $user->type,
                'role'        => $this->role($user),
                'role_label'  => $this->roleLabel($user),
                'designation' => $user->who_you_are,
            ],
        ]);
    }
}
