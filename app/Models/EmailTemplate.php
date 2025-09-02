<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
	use HasFactory;
	protected $fillable = ['slug', 'subject', 'email_body', 'text_tag'];

	public static function getEmailTemplate($limit, $page, $orderby, $order , $search_field , $search_type, $search_value)
	{

		$q = EmailTemplate::where('id' , '!=', '');

		$orderby  = $orderby ? $orderby : 'created_at';
		$order    = $order ? $order : 'desc';

		if($search_value && !empty($search_value))
		{
			$q->where(function($query) use ($search_field , $search_type, $search_value) {
				$query->where($search_field, $search_type, ($search_type=='like'?('%'.$search_value.'%'):$search_value));
			});
		}

		$response =  $q->orderBy($orderby, $order)->paginate($limit, ['*'], 'page', $page);

		return ['response' => $response,'last_page' => $response->lastPage()];
	}
}
