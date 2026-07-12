<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\Attendance;
use App\Models\LeaveType;
use Carbon\Carbon;

class DashboardController extends Controller
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

    public function index()
    {
        // ─── Stat cards ───────────────────────────────────────────────
        $totalActiveEmployees = Employee::where('status', 'aktif')->count();
        $totalDepartments = Department::count();
        $pendingLeaveRequests = LeaveRequest::where('status', 'pending')->count();
        $todayAttendance = Attendance::whereDate('date', today())->count();

        // ─── Employee by department ───────────────────────────────────
        $employeesByDepartment = Department::withCount(['employees' => function ($q) {
            $q->where('status', 'aktif');
        }])->get();

        // ─── Monthly leave stats (last 6 months) ─────────────────────
        $monthlyLeaves = collect();
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $approved = LeaveRequest::whereYear('start_date', $month->year)
                ->whereMonth('start_date', $month->month)
                ->where('status', 'approved')
                ->count();
            $rejected = LeaveRequest::whereYear('start_date', $month->year)
                ->whereMonth('start_date', $month->month)
                ->where('status', 'rejected')
                ->count();
            $monthlyLeaves->push([
                'month' => $month->isoFormat('MMM'),
                'approved' => $approved,
                'rejected' => $rejected,
            ]);
        }
        $maxMonthly = max($monthlyLeaves->max('approved'), $monthlyLeaves->max('rejected'), 1);

        // ─── Recent pending leave requests ───────────────────────────
        $recentLeaves = LeaveRequest::with(['employee', 'leaveType'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // ─── Today's attendance breakdown ────────────────────────────
        $todayAttendances = Attendance::whereDate('date', today())->get();
        $attendanceHadir = $todayAttendances->where('status', 'hadir')->count();
        $attendanceTerlambat = $todayAttendances->where('status', 'terlambat')->count();
        $attendanceIzin = $todayAttendances->where('status', 'izin')->count();
        $attendanceSakit = $todayAttendances->where('status', 'sakit')->count();
        $attendanceAbsen = $todayAttendances->where('status', 'absen')->count();

        // ─── Leave type quotas ───────────────────────────────────────
        $leaveTypes = LeaveType::all()->map(function ($lt) {
            $used = LeaveRequest::where('leave_type_id', $lt->id)
                ->whereIn('status', ['approved'])
                ->whereYear('start_date', now()->year)
                ->sum('days');
            $lt->used = $used;
            $lt->remaining = max(0, $lt->quota - $used);
            return $lt;
        });

        return view('admin.dashboard', compact(
            'totalActiveEmployees',
            'totalDepartments',
            'pendingLeaveRequests',
            'todayAttendance',
            'employeesByDepartment',
            'monthlyLeaves',
            'maxMonthly',
            'recentLeaves',
            'todayAttendances',
            'attendanceHadir',
            'attendanceTerlambat',
            'attendanceIzin',
            'attendanceSakit',
            'attendanceAbsen',
            'leaveTypes',
        ));
    }
}
