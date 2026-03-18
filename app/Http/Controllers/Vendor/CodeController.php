<?php

namespace App\Http\Controllers\Vendor;

use App\Exports\BulkExport;
use App\Exports\CodeExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\CodeActionRequest;
use App\Http\Requests\Vendor\CodeUploadRequest;
use App\Imports\CodeImport;
use App\Models\Batch;
use App\Models\Code;
use App\Models\UploadProgress;
use App\Models\Product;
use Excel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

// use Illuminate\Support\Facades\Artisan;

class CodeController extends Controller
{
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

			$response       = Code::getCodeModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value, Auth::id(),$start_date,$end_date);

			if(!$response){
				$codes      = [];
				$last_page  = 0;
				$total = 0;
			}
			else{
				$codes      = $response['response'];
				$last_page     = $response['last_page'];
				$total     = $response['total'];
			}

			$codeData = array();
			$i = 1;

			foreach ($codes as $code) {

				$u['id']             = $i;
				$u['status']         = $code->status??'-';
				$u['batch']          = $code->batch??'-';
				$u['code_data']      = $code->code_data??'-';
				$u['url']            = $code->url??'-';
				$u['product_id']     = $code->getProduct?($code->getProduct->name):'-';
				$u['created_at']     = date('M d, Y',strtotime($code->created_at));
				
				$actions            = view('vendor.codes.actions',['code' => $code]);
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
		$progress = UploadProgress::where('user_id',Auth::user()->parent_id??Auth::id())->where('status','1')->exists();
		return view('vendor.codes.index')->with('progress',$progress);
	}

	public function create()
	{	
		$products = Product::where('user_id',Auth::id())->get();
		return view('vendor.codes.create')->with('products',$products);
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
			ini_set('max_execution_time', 6000);

			$input = $request->all();
			$batch = Batch::where('code',$input['batch'])->first();
			$count = $this->getRows($input['file']);

			$data = [
				'user_id'     => Auth::id(),
				'product_id'  => $input['product'],
				'batch'       => $input['batch'],
				'batch_id'    => $batch->id,
				'total_rows'  => $count
			];

			if($count>getAvailableCredits(Auth::id())){
				return response(['status'=>'failed','message'=>'You do not have sufficient credits to upload data. Your file has '.$count.' code data but you only have '.getAvailableCredits(Auth::id()).' credits to use.'],400);
			}

			$file   = $request->file('file')->store('import');
			$import = FacadesExcel::import(new CodeImport($data), $file);
			return response(['status'=>'success','message'=>'Import in queue, please check progess in the header.'],200);
		}
		catch(Exception $e){
			return response(['errors'=>['file'=>$e->errors()]],400);
		}

	}

	public function getRows($file)
	{
		$fileExtension     = pathinfo($file, PATHINFO_EXTENSION);
		$temporaryFileFactory=new \Maatwebsite\Excel\Files\TemporaryFileFactory(
			config('excel.temporary_files.local_path', 
				config('excel.exports.temp_path', 
					storage_path('framework/laravel-excel'))
			),
			config('excel.temporary_files.remote_disk')
		);


		$temporaryFile = $temporaryFileFactory->make($fileExtension);
		$currentFile = $temporaryFile->copyFrom($file,null);            
		$reader = \Maatwebsite\Excel\Factories\ReaderFactory::make(null,$currentFile);
		$info = $reader->listWorksheetInfo($currentFile->getLocalPath());
		$totalRows = 0;
		foreach ($info as $sheet) {
			$totalRows+= $sheet['totalRows'];
		}
		$currentFile->delete();

		return $totalRows-1;
	}

	public function export()
	{	
		return FacadesExcel::download(new CodeExport, 'codes.xlsx');
	}

	public function markExported()
	{
		$codes = Code::where('user_id',Auth::id())->where('exported','0')->update(['exported'=>'1']);		

		return response(['status'=>'success','message'=>'Codes has been downloaded successfully.'],200);
	}

	public function action(CodeActionRequest $request) 
	{
		$input = $request->all();

		$check_serial = Code::where('code_data',$input['from_serial_no'])->where('product_id','>',0)->where('user_id',Auth::id())->first();

		if (!$check_serial) {
			return response(['errors'=>['from_serial_no'=>'This serial number does not exist or product is not asssigned.']],404);
		}

		$input['from_id'] = $check_serial->id;

		$codes = Code::orderBy('id','ASC')->where('user_id',Auth::id())->where('product_id','>',0)->where('id',$input['direction'],$check_serial->id)->limit($input['quantity']);
		
		$count = count($codes->get());

		if ($input['action']=='activate') {
			$codes->update(['status'=>'1']);
		}

		if ($input['action']=='deactivate') {
			$codes->update(['status'=>'0']);
		}

		Session::put('export_input', $input);
		
		return response(['status'=>'success','message'=>''.$count.' codes have been '.$input['action'].''.($input['action']!='export'?'d':'ed').' successfully. Please wait.'],200);
	}

	public function bulkexport()
	{
		$input = Session::get('export_input');
		$codes = Code::orderBy('id','ASC')->where('user_id',Auth::id())->where('id',$input['direction'],$input['from_id'])->limit($input['quantity'])->get();
		return Excel::download(new BulkExport($codes), 'codes.xlsx');
	}

	public function getbatches(Request $request)
	{
		$input = $request->all();

		$batches = Batch::where('product_id',$input['product_id'])->get();
		$view = view('vendor.codes.batches',['batches'=>$batches]);
		return $view->render();
	}
}
