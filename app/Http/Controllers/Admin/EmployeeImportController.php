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
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if (empty($lines)) {
            return back()->with('error', 'File CSV kosong.');
        }

        // Auto-detect delimiter (tab, comma, or semicolon)
        $firstLine = $lines[0];
        $delimiter = "\t";
        if (str_contains($firstLine, ',')) {
            $delimiter = ',';
        } elseif (str_contains($firstLine, ';')) {
            $delimiter = ';';
        }

        $data = array_map(function ($line) use ($delimiter) {
            return str_getcsv($line, $delimiter);
        }, $lines);

        // Ambil header dari baris pertama
        $header = array_map('trim', array_shift($data));

        // Hapus BOM (Byte Order Mark) dari header pertama
        $header[0] = preg_replace('/^\xEF\xBB\xBF|\xEF\xBB\xBF$/', '', $header[0]);
        $header[0] = trim($header[0]);

        $expectedHeader = [
            'NIK', 'Nama Lengkap', 'Email', 'Tanggal Lahir', 'Tempat Lahir', 'Jenis Kelamin',
            'Telepon', 'Alamat', 'Departemen', 'Jabatan', 'Tanggal Gabung', 'Status',
            'Nama Bank', 'Nomor Rekening', 'Nama Rekening', 'NPWP', 'BPJS Kesehatan', 'BPJS Ketenagakerjaan', 'Catatan',
        ];

        // Normalize header (trim values)
        $header = array_map('trim', $header);

        if (count($header) !== count($expectedHeader)) {
            return back()->withErrors(['file' => 'Jumlah kolom header tidak sesuai. Diharapkan ' . count($expectedHeader) . ' kolom, tetapi ditemukan ' . count($header) . ' kolom. Pastikan file menggunakan tab (TSV) atau koma (CSV) sebagai pemisah.']);
        }

        // Check header matches (case-insensitive)
        foreach ($header as $i => $h) {
            if (strcasecmp(trim($h), $expectedHeader[$i]) !== 0) {
                return back()->withErrors(['file' => 'Header kolom ke-' . ($i + 1) . ' tidak sesuai. Diharapkan "' . $expectedHeader[$i] . '" tetapi ditemukan "' . trim($h) . '".']);
            }
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

                // Parse dates: handle multiple formats (d/m/Y, m/d/Y, Y-m-d)
                $birthDate = $this->parseDate($rowData['Tanggal Lahir']);
                $joinDate = $this->parseDate($rowData['Tanggal Gabung']);

                if (!$birthDate) {
                    $errors[] = 'Baris ' . ($rowNum + 2) . ': Format Tanggal Lahir tidak valid. Gunakan format YYYY-MM-DD atau DD/MM/YYYY.';
                    continue;
                }
                if (!$joinDate) {
                    $errors[] = 'Baris ' . ($rowNum + 2) . ': Format Tanggal Gabung tidak valid. Gunakan format YYYY-MM-DD atau DD/MM/YYYY.';
                    continue;
                }

                $rowData['Tanggal Lahir'] = $birthDate;
                $rowData['Tanggal Gabung'] = $joinDate;

                // Clean NIK: remove scientific notation, ensure string
                $rowData['NIK'] = $this->cleanNumeric($rowData['NIK']);

                // Clean phone: ensure starts with 0
                $rowData['Telepon'] = $this->cleanPhone($rowData['Telepon']);

                $validator = Validator::make($rowData, [
                    'NIK' => 'required|string|unique:employees,nik',
                    'Nama Lengkap' => 'required|string|max:255',
                    'Email' => 'required|email|unique:users,email',
                    'Tanggal Lahir' => 'required|date',
                    'Jenis Kelamin' => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
                    'Telepon' => 'nullable|string|max:20',
                    'Alamat' => 'nullable|string|max:500',
                    'Departemen' => 'required|exists:departments,name',
                    'Jabatan' => 'required|exists:positions,name',
                    'Tanggal Gabung' => 'required|date',
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
                    'password' => Hash::make('password'),
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
            return back()->withErrors($errors)->with('info', $importedCount . ' pegawai berhasil diimpor, namun ada kesalahan pada baris tertentu.');
        }

        return redirect()->route('employees.index')
            ->with('success', $importedCount . ' pegawai berhasil diimpor.');
    }

    /**
     * Parse date from various formats to Y-m-d
     */
    private function parseDate($date)
    {
        if (empty($date)) return null;

        $date = trim($date);

        // Already Y-m-d
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return $date;
        }

        // Split by slash or dash
        $parts = preg_split('#[/\-\.]#', $date);

        if (count($parts) === 3 && is_numeric($parts[0]) && is_numeric($parts[1]) && is_numeric($parts[2])) {
            $a = (int)$parts[0];
            $b = (int)$parts[1];
            $c = (int)$parts[2];

            // Assume c is year (4 digits)
            if ($c < 100) $c += 2000;

            // If first part > 12, it must be day → d/m/Y
            if ($a > 12) {
                return sprintf('%04d-%02d-%02d', $c, $b, $a);
            }

            // If second part > 12, first part must be month → m/d/Y
            if ($b > 12) {
                return sprintf('%04d-%02d-%02d', $c, $a, $b);
            }

            // Both ≤ 12, ambiguous → assume m/d/Y (US format)
            return sprintf('%04d-%02d-%02d', $c, $a, $b);
        }

        // Try Carbon parse as last resort
        try {
            return \Carbon\Carbon::parse($date)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Clean numeric field (remove scientific notation, non-digit chars except dot/hyphen)
     */
    private function cleanNumeric($value)
    {
        $value = trim($value);
        // Remove scientific notation (e.g., 3.17301E+15)
        if (stripos($value, 'e') !== false) {
            $value = number_format((float)$value, 0, '', '');
        }
        // Remove dots used as thousands separator but keep dashes for NPWP
        if (str_contains($value, '.') && !str_contains($value, '-')) {
            $value = str_replace('.', '', $value);
        }
        return $value;
    }

    /**
     * Clean phone number - ensure starts with 0
     */
    private function cleanPhone($phone)
    {
        $phone = trim($phone);
        if (empty($phone)) return null;

        // Remove non-digit characters
        $phone = preg_replace('/[^\d]/', '', $phone);

        // If starts with 62, convert to 0
        if (substr($phone, 0, 2) === '62') {
            $phone = '0' . substr($phone, 2);
        }

        // If doesn't start with 0, add 0
        if (substr($phone, 0, 1) !== '0') {
            $phone = '0' . $phone;
        }

        return $phone;
    }
}
