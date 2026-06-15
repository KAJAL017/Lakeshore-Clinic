<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackupLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'backup_type',
        'status',
        'file_path',
        'file_size',
        'duration',
        'notes',
    ];

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'running' => 'Running',
            'completed' => 'Completed',
            'failed' => 'Failed',
            default => ucfirst($this->status),
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->backup_type) {
            'database' => 'Database Backup',
            'system' => 'System Backup',
            'configuration' => 'Configuration Backup',
            default => ucfirst($this->backup_type),
        };
    }
}
