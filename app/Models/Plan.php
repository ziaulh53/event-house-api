<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'interval',
        'interval_count',
        'lookup_key',
        'st_plan_id',
        'max_service',
        'contact_hide',
        'advertise',
    ];
}