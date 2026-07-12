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
        $users = User::whereDoesntHave('employee')->get();

        return view('admin.employees.create', compact('departments', 'positions', 'users'));
    }

    public function store(StoreEmployeeRequest $request)
    {
        Employee::create($request->validated());

        return redirect()->route('employees.index')
            ->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $positions = Position::all();
        $users = User::whereDoesntHave('employee')->orWhereHas('employee', fn($q) => $q->where('id', $employee->id))->get();

        return view('admin.employees.edit', compact('employee', 'departments', 'positions', 'users'));
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->validated());

        return redirect()->route('employees.index')
            ->with('success', 'Karyawan berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        $employee->update(['status' => 'nonaktif']);

        return redirect()->route('employees.index')
            ->with('success', 'Karyawan berhasil dinonaktifkan.');
    }
}
