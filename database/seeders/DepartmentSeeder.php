<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Teknologi Informasi', 'code' => 'IT', 'description' => 'Divisi Teknologi Informasi'],
            ['name' => 'Kepegawaian', 'code' => 'HRD', 'description' => 'Divisi Kepegawaian'],
            ['name' => 'Keuangan', 'code' => 'FIN', 'description' => 'Divisi Keuangan'],
            ['name' => 'Marketing', 'code' => 'MKT', 'description' => 'Divisi Marketing'],
            ['name' => 'Operasional', 'code' => 'OPS', 'description' => 'Divisi Operasional'],
            ['name' => 'Umum', 'code' => 'UMUM', 'description' => 'Divisi Umum'],
        ];

        foreach ($departments as $dept) {
            Department::updateOrCreate(
                ['code' => $dept['code']],
                $dept
            );
        }
    }
}
