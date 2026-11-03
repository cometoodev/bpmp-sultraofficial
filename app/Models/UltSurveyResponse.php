<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UltSurveyResponse extends Model
{
    protected $table = 'ult_survey_responses';

    protected $fillable = [
        'guestbook_id',
        'q1',
        'q2',
        'q3',
        'q4',
        'q5',
        'q6',
        'q7',
        'q8',
        'q9',
        'saran',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'q1' => 'integer',
        'q2' => 'integer',
        'q3' => 'integer',
        'q4' => 'integer',
        'q5' => 'integer',
        'q6' => 'integer',
        'q7' => 'integer',
        'q8' => 'integer',
        'q9' => 'integer',
    ];

    /** @return BelongsTo<Guestbook, UltSurveyResponse> */
    public function guestbook(): BelongsTo
    {
        return $this->belongsTo(Guestbook::class);
    }
}
