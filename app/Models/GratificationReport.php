<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GratificationReport extends Model
{
    use HasFactory;

    protected $table = 'gratification_reports';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'name',
        'nip',
        'position',
        'activity_name',
        'activity_date',
        'activity_location',
        'free_services',
        'service_date',
        'service_provider_name',
        'service_provider_position',
        'gift_consumable_types',
        'gift_non_consumable_desc',
        'gift_giver_name',
        'gift_giver_position',
        'gift_received_date',
        'follow_up_action',
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
            'activity_date' => 'date',
            'service_date' => 'date',
            'gift_received_date' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get free services as array.
     *
     * @return list<string>
     */
    public function getFreeServicesArrayAttribute(): array
    {
        if (is_array($this->free_services)) {
            return $this->free_services;
        }

        $decoded = json_decode($this->free_services ?? '[]', true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Get gift consumable types as array.
     *
     * @return list<string>
     */
    public function getGiftConsumableTypesArrayAttribute(): array
    {
        if (is_array($this->gift_consumable_types)) {
            return $this->gift_consumable_types;
        }

        $decoded = json_decode($this->gift_consumable_types ?? '[]', true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Get full URL of evidence file.
     */
    public function getEvidenceUrlAttribute(): ?string
    {
        if (! $this->evidence_file) {
            return null;
        }

        return Storage::disk('public')->url($this->evidence_file);
    }
}
