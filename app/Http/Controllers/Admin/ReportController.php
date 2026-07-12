<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\LeaveRequest;
use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isAdmin()) {
                abort(403);
            }
            return $next($request);
        });
    }

    public function attendances(Request $request)
    {
        $query = Attendance::with(['employee.department', 'employee.position']);

        if ($date = $request->query('date_from')) {
            $query->whereDate('date', '>=', $date);
        }
        if ($date = $request->query('date_to')) {
            $query->whereDate('date', '<=', $date);
        }
        if ($department = $request->query('department')) {
            $query->whereHas('employee', fn($q) => $q->where('department_id', $department));
        }
        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $attendances = $query->latest('date')->get();
        $departments = Department::all();

        $summary = [
            'hadir' => $attendances->where('status', 'hadir')->count(),
            'terlambat' => $attendances->where('status', 'terlambat')->count(),
            'absen' => $attendances->where('status', 'absen')->count(),
            'izin' => $attendances->where('status', 'izin')->count(),
            'sakit' => $attendances->where('status', 'sakit')->count(),
        ];

        return view('admin.reports.attendances', compact('attendances', 'departments', 'summary'));
    }

    public function leaves(Request $request)
    {
        $query = LeaveRequest::with(['employee.department', 'leaveType', 'approvedBy']);

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }
        if ($department = $request->query('department')) {
            $query->whereHas('employee', fn($q) => $q->where('department_id', $department));
        }
        if ($start = $request->query('start_date')) {
            $query->whereDate('start_date', '>=', $start);
        }
        if ($end = $request->query('end_date')) {
            $query->whereDate('end_date', '<=', $end);
        }

        $leaves = $query->latest()->get();
        $departments = Department::all();

        $summary = [
            'approved' => $leaves->where('status', 'approved')->count(),
            'pending' => $leaves->where('status', 'pending')->count(),
            'rejected' => $leaves->where('status', 'rejected')->count(),
            'cancelled' => $leaves->where('status', 'cancelled')->count(),
            'total_days' => $leaves->where('status', 'approved')->sum('days'),
        ];

        return view('admin.reports.leaves', compact('leaves', 'departments', 'summary'));
    }

    public function payrolls(Request $request)
    {
        $query = Payroll::with(['employee.department', 'employee.position']);

        if ($month = $request->query('month')) {
            $query->where('period', 'like', $month . '%');
        }
        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }
        if ($department = $request->query('department')) {
            $query->whereHas('employee', fn($q) => $q->where('department_id', $department));
        }

        $payrolls = $query->latest()->get();
        $departments = Department::all();

        $summary = [
            'total_gaji' => $payrolls->sum('net_salary'),
            'total_allowance' => $payrolls->sum('total_allowance'),
            'total_deduction' => $payrolls->sum('total_deduction'),
            'count' => $payrolls->count(),
            'paid' => $payrolls->where('status', 'paid')->count(),
            'draft' => $payrolls->where('status', 'draft')->count(),
        ];

        return view('admin.reports.payrolls', compact('payrolls', 'departments', 'summary'));
    }
}
