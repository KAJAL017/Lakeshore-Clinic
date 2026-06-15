<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'appointment_id',
        'consultation_id',
        'document_type',
        'file_name',
        'original_name',
        'file_path',
        'file_size',
        'mime_type',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class);
    }

    public function getDocumentTypeLabelAttribute(): string
    {
        return match ($this->document_type) {
            'lab_report' => 'Lab Report',
            'imaging' => 'Imaging',
            'prescription' => 'Prescription',
            'referral' => 'Referral',
            'insurance' => 'Insurance',
            'other' => 'Other',
            default => ucfirst(str_replace('_', ' ', $this->document_type)),
        };
    }
}
