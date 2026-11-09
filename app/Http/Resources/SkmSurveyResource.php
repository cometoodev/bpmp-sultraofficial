<?php

namespace App\Http\Resources;

use App\Models\UltSurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin UltSurveyResponse
 */
class SkmSurveyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $ratings = [$this->q1, $this->q2, $this->q3, $this->q4, $this->q5, $this->q6, $this->q7, $this->q8, $this->q9];
        $validRatings = array_filter($ratings, fn ($val) => ! is_null($val));
        $avgScore = count($validRatings) > 0 ? round(array_sum($validRatings) / count($validRatings), 2) : 0;

        return [
            'id' => $this->id,
            'guestbook_id' => $this->guestbook_id,
            'guestbook_nama' => $this->relationLoaded('guestbook') ? $this->guestbook?->nama : null,
            'answers' => [
                'q1' => $this->q1,
                'q2' => $this->q2,
                'q3' => $this->q3,
                'q4' => $this->q4,
                'q5' => $this->q5,
                'q6' => $this->q6,
                'q7' => $this->q7,
                'q8' => $this->q8,
                'q9' => $this->q9,
            ],
            'average_score' => $avgScore,
            'ikm_conversion' => round($avgScore * 25, 2), // Konversi skala 100 IKM Permenpan
            'saran' => $this->saran,
            'created_at' => $this->created_at?->toIso8601String(),
            'created_at_human' => $this->created_at ? $this->created_at->format('d M Y, H:i').' WITA' : null,
        ];
    }
}
