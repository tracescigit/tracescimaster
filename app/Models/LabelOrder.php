<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabelOrder extends Model
{
    use HasFactory;

    public static function getLabelOrderModel($limit, $page, $orderby, $order , $search_field , $search_type, $search_value,$user_id=null,$start_date=null,$end_date=null)
    {
        $q = LabelOrder::where('id' , '!=', '');

        if($start_date!=null){
            $q->whereDate('created_at','>=',$start_date);
        }

        if($end_date!=null){
            $q->whereDate('created_at','<=',$end_date);
        }

        if($user_id!=null){
            $q->where('user_id',$user_id);
        }

        $orderby  = $orderby ? $orderby : 'created_at';
        $order    = $order ? $order : 'desc';

        if($search_value && !empty($search_value) && !empty($search_field))
        {
            $search_value = strtolower($search_value);
            if($search_value== 'pending')
            {
                $search_value = '0';
            }
            if($search_value== 'approved' || $search_value== 'success')
            {
                $search_value = '1';
            }
            if ($search_field=='dispatch_status') {
                switch ($search_value) {
                    case 'in progress':
                    $search_value='1';
                    break;
                    case 'ready to dispatch':
                    $search_value='2';
                    break;
                    case 'dispatched':
                    $search_value='3';
                    break;
                    case 'in transit':
                    $search_value='4';
                    break;
                    case 'ready to pick up':
                    $search_value='5';
                    break;
                    case 'cancelled':
                    $search_value='6';
                    break;
                    case 'delayed':
                    $search_value='7';
                    break;
                    default:
                    $search_value='0';
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

    public function getCurrentStatusText()
    {
        return $this->belongsTo(LabelOrderStatus::class,'dispatch_status','code');
    }

    public function getInvoice()
    {
        return $this->belongsTo(Invoice::class,'payment_id','payment_id');
    }

     public function getUser()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
