<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'message',
        'data',
        'icon',
        'color',
        'user_id',
        'role',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Get the user that owns the notification
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for unread notifications
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for specific role
     */
    public function scopeForRole($query, $role)
    {
        return $query->where('role', $role)->orWhereNull('role');
    }

    /**
     * Mark as read
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Create a payment notification
     */
    public static function createPaymentNotification($santri, $nominal, $role = 'bendahara')
    {
        return self::create([
            'type' => 'payment',
            'title' => 'Pembayaran Baru',
            'message' => "Pembayaran dari {$santri->nama_santri} sebesar Rp " . number_format($nominal, 0, ',', '.'),
            'icon' => 'dollar-sign',
            'color' => '#10b981',
            'role' => $role,
            'data' => [
                'santri_id' => $santri->id,
                'nominal' => $nominal,
            ],
        ]);
    }

    /**
     * Create a santri notification
     */
    public static function createSantriNotification($santri, $action = 'registered')
    {
        $messages = [
            'registered' => "Santri baru terdaftar: {$santri->nama_santri}",
            'graduated' => "Santri lulus: {$santri->nama_santri}",
            'mutated' => "Santri mutasi: {$santri->nama_santri}",
        ];

        return self::create([
            'type' => 'santri',
            'title' => 'Update Santri',
            'message' => $messages[$action] ?? "Update santri: {$santri->nama_santri}",
            'icon' => 'user',
            'color' => '#3b82f6',
            'role' => 'sekretaris',
            'data' => [
                'santri_id' => $santri->id,
                'action' => $action,
            ],
        ]);
    }

    /**
     * Create a system notification
     */
    public static function createSystemNotification($title, $message, $role = null)
    {
        return self::create([
            'type' => 'system',
            'title' => $title,
            'message' => $message,
            'icon' => 'info',
            'color' => '#8b5cf6',
            'role' => $role,
        ]);
    }
}
