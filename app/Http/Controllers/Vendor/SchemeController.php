<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\SchemeCreateRequest;
use App\Http\Requests\Vendor\SchemeUpdateRequest;
use App\Models\Batch;
use App\Models\Code;
use App\Models\Product;
use App\Models\ScanHistory;
use App\Models\Scheme;
use App\Models\SchemeWinner;
use App\Models\User;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SchemeController extends Controller
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

            $response       = Scheme::getSchemeModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value);

            if(!$response){
                $schemes      = [];
                $last_page  = 0;
                $total = 0;
            }
            else{
                $schemes      = $response['response'];
                $last_page   = $response['last_page'];
                $total       = $response['total'];
            }

            $schemeData = array();
            $i = 1;

            foreach ($schemes as $scheme) {


                $u['title']     = $scheme->title??'-';
                $u['from']      = $scheme->from??'-';
                $u['to']        = $scheme->to??'-';
                $u['status']    = $scheme->status??'-';

                $actions            = view('vendor.schemes.actions',['scheme' => $scheme]);
                $u['actions']       = $actions->render(); 

                $schemeData[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                "last_page"         =>  $last_page,
                "data"              =>  $schemeData,
                "total"=>$total
            ];

            return $return;
        }
        return view('vendor.schemes.index');
    }

    public function create()
    {   
        $products = Product::where('user_id',Auth::user()->parent_id??Auth::id())->where('status','1')->get();
        return view('vendor.schemes.create')->with('page_name','vendor-schemes')->with('products',$products); 
    }

    public function store(SchemeCreateRequest $request)
    {
        try{
            $input   = $request->all();

            $scheme = new Scheme;

            $scheme->title = $input['title'];
            $scheme->from = $input['from'];
            $scheme->to  = $input['to'];
            $scheme->user_id = Auth::user()->parent_id??Auth::id();
            $scheme->allow_multiple = $input['allow_multiple'];
            $scheme->status = $input['status'];
            $scheme->product_selection_type = $input['product_selection_type'];
            $scheme->reshuffle_items = $input['reshuffle_items'];

            if ($input['product_selection_type']=='product') {
                $scheme->product_id = $input['product'];
            }elseif($input['product_selection_type']=='batch'){
                $scheme->product_id = $input['product'];
                $batch = Batch::where('code',$input['batch'])->first();
                $scheme->batch_id = $batch->id;
            }else{
                $codes = [];

                if (isset($input['from_codes']) && count($input['from_codes'])>0) {
                    for ($i=0; $i < count($input['from_codes']); $i++) { 
                        $item = [
                            'from'  => $input['from_codes'][$i],
                            'to'    => $input['to_codes'][$i],
                        ];
                        array_push($codes, $item);
                    }
                }

                $scheme->codes = json_encode($codes);
            }

            $items = [];

            if (isset($input['items']) && count($input['items'])>0) {
                for ($i=0; $i < count($input['items']); $i++) { 
                    $item = [
                        'item'    => $input['items'][$i],
                        'quantity'=> $input['quantity'][$i],
                    ];
                    array_push($items, $item);
                }
            }

            $scheme->items = json_encode($items);
            
            $scheme->save();

            return response(['message'=>'Scheme created successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function edit($id)
    {   
        $id = decrypt($id);

        $scheme = Scheme::find($id);
        $products = Product::where('user_id',Auth::user()->parent_id??Auth::id())->where('status','1')->get();
        $batch = null;

        if ($scheme->batch_id) {
            $batch = Batch::find($scheme->batch_id);
        }

        return view('vendor.schemes.edit')->with('scheme',$scheme)->with('page_name', 'vendor-schemes')->with('products',$products)->with('batch',$batch);
    }

    public function update(SchemeUpdateRequest $request ,$id)
    {
        try{
            $id = decrypt($id);

            $input   = $request->all();
            $scheme = Scheme::find($id);

            $scheme->title = $input['title'];
            $scheme->from = $input['from'];
            $scheme->to  = $input['to'];
            $scheme->user_id = Auth::user()->parent_id??Auth::id();
            $scheme->allow_multiple = $input['allow_multiple'];
            $scheme->status = $input['status'];
            $scheme->product_selection_type = $input['product_selection_type'];
            $scheme->reshuffle_items = $input['reshuffle_items'];

            if ($input['product_selection_type']=='product') {
                $scheme->product_id = $input['product'];
            }elseif($input['product_selection_type']=='batch'){
                $scheme->product_id = $input['product'];
                $batch = Batch::where('code',$input['batch'])->first();
                $scheme->batch_id = $batch->id;
            }else{
                $codes = [];

                if (isset($input['from_codes']) && count($input['from_codes'])>0) {
                    for ($i=0; $i < count($input['from_codes']); $i++) { 
                        $item = [
                            'from'  => $input['from_codes'][$i],
                            'to'    => $input['to_codes'][$i],
                        ];
                        array_push($codes, $item);
                    }
                }

                $scheme->codes = json_encode($codes);
            }

            $items = [];

            if (isset($input['items']) && count($input['items'])>0) {
                for ($i=0; $i < count($input['items']); $i++) { 
                    $item = [
                        'item'    => $input['items'][$i],
                        'quantity'=> $input['quantity'][$i],
                    ];
                    array_push($items, $item);
                }
            }

            $scheme->items = json_encode($items);

            $scheme->save();

            return response(['message'=>'Scheme updated successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function destroy($id)
    {
        try{
            $id = decrypt($id);

            $scheme = Scheme::find($id);
            $scheme->delete();
            
            return response(['message'=>'Scheme deleted successfully.'], 200);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function show($id)
    {
        $id = decrypt($id);

        $scheme = Scheme::find($id);
        $winners = SchemeWinner::where('vendor_id',Auth::user()->parent_id??Auth::id())->where('scheme_id',$scheme->id)->get();
        return view('vendor.schemes.view')->with('scheme',$scheme)->with('winners',$winners);
    }

    public function execute($id)
    {
        $id = decrypt($id);

        $scheme = Scheme::find($id);

        $codes_in_scheme = array();

        if($scheme->product_selection_type=='product'){
            $product_codes = Code::where('user_id',Auth::user()->parent_id??Auth::id())->where('product_id',$scheme->product_id)->get();
            if (!$product_codes->isEmpty()) {
                foreach ($product_codes as $product_code) {
                    array_push($codes_in_scheme, $product_code->id);
                }
            }
        }elseif($scheme->product_selection_type=='batch'){
            $batch_codes = Code::where('user_id',Auth::user()->parent_id??Auth::id())->where('batch_id',$scheme->batch_id)->get();
            if (!$batch_codes->isEmpty()) {
                foreach ($batch_codes as $batch_code) {
                    array_push($codes_in_scheme, $batch_code->id);
                }
            }
        }
        else{
            $codes = json_decode($scheme->codes,true);

            if (!empty($codes)) {
                foreach ($codes as $code) {
                    $from = Code::where('user_id',Auth::user()->parent_id??Auth::id())->where('code_data',$code['from'])->first();
                    $to = Code::where('user_id',Auth::user()->parent_id??Auth::id())->where('code_data',$code['to'])->first();
                    if ($from && $to && $to->id>$from->id) {
                        $between_codes = Code::where('user_id',Auth::user()->parent_id??Auth::id())->where('id','>=',$from->id)->where('id','<=',$to->id)->get();
                        if (!$between_codes->isEmpty()) {
                            foreach ($between_codes as $between_code) {
                                array_push($codes_in_scheme, $between_code->id);
                            }
                        }
                    }
                }
            }
        }

        if (!empty($codes_in_scheme)) {

            $items = json_decode($scheme->items,true);

            if (!empty($items)) {

                if ($scheme->reshuffle_items=='Yes') {
                    shuffle($items);
                }

                $delete_winners = SchemeWinner::where('vendor_id',Auth::user()->parent_id??Auth::id())->where('scheme_id',$scheme->id)->delete();

                $winner_user_ids = array();
                $wins = array();

                foreach ($items as $key => $item) {
                    $scans = ScanHistory::whereBetween('created_at',[$scheme->from,$scheme->to])->whereIn('code_id',$codes_in_scheme)->inRandomOrder()->limit($item['quantity'])->get();

                    foreach ($scans as $scan) {

                        if ($scheme->allow_multiple=='Yes') {
                            array_push($winner_user_ids,$scan->scanned_by);
                            $item = [
                                'scan_id' => $scan->id,
                                'item'    => $item['item']
                            ];
                            array_push($wins,$item);
                        }else{
                            if (!in_array($scan->scanned_by, $winner_user_ids)) {
                                array_push($winner_user_ids,$scan->scanned_by);
                                $item = [
                                    'scan_id' => $scan->id,
                                    'item'    => $item['item']
                                ];
                                array_push($wins,$item);
                            }
                        }
                        
                    }
                }

                if (!empty($wins)) {
                    foreach ($wins as $win) {

                        $scan_history = ScanHistory::find($win['scan_id']);

                        $create_win = new SchemeWinner;
                        $create_win->vendor_id = Auth::user()->parent_id??Auth::id();
                        $create_win->scheme_id = $scheme->id;
                        $create_win->winner_id = $scan_history->scanned_by;
                        $create_win->scan_id   = $scan_history->id;
                        $create_win->item      = $win['item'];
                        $create_win->quantity  = 1;

                        $create_win->save();
                    }
                }

            }
        }

        $scheme->status = 'Executed';
        $scheme->save();

        
        return redirect('vendor/schemes/'.encrypt($scheme->id).'/show');
    }

    public function finalize($id)
    {
        $id = decrypt($id);

        $scheme = Scheme::find($id);
        $scheme->status = 'Finalized';
        $scheme->save();

        $winners = SchemeWinner::where('vendor_id',Auth::user()->parent_id??Auth::id())->where('scheme_id',$scheme->id)->get();
        return redirect('vendor/schemes/'.encrypt($scheme->id).'/show');
    }

}