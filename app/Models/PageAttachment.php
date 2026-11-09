<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PageAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id',
        'title',
        'source_type',
        'file_path',
        'file_name',
        'file_extension',
        'file_size',
        'category',
        'order_position',
        'is_active',
        'download_count',
        'uploaded_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'order_position' => 'integer',
            'download_count' => 'integer',
            'uploaded_at' => 'datetime',
        ];
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function isDriveLink(): bool
    {
        return in_array($this->source_type, ['drive', 'drive_link', 'url']) || filter_var($this->file_path, FILTER_VALIDATE_URL);
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

    public function getFileUrlAttribute(): string
    {
        if ($this->isDriveLink()) {
            return $this->file_path;
        }

        return Storage::disk('public')->url($this->file_path);
    }

    public function getFormattedSizeAttribute(): string
    {
        if ($this->isDriveLink()) {
            return 'Google Drive';
        }

        return $this->file_size ?: '-';
    }
}
