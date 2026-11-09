<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandarPelayanan extends Model
{
    use HasFactory;

    protected $table = 'standar_pelayanans';

    protected $fillable = [
        'title',
        'source_type',
        'file_extension',
        'category',
        'order_position',
        'is_active',
        'download_count',
        'file_path',
        'file_size',
        'uploaded_at',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
        'is_active' => 'boolean',
        'order_position' => 'integer',
        'download_count' => 'integer',
    ];

    public function isDriveLink(): bool
    {
        return $this->source_type === 'drive_link';
    }

    public function isPdf(): bool
    {
        return strtolower((string) $this->file_extension) === 'pdf';
    }

    public function isWord(): bool
    {
        $ext = strtolower((string) $this->file_extension);

        return in_array($ext, ['doc', 'docx']);
    }

    public function isExcel(): bool
    {
        $ext = strtolower((string) $this->file_extension);

        return in_array($ext, ['xls', 'xlsx', 'csv']);
    }

    public function getBadgeLabelAttribute(): string
    {
        if ($this->isDriveLink()) {
            return 'DRIVE';
        }

        $ext = strtoupper((string) ($this->file_extension ?: 'PDF'));

        return $ext;
    }

    public function getBadgeColorClassAttribute(): string
    {
        if ($this->isDriveLink()) {
            return 'bg-amber-50 text-amber-700 border-amber-200';
        }

        if ($this->isWord()) {
            return 'bg-blue-50 text-blue-700 border-blue-200';
        }

        if ($this->isExcel()) {
            return 'bg-emerald-50 text-emerald-700 border-emerald-200';
        }

        return 'bg-red-50 text-red-600 border-red-200';
    }
}
