<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\BulkCodeUploadRequest;
use App\Http\Requests\Vendor\CodeBulkAssignRequest;
use App\Imports\CodeImport;
use App\Models\Batch;
use App\Models\Code;
use App\Models\Product;
use Auth;
use Excel;
use Illuminate\Http\Request;

class BulkController extends Controller
{
    public function index()
    {
        $products = Product::where('user_id',Auth::id())->get();
        return view('vendor.codes.bulk_upload')->with('products',$products);
    }

    public function store(BulkCodeUploadRequest $request)
    {
        try{
            ini_set('max_execution_time', 6000);

            $input = $request->all();
            $count = $this->getRows($input['file']);

            $data = [
                'user_id'     => Auth::id(),
                'product_id'  => NULL,
                'batch'       => NULL,
                'batch_id'    => NULL,
                'total_rows'  => $count
            ];

            if($count>getAvailableCredits(Auth::id())){
                return response(['status'=>'failed','message'=>'You do not have sufficient credits to upload data. Your file has '.$count.' code data but you only have '.getAvailableCredits(Auth::id()).' credits to use.'],400);
            }

            $file   = $request->file('file')->store('import');
            $import = Excel::import(new CodeImport($data), $file);
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

    public function assign(CodeBulkAssignRequest $request) 
    {
        $input = $request->all();
        $check_serial = Code::where('code_data',$input['from_serial_no'])->where('status','0')->where('user_id',Auth::id())->first();
        $batch = Batch::where('code',$input['batch'])->first();

        if (!$check_serial) {
            return response(['errors'=>['from_serial_no'=>'Code is already associated and active. Please deactivate and then assign.']],404);
        }
        
        $input['from_id'] = $check_serial->id;
        
        $codes = Code::orderBy('id','ASC')->where('user_id',Auth::id())->where('status','0')->where('id',$input['direction'],$check_serial->id)->limit($input['quantity']);
        
        $codes->update([
            'product_id'  => $input['product'],
            'batch'       => $input['batch'],
            'batch_id'    => $batch->id
        ]);

        return response(['status'=>'success','message'=>'Product and Batch assigned successfully.'],200);
    }
}
