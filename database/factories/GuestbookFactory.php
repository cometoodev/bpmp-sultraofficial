<?php

namespace Database\Factories;

use App\Models\Guestbook;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Guestbook>
 */
class GuestbookFactory extends Factory
{
    protected $model = Guestbook::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'jenis_kelamin' => fake()->randomElement(['L', 'P']),
            'usia' => fake()->numberBetween(20, 60),
            'telepon' => fake()->phoneNumber(),
            'pendidikan' => fake()->randomElement([
                'SD / Sederajat',
                'SMP / Sederajat',
                'SMA / SMK / Sederajat',
                'Diploma (D1 - D3)',
                'Sarjana (S1 / D4)',
                'Magister (S2)',
                'Doktoral (S3)',
            ]),
            'pekerjaan' => fake()->randomElement([
                'Guru / Pendidik',
                'Kepala Sekolah',
                'Pengawas Sekolah',
                'Aparatur Sipil Negara (ASN)',
                'Masyarakat Umum',
            ]),
            'status_kepegawaian' => fake()->randomElement([
                'PNS',
                'PPPK',
                'Non-ASN / Honorer',
                'Pegawai Swasta / Yayasan',
                'Masyarakat Umum',
            ]),
            'asal_instansi' => fake()->company(),
            'asal_kabupaten' => fake()->randomElement([
                'Kota Kendari',
                'Kota Baubau',
                'Kab. Konawe',
                'Kab. Kolaka',
                'Kab. Muna',
            ]),
            'jenis_layanan' => fake()->randomElement([
                'Konsultasi & Advokasi Program Prioritas Kemendikdasmen',
                'Layanan Data Pokok Pendidikan (Dapodik) & PDM',
                'Penjaminan Mutu & Rekomendasi Rapor Pendidikan',
                'Informasi Publik & Penanganan Pengaduan Layanan',
            ]),
            'import_batch_id' => null,
        ];
    }
}
