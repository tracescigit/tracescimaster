<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
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

            $response       = Wallet::getWalletModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value);

            if(!$response){
                $wallets      = [];
                $last_page  = 0;
                $total = 0;
                $credit = 0;
                $debit = 0;
                $balance = 0;
            }
            else{
                $wallets     = $response['response'];
                $last_page   = $response['last_page'];
                $total       = $response['total'];
                $credit       = $response['credit'];
                $debit       = $response['debit'];
                $balance       = $response['balance'];
            }

            $walletData = array();
            $i = 1;

            foreach ($wallets as $wallet) {
                $u['user']    = $wallet->getUser->name??'-';
                $u['mobile']  = $wallet->getUser->phone??'-';
                $u['code_data']  = $wallet->getScan->getCode->code_data??'-';
                $u['type']  = ucfirst($wallet->type);
                $u['points']  = $wallet->points??'-';
                $u['amount']  = $wallet->amount??'-';
                $u['transaction_id']  = $wallet->transaction_id??'-';
                $u['created_at']  = date('M d, Y',strtotime($wallet->created_at));
                $u['status']  = $wallet->status??'-';

                $walletData[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                "last_page"         =>  $last_page,
                "data"              =>  $walletData,
                "total"             =>  $total,
                "credit"            =>  $credit,
                "debit"             =>  $debit,
                "balance"           =>  $balance
            ];

            return $return;
        }
        return view('vendor.wallets.index');
    }
}
