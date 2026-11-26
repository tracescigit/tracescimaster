<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
	use HasFactory;

	protected $fillable = ['product_id', 'batch', 'batch_id', 'qr_code', 'url', 'user_id', 'status', 'code_data', 'exported', 'aggregation_id', 'order_id', 'secret_code', 'deactivate_reason', 'deactivated_at', 'deactivated_by'];


	public static function getCodeModel(
		$limit,
		$page,
		$orderby,
		$order,
		$search_field,
		$search_type,
		$search_value,
		$user_id = null,
		$start_date = null,
		$end_date = null
	) {
		$limit = max(1, min((int) $limit, 10000));
		$page = max(1, (int) $page);

		$allowedSortFields = [
			'id' => 'codes.id',
			'created_at' => 'codes.created_at',
			'status' => 'codes.status',
			'batch' => 'codes.batch',
		];

		$orderby = $allowedSortFields[$orderby] ?? 'codes.id';
		$order = strtoupper($order) === 'ASC' ? 'ASC' : 'DESC';

		$q = Code::query()
			->with([
				'getProduct.getUser.getCompany'
			]);

		if ($user_id !== null) {
			$q->where('codes.user_id', $user_id);
		}

		if ($start_date) {
			$q->where('codes.created_at', '>=', $start_date . ' 00:00:00');
		}

		if ($end_date) {
			$q->where('codes.created_at', '<=', $end_date . ' 23:59:59');
		}

		if (!empty($search_value)) {
			$search_value = strtolower($search_value);

			if ($search_value === 'inactive') {
				$search_value = '0';
			} elseif ($search_value === 'active') {
				$search_value = '1';
			}

			$allowedSearchFields = [
				'status' => 'codes.status',
				'batch' => 'codes.batch',
				'code_data' => 'codes.code_data',
			];

			$field = $allowedSearchFields[$search_field] ?? null;

			if ($field) {
				$q->where(
					$field,
					$search_type === 'like' ? 'LIKE' : '=',
					$search_type === 'like'
						? '%' . $search_value . '%'
						: $search_value
				);
			}
		}

		$response = $q->orderBy($orderby, $order)
			->paginate($limit, ['codes.*'], 'page', $page);

		return [
			'response' => $response,
			'last_page' => $response->lastPage(),
			'total' => $response->total(),
		];
	}


	public function getProduct()
	{
		return $this->belongsTo(Product::class, 'product_id', 'id');
	}

	public function getBatchData()
	{
		return $this->belongsTo(Batch::class, 'batch', 'code');
	}

	public function getUser()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function getBatch()
	{
		return $this->belongsTo(Batch::class, 'batch_id', 'id');
	}

	public function getAggregation()
	{
		return $this->belongsTo(Aggregation::class, 'aggregation_id', 'id');
	}
	public function getScanhistory()
	{
		return $this->hasMany(ScanHistory::class, 'code_id', 'id');
	}
}
