<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Guestbook extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'usia',
        'telepon',
        'pendidikan',
        'pekerjaan',
        'status_kepegawaian',
        'asal_instansi',
        'asal_kabupaten',
        'jenis_layanan',
        'import_batch_id',
        'created_at',
        'updated_at',
    ];

    /** @return HasOne<UltSurveyResponse> */
    public function ultSurveyResponse(): HasOne
    {
        return $this->hasOne(UltSurveyResponse::class);
    }

    /** @return HasOne<UltSurveyResponse> */
    public function surveyResponse(): HasOne
    {
        return $this->hasOne(UltSurveyResponse::class);
    }
}
