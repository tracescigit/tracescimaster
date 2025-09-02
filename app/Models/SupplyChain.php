<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyChain extends Model
{
    use HasFactory;

    public function getUser()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function getChildren()
    {
        return $this->hasMany(SupplyChain::class,'supply_chain_parent_id','user_id');
    }
}
