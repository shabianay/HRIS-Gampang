<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\LeaveRequestNotification;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\LeaveRequest;
use App\Models\Notification;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LeaveRequestController extends Controller
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
        $query = LeaveRequest::with(['employee.department', 'leaveType', 'approvedBy']);

        if ($status = request('status')) {
            $query->where('status', $status);
        }

        if ($department = request('department')) {
            $query->whereHas('employee', function ($q) use ($department) {
                $q->where('department_id', $department);
            });
        }

        if ($startDate = request('start_date')) {
            $query->whereDate('start_date', '>=', $startDate);
        }

        if ($endDate = request('end_date')) {
            $query->whereDate('end_date', '<=', $endDate);
        }

        $leaveRequests = $query->latest()->paginate(10);
        $departments = Department::all();

        return view('admin.leave_requests.index', compact('leaveRequests', 'departments'));
    }

    public function show(LeaveRequest $leaveRequest)
    {
        $leaveRequest->load(['employee.department', 'employee.position', 'leaveType', 'approvedBy']);

        return view('admin.leave_requests.show', compact('leaveRequest'));
    }

    public function approve(LeaveRequest $leaveRequest)
    {
        $leaveRequest->update([
            'status' => 'approved',
            'approved_by_id' => auth()->id(),
            'approved_at' => now(),
        ]);

        // Buat Attendance records untuk setiap hari cuti
        $leaveTypeName = strtolower($leaveRequest->leaveType->name ?? '');
        $status = in_array($leaveTypeName, ['izin', 'sakit']) ? $leaveTypeName : 'izin';

        $period = CarbonPeriod::create($leaveRequest->start_date, $leaveRequest->end_date);
        foreach ($period as $date) {
            Attendance::firstOrCreate(
                [
                    'employee_id' => $leaveRequest->employee_id,
                    'date' => $date,
                ],
                [
                    'status' => $status,
                ]
            );
        }

        // Kirim notifikasi email ke pegawai
        Mail::send(new LeaveRequestNotification($leaveRequest, 'approved'));

        Notification::send(
            $leaveRequest->employee->user_id,
            'leave_request',
            'Cuti Disetujui',
            'Pengajuan cuti ' . $leaveRequest->leaveType->name . ' Anda (' . $leaveRequest->days . ' hari) telah disetujui.',
            route('employee.leave-requests.show', $leaveRequest)
        );

        return redirect()->route('leave-requests.index')
            ->with('success', 'Pengajuan cuti berhasil disetujui.');
    }

    public function cancel(LeaveRequest $leaveRequest)
    {
        if ($leaveRequest->status !== 'pending') {
            return back()->with('error', 'Only pending requests can be cancelled.');
        }

        $leaveRequest->update([
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'Pengajuan cuti dibatalkan.');
    }

    public function reject(Request $request, LeaveRequest $leaveRequest)
    {
        if ($leaveRequest->status !== 'pending') {
            return back()->with('error', 'Hanya pengajuan pending yang bisa ditolak.');
        }

        $request->validate([
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $leaveRequest->update([
            'status' => 'rejected',
            'approved_by_id' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        Mail::send(new LeaveRequestNotification($leaveRequest, 'rejected'));

        Notification::send(
            $leaveRequest->employee->user_id,
            'leave_request',
            'Cuti Ditolak',
            'Pengajuan cuti ' . $leaveRequest->leaveType->name . ' Anda (' . $leaveRequest->days . ' hari) telah ditolak.' . ($request->rejection_reason ? ' Alasan: ' . $request->rejection_reason : ''),
            route('employee.leave-requests.show', $leaveRequest)
        );

        return redirect()->route('leave-requests.index')
            ->with('success', 'Pengajuan cuti berhasil ditolak.');
    }
}
