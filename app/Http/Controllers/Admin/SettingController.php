<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;

class SettingController extends Controller
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

    public function departments()
    {
        $departments = Department::withCount('employees')->latest()->paginate(10);

        return view('admin.settings.departments.index', compact('departments'));
    }

    public function storeDepartment(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:departments,code',
            'description' => 'nullable|string',
        ]);

        Department::create($validated);

        return redirect()->route('settings.departments')
            ->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function updateDepartment(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:departments,code,' . $department->id,
            'description' => 'nullable|string',
        ]);

        $department->update($validated);

        return redirect()->route('settings.departments')
            ->with('success', 'Departemen berhasil diperbarui.');
    }

    public function destroyDepartment(Department $department)
    {
        if ($department->employees()->count() > 0) {
            return back()->withErrors(['error' => 'Departemen masih memiliki karyawan.']);
        }

        $department->delete();

        return redirect()->route('settings.departments')
            ->with('success', 'Departemen berhasil dihapus.');
    }

    public function positions()
    {
        $positions = Position::withCount('employees')->latest()->paginate(10);

        return view('admin.settings.positions.index', compact('positions'));
    }

    public function storePosition(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:positions,code',
            'level' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        Position::create($validated);

        return redirect()->route('settings.positions')
            ->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function updatePosition(Request $request, Position $position)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:positions,code,' . $position->id,
            'level' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        $position->update($validated);

        return redirect()->route('settings.positions')
            ->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroyPosition(Position $position)
    {
        if ($position->employees()->count() > 0) {
            return back()->withErrors(['error' => 'Jabatan masih memiliki karyawan.']);
        }

        $position->delete();

        return redirect()->route('settings.positions')
            ->with('success', 'Jabatan berhasil dihapus.');
    }
}
