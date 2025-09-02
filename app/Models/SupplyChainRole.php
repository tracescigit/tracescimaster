<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyChainRole extends Model
{
    use HasFactory;

    public static function getSupplyChainRoleModel($limit, $page, $orderby, $order , $search_field , $search_type, $search_value,$user_id=null)
    {
        $q = SupplyChainRole::where('supply_chain_roles.id' , '!=', '')->leftJoin('users','supply_chain_roles.user_id','=','users.id')->select(['supply_chain_roles.*']);

        if($user_id!=null){
            $q->where('supply_chain_roles.user_id',$user_id);
        }

        $orderby  = $orderby ? $orderby : 'supply_chain_roles.created_at';
        $order    = $order ? $order : 'desc';

        if($search_value && !empty($search_value))
        {   
            $search_value = strtolower($search_value);
            if($search_value== 'inactive')
            {
                $search_value = '0';
            }
            if($search_value== 'active' )
            {
                $search_value = '1';
            }
            
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
        return $this->belongsTo(User::class,'user_id','id');
    }
}
