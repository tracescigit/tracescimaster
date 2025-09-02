<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    public static function getReportModel($limit, $page, $orderby, $order , $search_field , $search_type, $search_value,$user_id=null)
    {
        $q = Report::where('reports.id' , '!=', '')
        ->leftJoin('products','reports.product_id','=','products.id')
        ->leftJoin('users','reports.user_id','=','users.id')
        ->select('reports.*','products.name as product_name','products.user_id','users.name as user_name');

        if($user_id!=null){
            $q->where('products.user_id',$user_id);
        }


        $orderby  = $orderby ? $orderby : 'reports.created_at';
        $order    = $order ? $order : 'desc';

        if($search_value && !empty($search_value))
        {   

            $q->where(function($query) use ($search_field , $search_type, $search_value) {
                $query->where($search_field, $search_type, ($search_type=='like'?('%'.$search_value.'%'):$search_value));
            });
        }

        $response =  $q->orderBy($orderby, $order)->paginate($limit, ['*'], 'page', $page);

        return ['response' => $response,'last_page' => $response->lastPage()];
    }


    public function getProduct()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
    public function getUser()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
