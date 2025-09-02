<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyChainAlert extends Model
{
    use HasFactory;

    protected $fillable = ['aggregation_id','scanned_by','alert_message','created_at','updated_at'];
}
