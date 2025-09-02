<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
	use HasFactory;

	public static function getCreditModel($limit, $page, $orderby, $order , $search_field , $search_type, $search_value,$user_id=null,$start_date=null,$end_date=null)
	{
		$q = Credit::where('id' , '!=', '')->where('status','1');

		if($user_id!=null){
			$q->where('user_id',$user_id);
		}

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
			if($search_value== 'pending')
			{
				$search_value = '0';
			}
			if($search_value== 'success')
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

	public function getPlan()
	{
		return $this->belongsTo(Plan::class,'plan_id','id');
	}

	public function getOffer()
	{
		return $this->belongsTo(Offer::class,'offer_id','id');
	}

	public function getUser()
	{
		return $this->belongsTo(User::class,'user_id','id');
	}

	public function getInvoice()
	{
		return $this->belongsTo(Invoice::class,'payment_id','payment_id');
	}
}
