<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    protected $table = 'user_notifications';

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'unread' => 'Unread',
            'read' => 'Read',
            'archived' => 'Archived',
            default => ucfirst($this->status),
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'system' => 'System',
            'appointment' => 'Appointment',
            'payment' => 'Payment',
            'insurance' => 'Insurance',
            'prescription' => 'Prescription',
            'telemedicine' => 'Telemedicine',
            'general' => 'General',
            default => ucfirst($this->type),
        };
    }
}
