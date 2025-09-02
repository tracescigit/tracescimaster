<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponCode extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','code_id','reward_id','coupon_code'];

    public function getCode()
    {
        return $this->belongsTo(Code::class,'code_id','id')->with('getProduct');
    }
}
