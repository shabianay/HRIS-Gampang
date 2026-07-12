<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    public function run(): void
    {
        LeaveType::create([
            'name' => 'Cuti Tahunan',
            'code' => 'CT',
            'quota' => 12,
            'description' => 'Cuti tahunan karyawan',
            'is_paid' => true,
        ]);

        LeaveType::create([
            'name' => 'Cuti Sakit',
            'code' => 'CS',
            'quota' => 12,
            'description' => 'Cuti karena sakit',
            'is_paid' => true,
        ]);

        LeaveType::create([
            'name' => 'Cuti Menikah',
            'code' => 'CM',
            'quota' => 3,
            'description' => 'Cuti karena menikah',
            'is_paid' => true,
        ]);

        LeaveType::create([
            'name' => 'Cuti Besar',
            'code' => 'CB',
            'quota' => 1,
            'description' => 'Cuti besar karyawan',
            'is_paid' => true,
        ]);

        LeaveType::create([
            'name' => 'Izin',
            'code' => 'IZ',
            'quota' => 12,
            'description' => 'Izin tidak masuk kerja',
            'is_paid' => false,
        ]);
    }
}
