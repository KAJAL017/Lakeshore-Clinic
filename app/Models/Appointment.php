<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    const TYPE_CLINIC = 'clinic';

    const TYPE_TELEMEDICINE = 'telemedicine';

    const STATUS_PENDING = 'pending';

    const STATUS_APPROVED = 'approved';

    const STATUS_REJECTED = 'rejected';

    const STATUS_SCHEDULED = 'scheduled';

    const STATUS_CANCELLED = 'cancelled';

    const STATUS_RESCHEDULED = 'rescheduled';

    const STATUS_COMPLETED = 'completed';

    const STATUS_NO_SHOW = 'no_show';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'specialization_id',
        'type',
        'appointment_date',
        'appointment_time',
        'status',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'date',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_REJECTED => 'Rejected',
            self::STATUS_SCHEDULED => 'Scheduled',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_RESCHEDULED => 'Rescheduled',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_NO_SHOW => 'No Show',
            default => ucfirst($this->status),
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            self::TYPE_CLINIC => 'Clinic Visit',
            self::TYPE_TELEMEDICINE => 'Telemedicine',
            default => ucfirst($this->type),
        };
    }
}
