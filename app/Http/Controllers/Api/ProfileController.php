<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Validator;
use Str;

class ProfileController extends Controller
{

    public function profile (Request $request)
    {
        $input = $request->all();

        $rules = [
            'token'       =>  'required'
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
            $token = $input['token'];

            try {
                $id = decrypt($token);
            } catch (Exception $e) {
                return response([
                    'success' => false,
                    'message' => 'Invalid token',
                    'errors' => ['token' => ['Invalid token']]
                ], 400);
            }

            $user = User::find($id);

            if (!$user) {
                return response([
                    'success' => false,
                    'message' => 'Invalid token',
                    'errors' => ['token' => ['Invalid token']]
                ], 400);
            }

            $response = [];

            $response['first_name']     = $user->first_name;
            $response['middle_name']    = $user->middle_name;
            $response['last_name']      = $user->last_name;
            $response['phone_code']     = $user->phone_code;
            $response['phone'] = $user->phone;
            $response['email'] = $user->email;
            $response['role']  = Str::slug($user->who_you_are);

            return response([
                'success' => true,
                'message' => 'Profile fetched successfully',
                'details' => $response
            ], 200);
        }
    }

}
