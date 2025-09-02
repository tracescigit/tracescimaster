<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyChainAction extends Model
{
    use HasFactory;

    public function getActionBy()
    {
        return $this->belongsTo(User::class,'action_by','id');
    }

    public function getActionFor()
    {
        return $this->belongsTo(User::class,'action_for','id');
    }

    public function getScan()
    {
        return $this->belongsTo(SupplyChainScanHistory::class,'scan_id','id');
    }

    public function getAggregation()
    {
        return $this->belongsTo(Aggregation::class,'aggregation_unique_id','unique_id');
    }
}
