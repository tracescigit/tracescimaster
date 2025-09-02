<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Wallet extends Model
{
    use HasFactory;

    public static function getWalletModel($limit, $page, $orderby, $order , $search_field , $search_type, $search_value)
    {
        $q = Wallet::leftJoin('reward_schemes', 'wallets.reward_id', '=', 'reward_schemes.id')
        ->leftJoin('users', 'wallets.user_id', '=', 'users.id')
        ->select(['wallets.*','users.phone'])->where('reward_schemes.user_id',Auth::id());

        $orderby  = $orderby ? $orderby : 'wallets.created_at';
        $order    = $order ? $order : 'DESC';

        if($search_value && !empty($search_value))
        {   
            $search_value = strtolower($search_value);         
            $q->where(function($query) use ($search_field , $search_type, $search_value) {
                $query->where($search_field, $search_type, ($search_type=='like'?('%'.$search_value.'%'):$search_value));
            });
        }

        
        $total = $q->count();

        $credit_q = clone $q;
        $debit_q = clone $q;

        $credit = $credit_q->where('wallets.type','credit')->sum('wallets.points');
        $debit = $debit_q->where('wallets.type','debit')->sum('wallets.points');
        $balance = $credit-$debit;

        $response =  $q->orderBy($orderby, $order)->paginate($limit, ['*'], 'page', $page);

        return ['response' => $response,'last_page' => $response->lastPage(),'total'=>$total,'credit'=>$credit,'debit'=>$debit,'balance'=>$balance];

    }

    public function getUser()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function getScan()
    {
        return $this->belongsTo(ScanHistory::class,'scan_id','id');
    }

    public function getRewardScheme()
    {
        return $this->belongsTo(RewardScheme::class,'reward_id','id');
    }


}
