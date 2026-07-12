<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
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
        $leaveTypes = LeaveType::latest()->paginate(10);

        return view('admin.leave_types.index', compact('leaveTypes'));
    }

    public function create()
    {
        return view('admin.leave_types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:leave_types,code',
            'quota' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'is_paid' => 'boolean',
        ]);

        LeaveType::create($validated);

        return redirect()->route('leave-types.index')
            ->with('success', 'Tipe cuti berhasil ditambahkan.');
    }

    public function edit(LeaveType $leaveType)
    {
        return view('admin.leave_types.edit', compact('leaveType'));
    }

    public function update(Request $request, LeaveType $leaveType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:leave_types,code,' . $leaveType->id,
            'quota' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'is_paid' => 'boolean',
        ]);

        $leaveType->update($validated);

        return redirect()->route('leave-types.index')
            ->with('success', 'Tipe cuti berhasil diperbarui.');
    }

    public function destroy(LeaveType $leaveType)
    {
        $leaveType->delete();

        return redirect()->route('leave-types.index')
            ->with('success', 'Tipe cuti berhasil dihapus.');
    }
}
