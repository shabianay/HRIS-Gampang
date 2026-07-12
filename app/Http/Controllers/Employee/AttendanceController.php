<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'pegawai') {
                abort(403);
            }
            // Pastikan employee_id ada di user yang login
            if (!auth()->user()->employee) {
                abort(403, 'Akun Anda belum terhubung dengan data pegawai.');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $employee = auth()->user()->employee;

        $todayAttendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', today())
            ->first();

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

        return view('employee.attendances.index', compact('attendances', 'summary', 'todayAttendance'));
    }

    public function show(Attendance $attendance)
    {
        $employee = auth()->user()->employee;

        if ($attendance->employee_id !== $employee->id) {
            abort(403);
        }

        $attendance->load(['employee.department', 'employee.position']);

        return view('employee.attendances.show', compact('attendance'));
    }

    public function clockIn(Request $request)
    {
        $employee = auth()->user()->employee;

        // Check if already clocked in today
        $existingAttendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', today())
            ->first();

        if ($existingAttendance) {
            return back()->with('error', 'Anda sudah melakukan clock in hari ini.');
        }

        $clockInTime = now();
        $standardClockInTime = Carbon::parse('08:00:00'); // Standard 8 AM

        $lateMinutes = 0;
        $status = 'hadir';

        if ($clockInTime->greaterThan($standardClockInTime)) {
            $lateMinutes = $clockInTime->diffInMinutes($standardClockInTime);
            $status = 'terlambat';
        }

        Attendance::create([
            'employee_id' => $employee->id,
            'date' => today(),
            'clock_in' => $clockInTime,
            'clock_out' => null,
            'location' => $request->ip(),
            'clock_in_latitude' => $request->input('latitude'),
            'clock_in_longitude' => $request->input('longitude'),
            'device_info' => $request->header('User-Agent'),
            'ip_address' => $request->ip(),
            'status' => $status,
            'late_minutes' => $lateMinutes,
            'notes' => $lateMinutes > 0 ? 'Terlambat ' . $lateMinutes . ' menit' : null,
        ]);

        return back()->with('success', 'Clock In berhasil dicatat!');
    }

    public function clockOut(Request $request)
    {
        $employee = auth()->user()->employee;

        $todayAttendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', today())
            ->first();

        if (!$todayAttendance) {
            return back()->with('error', 'Anda belum melakukan clock in hari ini.');
        }

        if ($todayAttendance->clock_out) {
            return back()->with('error', 'Anda sudah melakukan clock out hari ini.');
        }

        $todayAttendance->update([
            'clock_out' => now(),
            'clock_out_latitude' => $request->input('latitude'),
            'clock_out_longitude' => $request->input('longitude'),
            'device_info' => $request->header('User-Agent'),
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Clock Out berhasil dicatat!');
    }
}
