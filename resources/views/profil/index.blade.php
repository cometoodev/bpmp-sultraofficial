@php
    $seo = \Illuminate\Support\Facades\DB::table('settings')->where('group', 'seo')->pluck('value', 'key');
    $general = \Illuminate\Support\Facades\DB::table('settings')->where('group', 'general')->pluck('value', 'key');
    $site_name = $general['site_name'] ?? 'BPMP Provinsi Sulawesi Tenggara';
    $pageTitle = $page->title ?? 'Profil Lembaga';
    $pageDescription = $page->meta_description ?? ($page->excerpt ?? 'Mengenal lebih dekat visi, sejarah pembentukan, tugas, fungsi pokok, serta struktur kepemimpinan Balai Penjaminan Mutu Pendidikan Provinsi Sulawesi Tenggara.');
    $pageFeaturedImage = !empty($page->featured_image) ? Storage::disk('public')->url($page->featured_image) : asset('fotoheader/slide1.png');
@endphp
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($page) ? $page->getSeoTitle() : $pageTitle }} - {{ $site_name }}</title>
    <meta name="description" content="{{ isset($page) ? $page->getSeoDescription() : $pageDescription }}">
    <link rel="icon" href="{{ asset('tutwurihandayani.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased overflow-x-hidden selection:bg-blue-600 selection:text-white">

    @if(!empty($isPreview))
        <!-- Preview Mode Banner -->
        <div class="bg-amber-500 text-slate-950 px-4 py-2 text-center text-xs font-bold fixed top-0 inset-x-0 z-[60] shadow-md flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <span>MODE PRATINJAU (PREVIEW): Halaman berstatus draft.</span>
        </div>
    @endif

    {{-- NAVBAR --}}
    <x-navbar :alwaysScrolled="true" :isPreview="!empty($isPreview)" />

    @if(!empty($page->content) && !str_contains($page->content, '<!DOCTYPE'))
        {!! $page->content !!}
    @else
    {{-- HEADER UNIVERSAL (BIRU SOLID / BG-BLUE-900) --}}
    <div class="relative pt-28 pb-40 overflow-hidden bg-blue-900">
        
        <!-- Konten Judul Header -->
        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto flex flex-col items-center">
            
            <!-- Badge Kategori / Label -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-white font-extrabold text-[10px] sm:text-xs uppercase tracking-widest shadow-sm mb-6">
                <div class="w-2 h-2 rounded-full bg-blue-400"></div>
                Tentang Kami &bull; Profil Lembaga
            </div>

            <!-- Judul Utama (Dinamis dari $page->title) -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight mb-6" style="font-family:'Plus Jakarta Sans',sans-serif;">
                {{ $page->title ?? 'Profil Lembaga BPMP' }}
            </h1>

            <!-- Deskripsi Singkat (Dinamis dari $page->meta_description / excerpt) -->
            <p class="text-blue-100 text-sm md:text-base lg:text-lg leading-relaxed max-w-3xl mx-auto mb-8 drop-shadow-sm">
                {{ $page->excerpt ?? ($page->meta_description ?? 'Mengenal lebih dekat visi, sejarah pembentukan, tugas, fungsi pokok, serta struktur kepemimpinan Balai Penjaminan Mutu Pendidikan Provinsi Sulawesi Tenggara.') }}
            </p>

            <!-- Breadcrumbs & Meta Date -->
            <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 text-xs sm:text-sm font-medium text-blue-200">
                <a href="{{ url('/') }}" class="hover:text-white transition-colors">Beranda</a>
                <span class="text-blue-400/60">›</span>
                <span class="text-white font-semibold">{{ $page->title ?? 'Profil Lembaga' }}</span>
                
                <span class="hidden sm:inline-block text-blue-400/60 mx-2">|</span>
                
                <div class="flex items-center gap-1.5 mt-2 sm:mt-0 px-3 py-1 rounded-lg bg-black/10 border border-white/10 text-blue-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Diperbarui: {{ isset($page) ? $page->updated_at->format('d M Y') : date('d M Y') }}
                </div>
            </div>
        </div>
    </div>

    {{-- TAHAP 2: CONTAINER UTAMA & FOTO GEDUNG (Dinamis $page->featured_image) --}}
    <div class="relative z-20 w-full max-w-6xl mx-auto px-4 lg:px-8 -mt-24">
        
        <!-- Hero Image (Foto Gedung BPMP) -->
        <div class="relative group">
            <img src="{{ $pageFeaturedImage }}" 
                 alt="{{ $page->title ?? 'Gedung BPMP Provinsi Sulawesi Tenggara' }}" 
                 class="live-preview cursor-pointer transition-transform duration-500 hover:scale-[1.02] w-full h-auto md:h-[450px] object-cover rounded-3xl shadow-2xl border-4 border-white/20 select-none">
            <div class="absolute bottom-6 left-6 right-6 md:left-10 md:right-auto bg-slate-900/80 backdrop-blur-md text-white px-5 py-3 rounded-2xl border border-white/20 shadow-lg max-w-lg pointer-events-none">
                <p class="text-xs font-semibold tracking-wide uppercase text-blue-300">Gedung Utama BPMP Sultra</p>
                <p class="text-sm font-medium mt-0.5 text-slate-100">Jl. D.I. Panjaitan No. 83, Kelurahan Wundudopi, Baruga, Kota Kendari</p>
            </div>
        </div>

        <!-- Kartu Pengantar Lembaga -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 md:p-12 mt-10">
            <div class="flex items-center gap-3 mb-4">
                <span class="w-2.5 h-8 bg-blue-600 rounded-full"></span>
                <h2 class="text-2xl md:text-3xl font-bold text-[#112244]" style="font-family:'Plus Jakarta Sans',sans-serif;">
                    Balai Penjaminan Mutu Pendidikan Sultra
                </h2>
            </div>
            <p class="text-slate-600 leading-relaxed text-justify text-base md:text-lg">
                Balai Penjaminan Mutu Pendidikan Provinsi Sulawesi Tenggara (BPMP Sultra) merupakan Unit Pelaksana Teknis (UPT) yang beroperasi di bawah Direktorat Jenderal Pendidikan Anak Usia Dini, Pendidikan Dasar, dan Pendidikan Menengah, Kementerian Pendidikan Dasar dan Menengah (Kemendikdasmen). Keberadaan BPMP Sulawesi Tenggara adalah hasil implementasi Peraturan Mendikbudristek Nomor 11 Tahun 2022 tentang Organisasi dan Tata Kerja Balai Besar Penjaminan Mutu Pendidikan dan Balai Penjaminan Mutu Pendidikan.
            </p>
        </div>

        {{-- TAHAP 3: KARTU PROFIL PIMPINAN (GLASSMORPHISM) --}}
        <div class="text-center mt-16 mb-6">
            <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">Jajaran Manajemen</span>
            <h2 class="text-3xl font-bold text-[#112244] mt-1" style="font-family:'Plus Jakarta Sans',sans-serif;">Profil Pimpinan</h2>
            <p class="text-slate-500 text-sm mt-2 max-w-lg mx-auto">Kepemimpinan yang berintegritas, visioner, dan berkomitmen kuat terhadap mutu pendidikan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 my-10">
            <!-- Kartu Pimpinan 1: Kepala BPMP -->
            <div class="relative overflow-hidden bg-white/70 backdrop-blur-xl border border-white/50 shadow-[0_8px_30px_rgb(0,0,0,0.05)] rounded-3xl p-8 flex flex-col items-center text-center transition-transform hover:-translate-y-2">
                <div class="relative mb-5">
                    <img src="https://placehold.co/400x400/1e3a8a/ffffff?text=Junaiddin+Pagala" 
                         alt="Junaiddin Pagala, S.T., M.T." 
                         class="live-preview cursor-pointer transition-transform hover:scale-[1.02] w-48 h-48 object-cover rounded-full border-4 border-white shadow-lg mb-4 select-none">
                    <div class="absolute bottom-4 right-2 w-7 h-7 rounded-full bg-emerald-500 border-2 border-white flex items-center justify-center text-white pointer-events-none" title="Aktif">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-slate-800" style="font-family:'Plus Jakarta Sans',sans-serif;">Junaiddin Pagala, S.T., M.T.</h3>
                <span class="mt-2 px-4 py-1 bg-blue-600 text-white text-sm font-semibold rounded-full shadow-sm">Kepala BPMP</span>
                <p class="text-xs md:text-sm text-slate-500 mt-4 leading-relaxed max-w-sm">
                    Memimpin pelaksanaan penjaminan dan peningkatan mutu pendidikan anak usia dini, pendidikan dasar, pendidikan menengah, dan pendidikan masyarakat di Sulawesi Tenggara.
                </p>
            </div>

            <!-- Kartu Pimpinan 2: Kasubbag Umum -->
            <div class="relative overflow-hidden bg-white/70 backdrop-blur-xl border border-white/50 shadow-[0_8px_30px_rgb(0,0,0,0.05)] rounded-3xl p-8 flex flex-col items-center text-center transition-transform hover:-translate-y-2">
                <div class="relative mb-5">
                    <img src="https://placehold.co/400x400/0284c7/ffffff?text=Rika+Ernita+Mekuo" 
                         alt="Rika Ernita Mekuo, S.Si., M.Si." 
                         class="live-preview cursor-pointer transition-transform hover:scale-[1.02] w-48 h-48 object-cover rounded-full border-4 border-white shadow-lg mb-4 select-none">
                    <div class="absolute bottom-4 right-2 w-7 h-7 rounded-full bg-emerald-500 border-2 border-white flex items-center justify-center text-white pointer-events-none" title="Aktif">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-slate-800" style="font-family:'Plus Jakarta Sans',sans-serif;">Rika Ernita Mekuo, S.Si., M.Si.</h3>
                <span class="mt-2 px-4 py-1 bg-blue-600 text-white text-sm font-semibold rounded-full shadow-sm">Kasubbag Umum</span>
                <p class="text-xs md:text-sm text-slate-500 mt-4 leading-relaxed max-w-sm">
                    Mengkoordinasikan urusan perencanaan, keuangan, kepegawaian, tata laksana, hubungan masyarakat, persuratan, kearsipan, BMN, dan tata usaha rumah tangga lembaga.
                </p>
            </div>
        </div>

        {{-- TAHAP 4: RESTRUKTURISASI TEKS (SEJARAH, TUGAS & FUNGSI) --}}

        <!-- 1. Section Sejarah Pembentukan -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 md:p-12 mb-10">
            <h2 class="text-2xl font-bold text-[#112244] mb-6 flex items-center gap-3" style="font-family:'Plus Jakarta Sans',sans-serif;">
                <span class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <span>Sejarah Pembentukan</span>
            </h2>

            <div class="space-y-4 text-slate-600 leading-relaxed text-justify text-base">
                <p>
                    Pembentukan BPMP Provinsi Sulawesi Tenggara memiliki akar sejarah yang panjang. Dimulai dengan pendirian <strong>Balai Penataran Guru (BPG) Kendari</strong> pada tahun 1991 berdasarkan Keputusan Mendikbud Nomor 0240a/O/1991. BPG Kendari mengalami berbagai perubahan seiring berjalannya waktu, terutama setelah adanya otonomi daerah yang mempengaruhi struktur organisasi. Saat ini, kantor BPMP berlokasi strategis di Jalan D.I. Panjaitan No. 83, Kelurahan Wundudopi, Kecamatan Baruga, Kota Kendari.
                </p>
                <p>
                    Pada tahun 2003, pemerintah melakukan restrukturisasi BPG menjadi <strong>Lembaga Penjamin Mutu Pendidikan (LPMP)</strong> melalui Keputusan Mendiknas Nomor 087/O/2003 dengan mandat utama menjamin mutu pendidikan dasar dan menengah. Selanjutnya pada tahun 2007, LPMP kembali direfungsionalisasi menjadi Lembaga Penjaminan Mutu Pendidikan berdasarkan Keputusan Mendiknas Nomor 07 Tahun 2007 untuk memperkuat mutu pendidikan formal mulai dari jenjang TK/RA hingga menengah atas.
                </p>
                <p>
                    Dalam perjalanannya, institusi ini terus bertransformasi hingga akhirnya pada <strong>1 Mei 2022</strong> resmi bertransformasi menjadi <strong>Balai Penjaminan Mutu Pendidikan (BPMP)</strong>. Perubahan ini sejalan dengan Peraturan Mendikbudristek Nomor 11 Tahun 2022 yang menempatkan BPMP langsung di bawah Direktorat Jenderal Pendidikan Anak Usia Dini, Pendidikan Dasar, dan Pendidikan Menengah (Ditjen PAUD, Dikdas, dan Dikmen).
                </p>
            </div>

            <!-- Milestone Timeline Visual -->
            <div class="mt-8 pt-8 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100/80">
                    <span class="text-xs font-bold text-blue-600">Tahun 1991</span>
                    <h4 class="font-bold text-slate-800 text-sm mt-1">BPG Kendari</h4>
                    <p class="text-xs text-slate-500 mt-1">Keputusan Mendikbud No. 0240a/O/1991</p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100/80">
                    <span class="text-xs font-bold text-blue-600">Tahun 2003</span>
                    <h4 class="font-bold text-slate-800 text-sm mt-1">LPMP Sultra</h4>
                    <p class="text-xs text-slate-500 mt-1">Keputusan Mendiknas No. 087/O/2003</p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100/80">
                    <span class="text-xs font-bold text-blue-600">Tahun 2007</span>
                    <h4 class="font-bold text-slate-800 text-sm mt-1">Refungsionalisasi</h4>
                    <p class="text-xs text-slate-500 mt-1">Permendiknas No. 07 Tahun 2007</p>
                </div>
                <div class="p-4 rounded-2xl bg-blue-50/60 border border-blue-100">
                    <span class="text-xs font-bold text-blue-700">Tahun 2022 &ndash; Kini</span>
                    <h4 class="font-bold text-blue-900 text-sm mt-1">BPMP Sultra</h4>
                    <p class="text-xs text-blue-600 mt-1">Permendikbudristek No. 11 Tahun 2022</p>
                </div>
            </div>
        </div>

        <!-- 2. Section Tugas & Fungsi (Card Gradient dengan Custom Checkmark List) -->
        <div class="bg-gradient-to-br from-slate-50 to-white rounded-3xl shadow-sm border border-slate-100 p-8 md:p-12 mb-10">
            <h2 class="text-2xl font-bold text-[#112244] mb-4 flex items-center gap-3" style="font-family:'Plus Jakarta Sans',sans-serif;">
                <span class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </span>
                <span>Tugas dan Fungsi Pokok</span>
            </h2>

            <p class="text-slate-600 leading-relaxed text-base mb-8">
                Berdasarkan <strong>Pasal 6 ayat (1) Permendikbudristek Nomor 11 Tahun 2022</strong>, BPMP mempunyai mandat utama melaksanakan penjaminan dan peningkatan mutu pendidikan anak usia dini, pendidikan dasar, pendidikan menengah, dan pendidikan masyarakat di tingkat provinsi.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Item 1 -->
                <div class="flex items-start gap-3 p-4 rounded-2xl bg-white border border-slate-100 shadow-xs hover:border-blue-200 transition-colors">
                    <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm">Pemetaan Mutu Pendidikan</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Melakukan pemetaan mutu pendidikan anak usia dini, pendidikan dasar, pendidikan menengah, dan pendidikan masyarakat.</p>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="flex items-start gap-3 p-4 rounded-2xl bg-white border border-slate-100 shadow-xs hover:border-blue-200 transition-colors">
                    <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm">Pengembangan Model</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Mengembangkan model penjaminan dan peningkatan mutu pendidikan yang aplikatif dan adaptif di daerah.</p>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="flex items-start gap-3 p-4 rounded-2xl bg-white border border-slate-100 shadow-xs hover:border-blue-200 transition-colors">
                    <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm">Supervisi Penjaminan Mutu</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Melaksanakan supervisi penjaminan dan peningkatan mutu pendidikan pada satuan pendidikan dan pemerintah daerah.</p>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="flex items-start gap-3 p-4 rounded-2xl bg-white border border-slate-100 shadow-xs hover:border-blue-200 transition-colors">
                    <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm">Fasilitasi Peningkatan Mutu</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Melaksanakan pendampingan dan fasilitasi peningkatan mutu pendidikan untuk akselerasi standar nasional.</p>
                    </div>
                </div>

                <!-- Item 5 -->
                <div class="flex items-start gap-3 p-4 rounded-2xl bg-white border border-slate-100 shadow-xs hover:border-blue-200 transition-colors">
                    <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm">Kemitraan Strategis</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Mengembangkan dan mengimplementasikan kemitraan sinergis di bidang penjaminan dan peningkatan mutu pendidikan.</p>
                    </div>
                </div>

                <!-- Item 6 -->
                <div class="flex items-start gap-3 p-4 rounded-2xl bg-white border border-slate-100 shadow-xs hover:border-blue-200 transition-colors">
                    <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm">Pemantauan dan Evaluasi</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Melakukan monitoring, pemantauan berkala, serta evaluasi komprehensif atas pelaksanaan penjaminan mutu pendidikan.</p>
                    </div>
                </div>

                <!-- Item 7 (Span Full) -->
                <div class="md:col-span-2 flex items-start gap-3 p-4 rounded-2xl bg-white border border-slate-100 shadow-xs hover:border-blue-200 transition-colors">
                    <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm">Urusan Administrasi dan Tata Kelola</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Melaksanakan urusan perencanaan, persuratan, tata usaha, kepegawaian, keuangan, dan rumah tangga pendukung seluruh fungsi teknis.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Section Ruang Lingkup Wilayah Kerja & Statistik SDM -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 md:p-12 mb-10">
            <h2 class="text-2xl font-bold text-[#112244] mb-6 flex items-center gap-3" style="font-family:'Plus Jakarta Sans',sans-serif;">
                <span class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <span>Ruang Lingkup Wilayah Kerja</span>
            </h2>

            <p class="text-slate-600 leading-relaxed text-justify text-base mb-8">
                Wilayah kerja BPMP Sulawesi Tenggara mencakup <strong>15 kabupaten dan 2 kota</strong> dengan total 219 kecamatan, 377 kelurahan, 1.915 desa, dan melayani <strong>6.493 satuan pendidikan</strong> (PAUD, SD, SMP, SMA, SMK, dan SLB), mencakup <strong>675.594 peserta didik</strong> serta <strong>60.533 guru</strong>.
            </p>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="p-5 rounded-2xl bg-blue-50/70 border border-blue-100 text-center">
                    <span class="text-3xl font-extrabold text-blue-700">17</span>
                    <span class="block text-xs font-semibold text-slate-600 mt-1 uppercase tracking-wider">Kabupaten / Kota</span>
                </div>
                <div class="p-5 rounded-2xl bg-sky-50/70 border border-sky-100 text-center">
                    <span class="text-3xl font-extrabold text-sky-700">6.493</span>
                    <span class="block text-xs font-semibold text-slate-600 mt-1 uppercase tracking-wider">Satuan Pendidikan</span>
                </div>
                <div class="p-5 rounded-2xl bg-indigo-50/70 border border-indigo-100 text-center">
                    <span class="text-3xl font-extrabold text-indigo-700">60.533</span>
                    <span class="block text-xs font-semibold text-slate-600 mt-1 uppercase tracking-wider">Total Guru</span>
                </div>
                <div class="p-5 rounded-2xl bg-emerald-50/70 border border-emerald-100 text-center">
                    <span class="text-3xl font-extrabold text-emerald-700">675k+</span>
                    <span class="block text-xs font-semibold text-slate-600 mt-1 uppercase tracking-wider">Peserta Didik</span>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100">
                <h3 class="text-lg font-bold text-slate-800 mb-3">Distribusi Jabatan Aparatur Sipil Negara (103 ASN)</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-xs">
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="font-bold text-slate-800">21 Orang (27,3%)</span>
                        <p class="text-slate-500 mt-0.5">Tenaga Fungsional/Widyaprada</p>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="font-bold text-slate-800">21 Orang (27,3%)</span>
                        <p class="text-slate-500 mt-0.5">Penelaah Teknis Kebijakan</p>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="font-bold text-slate-800">20 Orang (26,0%)</span>
                        <p class="text-slate-500 mt-0.5">Pengolah Data & Informasi</p>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="font-bold text-slate-800">8 Orang (10,4%)</span>
                        <p class="text-slate-500 mt-0.5">Pengadministrasi Perkantoran</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Section Kepemimpinan dari Masa ke Masa -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 md:p-12 mb-10">
            <h2 class="text-2xl font-bold text-[#112244] mb-6 flex items-center gap-3" style="font-family:'Plus Jakarta Sans',sans-serif;">
                <span class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </span>
                <span>Kepemimpinan dari Masa ke Masa</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 text-xs">
                @php
                    $pemimpin = [
                        ['Drs. Zainuddin Baso', '1992 – 1995', 'Kepala BPG Kendari'],
                        ['Drs. H. Azis Tondrang', '1996 – 2000', 'Kepala BPG Kendari'],
                        ['Drs. Muh. Kalar', '2000 – 2002', 'Kepala BPG Kendari'],
                        ['Drs. H. Rafiuddin Dihiru, M.Pd.', '2002 – 2007', 'Kepala LPMP Sultra'],
                        ['Dr. Drs. Harizal, M.Pd.', '2007 – 2008', 'Kepala LPMP Sultra'],
                        ['Drs. Bambang Tawaldi, M.Pd.', '2008 – 2013', 'Kepala LPMP Sultra'],
                        ['Prof. Dr. H. Hanna, M.Pd.', '2013 – 2016', 'Kepala LPMP Sultra'],
                        ['Drs. Idham, M.Si.', '2016 – Okt 2020', 'Kepala LPMP Sultra'],
                        ['Drs. Sakkang, M.Pd.', 'Jan 2021 – Apr 2022', 'Kepala LPMP Sultra'],
                        ['Dr. H. Moh. Askari, S.H., M.Si.', 'Mei 2022 – Nov 2023', 'Kepala BPMP Sultra'],
                        ['Junaiddin Pagala, S.T., M.T.', 'Des 2023 – Sekarang', 'Kepala BPMP Sultra (Petahana)', true],
                    ];
                @endphp

                @foreach($pemimpin as $p)
                    <div class="p-3.5 rounded-2xl {{ !empty($p[3]) ? 'bg-blue-600 text-white shadow-md' : 'bg-slate-50 border border-slate-100 text-slate-700' }}">
                        <span class="block text-[11px] font-semibold {{ !empty($p[3]) ? 'text-blue-100' : 'text-blue-600' }}">{{ $p[1] }}</span>
                        <h4 class="font-bold text-sm mt-0.5 {{ !empty($p[3]) ? 'text-white' : 'text-slate-800' }}">{{ $p[0] }}</h4>
                        <span class="text-[11px] block mt-1 {{ !empty($p[3]) ? 'text-blue-200' : 'text-slate-500' }}">{{ $p[2] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- TAHAP 5: INFOGRAFIS & FOTO BERSAMA --}}

        <!-- 1. Infografis Kepegawaian (Section Khusus Background Transparan) -->
        <div class="my-14">
            <div class="text-center mb-6">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">Informasi Visual</span>
                <h2 class="text-2xl md:text-3xl font-bold text-[#112244] mt-1" style="font-family:'Plus Jakarta Sans',sans-serif;">Infografis Kepegawaian</h2>
                <p class="text-slate-500 text-sm mt-1 max-w-md mx-auto">Visualisasi sebaran komposisi aparatur dan kompetensi pegawai BPMP Sultra.</p>
            </div>
            
            <div class="bg-white/80 backdrop-blur-md rounded-3xl p-4 md:p-6 shadow-sm border border-slate-100 flex justify-center">
                <img src="https://placehold.co/1200x600/f8fafc/0284c7?text=Infografis+Profil+Kepegawaian+BPMP+Sultra" 
                     alt="Infografis Kepegawaian BPMP Sultra" 
                     class="live-preview cursor-pointer transition-transform hover:scale-[1.02] w-full rounded-2xl shadow-lg border border-slate-100 object-cover max-h-[550px] select-none">
            </div>
        </div>

        <!-- 2. Foto Bersama Staf (Paling Bawah Sebelum Footer) -->
        <div class="my-16 text-center">
            <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">Keluarga Besar BPMP Sultra</span>
            <h2 class="text-2xl md:text-3xl font-bold text-[#112244] mt-1 mb-6" style="font-family:'Plus Jakarta Sans',sans-serif;">Foto Bersama Staf &amp; Pimpinan</h2>
            <div class="flex justify-center">
                <img src="{{ asset('fotoheader/slide2.png') }}" 
                     alt="Foto Bersama Staf BPMP Sultra" 
                     class="live-preview cursor-pointer transition-transform hover:scale-[1.02] w-full max-w-4xl mx-auto rounded-3xl shadow-xl border-8 border-white object-cover select-none">
            </div>
            <p class="text-xs text-slate-500 mt-4 max-w-lg mx-auto">Bersama melayani, mendampingi, dan memastikan mutu pendidikan berkualitas bagi seluruh insan pendidikan di Bumi Anoa.</p>
        </div>

    </div>

    <!-- LIVE PREVIEW MODAL GLASSMORPHISM -->
    <div id="image-preview-modal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/40 backdrop-blur-md opacity-0 pointer-events-none transition-all duration-300">
        <img id="image-preview-src" src="" class="max-w-[90vw] max-h-[90vh] object-contain rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.3)] border border-white/20 scale-95 transition-transform duration-300" alt="Live Preview">
    </div>

    <!-- LIVE PREVIEW JAVASCRIPT LOGIC (LONG PRESS / HOLD) -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        let pressTimer;
        const modal = document.getElementById('image-preview-modal');
        const modalImg = document.getElementById('image-preview-src');
        // Pilih semua gambar dengan class .live-preview atau gambar di dalam konten CMS
        const images = document.querySelectorAll('.live-preview, .page-content img');

        const showModal = (src) => {
            modalImg.src = src;
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100');
            modalImg.classList.remove('scale-95');
            modalImg.classList.add('scale-100');
        };

        const hideModal = () => {
            clearTimeout(pressTimer);
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0', 'pointer-events-none');
            modalImg.classList.remove('scale-100');
            modalImg.classList.add('scale-95');
        };

        images.forEach(img => {
            // Otomatis pastikan class live-preview terpasang
            img.classList.add('live-preview', 'cursor-pointer');

            // Event untuk Mouse (Desktop)
            img.addEventListener('mousedown', (e) => {
                if (e.button === 0) { // Hanya klik kiri
                    pressTimer = setTimeout(() => showModal(e.target.src), 400); // Muncul setelah ditahan 0.4 detik
                }
            });
            img.addEventListener('mouseup', hideModal);
            img.addEventListener('mouseleave', hideModal);

            // Event untuk Touch (Mobile/Tablet)
            img.addEventListener('touchstart', (e) => {
                pressTimer = setTimeout(() => showModal(e.target.src), 400);
            });
            img.addEventListener('touchend', hideModal);
            img.addEventListener('touchcancel', hideModal);
            
            // Mencegah menu klik kanan/drag bawaan browser agar fitur klik-tahan mulus
            img.addEventListener('contextmenu', (e) => e.preventDefault());
            img.addEventListener('dragstart', (e) => e.preventDefault());
        });
    });
    </script>
    @endif

    {{-- FOOTER GLOBAL --}}
    <x-footer />

</body>
</html>
