<?php

namespace Database\Seeders;

use App\Models\Award;
use Illuminate\Database\Seeder;

class AwardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $awards = [
            [
                'title' => 'Maklumat Pelayanan BPMP Sulawesi Tenggara',
                'badge' => 'Maklumat Resmi',
                'description' => 'Dengan ini, kami menyatakan sanggup menyelenggarakan pelayanan sesuai standar pelayanan yang telah ditetapkan dan apabila tidak menepati janji ini, kami siap menerima sanksi sesuai peraturan perundang-undangan yang berlaku.',
                'image' => null,
                'order' => 1,
            ],
            [
                'title' => 'Zona Integritas Menuju Wilayah Birokrasi Bersih dan Melayani (WBBM)',
                'badge' => 'Penghargaan Kemendikdasmen',
                'description' => 'Piagam Penghargaan Zona Integritas Menuju Wilayah Birokrasi Bersih dan Melayani (WBBM) Tahun 2025 di lingkungan BPMP Sulawesi Tenggara.',
                'image' => null,
                'order' => 2,
            ],
            [
                'title' => 'Penghargaan Transaksi KKP Terbaik',
                'badge' => 'Penghargaan Kemenkeu',
                'description' => 'Piagam Penghargaan dari Kementerian Keuangan RI Direktorat Jenderal Perbendaharaan (DJPb) atas kinerja pengelolaan keuangan dan transaksi Kartu Kredit Pemerintah (KKP).',
                'image' => null,
                'order' => 3,
            ],
            [
                'title' => 'Peringkat I Realisasi PNBP BMN',
                'badge' => 'Penghargaan DJKN',
                'description' => 'Piagam Penghargaan dari Kementerian Keuangan RI Direktorat Jenderal Kekayaan Negara (DJKN) atas pencapaian Peringkat I Realisasi PNBP Pengelolaan BMN.',
                'image' => null,
                'order' => 4,
            ],
            [
                'title' => 'Keterbukaan Informasi Publik (KIP) Informatif',
                'badge' => 'Keterbukaan Informasi',
                'description' => 'Penghargaan Komisi Informasi atas dedikasi dan konsistensi penyediaan informasi publik yang transparan, akuntabel, dan ramah pengguna di lingkungan BPMP Sulawesi Tenggara.',
                'image' => null,
                'order' => 5,
            ],
        ];

        foreach ($awards as $item) {
            Award::updateOrCreate(
                ['title' => $item['title']],
                $item
            );
        }
    }
}
