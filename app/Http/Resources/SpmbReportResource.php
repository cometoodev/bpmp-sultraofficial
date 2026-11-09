<?php

namespace App\Http\Resources;

use App\Models\SpmbReport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin SpmbReport
 */
class SpmbReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $statusLabels = [
            'pending' => 'Menunggu Tindak Lanjut',
            'processed' => 'Sedang Diproses',
            'completed' => 'Selesai Ditindaklanjuti',
        ];

        return [
            'id' => $this->id,
            'category' => $this->category,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'message' => $this->message,
            'evidence_url' => $this->evidence_file ? Storage::disk('public')->url($this->evidence_file) : null,
            'status' => $this->status,
            'status_label' => $statusLabels[$this->status] ?? ucfirst($this->status),
            'admin_note' => $this->admin_note,
            'created_at' => $this->created_at?->toIso8601String(),
            'created_at_human' => $this->created_at ? $this->created_at->format('d M Y, H:i').' WITA' : null,
        ];
    }
}
