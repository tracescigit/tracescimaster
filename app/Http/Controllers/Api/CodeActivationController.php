<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Imports\CodeActivate;
use App\Models\Code;
use App\Models\CodeActivation;
use App\Models\User;
use Excel;
use Illuminate\Http\Request;
use Validator;

class CodeActivationController extends Controller
{
    public function activate(Request $request)
    {
        $input = $request->all();

        $rules = [
            'token'       =>  'required',
            'code_data'   =>  'required|exists:codes'
        ];

        $validator = Validator::make($input, $rules);

        $date_time = date('d-m-Y h:i:s a');

        if ($validator->fails()) {
            $errors = $validator->errors();

            $history = new CodeActivation;
            $history->response = 'Invalid request';
            $history->status   = 'Failed';
            $history->code_data = $input['code_data'];
            $history->date_time = $date_time;
            $history->save();

            return response([
                'success'   => false,
                'message'   => 'Invalid code',
                'code_data' => $input['code_data'],
                'date_time' => $date_time
            ], 400);
        } else {

            $token = $input['token'];

            try {
                $id = decrypt($token);
            } catch (Exception $e) {

                $history = new CodeActivation;
                $history->response = 'Invalid request';
                $history->status   = 'Failed';
                $history->code_data = $input['code_data'];
                $history->date_time = $date_time;
                $history->save();

                return response([
                    'success'   => false,
                    'message'   => 'Invalid request',
                    'code_data' => $input['code_data'],
                    'date_time' => $date_time
                ], 400);
            }

            $user = User::find($id);

            if (!$user) {

                $history = new CodeActivation;
                $history->response = 'Invalid request';
                $history->status   = 'Failed';
                $history->code_data = $input['code_data'];
                $history->date_time = $date_time;
                $history->save();

                return response([
                    'success' => false,
                    'message' => 'Invalid request',
                    'code_data' => $input['code_data'],
                    'date_time' => $date_time
                ], 400);
            }

            $code = Code::where('code_data',$input['code_data'])->where('user_id',$user->parent_id??$user->id)->first();

            if (!$code) {
                $history = new CodeActivation;
                $history->response  = 'Invalid code';
                $history->status    = 'Failed';
                $history->code_data = $input['code_data'];
                $history->date_time = $date_time;
                $history->save();

                return response([
                    'success' => false,
                    'message' => 'Invalid code',
                    'code_data' => $input['code_data'],
                    'date_time' => $date_time
                ], 400);
            }

            if ($code->status=='1') {

                $history = new CodeActivation;
                $history->response  = 'Code is active';
                $history->status    = 'Failed';
                $history->code_data = $input['code_data'];
                $history->date_time = $date_time;
                $history->save();

                return response([
                    'success' => false,
                    'message' => 'Code is active',
                    'code_data' => $input['code_data'],
                    'date_time' => $date_time
                ], 400);

            }else{
                $code->status = '1';
                $code->save();

                $history = new CodeActivation;
                $history->status    = 'Success';
                $history->response  = 'Activated';
                $history->code_data = $input['code_data'];
                $history->date_time = $date_time;
                $history->save();

                return response([
                    'success'   => true,
                    'message'   => 'Activated',
                    'code_data' => $input['code_data'],
                    'date_time' => $date_time
                ], 200);

            }
        }
    }

    public function upload(Request $request)
    {
        $input = $request->all();

        $rules = [
            'token'       =>  'required',
            'file'        =>  'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response([
                'success'   => false,
                'message'   => 'File is required'
            ], 400);
        } else {

            $token = $input['token'];

            try {
                $id = decrypt($token);
            } catch (Exception $e) {
                return response([
                    'success'   => false,
                    'message'   => 'Invalid request'
                ], 400);
            }

            $user = User::find($id);

            if (!$user) {
                return response([
                    'success' => false,
                    'message' => 'Invalid request'
                ], 400);
            }

            $data = [
                'user_id'     => $user->id
            ];

            $file   = $request->file('file')->store('import');
            $import = Excel::import(new CodeActivate($data), $file);
            
            return response([
                'success' => true,
                'message' => 'Activation completed.'
            ], 200);

        }
    }

}
