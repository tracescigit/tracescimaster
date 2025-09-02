<?php

namespace App\Models;

use App\Models\Product;
use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardScheme extends Model
{
    use HasFactory;

    public static function getRewardSchemeModel($limit, $page, $orderby, $order , $search_field , $search_type, $search_value)
    {
        $q = RewardScheme::where('user_id', Auth::user()->parent_id??Auth::id());

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

            $q->where(function($query) use ($search_field , $search_type, $search_value) {
                $query->where($search_field, $search_type, ($search_type=='like'?('%'.$search_value.'%'):$search_value));
            });
        }

        $total = $q->count();

        $response =  $q->orderBy($orderby, $order)->paginate($limit, ['*'], 'page', $page);

        return ['response' => $response,'last_page' => $response->lastPage(),'total'=>$total];
    }

    public function getProduct()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function getBatch()
    {
        return $this->belongsTo(Batch::class,'batch_id','id');
    }
}
