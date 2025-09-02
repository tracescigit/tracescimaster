<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;

class HomeController extends Controller
{
	public function index()
	{
		$pendingUsers = User::where('type','2')->where('status','0')->count();

		return view('admin.dashboard.index', [

			'pendingUsers'=>$pendingUsers

		]);
	}

	public function profile()
	{
		return view('admin.profile.index');
	}


	public function updateProfile(UpdateProfileRequest $request)
	{
		try{
			$id = Auth::id();
			$input = $request->all();

			$user = Auth::user();

			if($user){
				$user->email = $input['email'];
				$user->username = $input['email'];
				$user->name  = $input['name'];
				$user->password  = bcrypt($input['password']);
				$user->phone_code  = $input['phone_code']??'91';
				$user->phone  = $input['mobile'];
				$user->gender  = $input['gender'];
				$user->updated_at = Carbon::now();

				$user->save();
			}

			return response(['message'=>'Your profile has been updated successfully.'], 200);

		}catch(Exception $e){
			return response(['message'=>'Something went wrong.'], 503);
		}
	}

	public function changePassword()
	{
		return view('admin.profile.password');
	}


	public function updatePassword(UpdatePasswordRequest $request)
	{
		try{
			$input     = $request->all();

			$user= User::where('id', Auth::id())->first();
			if (!Hash::check($request->old_password, $user->password)) {

				$response = [
					'status' => 'failed',
					'message' => 'Old password is wrong.',
					'errors'  => [
						'old_password' =>['Old password is wrong.']
					]
				];

				return response($response, 400);
			}

			$user->password = bcrypt($request->new_password);
			$user->save();

			return response([
				'message' => 'Password changed successfully. Please login again with new password.',
				'status'  => 'success',
				'url' => url('logout')
			], 200);

		}catch(Exception $e){
			return response([
				'status'  => 'failed',
				'message'  => 'Something went wrong.'
			], 400);
		}
	}
}
