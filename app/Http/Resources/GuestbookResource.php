<?php

namespace App\Http\Resources;

use App\Models\Guestbook;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Guestbook
 */
class GuestbookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'jenis_kelamin' => $this->jenis_kelamin,
            'jenis_kelamin_label' => $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
            'usia' => (int) $this->usia,
            'telepon' => $this->telepon,
            'pendidikan' => $this->pendidikan,
            'pekerjaan' => $this->pekerjaan,
            'status_kepegawaian' => $this->status_kepegawaian,
            'asal_instansi' => $this->asal_instansi,
            'asal_kabupaten' => $this->asal_kabupaten,
            'jenis_layanan' => $this->jenis_layanan,
            'created_at' => $this->created_at?->toIso8601String(),
            'created_at_human' => $this->created_at ? $this->created_at->format('d M Y, H:i').' WITA' : null,
            'survey_completed' => $this->whenLoaded('ultSurveyResponse', fn () => $this->ultSurveyResponse !== null, false),
        ];
    }
}
