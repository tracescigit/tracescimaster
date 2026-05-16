<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Product extends Model
{
	use HasFactory;

	public static function getProductModel($limit, $page, $orderby, $order, $search_field, $search_type, $search_value, $user_id = null)
	{
		$q = Product::where('products.id', '!=', '')->leftJoin('users', 'products.user_id', '=', 'users.id')
			->leftJoin('companies', 'products.user_id', '=', 'companies.user_id')
			->select(['products.*', 'products.name as product_name', 'products.created_at as date', 'products.status as product_status', 'companies.name as business_name']);

		if ($user_id != null) {
			$q->where('products.user_id', $user_id);
		}

		$orderby  = $orderby ? $orderby : 'products.created_at';
		$order    = $order ? $order : 'desc';

		if ($search_value && !empty($search_value)) {
			$search_value = strtolower($search_value);
			if ($search_value == 'inactive') {
				$search_value = '0';
			}
			if ($search_value == 'active') {
				$search_value = '1';
			}

			$q->where(function ($query) use ($search_field, $search_type, $search_value) {
				$query->where($search_field, $search_type, ($search_type == 'like' ? ('%' . $search_value . '%') : $search_value));
			});
		}

		$total = $q->count();

		$response =  $q->orderBy($orderby, $order)->paginate($limit, ['*'], 'page', $page);

		return ['response' => $response, 'last_page' => $response->lastPage(), 'total' => $total];
	}

	public function getUser()
	{
		return $this->belongsTo(User::class, 'user_id', 'id')->with('getCompany');
	}
	public function getTemplate()
	{
		return $this->belongsTo(ProductTemplate::class, 'template_id', 'id');
	}
}
