<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan menu sebelumnya
        Menu::truncate();

        $menus = [
            [
                'title' => 'Profil',
                'url' => '#',
                'order' => 1,
                'status' => true,
                'target' => '_self',
                'children' => [
                    ['title' => 'Profil Lembaga', 'url' => '/profil-lembaga', 'order' => 1, 'target' => '_self'],
                    ['title' => 'Struktur Organisasi', 'url' => '/struktur-organisasi', 'order' => 2, 'target' => '_self'],
                    ['title' => 'Profil Pegawai', 'url' => '/profil-pegawai', 'order' => 3, 'target' => '_self'],
                    ['title' => 'Visi Misi', 'url' => '/visi-misi', 'order' => 4, 'target' => '_self'],
                ],
            ],
            [
                'title' => 'Program',
                'url' => '#',
                'order' => 2,
                'status' => true,
                'target' => '_self',
                'children' => [
                    ['title' => 'Program Prioritas', 'url' => '/program-prioritas', 'order' => 1, 'target' => '_self'],
                    ['title' => 'Rapor Pendidikan', 'url' => '/rapor-pendidikan', 'order' => 2, 'target' => '_self'],
                    ['title' => 'PBD (Perencanaan Berbasis Data)', 'url' => '/pbd-perencanaan-berbasis-data', 'order' => 3, 'target' => '_self'],
                ],
            ],
            [
                'title' => 'ULT',
                'url' => '#',
                'order' => 3,
                'status' => true,
                'target' => '_self',
                'children' => [
                    ['title' => 'Unit Layanan Terpadu', 'url' => '/ult-unit-layanan-terpadu', 'order' => 1, 'target' => '_self'],
                    ['title' => 'Hasil SKM', 'url' => '/hasil-skm', 'order' => 2, 'target' => '_self'],
                ],
            ],
            [
                'title' => 'Publikasi',
                'url' => '#',
                'order' => 4,
                'status' => true,
                'target' => '_self',
                'children' => [
                    ['title' => 'SINONGGI', 'url' => '/sinonggi', 'order' => 1, 'target' => '_self'],
                    ['title' => 'Profil Mutu Pendidikan', 'url' => '/profil-mutu-pendidikan', 'order' => 2, 'target' => '_self'],
                    ['title' => 'Regulasi dan Peraturan', 'url' => '/regulasi-dan-peraturan', 'order' => 3, 'target' => '_self'],
                    ['title' => 'Kisah Inspiratif', 'url' => '/kisah-inspiratif', 'order' => 4, 'target' => '_self'],
                    ['title' => 'JURNAL', 'url' => '/jurnal', 'order' => 5, 'target' => '_self'],
                    ['title' => 'Majalah', 'url' => '/majalah', 'order' => 6, 'target' => '_self'],
                    ['title' => 'Artikel', 'url' => '/berita?kategori=artikel', 'order' => 7, 'target' => '_self'],
                    ['title' => 'Berita', 'url' => '/berita', 'order' => 8, 'target' => '_self'],
                    ['title' => 'Goes to School', 'url' => '/goes-to-school', 'order' => 9, 'target' => '_self'],
                ],
            ],
            [
                'title' => 'SAKIP',
                'url' => '#',
                'order' => 5,
                'status' => true,
                'target' => '_self',
                'children' => [
                    ['title' => 'RENSTRA', 'url' => '/renstra', 'order' => 1, 'target' => '_self'],
                    ['title' => 'PERJANJIAN KINERJA', 'url' => '/perjanjian-kinerja', 'order' => 2, 'target' => '_self'],
                    ['title' => 'LAKIN', 'url' => '/lakin', 'order' => 3, 'target' => '_self'],
                    ['title' => 'LHE', 'url' => '/lhe', 'order' => 4, 'target' => '_self'],
                    ['title' => 'LK', 'url' => '/lk', 'order' => 5, 'target' => '_self'],
                    ['title' => 'DIPA 2026', 'url' => '/dipa-2026', 'order' => 6, 'target' => '_self'],
                ],
            ],
            [
                'title' => 'Link Terkait',
                'url' => '#',
                'order' => 6,
                'status' => true,
                'target' => '_self',
                'children' => [
                    ['title' => 'e-SKP', 'url' => 'https://kinerja.bkn.go.id/', 'order' => 1, 'target' => '_blank'],
                    ['title' => 'e-Kehadiran', 'url' => '/e-kehadiran', 'order' => 2, 'target' => '_self'],
                    ['title' => 'Portal Kemendikdasmen', 'url' => 'https://kemdikbud.go.id/', 'order' => 3, 'target' => '_blank'],
                    ['title' => 'Data Profil Sekolah', 'url' => 'https://dapo.kemdikbud.go.id/', 'order' => 4, 'target' => '_blank'],
                    ['title' => 'Raport Pendidikan', 'url' => 'https://raporpendidikan.kemdikbud.go.id/', 'order' => 5, 'target' => '_blank'],
                    ['title' => 'PMP', 'url' => '/pmp', 'order' => 6, 'target' => '_self'],
                    ['title' => 'DAPODIK', 'url' => 'https://dapo.kemdikbud.go.id/', 'order' => 7, 'target' => '_blank'],
                    ['title' => 'BOS', 'url' => 'https://bos.kemdikbud.go.id/', 'order' => 8, 'target' => '_blank'],
                    ['title' => 'Rumah Pendidikan', 'url' => '/rumah-pendidikan', 'order' => 9, 'target' => '_self'],
                    ['title' => 'SIBI', 'url' => 'https://buku.kemdikbud.go.id/', 'order' => 10, 'target' => '_blank'],
                    ['title' => 'Data Referensi', 'url' => 'https://referensi.data.kemdikbud.go.id/', 'order' => 11, 'target' => '_blank'],
                    ['title' => 'PUSPEKA', 'url' => 'https://cerdasberkarakter.kemdikbud.go.id/', 'order' => 12, 'target' => '_blank'],
                ],
            ],
            [
                'title' => 'PPID',
                'url' => 'https://ppid-bpmpsultra.page.gd/',
                'order' => 7,
                'status' => true,
                'target' => '_blank',
                'children' => [],
            ],
            [
                'title' => 'ZI WBK',
                'url' => '#',
                'order' => 8,
                'status' => true,
                'target' => '_self',
                'children' => [
                    ['title' => 'Standar Pelayanan', 'url' => '/standar-pelayanan', 'order' => 1, 'target' => '_self'],
                    ['title' => 'Maklumat Pelayanan', 'url' => '/maklumat-pelayanan', 'order' => 2, 'target' => '_self'],
                    ['title' => 'Manajemen Perubahan', 'url' => '/manajemen-perubahan', 'order' => 3, 'target' => '_self'],
                    ['title' => 'Penataan Tata Laksana', 'url' => '/penataan-tata-laksana', 'order' => 4, 'target' => '_self'],
                    ['title' => 'Manajemen SDM', 'url' => '/manajemen-sdm', 'order' => 5, 'target' => '_self'],
                    ['title' => 'Penguatan Akuntabilitas', 'url' => '/penguatan-akuntabilitas', 'order' => 6, 'target' => '_self'],
                    ['title' => 'Penguatan Pengawasan', 'url' => '/penguatan-pengawasan', 'order' => 7, 'target' => '_self'],
                    ['title' => 'Peningkatan Kualitas Layanan', 'url' => '/peningkatan-kualitas-layanan', 'order' => 8, 'target' => '_self'],
                ],
            ],
            [
                'title' => 'Pengaduan',
                'url' => '#',
                'order' => 9,
                'status' => true,
                'target' => '_self',
                'children' => [
                    ['title' => 'SPMB', 'url' => '/spmb', 'order' => 1, 'target' => '_self'],
                    ['title' => 'SP4N Lapor', 'url' => 'https://www.lapor.go.id/', 'order' => 2, 'target' => '_blank'],
                    ['title' => 'Lapor Gratifikasi', 'url' => 'https://gol.kpk.go.id/', 'order' => 3, 'target' => '_blank'],
                    ['title' => 'Whistle Blowing System (WBS)', 'url' => 'https://wbs.kemdikbud.go.id/', 'order' => 4, 'target' => '_blank'],
                ],
            ],
            [
                'title' => 'Hubungi Kami',
                'url' => '/kontak',
                'order' => 10,
                'status' => true,
                'target' => '_self',
                'children' => [],
            ],
        ];

        foreach ($menus as $menuData) {
            $children = $menuData['children'] ?? [];
            unset($menuData['children']);

            $parent = Menu::create($menuData);

            foreach ($children as $childData) {
                $childData['parent_id'] = $parent->id;
                $childData['status'] = true;
                Menu::create($childData);
            }
        }
    }
}
