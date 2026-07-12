<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

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

        return redirect()->route('leave-requests.index')
            ->with('success', 'Pengajuan cuti berhasil disetujui.');
    }

    public function reject(Request $request, LeaveRequest $leaveRequest)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $leaveRequest->update([
            'status' => 'rejected',
            'approved_by_id' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return redirect()->route('leave-requests.index')
            ->with('success', 'Pengajuan cuti berhasil ditolak.');
    }
}
