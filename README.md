<p align="center"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></p>

## Tentang HRIS Gampang

**HRIS Gampang** adalah sistem informasi kepegawaian (Human Resource Information System) berbasis web yang dibangun dengan Laravel 12. Sistem ini dirancang untuk memudahkan pengelolaan data HR di organisasi/perusahaan.

### Fitur Utama

- **Manajemen Pegawai** — CRUD data pegawai, upload foto, import CSV/TSV, archive/restore
- **Manajemen Departemen & Jabatan** — Kelola struktur organisasi
- **Absensi** — Clock in/out dengan GPS dan selfie, deteksi keterlambatan otomatis, rekap bulanan, export CSV
- **Pengajuan Cuti** — Ajukan cuti, upload dokumen pendukung, approval/rejection oleh admin, notifikasi email
- **Penggajian (Payroll)** — Komponen gaji (tunjangan/potongan), hitung BPJS & PPh21 otomatis, cetak slip gaji, notifikasi
- **Notifikasi** — Notifikasi in-app real-time
- **Activity Log** — Catat aktivitas pengguna
- **Two Role** — Admin HR dan Pegawai

### Tech Stack

| Lapisan | Teknologi |
|---|---|
| Backend | Laravel 12, PHP ^8.2 |
| Frontend | Blade, Tailwind CSS 3, Alpine.js 3 |
| Build | Vite 7 |
| Database | SQLite / MySQL / PostgreSQL |
| Auth | Laravel Breeze |

### Prasyarat

- PHP ^8.2
- Composer
- Node.js & npm
- SQLite / MySQL / PostgreSQL

### Instalasi

```bash
git clone https://github.com/username/hris-gampang.git
cd hris-gampang
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

### Login Default

| Role | Email | Password |
|---|---|---|
| Admin HR | admin@example.com | password |
| Pegawai | pegawai@example.com | password |

### Pengembangan

```bash
npm run dev
```

### Scheduler

Pastikan cron job di server menjalankan `php artisan schedule:run` setiap menit untuk fitur absensi otomatis.

### License

[MIT](https://opensource.org/licenses/MIT)
