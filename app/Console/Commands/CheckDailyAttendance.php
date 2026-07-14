<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckDailyAttendance extends Command
{
    protected $signature = 'attendance:check-daily';
    protected $description = 'Mark employees as absent if they have no attendance record for the day.';

    public function handle()
    {
        $today = Carbon::today();
        $employees = Employee::all();
        $marked = 0;

        foreach ($employees as $employee) {
            $hasAttendance = Attendance::where('employee_id', $employee->id)
                ->whereDate('date', $today)
                ->exists();

            if (!$hasAttendance) {
                Attendance::create([
                    'employee_id' => $employee->id,
                    'date' => $today,
                    'status' => 'absen',
                    'clock_in' => null,
                    'clock_out' => null,
                ]);
                $marked++;
            }
        }

        $this->info("Marked {$marked} employees as absent for {$today->toDateString()}.");
    }
}
