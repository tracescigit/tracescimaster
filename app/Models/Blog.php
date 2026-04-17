<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'address',
        'created_by',
        'publish_by',
        'city',
        'image_path',
        'description',
        'is_allowed',
        'status',
    ];

    public static function getAdminUserModel($limit, $page, $orderby, $order, $search_field, $search_type, $search_value, $start_date = null, $end_date = null)
    {
        $q = Blog::select('blogs.*');
        if ($start_date != null) {
            $q->whereDate('created_at', '>=', $start_date);
        }

        if ($end_date != null) {
            $q->whereDate('created_at', '<=', $end_date);
        }

        $orderby  = $orderby ? $orderby : 'created_at';
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
}
