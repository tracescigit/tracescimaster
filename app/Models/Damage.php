<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Damage extends Model
{
    use HasFactory;

    public static function getDamages($limit, $page, $orderby, $order , $search_field , $search_type, $search_value,$user_id=null)
    {
       $q = Damage::where('damages.id' , '!=', '')
       ->leftJoin('companies','damages.manufacturer_id','=','companies.user_id')
       ->select('damages.*','companies.name as manufacturer_name');

       if($user_id!=null){
        $q->where('manufacturer_id',$user_id);
    }


    if(Auth::user()->who_you_are=="Province Governor"){
        $q->whereIn('manufacturer_id',getMyProvinceUsers());
    }


    $orderby  = $orderby ? $orderby : 'damages.created_at';
    $order    = $order ? $order : 'desc';

    if($search_value && !empty($search_value))
    {   

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
    return $this->belongsTo(User::class,'manufacturer_id','id');
}

}