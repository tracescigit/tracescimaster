<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class SupplyChainUser extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = ['who_you_are'];

    public static function getSupplyChainUserModel($limit, $page, $orderby, $order , $search_field , $search_type, $search_value,$start_date=null,$end_date=null)
    {
        $q = SupplyChainUser::select('users.*')->where('users.type','5')->where('users.id' , '<>', Auth::user()->id)->where('parent_id',Auth::user()->parent_id??Auth::user()->id);

        if($start_date!=null){
            $q->whereDate('created_at','>=',$start_date);
        }

        if($end_date!=null){
            $q->whereDate('created_at','<=',$end_date);
        }

        $orderby  = $orderby ? $orderby : 'created_at';
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
}
