<?php

namespace App\Http\Resources;

use App\Models\UltRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin UltRequest
 */
class UltRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $statusLabels = [
            'pending' => 'Menunggu Verifikasi',
            'diproses' => 'Sedang Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
        ];

        return [
            'id' => $this->id,
            'ticket_number' => $this->ticket_number,
            'layanan_type' => $this->layanan_type,
            'layanan_type_label' => $this->layanan_type_label ?? ucfirst($this->layanan_type),
            'nama' => $this->nama,
            'email' => $this->email,
            'no_hp' => $this->no_hp,
            'profesi' => $this->profesi,
            'instansi' => $this->instansi,
            'kategori' => $this->kategori,
            'keperluan' => $this->keperluan,
            'dokumen_url' => $this->dokumen_path ? Storage::disk('public')->url($this->dokumen_path) : null,
            'status' => $this->status,
            'status_label' => $statusLabels[$this->status] ?? ucfirst($this->status),
            'catatan_petugas' => $this->catatan_petugas,
            'created_at' => $this->created_at?->toIso8601String(),
            'created_at_human' => $this->created_at ? $this->created_at->format('d M Y, H:i').' WITA' : null,
        ];
    }
}
