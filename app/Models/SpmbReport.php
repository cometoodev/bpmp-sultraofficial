<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SpmbReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'category',
        'name',
        'email',
        'phone',
        'address',
        'message',
        'evidence_file',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get URL of evidence file.
     */
    public function getEvidenceUrlAttribute(): ?string
    {
        if (! $this->evidence_file) {
            return null;
        }

        return Storage::disk('public')->url($this->evidence_file);
    }
}
