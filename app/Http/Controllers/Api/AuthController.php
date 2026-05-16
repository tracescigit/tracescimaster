<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Code;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Str;
use Hash;

class AuthController extends Controller
{
	public function getOtp(Request $request)
	{
		$input = $request->all();

		$rules = [
			'country_code' =>  'required|regex:/^[0-9-]+$/',
			'phone'       =>  'required|min:10|max:10|regex:/^[0-9-]+$/',
		];

		$validator = Validator::make($input, $rules);

		if ($validator->fails()) {
			$errors = $validator->errors();
			return response([
				'success' => false,
				'message' => 'Invalid request',
				'errors' => $errors
			], 400);
		} else {
			$user = createOrUpdateUserAndAssignOtp($input['country_code'], $input['phone']);

			return response([
				'success' => true,
				'message' => 'OTP sent successfully',
				'otp' => $user->otp
			], 200);
		}
	}

	public function verifyOtp(Request $request)
	{
		$input = $request->all();
		$rules = [
			'country_code' =>  'required|regex:/^[0-9-]+$/',
			'otp'         =>  'required|min:4|max:4|regex:/^[0-9-]+$/',
			'phone'       =>  'required|min:10|max:10|regex:/^[0-9-]+$/',

		];

		$validator = Validator::make($input, $rules);

		if ($validator->fails()) {
			$errors = $validator->errors();
			return response([
				'success' => false,
				'message' => 'Invalid request',
				'errors' => $errors
			], 400);
		} else {
			$user = User::where('phone', $input['phone'])->where('otp', $input['otp'])->first();

			if (!$user) {
				return response([
					'success' => false,
					'message' => 'Invalid otp',
					'errors' => ['otp' => ['Invalid otp']]
				], 400);
			}

			$profile = [];

			$profile['first_name'] = $user->first_name;
			$profile['middle_name'] = $user->middle_name;
			$profile['last_name'] = $user->last_name;
			$profile['phone_code'] = $user->phone_code;
			$profile['phone'] = $user->phone;
			$profile['email'] = $user->email;
			$profile['role']  = getAppUsersRoles($user->id);
			// $profile['type']  = getDesignation($user->id);
			return response([
				'success' => true,
				'message' => 'Logged in successfully',
				'token'  => encrypt($user->id),
				'profile' => $profile,
			], 200);
		}
	}
	public function verifySecretCode(Request $request)
	{
		$input = $request->all();
		$rules = [
			'code' =>  'required|regex:/^[A-Za-z0-9]+$/',
			'secret_code' =>  'required|regex:/^[A-Za-z0-9]+$/',

		];

		$validator = Validator::make($input, $rules);

		if ($validator->fails()) {
			$errors = $validator->errors();
			return response([
				'success' => false,
				'message' => 'Invalid request',
				'errors' => $errors
			], 400);
		} else {
			$verify = Code::where('qr_code', $input['code'])->where('secret_code', $input['secret_code'])->exists();

			if (!$verify) {
				return response([
					'success' => false,
					'message' => 'Invalid Secret Code',
					'errors' => ['secret-code' => ['Invalid Secret Code']]
				], 400);
			}
			
			return response([
				'success' => true,
				'message' => 'Logged in successfully',
			], 200);
		}
	}
	public function passwordLogin(Request $request)
	{
		$input = $request->all();

		$rules = [
			'username'    =>  'required|exists:users,email',
			'password'    =>  'required',
		];

		$validator = Validator::make($input, $rules);

		if ($validator->fails()) {
			$errors = $validator->errors();
			return response([
				'success' => false,
				'message' => 'Invalid credentials'
			], 200);
		} else {
			$user = User::where('email', $input['username'])->first();

			if (!Hash::check($input['password'], $user->password)) {
				return response([
					'success' => false,
					'message' => 'Invalid credentials'
				], 200);
			}

			$profile = [];

			$profile['name']        = $user->name;
			$profile['first_name']  = $user->first_name;
			$profile['middle_name'] = $user->middle_name;
			$profile['last_name']   = $user->last_name;
			$profile['phone_code']  = $user->phone_code;
			$profile['phone'] = $user->phone;
			$profile['email'] = $user->email;
			$profile['role']  = getAppUsersRoles($user->id);

			return response([
				'success' => true,
				'message' => 'Logged in successfully',
				'token'  => encrypt($user->id),
				'profile' => $profile
			], 200);
		}
	}

	public function withoutAuth(Request $request)
	{
		$input = $request->all();

		$rules = [
			'country_code' =>  'required|regex:/^[0-9-]+$/',
			'phone'       =>  'required|min:10|max:10|regex:/^[0-9-]+$/',
		];

		$validator = Validator::make($input, $rules);

		if ($validator->fails()) {
			$errors = $validator->errors();
			return response([
				'success' => false,
				'message' => 'Invalid request',
				'errors' => $errors
			], 400);
		} else {
			$user = createOrUpdateUserAndAssignOtp($input['country_code'], $input['phone'], false);

			return response([
				'success' => true,
				'message' => 'Logged in successfully',
				'token'  => encrypt($user->id)
			], 200);
		}
	}
}
