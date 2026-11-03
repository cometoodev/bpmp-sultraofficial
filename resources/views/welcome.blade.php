<!DOCTYPE html>
<html lang="id" class="scroll-smooth overflow-x-hidden w-full max-w-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BPMP Provinsi Sulawesi Tenggara</title>
    <!-- 2. Favicon -->
    <link rel="icon" href="{{ asset('tutwurihandayani.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- 5. Font Family: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Family: Plus Jakarta Sans for Hero -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- 6. Alpine.js for Background Slider & Collapse -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Mengaktifkan native smooth scrolling pada seluruh halaman */
        html {
            scroll-behavior: smooth;
        }

        /* Meredam loncatan scroll yang terlalu sensitif pada touchpad */
        body { 
            font-family: 'Poppins', sans-serif; 
            -webkit-overflow-scrolling: touch;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
    </style>
</head>
<body class="bg-slate-900 text-white antialiased overflow-x-hidden w-full max-w-full selection:bg-blue-600 selection:text-white">

    <!-- 4. Glassmorphism Navbar (Fixed to top to overlay Hero) -->
    <x-navbar />

    @php
        $heroBackground = asset('fotoheader/slide1.png');
        if (isset($banners) && $banners->isNotEmpty()) {
            foreach ($banners as $b) {
                if (!empty($b->image) && \Illuminate\Support\Str::startsWith($b->image, ['http://', 'https://'])) {
                    $heroBackground = $b->image;
                    break;
                } elseif (!empty($b->image) && file_exists(public_path('storage/' . ltrim($b->image, '/')))) {
                    $heroBackground = asset('storage/' . ltrim($b->image, '/'));
                    break;
                }
            }
        }
    @endphp

    <!-- HERO SECTION -->
    <!-- bg-cover dan bg-no-repeat WAJIB ada agar gambar utuh 1 layar -->
    <section class="relative w-full h-screen bg-cover bg-center bg-no-repeat overflow-hidden" style="background-image: url('{{ $heroBackground }}');">
        
        <!-- 1. OVERLAY GRADIENT BIRU -->
        <!-- z-0 agar berada di bawah teks tapi di atas gambar -->
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/95 via-blue-800/80 to-slate-900/20 z-0"></div>

        <!-- 2. KONTEN UTAMA (TEKS & LOGO) -->
        <!-- z-10 agar berada di atas overlay. pt-20 pb-16 md:pb-20 -->
        <div class="relative z-10 container mx-auto h-full flex flex-col justify-center px-6 lg:px-16 pt-20 pb-16 md:pb-20">
            <div class="flex flex-col lg:flex-row items-center justify-between w-full">
                
                <!-- KIRI: TEKS (Rata Kiri) -->
                <div class="w-full lg:w-3/5 flex flex-col items-start text-left">
                    <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white text-xs font-semibold mb-6">
                        Kemendikdasmen • BPMP Sulawesi Tenggara
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight tracking-tight drop-shadow-lg uppercase">
                        BALAI PENJAMINAN<br>MUTU PENDIDIKAN
                    </h1>
                    <h2 class="text-2xl lg:text-3xl font-semibold text-white mt-3 drop-shadow-md">
                        Provinsi Sulawesi Tenggara
                    </h2>
                    <p class="text-gray-200 text-sm md:text-base mt-6 max-w-xl leading-relaxed">
                        Pusat penjaminan mutu dan referensi pendidikan berkualitas Provinsi Sulawesi Tenggara untuk mendorong transformasi pembelajaran yang berkeadilan di Bumi Anoa.
                    </p>
                    
                    <!-- TOMBOL AKSI -->
                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="#layanan" class="flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-full transition-all shadow-lg shadow-blue-900/50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            Jelajahi Layanan
                        </a>
                        <a href="{{ route('guestbook.create') }}" class="flex items-center gap-2 px-6 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white font-semibold rounded-full transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            Buku Tamu
                        </a>
                    </div>

                    <!-- SMART SEARCH BAR (GLASSMORPHISM) -->
                    <div class="relative group mt-8 md:mt-10 flex justify-start w-full">
                        <div class="absolute inset-0 bg-white/20 rounded-full blur-xl scale-105 opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none w-72 md:w-96"></div>
                        <div class="relative flex items-center bg-white/70 hover:bg-white/85 backdrop-blur-xl border border-white/80 shadow-[0_8px_30px_rgb(0,0,0,0.15)] rounded-full px-2 py-1.5 transition-all duration-500 ease-out w-full max-w-[18rem] md:max-w-md focus-within:max-w-xl overflow-hidden cursor-text ring-4 ring-white/20">
                            <div class="flex-shrink-0 p-2.5 text-blue-600 bg-white/90 rounded-full shadow-sm ml-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="text" id="hero-typewriter-input" class="w-full bg-transparent border-none outline-none focus:ring-0 px-4 text-slate-800 placeholder-slate-600 font-semibold text-sm md:text-base transition-all" placeholder="">
                        </div>
                    </div>
                </div>

                <!-- KANAN: LOGO -->
                <div class="w-full lg:w-2/5 flex justify-center lg:justify-end items-center mt-12 lg:mt-0 hidden md:flex">
                    <div class="w-64 h-64 lg:w-80 lg:h-80 rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center shadow-2xl p-8">
                        <!-- Ganti src dengan path logo Tut Wuri Handayani yang benar -->
                        <img src="{{ asset('tutwurihandayani.png') }}" alt="Logo BPMP" class="w-full h-full object-contain drop-shadow-xl">
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- SECTION 2: PROFIL KAMI & PIMPINAN -->
    <section class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Profil Kami (Redesigned) -->
            <!-- 1. TOP HEADER AREA -->
            <div class="flex flex-col md:flex-row justify-between items-end mb-12">
                <!-- Left Side -->
                <div>
                    <div class="bg-blue-50 text-blue-600 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v2m0 16v2m10-10h-2M4 12H2m15.364 7.364l-1.414-1.414M7.05 7.05L5.636 5.636m12.728 0l-1.414 1.414M7.05 16.95l-1.414 1.414"></path></svg>
                        PROFIL KAMI
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-4">Tentang BPMP Provinsi Sulawesi Tenggara</h2>
                    <div class="w-16 h-1.5 bg-blue-600 rounded-full mt-3"></div>
                </div>
                <!-- Right Side -->
                <p class="text-gray-500 text-sm max-w-xs text-left md:text-right hidden md:block">
                    Pelajari profil, sejarah, dan visi misi BPMP Provinsi Sulawesi Tenggara.
                </p>
            </div>

            <!-- 2. MAIN CONTENT GRID -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-20">
                <!-- 3. LEFT COLUMN (Interactive Circular Logo) -->
                <div>
                    <div class="w-72 h-72 md:w-80 md:h-80 rounded-full bg-white shadow-2xl border-[10px] border-gray-50 flex items-center justify-center relative mx-auto hover:scale-105 transition-transform duration-500">
                        <img src="{{ asset('tutwurihandayani.png') }}" alt="Logo Tut Wuri Handayani" class="w-48 h-48 object-contain drop-shadow-xl hover:rotate-3 transition-transform duration-300">
                    </div>
                </div>

                <!-- 4. RIGHT COLUMN (Text & Feature List) -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Balai Penjaminan Mutu Pendidikan Sultra</h3>
                    <p class="text-gray-600 leading-relaxed mb-8">
                        Balai Penjaminan Mutu Pendidikan (BPMP) Provinsi Sulawesi Tenggara adalah unit pelaksana teknis Kementerian Pendidikan Dasar dan Menengah yang memiliki tugas mulia untuk mengawal, memfasilitasi, dan meningkatkan mutu pendidikan di wilayah Sulawesi Tenggara.
                    </p>
                    
                    <div class="space-y-6">
                        <!-- Item 1 -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Pelayanan Sepenuh Hati</h4>
                                <p class="text-sm text-gray-500 mt-1">Sikap melayani dengan tulus dan berdedikasi tinggi.</p>
                            </div>
                        </div>

                        <!-- Item 2 -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Zona Integritas WBK</h4>
                                <p class="text-sm text-gray-500 mt-1">Berkomitmen bebas dari korupsi dan birokrasi bersih.</p>
                            </div>
                        </div>

                        <!-- Item 3 -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Profil Pelajar Pancasila</h4>
                                <p class="text-sm text-gray-500 mt-1">Mewujudkan generasi cerdas, berkarakter, dan inovatif.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profil Pimpinan -->
            @php
                $leader1Name = $settings['leader_1_name'] ?? 'Junaiddin Pagala, S.T., M.T.';
                $leader1Pos = $settings['leader_1_position'] ?? 'KEPALA BPMP PROVINSI SULAWESI TENGGARA';
                $leader1Photo = !empty($settings['leader_1_photo']) 
                    ? (\Illuminate\Support\Str::startsWith($settings['leader_1_photo'], 'http') ? $settings['leader_1_photo'] : asset('storage/' . ltrim($settings['leader_1_photo'], '/')))
                    : 'https://ui-avatars.com/api/?name=' . urlencode($leader1Name) . '&background=1e3a8a&color=fff&size=500';

                $leader2Name = $settings['leader_2_name'] ?? 'Rika Ernita Mekuo, S.Si., M.Si.';
                $leader2Pos = $settings['leader_2_position'] ?? 'KASUBBAG UMUM BPMP SULTRA';
                $leader2Photo = !empty($settings['leader_2_photo']) 
                    ? (\Illuminate\Support\Str::startsWith($settings['leader_2_photo'], 'http') ? $settings['leader_2_photo'] : asset('storage/' . ltrim($settings['leader_2_photo'], '/')))
                    : 'https://ui-avatars.com/api/?name=' . urlencode($leader2Name) . '&background=1e3a8a&color=fff&size=500';

                $leaderQuote = $settings['leader_quote'] ?? 'Berkomitmen penuh mewujudkan Zona Integritas Wilayah Bebas dari Korupsi (ZI WBK) dan Pelayanan Prima bagi seluruh insan pendidikan serta mendukung tata kelola organisasi yang transparan dan akuntabel.';
                $leaderQuoteAuthor = $settings['leader_quote_author'] ?? 'Pimpinan BPMP Provinsi Sulawesi Tenggara';
                $leaderSecTitle = $settings['leader_section_title'] ?? 'Profil Pimpinan';
                $leaderSecSubtitle = $settings['leader_section_subtitle'] ?? 'Mengenal jajaran kepemimpinan yang berdedikasi mengawal penjaminan dan peningkatan mutu pendidikan di Sulawesi Tenggara.';
            @endphp
            <div class="pt-6">
                <!-- Divider -->
                <div class="w-[100vw] relative left-1/2 -translate-x-1/2 border-t border-blue-500/20 dark:border-blue-400/20 my-10"></div>
                
                <!-- Section Header -->
                <div class="text-center mb-12">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 font-bold tracking-wider text-xs uppercase mb-3 border border-blue-200 shadow-sm">
                        Struktur Organisasi
                    </span>
                    <h2 class="font-display text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
                        {{ $leaderSecTitle }} <span class="text-blue-600">BPMP Sultra</span>
                    </h2>
                    <div class="w-20 h-1.5 bg-blue-600 mx-auto rounded-full mb-4"></div>
                    <p class="text-gray-500 max-w-2xl mx-auto leading-relaxed">
                        {{ $leaderSecSubtitle }}
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-3xl mx-auto">
                    
                    <!-- Kartu 1 -->
                    <div class="w-full max-w-[300px] mx-auto bg-white rounded-[2rem] shadow-[0_8px_30px_rgba(0,0,0,0.08)] border border-gray-100 overflow-hidden flex flex-col transition-transform duration-300 hover:-translate-y-2">
                        <img src="{{ $leader1Photo }}" alt="{{ $leader1Name }}" class="w-full h-80 object-cover rounded-t-[2rem] bg-blue-900">
                        <div class="p-6 text-center bg-white">
                            <h3 class="text-base font-bold text-gray-900">{{ $leader1Name }}</h3>
                            <p class="text-xs uppercase text-blue-600 font-bold mt-1 tracking-wider">{{ $leader1Pos }}</p>
                        </div>
                    </div>

                    <!-- Kartu 2 -->
                    <div class="w-full max-w-[300px] mx-auto bg-white rounded-[2rem] shadow-[0_8px_30px_rgba(0,0,0,0.08)] border border-gray-100 overflow-hidden flex flex-col transition-transform duration-300 hover:-translate-y-2">
                        <img src="{{ $leader2Photo }}" alt="{{ $leader2Name }}" class="w-full h-80 object-cover rounded-t-[2rem] bg-blue-900">
                        <div class="p-6 text-center bg-white">
                            <h3 class="text-base font-bold text-gray-900">{{ $leader2Name }}</h3>
                            <p class="text-xs uppercase text-blue-600 font-bold mt-1 tracking-wider">{{ $leader2Pos }}</p>
                        </div>
                    </div>
                    
                </div>
                
                <!-- The Quote Box -->
                <div class="max-w-4xl mx-auto mt-8 bg-slate-50 border border-gray-200 rounded-3xl p-8 flex flex-col sm:flex-row gap-6 items-start shadow-sm">
                    <div class="text-blue-200 text-6xl font-serif leading-none mt-2">"</div>
                    <div>
                        <p class="italic text-gray-700 leading-relaxed text-lg">{{ $leaderQuote }}</p>
                        <span class="font-bold text-gray-900 text-sm mt-4 block">{{ $leaderQuoteAuthor }}</span>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

    <!-- 4. Layanan & Aplikasi Internal (The Icon Grid) -->
    <section id="layanan" class="pt-32 pb-20 bg-slate-50 relative z-10">
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-blue-600 font-bold tracking-wider text-sm uppercase mb-2 block">Akses Cepat</span>
                <h2 class="font-display text-3xl md:text-4xl font-extrabold text-blue-900 mb-4">Layanan & Aplikasi <span class="text-blue-600">Internal</span></h2>
                <div class="w-20 h-1.5 bg-blue-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-7xl mx-auto">
                <!-- Card 1: SINONGGI -->
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 hover:shadow-xl transition-all flex flex-col items-center text-center h-full">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-5 bg-blue-50 text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-gray-800 mb-2">SINONGGI</h3>
                    <p class="text-sm text-gray-500 font-medium mb-6">Sistem Informasi Online BPMP Sultra.</p>
                    <a href="#" class="mt-auto inline-flex items-center gap-2 border px-5 py-2 rounded-full text-sm font-semibold transition-colors border-blue-600 text-blue-600 hover:bg-blue-50">
                        Buka Aplikasi &rarr;
                    </a>
                </div>

                <!-- Card 2: LAPOR! -->
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 hover:shadow-xl transition-all flex flex-col items-center text-center h-full">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-5 bg-red-50 text-red-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-gray-800 mb-2">LAPOR!</h3>
                    <p class="text-sm text-gray-500 font-medium mb-6">SP4N Lapor - Layanan Aspirasi dan Pengaduan.</p>
                    <a href="#" class="mt-auto inline-flex items-center gap-2 border px-5 py-2 rounded-full text-sm font-semibold transition-colors border-red-600 text-red-600 hover:bg-red-50">
                        Buat Laporan &rarr;
                    </a>
                </div>

                <!-- Card 3: Unit Layanan Terpadu -->
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 hover:shadow-xl transition-all flex flex-col items-center text-center h-full">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-5 bg-purple-50 text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-gray-800 mb-2">Unit Layanan Terpadu</h3>
                    <p class="text-sm text-gray-500 font-medium mb-6">Layanan informasi dan pengaduan terpadu satu pintu.</p>
                    <a href="#" class="mt-auto inline-flex items-center gap-2 border px-5 py-2 rounded-full text-sm font-semibold transition-colors border-purple-600 text-purple-600 hover:bg-purple-50">
                        Akses Layanan &rarr;
                    </a>
                </div>

                <!-- Card 4: Rumah Pendidikan -->
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 hover:shadow-xl transition-all flex flex-col items-center text-center h-full">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-5 bg-green-50 text-green-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-gray-800 mb-2">Rumah Pendidikan</h3>
                    <p class="text-sm text-gray-500 font-medium mb-6">Portal edukasi dan informasi daerah Sulawesi Tenggara.</p>
                    <a href="#" class="mt-auto inline-flex items-center gap-2 border px-5 py-2 rounded-full text-sm font-semibold transition-colors border-green-600 text-green-600 hover:bg-green-50">
                        Eksplorasi &rarr;
                    </a>
                </div>

                <!-- Card 5: Konsultasi Online -->
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 hover:shadow-xl transition-all flex flex-col items-center text-center h-full">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-5 bg-orange-50 text-orange-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-gray-800 mb-2">Konsultasi Online</h3>
                    <p class="text-sm text-gray-500 font-medium mb-6">Layanan konsultasi virtual untuk publik dan instansi.</p>
                    <a href="#" class="mt-auto inline-flex items-center gap-2 border px-5 py-2 rounded-full text-sm font-semibold transition-colors border-orange-500 text-orange-500 hover:bg-orange-50">
                        Mulai Konsultasi &rarr;
                    </a>
                </div>

                <!-- Card 6: Peminjaman Sarpras -->
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 hover:shadow-xl transition-all flex flex-col items-center text-center h-full">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-5 bg-teal-50 text-teal-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-gray-800 mb-2">Peminjaman Sarpras</h3>
                    <p class="text-sm text-gray-500 font-medium mb-6">Layanan peminjaman fasilitas, sarana dan prasarana BPMP.</p>
                    <a href="#" class="mt-auto inline-flex items-center gap-2 border px-5 py-2 rounded-full text-sm font-semibold transition-colors border-teal-600 text-teal-600 hover:bg-teal-50">
                        Ajukan Peminjaman &rarr;
                    </a>
                </div>

                <!-- Card 7: OMSABRI -->
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 hover:shadow-xl transition-all flex flex-col items-center text-center h-full">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-5 bg-indigo-50 text-indigo-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-gray-800 mb-2">OMSABRI</h3>
                    <p class="text-sm text-gray-500 font-medium mb-6">Online Management Sistem Aset Barang dengan Rekam Identitas.</p>
                    <a href="#" class="mt-auto inline-flex items-center gap-2 border px-5 py-2 rounded-full text-sm font-semibold transition-colors border-indigo-600 text-indigo-600 hover:bg-indigo-50">
                        Akses Sistem &rarr;
                    </a>
                </div>

                <!-- Card 8: SIPPN -->
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 hover:shadow-xl transition-all flex flex-col items-center text-center h-full">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-5 bg-pink-50 text-pink-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-gray-800 mb-2">SIPPN</h3>
                    <p class="text-sm text-gray-500 font-medium mb-6">Sistem Informasi Pelayanan Publik Nasional.</p>
                    <a href="#" class="mt-auto inline-flex items-center gap-2 border px-5 py-2 rounded-full text-sm font-semibold transition-colors border-pink-600 text-pink-600 hover:bg-pink-50">
                        Buka SIPPN &rarr;
                    </a>
                </div>

                <!-- Card 9: Goes To School -->
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 hover:shadow-xl transition-all flex flex-col items-center text-center h-full">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-5 bg-sky-50 text-sky-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-gray-800 mb-2">Goes To School</h3>
                    <p class="text-sm text-gray-500 font-medium mb-6">Kunjungan edukasi sekolah membangun kebersamaan dan karakter.</p>
                    <a href="#" class="mt-auto inline-flex items-center gap-2 border px-5 py-2 rounded-full text-sm font-semibold transition-colors border-sky-600 text-sky-600 hover:bg-sky-50">
                        Lihat Program &rarr;
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================== -->
    <!-- SECTION MAKLUMAT PELAYANAN & PENGHARGAAN (AUTO-SLIDER & POP-UP) -->
    <!-- ========================================================== -->
    <section id="maklumat-penghargaan" class="w-full py-16 bg-white relative overflow-hidden" 
         x-data="{
            activeModal: false,
            modalData: { title: '', desc: '', image: '', badge: '' },
            currentIndex: 0,
            autoSlideInterval: null,
            
            initSlide() {
                clearInterval(this.autoSlideInterval);
                this.autoSlideInterval = setInterval(() => {
                    const container = document.getElementById('awardsSlider');
                    if (!container) return;
                    
                    this.currentIndex++;
                    const maxIndex = Math.max(0, container.children.length - 2);
                    if (this.currentIndex > maxIndex) {
                        this.currentIndex = 0;
                    }
                    
                    container.scrollTo({
                        left: this.currentIndex * 390,
                        behavior: 'smooth'
                    });
                }, 4000);
            },

            manualScroll(direction) {
                const container = document.getElementById('awardsSlider');
                if (!container) return;
                const maxIndex = Math.max(0, container.children.length - 2);
                if (direction === 'next') {
                    this.currentIndex++;
                    if (this.currentIndex > maxIndex) this.currentIndex = 0;
                } else {
                    this.currentIndex--;
                    if (this.currentIndex < 0) this.currentIndex = maxIndex;
                }
                container.scrollTo({
                    left: this.currentIndex * 390,
                    behavior: 'smooth'
                });
            },

            openModal(title, desc, image, badge) {
                this.modalData = { title, desc, image, badge };
                this.activeModal = true;
            }
         }" 
         x-init="initSlide()">

        <div style="width: 100%; max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; display: flex; flex-direction: column; gap: 2.5rem;">

            <!-- Header Section -->
            <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1.5rem;">
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="color: #4f46e5; width: 2.5rem; height: 2.5rem; display: flex; align-items: center; justify-content: center;">
                            <svg style="width: 2rem; height: 2rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                        <h2 style="color: #0f172a; font-weight: 900; font-size: clamp(1.75rem, 3vw, 2.5rem); margin: 0; letter-spacing: -0.02em;">
                            Maklumat Pelayanan &amp; Penghargaan
                        </h2>
                    </div>
                    <div style="width: 3.5rem; height: 0.3rem; background-color: #eab308; border-radius: 9999px; margin-bottom: 0.25rem;"></div>
                    <p style="color: #64748b; font-size: 0.95rem; margin: 0; font-weight: 500;">
                        Komitmen mutu pelayanan publik serta dokumentasi prestasi dan penghargaan BPMP Provinsi Sulawesi Tenggara.
                    </p>
                </div>

                <!-- Tombol Navigasi Slider -->
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <button type="button" @click="manualScroll('prev')" aria-label="Sebelumnya" class="w-10 h-10 rounded-full bg-white border border-slate-200 text-slate-700 flex items-center justify-center shadow-md hover:bg-slate-50 hover:text-indigo-600 transition-all cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button type="button" @click="manualScroll('next')" aria-label="Selanjutnya" class="w-10 h-10 rounded-full bg-white border border-slate-200 text-slate-700 flex items-center justify-center shadow-md hover:bg-slate-50 hover:text-indigo-600 transition-all cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            <!-- Wadah Slider Kartu Penghargaan (Lebih Kompak & Variasi Warna Badge) -->
            <div id="awardsSlider" @mouseenter="clearInterval(autoSlideInterval)" @mouseleave="initSlide()" style="display: flex; gap: 2rem; overflow-x: auto; scroll-behavior: smooth; padding: 1rem 0.25rem; scrollbar-width: none;">
                @forelse($awards ?? [] as $item)
                    @php
                        // Menentukan warna badge secara otomatis berdasarkan teks/kategori
                        $badgeColor = '#2563eb'; // Default Biru (Kemendikdasmen dsb)
                        $badgeText = strtolower($item->badge);
                        if (str_contains($badgeText, 'kemenkeu')) {
                            $badgeColor = '#059669'; // Hijau Zamrud
                        } elseif (str_contains($badgeText, 'djkn')) {
                            $badgeColor = '#d97706'; // Amber / Oranye
                        } elseif (str_contains($badgeText, 'maklumat')) {
                            $badgeColor = '#7c3aed'; // Ungu / Indigo
                        } elseif (str_contains($badgeText, 'informasi') || str_contains($badgeText, 'kip')) {
                            $badgeColor = '#0284c7'; // Biru Langit / Sky Blue
                        } elseif (str_contains($badgeText, 'pusat') || str_contains($badgeText, 'utama')) {
                            $badgeColor = '#dc2626'; // Merah
                        }

                        $awardImage = $item->image ? asset('storage/' . $item->image) : 'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?w=800';
                    @endphp

                    <div @click="openModal('{{ addslashes($item->title) }}', '{{ addslashes($item->description) }}', '{{ $awardImage }}', '{{ addslashes($item->badge) }}')" 
                         class="group cursor-pointer hover:shadow-2xl hover:-translate-y-2 transition-all duration-300" 
                         style="min-width: calc(33.333% - 1.35rem); max-width: calc(33.333% - 1.35rem); flex: 0 0 calc(33.333% - 1.35rem); background: white; border: 1px solid #e2e8f0; border-radius: 1.75rem; padding: 1.25rem; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.03); display: flex; flex-direction: column; gap: 1rem;">
                        
                        <!-- Gambar Poster/Piagam Lebih Kompak (Tinggi 180px) -->
                        <div style="width: 100%; height: 180px; border-radius: 1rem; overflow: hidden; background: #f1f5f9; position: relative;">
                            <img src="{{ $awardImage }}" alt="{{ $item->title }}" class="group-hover:scale-105 transition-transform duration-500" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?w=800'">
                            
                            <!-- Badge Kategori dengan Warna Dinamis -->
                            <span style="position: absolute; top: 10px; left: 10px; background: {{ $badgeColor }}; color: white; padding: 0.25rem 0.65rem; border-radius: 9999px; font-weight: 700; font-size: 0.65rem; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                                {{ $item->badge }}
                            </span>
                            
                            <!-- Efek Tombol Lihat Detail saat Hover -->
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none" style="position: absolute; inset: 0; background: rgba(0,0,0,0.4); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center;">
                                <span style="background: white; color: #1e293b; padding: 0.5rem 1rem; border-radius: 9999px; font-weight: 800; font-size: 0.8rem; box-shadow: 0 10px 20px rgba(0,0,0,0.2);">🔍 Lihat Detail</span>
                            </div>
                        </div>

                        <!-- Bagian Teks Ringkas -->
                        <div style="display: flex; flex-direction: column; gap: 0.4rem; flex-grow: 1;">
                            <h3 style="color: #1e293b; font-weight: 900; font-size: 1rem; margin: 0; line-height: 1.35; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;">{{ $item->title }}</h3>
                            <p style="color: #64748b; font-size: 0.8rem; line-height: 1.4; margin: 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $item->description }}</p>
                        </div>

                        <!-- Footer Card -->
                        <div style="border-top: 1px solid #f1f5f9; padding-top: 0.75rem; display: flex; align-items: center; justify-content: space-between; color: #4f46e5; font-weight: 800; font-size: 0.8rem;">
                            <span>Klik untuk melihat keterangan lengkap</span>
                            <span>&rarr;</span>
                        </div>
                    </div>
                @empty
                    <div style="width: 100%; text-align: center; padding: 3rem; color: #94a3b8; font-size: 0.95rem;">
                        Belum ada data maklumat pelayanan atau penghargaan.
                    </div>
                @endforelse
            </div>

        </div>

        <!-- ========================================== -->
        <!-- POP-UP MODAL KETIKA CARD DIKLIK -->
        <!-- ========================================== -->
        <template x-teleport="body">
            <div x-show="activeModal" class="fixed inset-0 z-[99999] flex items-center justify-center p-4" style="display: none;">
                <!-- Backdrop Blur -->
                <div x-show="activeModal" x-transition.opacity class="absolute inset-0 bg-slate-950/80 backdrop-blur-md" @click="activeModal = false"></div>
                
                <!-- Konten Pop-up Card -->
                <div x-show="activeModal" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-90 translate-y-4"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     class="relative bg-slate-900 border border-slate-700 rounded-3xl shadow-2xl max-w-2xl w-full overflow-hidden flex flex-col z-10">
                    
                    <!-- Tombol Close (X) -->
                    <button type="button" @click="activeModal = false" class="absolute top-4 right-4 z-20 w-9 h-9 rounded-full bg-slate-800/80 text-white flex items-center justify-center hover:bg-red-600 transition-colors cursor-pointer">
                        ✕
                    </button>

                    <!-- Gambar Piagam Utuh -->
                    <div class="w-full max-h-[60vh] bg-black/60 overflow-hidden flex items-center justify-center p-3">
                        <img :src="modalData.image" :alt="modalData.title" class="max-h-[55vh] w-auto object-contain rounded-xl shadow-lg">
                    </div>

                    <!-- Keterangan Lengkap di Bawah Gambar -->
                    <div class="p-6 bg-slate-900 flex flex-col gap-2">
                        <span class="text-xs font-bold text-indigo-400 uppercase tracking-wider" x-text="modalData.badge"></span>
                        <h3 class="text-lg font-black text-white m-0" x-text="modalData.title"></h3>
                        <p class="text-sm text-slate-300 m-0 leading-relaxed" x-text="modalData.desc"></p>
                    </div>
                </div>
            </div>
        </template>

    </section>

    <!-- ========================================================== -->
    <!-- SECTION EVENTS & WEBINAR (BERANDA - 2 CARD PER SLIDE) -->
    <!-- ========================================================== -->
    <div id="events" style="width: 100%; background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%); padding: 5rem 1.5rem; display: flex; flex-direction: column; align-items: center; position: relative; overflow: hidden;" x-data="{
        scrollSlider(direction) {
            const container = document.getElementById('eventsHomeSlider');
            const scrollAmount = 600;
            if (direction === 'next') {
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            }
        }
    }">

        <!-- Efek Cahaya Blur Background Glassmorphic -->
        <div style="position: absolute; width: 400px; height: 400px; background: rgba(79, 70, 229, 0.05); filter: blur(90px); border-radius: 50%; top: 10%; left: 5%; pointer-events: none;"></div>
        <div style="position: absolute; width: 350px; height: 350px; background: rgba(59, 130, 246, 0.05); filter: blur(80px); border-radius: 50%; bottom: 10%; right: 5%; pointer-events: none;"></div>

        <div style="max-width: 1200px; width: 100%; display: flex; flex-direction: column; gap: 2.5rem; position: relative; z-index: 10;">
            
            <!-- Header Section -->
            <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1.5rem;">
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="color: #4f46e5; width: 2.5rem; height: 2.5rem; display: flex; align-items: center; justify-content: center;">
                            <svg style="width: 2rem; height: 2rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </div>
                        <h2 style="color: #0f172a; font-weight: 900; font-size: clamp(1.75rem, 3vw, 2.5rem); margin: 0; letter-spacing: -0.02em;">
                            Events dan Webinar
                        </h2>
                    </div>
                    <div style="width: 3.5rem; height: 0.3rem; background-color: #eab308; border-radius: 9999px; margin-bottom: 0.25rem;"></div>
                    <p style="color: #64748b; font-size: 0.95rem; margin: 0; font-weight: 500;">
                        Jadwal dan informasi sesi daring pengembangan kompetensi pendidikan.
                    </p>
                </div>

                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <button type="button" @click="scrollSlider('prev')" aria-label="Sebelumnya" class="w-10 h-10 rounded-full bg-white border border-slate-200 text-slate-700 flex items-center justify-center shadow-md hover:bg-slate-50 hover:text-indigo-600 transition-all cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button type="button" @click="scrollSlider('next')" aria-label="Selanjutnya" class="w-10 h-10 rounded-full bg-white border border-slate-200 text-slate-700 flex items-center justify-center shadow-md hover:bg-slate-50 hover:text-indigo-600 transition-all cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    <a href="{{ route('events.index') }}" class="hover:bg-blue-700 transition-all duration-300 shadow-lg shadow-blue-600/30" style="background: #0284c7; color: white; padding: 0.75rem 1.75rem; border-radius: 9999px; font-weight: 700; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; margin-left: 0.5rem;">
                        Lihat Semua
                    </a>
                </div>
            </div>

            <!-- Wadah Slider (2 Card per Tampilan) -->
            <div id="eventsHomeSlider" style="display: flex; gap: 2rem; overflow-x: auto; scroll-behavior: smooth; padding: 0.5rem 0.25rem 1.5rem 0.25rem; scrollbar-width: none;">
                @forelse($events ?? [] as $item)
                    <!-- Card Horizontal Style (Gambar Kiri, Teks Kanan) -->
                    <div style="min-width: min(540px, 88vw); max-width: 570px; flex: 1 0 auto; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 2rem; padding: 1.75rem; box-shadow: 0 20px 40px -15px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 1.5rem;">
                        
                        <!-- Kiri: Poster / Gambar -->
                        <div style="width: 170px; height: 210px; border-radius: 1rem; overflow: hidden; background: #f1f5f9; flex-shrink: 0; box-shadow: 0 10px 20px rgba(0,0,0,0.08);">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://via.placeholder.com/400x500/e2e8f0/475569?text=Event'">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-indigo-500/10 via-blue-500/10 to-purple-500/10 flex flex-col items-center justify-center p-3 text-center">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-600/10 text-indigo-600 flex items-center justify-center mb-1.5">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    </div>
                                    <span class="text-[11px] font-extrabold text-indigo-900 line-clamp-2">{{ $item->title }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Kanan: Informasi (Badge, Waktu, Judul, Penyelenggara, Tombol) -->
                        <div style="flex: 1; display: flex; flex-direction: column; gap: 0.75rem; min-width: 0;">
                            <div style="display: flex; align-items: center; gap: 0.4rem; flex-wrap: wrap;">
                                <span style="background: #e0e7ff; color: #4338ca; padding: 0.25rem 0.65rem; border-radius: 0.5rem; font-weight: 800; font-size: 0.65rem; text-transform: uppercase;">{{ $item->type }}</span>
                                
                                @php $status = $item->status; @endphp
                                <span style="background: {{ $status == 'Selesai' ? '#f1f5f9' : '#dcfce7' }}; color: {{ $status == 'Selesai' ? '#64748b' : '#15803d' }}; padding: 0.25rem 0.65rem; border-radius: 0.5rem; font-weight: 800; font-size: 0.65rem; text-transform: uppercase;">{{ $status }}</span>
                            </div>

                            <div style="display: flex; align-items: center; gap: 0.3rem; color: #64748b; font-size: 0.75rem; font-weight: 600;">
                                <span>📅</span> {{ \Carbon\Carbon::parse($item->event_date)->translatedFormat('d M Y, H:i') }} WITA
                            </div>

                            <h3 style="color: #1e293b; font-weight: 900; font-size: 1.05rem; margin: 0; line-height: 1.35; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $item->title }}</h3>
                            
                            <div style="color: #475569; font-size: 0.8rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                Oleh: <strong style="color: #1e293b;">{{ $item->organizer }}</strong>
                            </div>

                            <div style="margin-top: 0.5rem;">
                                <a href="{{ $item->instagram_url }}" target="_blank" rel="noopener noreferrer" class="hover:bg-blue-700 transition-colors" style="background: #0284c7; color: white; padding: 0.6rem 1rem; border-radius: 0.85rem; font-weight: 700; font-size: 0.8rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem; box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3);">
                                    <svg style="width: 0.95rem; height: 0.95rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>Info selengkapnya &rarr;</span>
                                </a>
                            </div>
                        </div>

                    </div>
                @empty
                    <div style="width: 100%; text-align: center; padding: 4rem; color: #94a3b8; font-size: 1rem; background: rgba(255,255,255,0.8); border-radius: 2rem;">
                        Belum ada jadwal Event atau Webinar yang aktif saat ini.
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    <!-- ========================================================== -->
    <!-- SECTION JADWAL & KEGIATAN AGENDA BPMP SULTRA (GLASSMORPHISM) -->
    <!-- ========================================================== -->
    <div id="agenda" style="width: 100%; background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%); padding: 5rem 1.5rem; display: flex; flex-direction: column; align-items: center; position: relative; overflow: hidden;">
        
        <!-- Efek Cahaya Blur Background Glassmorphic -->
        <div style="position: absolute; width: 400px; height: 400px; background: rgba(79, 70, 229, 0.05); filter: blur(90px); border-radius: 50%; top: 10%; left: 5%; pointer-events: none;"></div>
        <div style="position: absolute; width: 350px; height: 350px; background: rgba(59, 130, 246, 0.05); filter: blur(80px); border-radius: 50%; bottom: 10%; right: 5%; pointer-events: none;"></div>

        <div style="max-width: 1100px; width: 100%; display: flex; flex-direction: column; align-items: center; gap: 2.5rem; position: relative; z-index: 10;">
            
            <!-- Header Judul & Deskripsi Singkat -->
            <div style="display: flex; flex-direction: column; align-items: center; text-align: center; gap: 1rem;">
                
                <!-- Badge / Logo Penanda Keren -->
                <div style="background: rgba(79, 70, 229, 0.1); border: 1px solid rgba(79, 70, 229, 0.2); padding: 0.4rem 1.25rem; border-radius: 9999px; display: inline-flex; align-items: center; gap: 0.6rem; backdrop-filter: blur(10px);">
                    <div style="width: 1.5rem; height: 1.5rem; border-radius: 50%; background: #4f46e5; display: flex; align-items: center; justify-content: center; color: white;">
                        <svg style="width: 0.9rem; height: 0.9rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <span style="color: #4338ca; font-weight: 800; font-size: 0.8rem; letter-spacing: 0.05em; text-transform: uppercase;">Informasi Terpadu</span>
                </div>

                <!-- Judul Utama -->
                <h2 style="color: #1e293b; font-weight: 900; font-size: clamp(2rem, 3.5vw, 2.75rem); margin: 0; letter-spacing: -0.02em;">
                    Jadwal & Kegiatan <span style="color: #4f46e5;">Agenda BPMP Sultra</span>
                </h2>

                <!-- Deskripsi Singkat -->
                <p style="color: #64748b; font-size: 1.05rem; line-height: 1.6; max-width: 650px; margin: 0; font-weight: 500;">
                    Pantau agenda kegiatan, rapat koordinasi, serta linimasa program kerja resmi secara real-time di lingkungan BPMP Provinsi Sulawesi Tenggara.
                </p>

            </div>

            <!-- Wadah Utama Kalender / Agenda (Glassmorphic Card Penuh & Elegan) -->
            <div style="width: 100%; max-width: 1050px; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 2.5rem; box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05);"
                 class="p-6 sm:p-8 md:p-10"
                 x-data="calendarData()">
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    <!-- Kolom Kiri: Kalender Bulan & Grid Tanggal (lg:col-span-7) -->
                    <div class="lg:col-span-7 bg-white/70 backdrop-blur-md rounded-2xl p-5 sm:p-6 border border-white/80 shadow-sm">
                        <!-- Header Bulan & Navigasi -->
                        <div class="flex justify-between items-center mb-5 pb-4 border-b border-slate-100">
                            <button @click="prevMonth" type="button" aria-label="Bulan Sebelumnya" class="w-9 h-9 rounded-full flex items-center justify-center bg-white hover:bg-indigo-50 text-slate-600 hover:text-indigo-600 border border-slate-200 hover:border-indigo-200 transition-all shadow-sm cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                            </button>
                            <h4 class="font-display text-lg sm:text-xl font-extrabold text-slate-800" x-text="monthNames[month] + ' ' + year"></h4>
                            <button @click="nextMonth" type="button" aria-label="Bulan Berikutnya" class="w-9 h-9 rounded-full flex items-center justify-center bg-white hover:bg-indigo-50 text-slate-600 hover:text-indigo-600 border border-slate-200 hover:border-indigo-200 transition-all shadow-sm cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>

                        <!-- Nama Hari -->
                        <div class="grid grid-cols-7 gap-1 sm:gap-2 text-center text-xs font-extrabold text-slate-400 mb-3 uppercase tracking-wider">
                            <div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
                        </div>

                        <!-- Grid Tanggal -->
                        <div class="grid grid-cols-7 gap-1 sm:gap-2 text-center text-sm font-semibold">
                            <template x-for="blank in blankDays">
                                <div class="py-2 text-slate-300 pointer-events-none"></div>
                            </template>
                            <template x-for="day in daysInMonth">
                                <div @click="selectDate(day)" 
                                     class="py-2 rounded-xl cursor-pointer transition-all relative flex flex-col items-center justify-center select-none"
                                     :class="{
                                         'bg-indigo-600 text-white font-bold shadow-md shadow-indigo-600/30 scale-105': isSelected(day),
                                         'text-indigo-600 bg-indigo-50 border border-indigo-200 font-bold': isToday(day) && !isSelected(day),
                                         'text-slate-700 hover:bg-slate-100': !isSelected(day) && !isToday(day)
                                     }">
                                    <span x-text="day"></span>
                                    <div x-show="hasEvent(day)" class="w-1.5 h-1.5 rounded-full mt-0.5"
                                         :class="isSelected(day) ? 'bg-white' : 'bg-indigo-600'"></div>
                                </div>
                            </template>
                        </div>

                        <!-- Petunjuk Keterangan -->
                        <div class="flex items-center gap-4 text-xs font-semibold text-slate-500 mt-5 pt-4 border-t border-slate-100">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                                <span>Ada Kegiatan</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-md bg-indigo-50 border border-indigo-200"></span>
                                <span>Hari Ini</span>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Rincian Kegiatan Tanggal Terpilih (lg:col-span-5) -->
                    <div class="lg:col-span-5 flex flex-col gap-4">
                        <div class="bg-indigo-50/80 border border-indigo-100 rounded-2xl p-4 flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <span class="text-[11px] font-bold text-indigo-500 uppercase tracking-wider block">Agenda Tanggal</span>
                                    <h5 class="text-sm font-extrabold text-indigo-950 m-0" x-text="selectedDate + ' ' + monthNames[month] + ' ' + year"></h5>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-indigo-700 bg-white px-2.5 py-1 rounded-lg border border-indigo-100 shadow-xs" x-text="currentEvents.length + ' Agenda'"></span>
                        </div>

                        <!-- Daftar Event / Acara -->
                        <div class="space-y-3 min-h-[220px]">
                            <template x-if="currentEvents.length === 0">
                                <div class="text-center py-10 px-4 bg-white/60 border border-slate-200/60 rounded-2xl flex flex-col items-center justify-center gap-2">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mb-1">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <p class="text-sm font-bold text-slate-700 m-0">Tidak Ada Agenda Terjadwal</p>
                                    <p class="text-xs text-slate-500 m-0">Tidak ada jadwal agenda resmi pada tanggal ini.</p>
                                </div>
                            </template>
                            <template x-for="event in currentEvents" :key="event.title">
                                <div class="flex gap-3.5 p-4 rounded-2xl border transition-all shadow-sm bg-white hover:border-indigo-300 hover:shadow-md"
                                     :class="event.type === 'primary' ? 'border-indigo-100' : 'border-slate-100'">
                                    <div class="flex flex-col items-center justify-center min-w-[50px] bg-indigo-50/80 p-2 rounded-xl border border-indigo-100 shrink-0">
                                        <span class="text-[10px] font-extrabold uppercase text-indigo-600" x-text="monthNames[month].substring(0,3)"></span>
                                        <span class="text-lg font-black leading-none text-indigo-900" x-text="selectedDate.toString().padStart(2, '0')"></span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h5 class="font-extrabold text-slate-900 text-sm mb-1 leading-snug" x-text="event.title"></h5>
                                        <p class="text-xs text-slate-500 font-medium flex items-center gap-1.5 m-0">
                                            <svg class="w-3.5 h-3.5 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span x-text="event.time"></span>
                                        </p>
                                        <p x-show="event.description" class="text-xs text-slate-400 mt-1 line-clamp-1" x-text="event.description"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <!-- Alpine.js Calendar Data Script -->
    <script>
        function calendarData() {
            const today = new Date();
            // Default current month and year based on today
            return {
                todayDate: today.getDate(),
                todayMonth: today.getMonth(),
                todayYear: today.getFullYear(),
                month: today.getMonth(),
                year: today.getFullYear(),
                selectedDate: today.getDate(),
                monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                // Dynamic Agendas from Database
                events: @json($agendaJsonList ?? []),
                get daysInMonth() {
                    return new Date(this.year, this.month + 1, 0).getDate();
                },
                get blankDays() {
                    return Array.from({ length: new Date(this.year, this.month, 1).getDay() });
                },
                prevMonth() {
                    if (this.month === 0) {
                        this.month = 11;
                        this.year--;
                    } else {
                        this.month--;
                    }
                    this.selectedDate = 1; // Reset selection to 1st of month
                },
                nextMonth() {
                    if (this.month === 11) {
                        this.month = 0;
                        this.year++;
                    } else {
                        this.month++;
                    }
                    this.selectedDate = 1; // Reset selection to 1st of month
                },
                selectDate(day) {
                    this.selectedDate = day;
                },
                isSelected(day) {
                    return this.selectedDate === day;
                },
                isToday(day) {
                    return day === this.todayDate && this.month === this.todayMonth && this.year === this.todayYear;
                },
                hasEvent(day) {
                    return this.events.some(e => e.day === day && e.month === this.month && e.year === this.year);
                },
                get currentEvents() {
                    return this.events.filter(e => e.day === this.selectedDate && e.month === this.month && e.year === this.year);
                }
            }
        }
    </script>


    <!-- 6. Berita & Publikasi (Split Layout) -->
    <section id="berita" class="py-24 bg-white relative">
        <div class="container mx-auto px-4 max-w-7xl">
            <!-- Section Header dengan Ikon/Logo dan Judul -->
            <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem;" class="mb-12">
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <!-- Logo / Badge Indikator Sesuai Permintaan -->
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="background-color: #e0e7ff; color: #4338ca; width: 2.5rem; height: 2.5rem; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(67, 56, 202, 0.15);">
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                        <h2 class="font-display" style="color: #1e293b; font-weight: 900; font-size: clamp(1.5rem, 3vw, 2rem); margin: 0; letter-spacing: -0.02em;">
                            Kabar Terbaru dari Kami
                        </h2>
                    </div>
                    <!-- Garis Indikator di Bawah Judul -->
                    <div style="width: 4rem; height: 0.35rem; background-color: #4f46e5; border-radius: 9999px;"></div>
                </div>

                <p style="color: #64748b; font-size: 0.95rem; max-width: 400px; margin: 0;">
                    Artikel dan berita atau informasi terbaru terkait kegiatan dan program BPMP Sulawesi Tenggara.
                </p>
            </div>

            <!-- Split Layout Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
                
                <!-- Left: Large Featured Auto-Slide (Alpine.js) -->
                <div class="lg:col-span-7 xl:col-span-7 h-full"
                     x-data="{ 
                        activeSlide: 0, 
                        totalSlides: {{ count($featuredPosts) }}, 
                        autoSlide() { 
                            setInterval(() => { 
                                this.activeSlide = this.activeSlide === this.totalSlides - 1 ? 0 : this.activeSlide + 1; 
                            }, 5000); 
                        } 
                     }"
                     x-init="autoSlide()">
                    <div class="h-full min-h-[360px] sm:min-h-[420px] lg:min-h-[460px] relative rounded-3xl overflow-hidden group shadow-lg bg-gray-900">
                        <!-- Slides Looping -->
                        @foreach($featuredPosts as $index => $post)
                            @php
                                // Resolusi path gambar: thumbnail_url (model accessor) -> thumbnail -> image -> fallback default
                                $imagePath = $post->thumbnail_url ?? null;
                                if (empty($imagePath)) {
                                    if (!empty($post->thumbnail)) {
                                        $imagePath = str_starts_with($post->thumbnail, 'http') 
                                            ? $post->thumbnail 
                                            : asset('storage/' . ltrim($post->thumbnail, '/'));
                                    } elseif (!empty($post->image)) {
                                        $imagePath = str_starts_with($post->image, 'http') 
                                            ? $post->image 
                                            : asset('storage/' . ltrim($post->image, '/'));
                                    } else {
                                        $imagePath = 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&w=1200&q=80';
                                    }
                                }
                                $postUrl = route('berita.show', $post->slug ?? $post->id);
                            @endphp

                            <div x-show="activeSlide === {{ $index }}"
                                 x-transition:enter="transition ease-out duration-700"
                                 x-transition:enter-start="opacity-0 scale-105"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-500 absolute inset-0"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 class="absolute inset-0 w-full h-full">

                                <!-- Background Image Penuh -->
                                <img src="{{ $imagePath }}" 
                                     alt="{{ $post->title }}" 
                                     class="absolute inset-0 w-full h-full object-cover">

                                <!-- Gradient Overlay Hitam (Bawah ke Atas) -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>

                                <!-- Konten Teks di Atas Gradien -->
                                <div class="absolute inset-0 p-6 md:p-8 flex flex-col justify-between z-10 pointer-events-none">
                                    <!-- Badge Kategori Berita -->
                                    <div class="self-start pointer-events-auto">
                                        <span class="inline-block bg-blue-600 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm uppercase tracking-wider">
                                            {{ $post->category->name ?? 'BERITA' }}
                                        </span>
                                    </div>

                                    <!-- Judul, Cuplikan Konten, dan Tombol Selengkapnya -->
                                    <div class="mt-auto pr-24 sm:pr-28 pointer-events-auto">
                                        <h3 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white mb-2 line-clamp-2 leading-tight drop-shadow-sm">
                                            <a href="{{ $postUrl }}" class="hover:text-blue-300 transition-colors">
                                                {{ $post->title }}
                                            </a>
                                        </h3>
                                        <p class="text-xs sm:text-sm text-slate-200 line-clamp-2 mb-4 leading-relaxed drop-shadow">
                                            {{ Str::limit(strip_tags($post->content), 120) }}
                                        </p>
                                        <a href="{{ $postUrl }}" 
                                           class="inline-flex items-center gap-2 text-sm font-semibold text-white/95 hover:text-white hover:gap-3 transition-all group/link">
                                            <span>Baca Selengkapnya</span>
                                            <svg class="w-4 h-4 transition-transform group-hover/link:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Navigasi Slider (Pojok Kanan Bawah) -->
                        <div class="absolute bottom-6 md:bottom-8 right-6 md:right-8 flex flex-col items-end gap-3 z-20">
                            <!-- Tombol Panah Kiri dan Kanan -->
                            <div class="flex items-center gap-2">
                                <button type="button"
                                        @click="activeSlide = activeSlide === 0 ? totalSlides - 1 : activeSlide - 1"
                                        aria-label="Slide Sebelumnya"
                                        class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md hover:bg-white/40 border border-white/30 text-white flex items-center justify-center transition-all shadow-sm active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button type="button"
                                        @click="activeSlide = activeSlide === totalSlides - 1 ? 0 : activeSlide + 1"
                                        aria-label="Slide Selanjutnya"
                                        class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md hover:bg-white/40 border border-white/30 text-white flex items-center justify-center transition-all shadow-sm active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Titik Indikator (Dots) -->
                            <div class="flex items-center gap-1.5">
                                @foreach($featuredPosts as $index => $post)
                                    <button type="button"
                                            @click="activeSlide = {{ $index }}"
                                            aria-label="Ke slide {{ $index + 1 }}"
                                            :class="activeSlide === {{ $index }} ? 'w-6 bg-blue-600' : 'w-2 bg-white/50 hover:bg-white/80'"
                                            class="h-2 rounded-full transition-all duration-300"></button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Stacked List Cards -->
                <div class="lg:col-span-5 xl:col-span-5 flex flex-col justify-between gap-4">
                    @if(isset($sidePosts) && $sidePosts->isNotEmpty())
                        @foreach($sidePosts as $sp)
                        <a href="{{ route('berita.show', $sp->slug ?? $sp->id) }}" class="flex items-center gap-4 p-4 rounded-2xl bg-white dark:bg-[#0f1b38] border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-md hover:border-blue-500/40 transition-all group flex-1">
                            <img src="{{ $sp->thumbnail_url }}" alt="{{ $sp->title }}" class="w-24 h-20 sm:w-28 sm:h-24 lg:w-32 rounded-xl object-cover shrink-0 group-hover:scale-105 transition-transform duration-300 shadow-sm">
                            <div class="flex flex-col justify-center h-full">
                                <span class="text-[10px] font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider mb-1">{{ strtoupper($sp->category->name ?? 'BERITA') }}</span>
                                <h3 class="text-sm sm:text-base font-semibold text-slate-800 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 line-clamp-2 transition-colors mb-2">{{ $sp->title }}</h3>
                                <div class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400 mt-auto">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $sp->published_at ? $sp->published_at->format('d F Y') : $sp->created_at->format('d F Y') }}
                                </div>
                            </div>
                        </a>
                        @endforeach
                    @else
                        <!-- Card 1 -->
                        <a href="/berita/4" class="flex items-center gap-4 p-4 rounded-2xl bg-white dark:bg-[#0f1b38] border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-md hover:border-blue-500/40 transition-all group flex-1">
                            <img src="https://images.unsplash.com/photo-1571260899304-4250701120f6?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" alt="Thumbnail" class="w-24 h-20 sm:w-28 sm:h-24 lg:w-32 rounded-xl object-cover shrink-0 group-hover:scale-105 transition-transform duration-300 shadow-sm">
                            <div class="flex flex-col justify-center h-full">
                                <span class="text-[10px] font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider mb-1">PENGUMUMAN</span>
                                <h3 class="text-sm sm:text-base font-semibold text-slate-800 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 line-clamp-2 transition-colors mb-2">Pendaftaran Bimtek Pengelolaan Kinerja Berbasis Digital</h3>
                                <div class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400 mt-auto">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    05 Oktober 2026
                                </div>
                            </div>
                        </a>

                        <!-- Card 2 -->
                        <a href="/berita/5" class="flex items-center gap-4 p-4 rounded-2xl bg-white dark:bg-[#0f1b38] border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-md hover:border-blue-500/40 transition-all group flex-1">
                            <img src="https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" alt="Thumbnail" class="w-24 h-20 sm:w-28 sm:h-24 lg:w-32 rounded-xl object-cover shrink-0 group-hover:scale-105 transition-transform duration-300 shadow-sm">
                            <div class="flex flex-col justify-center h-full">
                                <span class="text-[10px] font-bold text-teal-600 dark:text-teal-400 uppercase tracking-wider mb-1">ARTIKEL</span>
                                <h3 class="text-sm sm:text-base font-semibold text-slate-800 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 line-clamp-2 transition-colors mb-2">Tips Sukses Akreditasi Sekolah Standar Baru 2026</h3>
                                <div class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400 mt-auto">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    01 Oktober 2026
                                </div>
                            </div>
                        </a>

                        <!-- Card 3 -->
                        <a href="/berita/6" class="flex items-center gap-4 p-4 rounded-2xl bg-white dark:bg-[#0f1b38] border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-md hover:border-blue-500/40 transition-all group flex-1">
                            <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" alt="Thumbnail" class="w-24 h-20 sm:w-28 sm:h-24 lg:w-32 rounded-xl object-cover shrink-0 group-hover:scale-105 transition-transform duration-300 shadow-sm">
                            <div class="flex flex-col justify-center h-full">
                                <span class="text-[10px] font-bold text-purple-600 dark:text-purple-400 uppercase tracking-wider mb-1">PENDIDIKAN</span>
                                <h3 class="text-sm sm:text-base font-semibold text-slate-800 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 line-clamp-2 transition-colors mb-2">Optimalisasi Pemanfaatan Platform Merdeka Mengajar (PMM)</h3>
                                <div class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400 mt-auto">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    25 September 2026
                                </div>
                            </div>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Tombol Lihat Lebih Banyak (Diposisikan di Tengah / Center) -->
            <div style="display: flex; justify-content: center; width: 100%; margin-top: 3rem;">
                <a href="{{ route('berita.index') }}" class="hover:bg-indigo-700 hover:shadow-xl transition-all duration-300" style="background: #4f46e5; color: white; padding: 0.85rem 2.5rem; border-radius: 9999px; font-weight: 800; font-size: 0.95rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.4);">
                    Lihat Lebih Banyak &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- 6.5 Survei Kepuasan Masyarakat -->
    <section class="py-24 bg-slate-50 relative border-t border-slate-100 font-sans scroll-mt-10" id="section-skm">
        <div id="survei-kepuasan"></div>
        <div class="container mx-auto px-4 max-w-7xl">
            
            <!-- Section Header -->
            <div class="mb-10 text-center md:text-left flex flex-col md:flex-row justify-between items-center md:items-end gap-6">
                <div>
                    <div class="flex items-center justify-center md:justify-start gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-500 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <h2 class="font-display text-3xl md:text-4xl font-extrabold text-blue-900">Survei Kepuasan Masyarakat</h2>
                    </div>
                    <div class="w-20 h-1.5 bg-orange-500 rounded-full mx-auto md:mx-0 mb-4"></div>
                    <p class="text-slate-600 text-base">Indeks Kepuasan Masyarakat (IKM) BPMP Provinsi Sulawesi Tenggara</p>
                </div>
                
                <!-- Pills Filter Tahun -->
                <div class="flex items-center gap-2 bg-white p-1.5 rounded-full border border-slate-200 shadow-sm">
                    @foreach($availableSkmYears as $yr)
                        <a href="{{ request()->fullUrlWithQuery(['skm_tahun' => $yr]) }}#section-skm"
                           class="px-6 py-2.5 rounded-full text-sm font-bold transition-all {{ $tahunSkm == $yr ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                            {{ $yr }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Selector Periode Triwulan -->
            <div class="mb-6 flex flex-wrap items-center justify-center md:justify-start gap-2.5">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mr-1 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Pilih Triwulan:
                </span>
                @for($tw = 1; $tw <= 4; $tw++)
                    @php
                        $isTwActive = ($triwulanSkm == $tw);
                        $twScore = $skmTabs[$tw] ?? 0;
                    @endphp
                    <a href="{{ request()->fullUrlWithQuery(['skm_triwulan' => $tw]) }}#section-skm"
                       class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 {{ $isTwActive ? 'bg-blue-600 text-white shadow-sm ring-2 ring-blue-500/30' : 'bg-white text-slate-700 hover:text-blue-600 hover:bg-blue-50 border border-slate-200 shadow-xs' }}">
                        <span>Triwulan {{ $tw }}</span>
                        <span class="text-[10px] px-1.5 py-0.5 rounded-md {{ $isTwActive ? 'bg-white/20 text-white font-extrabold' : 'bg-blue-50 text-blue-700 font-extrabold' }}">
                            {{ number_format($twScore, 2, ',', '.') }}
                        </span>
                    </a>
                @endfor
            </div>

            <!-- Main Content Container -->
            <div class="bg-white rounded-[2rem] shadow-xl border border-slate-100 overflow-hidden">
                
                <!-- Blue Banner Hero Card -->
                <div class="bg-blue-600 px-6 py-8 md:px-12 md:py-10 relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6">
                    <!-- Background Decor -->
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-blue-500 rounded-full opacity-50 blur-3xl"></div>
                    
                    <div class="flex flex-col md:flex-row items-center gap-6 relative z-10 w-full">
                        <!-- Frosted Emoticon -->
                        <div class="w-20 h-20 md:w-24 md:h-24 rounded-2xl bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center shrink-0 shadow-lg">
                            <svg class="w-12 h-12 md:w-14 md:h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        
                        <!-- Score Info -->
                        <div class="text-center md:text-left flex-1">
                            <h3 class="text-blue-100 font-bold tracking-wider text-xs md:text-sm uppercase mb-2">NILAI IKM — TRIWULAN {{ $triwulanSkm }} TAHUN {{ $tahunSkm }}</h3>
                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-4">
                                <span class="text-5xl md:text-6xl font-extrabold text-white">{{ number_format($dataSkmUtama['nilai_konversi'], 2, ',', '.') }}</span>
                                @php
                                    $badgeMutuClass = match($dataSkmUtama['mutu'] ?? 'D') {
                                        'A' => 'bg-emerald-400 text-emerald-950',
                                        'B' => 'bg-sky-300 text-blue-950',
                                        'C' => 'bg-amber-300 text-amber-950',
                                        default => 'bg-rose-400 text-rose-950',
                                    };
                                @endphp
                                <span class="{{ $badgeMutuClass }} font-extrabold px-4 py-1.5 rounded-full text-sm shadow-sm tracking-widest">
                                    {{ strtoupper($dataSkmUtama['kinerja']) }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Right Text -->
                        <div class="text-center md:text-right md:max-w-[220px]">
                            <p class="text-white font-bold text-xs leading-relaxed">PERMENPAN RB No. 14 / 2017</p>
                            <p class="text-white/80 text-[11px] font-medium leading-relaxed mt-0.5">Kementerian Pendidikan Dasar &amp; Menengah &bull; BPMP Sultra</p>
                            @if(($dataSkmUtama['total_responden'] ?? 0) > 0)
                                <span class="inline-block mt-2 px-2.5 py-1 rounded-full bg-white/15 text-white text-[11px] font-semibold backdrop-blur-xs">
                                    {{ number_format($dataSkmUtama['total_responden']) }} Responden
                                </span>
                            @else
                                <span class="inline-block mt-2 px-2.5 py-1 rounded-full bg-white/10 text-white/70 text-[11px] font-medium backdrop-blur-xs">
                                    Belum ada data survei
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Grid Indikator -->
                <div class="p-6 md:p-10 bg-slate-50/50">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        
                        <!-- Card 1 -->
                        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Unsur 1</p>
                                <h4 class="font-bold text-slate-800 text-sm mb-1">Persyaratan</h4>
                                <p class="text-blue-600 font-extrabold text-lg">{{ number_format($dataSkmUtama['nrr_per_unsur']['q1'] ?? 0, 2) }}</p>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Unsur 2</p>
                                <h4 class="font-bold text-slate-800 text-sm mb-1">Prosedur</h4>
                                <p class="text-blue-600 font-extrabold text-lg">{{ number_format($dataSkmUtama['nrr_per_unsur']['q2'] ?? 0, 2) }}</p>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Unsur 3</p>
                                <h4 class="font-bold text-slate-800 text-sm mb-1">Waktu Pelayanan</h4>
                                <p class="text-blue-600 font-extrabold text-lg">{{ number_format($dataSkmUtama['nrr_per_unsur']['q3'] ?? 0, 2) }}</p>
                            </div>
                        </div>

                        <!-- Card 4 -->
                        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Unsur 4</p>
                                <h4 class="font-bold text-slate-800 text-sm mb-1">Biaya / Tarif</h4>
                                <p class="text-blue-600 font-extrabold text-lg">{{ number_format($dataSkmUtama['nrr_per_unsur']['q4'] ?? 0, 2) }}</p>
                            </div>
                        </div>

                        <!-- Card 5 -->
                        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Unsur 5</p>
                                <h4 class="font-bold text-slate-800 text-sm mb-1">Produk Pelayanan</h4>
                                <p class="text-blue-600 font-extrabold text-lg">{{ number_format($dataSkmUtama['nrr_per_unsur']['q5'] ?? 0, 2) }}</p>
                            </div>
                        </div>

                        <!-- Card 6 -->
                        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Unsur 6</p>
                                <h4 class="font-bold text-slate-800 text-sm mb-1">Kompetensi</h4>
                                <p class="text-blue-600 font-extrabold text-lg">{{ number_format($dataSkmUtama['nrr_per_unsur']['q6'] ?? 0, 2) }}</p>
                            </div>
                        </div>

                        <!-- Card 7 -->
                        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Unsur 7</p>
                                <h4 class="font-bold text-slate-800 text-sm mb-1">Perilaku</h4>
                                <p class="text-blue-600 font-extrabold text-lg">{{ number_format($dataSkmUtama['nrr_per_unsur']['q7'] ?? 0, 2) }}</p>
                            </div>
                        </div>

                        <!-- Card 8 -->
                        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Unsur 8</p>
                                <h4 class="font-bold text-slate-800 text-sm mb-1">Sarana &amp; Prasarana</h4>
                                <p class="text-blue-600 font-extrabold text-lg">{{ number_format($dataSkmUtama['nrr_per_unsur']['q8'] ?? 0, 2) }}</p>
                            </div>
                        </div>

                        <!-- Card 9 -->
                        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Unsur 9</p>
                                <h4 class="font-bold text-slate-800 text-sm mb-1">Penanganan Pengaduan</h4>
                                <p class="text-blue-600 font-extrabold text-lg">{{ number_format($dataSkmUtama['nrr_per_unsur']['q9'] ?? 0, 2) }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6.6 Section Publikasi -->
    <section id="publikasi" class="w-full py-16 md:py-24 bg-slate-50 relative border-t border-slate-100 font-sans overflow-hidden">
        <!-- Subtle decorative background blurs -->
        <div class="absolute top-1/4 -left-32 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-1/4 -right-32 w-96 h-96 bg-sky-300/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="container mx-auto px-4 max-w-7xl relative z-10">
            <!-- Section Header -->
            <div class="text-center md:text-left mb-12 flex flex-col md:flex-row justify-between items-center md:items-end gap-6">
                <div>
                    <div class="flex items-center justify-center md:justify-start gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h2 class="font-display text-3xl md:text-4xl font-extrabold text-blue-900">Publikasi</h2>
                    </div>
                    <div class="w-20 h-1.5 bg-blue-600 rounded-full mx-auto md:mx-0 mb-4"></div>
                    <p class="text-slate-600 text-sm md:text-base">Kumpulan dokumen, rilis berkala, artikel, dan materi edukasi</p>
                </div>
            </div>

            <!-- Grid 3 Kolom Modern White Glassmorphism Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- 1. SINONGGI -->
                <a href="#" class="group relative flex items-start gap-4 p-6 bg-white/60 hover:bg-white/90 backdrop-blur-md border border-white/80 hover:border-blue-300/60 shadow-lg shadow-slate-200/50 hover:shadow-xl rounded-2xl transition-all duration-300 hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white group-hover:scale-105 transition-all duration-300 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2 mb-1.5">
                            <h3 class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-blue-600 transition-colors">
                                SINONGGI
                            </h3>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                            Sistem Inovasi Online Berbagi Informasi BPMP Sultra.
                        </p>
                    </div>
                </a>

                <!-- 2. Profil Mutu Pendidikan -->
                <a href="#" class="group relative flex items-start gap-4 p-6 bg-white/60 hover:bg-white/90 backdrop-blur-md border border-white/80 hover:border-blue-300/60 shadow-lg shadow-slate-200/50 hover:shadow-xl rounded-2xl transition-all duration-300 hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white group-hover:scale-105 transition-all duration-300 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2 mb-1.5">
                            <h3 class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-blue-600 transition-colors">
                                Profil Mutu Pendidikan
                            </h3>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                            Data capaian dan profil mutu sekolah se-Sultra.
                        </p>
                    </div>
                </a>

                <!-- 3. Regulasi dan Peraturan -->
                <a href="#" class="group relative flex items-start gap-4 p-6 bg-white/60 hover:bg-white/90 backdrop-blur-md border border-white/80 hover:border-blue-300/60 shadow-lg shadow-slate-200/50 hover:shadow-xl rounded-2xl transition-all duration-300 hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white group-hover:scale-105 transition-all duration-300 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2 mb-1.5">
                            <h3 class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-blue-600 transition-colors">
                                Regulasi dan Peraturan
                            </h3>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                            Himpunan undang-undang, permen, dan keputusan resmi.
                        </p>
                    </div>
                </a>

                <!-- 4. Kisah Inspiratif -->
                <a href="#" class="group relative flex items-start gap-4 p-6 bg-white/60 hover:bg-white/90 backdrop-blur-md border border-white/80 hover:border-blue-300/60 shadow-lg shadow-slate-200/50 hover:shadow-xl rounded-2xl transition-all duration-300 hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white group-hover:scale-105 transition-all duration-300 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2 mb-1.5">
                            <h3 class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-blue-600 transition-colors">
                                Kisah Inspiratif
                            </h3>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                            Cerita sukses dan praktik baik insan pendidikan.
                        </p>
                    </div>
                </a>

                <!-- 5. JURNAL -->
                <a href="#" class="group relative flex items-start gap-4 p-6 bg-white/60 hover:bg-white/90 backdrop-blur-md border border-white/80 hover:border-blue-300/60 shadow-lg shadow-slate-200/50 hover:shadow-xl rounded-2xl transition-all duration-300 hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white group-hover:scale-105 transition-all duration-300 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2 mb-1.5">
                            <h3 class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-blue-600 transition-colors">
                                JURNAL
                            </h3>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                            Karya ilmiah dan penelitian pendidikan terakreditasi.
                        </p>
                    </div>
                </a>

                <!-- 6. Majalah -->
                <a href="#" class="group relative flex items-start gap-4 p-6 bg-white/60 hover:bg-white/90 backdrop-blur-md border border-white/80 hover:border-blue-300/60 shadow-lg shadow-slate-200/50 hover:shadow-xl rounded-2xl transition-all duration-300 hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white group-hover:scale-105 transition-all duration-300 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2 mb-1.5">
                            <h3 class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-blue-600 transition-colors">
                                Majalah
                            </h3>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                            Edisi buletin dan majalah berkala instansi.
                        </p>
                    </div>
                </a>

                <!-- 7. Artikel -->
                <a href="#" class="group relative flex items-start gap-4 p-6 bg-white/60 hover:bg-white/90 backdrop-blur-md border border-white/80 hover:border-blue-300/60 shadow-lg shadow-slate-200/50 hover:shadow-xl rounded-2xl transition-all duration-300 hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white group-hover:scale-105 transition-all duration-300 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2 mb-1.5">
                            <h3 class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-blue-600 transition-colors">
                                Artikel
                            </h3>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                            Opini, tulisan edukatif, dan analisis mutu.
                        </p>
                    </div>
                </a>

                <!-- 8. Berita -->
                <a href="#berita" class="group relative flex items-start gap-4 p-6 bg-white/60 hover:bg-white/90 backdrop-blur-md border border-white/80 hover:border-blue-300/60 shadow-lg shadow-slate-200/50 hover:shadow-xl rounded-2xl transition-all duration-300 hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white group-hover:scale-105 transition-all duration-300 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2 mb-1.5">
                            <h3 class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-blue-600 transition-colors">
                                Berita
                            </h3>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                            Kabar kegiatan terkini BPMP Provinsi Sulawesi Tenggara.
                        </p>
                    </div>
                </a>

                <!-- 9. Goes to School -->
                <a href="#" class="group relative flex items-start gap-4 p-6 bg-white/60 hover:bg-white/90 backdrop-blur-md border border-white/80 hover:border-blue-300/60 shadow-lg shadow-slate-200/50 hover:shadow-xl rounded-2xl transition-all duration-300 hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white group-hover:scale-105 transition-all duration-300 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2 mb-1.5">
                            <h3 class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-blue-600 transition-colors">
                                Goes to School
                            </h3>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                            Dokumentasi kunjungan edukasi langsung ke sekolah.
                        </p>
                    </div>
                </a>

            </div>
        </div>
    </section>

    <!-- 6.7 Section SAKIP -->
    <section id="sakip" class="w-full py-16 md:py-24 bg-slate-50 relative border-t border-slate-100 font-sans overflow-hidden">
        <!-- Subtle decorative background blurs -->
        <div class="absolute top-1/3 -right-24 w-80 h-80 bg-blue-400/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-1/4 -left-24 w-80 h-80 bg-indigo-300/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="container mx-auto px-4 max-w-7xl relative z-10">
            <!-- Section Header -->
            <div class="text-center md:text-left mb-12 flex flex-col md:flex-row justify-between items-center md:items-end gap-6">
                <div>
                    <div class="flex items-center justify-center md:justify-start gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h2 class="font-display text-3xl md:text-4xl font-extrabold text-blue-900">SAKIP</h2>
                    </div>
                    <div class="w-20 h-1.5 bg-blue-600 rounded-full mx-auto md:mx-0 mb-4"></div>
                    <p class="text-slate-600 text-sm md:text-base">Transparansi dan akuntabilitas kinerja BPMP Sulawesi Tenggara</p>
                </div>
            </div>

            <!-- Grid 2 Kolom Layout Horizontal / List View -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- 1. RENSTRA -->
                <a href="#" class="flex items-center gap-6 p-6 bg-white/40 backdrop-blur-md border border-white/50 shadow-lg shadow-slate-200/40 rounded-3xl group cursor-pointer transition-all duration-300 hover:bg-white/70 hover:translate-x-2 hover:shadow-xl">
                    <div class="flex-shrink-0 w-16 h-16 flex items-center justify-center bg-blue-100/50 text-blue-600 rounded-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-blue-600 transition-colors tracking-wide mb-1">
                            RENSTRA
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed line-clamp-2">
                            Rencana Strategis jangka menengah lembaga.
                        </p>
                    </div>
                    <div class="flex-shrink-0 text-slate-300 group-hover:text-blue-600 group-hover:translate-x-1.5 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>

                <!-- 2. PERJANJIAN KINERJA -->
                <a href="#" class="flex items-center gap-6 p-6 bg-white/40 backdrop-blur-md border border-white/50 shadow-lg shadow-slate-200/40 rounded-3xl group cursor-pointer transition-all duration-300 hover:bg-white/70 hover:translate-x-2 hover:shadow-xl">
                    <div class="flex-shrink-0 w-16 h-16 flex items-center justify-center bg-blue-100/50 text-blue-600 rounded-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-blue-600 transition-colors tracking-wide mb-1">
                            PERJANJIAN KINERJA
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed line-clamp-2">
                            Komitmen capaian target kinerja tahunan.
                        </p>
                    </div>
                    <div class="flex-shrink-0 text-slate-300 group-hover:text-blue-600 group-hover:translate-x-1.5 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>

                <!-- 3. LAKIN -->
                <a href="#" class="flex items-center gap-6 p-6 bg-white/40 backdrop-blur-md border border-white/50 shadow-lg shadow-slate-200/40 rounded-3xl group cursor-pointer transition-all duration-300 hover:bg-white/70 hover:translate-x-2 hover:shadow-xl">
                    <div class="flex-shrink-0 w-16 h-16 flex items-center justify-center bg-blue-100/50 text-blue-600 rounded-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-blue-600 transition-colors tracking-wide mb-1">
                            LAKIN
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed line-clamp-2">
                            Laporan Akuntabilitas Kinerja Instansi Pemerintah.
                        </p>
                    </div>
                    <div class="flex-shrink-0 text-slate-300 group-hover:text-blue-600 group-hover:translate-x-1.5 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>

                <!-- 4. LHE -->
                <a href="#" class="flex items-center gap-6 p-6 bg-white/40 backdrop-blur-md border border-white/50 shadow-lg shadow-slate-200/40 rounded-3xl group cursor-pointer transition-all duration-300 hover:bg-white/70 hover:translate-x-2 hover:shadow-xl">
                    <div class="flex-shrink-0 w-16 h-16 flex items-center justify-center bg-blue-100/50 text-blue-600 rounded-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-blue-600 transition-colors tracking-wide mb-1">
                            LHE
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed line-clamp-2">
                            Laporan Hasil Evaluasi akuntabilitas kinerja.
                        </p>
                    </div>
                    <div class="flex-shrink-0 text-slate-300 group-hover:text-blue-600 group-hover:translate-x-1.5 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>

                <!-- 5. LK -->
                <a href="#" class="flex items-center gap-6 p-6 bg-white/40 backdrop-blur-md border border-white/50 shadow-lg shadow-slate-200/40 rounded-3xl group cursor-pointer transition-all duration-300 hover:bg-white/70 hover:translate-x-2 hover:shadow-xl">
                    <div class="flex-shrink-0 w-16 h-16 flex items-center justify-center bg-blue-100/50 text-blue-600 rounded-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-blue-600 transition-colors tracking-wide mb-1">
                            LK
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed line-clamp-2">
                            Laporan Kinerja berkala.
                        </p>
                    </div>
                    <div class="flex-shrink-0 text-slate-300 group-hover:text-blue-600 group-hover:translate-x-1.5 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>

                <!-- 6. DIPA 2026 -->
                <a href="#" class="flex items-center gap-6 p-6 bg-white/40 backdrop-blur-md border border-white/50 shadow-lg shadow-slate-200/40 rounded-3xl group cursor-pointer transition-all duration-300 hover:bg-white/70 hover:translate-x-2 hover:shadow-xl">
                    <div class="flex-shrink-0 w-16 h-16 flex items-center justify-center bg-blue-100/50 text-blue-600 rounded-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-blue-600 transition-colors tracking-wide mb-1">
                            DIPA 2026
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed line-clamp-2">
                            Daftar Isian Pelaksanaan Anggaran tahun 2026.
                        </p>
                    </div>
                    <div class="flex-shrink-0 text-slate-300 group-hover:text-blue-600 group-hover:translate-x-1.5 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>

            </div>
        </div>
    </section>

    <!-- 7. Media Sosial Section -->
    <section class="py-24 bg-slate-50 relative border-t border-gray-100" x-data="{ platform: 'instagram' }">
        <script src="https://elfsightcdn.com/platform.js" async></script>
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header (Centered) -->
            <div class="text-center mb-12 flex flex-col items-center">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-pink-100 text-pink-600 font-bold tracking-wider text-xs uppercase mb-4 border border-pink-200 shadow-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"></path></svg>
                    MEDIA SOSIAL
                </span>
                <h2 class="font-display text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Terhubung dengan Kami</h2>
                <div class="w-20 h-1.5 bg-pink-500 rounded-full mb-6"></div>
                <p class="text-gray-500 max-w-2xl mx-auto leading-relaxed text-sm md:text-base">
                    Ikuti akun media sosial BPMP Provinsi Sulawesi Tenggara dan dapatkan informasi terbaru, kegiatan, serta konten edukatif menarik.
                </p>
            </div>

            <!-- Platform Tabs (Toggle Buttons) -->
            <div class="flex justify-center mb-10">
                <div class="inline-flex bg-white p-1.5 rounded-full shadow-sm border border-gray-100 gap-1 overflow-x-auto max-w-full">
                    <button @click="platform = 'instagram'" :class="platform === 'instagram' ? 'bg-gradient-to-r from-pink-500 via-red-500 to-yellow-500 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50'" class="flex items-center gap-2 px-6 py-2.5 rounded-full font-bold text-sm transition-all duration-300 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"></path></svg>
                        Instagram
                    </button>
                    <button @click="platform = 'tiktok'" :class="platform === 'tiktok' ? 'bg-black text-white shadow-md' : 'text-gray-600 hover:bg-gray-50'" class="flex items-center gap-2 px-6 py-2.5 rounded-full font-bold text-sm transition-all duration-300 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.28 6.28 0 005.4 15.6a6.28 6.28 0 0012.06 3.05 6.29 6.29 0 002.13-4.69V10.6a8.2 8.2 0 003.81 1.13V8.28a5 5 0 01-3.81-1.59z"/></svg>
                        TikTok
                    </button>
                    <button @click="platform = 'youtube'" :class="platform === 'youtube' ? 'bg-red-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50'" class="flex items-center gap-2 px-6 py-2.5 rounded-full font-bold text-sm transition-all duration-300 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        YouTube
                    </button>
                </div>
            </div>

            <!-- Main Content Card (Instagram Feed Container) -->
            <div x-show="platform === 'instagram'" x-transition.opacity.duration.500ms class="bg-white rounded-3xl shadow-lg border border-gray-100 p-6 md:p-8 lg:p-10 w-full mx-auto w-full overflow-hidden">
                
                <!-- Instagram Profile Header Top Row -->
                <div class="flex items-center justify-between mb-8 pb-6 border-b border-gray-100">
                    <div class="flex items-center gap-4">
                        <!-- Instagram gradient ring avatar -->
                        <div class="w-12 h-12 rounded-full p-[2px] bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-600 flex-shrink-0">
                            <div class="w-full h-full bg-white rounded-full p-[2px]">
                                <img src="{{ asset('tutwurihandayani.png') }}" alt="Avatar" class="w-full h-full rounded-full object-contain">
                            </div>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-base md:text-lg">BPMP Sultra di Instagram</h3>
                            <p class="text-gray-500 text-sm">@bpmpsultra</p>
                        </div>
                    </div>
                    <a href="https://www.instagram.com/bpmpsultra/" target="_blank" class="px-5 py-2 bg-gradient-to-r from-pink-500 to-rose-500 text-white text-sm font-bold rounded-full shadow-sm hover:shadow-md hover:scale-105 transition-all flex-shrink-0">
                        Follow Kami
                    </a>
                </div>

                <!-- Instagram Stats Middle Row -->
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6 md:gap-10 mb-10 px-0 md:px-4">
                    <div class="w-24 h-24 md:w-32 md:h-32 rounded-full p-1 bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-600 flex-shrink-0">
                        <div class="w-full h-full bg-white rounded-full p-1">
                            <img src="{{ asset('tutwurihandayani.png') }}" alt="Profile" class="w-full h-full rounded-full object-contain bg-gray-50">
                        </div>
                    </div>
                    <div class="flex flex-col gap-4 flex-grow w-full text-center md:text-left">
                        <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-6">
                            <h2 class="text-xl md:text-2xl font-medium text-gray-900">bpmpsultra</h2>
                            <div class="flex gap-2 justify-center">
                                <a href="https://www.instagram.com/bpmpsultra/" target="_blank" class="px-6 py-1.5 bg-[#0095f6] hover:bg-[#1877f2] text-white font-bold text-sm rounded-lg transition-colors">Follow</a>
                                <button class="px-6 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-900 font-bold text-sm rounded-lg transition-colors">Message</button>
                            </div>
                        </div>
                        <div class="flex gap-6 justify-center md:justify-start">
                            <span class="text-gray-900"><span class="font-bold">814</span> posts</span>
                            <span class="text-gray-900"><span class="font-bold">6K</span> followers</span>
                            <span class="text-gray-900"><span class="font-bold">217</span> following</span>
                        </div>
                        <div>
                            <span class="font-bold text-gray-900 text-sm block">BPMP SULTRA</span>
                            <p class="text-gray-800 text-sm">Kementerian Pendidikan Dasar dan Menengah</p>
                            <p class="text-blue-900 text-sm font-medium">www.bpmpsultra.kemdikbud.go.id</p>
                        </div>
                    </div>
                </div>

                <!-- Grid Layout for Posts -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Post 1 -->
                    <div class="border border-gray-100 rounded-xl overflow-hidden hover:shadow-lg transition-shadow bg-white flex flex-col">
                        <!-- Top bar -->
                        <div class="flex items-center justify-between p-3">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full p-[1.5px] bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-600">
                                    <div class="w-full h-full bg-white rounded-full p-[1px]">
                                        <img src="{{ asset('tutwurihandayani.png') }}" alt="Avatar" class="w-full h-full rounded-full object-contain">
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-gray-900">bpmpsultra</span>
                            </div>
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"></path></svg>
                        </div>
                        <!-- Image area -->
                        <div class="relative w-full aspect-[4/5] bg-gray-100">
                            <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Post Image" class="w-full h-full object-cover">
                        </div>
                        <!-- Bottom bar -->
                        <div class="p-3">
                            <div class="flex items-center gap-3 mb-2">
                                <svg class="w-5 h-5 text-gray-800 hover:text-gray-500 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                <svg class="w-5 h-5 text-gray-800 hover:text-gray-500 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                <svg class="w-5 h-5 text-gray-800 hover:text-gray-500 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                            </div>
                            <p class="text-xs font-bold text-gray-900 mb-1">124 likes</p>
                            <p class="text-xs text-gray-800 line-clamp-2"><span class="font-bold">bpmpsultra</span> Kegiatan Evaluasi Implementasi Rapor Pendidikan tingkat provinsi Sulawesi Tenggara...</p>
                        </div>
                    </div>

                    <!-- Post 2 -->
                    <div class="border border-gray-100 rounded-xl overflow-hidden hover:shadow-lg transition-shadow bg-white flex flex-col">
                        <!-- Top bar -->
                        <div class="flex items-center justify-between p-3">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full p-[1.5px] bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-600">
                                    <div class="w-full h-full bg-white rounded-full p-[1px]">
                                        <img src="{{ asset('tutwurihandayani.png') }}" alt="Avatar" class="w-full h-full rounded-full object-contain">
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-gray-900">bpmpsultra</span>
                            </div>
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"></path></svg>
                        </div>
                        <!-- Image area -->
                        <div class="relative w-full aspect-[4/5] bg-gray-100">
                            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Post Image" class="w-full h-full object-cover">
                        </div>
                        <!-- Bottom bar -->
                        <div class="p-3">
                            <div class="flex items-center gap-3 mb-2">
                                <svg class="w-5 h-5 text-gray-800 hover:text-gray-500 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                <svg class="w-5 h-5 text-gray-800 hover:text-gray-500 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                <svg class="w-5 h-5 text-gray-800 hover:text-gray-500 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                            </div>
                            <p class="text-xs font-bold text-gray-900 mb-1">98 likes</p>
                            <p class="text-xs text-gray-800 line-clamp-2"><span class="font-bold">bpmpsultra</span> Sinergi BPMP bersama Dinas Pendidikan dalam menyukseskan program prioritas nasional.</p>
                        </div>
                    </div>

                    <!-- Post 3 -->
                    <div class="border border-gray-100 rounded-xl overflow-hidden hover:shadow-lg transition-shadow bg-white flex flex-col">
                        <!-- Top bar -->
                        <div class="flex items-center justify-between p-3">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full p-[1.5px] bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-600">
                                    <div class="w-full h-full bg-white rounded-full p-[1px]">
                                        <img src="{{ asset('tutwurihandayani.png') }}" alt="Avatar" class="w-full h-full rounded-full object-contain">
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-gray-900">bpmpsultra</span>
                            </div>
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"></path></svg>
                        </div>
                        <!-- Image area -->
                        <div class="relative w-full aspect-[4/5] bg-gray-100">
                            <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Post Image" class="w-full h-full object-cover">
                        </div>
                        <!-- Bottom bar -->
                        <div class="p-3">
                            <div class="flex items-center gap-3 mb-2">
                                <svg class="w-5 h-5 text-gray-800 hover:text-gray-500 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                <svg class="w-5 h-5 text-gray-800 hover:text-gray-500 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                <svg class="w-5 h-5 text-gray-800 hover:text-gray-500 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                            </div>
                            <p class="text-xs font-bold text-gray-900 mb-1">210 likes</p>
                            <p class="text-xs text-gray-800 line-clamp-2"><span class="font-bold">bpmpsultra</span> Sosialisasi peningkatkan literasi numerasi bersama komunitas guru penggerak.</p>
                        </div>
                    </div>

                    <!-- Post 4 -->
                    <div class="border border-gray-100 rounded-xl overflow-hidden hover:shadow-lg transition-shadow bg-white flex flex-col">
                        <!-- Top bar -->
                        <div class="flex items-center justify-between p-3">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full p-[1.5px] bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-600">
                                    <div class="w-full h-full bg-white rounded-full p-[1px]">
                                        <img src="{{ asset('tutwurihandayani.png') }}" alt="Avatar" class="w-full h-full rounded-full object-contain">
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-gray-900">bpmpsultra</span>
                            </div>
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"></path></svg>
                        </div>
                        <!-- Image area -->
                        <div class="relative w-full aspect-[4/5] bg-gray-100">
                            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Post Image" class="w-full h-full object-cover">
                        </div>
                        <!-- Bottom bar -->
                        <div class="p-3">
                            <div class="flex items-center gap-3 mb-2">
                                <svg class="w-5 h-5 text-gray-800 hover:text-gray-500 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                <svg class="w-5 h-5 text-gray-800 hover:text-gray-500 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                <svg class="w-5 h-5 text-gray-800 hover:text-gray-500 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                            </div>
                            <p class="text-xs font-bold text-gray-900 mb-1">156 likes</p>
                            <p class="text-xs text-gray-800 line-clamp-2"><span class="font-bold">bpmpsultra</span> Kunjungan lapangan di wilayah 3T untuk memastikan akses pendidikan yang merata.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- TikTok Panel -->
            <div x-show="platform === 'tiktok'" x-transition.opacity.duration.500ms style="display: none;" class="bg-white rounded-3xl shadow-lg border border-gray-100 p-6 md:p-8 lg:p-10 w-full mx-auto">
                <div class="flex items-center justify-between mb-8 pb-6 border-b border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full p-[2px] bg-black flex-shrink-0">
                            <div class="w-full h-full bg-white rounded-full p-[2px]">
                                <img src="{{ asset('tutwurihandayani.png') }}" alt="Avatar" class="w-full h-full rounded-full object-contain">
                            </div>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-base md:text-lg">BPMP Sultra di TikTok</h3>
                            <p class="text-gray-500 text-sm">@bpmp.sulawesitenggara</p>
                        </div>
                    </div>
                    <a href="https://www.tiktok.com/@bpmp.sulawesitenggara" target="_blank" class="px-5 py-2 bg-black text-white text-sm font-bold rounded-full shadow-sm hover:shadow-md hover:scale-105 transition-all flex-shrink-0">
                        Follow Kami
                    </a>
                </div>
                
                <!-- Elfsight TikTok Widget -->
                <div class="elfsight-app-5f5a5923-4bd1-4aaa-a109-7680e293f81a" data-elfsight-app-lazy></div>
            </div>

            <!-- YouTube Panel -->
            <div x-show="platform === 'youtube'" x-transition.opacity.duration.500ms style="display: none;" class="bg-white rounded-3xl shadow-lg border border-gray-100 p-6 md:p-8 lg:p-10 w-full mx-auto">
                <div class="flex items-center justify-between mb-8 pb-6 border-b border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full p-[2px] bg-red-600 flex-shrink-0">
                            <div class="w-full h-full bg-white rounded-full p-[2px]">
                                <img src="{{ asset('tutwurihandayani.png') }}" alt="Avatar" class="w-full h-full rounded-full object-contain">
                            </div>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-base md:text-lg">BPMP Sultra di YouTube</h3>
                            <p class="text-gray-500 text-sm">@bpmpsultra</p>
                        </div>
                    </div>
                    <a href="https://www.youtube.com/@bpmpsultra" target="_blank" class="px-5 py-2 bg-red-600 text-white text-sm font-bold rounded-full shadow-sm hover:shadow-md hover:scale-105 transition-all flex-shrink-0">
                        Subscribe
                    </a>
                </div>
                
                <!-- Elfsight YouTube Widget -->
                <div class="elfsight-app-0bbc46c3-7224-4e01-804d-243726b1c183" data-elfsight-app-lazy></div>
            </div>

        </div>
    </section>

    <!-- 8. Statistik Kinerja (Dark Section) -->
    <section class="py-24 bg-blue-950 relative overflow-hidden">
        <!-- Subtle Pattern -->
        <div class="absolute inset-0 opacity-10" style="background-image: linear-gradient(30deg, #1d4ed8 12%, transparent 12.5%, transparent 87%, #1d4ed8 87.5%, #1d4ed8), linear-gradient(150deg, #1d4ed8 12%, transparent 12.5%, transparent 87%, #1d4ed8 87.5%, #1d4ed8), linear-gradient(30deg, #1d4ed8 12%, transparent 12.5%, transparent 87%, #1d4ed8 87.5%, #1d4ed8), linear-gradient(150deg, #1d4ed8 12%, transparent 12.5%, transparent 87%, #1d4ed8 87.5%, #1d4ed8), linear-gradient(60deg, #1d4ed877 25%, transparent 25.5%, transparent 75%, #1d4ed877 75%, #1d4ed877), linear-gradient(60deg, #1d4ed877 25%, transparent 25.5%, transparent 75%, #1d4ed877 75%, #1d4ed877); background-size: 80px 140px; background-position: 0 0, 0 0, 40px 70px, 40px 70px, 0 0, 40px 70px;"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <span class="text-blue-400 font-bold tracking-wider text-sm uppercase mb-2 block">Dampak & Capaian</span>
                <h2 class="font-display text-3xl md:text-4xl font-extrabold text-white mb-4">Statistik <span class="text-blue-400">Kinerja</span></h2>
                <div class="w-20 h-1.5 bg-blue-500 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 lg:gap-8">
                <!-- Stat 1 -->
                <div class="bg-blue-900/50 backdrop-blur-md rounded-3xl p-8 text-center border border-blue-800 shadow-[0_0_30px_rgba(37,99,235,0.15)] hover:bg-blue-800/60 transition-colors">
                    <h3 class="font-display text-4xl md:text-5xl font-extrabold text-white mb-3 drop-shadow-md">17</h3>
                    <p class="text-blue-300 text-xs md:text-sm font-bold uppercase tracking-wider">Kab/Kota Terjangkau</p>
                </div>
                <!-- Stat 2 -->
                <div class="bg-blue-900/50 backdrop-blur-md rounded-3xl p-8 text-center border border-blue-800 shadow-[0_0_30px_rgba(37,99,235,0.15)] hover:bg-blue-800/60 transition-colors">
                    <h3 class="font-display text-4xl md:text-5xl font-extrabold text-white mb-3 drop-shadow-md">4.5K</h3>
                    <p class="text-blue-300 text-xs md:text-sm font-bold uppercase tracking-wider">Sekolah Sasaran</p>
                </div>
                <!-- Stat 3 -->
                <div class="bg-blue-900/50 backdrop-blur-md rounded-3xl p-8 text-center border border-blue-800 shadow-[0_0_30px_rgba(37,99,235,0.15)] hover:bg-blue-800/60 transition-colors">
                    <h3 class="font-display text-4xl md:text-5xl font-extrabold text-white mb-3 drop-shadow-md">98%</h3>
                    <p class="text-blue-300 text-xs md:text-sm font-bold uppercase tracking-wider">Kepuasan Layanan</p>
                </div>
                <!-- Stat 4 -->
                <div class="bg-blue-900/50 backdrop-blur-md rounded-3xl p-8 text-center border border-blue-800 shadow-[0_0_30px_rgba(37,99,235,0.15)] hover:bg-blue-800/60 transition-colors">
                    <h3 class="font-display text-4xl md:text-5xl font-extrabold text-white mb-3 drop-shadow-md">24h</h3>
                    <p class="text-blue-300 text-xs md:text-sm font-bold uppercase tracking-wider">Waktu Respon</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 9. Lokasi, Jam Kerja & Kontak Form -->
    <section id="kontak" class="py-24 bg-white relative">
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Centered Header -->
            <div class="text-center mb-16">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 font-bold tracking-wider text-xs uppercase mb-3 border border-blue-200 shadow-sm">
                    Hubungi Kami
                </span>
                <h2 class="font-display text-3xl md:text-4xl font-extrabold text-blue-900 mb-4">
                    Kontak & Lokasi <span class="text-blue-600">Pelayanan</span>
                </h2>
                <div class="w-20 h-1.5 bg-blue-600 mx-auto rounded-full"></div>
            </div>

            <!-- Map Sub-header -->
            <div class="mb-6 text-center md:text-left">
                <h3 class="font-display text-2xl font-extrabold text-blue-900 mb-2">Lokasi Kantor Operasional BPMP Sultra</h3>
                <p class="text-gray-600 font-medium">Jl. D.I. Panjaitan No. 83, Wundudopi, Kota Kendari, Sulawesi Tenggara</p>
            </div>

            <!-- Google Maps -->
            <div class="w-full aspect-[21/9] bg-gray-100 rounded-2xl overflow-hidden mb-16 border border-slate-200/80 shadow-lg relative">
                <iframe 
                    src="https://maps.google.com/maps?q=BPMP+Sultra,+Jl.+DI+Panjaitan,+Kendari&t=&z=17&ie=UTF8&iwloc=&output=embed" 
                    class="w-full h-full border-0" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            <div class="flex flex-col lg:flex-row gap-10 lg:gap-14 items-start" x-data="{ activeFormTab: 'spmb' }">
                <!-- Kolom Kiri: Form SPMB & Pesan (Gaya Presisi Sesuai Referensi Gambar) -->
                <div class="w-full lg:w-3/5 bg-white rounded-3xl p-6 sm:p-8 md:p-10 border border-slate-200/90 shadow-xl shadow-slate-100">
                    
                    <!-- Pilihan Tab: Pengaduan SPMB / Kirim Pesan -->
                    <div class="flex items-center gap-2 p-1.5 bg-slate-100 rounded-2xl mb-8 max-w-sm border border-slate-200/60">
                        <button type="button" @click="activeFormTab = 'spmb'"
                                :class="activeFormTab === 'spmb' ? 'bg-white text-blue-900 shadow-sm font-extrabold' : 'text-slate-600 hover:text-slate-900 font-bold'"
                                class="flex-1 py-2.5 px-4 rounded-xl text-xs sm:text-sm transition-all flex items-center justify-center gap-2 cursor-pointer">
                            <span>📢</span>
                            <span>Pengaduan SPMB</span>
                        </button>
                        <button type="button" @click="activeFormTab = 'pesan'"
                                :class="activeFormTab === 'pesan' ? 'bg-white text-blue-900 shadow-sm font-extrabold' : 'text-slate-600 hover:text-slate-900 font-bold'"
                                class="flex-1 py-2.5 px-4 rounded-xl text-xs sm:text-sm transition-all flex items-center justify-center gap-2 cursor-pointer">
                            <span>✉️</span>
                            <span>Kirim Pesan</span>
                        </button>
                    </div>

                    @if(session('success'))
                        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-2 mb-6">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- TAB 1: FORMULIR PENGADUAN MASYARAKAT (SPMB) - Persis Gambar 1 -->
                    <div x-show="activeFormTab === 'spmb'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="mb-7 pb-4 border-b border-slate-100">
                            <h3 class="font-display text-2xl sm:text-3xl font-extrabold text-slate-900 mb-1.5" style="color: #0f172a;">
                                Formulir Pengaduan Masyarakat (SPMB)
                            </h3>
                            <p class="text-sm text-slate-500 font-medium">
                                Silakan isi formulir di bawah ini dengan data yang valid dan uraian pengaduan yang jelas.
                            </p>
                        </div>

                        <form action="{{ route('spmb.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            <input type="hidden" name="category" value="spmb">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-2">NAMA ANDA *</label>
                                    <input type="text" name="name" required value="{{ old('name') }}" placeholder="Nama Lengkap..."
                                           style="color: #0f172a !important; -webkit-text-fill-color: #0f172a !important;"
                                           class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 font-semibold text-sm placeholder:text-slate-400 placeholder:font-normal focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all outline-none">
                                    @error('name') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-2">EMAIL *</label>
                                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="nama@email.com"
                                           style="color: #0f172a !important; -webkit-text-fill-color: #0f172a !important;"
                                           class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 font-semibold text-sm placeholder:text-slate-400 placeholder:font-normal focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all outline-none">
                                    @error('email') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-2">NOMOR HP / WHATSAPP *</label>
                                    <input type="tel" name="phone" required value="{{ old('phone') }}" placeholder="08xxxxxxxxxx"
                                           style="color: #0f172a !important; -webkit-text-fill-color: #0f172a !important;"
                                           class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 font-semibold text-sm placeholder:text-slate-400 placeholder:font-normal focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all outline-none">
                                    @error('phone') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-2">ALAMAT ANDA *</label>
                                    <input type="text" name="address" required value="{{ old('address') }}" placeholder="Kota Kendari..."
                                           style="color: #0f172a !important; -webkit-text-fill-color: #0f172a !important;"
                                           class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 font-semibold text-sm placeholder:text-slate-400 placeholder:font-normal focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all outline-none">
                                    @error('address') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-2">ISI PENGADUAN *</label>
                                <textarea name="complaint" rows="4" required placeholder="Tuliskan isi pengaduan Anda di sini secara detail..."
                                          style="color: #0f172a !important; -webkit-text-fill-color: #0f172a !important;"
                                          class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 font-semibold text-sm placeholder:text-slate-400 placeholder:font-normal focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all outline-none resize-none">{{ old('complaint') }}</textarea>
                                @error('complaint') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-2">LENGKAPI LAPORAN DENGAN MELAMPIRKAN BUKTI KEJADIAN (OPSIONAL)</label>
                                <input type="file" name="evidence_file" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                                       style="color: #0f172a !important; -webkit-text-fill-color: #0f172a !important;"
                                       class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-700 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer">
                                @error('evidence_file') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="submit" class="px-8 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-600/30 transition-all hover:-translate-y-0.5 inline-flex items-center gap-2 cursor-pointer text-sm">
                                    <span>Kirim Pengaduan</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- TAB 2: KIRIM PESAN & PERTANYAAN -->
                    <div x-show="activeFormTab === 'pesan'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                        <div class="mb-7 pb-4 border-b border-slate-100">
                            <h3 class="font-display text-2xl sm:text-3xl font-extrabold text-slate-900 mb-1.5" style="color: #0f172a;">
                                Kirim Pesan &amp; Pertanyaan
                            </h3>
                            <p class="text-sm text-slate-500 font-medium">
                                Sampaikan pesan, masukan, atau pertanyaan langsung ke pihak BPMP Provinsi Sulawesi Tenggara.
                            </p>
                        </div>

                        <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-2">NAMA LENGKAP *</label>
                                    <input type="text" name="name" required value="{{ old('name') }}" placeholder="Masukkan nama Anda..."
                                           style="color: #0f172a !important; -webkit-text-fill-color: #0f172a !important;"
                                           class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 font-semibold text-sm placeholder:text-slate-400 placeholder:font-normal focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all outline-none">
                                    @error('name') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-2">EMAIL *</label>
                                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="alamat@email.com"
                                           style="color: #0f172a !important; -webkit-text-fill-color: #0f172a !important;"
                                           class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 font-semibold text-sm placeholder:text-slate-400 placeholder:font-normal focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all outline-none">
                                    @error('email') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-2">SUBJEK *</label>
                                <input type="text" name="subject" required value="{{ old('subject') }}" placeholder="Perihal pesan..."
                                       style="color: #0f172a !important; -webkit-text-fill-color: #0f172a !important;"
                                       class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 font-semibold text-sm placeholder:text-slate-400 placeholder:font-normal focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all outline-none">
                                @error('subject') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-2">PESAN *</label>
                                <textarea rows="4" name="message" required placeholder="Tuliskan pesan atau pertanyaan Anda di sini..."
                                          style="color: #0f172a !important; -webkit-text-fill-color: #0f172a !important;"
                                          class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 font-semibold text-sm placeholder:text-slate-400 placeholder:font-normal focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all outline-none resize-none">{{ old('message') }}</textarea>
                                @error('message') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="submit" class="px-8 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-600/30 transition-all hover:-translate-y-0.5 inline-flex items-center gap-2 cursor-pointer text-sm">
                                    <span>Kirim Pesan Sekarang</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

                <!-- Info Kontak & Jam Kerja (Kolom Kanan) -->
                <div class="w-full lg:w-2/5">
                    <span class="text-blue-600 font-bold tracking-wider text-xs uppercase mb-2 block">Informasi Layanan</span>
                    <h3 class="font-display text-2xl sm:text-3xl font-extrabold text-blue-900 mb-6">Jam Kerja &amp; Lokasi</h3>
                    
                    <div class="bg-white p-7 md:p-8 rounded-3xl border border-slate-200/90 shadow-xl shadow-slate-100 space-y-8">
                        <!-- Lokasi -->
                        <div class="flex gap-4 items-start">
                            <div class="w-12 h-12 shrink-0 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-extrabold text-slate-900 text-base mb-1">Alamat Kantor</h4>
                                <p class="text-slate-600 text-sm leading-relaxed">Jl. D.I. Panjaitan No. 83, Wundudopi, Kec. Baruga, Kota Kendari, Sulawesi Tenggara 93116</p>
                            </div>
                        </div>

                        <!-- Jam Kerja -->
                        <div class="flex gap-4 items-start">
                            <div class="w-12 h-12 shrink-0 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="w-full">
                                <h4 class="font-extrabold text-slate-900 text-base mb-2">Jam Pelayanan</h4>
                                <div class="space-y-2 text-sm text-slate-600">
                                    <div class="flex justify-between border-b border-slate-100 pb-1.5">
                                        <span class="font-medium">Senin - Kamis</span>
                                        <span class="font-bold text-slate-900">07.30 - 16.00</span>
                                    </div>
                                    <div class="flex justify-between border-b border-slate-100 pb-1.5">
                                        <span class="font-medium">Jumat</span>
                                        <span class="font-bold text-slate-900">07.30 - 16.30</span>
                                    </div>
                                    <p class="text-xs text-rose-600 font-bold mt-2.5">*Sabtu, Minggu &amp; Libur Nasional Tutup</p>
                                </div>
                            </div>
                        </div>

                        <!-- Telepon/Email -->
                        <div class="flex gap-4 items-start">
                            <div class="w-12 h-12 shrink-0 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-extrabold text-slate-900 text-base mb-1">Email Resmi</h4>
                                <a href="mailto:bpmpsultra@kemendikdasmen.go.id" class="text-blue-600 hover:text-blue-800 text-sm font-bold transition-colors">bpmpsultra@kemendikdasmen.go.id</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>

    <!-- 10. Global Footer -->
    <x-footer />

    
    
    
    <!-- KOMPONEN AKSESIBILITAS & FLOATING BUTTONS -->
    <x-accessibility />
<!-- HERO TYPEWRITER SEARCH SCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('hero-typewriter-input');
            if (!input) return;

            const phrases = [
                "Cari informasi layanan publik...",
                "Cari info konsultasi mutu pendidikan...",
                "Cari data & statistik sekolah...",
                "Cari agenda kegiatan & pelatihan...",
                "Cari berita terbaru BPMP Sultra..."
            ];

            let phraseIndex = 0;
            let charIndex = 0;
            let isDeleting = false;
            let typingSpeed = 70;
            let pauseTime = 2000;
            let isFocused = false;

            input.addEventListener('focus', () => {
                isFocused = true;
                input.setAttribute('placeholder', 'Ketik kata kunci lalu tekan Enter...');
            });

            input.addEventListener('blur', () => {
                isFocused = false;
                if (input.value === '') {
                    input.setAttribute('placeholder', phrases[phraseIndex].substring(0, charIndex));
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' && input.value.trim() !== '') {
                    window.location.href = `{{ url('/berita') }}?q=${encodeURIComponent(input.value.trim())}`;
                }
            });

            function type() {
                if (isFocused && input.value !== '') return;

                const currentPhrase = phrases[phraseIndex];

                if (isDeleting) {
                    charIndex--;
                    typingSpeed = 35;
                } else {
                    charIndex++;
                    typingSpeed = 70;
                }

                if (!isFocused) {
                    input.setAttribute('placeholder', currentPhrase.substring(0, charIndex));
                }

                if (!isDeleting && charIndex === currentPhrase.length) {
                    isDeleting = true;
                    typingSpeed = pauseTime;
                } else if (isDeleting && charIndex === 0) {
                    isDeleting = false;
                    phraseIndex = (phraseIndex + 1) % phrases.length;
                    typingSpeed = 400;
                }

                setTimeout(type, typingSpeed);
            }

            setTimeout(type, 1000);
        });
    </script>


</body>
</html>