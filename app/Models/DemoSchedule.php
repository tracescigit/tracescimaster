<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoSchedule extends Model
{
    use HasFactory;
    protected $table = 'demo_scheduling'; 

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'company_name',
        'company_email',
        'demo_date',
        'demo_time',
        'message',
        'created_by',
        'status',
    ];
}
