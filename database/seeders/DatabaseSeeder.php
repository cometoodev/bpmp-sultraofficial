<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Page;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@bpmp.kemdikbud.go.id'],
            [
                'name' => 'Administrator BPMP',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // 2. Settings
        $settings = [
            'site_name' => 'BPMP Provinsi Sulawesi Tenggara',
            'site_tagline' => 'Balai Penjaminan Mutu Pendidikan Provinsi Sulawesi Tenggara',
            'site_email' => 'bpmp.sultra@kemdikbud.go.id',
            'site_phone' => '(0401) 3195267',
            'site_address' => 'Jl. DI Panjaitan No. 123, Kendari, Sulawesi Tenggara',
            'facebook_url' => 'https://facebook.com/bpmpsultra',
            'instagram_url' => 'https://instagram.com/bpmpsultra',
            'youtube_url' => 'https://youtube.com/@bpmpsultra',
            'footer_text' => '© 2026 BPMP Provinsi Sulawesi Tenggara - Kementerian Pendidikan Dasar dan Menengah.',
            'meta_title' => 'BPMP Provinsi Sulawesi Tenggara - Portal Resmi',
            'meta_description' => 'Website Resmi Balai Penjaminan Mutu Pendidikan (BPMP) Provinsi Sulawesi Tenggara, Kementerian Pendidikan Dasar dan Menengah.',
            'meta_keywords' => 'BPMP, Sulawesi Tenggara, Kemendikdasmen, Penjaminan Mutu Pendidikan, Kendari',
        ];

        foreach ($settings as $key => $val) {
            Setting::set($key, $val, 'general');
        }

        // 3. Categories
        $categories = [
            ['name' => 'Berita Terkini', 'slug' => 'berita-terkini', 'description' => 'Kabar dan warta terbaru BPMP Sultra'],
            ['name' => 'Kegiatan', 'slug' => 'kegiatan', 'description' => 'Dokumentasi kegiatan dan workshop'],
            ['name' => 'Informasi', 'slug' => 'informasi', 'description' => 'Informasi kedinasan dan publik'],
            ['name' => 'Pendidikan', 'slug' => 'pendidikan', 'description' => 'Artikel dan opini dunia pendidikan'],
            ['name' => 'Prestasi', 'slug' => 'prestasi', 'description' => 'Capaian dan penghargaan'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 4. Sample Pages
        $pages = [
            [
                'title' => 'Profil Lembaga',
                'slug' => 'profil-lembaga',
                'content' => '<h2>Profil BPMP Provinsi Sulawesi Tenggara</h2><p>Balai Penjaminan Mutu Pendidikan (BPMP) Provinsi Sulawesi Tenggara adalah unit pelaksana teknis Kementerian Pendidikan Dasar dan Menengah di bidang penjaminan mutu pendidikan yang berada di bawah dan bertanggung jawab kepada Direktur Jenderal Pendidikan Anak Usia Dini, Pendidikan Dasar, dan Pendidikan Menengah.</p><p>BPMP Provinsi Sulawesi Tenggara mempunyai tugas melaksanakan penjaminan dan peningkatan mutu pendidikan anak usia dini, pendidikan dasar, pendidikan menengah, dan pendidikan masyarakat di wilayah Provinsi Sulawesi Tenggara.</p>',
                'status' => 'published',
                'published_at' => now(),
                'meta_title' => 'Profil Lembaga - BPMP Sultra',
                'meta_description' => 'Profil resmi Balai Penjaminan Mutu Pendidikan Provinsi Sulawesi Tenggara.',
            ],
            [
                'title' => 'Visi & Misi',
                'slug' => 'visi-misi',
                'content' => '<h2>Visi</h2><p>Terwujudnya layanan penjaminan mutu pendidikan yang prima, akuntabel, dan berkelanjutan untuk mewujudkan insan Sulawesi Tenggara yang cerdas, berkarakter, dan berdaya saing global.</p><h2>Misi</h2><ul><li>Melaksanakan supervisi dan fasilitasi penjaminan mutu pendidikan di seluruh kabupaten/kota se-Sulawesi Tenggara.</li><li>Meningkatkan kapasitas pendidik dan tenaga kependidikan secara terpadu.</li><li>Mengembangkan kemitraan strategis dengan pemerintah daerah dan pemangku kepentingan pendidikan.</li></ul>',
                'status' => 'published',
                'published_at' => now(),
                'meta_title' => 'Visi & Misi - BPMP Sultra',
                'meta_description' => 'Visi dan Misi Balai Penjaminan Mutu Pendidikan Provinsi Sulawesi Tenggara.',
            ],
            [
                'title' => 'Struktur Organisasi',
                'slug' => 'struktur-organisasi',
                'content' => '<h2>Struktur Organisasi BPMP Provinsi Sulawesi Tenggara</h2><p>Susunan organisasi BPMP Provinsi Sulawesi Tenggara terdiri atas:</p><ul><li>Kepala Balai</li><li>Subbagian Umum</li><li>Kelompok Jabatan Fungsional (Widyaprada, Pengembang Teknologi Pembelajaran, Arsiparis, Pranata Komputer, Analis Kebijakan)</li></ul>',
                'status' => 'published',
                'published_at' => now(),
                'meta_title' => 'Struktur Organisasi - BPMP Sultra',
                'meta_description' => 'Bagan dan struktur organisasi BPMP Provinsi Sulawesi Tenggara.',
            ],
        ];

        foreach ($pages as $p) {
            Page::firstOrCreate(['slug' => $p['slug']], $p);
        }

        // 5. Sample Banners
        $banners = [
            [
                'title' => 'Balai Penjaminan Mutu Pendidikan Provinsi Sulawesi Tenggara',
                'description' => 'Mewujudkan Penjaminan Mutu Pendidikan yang Berkualitas, Merata, dan Berkeadilan bagi Seluruh Satuan Pendidikan di Sulawesi Tenggara.',
                'image' => '/fotoheader/slide1.png',
                'button_text' => 'Pelajari Selengkapnya',
                'button_url' => '/profil-lembaga',
                'order' => 1,
                'status' => true,
            ],
            [
                'title' => 'Sosialisasi Rapor Pendidikan & PBD 2026',
                'description' => 'Mendorong Perencanaan Berbasis Data (PBD) untuk Satuan Pendidikan dan Pemerintah Daerah se-Sulawesi Tenggara.',
                'image' => '/fotoheader/slide2.png',
                'button_text' => 'Lihat Informasi',
                'button_url' => '/berita',
                'order' => 2,
                'status' => true,
            ],
            [
                'title' => 'Layanan Terpadu & Akuntabel ZI-WBK',
                'description' => 'BPMP Provinsi Sulawesi Tenggara berkomitmen mewujudkan Zona Integritas Wilayah Bebas dari Korupsi (ZI-WBK).',
                'image' => '/fotoheader/slide3.png',
                'button_text' => 'Unit Layanan Terpadu',
                'button_url' => '/#layanan',
                'order' => 3,
                'status' => true,
            ],
        ];

        foreach ($banners as $b) {
            Banner::firstOrCreate(['title' => $b['title']], $b);
        }

        // 6. Sample Announcements
        Announcement::firstOrCreate(
            ['title' => 'Jadwal Bimtek Pendampingan PBD Tahun 2026'],
            [
                'content' => 'Diberitahukan kepada seluruh Kepala Satuan Pendidikan dan Dinas Pendidikan Kab/Kota se-Sulawesi Tenggara bahwa Bimbingan Teknis Perencanaan Berbasis Data akan diselenggarakan mulai tanggal 15 Oktober 2026.',
                'status' => 'published',
                'published_at' => now(),
            ]
        );

        // 7. Menus
        $this->call(MenuSeeder::class);
    }
}
