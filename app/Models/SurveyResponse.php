<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_id',
        'respondent_name',
        'respondent_age',
        'respondent_job',
        'u1',
        'u2',
        'u3',
        'u4',
        'u5',
        'u6',
        'u7',
        'u8',
        'u9',
    ];

    protected $casts = [
        'respondent_age' => 'integer',
        'u1' => 'integer',
        'u2' => 'integer',
        'u3' => 'integer',
        'u4' => 'integer',
        'u5' => 'integer',
        'u6' => 'integer',
        'u7' => 'integer',
        'u8' => 'integer',
        'u9' => 'integer',
    ];

    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }
}
