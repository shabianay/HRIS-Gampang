<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
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

    public function index(Request $request)
    {
        $employee = auth()->user()->employee;

        $query = Attendance::where('employee_id', $employee->id);

        if ($date = $request->query('date_from')) {
            $query->whereDate('date', '>=', $date);
        }
        if ($date = $request->query('date_to')) {
            $query->whereDate('date', '<=', $date);
        }
        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $attendances = $query->latest('date')->paginate(10);

        $summary = [
            'hadir' => Attendance::where('employee_id', $employee->id)
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->where('status', 'hadir')
                ->count(),
            'terlambat' => Attendance::where('employee_id', $employee->id)
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->where('status', 'terlambat')
                ->count(),
            'absen' => Attendance::where('employee_id', $employee->id)
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->where('status', 'absen')
                ->count(),
            'izin' => Attendance::where('employee_id', $employee->id)
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->where('status', 'izin')
                ->count(),
            'sakit' => Attendance::where('employee_id', $employee->id)
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->where('status', 'sakit')
                ->count(),
        ];

        return view('employee.attendances.index', compact('attendances', 'summary'));
    }
}
