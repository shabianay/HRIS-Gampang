<x-mail::message>
# {{ $action === 'approved' ? '✅ Pengajuan Cuti Disetujui' : '❌ Pengajuan Cuti Ditolak' }}

Yth. **{{ $leaveRequest->employee->full_name }}**,

Pengajuan cuti Anda dengan detail berikut telah **{{ $action === 'approved' ? 'disetujui' : 'ditolak' }}**:

@component('mail::table')
| Detail | Keterangan |
|--------|------------|
| Tipe Cuti | {{ $leaveRequest->leaveType->name }} |
| Tanggal | {{ $leaveRequest->start_date->format('d/m/Y') }} - {{ $leaveRequest->end_date->format('d/m/Y') }} |
| Durasi | {{ $leaveRequest->days }} hari |
| Status | {{ ucfirst($action) }} |
@if($action === 'rejected' && $leaveRequest->rejection_reason)
| Alasan Ditolak | {{ $leaveRequest->rejection_reason }} |
@endif
@endcomponent

Silakan login ke sistem untuk melihat detail lebih lanjut.

@component('mail::button', ['url' => route('employee.leave-requests.show', $leaveRequest)])
Lihat Detail
@endcomponent

Terima kasih,<br>
**{{ config('app.name') }}**
</x-mail::message>
