<?php

namespace App\Http\Controllers\Api\SupplyChain;

use App\Http\Controllers\Controller;
use App\Models\Aggregation;
use App\Models\SupplyChain;
use App\Models\SupplyChainAction;
use App\Models\SupplyChainScanHistory;
use App\Models\User;
use App\Models\SuppplyChainStatus;
use Illuminate\Http\Request;
use Validator;
use BrosSquad\LaravelCrypto\Facades\Hashing;

class ScanController extends Controller
{
    public function scan(Request $request)
    {
        $input = $request->all();

        $rules = [
            'token'       =>  'required',
            'code'        =>  'required',
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

            $check_user = SupplyChain::where('user_id',$id)->first();
            // ->where('supply_chain_parent_id',NULL)
            if (!$check_user) {
                return response([
                    'success' => false,
                    'message' => 'Unauthorized user.',
                    'errors' => ['user' => ['You are not allowed to scan this item.']]
                ], 400);
            }

            $user = User::find($id);

            $aggregation = Aggregation::where('user_id',$user->parent_id??$user->id)->where('unique_id',$input['code'])->first();
            // ->where('parent_id',NULL)
            if (!$aggregation) {
                return response([
                    'success' => false,
                    'message' => 'Invalid code.',
                    'errors' => ['user' => ['Please scan correct code.']]
                ], 400);
            }

            $codes = $this->getCodesInside($input['code'],$user->parent_id??$user->id);
            $response = [];
            $action  = [];

            $action['eligible_for'] = 'checkout';
            $last_action  = SupplyChainAction::where('user_id',$user->parent_id??$user->id)->where('aggregation_unique_id',$input['code'])->orderBy('created_at','DESC')->first();

            $allowed = true;

            if ($last_action && (($last_action->action=='checkout' && $last_action->action_for!=$user->id) || ($last_action->action=='checkin' && $last_action->action_by!=$user->id))) {
                $allowed = false;
            }

            if (!$last_action && $aggregation->parent_id) {
                $parent_aggregation = Aggregation::find($aggregation->parent_id);
                $parent_last_action = SupplyChainAction::where('user_id',$user->parent_id??$user->id)->where('aggregation_unique_id',$parent_aggregation->unique_id)->orderBy('created_at','DESC')->first();
                if ($parent_last_action && $parent_last_action->action=='checkin' && $parent_last_action->action_by!=$user->id ) {
                    $allowed = false;
                }
            }

            $in_history = SupplyChainScanHistory::where('user_id',$user->parent_id??$user->id)->where('aggregation_unique_id',$input['code'])->where('scanned_by',$user->id)->exists();

            if ($allowed==false && $in_history) {
                $allowed=true;
            }            

            if ($allowed==false) {

                $add_alert = addSupplyChainAlerts([
                    'alert_message'  => 'Aggregation scanned at wrong location.',
                    'aggregation_id' => $aggregation->id,
                    'scanned_by'     => $user->id,
                    'user_id'        => $user->parent_id??$user->id
                ]);

                return response([
                    'success' => false,
                    'message' => 'Unauthorized user.',
                    'errors' => ['user' => ['You are not allowed to scan this item.']]
                ], 400);
            }

            if ($last_action && $last_action->action=='checkout') {
                $action['eligible_for'] = 'checkin';
            }


            if ($action['eligible_for'] == 'checkout') {
                $action_users = SupplyChain::where('supply_chain_parent_id',$user->id)->get();
                $users_arr = [];

                if (count($action_users)>0) {
                    foreach ($action_users as $action_user) {
                        $user_item = [];
                        $user_item['label'] = $action_user->getUser->name;
                        $user_item['value'] = $action_user->getUser->id;
                        array_push($users_arr, $user_item);
                    }
                }

                $me = SupplyChain::where('user_id',$user->id)->first();

                if ($me->supply_chain_parent_id) {
                    $my_parent = SupplyChain::where('user_id',$me->supply_chain_parent_id)->first();
                    $user_item = [];
                    $user_item['label'] = $my_parent->getUser->name;
                    $user_item['value'] = $my_parent->getUser->id;
                    array_push($users_arr, $user_item);
                }

                $action['users'] = $users_arr;
            }


            if (!empty($codes) && count($codes)>0) {
                foreach ($codes as $key => $code) {
                    if (!$this->responseHasProduct($response,$code->getBatch)) {

                        $item = [];

                        $item['name']   = $code->getProduct->name ?? '';
                        $item['brand']  = $code->getProduct->brand ?? '';
                        // $item['description'] = $code->getProduct->description ?$code->getProduct->description: '';
                        $item['price']  = $code->getProduct->price ?( $code->getProduct->currency.' '.$code->getProduct->price): '';
                        $item['manufacturer']       = $code->getUser->getCompany->name??'';
                        $item['batch_code']         = $code->getBatch ?$code->getBatch->code: '';
                        $item['manufactured_on']    = $code->getBatch->mfg_date ? date('M d, Y H:i:s', strtotime($code->getBatch->mfg_date)) : '';
                        $item['expiry_on']          = $code->getBatch->exp_date ? date('M d, Y H:i:s', strtotime($code->getBatch->exp_date)) : '';
                        $item['image']              = $code->getProduct ? ($code->getProduct->image_url?asset($code->getProduct->image_url):'') : '';
                        $item['label_image']        = $code->getProduct ? ($code->getProduct->label_image_url?asset($code->getProduct->label_image_url):'') : '';
                        $item['media']              = $code->getProduct ? ($code->getProduct->media?asset($code->getProduct->media):'') : '';

                        array_push($response,$item);
                    }
                }
            }

            $history = SupplyChainScanHistory::where('aggregation_unique_id',$input['code'])->where('scanned_by',$user->supply_parent_id??$user->id)->orderBy('created_at','DESC')->first();

            $has_action   = false;

            if ($history) {
                $has_action = SupplyChainAction::where('scan_id',$history->id)->exists();
            }

            if (!$history || $has_action==true) {
                $history = new SupplyChainScanHistory;
                $history->user_id = $user->parent_id??$user->id;
                $history->aggregation_unique_id = $input['code'];
            }

            $history->scanned_by = $user->supply_parent_id??$user->id;
            $history->ip_address = $request->ip();

            if (isset($input['location'])) {
                $history->location = json_encode($input['location']);
            }

            $history->save();

            $last_scanned = null;
            $last_scan    = SupplyChainScanHistory::where('user_id',$user->parent_id??$user->id)->where('aggregation_unique_id',$input['code'])->orderBy('created_at','DESC')->skip(1)->first();

            if ($last_scan) {
                $last_scanned = date('M d, Y H:i:s', strtotime($last_scan->created_at));
            }

            $action['scan_id'] = $history->id;

            $isOpened = SupplyChainAction::where('user_id',$user->parent_id??$user->id)->where('parent_aggregation_unique_id',$input['code'])->orderBy('created_at','DESC')->exists();

            if ($isOpened || ($last_action && $last_action->action_by==$user->id && $last_action->action=='checkout') || ($last_action && $last_action->action=='checkin' && $last_action->action_by!=$user->id) || ($last_action && $last_action->action=='checkout' && $last_action->action_for!=$user->id)) {
                $action['eligible_for']='';
                $action['users']= [];
                $action['scan_id'] = '';
                $history->delete();
            }

            $status_arr = [];
            $all_status = SuppplyChainStatus::get();

            if (count($all_status)>0) {
                foreach ($all_status as $status) {
                    $status_item = [];
                    $status_item['label']   = $status->status;
                    $status_item['value']   = $status->status;
                    $status_item['comment'] = $status->placeholder;
                    array_push($status_arr, $status_item);
                }
            }
            $action['status'] = $status_arr;

            $history = prepareSupplyChainScanHistory($input['code'],$user->parent_id??$user->id);

            if (empty($history) && $aggregation->parent_id) {
                $parent_aggregation = Aggregation::find($aggregation->parent_id);
                $history = prepareSupplyChainScanHistory($parent_aggregation->unique_id,$user->parent_id??$user->id);
            }

            return response([
                'success'               => true,
                'message'               => 'Product details fetched successfully',
                'total'                 => count($codes),
                'aggregation_unique_id' => $input['code'],
                'last_scanned'          => $last_scanned,
                'action'                => $action,
                'history'               => $history,
                'products'              => $response
            ], 200);
        }
    }

    public function responseHasProduct($response,$batch)
    {
        $exists = false;
        if (!empty($response) && count($response)>0) {
            foreach ($response as $key => $value) {
                if ($value['batch_code']==$batch->code) {
                    $exists = true;
                }
            }
        }
        return $exists;
    }

    public function getCodesInside($unique_id,$user_id,$codes=[])
    {
        $aggregation = Aggregation::where('user_id',$user_id)->where('unique_id',$unique_id)->first();

        if (strtolower($aggregation->level)=='primary') {
            foreach ($aggregation->getCodes as $key => $code) {
                if (!in_array($code, $codes)) {
                    array_push($codes, $code);
                }
            }
        }else{
            foreach ($aggregation->getChildren as $key => $child) {
                $codes = $this->getCodesInside($child->unique_id,$user_id,$codes);
            }
        }

        return $codes;
    }

    public function scanHistory(Request $request)
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

            $histories = SupplyChainScanHistory::where('scanned_by', $user->supply_parent_id??$user->id)->get();
            $response = [];

            if (count($histories)>0) {

                foreach ($histories as $history_key => $history) {                    
                    $item = [];
                    $item['aggregation_unique_id'] = $history->aggregation_unique_id;
                    $item['location']              = json_decode($history->location,true);
                    $item['ip_address']            = $history->ip_address;
                    $item['scanned_at']            = date('M d, Y H:i:s', strtotime($history->created_at));
                    $item['products']              = [];

                    $codes = $this->getCodesInside($history->aggregation_unique_id,$user->parent_id??$user->id);

                    if (!empty($codes) && count($codes)>0) {
                        foreach ($codes as $key => $code) {
                            if (!$this->responseHasProduct($item['products'],$code->getBatch)) {
                                $product_item = [];
                                $product_item['name']   = $code->getProduct->name ?? '';
                                $product_item['brand']  = $code->getProduct->brand ?? '';
                                // $product_item['description'] = $code->getProduct->description ?$code->getProduct->description: '';
                                $product_item['price']  = $code->getProduct->price ?( $code->getProduct->currency.' '.$code->getProduct->price): '';
                                $product_item['manufacturer']       = $code->getUser->getCompany->name??'';
                                $product_item['batch_code']         = $code->getBatch ?$code->getBatch->code: '';
                                $product_item['manufactured_on']    = $code->getBatch->mfg_date ? date('M d, Y H:i:s', strtotime($code->getBatch->mfg_date)) : '';
                                $product_item['expiry_on']          = $code->getBatch->exp_date ? date('M d, Y H:i:s', strtotime($code->getBatch->exp_date)) : '';
                                $product_item['image']              = $code->getProduct ? ($code->getProduct->image_url?asset($code->getProduct->image_url):'') : '';
                                $product_item['label_image']        = $code->getProduct ? ($code->getProduct->label_image_url?asset($code->getProduct->label_image_url):'') : '';
                                $product_item['media']              = $code->getProduct ? ($code->getProduct->media?asset($code->getProduct->media):'') : '';
                                array_push($item['products'],$product_item);
                            }
                        }
                    }

                    $response[$history_key] = $item;

                }

            }

            return response([
                'success' => true,
                'message' => 'Scan history fetched successfully',
                'total'   => count($codes),
                'scans'   => $response
            ], 200);
        }
    }

    public function action(Request $request)
    {
        $input = $request->all();

        $rules = [
            'token'       =>  'required',
            'action'      =>  'required|in:checkin,checkout',
            'scan_id'     =>  'required|exists:supply_chain_scan_histories,id',
        ];

        if (isset($input['action']) && $input['action']=='checkout') {
            $rules['user'] = 'required|exists:supply_chains,user_id';
        }

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

            $check_user = SupplyChain::where('user_id',$id)->first();

            if (!$check_user) {
                return response([
                    'success' => false,
                    'message' => 'Unauthorized user.',
                    'errors' => ['user' => ['You are not allowed to scan this item.']]
                ], 400);
            }

            $user = User::find($id);

            $scan = SupplyChainScanHistory::find($input['scan_id']);
            $eligible_for = 'checkout';
            $last_action  = SupplyChainAction::where('user_id',$user->parent_id??$user->id)->where('aggregation_unique_id',$scan->aggregation_unique_id)->orderBy('created_at','DESC')->first();

            if ($last_action && $last_action->action=='checkout') {
                $eligible_for = 'checkin';
            }

            if ($eligible_for!=$input['action']) {
                return response([
                    'success' => false,
                    'message' => 'Action not allowed.',
                    'errors' => ['action' => ['This action is not allowed.']]
                ], 400);
            }

            if (SupplyChainAction::where('scan_id',$scan->id)->exists()) {
                return response([
                    'success' => false,
                    'message' => 'Scan is invalid.',
                    'errors' => ['scan_id' => ['Please scan again.']]
                ], 400);
            }

            if ($last_action && $last_action->action==$input['action'] && $last_action->action_by==$id) {
                return response([
                    'success' => false,
                    'message' => 'Action not allowed.',
                    'errors' => ['action' => ['You already have performed this action.']]
                ], 400);
            }

            if ($eligible_for=='checkin' && $last_action && $last_action->action_for!=$id) {
                return response([
                    'success' => false,
                    'message' => 'Action not allowed.',
                    'errors' => ['action' => ['You are not allowed to perform this action.']]
                ], 400);
            }

            $supply_chain_action = new SupplyChainAction;
            $supply_chain_action->scan_id               = $scan->id;
            $supply_chain_action->user_id               = $user->parent_id??$user->id;
            $supply_chain_action->aggregation_unique_id = $scan->aggregation_unique_id;
            $supply_chain_action->action                = $input['action'];
            $supply_chain_action->action_by             = $user->id;
            $supply_chain_action->aggregation_unique_id = $scan->aggregation_unique_id;

            if ($input['action']=='checkout') {
                $supply_chain_action->action_for        = $input['user'];
            }

            if (isset($input['comment']) && $input['comment']!='') {
                $supply_chain_action->comment           = $input['comment'];
            }

            if (isset($input['status']) && $input['status']!='') {
                $supply_chain_action->status            = $input['status'];
            }

            $current_hash = Hashing::hash($scan->aggregation_unique_id);
            $supply_chain_action->current_hash = $current_hash;

            $block_data = $scan->id.','.$scan->aggregation_unique_id.','.$current_hash;

            $parent_aggregation = null;
            $aggregation = Aggregation::where('user_id',$user->parent_id??$user->id)->where('unique_id',$scan->aggregation_unique_id)->first();
            
            if ($aggregation->parent_id) {
                $parent_aggregation = Aggregation::find($aggregation->parent_id);
                $supply_chain_action->parent_aggregation_unique_id = $parent_aggregation->unique_id;
                $parent_hash = Hashing::hash($parent_aggregation->unique_id);

                $supply_chain_action->parent_hash = $parent_hash;
                $block_data = $block_data.','.$parent_aggregation->unique_id.','.$parent_hash;
            }

            $supply_chain_action->block_hash = Hashing::hash($block_data);

            $supply_chain_action->save();            

            return response([
                'success'   => true,
                'message'   => 'Action performed successfully.',
            ], 200);

        }
    }

    public function verifyHash($block_hash)
    {
        $action = SupplyChainAction::where('block_hash',$block_hash)->first();
        $verified = false;

        if ($action) {
            $scan = SupplyChainScanHistory::find($action->scan_id);
            $block_data = $scan->id.','.$scan->aggregation_unique_id.','.$action->current_hash;

            if ($action->parent_hash) {
                $block_data = $block_data.','.$action->parent_aggregation_unique_id.','.$action->parent_hash;
            }

            $verified = Hashing::verify($block_hash,$block_data);
        }

        return $verified;
    }
}
