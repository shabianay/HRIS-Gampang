<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalaryComponent;
use Illuminate\Http\Request;

class SalaryComponentController extends Controller
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
        $salaryComponents = SalaryComponent::latest()->paginate(10);

        return view('admin.salary_components.index', compact('salaryComponents'));
    }

    public function create()
    {
        return view('admin.salary_components.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:salary_components,code',
            'type' => 'required|in:allowance,deduction',
            'amount' => 'required|numeric|min:0',
            'calculation' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
        ]);

        SalaryComponent::create($validated);

        return redirect()->route('salary-components.index')
            ->with('success', 'Komponen gaji berhasil ditambahkan.');
    }

    public function edit(SalaryComponent $salaryComponent)
    {
        return view('admin.salary_components.edit', compact('salaryComponent'));
    }

    public function update(Request $request, SalaryComponent $salaryComponent)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:salary_components,code,' . $salaryComponent->id,
            'type' => 'required|in:allowance,deduction',
            'amount' => 'required|numeric|min:0',
            'calculation' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
        ]);

        $salaryComponent->update($validated);

        return redirect()->route('salary-components.index')
            ->with('success', 'Komponen gaji berhasil diperbarui.');
    }

    public function destroy(SalaryComponent $salaryComponent)
    {
        $salaryComponent->delete();

        return redirect()->route('salary-components.index')
            ->with('success', 'Komponen gaji berhasil dihapus.');
    }
}
