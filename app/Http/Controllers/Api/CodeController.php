<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Code;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CodeController extends Controller
{
    public function deactivate(Request $request){
        $input = $request->all();

        $rules = [
            'token'       =>  'required',
            'type'        =>  'required|in:0,1',
            'code'        =>  'required'
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

            
            if ($input['type']=='0') {
                $code = Code::where('code_data',$input['code'])->first();

                if(!$code){
                    return response([
                        'success' => false,
                        'message' => 'Code not found.',
                        'errors' => ['code' => ['Code not found.']]
                    ], 400);
                }

                $code->status = '0';
                $code->seized_by = $user->id;
                $code->save();
            }else{

                $batch  =  Batch::where('code',$input['code'])->first();

                if(!$batch){
                    return response([
                        'success' => false,
                        'message' => 'Batch not found.',
                        'errors' => ['batch' => ['Batch not found.']]
                    ], 400);
                }

                $update = Code::where('batch_id',$batch->id)->update([
                    'status' => '0',
                    'seized_by' => $user->id
                ]);
            }

            return response([
                'success' => true,
                'message' => 'Products has been deactivated.',
                'errors' => ['products' => ['Products has been deactivated.']]
            ], 400);
        }
    }
}
