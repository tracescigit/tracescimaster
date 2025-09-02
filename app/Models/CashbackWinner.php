<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashbackWinner extends Model
{
    use HasFactory;

    public function getWinner()
    {
        return $this->belongsTo(User::class,'winner_id','id');
    }

    public function getScan()
    {
        return $this->belongsTo(ScanHistory::class,'scan_id','id');
    }
}
