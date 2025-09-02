<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class RewardOrder extends Model
{
    use HasFactory;

    public static function getRewardOrderModel($limit, $page, $orderby, $order , $search_field , $search_type, $search_value)
    {
        $q = RewardOrder::leftJoin('reward_schemes', 'reward_orders.reward_id', '=', 'reward_schemes.id')
        ->leftJoin('users', 'reward_orders.customer_id', '=', 'users.id')
        ->select(['reward_orders.*','users.phone'])->where('reward_schemes.user_id',Auth::id());

        $orderby  = $orderby ? $orderby : 'reward_orders.created_at';
        $order    = $order ? $order : 'DESC';

        if($search_value && !empty($search_value))
        {   
            $search_value = strtolower($search_value);         
            $q->where(function($query) use ($search_field , $search_type, $search_value) {
                $query->where($search_field, $search_type, ($search_type=='like'?('%'.$search_value.'%'):$search_value));
            });
        }

        
        $total = $q->count();
        $response =  $q->orderBy($orderby, $order)->paginate($limit, ['*'], 'page', $page);
        return ['response' => $response,'last_page' => $response->lastPage(),'total'=>$total];

    }

    public function getUser()
    {
        return $this->belongsTo(User::class,'customer_id','id');
    }

    public function getRewardScheme()
    {
        return $this->belongsTo(RewardScheme::class,'reward_id','id');
    }
}
