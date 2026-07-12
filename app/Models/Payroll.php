<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payroll extends Model
{
    protected $fillable = [
        'employee_id', 'period', 'base_salary', 'total_allowance', 'total_deduction',
        'net_salary', 'details', 'status', 'payment_date',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'details' => 'array',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}