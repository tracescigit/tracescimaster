<?php

namespace App\Models;

use App\Models\Code;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
class ScanHistory extends Model
{
	use HasFactory;

	public static function getScanModel($limit, $page, $orderby, $order , $search_field , $search_type, $search_value,$user_id=null,$start_date=null,$end_date=null)
	{
		$q = ScanHistory::where('scan_histories.id' , '!=', '')
		->leftJoin('codes','scan_histories.code_id','=','codes.id')
		->leftJoin('companies','codes.user_id','=','companies.user_id')
		->select('scan_histories.*','companies.name as business_name','codes.code_data');

		if($start_date!=null){
			$q->whereDate('scan_histories.created_at','>=',$start_date);
		}

		if($end_date!=null){
			$q->whereDate('scan_histories.created_at','<=',$end_date);
		}

		if($user_id!=null){
			$q->where('codes.user_id',$user_id);
		}


		$orderby  = $orderby ? $orderby : 'scan_histories.created_at';
		$order    = $order ? $order : 'desc';

		if($search_value && !empty($search_value))
		{   

			$search_value = strtolower($search_value);

			if($search_value== 'authority')
			{
				$search_value = '0';
			}
			if($search_value== 'users' )
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

	public static function getVendorScanModel($limit, $page, $orderby, $order , $search_field , $search_type, $search_value,$user_id)
	{

		$q = ScanHistory::where('scan_histories.id' , '!=', '')
		->leftJoin('codes','scan_histories.code_id','=','codes.id')
		->select('scan_histories.*')
		->where('codes.user_id',$user_id);

		if (Auth::user()->who_you_are=='Brand User') {
			$brand = Auth::user()->brand;
			$product_ids = Product::where('brand',$brand)->pluck('id');

			$q->whereIn('product_id',$product_ids);
		}

		$orderby  = $orderby ? $orderby : 'scan_histories.created_at';
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



	public function getCode()
	{
		return $this->belongsTo(Code::class,'code_id','id')->with('getProduct');
	}
}
