<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Cashback extends Model
{
    use HasFactory;

    public static function getCashbackModel($limit, $page, $orderby, $order , $search_field , $search_type, $search_value)
    {
        $q = Cashback::where('user_id', Auth::user()->parent_id??Auth::id());

        if (Auth::user()->who_you_are=='Brand User') {
            $brand = Auth::user()->brand;
            $product_ids = Product::where('brand',$brand)->pluck('id');

            $q->whereIn('product_id',$product_ids);
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
            if($search_value== 'active')
            {
                $search_value = '1';
            }

            if ($search_field=='type') {
                switch ($search_value) {
                    case 'price':
                    $search_value='0';
                    break;
                    case 'percentage':
                    $search_value='1';
                    break;
                }
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
