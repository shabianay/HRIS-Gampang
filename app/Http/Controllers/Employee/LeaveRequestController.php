<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
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

        $leaveRequests = LeaveRequest::with(['leaveType'])
            ->where('employee_id', $employee->id)
            ->latest()
            ->paginate(10);

        return view('employee.leave_requests.index', compact('leaveRequests'));
    }

    public function create()
    {
        $employee = auth()->user()->employee;

        $leaveTypes = LeaveType::all()->map(function ($lt) use ($employee) {
            $used = LeaveRequest::where('employee_id', $employee->id)
                ->where('leave_type_id', $lt->id)
                ->whereIn('status', ['approved', 'pending'])
                ->whereYear('start_date', now()->year)
                ->sum('days');
            $lt->used = $used;
            $lt->remaining = max(0, $lt->quota - $used);
            return $lt;
        });

        return view('employee.leave_requests.create', compact('leaveTypes'));
    }

    public function store(Request $request)
    {
        $employee = auth()->user()->employee;

        $validated = $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:500',
            'supporting_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:1024',
        ]);

        $start = Carbon::parse($validated['start_date']);
        $end = Carbon::parse($validated['end_date']);
        $days = $start->diffInDays($end) + 1;

        $leaveType = LeaveType::findOrFail($validated['leave_type_id']);

        $usedQuota = LeaveRequest::where('employee_id', $employee->id)
            ->where('leave_type_id', $leaveType->id)
            ->whereIn('status', ['approved', 'pending'])
            ->whereYear('start_date', now()->year)
            ->sum('days');

        if ($usedQuota + $days > $leaveType->quota) {
            return back()->withErrors(['leave_type_id' => 'Kuota cuti tidak mencukupi. Sisa kuota: ' . max(0, $leaveType->quota - $usedQuota) . ' hari.'])->withInput();
        }

        $data = [
            'employee_id' => $employee->id,
            'leave_type_id' => $validated['leave_type_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'days' => $days,
            'reason' => $validated['reason'],
            'status' => 'pending',
        ];

        if ($request->hasFile('supporting_document')) {
            $data['supporting_document'] = $request->file('supporting_document')->store('leave-documents', 'public');
        }

        LeaveRequest::create($data);

        return redirect()->route('employee.leave-requests.index')
            ->with('success', 'Pengajuan cuti berhasil dikirim.');
    }

    public function show(LeaveRequest $leaveRequest)
    {
        $employee = auth()->user()->employee;

        if ($leaveRequest->employee_id !== $employee->id) {
            abort(403);
        }

        $leaveRequest->load(['leaveType', 'approvedBy']);

        return view('employee.leave_requests.show', compact('leaveRequest'));
    }
}
