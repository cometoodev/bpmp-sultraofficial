<?php

namespace Database\Factories;

use App\Models\UltRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UltRequest>
 */
class UltRequestFactory extends Factory
{
    protected $model = UltRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['online', 'tatap_muka', 'keliling']);

        return [
            'ticket_number' => UltRequest::generateTicketNumber($type),
            'layanan_type' => $type,
            'nama' => fake()->name(),
            'email' => fake()->safeEmail(),
            'no_hp' => fake()->phoneNumber(),
            'profesi' => fake()->jobTitle(),
            'instansi' => fake()->company(),
            'kategori' => fake()->randomElement([
                'Konsultasi Kurikulum Merdeka & Pembelajaran',
                'Pengelolaan & Pemutakhiran Data Pokok Pendidikan (Dapodik)',
                'Bantuan Operasional Sekolah (BOS) & BOSP',
            ]),
            'keperluan' => fake()->paragraph(),
            'dokumen_path' => null,
            'status' => 'pending',
            'catatan_petugas' => null,
            'details' => ['source' => 'factory'],
        ];
    }
}
