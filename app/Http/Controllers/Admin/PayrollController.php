<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\SalaryComponent;
use Illuminate\Http\Request;

class PayrollController extends Controller
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
        $query = Payroll::with(['employee.department', 'employee.position']);

        if ($month = request('month')) {
            $query->where('period', 'like', $month . '%');
        }

        if ($status = request('status')) {
            $query->where('status', $status);
        }

        $payrolls = $query->latest()->paginate(10);

        return view('admin.payrolls.index', compact('payrolls'));
    }

    public function show(Payroll $payroll)
    {
        $payroll->load(['employee.department', 'employee.position']);

        return view('admin.payrolls.show', compact('payroll'));
    }

    public function create()
    {
        $employees = Employee::with('user')->where('status', 'aktif')->get();
        $salaryComponents = SalaryComponent::where('is_active', true)->get();

        return view('admin.payrolls.create', compact('employees', 'salaryComponents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'period' => 'required|string|max:7',
            'base_salary' => 'required|numeric|min:0',
            'salary_components' => 'nullable|array',
            'salary_components.*' => 'exists:salary_components,id',
        ]);

        $componentIds = $request->input('salary_components', []);
        $selectedComponents = SalaryComponent::whereIn('id', $componentIds)->get();

        $allowances = [];
        $deductions = [];
        $totalAllowance = 0;
        $totalDeduction = 0;

        foreach ($selectedComponents as $component) {
            $amount = $component->calculation === 'percentage'
                ? $validated['base_salary'] * $component->amount / 100
                : $component->amount;

            if ($component->type === 'allowance') {
                $allowances[$component->code] = $amount;
                $totalAllowance += $amount;
            } else {
                $deductions[$component->code] = $amount;
                $totalDeduction += $amount;
            }
        }

        $netSalary = $validated['base_salary'] + $totalAllowance - $totalDeduction;

        $validated['total_allowance'] = $totalAllowance;
        $validated['total_deduction'] = $totalDeduction;
        $validated['net_salary'] = max(0, $netSalary);
        $validated['details'] = [
            'allowances' => $allowances,
            'deductions' => $deductions,
        ];
        $validated['status'] = 'draft';

        Payroll::create($validated);

        return redirect()->route('payrolls.index')
            ->with('success', 'Payroll berhasil dibuat.');
    }

    public function markAsPaid(Payroll $payroll)
    {
        $payroll->update([
            'status' => 'paid',
            'payment_date' => now(),
        ]);

        return redirect()->route('payrolls.index')
            ->with('success', 'Payroll berhasil ditandai sebagai dibayar.');
    }

    public function bulkMarkAsPaid(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return back()->with('error', 'Tidak ada payroll yang dipilih.');
        }

        $count = Payroll::whereIn('id', $ids)
            ->where('status', '!=', 'paid')
            ->update([
                'status' => 'paid',
                'payment_date' => now(),
            ]);

        return redirect()->route('payrolls.index')
            ->with('success', $count . ' payroll berhasil ditandai sebagai dibayar.');
    }
}
