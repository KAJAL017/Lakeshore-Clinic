<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'channel',
        'event',
        'status',
        'recipient',
        'message',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'queued' => 'Queued',
            'sent' => 'Sent',
            'delivered' => 'Delivered',
            'failed' => 'Failed',
            'cancelled' => 'Cancelled',
            default => ucfirst($this->status),
        };
    }

    public function getChannelLabelAttribute(): string
    {
        return match ($this->channel) {
            'email' => 'Email',
            'sms' => 'SMS',
            'push' => 'Push Notification',
            'whatsapp' => 'WhatsApp',
            default => ucfirst($this->channel),
        };
    }

    public function getEventLabelAttribute(): string
    {
        return match ($this->event) {
            'registration' => 'Registration',
            'doctor_approval' => 'Doctor Approval',
            'appointment_submission' => 'Appointment Submission',
            'appointment_approval' => 'Appointment Approval',
            'appointment_rejection' => 'Appointment Rejection',
            'doctor_assignment' => 'Doctor Assignment',
            'payment_confirmation' => 'Payment Confirmation',
            'insurance_update' => 'Insurance Update',
            'prescription_ready' => 'Prescription Ready',
            'meeting_ready' => 'Meeting Ready',
            'cancellation' => 'Cancellation',
            'reminder_24h' => '24 Hour Reminder',
            'reminder_1h' => '1 Hour Reminder',
            default => ucfirst(str_replace('_', ' ', $this->event)),
        };
    }
}
