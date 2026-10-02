<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita &amp; Publikasi - BPMP Provinsi Sulawesi Tenggara</title>
    <meta name="description" content="Dapatkan informasi terkini seputar kebijakan pendidikan, kegiatan operasional, dan program penjaminan mutu dari BPMP Provinsi Sulawesi Tenggara.">
    <link rel="icon" href="{{ asset('tutwurihandayani.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased overflow-x-hidden">

    {{-- NAVBAR --}}
    <header class="fixed top-0 z-50 w-full bg-white shadow-md border-b border-gray-200" x-data="{ mobileMenuOpen: false }">
        <nav class="w-full flex items-center justify-between px-4 lg:px-8 py-3">
            <div class="flex items-center shrink-0 space-x-3">
                <a href="/" class="flex items-center gap-3 shrink-0 group">
                    <img src="{{ asset('tutwurihandayani.png') }}" alt="Logo BPMP" class="h-10 w-10 md:h-12 md:w-12 group-hover:scale-105 transition-transform drop-shadow-md">
                    <div class="flex flex-col">
                        <span class="font-bold text-lg md:text-xl leading-tight tracking-tight whitespace-nowrap">
                            <span class="text-blue-600">Kemen</span><span class="text-orange-500">dikdasmen</span>
                        </span>
                        <span class="text-[11px] md:text-[12px] font-medium whitespace-nowrap text-gray-800">BPMP Provinsi Sulawesi Tenggara</span>
                    </div>
                </a>
            </div>

            <div class="hidden lg:flex items-center space-x-1 xl:space-x-2 text-sm font-medium" x-data="{ openMenu: null }">
                <div class="relative" @mouseenter="openMenu = 'profil'" @mouseleave="openMenu = null">
                    <button class="px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap flex items-center gap-1 text-gray-700 hover:text-blue-600 transition-colors">
                        Profil
                        <svg class="w-3 h-3" :class="openMenu==='profil'?'rotate-180':''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openMenu === 'profil'" x-transition class="absolute left-0 mt-1 bg-white shadow-xl border border-gray-100 rounded-xl p-1.5 min-w-[180px] z-50">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 rounded-md">Profil Lembaga</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 rounded-md">Struktur Organisasi</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 rounded-md">Visi Misi</a>
                    </div>
                </div>
                <a href="/#layanan" class="px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap text-gray-700 hover:text-blue-600 transition-colors">Program</a>
                <a href="/#layanan" class="px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap text-gray-700 hover:text-blue-600 transition-colors">ULT</a>
                <a href="/berita" class="px-2 py-2 text-[11.5px] lg:text-[12.5px] font-bold whitespace-nowrap text-blue-600 border-b-2 border-blue-600">Berita</a>
                <a href="#" class="px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap text-gray-700 hover:text-blue-600 transition-colors">Publikasi</a>
                <a href="#" class="px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap text-gray-700 hover:text-blue-600 transition-colors">SAKIP</a>
                <a href="#" class="px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap text-gray-700 hover:text-blue-600 transition-colors">Link Terkait</a>
                <a href="#" class="px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap text-gray-700 hover:text-blue-600 transition-colors">PPID</a>
                <a href="#" class="px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap text-gray-700 hover:text-blue-600 transition-colors">ZI WBK</a>
                <a href="#" class="px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap text-gray-700 hover:text-blue-600 transition-colors">Pengaduan</a>
                <a href="/#kontak" class="px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap text-gray-700 hover:text-blue-600 transition-colors">Hubungi Kami</a>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden lg:block relative">
                    <input type="search" placeholder="Pencarian..." class="border text-sm rounded-full pl-9 pr-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-400/50 transition-all w-36 focus:w-48 bg-gray-100 text-gray-800 border-gray-200 placeholder-gray-400">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-3.5 w-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="xl:hidden p-2 rounded-lg text-gray-800 hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </nav>
    </header>

    {{-- HERO HEADER --}}
    <section class="bg-gradient-to-b from-blue-950 to-blue-900 pt-28 pb-14 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 20% 50%, #3b82f6 0%, transparent 60%), radial-gradient(circle at 80% 20%, #1d4ed8 0%, transparent 50%);"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-blue-200 text-xs font-semibold mb-5">
                <span>&#128240;</span>
                <span>Pusat Informasi Publik</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 leading-tight" style="font-family:'Plus Jakarta Sans',sans-serif;">
                Berita &amp; <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-300 to-blue-400">Publikasi</span> BPMP
            </h1>
            <p class="text-blue-200/80 text-base md:text-lg max-w-2xl mx-auto leading-relaxed">
                Dapatkan informasi terkini seputar kebijakan pendidikan, kegiatan operasional, dan program penjaminan mutu dari BPMP Provinsi Sulawesi Tenggara.
            </p>
            <div class="flex items-center justify-center gap-2 mt-6 text-xs text-blue-300/70 font-medium">
                <a href="/" class="hover:text-white transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-white">Berita &amp; Publikasi</span>
            </div>
        </div>
    </section>

    {{-- FILTER & SEARCH BAR --}}
    <div class="sticky top-[64px] z-40 bg-white/80 backdrop-blur-xl border-b border-gray-200/60 shadow-sm" x-data="{ activeTab: 'semua' }">
        <div class="container mx-auto px-4 py-3">
            <div class="flex flex-col md:flex-row items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-2">
                    <button @click="activeTab = 'semua'" :class="activeTab === 'semua' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all">Semua Kategori</button>
                    <button @click="activeTab = 'berita'" :class="activeTab === 'berita' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all">Berita Terkini</button>
                    <button @click="activeTab = 'artikel'" :class="activeTab === 'artikel' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all">Artikel</button>
                    <button @click="activeTab = 'program'" :class="activeTab === 'program' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all">Program Prioritas</button>
                    <button @click="activeTab = 'pengumuman'" :class="activeTab === 'pengumuman' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all">Pengumuman</button>
                    <button @click="activeTab = 'dokumentasi'" :class="activeTab === 'dokumentasi' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all">Dokumentasi</button>
                </div>
                <div class="relative w-full md:w-64">
                    <input type="search" placeholder="Ketik kata kunci..." class="w-full pl-9 pr-4 py-2 text-sm rounded-full bg-gray-100 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400/50 focus:bg-white transition-all">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <main class="container mx-auto px-4 py-12">
        <div class="flex items-center justify-between mb-8">
            <p class="text-sm text-gray-500 font-medium">Showing <strong class="text-gray-800">1</strong> to <strong class="text-gray-800">9</strong> of <strong class="text-gray-800">143</strong> results</p>
        </div>

        @php
        $articles = [
            ['id'=>1,'cat'=>'Berita Terkini','color'=>'bg-blue-600','title'=>'Sosialisasi Rapor Pendidikan 2026 di Kabupaten Konawe','date'=>'02 Okt 2026','excerpt'=>'KENDARI - BPMP Sultra menyelenggarakan kegiatan sosialisasi pemanfaatan Rapor Pendidikan untuk perencanaan berbasis data di tingkat daerah guna meningkatkan mutu...','img'=>'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&w=600&q=80'],
            ['id'=>2,'cat'=>'Program Prioritas','color'=>'bg-emerald-600','title'=>'Pendampingan Implementasi Kurikulum Merdeka di Sekolah Sasaran','date'=>'30 Sep 2026','excerpt'=>'KENDARI - Tim fasilitator BPMP Provinsi Sulawesi Tenggara melakukan pendampingan intensif bagi sekolah-sekolah sasaran IKM di wilayah kepulauan terluar...','img'=>'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=600&q=80'],
            ['id'=>3,'cat'=>'Dokumentasi','color'=>'bg-amber-500','title'=>'Kunjungan Kerja Tim Pusat ke BPMP Sultra','date'=>'30 Sep 2026','excerpt'=>'KENDARI - Menerima kunjungan tim dari kementerian pusat dalam rangka monitoring dan evaluasi penjaminan mutu pendidikan di Sulawesi Tenggara...','img'=>'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=600&q=80'],
            ['id'=>4,'cat'=>'Pengumuman','color'=>'bg-red-600','title'=>'Pengumuman Seleksi Fasilitator Sekolah Penggerak Angkatan IV','date'=>'29 Sep 2026','excerpt'=>'KENDARI - BPMP Provinsi Sulawesi Tenggara membuka pendaftaran seleksi fasilitator program Sekolah Penggerak angkatan keempat untuk tahun pelajaran 2026/2027...','img'=>'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=600&q=80'],
            ['id'=>5,'cat'=>'Artikel','color'=>'bg-purple-600','title'=>'Transformasi Pembelajaran: Refleksi Satu Tahun Kurikulum Merdeka','date'=>'28 Sep 2026','excerpt'=>'KENDARI - Satu tahun setelah implementasi penuh Kurikulum Merdeka, berbagai satuan pendidikan di Sulawesi Tenggara menunjukkan perkembangan signifikan...','img'=>'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=600&q=80'],
            ['id'=>6,'cat'=>'Program Prioritas','color'=>'bg-emerald-600','title'=>'Pelatihan Perencanaan Berbasis Data untuk Kepala Sekolah','date'=>'26 Sep 2026','excerpt'=>'KENDARI - BPMP Sultra menyelenggarakan pelatihan PBD bagi ratusan kepala sekolah dan pengawas dari 17 kabupaten/kota se-Sulawesi Tenggara...','img'=>'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=600&q=80'],
            ['id'=>7,'cat'=>'Berita Terkini','color'=>'bg-blue-600','title'=>'BPMP Sultra Raih Penghargaan ZI WBK dari Kemendikdasmen','date'=>'25 Sep 2026','excerpt'=>'KENDARI - BPMP Provinsi Sulawesi Tenggara kembali berhasil mempertahankan predikat Wilayah Bebas dari Korupsi dalam penilaian zona integritas tahun 2026...','img'=>'https://images.unsplash.com/photo-1531545514256-b1400bc00f31?auto=format&fit=crop&w=600&q=80'],
            ['id'=>8,'cat'=>'Dokumentasi','color'=>'bg-amber-500','title'=>'Galeri Kegiatan Bulan September 2026','date'=>'24 Sep 2026','excerpt'=>'KENDARI - Dokumentasi berbagai kegiatan BPMP Provinsi Sulawesi Tenggara selama bulan September 2026, mulai dari pendampingan sekolah hingga rapat koordinasi daerah...','img'=>'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=600&q=80'],
            ['id'=>9,'cat'=>'Artikel','color'=>'bg-purple-600','title'=>'Pentingnya Data Dalam Pengambilan Keputusan Pendidikan','date'=>'22 Sep 2026','excerpt'=>'KENDARI - Pemanfaatan data pendidikan secara akurat merupakan kunci keberhasilan dalam merumuskan kebijakan yang tepat sasaran dan berdampak nyata bagi peserta didik...','img'=>'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=600&q=80'],
        ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-7">
            @foreach($articles as $a)
            <article class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                <div class="relative overflow-hidden h-48">
                    <img src="{{ $a['img'] }}" alt="{{ $a['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <span class="absolute top-3 left-3 {{ $a['color'] }} text-white text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-1 rounded-full">{{ $a['cat'] }}</span>
                </div>
                <div class="p-5 flex flex-col flex-grow">
                    <div class="flex items-center gap-1.5 text-xs text-gray-400 font-medium mb-2">
                        <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $a['date'] }}
                    </div>
                    <h2 class="font-bold text-gray-900 text-base leading-snug mb-3 group-hover:text-blue-700 transition-colors line-clamp-2">{{ $a['title'] }}</h2>
                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 flex-grow mb-4">{{ $a['excerpt'] }}</p>
                    <div class="pt-4 border-t border-gray-100 mt-auto">
                        <a href="/berita/{{ $a['id'] }}" class="text-blue-600 font-bold text-sm hover:text-blue-800 inline-flex items-center gap-1 group-hover:gap-2 transition-all">Baca &rarr;</a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="flex items-center justify-center gap-1.5 mt-14">
            <button class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button class="w-9 h-9 flex items-center justify-center rounded-lg bg-blue-600 text-white font-bold text-sm shadow-md">1</button>
            <button class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 font-medium text-sm">2</button>
            <button class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 font-medium text-sm">3</button>
            <button class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 font-medium text-sm">4</button>
            <button class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 font-medium text-sm">5</button>
            <span class="text-gray-400 text-sm px-1">...</span>
            <button class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 font-medium text-sm">15</button>
            <button class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 font-medium text-sm">16</button>
            <button class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>
    </main>

    <footer class="bg-blue-950 py-8 mt-8">
        <div class="container mx-auto px-4 text-center">
            <p class="text-sm text-blue-100/50 font-medium">&copy; 2026 BPMP Provinsi Sulawesi Tenggara. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

</body>
</html>
