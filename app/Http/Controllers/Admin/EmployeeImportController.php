<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EmployeeImportController extends Controller
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

    public function create()
    {
        return view('admin.employees.import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));

        if (empty($data)) {
            return back()->with('error', 'File CSV kosong.');
        }

        // Asumsi baris pertama adalah header
        $header = array_map('trim', array_shift($data));

        $expectedHeader = [
            'NIK', 'Nama Lengkap', 'Email', 'Tanggal Lahir', 'Tempat Lahir', 'Jenis Kelamin',
            'Telepon', 'Alamat', 'Departemen', 'Jabatan', 'Tanggal Gabung', 'Status',
            'Nama Bank', 'Nomor Rekening', 'Nama Rekening', 'NPWP', 'BPJS Kesehatan', 'BPJS Ketenagakerjaan', 'Catatan',
        ];

        if (count($header) !== count($expectedHeader) || array_diff($expectedHeader, $header)) {
            return back()->withErrors(['file' => 'Format header CSV tidak sesuai. Harap gunakan template yang benar.']);
        }

        $errors = [];
        $importedCount = 0;

        DB::beginTransaction();
        try {
            foreach ($data as $rowNum => $row) {
                if (count($row) !== count($expectedHeader)) {
                    $errors[] = 'Baris ' . ($rowNum + 2) . ': Jumlah kolom tidak sesuai.';
                    continue;
                }

                $rowData = array_combine($expectedHeader, $row);

                $validator = Validator::make($rowData, [
                    'NIK' => 'required|string|unique:employees,nik',
                    'Nama Lengkap' => 'required|string|max:255',
                    'Email' => 'required|email|unique:users,email',
                    'Tanggal Lahir' => 'required|date_format:Y-m-d',
                    'Jenis Kelamin' => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
                    'Telepon' => 'nullable|string|max:20',
                    'Alamat' => 'nullable|string|max:500',
                    'Departemen' => 'required|exists:departments,name',
                    'Jabatan' => 'required|exists:positions,name',
                    'Tanggal Gabung' => 'required|date_format:Y-m-d',
                    'Status' => ['required', Rule::in(['aktif', 'nonaktif', 'resign', 'cuti'])],
                    'Nama Bank' => 'nullable|string|max:255',
                    'Nomor Rekening' => 'nullable|string|max:255',
                    'Nama Rekening' => 'nullable|string|max:255',
                    'NPWP' => 'nullable|string|max:255',
                    'BPJS Kesehatan' => 'nullable|string|max:255',
                    'BPJS Ketenagakerjaan' => 'nullable|string|max:255',
                    'Catatan' => 'nullable|string|max:500',
                ]);

                if ($validator->fails()) {
                    $errors[] = 'Baris ' . ($rowNum + 2) . ': ' . implode(', ', $validator->errors()->all());
                    continue;
                }

                $department = Department::where('name', $rowData['Departemen'])->first();
                $position = Position::where('name', $rowData['Jabatan'])->first();

                // Create User
                $user = User::create([
                    'name' => $rowData['Nama Lengkap'],
                    'email' => $rowData['Email'],
                    'password' => Hash::make('password'), // Default password
                    'role' => 'pegawai',
                    'is_active' => true,
                ]);

                // Create Employee
                Employee::create([
                    'user_id' => $user->id,
                    'nik' => $rowData['NIK'],
                    'full_name' => $rowData['Nama Lengkap'],
                    'gender' => ($rowData['Jenis Kelamin'] === 'Laki-laki') ? 'L' : 'P',
                    'birth_date' => $rowData['Tanggal Lahir'],
                    'birth_place' => $rowData['Tempat Lahir'] ?? '-',
                    'phone' => $rowData['Telepon'] ?? '-',
                    'address' => $rowData['Alamat'] ?? '-',
                    'department_id' => $department->id,
                    'position_id' => $position->id,
                    'join_date' => $rowData['Tanggal Gabung'],
                    'status' => $rowData['Status'],
                    'bank_name' => $rowData['Nama Bank'] ?? null,
                    'bank_account' => $rowData['Nomor Rekening'] ?? null,
                    'bank_account_name' => $rowData['Nama Rekening'] ?? null,
                    'npwp' => $rowData['NPWP'] ?? null,
                    'bpjs_kesehatan' => $rowData['BPJS Kesehatan'] ?? null,
                    'bpjs_ketenagakerjaan' => $rowData['BPJS Ketenagakerjaan'] ?? null,
                    'notes' => $rowData['Catatan'] ?? null,
                ]);

                $importedCount++;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }

        if (!empty($errors)) {
            return back()->withErrors($errors)->with('info', 'Beberapa pegawai berhasil diimpor, namun ada kesalahan pada baris tertentu.');
        }

        return redirect()->route('employees.index')
            ->with('success', $importedCount . ' pegawai berhasil diimpor.');
    }
}
