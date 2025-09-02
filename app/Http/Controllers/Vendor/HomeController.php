<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Company;
use App\Models\Document;
use App\Models\User;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;
use Hash;

class HomeController extends Controller
{
	public function index()
	{	
		$invoice = updateInvoices(Auth::user()->parent_id??Auth::id());
		return view('vendor.dashboard.index');
	}

	public function profile()
	{
		return view('vendor.profile.index');
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
				$user->phone_code  = $input['phone_code']??'91';
				$user->phone  = $input['mobile'];
				$user->gender  = $input['gender'];
				$user->address_one  = $input['company_address'];
				$user->payment_gateway_id  = $input['payment_gateway_id']??NULL;
				$user->payment_gateway_token  = $input['payment_gateway_token']??NULL;
				$user->payment_gateway  = $input['payment_gateway']??NULL;
				$user->updated_at = Carbon::now();

				$user->save();
			}

			$company = Company::where('user_id',$id)->first();

			if($company){
				$company->name    = $input['company_name'];
				$company->address = $input['company_address'];
				$company->cin     = $input['company_cin'];
				$company->gst 	  = $input['company_gst_no'];
				$company->save();
			}

			if ($request->hasFile('company_gst')) {
				$file = $request->file('company_gst');

				$doc = Document::where('user_id',$id)->where('type','company_gst')->first();

				if($doc){
					File::delete(public_path() .$doc->doc_url);
					$doc->delete();
				}

				$add_doc = $this->attachDocument('Company GST','company_gst',$user->id,$file);
			}

			if ($request->hasFile('self_kyc')) {
				$file = $request->file('self_kyc');

				$doc = Document::where('user_id',$id)->where('type','self_kyc')->first();

				if($doc){
					File::delete(public_path() .$doc->doc_url);
					$doc->delete();
				}

				$add_doc = $this->attachDocument('Self KYC','self_kyc',$user->id,$file);
			}

			if ($request->hasFile('company_roc')) {
				$file = $request->file('company_roc');
				$doc = Document::where('user_id',$id)->where('type','company_roc')->first();

				if($doc){
					File::delete(public_path() .$doc->doc_url);
					$doc->delete();
				}
				
				$add_doc = $this->attachDocument('Company ROC','company_roc',$user->id,$file);
			}

			return response(['message'=>'Your profile has been updated successfully.'], 200);

		}catch(Exception $e){
			return response(['message'=>'Something went wrong.'], 503);
		}
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

	public function changePassword()
	{
		return view('vendor.profile.password');
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
