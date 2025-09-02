<?php

namespace App\Http\Controllers\Vendor;

use App\Exports\Vendor\CouponCodeExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\RewardSchemeCreateRequest;
use App\Http\Requests\Vendor\RewardSchemeUpdateRequest;
use App\Models\Batch;
use App\Models\Code;
use App\Models\CouponCode;
use App\Models\Product;
use App\Models\RewardScheme;
use App\Models\Wallet;
use Auth;
use Excel;
use Illuminate\Http\Request;

class RewardController extends Controller
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

            $response       = RewardScheme::getRewardSchemeModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value);

            if(!$response){
                $rewards      = [];
                $last_page  = 0;
                $total = 0;
            }
            else{
                $rewards      = $response['response'];
                $last_page   = $response['last_page'];
                $total       = $response['total'];
            }

            $rewardData = array();
            $i = 1;

            foreach ($rewards as $reward) {


                $u['title']     = $reward->title??'-';
                $u['from']      = $reward->from??'-';
                $u['to']        = $reward->to??'-';
                $u['status']    = $reward->status??'-';

                $actions            = view('vendor.rewards.actions',['reward' => $reward]);
                $u['actions']       = $actions->render(); 

                $rewardData[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                "last_page"         =>  $last_page,
                "data"              =>  $rewardData,
                "total"=>$total
            ];

            return $return;
        }
        return view('vendor.rewards.index');
    }

    public function create()
    {   
        $products = Product::where('user_id',Auth::user()->parent_id??Auth::id())->where('status','1')->get();
        return view('vendor.rewards.create')->with('page_name','vendor-rewards')->with('products',$products); 
    }

    public function store(RewardSchemeCreateRequest $request)
    {
        try{
            $input   = $request->all();

            $reward = new RewardScheme;

            $reward->title = $input['title'];
            $reward->from = $input['from'];
            $reward->to  = $input['to'];
            $reward->points  = $input['reward_points'];
            $reward->user_id = Auth::user()->parent_id??Auth::id();
            $reward->status = $input['status'];
            $reward->product_selection_type = $input['product_selection_type'];

            $items = [];

            // dd($input);

            if (isset($input['points']) && count($input['points'])>0) {
                for ($i=0; $i < count($input['points']); $i++) { 
                    $item = [
                        'points'    => $input['points'][$i],
                        'item'      => $input['items'][$i],
                        'type'      => $input['types'][$i]
                    ];
                    array_push($items, $item);
                }
            }

            $reward->items = json_encode($items);
            $reward->save();

            if ($input['product_selection_type']=='product') {
                $reward->product_id = $input['product'];
                $product_codes = Code::where('user_id',Auth::user()->parent_id??Auth::id())->where('product_id',$input['product'])->get();
                if (!$product_codes->isEmpty()) {
                    foreach ($product_codes as $product_code) {

                        $exists = CouponCode::where('user_id',Auth::user()->parent_id??Auth::id())->where('code_id',$product_code->id)->where('reward_id',$reward->id)->exists();

                        if (!$exists) {
                            CouponCode::create([
                                'user_id' => Auth::user()->parent_id??Auth::id(),
                                'code_id' => $product_code->id,
                                'reward_id' => $reward->id,
                                'coupon_code' => getCouponCode()
                            ]);
                        }
                    }
                }

            }elseif($input['product_selection_type']=='batch'){
                $batch = Batch::where('code',$input['batch'])->first();
                $reward->batch_id = $batch->id;

                $batch_codes = Code::where('user_id',Auth::user()->parent_id??Auth::id())->where('batch_id',$reward->batch_id)->get();

                if (!$batch_codes->isEmpty()) {
                    foreach ($batch_codes as $batch_code) {

                        $exists = CouponCode::where('user_id',Auth::user()->parent_id??Auth::id())->where('code_id',$batch_code->id)->where('reward_id',$reward->id)->exists();

                        if (!$exists) {
                            CouponCode::create([
                                'user_id' => Auth::user()->parent_id??Auth::id(),
                                'code_id' => $batch_code->id,
                                'reward_id' => $reward->id,
                                'coupon_code' => getCouponCode()
                            ]);
                        }

                    }
                }

            }else{
                $codes = [];

                if (isset($input['from_codes']) && count($input['from_codes'])>0) {
                    for ($i=0; $i < count($input['from_codes']); $i++) { 
                        $item = [
                            'from'  => $input['from_codes'][$i],
                            'to'    => $input['to_codes'][$i],
                        ];
                        array_push($codes, $item);

                        $from = Code::where('user_id',Auth::user()->parent_id??Auth::id())->where('code_data',$input['from_codes'][$i])->first();
                        $to = Code::where('user_id',Auth::user()->parent_id??Auth::id())->where('code_data',$input['to_codes'][$i])->first();

                        if ($from && $to && $to->id>$from->id) {
                            $between_codes = Code::where('user_id',Auth::user()->parent_id??Auth::id())->where('id','>=',$from->id)->where('id','<=',$to->id)->get();
                            if (!$between_codes->isEmpty()) {
                                foreach ($between_codes as $between_code) {

                                    $exists = CouponCode::where('user_id',Auth::user()->parent_id??Auth::id())->where('code_id',$between_code->id)->where('reward_id',$reward->id)->exists();

                                    if (!$exists) {
                                        CouponCode::create([
                                            'user_id' => Auth::user()->parent_id??Auth::id(),
                                            'code_id' => $between_code->id,
                                            'reward_id' => $reward->id,
                                            'coupon_code' => getCouponCode()
                                        ]);
                                    }
                                }
                            }
                        }

                    }
                }

                $reward->codes = json_encode($codes);
            }

            $reward->save();

            return response(['message'=>'Reward Scheme created successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function edit($id)
    {   
        $id = decrypt($id);

        $reward = RewardScheme::find($id);
        $products = Product::where('user_id',Auth::user()->parent_id??Auth::id())->where('status','1')->get();
        $batch = null;

        if ($reward->batch_id) {
            $batch = Batch::find($reward->batch_id);
        }

        return view('vendor.rewards.edit')->with('reward',$reward)->with('page_name', 'vendor-rewards')->with('products',$products)->with('batch',$batch);
    }

    public function update(RewardSchemeUpdateRequest $request ,$id)
    {
        try{
            $id = decrypt($id);

            $input   = $request->all();
            $reward = RewardScheme::find($id);

            $reward->title = $input['title'];
            $reward->from = $input['from'];
            $reward->to  = $input['to'];
            $reward->points  = $input['reward_points'];
            $reward->user_id = Auth::user()->parent_id??Auth::id();
            $reward->status = $input['status'];

            $old_type = $reward->product_selection_type;

            $reward->product_selection_type = $input['product_selection_type'];

            $items = [];
            if (isset($input['points']) && count($input['points'])>0) {
                for ($i=0; $i < count($input['points']); $i++) { 
                    $item = [
                        'points'    => $input['points'][$i],
                        'item'      => $input['items'][$i],
                        'type'      => $input['types'][$i]
                    ];
                    array_push($items, $item);
                }
            }
            $reward->items = json_encode($items);
            $reward->save();

            if ($old_type!=$input['product_selection_type']) {
                $delete = CouponCode::where('reward_id',$reward->id)->delete();
            }

            if ($input['product_selection_type']=='product') {
                $reward->product_id = $input['product'];
                $product_codes = Code::where('user_id',Auth::user()->parent_id??Auth::id())->where('product_id',$input['product'])->get();
                if (!$product_codes->isEmpty()) {
                    foreach ($product_codes as $product_code) {

                        $exists = CouponCode::where('user_id',Auth::user()->parent_id??Auth::id())->where('code_id',$product_code->id)->where('reward_id',$reward->id)->exists();

                        if (!$exists) {
                            CouponCode::create([
                                'user_id' => Auth::user()->parent_id??Auth::id(),
                                'code_id' => $product_code->id,
                                'reward_id' => $reward->id,
                                'coupon_code' => getCouponCode()
                            ]);
                        }
                    }
                }

            }elseif($input['product_selection_type']=='batch'){
                $batch = Batch::where('code',$input['batch'])->first();
                $reward->batch_id = $batch->id;

                $batch_codes = Code::where('user_id',Auth::user()->parent_id??Auth::id())->where('batch_id',$reward->batch_id)->get();

                if (!$batch_codes->isEmpty()) {
                    foreach ($batch_codes as $batch_code) {

                        $exists = CouponCode::where('user_id',Auth::user()->parent_id??Auth::id())->where('code_id',$batch_code->id)->where('reward_id',$reward->id)->exists();

                        if (!$exists) {
                            CouponCode::create([
                                'user_id' => Auth::user()->parent_id??Auth::id(),
                                'code_id' => $batch_code->id,
                                'reward_id' => $reward->id,
                                'coupon_code' => getCouponCode()
                            ]);
                        }

                    }
                }

            }else{
                $codes = [];

                if (isset($input['from_codes']) && count($input['from_codes'])>0) {
                    for ($i=0; $i < count($input['from_codes']); $i++) { 
                        $item = [
                            'from'  => $input['from_codes'][$i],
                            'to'    => $input['to_codes'][$i],
                        ];
                        array_push($codes, $item);

                        $from = Code::where('user_id',Auth::user()->parent_id??Auth::id())->where('code_data',$input['from_codes'][$i])->first();
                        $to = Code::where('user_id',Auth::user()->parent_id??Auth::id())->where('code_data',$input['to_codes'][$i])->first();

                        if ($from && $to && $to->id>$from->id) {
                            $between_codes = Code::where('user_id',Auth::user()->parent_id??Auth::id())->where('id','>=',$from->id)->where('id','<=',$to->id)->get();
                            if (!$between_codes->isEmpty()) {
                                foreach ($between_codes as $between_code) {

                                    $exists = CouponCode::where('user_id',Auth::user()->parent_id??Auth::id())->where('code_id',$between_code->id)->where('reward_id',$reward->id)->exists();

                                    if (!$exists) {
                                        CouponCode::create([
                                            'user_id' => Auth::user()->parent_id??Auth::id(),
                                            'code_id' => $between_code->id,
                                            'reward_id' => $reward->id,
                                            'coupon_code' => getCouponCode()
                                        ]);
                                    }
                                }
                            }
                        }

                    }
                }

                $reward->codes = json_encode($codes);
            }

            $reward->save();

            return response(['message'=>'Reward Scheme updated successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function destroy($id)
    {
        try{
            $id = decrypt($id);

            $reward = RewardScheme::find($id);
            $reward->delete();

            return response(['message'=>'Reward Scheme deleted successfully.'], 200);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function download($id)
    {
        $id = decrypt($id);
        $reward = RewardScheme::find($id);
        $coupon_codes = CouponCode::where('reward_id',$reward->id)->get();

        return Excel::download(new CouponCodeExport($coupon_codes), 'coupon_codes.xlsx');
    }

    public function show($id)
    {
        $id = decrypt($id);

        $reward = RewardScheme::find($id);
        $transactions = Wallet::where('reward_id',$reward->id)->get();
        $credits = Wallet::where('type','credit')->where('status','Success')->where('reward_id',$reward->id)->sum('points');
        $debits = Wallet::where('type','debit')->where('status','Success')->where('reward_id',$reward->id)->sum('points');
        $balance = $credits-$debits;

        return view('vendor.rewards.transactions')->with('reward',$reward)->with('credits',$credits)->with('debits',$debits)->with('balance',$balance)->with('transactions',$transactions);
    }
}
