<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CaseController extends Controller
{
    public function assignedCases(Request $request)
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

            $alerts = Alert::where('id','>',0)->orderBy('updated_at','DESC');

            if ($user->type=='1') {
                $alerts->where('admin_assigned_to',$user->id);
            }

            if ($user->type=='2') {
                $alerts->where('manufacturer_assigned_to',$user->id);
            }

            if(isset($input['status']) && ($input['status']=='0' || $input['status']=='1')){
                $alerts->where('status',$input['status']);
            }

            $cases = $alerts->get();
            $response = [];

            if (count($cases)>0) {
                foreach ($cases as $key => $case) {
                    $response[$key]['id'] = $case->id;
                    $response[$key]['product_id'] = $case->product_id;
                    $response[$key]['product_name'] = $case->product_name;
                    $response[$key]['batch'] = $case->getBatch?$case->getBatch->code:'';
                    $response[$key]['location'] = json_decode($case->location,true);
                    $response[$key]['description'] = $case->alert_message;
                    $response[$key]['reported_by'] = $case->getUser?($case->getUser->phone_code.''.$case->getUser->phone):'';
                    $response[$key]['date'] = date('M d, Y H:i:s', strtotime($case->created_at));
                }
            }

            return response([
                'success' => true,
                'message' => 'Cases fetched successfully',
                'cases' => $response
            ], 200);
        }
    }

    public function caseDetails(Request $request,$case_id)
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

            $alert = Alert::where('id',$case_id);

            if ($user->type=='1') {
                $alert->where('admin_assigned_to',$user->id);
            }

            if ($user->type=='2') {
                $alert->where('manufacturer_assigned_to',$user->id);
            }

            $case = $alert->first();
            $response = [];

            if (!$case) {   
                return response([
                    'success' => false,
                    'message' => 'Case not found.',
                    'errors' => ['case' => ['Case not found.']]
                ], 400);
            }

            $response['id'] = $case->id;
            $response['product_id'] = $case->product_id;
            $response['code_data'] = $case->getCode->code_data;
            $response['product_name'] = $case->product_name;
            $response['batch'] = $case->getBatch?$case->getBatch->code:'';
            $response['manufactured_on'] = $case->getCode ? date('M d, Y H:i:s', strtotime($case->getCode->getBatch->mfg_date)) : '';
            $response['expiry_on'] = $case->getCode ? date('M d, Y H:i:s', strtotime($case->getCode->getBatch->exp_date)) : '';
            $response['location'] = json_decode($case->location,true);
            $response['description'] = $case->alert_message;
            $response['reported_by'] = $case->getUser?($case->getUser->phone_code.''.$case->getUser->phone):'';
            $response['date'] = date('M d, Y H:i:s', strtotime($case->created_at)); 
            $response['status'] = $case->status=='1'?'Closed':'Open';

            if ($case->status=='1') {                
                if ($user->type=='1') {
                    $response['comments'] = $case->admin_comment;
                }

                if ($user->type=='2') {
                    $response['comments'] = $case->manufacturer_comment;
                }
            }

            $response['manufacturer'] = [
                'name' => $case->getCode->getUser->getCompany->name??'',
                'email' => $case->getCode->getUser->getCompany->email??'',
                'phone' => $case->getCode->getUser->getCompany->phone??'',
                'address'=>companyAddress($case->getCode->getUser->getCompany),
                'provinces' => $case->getCode->getUser->business_location?json_decode($case->getCode->getUser->business_location,true):'',
            ];



            return response([
                'success' => true,
                'message' => 'Case details fetched successfully',
                'details' => $response
            ], 200);
        }
    }

    public function updateCase(Request $request,$case_id)
    {
        $input = $request->all();

        $rules = [
            'token'       =>  'required',
            'status'      =>  'required|in:0,1',
            'comments'    =>  'required'
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

            $alert = Alert::where('id',$case_id);

            if ($user->type=='1') {
                $alert->where('admin_assigned_to',$user->id);
            }

            if ($user->type=='2') {
                $alert->where('manufacturer_assigned_to',$user->id);
            }

            $case = $alert->first();

            if (!$case) {   
                return response([
                    'success' => false,
                    'message' => 'Case not found.',
                    'errors' => ['case' => ['Case not found.']]
                ], 400);
            }

            if ($case->status=='1') {   
                return response([
                    'success' => false,
                    'message' => 'Case is closed.',
                    'errors' => ['case' => ['Case is closed.']]
                ], 400);
            }


            $case->status = $input['status'];

            if ($user->type=='1') {
                $case->admin_comment = $input['comments'];
            }

            if ($user->type=='2') {
                $case->manufacturer_comment = $input['comments'];
            }

            $case->save();


            return response([
                'success' => true,
                'message' => 'Case updated successfully'
            ], 200);
        }
    }
}
