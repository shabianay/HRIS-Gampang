<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
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
        $query = Attendance::with(['employee.department', 'employee.position']);

        if ($date = request('date')) {
            $query->whereDate('date', $date);
        }

        if ($department = request('department')) {
            $query->whereHas('employee', function ($q) use ($department) {
                $q->where('department_id', $department);
            });
        }

        if ($status = request('status')) {
            $query->where('status', $status);
        }

        $attendances = $query->latest('date')->paginate(10);
        $departments = Department::all();

        return view('admin.attendances.index', compact('attendances', 'departments'));
    }

    public function show(Attendance $attendance)
    {
        $attendance->load(['employee.department', 'employee.position']);

        return view('admin.attendances.show', compact('attendance'));
    }

    public function create()
    {
        $employees = Employee::with('user')->where('status', 'aktif')->get();

        return view('admin.attendances.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'clock_in' => 'nullable|date_format:H:i',
            'clock_out' => 'nullable|date_format:H:i',
            'status' => 'required|in:hadir,terlambat,absen,izin,sakit',
            'notes' => 'nullable|string|max:500',
        ]);

        Attendance::create($validated);

        return redirect()->route('attendances.index')
            ->with('success', 'Absensi berhasil dicatat.');
    }

    public function export()
    {
        $query = Attendance::with(['employee.department', 'employee.position']);

        if ($date = request('date_from')) {
            $query->whereDate('date', '>=', $date);
        }
        if ($date = request('date_to')) {
            $query->whereDate('date', '<=', $date);
        }
        if ($department = request('department')) {
            $query->whereHas('employee', function ($q) use ($department) {
                $q->where('department_id', $department);
            });
        }
        if ($status = request('status')) {
            $query->where('status', $status);
        }

        $attendances = $query->latest('date')->get();

        $filename = 'kehadiran_' . now()->format('Y-m-d_His') . '.csv';
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($attendances) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nama Pegawai', 'NIK', 'Departemen', 'Tanggal', 'Clock In', 'Clock Out', 'Status', 'Terlambat (menit)', 'Keterangan']);

            foreach ($attendances as $a) {
                fputcsv($file, [
                    $a->employee->full_name ?? '-',
                    $a->employee->nik ?? '-',
                    $a->employee->department?->name ?? '-',
                    $a->date->format('d/m/Y'),
                    $a->clock_in ? $a->clock_in->format('H:i') : '-',
                    $a->clock_out ? $a->clock_out->format('H:i') : '-',
                    ucfirst($a->status),
                    $a->late_minutes ?? 0,
                    $a->notes ?? '-',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
