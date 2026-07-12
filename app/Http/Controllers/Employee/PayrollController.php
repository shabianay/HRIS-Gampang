<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Payroll;

class PayrollController extends Controller
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

        $payrolls = Payroll::with(['employee.department', 'employee.position'])
            ->where('employee_id', $employee->id)
            ->latest()
            ->paginate(10);

        return view('employee.payrolls.index', compact('payrolls'));
    }

    public function show(Payroll $payroll)
    {
        $employee = auth()->user()->employee;

        if ($payroll->employee_id !== $employee->id) {
            abort(403);
        }

        $payroll->load(['employee.department', 'employee.position']);

        return view('employee.payrolls.show', compact('payroll'));
    }

    public function print(Payroll $payroll)
    {
        $employee = auth()->user()->employee;

        if ($payroll->employee_id !== $employee->id) {
            abort(403);
        }

        $payroll->load(['employee.department', 'employee.position']);

        return view('employee.payrolls.print', compact('payroll'));
    }
}
