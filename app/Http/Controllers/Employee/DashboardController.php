<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Payroll;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'pegawai') {
                abort(403);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $employee = auth()->user()->employee;

        $pendingLeaves = LeaveRequest::where('employee_id', $employee->id)
            ->where('status', 'pending')->count();

        $approvedLeaves = LeaveRequest::where('employee_id', $employee->id)
            ->where('status', 'approved')->whereYear('start_date', now()->year)->count();

        $todayAttendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', today())->first();

        $thisMonthAttendance = Attendance::where('employee_id', $employee->id)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->count();

        $latestPayroll = Payroll::where('employee_id', $employee->id)
            ->latest()->first();

        $leaveQuotas = LeaveType::all()->map(function ($lt) use ($employee) {
            $used = LeaveRequest::where('employee_id', $employee->id)
                ->where('leave_type_id', $lt->id)
                ->whereIn('status', ['approved'])
                ->whereYear('start_date', now()->year)
                ->sum('days');
            $lt->used = $used;
            $lt->remaining = max(0, $lt->quota - $used);
            return $lt;
        });

        return view('employee.dashboard', compact(
            'employee', 'pendingLeaves', 'approvedLeaves',
            'todayAttendance', 'thisMonthAttendance',
            'latestPayroll', 'leaveQuotas'
        ));
    }
}
