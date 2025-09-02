<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\CashbackCreateRequest;
use App\Http\Requests\Vendor\CashbackUpdateRequest;
use App\Models\Cashback;
use App\Models\CashbackWinner;
use Auth;
use Illuminate\Http\Request;
use App\Models\Code;
use App\Models\ScanHistory;

class CashbackController extends Controller
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

            $response       = Cashback::getCashbackModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value);

            if(!$response){
                $cashbacks      = [];
                $last_page  = 0;
                $total = 0;
            }
            else{
                $cashbacks      = $response['response'];
                $last_page   = $response['last_page'];
                $total       = $response['total'];
            }

            $cashbackData = array();
            $i = 1;

            foreach ($cashbacks as $cashback) {


                $u['title']     = $cashback->title??'-';
                $u['from']      = $cashback->from??'-';
                $u['to']        = $cashback->to??'-';
                $u['status']    = $cashback->status??'-';

                $actions            = view('vendor.cashbacks.actions',['cashback' => $cashback]);
                $u['actions']       = $actions->render(); 

                $cashbackData[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                "last_page"         =>  $last_page,
                "data"              =>  $cashbackData,
                "total"=>$total
            ];

            return $return;
        }
        return view('vendor.cashbacks.index');
    }

    public function create()
    {
        return view('vendor.cashbacks.create')->with('page_name','vendor-cashbacks'); 
    }

    public function store(CashbackCreateRequest $request)
    {
        try{
            $input   = $request->all();

            $cashback = new Cashback;

            $cashback->title = $input['title'];
            $cashback->from = $input['from'];
            $cashback->to  = $input['to'];
            $cashback->description  = $input['description'];
            $cashback->user_id = Auth::user()->parent_id??Auth::id();
            $cashback->allow_multiple = $input['allow_multiple'];
            $cashback->status = $input['status'];
            $cashback->reshuffle_items = $input['reshuffle_items'];
            
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

            $cashback->codes = json_encode($codes);

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

            $cashback->items = json_encode($items);
            $cashback->save();

            return response(['message'=>'Cashback offer created successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function show($id)
    {
        $id = decrypt($id);

        $cashback = Cashback::find($id);
        $winners = CashbackWinner::where('vendor_id',Auth::user()->parent_id??Auth::id())->where('cashback_id',$cashback->id)->get();
        return view('vendor.cashbacks.view')->with('cashback',$cashback)->with('winners',$winners);
    }

    public function edit($id)
    {   
        $id = decrypt($id);
        $cashback = Cashback::find($id);
        return view('vendor.cashbacks.edit')->with('cashback',$cashback)->with('page_name', 'vendor-cashbacks');
    }

    public function update(CashbackUpdateRequest $request ,$id)
    {
        try{
            $id = decrypt($id);

            $input   = $request->all();
            $cashback = Cashback::find($id);

            $cashback->title = $input['title'];
            $cashback->from = $input['from'];
            $cashback->to  = $input['to'];
            $cashback->description  = $input['description'];
            $cashback->user_id = Auth::user()->parent_id??Auth::id();
            $cashback->allow_multiple = $input['allow_multiple'];
            $cashback->status = $input['status'];
            $cashback->reshuffle_items = $input['reshuffle_items'];

            
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

            $cashback->codes = json_encode($codes);

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

            $cashback->items = json_encode($items);
            $cashback->save();

            return response(['message'=>'Cashback offer updated successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function execute($id)
    {
        $id = decrypt($id);

        $cashback = Cashback::find($id);

        $codes_in_cashback = array();

        
        $codes = json_decode($cashback->codes,true);

        if (!empty($codes)) {
            foreach ($codes as $code) {
                $from = Code::where('user_id',Auth::user()->parent_id??Auth::id())->where('code_data',$code['from'])->first();
                $to = Code::where('user_id',Auth::user()->parent_id??Auth::id())->where('code_data',$code['to'])->first();
                if ($from && $to && $to->id>$from->id) {
                    $between_codes = Code::where('user_id',Auth::user()->parent_id??Auth::id())->where('id','>=',$from->id)->where('id','<=',$to->id)->get();
                    if (!$between_codes->isEmpty()) {
                        foreach ($between_codes as $between_code) {
                            array_push($codes_in_cashback, $between_code->id);
                        }
                    }
                }
            }
        }
        

        if (!empty($codes_in_cashback)) {

            $items = json_decode($cashback->items,true);

            if (!empty($items)) {

                if ($cashback->reshuffle_items=='Yes') {
                    shuffle($items);
                }

                $delete_winners = CashbackWinner::where('vendor_id',Auth::user()->parent_id??Auth::id())->where('cashback_id',$cashback->id)->delete();

                $winner_user_ids = array();
                $wins = array();

                foreach ($items as $key => $item) {
                    $scans = ScanHistory::whereBetween('created_at',[$cashback->from,$cashback->to])->whereIn('code_id',$codes_in_cashback)->inRandomOrder()->limit($item['quantity'])->where('cashback_id',$cashback->id)->get();

                    foreach ($scans as $scan) {

                        if ($cashback->allow_multiple=='Yes') {
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

                        $create_win = new CashbackWinner;
                        $create_win->vendor_id = Auth::user()->parent_id??Auth::id();
                        $create_win->cashback_id = $cashback->id;
                        $create_win->winner_id = $scan_history->scanned_by;
                        $create_win->scan_id   = $scan_history->id;
                        $create_win->item      = $win['item'];
                        $create_win->quantity  = 1;

                        $create_win->save();
                    }
                }

            }
        }

        $cashback->status = 'Executed';
        $cashback->save();

        
        return redirect('vendor/cashbacks/'.encrypt($cashback->id).'/show');
    }

    public function finalize($id)
    {
        $id = decrypt($id);

        $cashback = Cashback::find($id);
        $cashback->status = 'Finalized';
        $cashback->save();

        $winners = CashbackWinner::where('vendor_id',Auth::user()->parent_id??Auth::id())->where('cashback_id',$cashback->id)->get();
        return redirect('vendor/cashbacks/'.encrypt($cashback->id).'/show');
    }
}
