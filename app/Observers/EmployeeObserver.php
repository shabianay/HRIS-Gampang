<?php

namespace App\Observers;

use App\Models\Employee;

class EmployeeObserver
{
    public function updated(Employee $employee): void
    {
        if ($employee->isDirty('full_name') && $employee->user) {
            $employee->user->updateQuietly(['name' => $employee->full_name]);
        }
    }
}
