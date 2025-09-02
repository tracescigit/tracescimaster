<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    public static function getSupportTicketModel($limit, $page, $orderby, $order , $search_field , $search_type, $search_value,$user_id=null)
    {
        $q = SupportTicket::where('id' , '!=', '');

        $orderby  = $orderby ? $orderby : 'created_at';
        $order    = $order ? $order : 'desc';

        if($user_id!=null){
            $q->where('user_id',$user_id);
        }

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
        return $this->belongsTo(User::class,'user_id','id');
    }
}
