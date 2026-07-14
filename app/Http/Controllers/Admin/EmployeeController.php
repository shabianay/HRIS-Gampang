<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;

class EmployeeController extends Controller
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
        $query = Employee::with(['department', 'position', 'user']);

        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        if ($department = request('department')) {
            $query->where('department_id', $department);
        }

        if ($status = request('status')) {
            $query->where('status', $status);
        }

        $employees = $query->latest()->paginate(10);
        $departments = Department::all();

        return view('admin.employees.index', compact('employees', 'departments'));
    }

    public function show(Employee $employee)
    {
        $employee->load(['department', 'position', 'user']);

        return view('admin.employees.show', compact('employee'));
    }

    public function create()
    {
        $departments = Department::all();
        $positions = Position::all();

        return view('admin.employees.create', compact('departments', 'positions'));
    }

    public function store(StoreEmployeeRequest $request)
    {
        $user = User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'is_active' => true,
        ]);

        $employee = Employee::create([
            'user_id' => $user->id,
            'nik' => $request->nik,
            'full_name' => $request->full_name,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'birth_place' => $request->birth_place,
            'phone' => $request->phone,
            'address' => $request->address,
            'department_id' => $request->department_id,
            'position_id' => $request->position_id,
            'join_date' => $request->join_date,
            'status' => $request->status,
            'bank_name' => $request->bank_name,
            'bank_account' => $request->bank_account,
            'bank_account_name' => $request->bank_account_name,
            'npwp' => $request->npwp,
            'bpjs_kesehatan' => $request->bpjs_kesehatan,
            'bpjs_ketenagakerjaan' => $request->bpjs_ketenagakerjaan,
            'notes' => $request->notes,
        ]);

        return redirect()->route('employees.index')
            ->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $positions = Position::all();

        return view('admin.employees.edit', compact('employee', 'departments', 'positions'));
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->user->update([
            'name' => $request->full_name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->filled('password')) {
            $employee->user->update([
                'password' => bcrypt($request->password),
            ]);
        }

        $employee->update($request->validated());

        return redirect()->route('employees.index')
            ->with('success', 'Karyawan berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        $employee->update(['status' => 'nonaktif']);
        $employee->user()->update(['is_active' => false]);
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Karyawan berhasil diarsipkan.');
    }

    public function restore(Employee $employee)
    {
        $employee->restore();
        $employee->update(['status' => 'aktif']);
        $employee->user()->update(['is_active' => true]);

        return redirect()->route('employees.index')
            ->with('success', 'Karyawan berhasil dipulihkan.');
    }

    public function archived()
    {
        $employees = Employee::onlyTrashed()->with(['department', 'position', 'user'])->latest('deleted_at')->paginate(10);

        return view('admin.employees.archived', compact('employees'));
    }

    public function forceDelete(Employee $employee)
    {
        $employee->user()->delete();
        $employee->forceDelete();

        return redirect()->route('employees.index')
            ->with('success', 'Karyawan berhasil dihapus permanen.');
    }
}
