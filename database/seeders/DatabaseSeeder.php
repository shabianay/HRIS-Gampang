<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Payroll;
use App\Models\Position;
use App\Models\SalaryComponent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(PayrollSettingSeeder::class);

        // ─── Departments ───────────────────────────────────────────────
        $departments = [
            ['name' => 'Teknologi Informasi', 'code' => 'IT', 'description' => 'Divisi Teknologi Informasi'],
            ['name' => 'Sumber Daya Manusia', 'code' => 'HRD', 'description' => 'Divisi Sumber Daya Manusia'],
            ['name' => 'Keuangan', 'code' => 'FIN', 'description' => 'Divisi Keuangan dan Akuntansi'],
            ['name' => 'Pemasaran', 'code' => 'MKT', 'description' => 'Divisi Pemasaran dan Branding'],
            ['name' => 'Operasional', 'code' => 'OPS', 'description' => 'Divisi Operasional'],
        ];
        foreach ($departments as $data) {
            Department::create($data);
        }

        // ─── Positions ─────────────────────────────────────────────────
        $positions = [
            ['name' => 'Staff', 'code' => 'STF', 'level' => 1, 'description' => 'Staff level position'],
            ['name' => 'Senior Staff', 'code' => 'SSTF', 'level' => 2, 'description' => 'Senior Staff level position'],
            ['name' => 'Supervisor', 'code' => 'SPV', 'level' => 3, 'description' => 'Supervisor level position'],
            ['name' => 'Manager', 'code' => 'MGR', 'level' => 4, 'description' => 'Manager level position'],
            ['name' => 'Direktur', 'code' => 'DIR', 'level' => 5, 'description' => 'Direktur level position'],
        ];
        foreach ($positions as $data) {
            Position::create($data);
        }

        // ─── Users & Employees ──────────────────────────────────────────
        $employeeData = [
            [
                'email' => 'admin@hris.com',
                'role' => 'admin_hr',
                'nik' => '3273010101990001',
                'full_name' => 'Admin HR',
                'gender' => 'P',
                'birth_date' => '1992-05-15',
                'birth_place' => 'Bandung',
                'phone' => '081222222222',
                'department_id' => 2,
                'position_id' => 3,
                'join_date' => '2021-03-10',
                'status' => 'aktif',
                'bank_name' => 'Mandiri',
                'bank_account' => '1234567891',
                'bank_account_name' => 'Admin HR',
                'npwp' => '12.345.678.9-012.001',
                'bpjs_kesehatan' => '0001234567891',
                'bpjs_ketenagakerjaan' => '123456789013',
            ],
            [
                'email' => 'pegawai@hris.com',
                'role' => 'pegawai',
                'nik' => '3273010101990004',
                'full_name' => 'Shabian Arsyl',
                'gender' => 'L',
                'birth_date' => '1995-03-05',
                'birth_place' => 'Semarang',
                'phone' => '081255555555',
                'department_id' => 1,
                'position_id' => 1,
                'join_date' => '2022-08-01',
                'status' => 'aktif',
                'bank_name' => 'BCA',
                'bank_account' => '1234567894',
                'bank_account_name' => 'Shabian Arsyl',
                'npwp' => '12.345.678.9-012.004',
                'bpjs_kesehatan' => '0001234567894',
                'bpjs_ketenagakerjaan' => '123456789016',
                'address' => 'Jl. Merdeka No. 10, Semarang',
            ],
            [
                'email' => 'siti@hris.com',
                'role' => 'pegawai',
                'nik' => '3273010101990005',
                'full_name' => 'Siti Rahmawati',
                'gender' => 'P',
                'birth_date' => '1993-07-20',
                'birth_place' => 'Jakarta',
                'phone' => '081266666666',
                'department_id' => 2,
                'position_id' => 2,
                'join_date' => '2023-01-15',
                'status' => 'aktif',
                'bank_name' => 'BRI',
                'bank_account' => '1234567895',
                'bank_account_name' => 'Siti Rahmawati',
                'npwp' => '12.345.678.9-012.005',
                'bpjs_kesehatan' => '0001234567895',
                'bpjs_ketenagakerjaan' => '123456789017',
                'address' => 'Jl. Sudirman No. 20, Jakarta',
            ],
            [
                'email' => 'budi@hris.com',
                'role' => 'pegawai',
                'nik' => '3273010101990006',
                'full_name' => 'Budi Santoso',
                'gender' => 'L',
                'birth_date' => '1990-11-10',
                'birth_place' => 'Surabaya',
                'phone' => '081277777777',
                'department_id' => 3,
                'position_id' => 1,
                'join_date' => '2021-06-01',
                'status' => 'aktif',
                'bank_name' => 'BNI',
                'bank_account' => '1234567896',
                'bank_account_name' => 'Budi Santoso',
                'npwp' => '12.345.678.9-012.006',
                'bpjs_kesehatan' => '0001234567896',
                'bpjs_ketenagakerjaan' => '123456789018',
                'address' => 'Jl. Ahmad Yani No. 5, Surabaya',
            ],
            [
                'email' => 'dewi@hris.com',
                'role' => 'pegawai',
                'nik' => '3273010101990007',
                'full_name' => 'Dewi Lestari',
                'gender' => 'P',
                'birth_date' => '1998-02-14',
                'birth_place' => 'Yogyakarta',
                'phone' => '081288888888',
                'department_id' => 4,
                'position_id' => 2,
                'join_date' => '2024-03-01',
                'status' => 'aktif',
                'bank_name' => 'Mandiri',
                'bank_account' => '1234567897',
                'bank_account_name' => 'Dewi Lestari',
                'npwp' => '12.345.678.9-012.007',
                'bpjs_kesehatan' => '0001234567897',
                'bpjs_ketenagakerjaan' => '123456789019',
                'address' => 'Jl. Malioboro No. 15, Yogyakarta',
            ],
            [
                'email' => 'rizky@hris.com',
                'role' => 'pegawai',
                'nik' => '3273010101990008',
                'full_name' => 'Rizky Hidayat',
                'gender' => 'L',
                'birth_date' => '1994-09-30',
                'birth_place' => 'Medan',
                'phone' => '081299999999',
                'department_id' => 5,
                'position_id' => 1,
                'join_date' => '2022-11-20',
                'status' => 'aktif',
                'bank_name' => 'BCA',
                'bank_account' => '1234567898',
                'bank_account_name' => 'Rizky Hidayat',
                'npwp' => '12.345.678.9-012.008',
                'bpjs_kesehatan' => '0001234567898',
                'bpjs_ketenagakerjaan' => '123456789020',
                'address' => 'Jl. Diponegoro No. 8, Medan',
            ],
            [
                'email' => 'nur@hris.com',
                'role' => 'pegawai',
                'nik' => '3273010101990009',
                'full_name' => 'Nur Aisyah',
                'gender' => 'P',
                'birth_date' => '1996-12-25',
                'birth_place' => 'Makassar',
                'phone' => '081210101010',
                'department_id' => 4,
                'position_id' => 3,
                'join_date' => '2020-08-10',
                'status' => 'cuti',
                'bank_name' => 'BTN',
                'bank_account' => '1234567899',
                'bank_account_name' => 'Nur Aisyah',
                'npwp' => '12.345.678.9-012.009',
                'bpjs_kesehatan' => '0001234567899',
                'bpjs_ketenagakerjaan' => '123456789021',
                'address' => 'Jl. Pahlawan No. 12, Makassar',
            ],
        ];

        $createdEmployees = [];
        foreach ($employeeData as $data) {
            $user = User::create([
                'name' => $data['full_name'],
                'email' => $data['email'],
                'password' => 'password',
                'role' => $data['role'],
                'is_active' => true,
            ]);

            $createdEmployees[] = Employee::create([
                'user_id' => $user->id,
                'nik' => $data['nik'],
                'full_name' => $data['full_name'],
                'gender' => $data['gender'],
                'birth_date' => $data['birth_date'],
                'birth_place' => $data['birth_place'],
                'phone' => $data['phone'],
                'address' => $data['address'] ?? null,
                'department_id' => $data['department_id'],
                'position_id' => $data['position_id'],
                'join_date' => $data['join_date'],
                'status' => $data['status'],
                'bank_name' => $data['bank_name'],
                'bank_account' => $data['bank_account'],
                'bank_account_name' => $data['bank_account_name'],
                'npwp' => $data['npwp'],
                'bpjs_kesehatan' => $data['bpjs_kesehatan'],
                'bpjs_ketenagakerjaan' => $data['bpjs_ketenagakerjaan'],
            ]);
        }

        // ─── Leave Types ───────────────────────────────────────────────
        $leaveTypes = [
            ['name' => 'Cuti Tahunan', 'code' => 'CT', 'quota' => 12, 'description' => 'Cuti tahunan karyawan', 'is_paid' => true],
            ['name' => 'Cuti Sakit', 'code' => 'CS', 'quota' => 12, 'description' => 'Cuti karena sakit', 'is_paid' => true],
            ['name' => 'Cuti Menikah', 'code' => 'CM', 'quota' => 3, 'description' => 'Cuti karena menikah', 'is_paid' => true],
            ['name' => 'Cuti Besar', 'code' => 'CB', 'quota' => 1, 'description' => 'Cuti besar karyawan', 'is_paid' => true],
            ['name' => 'Izin', 'code' => 'IZ', 'quota' => 12, 'description' => 'Izin tidak masuk kerja', 'is_paid' => false],
        ];
        foreach ($leaveTypes as $data) {
            LeaveType::create($data);
        }

        // ─── Leave Requests ────────────────────────────────────────────
        $now = Carbon::now();
        $emp4 = Employee::where('nik', '3273010101990005')->first();
        $emp5 = Employee::where('nik', '3273010101990006')->first();
        $emp6 = Employee::where('nik', '3273010101990007')->first();
        $emp7 = Employee::where('nik', '3273010101990008')->first();

        $leaveRequests = [
            ['employee_id' => $emp4->id, 'leave_type_id' => 1, 'start_date' => $now->copy()->subMonth()->startOfMonth()->addDays(5), 'end_date' => $now->copy()->subMonth()->startOfMonth()->addDays(7), 'days' => 3, 'reason' => 'Liburan keluarga ke Bali', 'status' => 'approved', 'approved_by_id' => 2, 'approved_at' => $now->copy()->subMonth()->startOfMonth()->addDays(2)],
            ['employee_id' => $emp4->id, 'leave_type_id' => 2, 'start_date' => $now->copy()->addDays(10), 'end_date' => $now->copy()->addDays(11), 'days' => 2, 'reason' => 'Sakit demam', 'status' => 'pending', 'approved_by_id' => null, 'approved_at' => null],
            ['employee_id' => $emp5->id, 'leave_type_id' => 2, 'start_date' => $now->copy()->subMonth()->addDays(15), 'end_date' => $now->copy()->subMonth()->addDays(16), 'days' => 2, 'reason' => 'Sakit flu', 'status' => 'approved', 'approved_by_id' => 2, 'approved_at' => $now->copy()->subMonth()->addDays(14)],
            ['employee_id' => $emp5->id, 'leave_type_id' => 1, 'start_date' => $now->copy()->subMonths(2)->addDays(10), 'end_date' => $now->copy()->subMonths(2)->addDays(15), 'days' => 6, 'reason' => 'Mau liburan panjang', 'status' => 'rejected', 'approved_by_id' => 2, 'approved_at' => $now->copy()->subMonths(2)->addDays(8), 'rejection_reason' => 'Melebihi kuota cuti tahunan yang tersisa'],
            ['employee_id' => $emp6->id, 'leave_type_id' => 3, 'start_date' => $now->copy()->subMonth()->addDays(5), 'end_date' => $now->copy()->subMonth()->addDays(7), 'days' => 3, 'reason' => 'Menikah', 'status' => 'approved', 'approved_by_id' => 2, 'approved_at' => $now->copy()->subMonth()->startOfMonth()->addDays(3)],
            ['employee_id' => $emp7->id, 'leave_type_id' => 5, 'start_date' => $now->copy()->addDays(5), 'end_date' => $now->copy()->addDays(5), 'days' => 1, 'reason' => 'Ada acara keluarga', 'status' => 'pending', 'approved_by_id' => null, 'approved_at' => null],
            ['employee_id' => $emp6->id, 'leave_type_id' => 1, 'start_date' => $now->copy()->subMonths(2)->addDays(3), 'end_date' => $now->copy()->subMonths(2)->addDays(5), 'days' => 3, 'reason' => 'Liburan ke Jogja', 'status' => 'approved', 'approved_by_id' => 2, 'approved_at' => $now->copy()->subMonths(2)->startOfMonth()->addDays(1)],
        ];
        foreach ($leaveRequests as $data) {
            LeaveRequest::create($data);
        }

        // ─── Attendances ───────────────────────────────────────────────
        $attendanceSamples = [
            ['nik' => '3273010101990005', 'date' => '2026-07-13', 'clock_in' => '08:00:00', 'clock_out' => '17:00:00', 'status' => 'hadir', 'late_minutes' => 0],
            ['nik' => '3273010101990006', 'date' => '2026-07-13', 'clock_in' => '08:30:00', 'clock_out' => '17:15:00', 'status' => 'terlambat', 'late_minutes' => 30],
            ['nik' => '3273010101990007', 'date' => '2026-07-14', 'clock_in' => '07:50:00', 'clock_out' => '17:00:00', 'status' => 'hadir', 'late_minutes' => 0],
            ['nik' => '3273010101990008', 'date' => '2026-07-14', 'clock_in' => '09:00:00', 'clock_out' => '17:30:00', 'status' => 'terlambat', 'late_minutes' => 60],
        ];

        foreach ($attendanceSamples as $data) {
            $employee = Employee::where('nik', $data['nik'])->first();
            if ($employee) {
                Attendance::create([
                    'employee_id' => $employee->id,
                    'date' => $data['date'],
                    'clock_in' => $data['clock_in'],
                    'clock_out' => $data['clock_out'],
                    'location' => 'Kantor Pusat',
                    'status' => $data['status'],
                    'late_minutes' => $data['late_minutes'],
                    'notes' => $data['late_minutes'] > 0 ? 'Terlambat ' . $data['late_minutes'] . ' menit' : null,
                    'created_by_id' => 1,
                ]);
            }
        }

        // ─── Salary Components ─────────────────────────────────────────
        $components = [
            ['name' => 'Gaji Pokok', 'code' => 'GP', 'type' => 'allowance', 'amount' => 5000000, 'calculation' => 'fixed', 'is_active' => true, 'description' => 'Gaji pokok karyawan'],
            ['name' => 'Tunjangan Makan', 'code' => 'TM', 'type' => 'allowance', 'amount' => 500000, 'calculation' => 'fixed', 'is_active' => true, 'description' => 'Tunjangan makan harian'],
            ['name' => 'Tunjangan Transportasi', 'code' => 'TT', 'type' => 'allowance', 'amount' => 300000, 'calculation' => 'fixed', 'is_active' => true, 'description' => 'Tunjangan transportasi bulanan'],
            ['name' => 'Tunjangan Jabatan', 'code' => 'TJ', 'type' => 'allowance', 'amount' => 1000000, 'calculation' => 'fixed', 'is_active' => true, 'description' => 'Tunjangan berdasarkan jabatan'],
            ['name' => 'Bonus Kinerja', 'code' => 'BK', 'type' => 'allowance', 'amount' => 750000, 'calculation' => 'fixed', 'is_active' => true, 'description' => 'Bonus berdasarkan kinerja'],
            ['name' => 'BPJS Kesehatan', 'code' => 'BPJSKES', 'type' => 'deduction', 'amount' => 1, 'calculation' => 'percentage', 'is_active' => true, 'description' => 'Potongan BPJS Kesehatan'],
            ['name' => 'BPJS Ketenagakerjaan', 'code' => 'BPJSKT', 'type' => 'deduction', 'amount' => 2, 'calculation' => 'percentage', 'is_active' => true, 'description' => 'Potongan BPJS Ketenagakerjaan'],
            ['name' => 'Potongan Terlambat', 'code' => 'LATE', 'type' => 'deduction', 'amount' => 50000, 'calculation' => 'fixed', 'is_active' => true, 'description' => 'Potongan keterlambatan per hari'],
            ['name' => 'Pajak Penghasilan', 'code' => 'PPh21', 'type' => 'deduction', 'amount' => 5, 'calculation' => 'percentage', 'is_active' => true, 'description' => 'Potongan PPh Pasal 21'],
        ];
        foreach ($components as $data) {
            SalaryComponent::create($data);
        }

        // ─── Payrolls ──────────────────────────────────────────────────
        $allEmployees = Employee::all();
        $baseSalaryMap = [
            1 => 10000000, // Admin HR - Supervisor
            2 => 18000000, // Bambang - Manager
            3 => 18000000, // Dewi - Manager
            4 => 5000000,  // Ahmad - Staff
            5 => 6500000,  // Rina - Senior Staff
            6 => 5000000,  // Hendra - Staff
            7 => 5000000,  // Siti - Staff
        ];

        foreach (['2026-05', '2026-06', '2026-07'] as $period) {
            foreach ($allEmployees as $employee) {
                $baseSalary = $baseSalaryMap[$employee->id] ?? 5000000;
                $allowances = [
                    'tunjangan_makan' => 500000,
                    'tunjangan_transportasi' => 300000,
                    'tunjangan_jabatan' => $employee->position_id >= 3 ? 1500000 : 500000,
                    'bonus_kinerja' => 500000,
                ];
                $deductions = [
                    'bpjs_kesehatan' => $baseSalary * 0.01,
                    'bpjs_ketenagakerjaan' => $baseSalary * 0.02,
                    'pph21' => $baseSalary * 0.05,
                ];

                $totalAllowance = array_sum($allowances);
                $totalDeduction = array_sum($deductions);
                $netSalary = $baseSalary + $totalAllowance - $totalDeduction;

                Payroll::create([
                    'employee_id' => $employee->id,
                    'period' => $period,
                    'base_salary' => $baseSalary,
                    'total_allowance' => $totalAllowance,
                    'total_deduction' => $totalDeduction,
                    'net_salary' => $netSalary,
                    'details' => json_encode([
                        'allowances' => $allowances,
                        'deductions' => $deductions,
                    ]),
                    'status' => $period === '2026-07' ? 'pending' : 'paid',
                    'payment_date' => $period === '2026-07' ? null : Carbon::parse($period . '-28'),
                ]);
            }
        }
    }
}
