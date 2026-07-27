<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Code;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Str;
use Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str as SupportStr;
use App\Mail\SendOtpMail;
use App\CustomClasses\EmailProvider as CustomClassesEmailProvider;

class AuthController extends Controller
{

	// public function forgotPassword(ForgotPassword $request)
	// {

	// 	$message = __('forgot_password.success_message');
	// 	$status  = 'success';
	// 	$status_code = 200;

	// 	$user = User::where('email', $request->email)->first();

	// 	if ($user->status != '1' || $user->active != '1') {
	// 		$message = __('login.approval_message');
	// 		$status  = 'failed';
	// 		$status_code = 400;
	// 	} else {
	// 		$password = SupportStr::random(6);

	// 		CustomClassesEmailProvider::sendMail(
	// 			'user-forgot-password-mail',
	// 			[
	// 				'user_id' => $user->id,
	// 				'name' => $user->first_name,
	// 				'phone' => $user->phone_code . $user->phone,
	// 				'password' => $password,
	// 				'email' => $user->email
	// 			]
	// 		);

	// 		$user->password = bcrypt($password);
	// 		$user->save();
	// 	}

	// 	return response(['message' => $message, 'status' => $status], $status_code);
	// }
	public function getOtp(Request $request)
	{
		try {

			$input = $request->all();

			// Validation rules
			$rules = [
				'phone_code' => 'nullable|string|regex:/^[0-9-]+$/',
				'phone' => 'nullable|string|max:15',
				'email' => 'nullable|string|email',
				'password' => 'nullable|string',
			];

			// Validate input data
			$validator = Validator::make($input, $rules);

			if ($validator->fails()) {
				$errors = $validator->errors();
				return response([
					'error' => true,
					'message' => $errors->first(),
					'status' => 400
				], 400);
			}


			// Process login and OTP assignment
			$userResponse = loginUserAndAssignOtp(
				$input['password'] ?? null,
				$input['phone_code'] ?? null,
				$input['phone'] ?? null,
				$input['email'] ?? null

			);
			// Handle user response
			if ($userResponse instanceof \Illuminate\Http\Response) {
				return $userResponse;
			}

			if ($userResponse instanceof \App\Models\User) {

				if (!empty($userResponse->email)) {
					try {
						Mail::to($userResponse->email)->send(new SendOtpMail($userResponse->otp));
						Log::info('OTP email sent successfully', ['email' => $userResponse->email]);
					} catch (\Exception $e) {
						Log::error('Failed to send OTP email', [
							'email' => $userResponse->email,
							'error' => $e->getMessage()
						]);
					}
				}


				return response([
					'error' => false,
					'message' => 'OTP sent successfully',
					'status' => 200,
					'data' => [
						'otp' => $userResponse->otp,
					],
				], 200);
			}

			return response([
				'error' => true,
				'message' => 'Unable to process the request. Please try again.',
				'status' => 500
			], 500);
		} catch (\Exception $e) {
			return response([
				'error' => true,
				'message' => 'An unexpected error occurred: ' . $e->getMessage(),
				'status' => 500
			], 500);
		}
	}

	public function verifyOtp(Request $request)
	{
		$input = $request->all();

		// Validation rules for phone or email
		$rules = [
			'country_code' => 'nullable|regex:/^[0-9-]+$/',
			'otp'          => 'required|min:4|max:4|regex:/^[0-9-]+$/',
			'phone'        => 'nullable|min:10|max:10|regex:/^[0-9-]+$/',
			'email'        => 'nullable|email',
		];

		$messages = [
			'country_code.regex' => 'Please enter a valid country code.',

			'otp.required' => 'OTP is required.',
			'otp.min'      => 'OTP must be exactly 4 digits.',
			'otp.max'      => 'OTP must be exactly 4 digits.',
			'otp.regex'    => 'OTP must contain only numbers.',

			'phone.min'    => 'Phone number must be exactly 10 digits.',
			'phone.max'    => 'Phone number must be exactly 10 digits.',
			'phone.regex'  => 'Phone number must contain only numbers.',

			'email.email'  => 'Please enter a valid email address.',
		];

		$validator = Validator::make($input, $rules, $messages);


		if ($validator->fails()) {
			// Return the first validation error
			return response([
				'error'   => true,
				'message' => $validator->errors()->first(),
			], 400);
		}
		// Ensure either phone or email is provided
		if (empty($input['phone']) && empty($input['email'])) {
			return response([
				'error' => true,
				'status' => 400,
				'message' => 'Please provide a valid phone number or email address',
			], 400);
		}

		// Search for user by phone and OTP if phone is provided
		$user = null;
		if (!$user && !empty($input['phone'])) {
			$user = User::where('phone', $input['phone'])
				->where('otp', $input['otp'])
				->first();
		}

		// Search for user by email and OTP if email is provided
		if (!$user && !empty($input['email'])) {
			$user = User::where('email', $input['email'])
				->where('otp', $input['otp'])
				->first();
		}

		// If user is not found with provided phone/email and OTP, return error
		if (!$user) {
			return response([
				'error' => true,
				'message' => 'Invalid OTP or credentials'
			], 400);
		}

		// Prepare user profile information

		// $scannable = 0;
		// $allowedRoles = ['BIR LTS ACIR', 'BIR LTS HREA Excise', 'BIR LTS ELTFOD Division Chief', 'BIR LTS ELTFOD Assistant Division Chief', 'BIR LTS ELTFOD Section Chief Tobacco', 'BIR LTS ELTFOD Revenue Officer', 'BIR LTS ELTFOD ROOP(Zone in charge)', 'BIR LTS ELTFOD ROOP APO', 'BIR LTS ELTRD Assistant Division Chief', 'BIR LTS ELTRD Division Chief', 'BIR LTS ELTRD Section Chief Tobacco'];

		// if (in_array($user->who_you_are, $allowedRoles)) {
		// 	$scannable = 1;
		// } else {
		// 	$scannable = 0;
		// }



		$profile = [
			'first_name'  => $user->first_name,
			'middle_name' => $user->middle_name,
			'last_name'   => $user->last_name,
			'phone_code'  => $user->phone_code,
			'phone'       => $user->phone,
			'email'       => $user->email,
			'type'        => $user->type,
			'role'        => $user->who_you_are,
		];
		// Successful response with token and profile details
		return response([
			'error' => false,
			'message' => 'Success',
			'status' => 200,
			'data'    => [
				'token'   => encrypt($user->id),
				'profile' => $profile,
			],
		], 200);
	}

	public function verifySecretCode(Request $request)
	{
		$input = $request->all();
		$rules = [
			'code' => 'required|regex:/^[A-Za-z0-9]+$/',
			'secret_code' => 'required|regex:/^[A-Za-z0-9]+$/',
		];

		$messages = [
			'secret_code.required' => 'Secret Code is required.',
			'secret_code.regex'    => 'Please enter a valid Secret Code.',
		];

		$validator = Validator::make($input, $rules, $messages);

		if ($validator->fails()) {
			return response([
				'success' => false,
				'message' => $validator->errors()->first(),
				'errors'  => $validator->errors(),
			], 400);
		}else {
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
