<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PayrollSetting;
use Illuminate\Http\Request;

class PayrollSettingController extends Controller
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
        $settings = PayrollSetting::all()->pluck('value', 'key')->toArray();

        return view('admin.settings.payroll.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $rules = [
            'bpjs_kesehatan_employee_rate' => 'required|numeric|min:0|max:100',
            'bpjs_kesehatan_employer_rate' => 'required|numeric|min:0|max:100',
            'bpjs_kesehatan_max_base' => 'required|numeric|min:0',
            'bpjs_jht_employee_rate' => 'required|numeric|min:0|max:100',
            'bpjs_jht_employer_rate' => 'required|numeric|min:0|max:100',
            'bpjs_jp_employee_rate' => 'required|numeric|min:0|max:100',
            'bpjs_jp_employer_rate' => 'required|numeric|min:0|max:100',
            'bpjs_jkk_rate' => 'required|numeric|min:0|max:100',
            'bpjs_jkm_rate' => 'required|numeric|min:0|max:100',
            'ptkp_tk0' => 'required|numeric|min:0',
            'ptkp_tk1' => 'required|numeric|min:0',
            'ptkp_tk2' => 'required|numeric|min:0',
            'ptkp_tk3' => 'required|numeric|min:0',
            'ptkp_k0' => 'required|numeric|min:0',
            'ptkp_k1' => 'required|numeric|min:0',
            'ptkp_k2' => 'required|numeric|min:0',
            'ptkp_k3' => 'required|numeric|min:0',
        ];

        $validated = $request->validate($rules);

        foreach ($validated as $key => $value) {
            PayrollSetting::setValue($key, (string) $value);
        }

        return redirect()->route('settings.payroll')
            ->with('success', 'Pengaturan payroll berhasil diperbarui.');
    }
}
