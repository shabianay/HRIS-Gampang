<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'link',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public static function send($userId, $type, $title, $message, $link = null): self
    {
        $notification = static::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'link' => $link,
        ]);

        return $notification;
    }

    public static function sendToAdmins($type, $title, $message, $link = null): void
    {
        $adminUsers = User::where('role', 'admin_hr')->get();
        foreach ($adminUsers as $admin) {
            static::send($admin->id, $type, $title, $message, $link);
        }
    }
}
