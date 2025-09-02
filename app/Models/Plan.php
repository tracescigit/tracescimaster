<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
	use HasFactory;

	public static function getPlanModel($limit, $page, $orderby, $order , $search_field , $search_type, $search_value)
	{
		$q = Plan::where('parent_id', null);

		$orderby  = $orderby ? $orderby : 'created_at';
		$order    = $order ? $order : 'desc';

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

	public static function getTopupModel($limit, $page, $orderby, $order , $search_field , $search_type, $search_value)
	{
		$q = Plan::where('parent_id' , '!=', '');

		$orderby  = $orderby ? $orderby : 'created_at';
		$order    = $order ? $order : 'desc';

		if($search_value && !empty($search_value))
			{	$search_value = strtolower($search_value);
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
	}
