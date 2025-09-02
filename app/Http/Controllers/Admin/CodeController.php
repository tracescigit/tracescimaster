<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CodeExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CodeUploadRequest;
use App\Imports\CodeImport;
use App\Models\Code;
use App\Models\Damage;
use App\Models\Product;
use Excel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CodeController extends Controller
{	
	public function status($code_data,$status,$seized_by){
		$result = 'Inactive';

		if($status=='1'){
			$result = 'Active';
		}

		if($seized_by!=null){
			$result = 'Seized';
		}

		if($this->lostStolenCode($code_data)){
			$result = 'Lost/Stolen';
		}

		if($this->damagedCode($code_data)){
			$result = 'Damaged';
		}

		return $result;


	}

	public function lostStolenCode($code_data){

		$lots = Damage::where('reason','Lost/Stolen Stamp')->get();
		$exists = false;

		if (count($lots)>0) {
			foreach ($lots as $key => $lot) {
				$stamps = json_decode($lot->stamps,true);

				if (in_array($code_data,$stamps)) {
					$exists = true;
				}
			}       
		}

		return $exists;
	}

	public function damagedCode($code_data){
		$lots = Damage::where('reason','Damaged Stamp')->get();
		$exists = false;

		if (count($lots)>0) {
			foreach ($lots as $key => $lot) {
				$stamps = json_decode($lot->stamps,true);

				if (in_array($code_data,$stamps)) {
					$exists = true;
				}
			}       
		}

		return $exists;
	}

	public function index(Request $request)
	{
		if($request->ajax())
		{	
			$limit          = $request->input('size');
			$page           = $request->input('page');
			$search_field   = $request['filters']?$request['filters']['0']['field']:'';
			$search_type    = $request['filters']?$request['filters']['0']['type']:'';
			$search_value   = $request['filters']?$request['filters']['0']['value']:'';
			$orderby        = $request['sorters']?$request['sorters']['0']['field']:'';			
			$order          = $orderby != "" ? $request['sorters']['0']['dir'] : "";

			$start_date = $request['filters']?$request['filters']['1']['value']:'';
			$end_date = $request['filters']?$request['filters']['2']['value']:'';


			$response       = Code::getCodeModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value,null,$start_date,$end_date);

			if(!$response){
				$codes      = [];
				$last_page  = 0;
				$total = 0;
			}
			else{
				$codes      = $response['response'];
				$last_page     = $response['last_page'];
				$total      = $response['total'];
			}

			$codeData = array();
			$i = 1;

			foreach ($codes as $key=>$code) {

				$u['id']             = $key+1;
				$u['code_status']    = $code->status??'-';
				$u['business_name']  = $code->getProduct->getUser->getCompany->name??'-';
				$u['user_name'] 	 = $code->getProduct->getUser->name??'-';
				$u['email'] 		 = $code->getProduct->getUser->email??'-';
				$u['batch']	         = $code->batch??'-';
				$u['code_data']      = $code->code_data??'-';
				$u['url']            = $code->url??'-';
				$u['product_id']     = $code->getProduct?($code->getProduct->name):'-';
				$u['date']     		 = date('M d, Y',strtotime($code->created_at));
				$u['created_at']     = date('M d, Y',strtotime($code->created_at));
				$u['status']         = $this->status($code->code_data,$code->status,$code->seized_by);

				
				$actions            = view('admin.codes.actions',['code' => $code]);
				$u['actions']       = $actions->render(); 

				$codeData[] = $u;
				$i++;
				unset($u);
			}

			$return = [
				"last_page"		    =>  $last_page,
				"data"              =>  $codeData,
				"total"             =>  $total
			];
			
			return $return;
		}
		return view('admin.codes.index');
	}


	public function create()
	{	
		$products = Product::where('id' , '!=', '')->get();
		return view('admin.codes.create')->with('products',$products);
	}

	public function deactivate($id)
	{
		$id  = decrypt($id);

		$code = Code::find($id);

		$status = 'deactivated';

		if($code->status=='1'){
			$code->status = '0';
		}else{
			$code->status = '1';
			$status = 'activated';
		}

		$code->save();


		return response(['status'=>'success','message'=>'Code has been '.$status.' successfully.'],200);
	}

	public function generate(CodeUploadRequest $request)
	{
		try{
			$input = $request->all();

			$data = [
				'user_id'     => Auth::id(),
				'product_id'  => $input['product'],
				'batch'       => $input['batch'],
			];	

			$destroy = Code::where('user_id',Auth::id())->where('exported','0')->delete();
			$array = Excel::toArray(new CodeImport($data), $input['file']);
			$count = count($array[0]);

			// if($count>getAvailableCredits(Auth::id())){
			// 	return response(['status'=>'failed','message'=>'You do not have sufficient credits to upload data. Your file has '.$count.' code data but you only have '.getAvailableCredits(Auth::id()).' credits to use.'],400);
			// }			

			$import  = Excel::import(new CodeImport($data), $input['file']);

			if ($import) {

				$codes = Code::where('user_id',Auth::id())->where('exported','0')->get();
				$generate = $this->generateCodes($codes);

				return response(['status'=>'success','message'=>'Your codes have been uploaded. Please wait while we are downloading the codes for you.'],200);

			}else{
				return response(['status'=>'failed','message'=>'Error uploading data. Please try again.'],503);
			}

		}
		catch(Exception $e){
			return response(['errors'=>['file'=>$e->errors()]],400);
		}

	}

	public function generateCodes($codes)
	{
		foreach ($codes as $key => $code) {
			$secret        = generateQR();
			$code->qr_code = $secret;
			$code->url     = env('APP_URL','https://tracesci.in').'/api/p/'.$secret;
			$code->save();
		}

		return true;
	}

	public function export()
	{	
		return Excel::download(new CodeExport, 'codes.xlsx');
	}

	public function markExported()
	{
		$codes = Code::where('user_id',Auth::id())->where('exported','0')->update(['exported'=>'1']);		

		return response(['status'=>'success','message'=>'Codes has been downloaded successfully.'],200);
	}

}
