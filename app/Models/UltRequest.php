<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UltRequest extends Model
{
    use HasFactory;

    protected $table = 'ult_requests';

    protected $fillable = [
        'ticket_number',
        'layanan_type',
        'nama',
        'email',
        'no_hp',
        'profesi',
        'instansi',
        'kategori',
        'keperluan',
        'dokumen_path',
        'status',
        'catatan_petugas',
        'details',
    ];

    protected $casts = [
        'details' => 'array',
    ];

    /**
     * Generate Nomor Tiket Unik
     */
    public static function generateTicketNumber(string $type = 'online'): string
    {
        $prefix = match ($type) {
            'tatap_muka' => 'TM',
            'keliling' => 'KL',
            default => 'ON',
        };

        $datePrefix = date('ymd');

        do {
            $random = strtoupper(Str::random(4));
            $ticketNumber = "ULT-{$prefix}-{$datePrefix}-{$random}";
        } while (static::where('ticket_number', $ticketNumber)->exists());

        return $ticketNumber;
    }

    public function scopeType(Builder $query, ?string $type): Builder
    {
        if (! empty($type) && in_array($type, ['online', 'tatap_muka', 'keliling'], true)) {
            return $query->where('layanan_type', $type);
        }

        return $query;
    }

    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        if (! empty($status) && in_array($status, ['pending', 'diproses', 'selesai', 'ditolak'], true)) {
            return $query->where('status', $status);
        }

        return $query;
    }

    public function getLayananTypeLabelAttribute(): string
    {
        return match ($this->layanan_type) {
            'online' => 'Layanan Online',
            'tatap_muka' => 'Layanan Tatap Muka',
            'keliling' => 'Layanan Keliling',
            default => ucfirst($this->layanan_type),
        };
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'diproses' => [
                'label' => 'Sedang Diproses',
                'class' => 'bg-amber-50 text-amber-700 border-amber-200',
            ],
            'selesai' => [
                'label' => 'Selesai',
                'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            ],
            'ditolak' => [
                'label' => 'Ditolak',
                'class' => 'bg-rose-50 text-rose-700 border-rose-200',
            ],
            default => [
                'label' => 'Menunggu (Pending)',
                'class' => 'bg-blue-50 text-blue-700 border-blue-200',
            ],
        };
    }
}
