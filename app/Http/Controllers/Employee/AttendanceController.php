<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\OfficeHour;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        $baseQuery = Attendance::where('employee_id', $employee->id)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year);

        $summary = [
            'hadir' => (clone $baseQuery)->where('status', 'hadir')->count(),
            'terlambat' => (clone $baseQuery)->where('status', 'terlambat')->count(),
            'absen' => (clone $baseQuery)->where('status', 'absen')->count(),
            'izin' => (clone $baseQuery)->where('status', 'izin')->count(),
            'sakit' => (clone $baseQuery)->where('status', 'sakit')->count(),
            'total_hari' => (clone $baseQuery)->count(),
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
        $validated = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $employee = auth()->user()->employee;

        // Check if already clocked in today
        $existingAttendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', today())
            ->first();

        if ($existingAttendance && $existingAttendance->clock_in) {
            return back()->with('error', 'Anda sudah melakukan clock in hari ini.');
        }

        $clockInTime = now();
        
        // Ambil pengaturan jam kantor dari database
        $officeHour = OfficeHour::first();
        $standardClockInTime = $officeHour ? Carbon::parse($officeHour->clock_in_time) : Carbon::parse('08:00:00');

        $lateMinutes = 0;
        $status = 'hadir';

        if ($clockInTime->greaterThan($standardClockInTime)) {
            $lateMinutes = $clockInTime->diffInMinutes($standardClockInTime);
            $status = 'terlambat';
        }

        $photoInPath = null;
        if ($request->filled('photo')) {
            $base64Image = $request->input('photo');
            $base64Image = Str::after($base64Image, 'base64,');
            $decodedImage = base64_decode($base64Image);

            if ($decodedImage) {
                $fileName = 'attendance-photos/' . Str::uuid() . '.jpeg';
                Storage::disk('public')->put($fileName, $decodedImage);
                $photoInPath = $fileName;
            } else {
                Log::error('Failed to decode base64 image for clock-in.');
            }
        }

        $data = [
            'clock_in' => $clockInTime,
            'location' => $request->ip(),
            'clock_in_latitude' => $validated['latitude'],
            'clock_in_longitude' => $validated['longitude'],
            'device_info' => $request->header('User-Agent'),
            'ip_address' => $request->ip(),
            'status' => $status,
            'late_minutes' => $lateMinutes,
            'photo_in' => $photoInPath,
        ];

        if ($existingAttendance) {
            // Update existing record (e.g., previously marked as izin/sakit)
            $existingAttendance->update($data);
        } else {
            // Create new record
            $data['employee_id'] = $employee->id;
            $data['date'] = today();
            Attendance::create($data);
        }

        return back()->with('success', 'Clock In berhasil dicatat!');
    }

    public function clockOut(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

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

        $photoOutPath = null;
        if ($request->filled('photo')) {
            $base64Image = $request->input('photo');
            // Remove data URI scheme header if present (e.g., "data:image/jpeg;base64,")
            $base64Image = Str::after($base64Image, 'base64,');
            $decodedImage = base64_decode($base64Image);

            if ($decodedImage) {
                $fileName = 'attendance-photos/' . Str::uuid() . '.jpeg';
                Storage::disk('public')->put($fileName, $decodedImage);
                $photoOutPath = $fileName;
            } else {
                Log::error('Failed to decode base64 image for clock-out.');
            }
        }

        $todayAttendance->update([
            'clock_out' => now(),
            'clock_out_latitude' => $validated['latitude'],
            'clock_out_longitude' => $validated['longitude'],
            'device_info' => $request->header('User-Agent'),
            'ip_address' => $request->ip(),
            'photo_out' => $photoOutPath,
        ]);

        return back()->with('success', 'Clock Out berhasil dicatat!');
    }
}
