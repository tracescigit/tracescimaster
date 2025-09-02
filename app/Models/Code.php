<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
	use HasFactory;

	protected $fillable = ['product_id','batch','batch_id','qr_code','url','user_id','status','code_data','exported','aggregation_id','order_id'];

	public static function getCodeModel($limit, $page, $orderby, $order , $search_field , $search_type, $search_value,$user_id=null,$start_date=null,$end_date=null)
	{
		$q = Code::where('codes.id' , '!=', '')->leftJoin('products', 'codes.product_id', '=', 'products.id')
		->leftJoin('users','codes.user_id','=','users.id')
		->leftJoin('companies','codes.user_id','=','companies.user_id')
		->select(['codes.*','codes.created_at as date','codes.status as code_status','products.name','users.name as user_name','companies.name as business_name']);

		if($user_id!=null){
			$q->where('codes.user_id',$user_id);
		}

		if($start_date!=null){
			$q->whereDate('codes.created_at','>=',$start_date);
		}

		if($end_date!=null){
			$q->whereDate('codes.created_at','<=',$end_date);
		}
		
		$orderby  = $orderby ? $orderby : 'codes.id';
		$order    = $order ? $order : 'DESC';

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

	public function getProduct()
	{
		return $this->belongsTo(Product::class,'product_id','id');
	}

	public function getBatchData()
	{
		return $this->belongsTo(Batch::class,'batch','code');
	}

	public function getUser()
	{
		return $this->belongsTo(User::class,'user_id','id');
	}

	public function getBatch()
	{
		return $this->belongsTo(Batch::class,'batch_id','id');
	}

	public function getAggregation()
	{
		return $this->belongsTo(Aggregation::class,'aggregation_id','id');
	}

}
