<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

   public static function getAlerts($limit, $page, $orderby, $order , $search_field , $search_type, $search_value,$user_id=null,$start_date=null,$end_date=null)
    {
        $q = Alert::where('alerts.id' , '!=', '')->where('alerts.type','0')
        ->leftJoin('users','alerts.scanned_by','=','users.id')
        ->leftJoin('products','alerts.product_id','=','products.id')
        ->leftJoin('codes','alerts.code_id','=','codes.id')
        ->select('alerts.*','products.user_id','users.phone','codes.code_data');

        if($user_id!=null){
            $q->where('products.user_id',$user_id);
        }

        if($start_date!=null){
            $q->whereDate('alerts.created_at','>=',$start_date);
        }

        if($end_date!=null){
            $q->whereDate('alerts.created_at','<=',$end_date);
        }


        $orderby  = $orderby ? $orderby : 'alerts.created_at';
        $order    = $order ? $order : 'desc';

        if($search_value && !empty($search_value))
        {   
            $search_value = strtolower($search_value);
            if($search_value== 'no')
            {
                $search_value = null;
            }
            if($search_value== 'yes' )
            {
                $search_value = $user_id;
            }

            $q->where(function($query) use ($search_field , $search_type, $search_value) {
                $query->where($search_field, $search_type, ($search_type=='like'?('%'.$search_value.'%'):$search_value));
            });
        }

        $total = $q->count();

        $response =  $q->orderBy($orderby, $order)->paginate($limit, ['*'], 'page', $page);

        return ['response' => $response,'last_page' => $response->lastPage(),'total'=>$total];
    }

    public static function getReportModel($limit, $page, $orderby, $order , $search_field , $search_type, $search_value,$user_id=null,$start_date=null,$end_date=null)
    {
        $q = Alert::where('alerts.id' , '!=', '')->where('alerts.type','1')
        ->leftJoin('products','alerts.product_id','=','products.id')
        ->leftJoin('users','alerts.scanned_by','=','users.id')
        ->select('alerts.*','products.user_id','users.name as user_name');

        if($start_date!=null){
            $q->whereDate('alerts.created_at','>=',$start_date);
        }

        if($end_date!=null){
            $q->whereDate('alerts.created_at','<=',$end_date);
        }

        if($user_id!=null){
            $q->where('products.user_id',$user_id);
        }

        $orderby  = $orderby ? $orderby : 'alerts.created_at'; 
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

    public function getProduct()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function getUser()
    {
        return $this->belongsTo(User::class,'scanned_by','id');
    }

    public function getBatch()
    {
        return $this->belongsTo(Batch::class,'batch_id','id');
    }

    public function getCode()
    {
        return $this->belongsTo(Code::class,'code_id','id');
    }

    public function getAssignedToAdmin()
    {
        return $this->belongsTo(User::class,'admin_assigned_to','id');
    }
    public function getAssignedToVendor()
    {
        return $this->belongsTo(User::class,'manufacturer_assigned_to','id');
    }
}
