<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan menu sebelumnya
        Menu::whereNull('parent_id')->delete();

        $menus = [
            'Profil' => [
                'Profil Lembaga',
                'Struktur Organisasi',
                'Profil Pegawai',
                'Visi Misi'
            ],
            'Program' => [
                'Program Prioritas',
                'Rapor Pendidikan',
                'PBD (Perencanaan Berbasis Data)'
            ],
            'ULT (Unit Layanan Terpadu)' => [],
            'Hasil SKM (Survei Kepuasan Masyarakat)' => [],
            'Publikasi' => [
                'SINONGGI',
                'Profil Mutu Pendidikan',
                'Regulasi dan Peraturan',
                'Kisah Inspiratif',
                'JURNAL',
                'Majalah',
                'Artikel',
                'Berita',
                'Goes to School'
            ],
            'SAKIP' => [
                'RENSTRA',
                'PERJANJIAN KINERJA',
                'LAKIN',
                'LHE',
                'LK',
                'DIPA 2026'
            ],
            'Link Terkait' => [],
            'Layanan Kepegawaian' => [
                'e-SKP',
                'e-Kehadiran',
                'Portal Kemendikdasmen'
            ],
            'Layanan Data dan Informasi' => [
                'Data Profil Sekolah',
                'Raport Pendidikan',
                'PMP, DAPODIK, BOS, Rumah Pendidikan, SIBI, Data Referensi, PUSPEKA'
            ],
            'PPID' => [],
            'ZI WBK (Zona Integritas Wilayah Bebas Korupsi)' => [
                'Standar Pelayanan',
                'Maklumat Pelayanan',
                'Area Pemenuhan (Manajemen Perubahan, Penataan Tata Laksana, Manajemen SDM, dll.)'
            ],
            'Pengaduan' => [
                'SPMB',
                'SP4N Lapor',
                'Lapor Gratifikasi',
                'Whistle Blowing System'
            ],
            'Hubungi Kami' => [],
        ];

        $order = 1;

        foreach ($menus as $parentTitle => $children) {
            // Jika punya anak, url `#`, jika tidak, url slug.
            $parentUrl = empty($children) ? '/' . Str::slug($parentTitle) : '#';
            
            $parent = Menu::create([
                'title' => $parentTitle,
                'url' => $parentUrl,
                'parent_id' => null,
                'order' => $order++,
                'status' => true,
                'target' => '_self',
            ]);

            $childOrder = 1;
            foreach ($children as $childTitle) {
                Menu::create([
                    'title' => $childTitle,
                    'url' => '/' . Str::slug($childTitle),
                    'parent_id' => $parent->id,
                    'order' => $childOrder++,
                    'status' => true,
                    'target' => '_self',
                ]);
            }
        }
    }
}
