<?php

namespace App\Mail;

use App\Models\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeaveRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    public LeaveRequest $leaveRequest;
    public string $action;

    public function __construct(LeaveRequest $leaveRequest, string $action)
    {
        $this->leaveRequest = $leaveRequest;
        $this->action = $action;
    }

    public function envelope(): Envelope
    {
        $subject = $this->action === 'approved'
            ? 'Pengajuan Cuti Disetujui'
            : 'Pengajuan Cuti Ditolak';

        return new Envelope(
            to: [$this->leaveRequest->employee->user->email],
            subject: $subject . ' - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.leave-request-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
