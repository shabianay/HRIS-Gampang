<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;

class LogActivity
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only log for POST, PUT, PATCH, DELETE requests
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            $activity = $this->getActivity($request);
            if ($activity) {
                ActivityLog::create([
                    'user_id' => auth()->check() ? auth()->id() : null,
                    'activity' => $activity,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'properties' => [
                        'method' => $request->method(),
                        'url' => $request->url(),
                        'route' => $request->route() ? $request->route()->getName() : null,
                    ],
                ]);
            }
        }

        return $response;
    }

    protected function getActivity(Request $request): ?string
    {
        $routeName = $request->route() ? $request->route()->getName() : null;
        $method = $request->method();

        if (!$routeName) return null;

        if (str_contains($routeName, 'login')) return 'Login';
        if (str_contains($routeName, 'logout')) return 'Logout';
        if (str_contains($routeName, 'employees.store')) return 'Menambahkan pegawai baru';
        if (str_contains($routeName, 'employees.update')) return 'Mengubah data pegawai';
        if (str_contains($routeName, 'employees.destroy')) return 'Menghapus pegawai';
        if (str_contains($routeName, 'leave-requests.approve')) return 'Menyetujui pengajuan cuti';
        if (str_contains($routeName, 'leave-requests.reject')) return 'Menolak pengajuan cuti';
        if (str_contains($routeName, 'leave-requests.cancel')) return 'Membatalkan pengajuan cuti';
        if (str_contains($routeName, 'leave-requests.store')) return 'Mengajukan cuti';
        if (str_contains($routeName, 'attendances.store')) return 'Input absensi';
        if (str_contains($routeName, 'payrolls.store')) return 'Membuat payroll';
        if (str_contains($routeName, 'payrolls.mark-paid')) return 'Menandai payroll dibayar';
        if (str_contains($routeName, 'payrolls.bulk-paid')) return 'Bulk payment payroll';
        if (str_contains($routeName, 'users.update')) return 'Mengubah data user';
        if (str_contains($routeName, 'users.destroy')) return 'Menonaktifkan user';
        if (str_contains($routeName, 'employees.import.store')) return 'Import pegawai massal';

        return null;
    }
}
