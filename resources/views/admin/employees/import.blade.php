<x-admin-layout>
    <div>
        <div class="mb-6">
            <a href="{{ route('employees.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        <div class="card p-6">
            <h2 class="text-xl font-bold text-slate-900 mb-6">Import Data Pegawai</h2>
            <p class="text-sm text-slate-500 mb-4">Unggah file CSV untuk mengimpor data pegawai secara massal.</p>

            <form action="{{ route('employees.import.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="file" class="label">File CSV</label>
                    <input type="file" name="file" id="file" class="input-field p-2.5">
                    <x-input-error :messages="$errors->get('file')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <p class="text-sm font-medium text-slate-700">Format header yang didukung (pemisah: Tab atau Koma):</p>
                    <p class="text-xs text-slate-500 mt-1 font-mono bg-slate-50 p-3 rounded-lg border border-slate-200">NIK, Nama Lengkap, Email, Tanggal Lahir (YYYY-MM-DD), Tempat Lahir, Jenis Kelamin (Laki-laki/Perempuan), Telepon, Alamat, Departemen, Jabatan, Tanggal Gabung (YYYY-MM-DD), Status (aktif/nonaktif/resign/cuti), Nama Bank, Nomor Rekening, Nama Rekening, NPWP, BPJS Kesehatan, BPJS Ketenagakerjaan, Catatan</p>
                    <p class="text-xs text-amber-600 mt-3">
                        <strong>&#9432; Catatan Penting:</strong><br>
                        &bull; Gunakan file dengan ekstensi <code>.csv</code> atau <code>.txt</code><br>
                        &bull; Pemisah kolom bisa Tab, Koma (`,`), atau Titik Koma (`;`)<br>
                        &bull; Tanggal bisa menggunakan format <code>YYYY-MM-DD</code> (contoh: 1990-01-01) atau <code>DD/MM/YYYY</code> (contoh: 01/01/1990)<br>
                        &bull; Default password untuk user yang diimpor adalah <strong>password</strong>. Harap instruksikan pegawai untuk mengubahnya setelah login pertama.<br>
                        &bull; Pastikan Nama Departemen dan Jabatan sudah tersedia di sistem (Pengaturan > Departemen/Jabatan).
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <x-primary-button>Import Pegawai</x-primary-button>
                </div>
            </form>

            @if($errors->any() && session('info'))
                <div class="mt-6 p-4 text-sm text-blue-800 rounded-lg bg-blue-50" role="alert">
                    <span class="font-medium">Informasi:</span> {{ session('info') }}
                    <ul class="mt-1.5 ml-4 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
