<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyChainScanHistory extends Model
{
    use HasFactory;

    public static function getScanModel($limit, $page, $orderby, $order , $search_field , $search_type, $search_value,$user_id)
    {

        $q = SupplyChainScanHistory::where('supply_chain_scan_histories.id' , '!=', '')
        ->leftJoin('supply_chain_actions','supply_chain_actions.scan_id','=','supply_chain_scan_histories.id')
        ->leftJoin('aggregations','supply_chain_actions.aggregation_unique_id','=','aggregations.unique_id')
        ->select('supply_chain_scan_histories.*')
        ->groupBy('supply_chain_scan_histories.aggregation_unique_id')->distinct()
        ->where('aggregations.user_id',$user_id);

        $orderby  = $orderby ? $orderby : 'supply_chain_scan_histories.created_at';
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

    public function getAction()
    {
        return $this->belongsTo(SupplyChainAction::class,'id','scan_id');
    }

    public function getScannedBy()
    {
        return $this->belongsTo(User::class,'scanned_by','id');
    }
}
