<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfficeHour;
use Illuminate\Http\Request;

class OfficeHourController extends Controller
{
    public function index()
    {
        $officeHour = OfficeHour::first();
        
        if (!$officeHour) {
            $officeHour = OfficeHour::create([
                'clock_in_time' => '08:00:00',
                'clock_out_time' => '17:00:00',
            ]);
        }

        return view('admin.settings.office_hours.index', compact('officeHour'));
    }

    public function update(Request $request, OfficeHour $officeHour)
    {
        $validated = $request->validate([
            'clock_in_time' => 'required',
            'clock_out_time' => 'required',
        ]);

        $officeHour->update($validated);

        return redirect()->back()->with('success', 'Pengaturan jam kantor berhasil diperbarui.');
    }
}
