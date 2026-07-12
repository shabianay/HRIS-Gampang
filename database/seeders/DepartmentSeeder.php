<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        Department::create([
            'name' => 'IT',
            'code' => 'IT',
            'description' => 'Information Technology Department',
        ]);

        Department::create([
            'name' => 'HRD',
            'code' => 'HRD',
            'description' => 'Human Resources Department',
        ]);

        Department::create([
            'name' => 'Keuangan',
            'code' => 'FIN',
            'description' => 'Finance Department',
        ]);

        Department::create([
            'name' => 'Marketing',
            'code' => 'MKT',
            'description' => 'Marketing Department',
        ]);
    }
}
