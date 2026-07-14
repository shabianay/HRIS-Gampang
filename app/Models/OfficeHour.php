<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeHour extends Model
{
    protected $fillable = [
        'clock_in_time',
        'clock_out_time',
    ];

    protected $casts = [
        'clock_in_time' => 'datetime',
        'clock_out_time' => 'datetime',
    ];
}
