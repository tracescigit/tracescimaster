<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aggregation extends Model
{
    protected $fillable = ['parent_id'];
    
    use HasFactory;

    public static function getAggregationModel($limit, $page, $orderby, $order , $search_field , $search_type, $search_value,$user_id=null,$level=null)
    {
        $q = Aggregation::where('user_id',$user_id);

        $orderby  = $orderby ? $orderby : 'id';
        $order    = $order ? $order : 'desc';

        if ($level=='All') {
            $q->where('parent_id',NULL);
        }else{
            $q->where('level',$level);
        }

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

    public function getCodes()
    {
        return $this->hasMany(Code::class,'aggregation_id','id');
    }

    public function getChildren()
    {
        return $this->hasMany(Aggregation::class,'parent_id','id');
    }

    public function getParent()
    {
        return $this->belongsTo(Aggregation::class,'parent_id','id');
    }
}
