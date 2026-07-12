<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryComponent extends Model
{
    protected $fillable = [
        'name', 'code', 'type', 'amount', 'calculation', 'is_active', 'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}