<?php

namespace Database\Seeders;

use App\Models\PageTemplate;
use Illuminate\Database\Seeder;

class PageTemplateSeeder extends Seeder
{
    public function run(): void
    {
        if (! PageTemplate::where('name', 'Halaman Unit Layanan Terpadu (ULT)')->exists()) {
            PageTemplate::create([
                'name' => 'Halaman Unit Layanan Terpadu (ULT)',
                'description' => 'Sistem tab interaktif untuk 3 jenis layanan (Online, Tatap Muka, Keliling) dan susunan Tim ULT.',
                'content' => <<<'EOD'
<!-- Wrapper Utama ULT dengan Alpine.js State -->
<div x-data="{ activeTab: 'online' }" class="w-full max-w-6xl mx-auto space-y-8 mt-8">
    
    <!-- NAVIGASI TAB UTAMA -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <!-- Tab 1: Online -->
        <button @click="activeTab = 'online'" :class="activeTab === 'online' ? 'border-blue-500 bg-blue-50 shadow-md ring-1 ring-blue-500' : 'border-slate-200 bg-white hover:bg-slate-50'" class="flex flex-col items-center justify-center p-6 rounded-3xl border transition-all duration-300 group">
            <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="font-bold text-slate-800 text-sm">Layanan Online</h3>
        </button>

        <!-- Tab 2: Tatap Muka -->
        <button @click="activeTab = 'tatap-muka'" :class="activeTab === 'tatap-muka' ? 'border-indigo-500 bg-indigo-50 shadow-md ring-1 ring-indigo-500' : 'border-slate-200 bg-white hover:bg-slate-50'" class="flex flex-col items-center justify-center p-6 rounded-3xl border transition-all duration-300 group">
            <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <h3 class="font-bold text-slate-800 text-sm">Layanan Tatap Muka</h3>
        </button>

        <!-- Tab 3: Keliling -->
        <button @click="activeTab = 'keliling'" :class="activeTab === 'keliling' ? 'border-teal-500 bg-teal-50 shadow-md ring-1 ring-teal-500' : 'border-slate-200 bg-white hover:bg-slate-50'" class="flex flex-col items-center justify-center p-6 rounded-3xl border transition-all duration-300 group">
            <div class="w-12 h-12 rounded-full bg-teal-100 text-teal-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
            </div>
            <h3 class="font-bold text-slate-800 text-sm">Layanan Keliling</h3>
        </button>

        <!-- Tab 4: Tim ULT -->
        <button @click="activeTab = 'tim-ult'" :class="activeTab === 'tim-ult' ? 'border-purple-500 bg-purple-50 shadow-md ring-1 ring-purple-500' : 'border-slate-200 bg-white hover:bg-slate-50'" class="flex flex-col items-center justify-center p-6 rounded-3xl border transition-all duration-300 group">
            <div class="w-12 h-12 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
            <h3 class="font-bold text-slate-800 text-sm">Tim ULT</h3>
        </button>
    </div>

    <!-- AREA KONTEN TAB -->
    <div class="relative bg-white/80 backdrop-blur-xl border border-slate-100 shadow-sm rounded-[2.5rem] p-8 md:p-12 min-h-[500px]">
        
        <!-- 1. KONTEN ONLINE -->
        <div x-show="activeTab === 'online'" x-transition.opacity.duration.500ms>
            <div class="max-w-4xl mx-auto">
                <div class="mb-8 border-b border-slate-100 pb-6">
                    <h3 class="text-3xl font-extrabold text-slate-800">Permohonan Layanan Daring</h3>
                    <p class="text-slate-500 mt-2">Silakan lengkapi formulir di bawah ini dengan data yang valid.</p>
                </div>
                <!-- Native Form Online -->
                <form action="#" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Kategori *</label>
                            <select name="kategori" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all" required>
                                <option value="">-- Pilih Kategori Layanan --</option>
                                <option value="Pelayanan Permohonan Informasi">Pelayanan Permohonan Informasi</option>
                                <option value="Pelayanan Peminjaman Fasilitas">Pelayanan Peminjaman Fasilitas</option>
                                <option value="Pelayanan Data dan Informasi Mutu">Pelayanan Data dan Informasi Mutu</option>
                                <option value="Pelayanan Supervisi Mutu Pendidikan">Pelayanan Supervisi Mutu Pendidikan</option>
                                <option value="Pelayanan Kerja sama Peningkatan Mutu">Pelayanan Kerja sama Peningkatan Mutu</option>
                                <option value="Pelayanan Permohonan Narasumber">Pelayanan Permohonan Narasumber</option>
                                <option value="Pelayanan Pengaduan">Pelayanan Pengaduan</option>
                                <option value="Pelayanan Magang/Prakerin/Penelitian">Pelayanan Magang/Prakerin/Penelitian</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap *</label>
                            <input type="text" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all" placeholder="Masukkan nama..." required>
                        </div>
                    </div>
                    <button type="button" class="px-8 py-4 bg-blue-600 text-white font-bold rounded-2xl shadow-lg hover:bg-blue-700 hover:-translate-y-1 transition-all w-full md:w-auto">Kirim Permohonan Online</button>
                </form>
            </div>
        </div>

        <!-- 2. KONTEN TATAP MUKA (DENGAN LOCK SCREEN) -->
        <div x-show="activeTab === 'tatap-muka'" x-transition.opacity.duration.500ms x-data="{ isUnlocked: false, password: '', errorMsg: '' }">
            
            <!-- Lock Screen -->
            <div x-show="!isUnlocked" class="max-w-md mx-auto text-center py-10">
                <div class="w-20 h-20 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-2">Akses Terkunci</h3>
                <p class="text-slate-500 mb-8">Silakan minta kode akses kunjungan dari petugas Resepsionis ULT.</p>
                <input type="password" x-model="password" @keyup.enter="if(password === 'ULT2026') { isUnlocked = true; errorMsg = ''; } else { errorMsg = 'Kode akses tidak valid!'; }" class="w-full px-4 py-4 rounded-2xl bg-slate-50 border border-slate-200 text-center tracking-[0.5em] text-lg focus:ring-4 focus:ring-indigo-500/20 outline-none mb-3 font-bold text-slate-700" placeholder="••••••">
                <p x-show="errorMsg" x-text="errorMsg" class="text-red-500 text-sm font-semibold mb-4"></p>
                <button @click="if(password === 'ULT2026') { isUnlocked = true; errorMsg = ''; } else { errorMsg = 'Kode akses tidak valid!'; }" class="w-full py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-lg hover:bg-indigo-700 transition-colors">Buka Formulir Kunjungan</button>
            </div>

            <!-- Form Terbuka -->
            <div x-show="isUnlocked" style="display: none;" class="max-w-4xl mx-auto">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-slate-100 pb-6 gap-4">
                    <div>
                        <h3 class="text-3xl font-extrabold text-slate-800">Buku Tamu Front Office</h3>
                        <p class="text-slate-500 mt-2">Selamat datang di ruang pelayanan BPMP Sultra.</p>
                    </div>
                    <button @click="isUnlocked = false; password = '';" class="px-4 py-2 bg-rose-50 text-rose-600 font-bold rounded-xl hover:bg-rose-100 transition-colors text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg> Kunci Layar
                    </button>
                </div>
                <!-- Native Form Tatap Muka -->
                <form action="#" method="POST" class="space-y-6">
                    <!-- Isi field buku tamu -->
                    <div class="p-6 bg-slate-50 border border-slate-200 rounded-2xl text-center text-slate-500 font-semibold italic">Area Input Native Form Tatap Muka...</div>
                </form>
            </div>
        </div>

        <!-- 3. KONTEN KELILING -->
        <div x-show="activeTab === 'keliling'" x-transition.opacity.duration.500ms>
            <div class="max-w-4xl mx-auto text-center py-10">
                <h3 class="text-3xl font-extrabold text-slate-800 mb-4">Layanan Mobile Service</h3>
                <p class="text-slate-500 mb-8">Pengajuan tim layanan jemput bola ke daerah Kabupaten/Kota.</p>
                <!-- Native Form Keliling -->
                <div class="p-6 bg-slate-50 border border-slate-200 rounded-2xl text-center text-slate-500 font-semibold italic">Area Input Native Form Keliling...</div>
            </div>
        </div>

        <!-- 4. KONTEN TIM ULT -->
        <div x-show="activeTab === 'tim-ult'" x-transition.opacity.duration.500ms>
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-12">
                    <h3 class="text-3xl font-extrabold text-slate-800">Struktur Tim Pelayanan</h3>
                    <p class="text-slate-500 mt-2">Daftar petugas resmi Unit Layanan Terpadu BPMP Sultra.</p>
                </div>
                <!-- Grid Tim -->
                <div class="flex justify-center mb-8">
                    <div class="bg-blue-50 border-t-4 border-blue-600 rounded-2xl p-6 w-80 text-center shadow-sm">
                        <h4 class="text-xs font-bold text-blue-400 uppercase tracking-widest mb-2">Koordinator</h4>
                        <h3 class="text-lg font-extrabold text-blue-900">Sitti Samsuria, S.E.</h3>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 shadow-sm"><h4 class="font-bold text-slate-700 text-sm mb-3">Narasumber</h4><ul class="text-slate-600 text-sm space-y-1"><li>La Siara, S.Pd., M.Pd.</li><li>Elyati</li></ul></div>
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 shadow-sm"><h4 class="font-bold text-slate-700 text-sm mb-3">Data & Informasi</h4><ul class="text-slate-600 text-sm space-y-1"><li>Rohmad, S.E., M.Si.</li></ul></div>
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 shadow-sm"><h4 class="font-bold text-slate-700 text-sm mb-3">SarPras</h4><ul class="text-slate-600 text-sm space-y-1"><li>H. Usman N., S.Pd.</li><li>Asruddin</li><li>Novri Hardiansyah, S.IP.</li></ul></div>
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 shadow-sm"><h4 class="font-bold text-slate-700 text-sm mb-3">Magang</h4><ul class="text-slate-600 text-sm space-y-1"><li>H. Syamsul Bahri</li><li>Hariudin, S.E.</li></ul></div>
                </div>
            </div>
        </div>

    </div>
</div>
EOD,
                'sort_order' => 1,
            ]);
        }

        if (! PageTemplate::where('name', 'Hasil SKM (Halaman Utama / Grid)')->exists()) {
            PageTemplate::create([
                'name' => 'Hasil SKM (Halaman Utama / Grid)',
                'description' => 'Template beranda SKM dengan grid kartu kuartalan dan modal pop-up lightbox infografis.',
                'content' => <<<'EOD'
<!-- Wrapper Utama SKM dengan Alpine.js Lightbox State -->
<div x-data="{ showModal: false, modalImg: '', modalTitle: '' }" class="w-full max-w-7xl mx-auto">
    <div class="bg-white/95 backdrop-blur-xl rounded-[2.5rem] shadow-sm border border-slate-100 p-8 md:p-12 mb-8">
        
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-slate-800">Laporan Kepuasan Masyarakat (SKM)</h2>
            <p class="text-slate-500 mt-2">Publikasi hasil survei dan tindak lanjut performa pelayanan publik BPMP Sultra.</p>
        </div>

        <!-- Grid Kartu SKM -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- KARTU TRIWULAN I -->
            <div class="bg-slate-50 rounded-3xl border border-slate-200 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col group">
                <div class="relative h-56 overflow-hidden bg-slate-200 cursor-pointer" 
                     @click="showModal = true; modalImg = 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=1200&auto=format&fit=crop&q=80'; modalTitle = 'Infografis SKM Triwulan I'">
                    <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=600&auto=format&fit=crop&q=80" alt="Infografis TW 1" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-blue-900/0 group-hover:bg-blue-900/20 transition-colors flex items-center justify-center">
                        <div class="bg-white/90 backdrop-blur text-blue-600 px-4 py-2 rounded-full font-bold text-sm opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-4 group-hover:translate-y-0 shadow-lg">Lihat Infografis</div>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow text-center">
                    <span class="text-xs font-extrabold text-blue-500 uppercase tracking-widest mb-1">Tahun 2026</span>
                    <h3 class="text-xl font-bold text-slate-800 mb-6">Triwulan I</h3>
                    <div class="mt-auto">
                        <!-- URL ini diarahkan ke halaman detail yang dibuat terpisah -->
                        <a href="/halaman/skm-tw-1-2026" class="block w-full py-3 bg-white hover:bg-blue-600 text-blue-600 hover:text-white font-bold rounded-xl transition-colors border border-blue-100 hover:border-blue-600">Lihat Dokumen</a>
                    </div>
                </div>
            </div>

            <!-- KARTU TRIWULAN II -->
            <div class="bg-slate-50 rounded-3xl border border-slate-200 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col group">
                <div class="relative h-56 overflow-hidden bg-slate-200 cursor-pointer" @click="showModal = true; modalImg = 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1200&auto=format&fit=crop&q=80'; modalTitle = 'Infografis SKM Triwulan II'">
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&auto=format&fit=crop&q=80" alt="Infografis TW 2" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-blue-900/0 group-hover:bg-blue-900/20 transition-colors flex items-center justify-center">
                        <div class="bg-white/90 backdrop-blur text-blue-600 px-4 py-2 rounded-full font-bold text-sm opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-4 group-hover:translate-y-0 shadow-lg">Lihat Infografis</div>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow text-center">
                    <span class="text-xs font-extrabold text-blue-500 uppercase tracking-widest mb-1">Tahun 2026</span>
                    <h3 class="text-xl font-bold text-slate-800 mb-6">Triwulan II</h3>
                    <div class="mt-auto">
                        <a href="/halaman/skm-tw-2-2026" class="block w-full py-3 bg-white hover:bg-blue-600 text-blue-600 hover:text-white font-bold rounded-xl transition-colors border border-blue-100 hover:border-blue-600">Lihat Dokumen</a>
                    </div>
                </div>
            </div>

            <!-- KARTU TRIWULAN III -->
            <div class="bg-slate-50 rounded-3xl border border-slate-200 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col group">
                <div class="relative h-56 overflow-hidden bg-slate-200 cursor-pointer" @click="showModal = true; modalImg = 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=1200&auto=format&fit=crop&q=80'; modalTitle = 'Infografis SKM Triwulan III'">
                    <img src="https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=600&auto=format&fit=crop&q=80" alt="Infografis TW 3" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-blue-900/0 group-hover:bg-blue-900/20 transition-colors flex items-center justify-center">
                        <div class="bg-white/90 backdrop-blur text-blue-600 px-4 py-2 rounded-full font-bold text-sm opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-4 group-hover:translate-y-0 shadow-lg">Lihat Infografis</div>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow text-center">
                    <span class="text-xs font-extrabold text-blue-500 uppercase tracking-widest mb-1">Tahun 2026</span>
                    <h3 class="text-xl font-bold text-slate-800 mb-6">Triwulan III</h3>
                    <div class="mt-auto">
                        <a href="/halaman/skm-tw-3-2026" class="block w-full py-3 bg-white hover:bg-blue-600 text-blue-600 hover:text-white font-bold rounded-xl transition-colors border border-blue-100 hover:border-blue-600">Lihat Dokumen</a>
                    </div>
                </div>
            </div>

            <!-- KARTU TRIWULAN IV -->
            <div class="bg-slate-50 rounded-3xl border border-slate-200 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col group">
                <div class="relative h-56 overflow-hidden bg-slate-200 cursor-pointer" @click="showModal = true; modalImg = 'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=1200&auto=format&fit=crop&q=80'; modalTitle = 'Infografis SKM Triwulan IV'">
                    <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?w=600&auto=format&fit=crop&q=80" alt="Infografis TW 4" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-blue-900/0 group-hover:bg-blue-900/20 transition-colors flex items-center justify-center">
                        <div class="bg-white/90 backdrop-blur text-blue-600 px-4 py-2 rounded-full font-bold text-sm opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-4 group-hover:translate-y-0 shadow-lg">Lihat Infografis</div>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow text-center">
                    <span class="text-xs font-extrabold text-blue-500 uppercase tracking-widest mb-1">Tahun 2026</span>
                    <h3 class="text-xl font-bold text-slate-800 mb-6">Triwulan IV</h3>
                    <div class="mt-auto">
                        <a href="/halaman/skm-tw-4-2026" class="block w-full py-3 bg-white hover:bg-blue-600 text-blue-600 hover:text-white font-bold rounded-xl transition-colors border border-blue-100 hover:border-blue-600">Lihat Dokumen</a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <!-- MODAL POP-UP (LIGHTBOX) -->
    <div x-show="showModal" class="fixed inset-0 z-[999] flex items-center justify-center p-4 sm:p-6" style="display: none;" @keydown.escape.window="showModal = false">
        <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm" @click="showModal = false"></div>
        <div x-show="showModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-8"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-8"
             class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden z-10">
            <div class="flex justify-between items-center p-4 border-b border-slate-100 bg-slate-50/80 backdrop-blur">
                <h4 class="font-bold text-slate-800" x-text="modalTitle"></h4>
                <button type="button" @click="showModal = false" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-200 text-slate-600 hover:bg-red-100 hover:text-red-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="overflow-y-auto p-4 bg-slate-100 flex-grow flex items-center justify-center">
                <img :src="modalImg" class="w-full h-auto max-h-[75vh] object-contain rounded-xl shadow-sm">
            </div>
        </div>
    </div>
</div>
EOD,
                'sort_order' => 2,
            ]);
        }

        if (! PageTemplate::where('name', 'Detail SKM & Tindak Lanjut (Dokumen Tab)')->exists()) {
            PageTemplate::create([
                'name' => 'Detail SKM & Tindak Lanjut (Dokumen Tab)',
                'description' => 'Template halaman detail dokumen dengan tab Laporan SKM dan Tindak Lanjut (iframe PDF) terpadu.',
                'content' => <<<'EOD'
<!-- Wrapper Halaman Detail SKM Terpadu (Laporan & Tindak Lanjut) -->
<div x-data="{ activeDocTab: 'skm' }" class="w-full max-w-6xl mx-auto mb-10">
    <div class="bg-white/95 backdrop-blur-xl rounded-[2rem] border border-slate-100 shadow-sm p-6 md:p-8">
        
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-slate-800 mb-2">Laporan SKM Triwulan I</h2>
            <p class="text-slate-500">Periode Januari - Maret 2026</p>
        </div>

        <!-- Switcher Tab -->
        <div class="flex justify-center mb-8">
            <div class="inline-flex bg-slate-100 p-1.5 rounded-2xl">
                <button type="button" @click="activeDocTab = 'skm'" :class="activeDocTab === 'skm' ? 'bg-white text-blue-600 shadow-sm font-bold' : 'text-slate-500 hover:text-slate-700 font-medium'" class="px-6 py-2.5 rounded-xl text-sm transition-all">
                    Dokumen Laporan SKM
                </button>
                <button type="button" @click="activeDocTab = 'tindak-lanjut'" :class="activeDocTab === 'tindak-lanjut' ? 'bg-white text-blue-600 shadow-sm font-bold' : 'text-slate-500 hover:text-slate-700 font-medium'" class="px-6 py-2.5 rounded-xl text-sm transition-all">
                    Tindak Lanjut Hasil SKM
                </button>
            </div>
        </div>

        <!-- Iframe Laporan SKM -->
        <div x-show="activeDocTab === 'skm'" x-transition.opacity class="w-full bg-slate-100 rounded-2xl overflow-hidden border border-slate-200">
            <iframe src="https://drive.google.com/file/d/YOUR_FILE_ID_HERE/preview" class="w-full h-[600px] md:h-[800px] border-0" allow="autoplay"></iframe>
        </div>

        <!-- Iframe Tindak Lanjut -->
        <div x-show="activeDocTab === 'tindak-lanjut'" x-transition.opacity class="w-full bg-slate-100 rounded-2xl overflow-hidden border border-slate-200" style="display: none;">
            <iframe src="https://drive.google.com/file/d/YOUR_FILE_ID_HERE/preview" class="w-full h-[600px] md:h-[800px] border-0" allow="autoplay"></iframe>
        </div>
    </div>
</div>
EOD,
                'sort_order' => 3,
            ]);
        }

        if (! PageTemplate::where('name', 'Profil Mutu Pendidikan')->exists()) {
            PageTemplate::create([
                'name' => 'Profil Mutu Pendidikan',
                'description' => 'Layout elegan dengan sambutan pimpinan dan grid interaktif untuk profil Kabupaten/Kota se-Sultra.',
                'content' => <<<'EOD'
<!-- Profil Mutu Pendidikan (Split Layout, 1 Giant Card, & Grid 5 Kolom) -->
<div x-data="{ 
        showModal: false, 
        pdfTitle: '', 
        pdfUrl: '', 
        fileInfo: '',
        openModal(title, url, info) {
            this.pdfTitle = title;
            this.pdfUrl = url;
            this.fileInfo = info;
            this.showModal = true;
        },
        copyLink() {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(this.pdfUrl).then(() => {
                    alert('Tautan berhasil disalin: ' + this.pdfUrl);
                }).catch(() => {
                    prompt('Salin tautan dokumen PDF:', this.pdfUrl);
                });
            } else {
                prompt('Salin tautan dokumen PDF:', this.pdfUrl);
            }
        }
    }" 
    class="w-full space-y-12"> <!-- Hapus batasan lebar di sini, ikuti Master Template -->
        
        <!-- 1. KATA SAMBUTAN PIMPINAN (Split Layout) -->
        <div class="flex flex-col lg:flex-row items-center gap-10 lg:gap-16">
            <!-- Foto Pimpinan -->
            <div class="w-full lg:w-1/3 shrink-0">
                <div class="relative rounded-[2rem] overflow-hidden shadow-md group">
                    <!-- Silakan ganti link gambar pimpinan -->
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=800&fit=crop" alt="Sambutan Pimpinan" class="w-full h-auto aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-blue-900/90 via-blue-900/10 to-transparent flex items-end p-6">
                        <div>
                            <h4 class="text-white font-bold text-xl md:text-2xl">Dr. Hendra Wijaya, M.Pd.</h4>
                            <p class="text-blue-200 text-sm md:text-base font-medium mt-1">Kepala BPMP Provinsi Sulawesi Tenggara</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Teks Sambutan -->
            <div class="w-full lg:w-2/3 space-y-6">
                <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-blue-50 text-blue-600 font-bold text-sm uppercase tracking-widest border border-blue-100">Kata Sambutan</div>
                <h2 class="text-3xl lg:text-5xl font-extrabold text-slate-800 leading-tight">Mewujudkan Layanan Pendidikan yang Adaptif &amp; Inklusif</h2>
                <div class="prose prose-slate prose-lg md:prose-xl max-w-none text-slate-600 leading-relaxed">
                    <p>Puji syukur ke hadirat Allah SWT, Buku Profil Mutu Pendidikan Provinsi Sulawesi Tenggara Tahun 2026 ini dapat terselesaikan. Rapor Pendidikan 2026 yang dirilis oleh Kemendikbudristek menjadi acuan utama kami dalam melaksanakan fungsi pemetaan mutu pendidikan.</p>
                    <p>Besar harapan kami, profil ini dapat memenuhi kebutuhan Pemerintah Daerah dalam membuat kebijakan pendidikan yang lebih terarah guna mewujudkan layanan pendidikan berkualitas yang kita cita-citakan.</p>
                </div>
            </div>
        </div>

        <!-- GARIS PEMISAH HALUS -->
        <div class="w-full h-px bg-slate-200 my-16"></div>

        <!-- 2. KATA PENGANTAR (Split Layout) -->
        <div class="flex flex-col-reverse lg:flex-row items-center gap-10 lg:gap-16">
            <!-- Teks Pengantar -->
            <div class="w-full lg:w-2/3 space-y-6">
                <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-amber-50 text-amber-600 font-bold text-sm uppercase tracking-widest border border-amber-100">Kata Pengantar</div>
                <h2 class="text-3xl lg:text-5xl font-extrabold text-slate-800 leading-tight">Referensi Utama Analisis Perencanaan Mutu</h2>
                <div class="prose prose-slate prose-lg md:prose-xl max-w-none text-slate-600 leading-relaxed">
                    <p>Buku Profil Mutu Pendidikan adalah publikasi tahunan yang diterbitkan oleh BPMP Provinsi Sulawesi Tenggara. Hasil Rapor Pendidikan didukung oleh berbagai sumber data kredibel seperti Asesmen Nasional (AN) dan Survei Karakter.</p>
                    <p>Profil Mutu Pendidikan 2026 dapat dibaca dan diunduh melalui website BPMP Sultra yang dilengkapi dengan detail data capaian daerah.</p>
                </div>
            </div>
            <!-- Foto Pengantar -->
            <div class="w-full lg:w-1/3 shrink-0">
                <div class="relative rounded-[2rem] overflow-hidden shadow-md group">
                    <!-- Silakan ganti link gambar pengantar -->
                    <img src="https://images.unsplash.com/photo-1497215728101-856f4ea42174?w=800&fit=crop" alt="Kata Pengantar" class="w-full h-auto aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-700">
                </div>
            </div>
        </div>

        <!-- GARIS PEMISAH HALUS -->
        <div class="w-full h-px bg-slate-200 my-16"></div>

        <!-- 3. GRID 18 KABUPATEN / KOTA -->
        <div class="text-center mb-12">
            <h3 class="text-3xl md:text-4xl font-extrabold text-slate-800">Profil Mutu per Daerah</h3>
            <p class="text-slate-500 mt-3 text-lg md:text-xl">Pilih Kabupaten/Kota untuk melihat dokumen profil mutu pendidikan secara spesifik.</p>
        </div>

        <!-- Layout Grid Proporsional untuk Layar Sangat Lebar (Up to 5 Kolom) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-5 lg:gap-6">
            
            <!-- 1. Provinsi Sulawesi Tenggara (Biru Utama) -->
            <button type="button" @click="openModal('Profil Mutu Provinsi Sulawesi Tenggara', 'https://drive.google.com/file/d/CONTOH_ID/preview', 'Provinsi Sulawesi Tenggara • PDF')" 
                    class="group relative bg-blue-50/80 backdrop-blur-md border border-blue-200 rounded-2xl p-5 shadow-sm hover:shadow-xl hover:border-blue-400 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-blue-500 group-hover:text-blue-700 shadow-sm transition-all group-hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-blue-500 font-extrabold uppercase tracking-widest block mb-1">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-blue-900 leading-tight">Prov. Sulawesi Tenggara</h4>
                    <span class="text-[11px] text-blue-400/80 mt-1 flex items-center gap-1 font-medium">Laporan Induk • 2.4 MB</span>
                </div>
            </button>

            <!-- 2. Kota Kendari -->
            <button type="button" @click="openModal('Profil Mutu Kota Kendari', 'https://drive.google.com/file/d/CONTOH_ID_KENDARI/preview', 'Kota Kendari • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kota Kendari</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.8 MB</span>
                </div>
            </button>

            <!-- 3. Kota Baubau -->
            <button type="button" @click="openModal('Profil Mutu Kota Baubau', 'https://drive.google.com/file/d/CONTOH_ID_BAUBAU/preview', 'Kota Baubau • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kota Baubau</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.7 MB</span>
                </div>
            </button>

            <!-- 4. Kab. Konawe -->
            <button type="button" @click="openModal('Profil Mutu Kab. Konawe', 'https://drive.google.com/file/d/CONTOH_ID_KONAWE/preview', 'Kab. Konawe • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Konawe</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.9 MB</span>
                </div>
            </button>

            <!-- 5. Kab. Konawe Selatan -->
            <button type="button" @click="openModal('Profil Mutu Kab. Konawe Selatan', 'https://drive.google.com/file/d/CONTOH_ID_KONSEL/preview', 'Kab. Konawe Selatan • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Konawe Selatan</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.8 MB</span>
                </div>
            </button>

            <!-- 6. Kab. Konawe Utara -->
            <button type="button" @click="openModal('Profil Mutu Kab. Konawe Utara', 'https://drive.google.com/file/d/CONTOH_ID_KONUT/preview', 'Kab. Konawe Utara • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Konawe Utara</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.6 MB</span>
                </div>
            </button>

            <!-- 7. Kab. Konawe Kepulauan -->
            <button type="button" @click="openModal('Profil Mutu Kab. Konawe Kepulauan', 'https://drive.google.com/file/d/CONTOH_ID_KONKEP/preview', 'Kab. Konawe Kepulauan • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Konawe Kepulauan</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.5 MB</span>
                </div>
            </button>

            <!-- 8. Kab. Kolaka -->
            <button type="button" @click="openModal('Profil Mutu Kab. Kolaka', 'https://drive.google.com/file/d/CONTOH_ID_KOLAKA/preview', 'Kab. Kolaka • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Kolaka</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.9 MB</span>
                </div>
            </button>

            <!-- 9. Kab. Kolaka Utara -->
            <button type="button" @click="openModal('Profil Mutu Kab. Kolaka Utara', 'https://drive.google.com/file/d/CONTOH_ID_KOLUT/preview', 'Kab. Kolaka Utara • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Kolaka Utara</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.7 MB</span>
                </div>
            </button>

            <!-- 10. Kab. Kolaka Timur -->
            <button type="button" @click="openModal('Profil Mutu Kab. Kolaka Timur', 'https://drive.google.com/file/d/CONTOH_ID_KOLTIM/preview', 'Kab. Kolaka Timur • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Kolaka Timur</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.6 MB</span>
                </div>
            </button>

            <!-- 11. Kab. Buton -->
            <button type="button" @click="openModal('Profil Mutu Kab. Buton', 'https://drive.google.com/file/d/CONTOH_ID_BUTON/preview', 'Kab. Buton • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Buton</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.9 MB</span>
                </div>
            </button>

            <!-- 12. Kab. Buton Selatan -->
            <button type="button" @click="openModal('Profil Mutu Kab. Buton Selatan', 'https://drive.google.com/file/d/CONTOH_ID_BUSEL/preview', 'Kab. Buton Selatan • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Buton Selatan</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.6 MB</span>
                </div>
            </button>

            <!-- 13. Kab. Buton Tengah -->
            <button type="button" @click="openModal('Profil Mutu Kab. Buton Tengah', 'https://drive.google.com/file/d/CONTOH_ID_BUTENG/preview', 'Kab. Buton Tengah • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Buton Tengah</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.7 MB</span>
                </div>
            </button>

            <!-- 14. Kab. Buton Utara -->
            <button type="button" @click="openModal('Profil Mutu Kab. Buton Utara', 'https://drive.google.com/file/d/CONTOH_ID_BUTUR/preview', 'Kab. Buton Utara • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Buton Utara</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.6 MB</span>
                </div>
            </button>

            <!-- 15. Kab. Muna -->
            <button type="button" @click="openModal('Profil Mutu Kab. Muna', 'https://drive.google.com/file/d/CONTOH_ID_MUNA/preview', 'Kab. Muna • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Muna</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 2.0 MB</span>
                </div>
            </button>

            <!-- 16. Kab. Muna Barat -->
            <button type="button" @click="openModal('Profil Mutu Kab. Muna Barat', 'https://drive.google.com/file/d/CONTOH_ID_MUBAR/preview', 'Kab. Muna Barat • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Muna Barat</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.7 MB</span>
                </div>
            </button>

            <!-- 17. Kab. Wakatobi -->
            <button type="button" @click="openModal('Profil Mutu Kab. Wakatobi', 'https://drive.google.com/file/d/CONTOH_ID_WAKATOBI/preview', 'Kab. Wakatobi • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Wakatobi</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.8 MB</span>
                </div>
            </button>

            <!-- 18. Kab. Bombana -->
            <button type="button" @click="openModal('Profil Mutu Kab. Bombana', 'https://drive.google.com/file/d/CONTOH_ID_BOMBANA/preview', 'Kab. Bombana • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Bombana</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.9 MB</span>
                </div>
            </button>

        </div>

    <!-- MODAL PDF VIEWER (UI Dark Mode Premium) -->
    <template x-teleport="body">
        <div x-show="showModal" class="fixed inset-0 z-[999] flex items-center justify-center p-4 sm:p-6" style="display: none;" @keydown.escape.window="showModal = false">
            
            <!-- Backdrop Overlay Gelap -->
            <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm" @click="showModal = false"></div>
            
            <!-- Container Modal -->
            <div x-show="showModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-8"
                 class="relative bg-[#1e2329] rounded-2xl shadow-2xl w-full max-w-5xl h-[85vh] flex flex-col overflow-hidden border border-slate-700 z-10">
                
                <!-- HEADER MODAL (Dark Mode UI) -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 border-b border-slate-700/50 bg-[#161b22] gap-4">
                    
                    <!-- Kiri: Judul & Info File -->
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-red-500/20 text-red-400 flex items-center justify-center shrink-0 border border-red-500/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-100 text-sm md:text-base leading-tight" x-text="pdfTitle"></h4>
                            <p class="text-xs text-slate-400 mt-0.5" x-text="fileInfo"></p>
                        </div>
                    </div>
                    
                    <!-- Kanan: Tombol Aksi -->
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <!-- Tombol Copy Link -->
                        <button type="button" @click="copyLink()" title="Salin Tautan Dokumen" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-3.5 py-2 rounded-xl bg-slate-800 text-slate-200 hover:bg-slate-700 hover:text-white transition-colors text-xs font-semibold border border-slate-600/70">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            <span>Salin Tautan</span>
                        </button>
                        
                        <!-- Tombol Download -->
                        <a :href="pdfUrl" target="_blank" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 text-white hover:bg-emerald-500 transition-colors text-xs font-bold shadow-lg shadow-emerald-900/30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Download</span>
                        </a>
                        
                        <!-- Tombol Close -->
                        <button type="button" @click="showModal = false" class="w-9 h-9 ml-1 flex items-center justify-center rounded-xl bg-slate-800 text-slate-400 hover:bg-red-500/20 hover:text-red-400 transition-colors border border-slate-700/60" title="Tutup Modal">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
                
                <!-- BODY MODAL (IFRAME PDF RESPONSIVE) -->
                <div class="flex-grow bg-[#525659] w-full relative min-h-[400px]">
                    <iframe :src="showModal ? pdfUrl : ''" class="absolute inset-0 w-full h-full border-0" allow="autoplay"></iframe>
                </div>
                
            </div>
        </div>
    </template>
</div>
EOD,
                'sort_order' => 4,
            ]);
        }

        if (! PageTemplate::where('name', 'Regulasi & Dokumen Pendidikan')->exists()) {
            PageTemplate::create([
                'name' => 'Regulasi & Dokumen Pendidikan',
                'description' => 'Direktori dokumen dengan fitur live search, list item glassmorphism, pagination 5 item, dan PDF pop-up.',
                'content' => <<<'EOD'
<!-- Direktori Regulasi & Dokumen Pendidikan (Live Search, Pagination 5 item, Light Glassmorphism, & Dark PDF Viewer) -->
<div x-data="{
    search: '',
    selectedCategory: 'all',
    currentPage: 1,
    perPage: 5,
    showModal: false,
    pdfTitle: '',
    pdfUrl: '',
    fileInfo: '',
    copied: false,
    openModal(title, url, info) {
        this.pdfTitle = title;
        this.pdfUrl = url;
        this.fileInfo = info;
        this.showModal = true;
    },
    copyLink() {
        if (this.pdfUrl) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(this.pdfUrl).then(() => {
                    this.copied = true;
                    setTimeout(() => { this.copied = false; }, 2500);
                });
            } else {
                const ta = document.createElement('textarea');
                ta.value = this.pdfUrl;
                document.body.appendChild(ta);
                ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
                this.copied = true;
                setTimeout(() => { this.copied = false; }, 2500);
            }
        }
    },
    docs: [
        { id: 1, title: 'Permendikdasmen Nomor 1 Tahun 2024 tentang OTK Kementerian Pendidikan Dasar dan Menengah', nomor: 'Permendikdasmen No. 1 / 2024', category: 'Permendikdasmen', year: '2024', size: '2.4 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_1_2024/preview', desc: 'Peraturan Organisasi dan Tata Kerja Kementerian Pendidikan Dasar dan Menengah Republik Indonesia.' },
        { id: 2, title: 'Permendikdasmen Nomor 2 Tahun 2025 tentang Pedoman Pengawasan Penggunaan Bahasa Indonesia', nomor: 'Permendikdasmen No. 2 / 2025', category: 'Permendikdasmen', year: '2025', size: '1.8 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_2_2025/preview', desc: 'Pedoman pengawasan serta pembinaan penggunaan bahasa Indonesia di lingkungan satuan pendidikan.' },
        { id: 3, title: 'Permendikdasmen Nomor 3 Tahun 2025 tentang Sistem Penerimaan Murid Baru', nomor: 'Permendikdasmen No. 3 / 2025', category: 'Permendikdasmen', year: '2025', size: '2.1 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_3_2025/preview', desc: 'Juknis dan regulasi resmi penerimaan murid baru (SPMB) yang akuntabel, objektif, dan berkeadilan.' },
        { id: 4, title: 'Permendikdasmen Nomor 4 Tahun 2025 tentang Juknis TP Guru ASN Daerah', nomor: 'Permendikdasmen No. 4 / 2025', category: 'Permendikdasmen', year: '2025', size: '3.2 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_4_2025/preview', desc: 'Petunjuk teknis penyaluran tunjangan profesi bagi guru aparatur sipil negara di daerah.' },
        { id: 5, title: 'Permendikdasmen Nomor 5 Tahun 2025 tentang OTK BGTK', nomor: 'Permendikdasmen No. 5 / 2025', category: 'Permendikdasmen', year: '2025', size: '1.9 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_5_2025/preview', desc: 'Organisasi dan tata kerja Balai Guru dan Tenaga Kependidikan pada tingkat pusat dan wilayah.' },
        { id: 6, title: 'Permendikdasmen Nomor 6 Tahun 2025 tentang Pengembangan Kompetensi ASN', nomor: 'Permendikdasmen No. 6 / 2025', category: 'Permendikdasmen', year: '2025', size: '2.5 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_6_2025/preview', desc: 'Kebijakan program berkelanjutan pengembangan kompetensi aparatur sipil negara di sektor pendidikan.' },
        { id: 7, title: 'Permendikdasmen Nomor 7 Tahun 2025 tentang Penugasan Guru Sebagai Kepala Sekolah', nomor: 'Permendikdasmen No. 7 / 2025', category: 'Permendikdasmen', year: '2025', size: '2.0 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_7_2025/preview', desc: 'Standar persyaratan, seleksi, serta mekanisme penugasan guru sebagai kepala sekolah di satuan pendidikan.' },
        { id: 8, title: 'Permendikdasmen Nomor 8 Tahun 2025 tentang Juknis BOSP 2025', nomor: 'Permendikdasmen No. 8 / 2025', category: 'Permendikdasmen', year: '2025', size: '4.1 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_8_2025/preview', desc: 'Petunjuk teknis pengelolaan dan pertanggungjawaban Bantuan Operasional Satuan Pendidikan (BOSP) tahun 2025.' },
        { id: 9, title: 'Permendikdasmen Nomor 9 Tahun 2025 tentang Tes Kemampuan Akademik', nomor: 'Permendikdasmen No. 9 / 2025', category: 'Permendikdasmen', year: '2025', size: '1.7 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_9_2025/preview', desc: 'Pelaksanaan dan standar evaluasi tes kemampuan akademik bagi peserta didik pendidikan dasar dan menengah.' },
        { id: 10, title: 'Permendikdasmen Nomor 10 Tahun 2025 tentang SKL PAUD Dikdasmen', nomor: 'Permendikdasmen No. 10 / 2025', category: 'Permendikdasmen', year: '2025', size: '2.8 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_10_2025/preview', desc: 'Standar Kompetensi Lulusan (SKL) pada Pendidikan Anak Usia Dini, Pendidikan Dasar, dan Pendidikan Menengah.' },
        { id: 11, title: 'Permendikdasmen Nomor 11 Tahun 2025 tentang Pemenuhan Beban Kerja Guru', nomor: 'Permendikdasmen No. 11 / 2025', category: 'Permendikdasmen', year: '2025', size: '2.2 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_11_2025/preview', desc: 'Ketentuan dan rincian pemenuhan beban kerja guru, kepala sekolah, dan pengawas sekolah.' },
        { id: 12, title: 'Permendikdasmen Nomor 12 Tahun 2025 tentang Standar Isi PAUD Dikdasmen', nomor: 'Permendikdasmen No. 12 / 2025', category: 'Permendikdasmen', year: '2025', size: '3.5 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_12_2025/preview', desc: 'Standar isi ruang lingkup materi dan tingkat kompetensi untuk jenjang PAUD, SD, SMP, dan SMA/SMK.' },
        { id: 13, title: 'Permendikdasmen Nomor 13 Tahun 2025 tentang Kurikulum PAUD Dikdasmen', nomor: 'Permendikdasmen No. 13 / 2025', category: 'Permendikdasmen', year: '2025', size: '4.8 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_13_2025/preview', desc: 'Kerangka dasar dan struktur kurikulum nasional untuk satuan pendidikan anak usia dini hingga menengah.' },
        { id: 14, title: 'Permendikdasmen Nomor 14 Tahun 2025 tentang Pelaksanaan Pemberian Tukin Pegawai Kemendikdasmen', nomor: 'Permendikdasmen No. 14 / 2025', category: 'Permendikdasmen', year: '2025', size: '2.6 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_14_2025/preview', desc: 'Mekanisme perhitungan dan penyaluran tunjangan kinerja aparatur sipil negara di lingkungan kementerian.' },
        { id: 15, title: 'Pedoman Pengelolaan Organisasi, Administrasi dan Personil', nomor: 'Pedoman Organisasi', category: 'Pedoman', year: '2025', size: '3.1 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PEDOMAN_ORG/preview', desc: 'Buku panduan tata kelola administrasi kepegawaian, persuratan, dan kelembagaan unit pelaksana teknis.' },
        { id: 16, title: 'Perpres Nomor 3 Tahun 2026 tentang Kebijakan Strategis Pendidikan Nasional', nomor: 'Perpres No. 3 / 2026', category: 'Perpres', year: '2026', size: '2.9 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERPRES_3_2026/preview', desc: 'Peraturan Presiden mengenai arah kebijakan prioritas pembangunan pendidikan nasional jangka menengah.' },
        { id: 17, title: 'SE Dirjen PAUD Dasmen Nomor 0301 Tahun 2026 tentang SPMB', nomor: 'SE Dirjen No. 0301 / 2026', category: 'Surat Edaran', year: '2026', size: '1.2 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_SE_DIRJEN_0301_2026/preview', desc: 'Surat Edaran Direktur Jenderal terkait kesiapan daerah dan satuan pendidikan dalam pelaksanaan SPMB 2026.' },
        { id: 18, title: 'SE KPK tentang Pencegahan Korupsi pada SPMB Tahun 2026', nomor: 'SE KPK SPMB / 2026', category: 'Surat Edaran', year: '2026', size: '1.5 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_SE_KPK_SPMB_2026/preview', desc: 'Himbauan integritas pencegahan suap, gratifikasi, dan pungutan liar dalam proses penerimaan peserta didik.' },
        { id: 19, title: 'Permendikdasmen Nomor 26 Tahun 2025 tentang Tata Kelola Sistem Penjaminan Mutu', nomor: 'Permendikdasmen No. 26 / 2025', category: 'Permendikdasmen', year: '2025', size: '3.0 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_26_2025/preview', desc: 'Siklus dan tata kelola penjaminan mutu pendidikan internal dan eksternal tingkat daerah dan provinsi.' },
        { id: 20, title: 'Permendikdasmen Nomor 3 Tahun 2025 (JDIH Salinan Resmi)', nomor: 'Salinan JDIH No. 3 / 2025', category: 'Permendikdasmen', year: '2025', size: '2.3 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_3_2025_JDIH/preview', desc: 'Salinan resmi JDIH Peraturan Menteri Pendidikan Dasar dan Menengah Nomor 3 Tahun 2025.' },
        { id: 21, title: 'Salinan Kepmen Nomor 14 Tahun 2026 JDIH', nomor: 'Kepmen No. 14 / 2026', category: 'Kepmen', year: '2026', size: '2.7 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_KEPMEN_14_2026/preview', desc: 'Salinan Keputusan Menteri Pendidikan Dasar dan Menengah terdaftar resmi pada JDIH kementerian.' },
        { id: 22, title: 'Salinan Permendikdasmen Nomor 14 Tahun 2026 CAP', nomor: 'Permendikdasmen No. 14 / 2026 CAP', category: 'Permendikdasmen', year: '2026', size: '3.4 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_14_2026_CAP/preview', desc: 'Salinan naskah asli bertanda tangan dan cap basah resmi kementerian untuk arsip regulasi kepegawaian.' }
    ],
    get filteredDocs() {
        let q = this.search.toLowerCase().trim();
        return this.docs.filter(doc => {
            let matchSearch = !q || 
                doc.title.toLowerCase().includes(q) || 
                doc.nomor.toLowerCase().includes(q) || 
                doc.category.toLowerCase().includes(q) || 
                doc.year.includes(q);
            let matchCat = this.selectedCategory === 'all' || doc.category === this.selectedCategory;
            return matchSearch && matchCat;
        });
    },
    get totalPages() {
        return Math.ceil(this.filteredDocs.length / this.perPage) || 1;
    },
    get paginatedDocs() {
        let start = (this.currentPage - 1) * this.perPage;
        return this.filteredDocs.slice(start, start + this.perPage);
    },
    get startCount() {
        return this.filteredDocs.length === 0 ? 0 : (this.currentPage - 1) * this.perPage + 1;
    },
    get endCount() {
        return Math.min(this.currentPage * this.perPage, this.filteredDocs.length);
    },
    goToPage(page) {
        if (page >= 1 && page <= this.totalPages) {
            this.currentPage = page;
        }
    },
    nextPage() {
        if (this.currentPage < this.totalPages) {
            this.currentPage++;
        }
    },
    prevPage() {
        if (this.currentPage > 1) {
            this.currentPage--;
        }
    }
}" class="w-full space-y-8">

    <!-- HEADER / PENCARIAN REAL-TIME -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pb-6 border-b border-slate-100">
        <div>
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-50 border border-blue-100 text-blue-700 text-xs font-extrabold uppercase tracking-wider mb-2">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Bank Regulasi & Kebijakan
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight">Dokumen Regulasi Pendidikan</h2>
            <p class="text-slate-500 text-sm mt-1">Akses dan telusuri peraturan menteri, keputusan, serta pedoman resmi penjaminan mutu pendidikan.</p>
        </div>

        <!-- Kolom Pencarian Live Search -->
        <div class="w-full md:w-80 relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" x-model="search" @input="currentPage = 1" placeholder="Cari nomor, judul, atau tahun..." 
                   class="w-full pl-10 pr-10 py-2.5 bg-slate-50/80 hover:bg-slate-50 focus:bg-white border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 rounded-2xl text-xs sm:text-sm font-medium text-slate-700 placeholder:text-slate-400 transition-all outline-none">
            <button type="button" x-show="search" @click="search = ''; currentPage = 1" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <!-- FILTER KATEGORI (PILLS) & STATUS INFO -->
    <div class="flex flex-wrap items-center justify-between gap-3 pt-1">
        <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
            <button type="button" @click="selectedCategory = 'all'; currentPage = 1" 
                    :class="selectedCategory === 'all' ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30 font-bold' : 'bg-slate-100 hover:bg-slate-200/80 text-slate-600 font-medium'" 
                    class="px-3.5 py-1.5 rounded-xl text-xs transition-all">Semua Dokumen</button>
            <button type="button" @click="selectedCategory = 'Permendikdasmen'; currentPage = 1" 
                    :class="selectedCategory === 'Permendikdasmen' ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30 font-bold' : 'bg-slate-100 hover:bg-slate-200/80 text-slate-600 font-medium'" 
                    class="px-3.5 py-1.5 rounded-xl text-xs transition-all">Permendikdasmen</button>
            <button type="button" @click="selectedCategory = 'Surat Edaran'; currentPage = 1" 
                    :class="selectedCategory === 'Surat Edaran' ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30 font-bold' : 'bg-slate-100 hover:bg-slate-200/80 text-slate-600 font-medium'" 
                    class="px-3.5 py-1.5 rounded-xl text-xs transition-all">Surat Edaran</button>
            <button type="button" @click="selectedCategory = 'Pedoman'; currentPage = 1" 
                    :class="selectedCategory === 'Pedoman' ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30 font-bold' : 'bg-slate-100 hover:bg-slate-200/80 text-slate-600 font-medium'" 
                    class="px-3.5 py-1.5 rounded-xl text-xs transition-all">Pedoman</button>
            <button type="button" @click="selectedCategory = 'Perpres'; currentPage = 1" 
                    :class="selectedCategory === 'Perpres' ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30 font-bold' : 'bg-slate-100 hover:bg-slate-200/80 text-slate-600 font-medium'" 
                    class="px-3.5 py-1.5 rounded-xl text-xs transition-all">Perpres</button>
            <button type="button" @click="selectedCategory = 'Kepmen'; currentPage = 1" 
                    :class="selectedCategory === 'Kepmen' ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30 font-bold' : 'bg-slate-100 hover:bg-slate-200/80 text-slate-600 font-medium'" 
                    class="px-3.5 py-1.5 rounded-xl text-xs transition-all">Kepmen</button>
        </div>

        <div class="text-xs text-slate-400 font-medium">
            Menampilkan <span class="font-bold text-slate-700" x-text="startCount"></span> - <span class="font-bold text-slate-700" x-text="endCount"></span> dari <span class="font-bold text-blue-600" x-text="filteredDocs.length"></span> regulasi
        </div>
    </div>

    <!-- LIST DOKUMEN (5 ITEM PER HALAMAN) -->
    <div class="space-y-4">
        <template x-for="doc in paginatedDocs" :key="doc.id">
            <div class="group relative bg-white/90 hover:bg-white border border-slate-200/90 hover:border-blue-400 rounded-3xl p-5 sm:p-6 shadow-[0_4px_20px_rgb(0,0,0,0.02)] hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 flex flex-col md:flex-row md:items-center justify-between gap-5">
                
                <!-- Sisi Kiri: Ikon & Teks Informasi -->
                <div class="flex items-start gap-4 sm:gap-5 flex-1 min-w-0">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-red-50 text-red-500 border border-red-100 flex items-center justify-center shrink-0 group-hover:scale-105 group-hover:bg-red-500 group-hover:text-white transition-all duration-300 shadow-xs">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    
                    <div class="space-y-1.5 flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-[10px] sm:text-[11px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-100" x-text="doc.nomor"></span>
                            <span class="text-[10px] sm:text-[11px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600" x-text="'Tahun ' + doc.year"></span>
                            <span class="text-[10px] sm:text-[11px] text-slate-400 font-medium flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                <span x-text="doc.size"></span>
                            </span>
                        </div>
                        
                        <h3 class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-blue-700 transition-colors leading-snug" x-text="doc.title"></h3>
                        
                        <p class="text-xs sm:text-sm text-slate-500 line-clamp-2 leading-relaxed" x-text="doc.desc"></p>
                    </div>
                </div>

                <!-- Sisi Kanan: Tombol Aksi -->
                <div class="flex items-center gap-2.5 sm:gap-3 shrink-0 pt-3 md:pt-0 border-t md:border-t-0 border-slate-100">
                    <button type="button" @click="openModal(doc.title, doc.file, doc.nomor + ' • ' + doc.size)" 
                            class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-2xl bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white font-bold text-xs transition-all duration-200 border border-blue-100 hover:border-blue-600 shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>Lihat PDF</span>
                    </button>
                    
                    <a :href="doc.file" target="_blank" 
                       class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-all duration-200 border border-slate-200/80 shadow-xs" title="Unduh Dokumen">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span class="md:hidden lg:inline">Unduh</span>
                    </a>
                </div>
            </div>
        </template>

        <!-- Empty State (Ketika tidak ditemukan) -->
        <div x-show="filteredDocs.length === 0" class="text-center py-16 px-4 bg-slate-50/60 rounded-3xl border border-dashed border-slate-200">
            <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-3">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h4 class="font-bold text-slate-700 text-base">Tidak ada regulasi yang ditemukan</h4>
            <p class="text-slate-400 text-xs sm:text-sm mt-1 max-w-sm mx-auto">Kata kunci "<span class="font-semibold text-slate-600" x-text="search"></span>" tidak cocok dengan regulasi manapun.</p>
            <button type="button" @click="search = ''; selectedCategory = 'all'; currentPage = 1" class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition-all shadow-sm shadow-blue-500/25">
                Reset Pencarian
            </button>
        </div>
    </div>

    <!-- PAGINATION CONTROL (5 Item Per Halaman) -->
    <div x-show="totalPages > 1" class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="text-xs text-slate-400 font-medium">
            Halaman <span class="font-bold text-slate-700" x-text="currentPage"></span> dari <span class="font-bold text-slate-700" x-text="totalPages"></span>
        </div>
        
        <div class="flex items-center gap-1.5">
            <button type="button" @click="prevPage()" :disabled="currentPage === 1" 
                    :class="currentPage === 1 ? 'opacity-40 cursor-not-allowed text-slate-300' : 'hover:bg-slate-100 text-slate-600 hover:text-slate-900'" 
                    class="p-2 rounded-xl border border-slate-200 bg-white transition-all flex items-center justify-center w-9 h-9" title="Halaman Sebelumnya">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            
            <template x-for="page in totalPages" :key="page">
                <button type="button" @click="goToPage(page)" 
                        :class="currentPage === page ? 'bg-blue-600 text-white font-extrabold shadow-md shadow-blue-500/30 border-blue-600' : 'bg-white hover:bg-slate-50 text-slate-600 font-bold border-slate-200'" 
                        class="w-9 h-9 rounded-xl border text-xs transition-all flex items-center justify-center" 
                        x-text="page"></button>
            </template>
            
            <button type="button" @click="nextPage()" :disabled="currentPage === totalPages" 
                    :class="currentPage === totalPages ? 'opacity-40 cursor-not-allowed text-slate-300' : 'hover:bg-slate-100 text-slate-600 hover:text-slate-900'" 
                    class="p-2 rounded-xl border border-slate-200 bg-white transition-all flex items-center justify-center w-9 h-9" title="Halaman Berikutnya">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </div>

    <!-- MODAL PDF VIEWER (UI Dark Mode Premium) -->
    <template x-teleport="body">
        <div x-show="showModal" class="fixed inset-0 z-[999] flex items-center justify-center p-4 sm:p-6" style="display: none;" @keydown.escape.window="showModal = false">
            <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm" @click="showModal = false"></div>
            
            <div x-show="showModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-8"
                 class="relative bg-[#1e2329] rounded-2xl shadow-2xl w-full max-w-5xl h-[85vh] flex flex-col overflow-hidden border border-slate-700 z-10">
                
                <!-- HEADER MODAL (Dark Mode UI) -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 border-b border-slate-700/50 bg-[#161b22] gap-4">
                    <div class="flex items-center gap-3.5 min-w-0 flex-1">
                        <div class="w-10 h-10 rounded-xl bg-red-500/20 text-red-400 flex items-center justify-center shrink-0 border border-red-500/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h4 class="font-bold text-slate-100 text-sm md:text-base leading-tight truncate" x-text="pdfTitle"></h4>
                            <p class="text-xs text-slate-400 mt-0.5" x-text="fileInfo"></p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2 w-full sm:w-auto shrink-0">
                        <button type="button" @click="copyLink()" title="Salin Tautan Dokumen" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-3.5 py-2 rounded-xl bg-slate-800 text-slate-200 hover:bg-slate-700 hover:text-white transition-colors text-xs font-semibold border border-slate-600/70">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            <span x-text="copied ? 'Tersalin!' : 'Salin Tautan'">Salin Tautan</span>
                        </button>
                        
                        <a :href="pdfUrl" target="_blank" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 text-white hover:bg-emerald-500 transition-colors text-xs font-bold shadow-lg shadow-emerald-900/30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Download</span>
                        </a>
                        
                        <button type="button" @click="showModal = false" class="w-9 h-9 ml-1 flex items-center justify-center rounded-xl bg-slate-800 text-slate-400 hover:bg-red-500/20 hover:text-red-400 transition-colors border border-slate-700/60" title="Tutup Modal">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
                
                <!-- BODY MODAL (IFRAME PDF RESPONSIVE) -->
                <div class="flex-grow bg-[#525659] w-full relative min-h-[400px]">
                    <iframe :src="showModal ? pdfUrl : ''" class="absolute inset-0 w-full h-full border-0" allow="autoplay"></iframe>
                </div>
                
            </div>
        </div>
    </template>
</div>
EOD,
                'sort_order' => 5,
            ]);
        }

    }
}
