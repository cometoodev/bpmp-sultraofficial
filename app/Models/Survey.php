<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'period',
        'year',
        'description',
        'total_respondents',
        'nrr_elements',
        'nrt_elements',
        'ikm_score',
        'ikm_service_quality',
        'ikm_performance_category',
        'is_active',
    ];

    protected $casts = [
        'year' => 'integer',
        'total_respondents' => 'integer',
        'nrr_elements' => 'array',
        'nrt_elements' => 'array',
        'ikm_score' => 'float',
        'is_active' => 'boolean',
    ];

    /**
     * Nama-nama baku 9 unsur SKM sesuai Permenpan RB No 14 Tahun 2017.
     *
     * @return array<string, string>
     */
    public static function elementLabels(): array
    {
        return [
            'u1' => 'Persyaratan',
            'u2' => 'Prosedur',
            'u3' => 'Waktu Pelayanan',
            'u4' => 'Biaya / Tarif',
            'u5' => 'Produk Pelayanan',
            'u6' => 'Kompetensi Pelaksana',
            'u7' => 'Perilaku Pelaksana',
            'u8' => 'Penanganan Pengaduan',
            'u9' => 'Sarana & Prasarana',
        ];
    }

    public function responses(): HasMany
    {
        return $this->hasMany(SurveyResponse::class);
    }
}
