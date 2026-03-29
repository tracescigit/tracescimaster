<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTemplate extends Model
{
    use HasFactory;
    protected $table = 'product_templates';
    public static function getProductTemplateModel($limit, $page, $orderby, $order, $search_field, $search_type, $search_value, $user_id = null)
    {
        $q = ProductTemplate::where('product_templates.product_id', '!=', '')->leftJoin('users', 'product_templates.user_id', '=', 'users.id')
            ->leftJoin('companies', 'product_templates.user_id', '=', 'companies.user_id')->leftJoin('products', 'product_templates.product_id', '=', 'products.id')
            ->select(['product_templates.*', 'products.name as product_name', 'products.created_at as date', 'products.status as product_status', 'companies.name as business_name', 'users.name as user_name']);

        if ($user_id != null) {
            $q->where('products.user_id', $user_id);
        }

        $orderby  = $orderby ? $orderby : 'products.created_at';
        $order    = $order ? $order : 'desc';

        if ($search_value && !empty($search_value)) {
            $search_field = strtolower($search_field);
            if ($search_field == 'created_by') {
                $q->where('user_name', $search_value);
            }
            if ($search_field == 'product_name') {
                $q->where('product_name', $search_value);
            }

            $q->where(function ($query) use ($search_field, $search_type, $search_value) {
                $query->where($search_field, $search_type, ($search_type == 'like' ? ('%' . $search_value . '%') : $search_value));
            });
        }

        $total = $q->count();

        $response =  $q->orderBy($orderby, $order)->paginate($limit, ['*'], 'page', $page);

        return ['response' => $response, 'last_page' => $response->lastPage(), 'total' => $total];
    }
    public function getProduct()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
