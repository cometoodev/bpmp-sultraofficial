<!DOCTYPE html>
<html lang="id" class="scroll-smooth overflow-x-hidden w-full max-w-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
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
        body { font-family: 'Poppins', sans-serif; }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
    </style>
</head>
<body class="bg-slate-900 text-white antialiased overflow-x-hidden w-full max-w-full selection:bg-blue-600 selection:text-white">

    <!-- 4. Glassmorphism Navbar (Fixed to top to overlay Hero) -->
    <x-navbar />

    <!-- 6. Background Slider & 5. Hero Section Text -->
    <section class="relative min-h-[90vh] flex flex-col justify-between overflow-hidden pt-24 pb-0" style="font-family: 'Plus Jakarta Sans', sans-serif;"
             x-data="{ 
                 slides: ['/fotoheader/slide1.png', '/fotoheader/slide2.png', '/fotoheader/slide3.png'], 
                 activeSlide: 0 
             }" 
             x-init="setInterval(() => { activeSlide = (activeSlide + 1) % slides.length }, 5000)">
        
        <!-- Image Slider (Alpine.js) -->
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index" 
                 x-transition:enter="transition-opacity duration-1000 ease-in-out"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity duration-1000 ease-in-out"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0 z-0 w-full h-full object-cover">
                <img :src="slide" alt="Hero Slide" class="w-full h-full object-cover">
            </div>
        </template>
        
        <!-- Dark Overlay for contrast -->
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/80 via-slate-900/50 to-slate-950/60 z-0"></div>

        <!-- 2-Column Hero Content Container -->
        <div class="relative z-10 my-auto py-12 max-w-[1400px] mx-auto px-6 lg:px-12 grid grid-cols-1 lg:grid-cols-12 gap-10 items-center w-full">
            
            <!-- Left Column -->
            <div class="lg:col-span-7 space-y-5">
                <!-- Top Badge -->
                <div class="inline-flex items-center gap-3 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs sm:text-sm font-semibold text-slate-100 shadow-sm">
                    <span class="relative flex h-2.5 w-2.5">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-blue-500"></span>
                    </span>
                    <span>Kemendikdasmen &bull; BPMP Sulawesi Tenggara</span>
                </div>
                
                <!-- Headline -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-extrabold text-white tracking-tight leading-tight font-['Plus_Jakarta_Sans'] mb-4 pb-2">
                    BALAI PENJAMINAN MUTU PENDIDIKAN
                    <span class="block text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-black text-white drop-shadow-[0_2px_8px_rgba(0,0,0,0.85)] mt-3 pb-3 leading-normal">
                        Provinsi Sulawesi Tenggara
                    </span>
                </h1>
                
                <!-- Paragraph -->
                <p class="text-slate-100 text-base sm:text-lg max-w-2xl leading-relaxed drop-shadow-md mb-6">
                    Pusat penjaminan mutu dan referensi pendidikan berkualitas Provinsi Sulawesi Tenggara untuk mendorong transformasi pembelajaran yang berkeadilan di Bumi Anoa.
                </p>
                
                <!-- CTA Buttons -->
                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="#layanan" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-[0_4px_16px_rgba(37,99,235,0.4)] transition-all hover:scale-105">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Jelajahi Layanan
                    </a>
                    <a href="#berita" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/25 text-white font-medium text-sm transition-all hover:scale-105">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        Berita Terbaru
                    </a>
                </div>
                

            </div>

            <!-- Right Column -->
            <div class="lg:col-span-5 flex justify-center lg:justify-end">
                <!-- Floating circular badge identical to the reference -->
                <div class="relative group">
                    <!-- Subtle glow ring -->
                    <div class="absolute -inset-1 rounded-full bg-gradient-to-r from-sky-400/30 to-blue-600/30 blur-xl opacity-70 group-hover:opacity-100 transition duration-1000"></div>
                    <!-- Glass Circle with Floating Animation -->
                    <div class="relative w-48 h-48 sm:w-60 sm:h-60 rounded-full bg-white/15 backdrop-blur-2xl border-2 border-white/40 shadow-[0_20px_50px_rgba(0,0,0,0.4)] flex items-center justify-center p-8 transition-transform duration-500 hover:scale-105" style="animation: float 6s ease-in-out infinite;">
                        <!-- Internal highlight for depth -->
                        <div class="absolute inset-0 rounded-full bg-gradient-to-br from-white/40 to-transparent opacity-60 pointer-events-none"></div>
                        <img src="{{ asset('tutwurihandayani.png') }}" alt="Tut Wuri Handayani" class="w-full h-full object-contain filter drop-shadow-2xl">
                    </div>
                </div>
            </div>
        </div>

        <!-- Floating Glassmorphism Stats Bar -->
        <div class="relative z-20 w-full max-w-6xl mx-auto px-4 mb-10 sm:mb-12">
            <div class="w-full rounded-2xl bg-white/10 backdrop-blur-xl border border-white/20 shadow-2xl py-6 px-4">
                <div class="grid grid-cols-3 divide-x divide-white/20 text-center text-white">
                    <div class="px-2 flex flex-col items-center justify-center">
                        <div class="text-3xl lg:text-4xl font-extrabold tracking-tight drop-shadow-md">17</div>
                        <div class="text-xs lg:text-sm font-medium tracking-wider text-slate-200 mt-1 uppercase">Kabupaten / Kota</div>
                    </div>
                    <div class="px-2 flex flex-col items-center justify-center">
                        <div class="text-3xl lg:text-4xl font-extrabold tracking-tight drop-shadow-md">8+</div>
                        <div class="text-xs lg:text-sm font-medium tracking-wider text-slate-200 mt-1 uppercase">Layanan Prioritas</div>
                    </div>
                    <div class="px-2 flex flex-col items-center justify-center">
                        <div class="text-3xl lg:text-4xl font-extrabold tracking-tight drop-shadow-md">100%</div>
                        <div class="text-xs lg:text-sm font-medium tracking-wider text-slate-200 mt-1 uppercase">Akses Digital</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: Logo Showcase / Partner Banner (Marquee) -->
    <section class="bg-white dark:bg-[#070d1e] py-10 md:py-14 border-y border-slate-100 dark:border-slate-800/60 relative w-full overflow-hidden z-10">
        
        <style>
            @keyframes marquee-continuous {
                0% { transform: translateX(0); }
                100% { transform: translateX(-33.333333%); }
            }
            .animate-marquee-continuous {
                display: flex;
                width: max-content;
                animation: marquee-continuous 30s linear infinite !important;
                pointer-events: none; /* Prevents pause or cursor interference */
            }
        </style>

        <!-- Left Gradient Mask -->
        <div class="pointer-events-none absolute inset-y-0 left-0 w-24 bg-gradient-to-r from-white dark:from-[#070d1e] to-transparent z-20"></div>
        
        <!-- Right Gradient Mask -->
        <div class="pointer-events-none absolute inset-y-0 right-0 w-24 bg-gradient-to-l from-white dark:from-[#070d1e] to-transparent z-20"></div>

        <div class="animate-marquee-continuous items-center gap-16 md:gap-24 px-8">
            <!-- Set 1 -->
            @foreach(['bangga.png', 'rumahpendidikan.png', 'sehat.png', 'berahlak.png', 'ramah.png', 'pendidikan.png'] as $logo)
                <img src="{{ asset('slidelogo/' . $logo) }}" alt="Logo" class="h-14 md:h-16 lg:h-20 w-auto object-contain shrink-0 dark:brightness-110 dark:drop-shadow-[0_2px_10px_rgba(255,255,255,0.25)]">
            @endforeach
            <!-- Set 2 (Duplicate for continuous loop) -->
            @foreach(['bangga.png', 'rumahpendidikan.png', 'sehat.png', 'berahlak.png', 'ramah.png', 'pendidikan.png'] as $logo)
                <img src="{{ asset('slidelogo/' . $logo) }}" alt="Logo" class="h-14 md:h-16 lg:h-20 w-auto object-contain shrink-0 dark:brightness-110 dark:drop-shadow-[0_2px_10px_rgba(255,255,255,0.25)]">
            @endforeach
            <!-- Set 3 (Buffer) -->
            @foreach(['bangga.png', 'rumahpendidikan.png', 'sehat.png', 'berahlak.png', 'ramah.png', 'pendidikan.png'] as $logo)
                <img src="{{ asset('slidelogo/' . $logo) }}" alt="Logo" class="h-14 md:h-16 lg:h-20 w-auto object-contain shrink-0 dark:brightness-110 dark:drop-shadow-[0_2px_10px_rgba(255,255,255,0.25)]">
            @endforeach
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
            <div class="pt-6">
                <!-- Divider -->
                <div class="w-[100vw] relative left-1/2 -translate-x-1/2 border-t border-blue-500/20 dark:border-blue-400/20 my-10"></div>
                
                <!-- Section Header -->
                <div class="text-center mb-12">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 font-bold tracking-wider text-xs uppercase mb-3 border border-blue-200 shadow-sm">
                        Struktur Organisasi
                    </span>
                    <h2 class="font-display text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
                        Profil Pimpinan <span class="text-blue-600">BPMP Sultra</span>
                    </h2>
                    <div class="w-20 h-1.5 bg-blue-600 mx-auto rounded-full mb-4"></div>
                    <p class="text-gray-500 max-w-2xl mx-auto leading-relaxed">
                        Mengenal jajaran kepemimpinan yang berdedikasi mengawal penjaminan dan peningkatan mutu pendidikan di Sulawesi Tenggara.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-3xl mx-auto">
                    
                    <!-- Kartu 1 -->
                    <div class="w-full max-w-[300px] mx-auto bg-white rounded-[2rem] shadow-[0_8px_30px_rgba(0,0,0,0.08)] border border-gray-100 overflow-hidden flex flex-col transition-transform duration-300 hover:-translate-y-2">
                        <img src="https://ui-avatars.com/api/?name=JP&background=1e3a8a&color=fff&size=500" alt="Kepala BPMP" class="w-full h-80 object-cover rounded-t-[2rem] bg-blue-900">
                        <div class="p-6 text-center bg-white">
                            <h3 class="text-base font-bold text-gray-900">Junaiddin Pagala, S.T., M.T.</h3>
                            <p class="text-xs uppercase text-blue-600 font-bold mt-1 tracking-wider">KEPALA BPMP PROVINSI SULAWESI TENGGARA</p>
                        </div>
                    </div>

                    <!-- Kartu 2 -->
                    <div class="w-full max-w-[300px] mx-auto bg-white rounded-[2rem] shadow-[0_8px_30px_rgba(0,0,0,0.08)] border border-gray-100 overflow-hidden flex flex-col transition-transform duration-300 hover:-translate-y-2">
                        <img src="https://ui-avatars.com/api/?name=RM&background=1e3a8a&color=fff&size=500" alt="Kasubbag Umum" class="w-full h-80 object-cover rounded-t-[2rem] bg-blue-900">
                        <div class="p-6 text-center bg-white">
                            <h3 class="text-base font-bold text-gray-900">Rika Ernita Mekuo, S.Si., M.Si.</h3>
                            <p class="text-xs uppercase text-blue-600 font-bold mt-1 tracking-wider">KASUBBAG UMUM BPMP SULTRA</p>
                        </div>
                    </div>
                    
                </div>
                
                <!-- The Quote Box -->
                <div class="max-w-4xl mx-auto mt-8 bg-slate-50 border border-gray-200 rounded-3xl p-8 flex flex-col sm:flex-row gap-6 items-start shadow-sm">
                    <div class="text-blue-200 text-6xl font-serif leading-none mt-2">"</div>
                    <div>
                        <p class="italic text-gray-700 leading-relaxed text-lg">Berkomitmen penuh mewujudkan Zona Integritas Wilayah Bebas dari Korupsi (ZI WBK) dan Pelayanan Prima bagi seluruh insan pendidikan serta mendukung tata kelola organisasi yang transparan dan akuntabel.</p>
                        <span class="font-bold text-gray-900 text-sm mt-4 block">Pimpinan BPMP Provinsi Sulawesi Tenggara</span>
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

    <!-- 5. Agenda & Multimedia (Split Section) -->
    <section class="py-20 bg-white relative border-t border-gray-200">
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Centered Header -->
            <div class="text-center mb-16">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 font-bold tracking-wider text-xs uppercase mb-3 border border-blue-200 shadow-sm">
                    Informasi Terpadu
                </span>
                <h2 class="font-display text-3xl md:text-4xl font-extrabold text-blue-900 mb-4">
                    Jadwal Kegiatan & <span class="text-blue-600">Media Edukasi</span>
                </h2>
                <div class="w-20 h-1.5 bg-blue-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
                <!-- Left: Calendar Widget (Interactive Alpine.js) -->
                <div x-data="calendarData()">
                    <div class="mb-8">
                        <span class="text-blue-600 font-bold tracking-wider text-sm uppercase mb-1 block">Jadwal & Kegiatan</span>
                        <h3 class="font-display text-2xl font-extrabold text-blue-900">Agenda BPMP Sultra</h3>
                    </div>
                    
                    <div class="bg-white rounded-3xl p-6 md:p-8 border border-gray-100 shadow-lg shadow-gray-200/50 relative overflow-hidden">
                        <!-- Header Calendar -->
                        <div class="flex justify-between items-center mb-6 pb-6 border-b border-gray-100 relative z-10">
                            <button @click="prevMonth" class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-50 text-gray-500 hover:text-blue-600 border border-gray-200 hover:border-blue-200 transition-all shadow-sm"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                            <h4 class="font-display text-xl font-bold text-blue-900" x-text="monthNames[month] + ' ' + year"></h4>
                            <button @click="nextMonth" class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-50 text-gray-500 hover:text-blue-600 border border-gray-200 hover:border-blue-200 transition-all shadow-sm"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                        </div>
                        
                        <!-- Grid Calendar -->
                        <div class="mb-8 relative z-10">
                            <div class="grid grid-cols-7 gap-2 text-center text-xs font-bold text-gray-400 mb-4 uppercase">
                                <div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
                            </div>
                            <div class="grid grid-cols-7 gap-2 text-center text-sm font-medium">
                                <template x-for="blank in blankDays">
                                    <div class="py-2 text-gray-300"></div>
                                </template>
                                <template x-for="day in daysInMonth">
                                    <div @click="selectDate(day)" 
                                         class="py-2 rounded-lg cursor-pointer transition-all relative flex flex-col items-center justify-center"
                                         :class="{
                                             'bg-blue-600 text-white font-bold shadow-md shadow-blue-500/30 scale-110': isSelected(day),
                                             'text-blue-600 bg-blue-50 border border-blue-200 font-bold': isToday(day) && !isSelected(day),
                                             'text-gray-700 hover:bg-gray-100': !isSelected(day) && !isToday(day)
                                         }">
                                        <span x-text="day"></span>
                                        <div x-show="hasEvent(day)" class="w-1.5 h-1.5 rounded-full mt-0.5"
                                             :class="isSelected(day) ? 'bg-white' : 'bg-blue-500'"></div>
                                    </div>
                                </template>
                            </div>
                        </div>
                        
                        <!-- Events List -->
                        <div class="space-y-4 relative z-10 min-h-[160px]">
                            <template x-if="currentEvents.length === 0">
                                <div class="text-center py-8 text-gray-400 text-sm font-medium border-2 border-dashed border-gray-100 rounded-2xl">
                                    Tidak ada jadwal pada tanggal ini.
                                </div>
                            </template>
                            <template x-for="event in currentEvents" :key="event.title">
                                <div class="flex gap-4 p-5 rounded-2xl border items-center transition-all shadow-sm"
                                     :class="event.type === 'primary' ? 'bg-blue-50 border-blue-100' : 'bg-white border-gray-100'">
                                    <div class="flex flex-col items-center justify-center min-w-[55px] bg-white p-2 rounded-xl shadow-sm border border-gray-100">
                                        <span class="text-[10px] font-bold uppercase" :class="event.type === 'primary' ? 'text-blue-500' : 'text-gray-400'" x-text="monthNames[month].substring(0,3)"></span>
                                        <span class="text-xl font-extrabold leading-none" :class="event.type === 'primary' ? 'text-blue-800' : 'text-gray-700'" x-text="selectedDate.toString().padStart(2, '0')"></span>
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="font-bold text-gray-800 text-sm mb-1.5 leading-snug" x-text="event.title"></h5>
                                        <p class="text-xs text-gray-500 font-medium flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span x-text="event.time"></span>
                                        </p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Right: Multimedia -->
                <div class="h-full flex flex-col">
                    <div class="mb-8 shrink-0">
                        <span class="text-blue-600 font-bold tracking-wider text-sm uppercase mb-1 block">Galeri & Media</span>
                        <h3 class="font-display text-2xl font-extrabold text-blue-900">Multimedia</h3>
                    </div>
                    
                    <div class="flex flex-col gap-6 flex-1">
                        <!-- YouTube Embed -->
                        <div class="bg-white rounded-3xl p-5 border border-gray-100 shadow-lg shadow-gray-200/50 flex flex-col h-full flex-1">
                            <h4 class="font-display font-bold text-gray-800 mb-4 ml-1 flex items-center gap-2 shrink-0">
                                <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"></path></svg>
                                Profil BPMP Sultra
                            </h4>
                            <div class="relative w-full rounded-2xl overflow-hidden bg-gray-100 shadow-inner border border-gray-200/60 flex-1 min-h-[300px]">
                                <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube-nocookie.com/embed/_TX6E1t9AnY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Edge-to-Edge Divider -->
    <div class="w-full bg-white flex flex-col">
        <div class="w-full border-t border-slate-200/80 dark:border-slate-800 my-8"></div>
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
                // Example Events Data
                events: [
                    { day: today.getDate(), month: today.getMonth(), year: today.getFullYear(), title: 'Rapat Koordinasi Mingguan', time: '09.00 - 11.00', type: 'primary' },
                    { day: 10, month: 8, year: 2026, title: 'Evaluasi SAKIP Internal Tahap II', time: '09.00 - 15.00', type: 'secondary' },
                    { day: 4, month: 8, year: 2026, title: 'Pendampingan Perencanaan Berbasis Data', time: '08.00 - Selesai', type: 'primary' },
                    { day: 15, month: today.getMonth(), year: today.getFullYear(), title: 'Webinar Implementasi Kurikulum Merdeka', time: '13.00 - 15.30', type: 'secondary' },
                    { day: 22, month: today.getMonth(), year: today.getFullYear(), title: 'Monitoring Dana BOS Daerah', time: '08.00 - Selesai', type: 'primary' },
                ],
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
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row justify-between items-end mb-12">
                <div>
                    <h2 class="font-display text-3xl md:text-4xl font-extrabold text-blue-900 mb-4">Kabar Terbaru <span class="text-blue-600">dari Kami</span></h2>
                    <div class="w-20 h-1.5 bg-blue-600 rounded-full"></div>
                </div>
                <p class="text-sm text-slate-500 max-w-md text-right hidden sm:block">
                    Artikel dan berita atau informasi terbaru terkait kegiatan dan program BPMP Sulawesi Tenggara
                </p>
            </div>

            <!-- Split Layout Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
                
                <!-- Left: Large Featured Auto-Slide (Alpine.js) -->
                <div class="lg:col-span-7 xl:col-span-7 h-full"
                     x-data="{
                        active: 0,
                        timer: null,
                        slides: [
                            {
                                tag: 'BERITA TERKINI',
                                tagColor: 'bg-blue-600',
                                image: 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                                title: 'Sosialisasi Rapor Pendidikan 2026 di Kabupaten Konawe',
                                excerpt: 'BPMP Sultra menyelenggarakan kegiatan sosialisasi pemanfaatan Rapor Pendidikan untuk perencanaan berbasis data di tingkat daerah.',
                                link: '/berita/1'
                            },
                            {
                                tag: 'VIDEO',
                                tagColor: 'bg-purple-600',
                                image: 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                                title: 'Pendampingan Implementasi Kurikulum Merdeka',
                                excerpt: 'Tim fasilitator BPMP Provinsi Sulawesi Tenggara melakukan pendampingan intensif bagi sekolah-sekolah sasaran IKM di kepulauan.',
                                link: '/berita/2'
                            },
                            {
                                tag: 'DOKUMENTASI',
                                tagColor: 'bg-amber-500',
                                image: 'https://images.unsplash.com/photo-1577896851231-70ef18881754?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                                title: 'Kunjungan Kerja Tim Pusat ke BPMP Sultra',
                                excerpt: 'Menerima kunjungan tim dari kementerian pusat dalam rangka monitoring dan evaluasi penjaminan mutu pendidikan di Sultra.',
                                link: '/berita/3'
                            }
                        ],
                        startTimer() {
                            this.timer = setInterval(() => {
                                this.next();
                            }, 5000);
                        },
                        stopTimer() {
                            clearInterval(this.timer);
                        },
                        next() {
                            this.active = (this.active === this.slides.length - 1) ? 0 : this.active + 1;
                        },
                        prev() {
                            this.active = (this.active === 0) ? this.slides.length - 1 : this.active - 1;
                        }
                     }"
                     x-init="startTimer()"
                     @mouseenter="stopTimer()"
                     @mouseleave="startTimer()"
                >
                    <div class="min-h-[360px] sm:min-h-[420px] h-auto flex-grow relative rounded-3xl overflow-hidden group shadow-md bg-gray-900">
                        <!-- Slides -->
                        <template x-for="(slide, index) in slides" :key="index">
                            <div x-show="active === index"
                                 x-transition:enter="transition ease-out duration-700"
                                 x-transition:enter-start="opacity-0 scale-105"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-500 absolute inset-0"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 class="absolute inset-0 w-full h-full"
                            >
                                <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover">
                                <!-- Gradient Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                                
                                <!-- Content Overlay -->
                                <div class="absolute inset-0 p-6 md:p-8 flex flex-col justify-between z-10">
                                    <!-- Top Tag -->
                                    <div class="self-start">
                                        <span :class="slide.tagColor" class="text-white text-xs font-extrabold px-3 py-1.5 rounded-full shadow-sm uppercase tracking-wide" x-text="slide.tag"></span>
                                    </div>
                                    
                                    <!-- Bottom Content -->
                                    <div class="mt-auto pr-16">
                                        <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-white mb-1 sm:mb-2 line-clamp-2" x-text="slide.title"></h3>
                                        <p class="text-xs sm:text-sm text-slate-200 line-clamp-2 mb-4" x-text="slide.excerpt"></p>
                                        <a :href="slide.link" class="text-sm font-semibold text-white/90 hover:text-white flex items-center gap-1.5 transition-colors">
                                            Baca Selengkapnya
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Slide Controls (Bottom-Right) -->
                        <div class="absolute bottom-6 md:bottom-8 right-6 md:right-8 flex flex-col items-end gap-4 z-20">
                            <!-- Arrows -->
                            <div class="flex gap-2">
                                <button @click="prev()" class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md hover:bg-white/40 border border-white/30 text-white flex items-center justify-center transition-colors shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                </button>
                                <button @click="next()" class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md hover:bg-white/40 border border-white/30 text-white flex items-center justify-center transition-colors shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            </div>
                            <!-- Dots -->
                            <div class="flex gap-1.5">
                                <template x-for="(slide, index) in slides" :key="index">
                                    <button @click="active = index" :class="active === index ? 'bg-white w-4' : 'bg-white/50 hover:bg-white/80 w-2.5'" class="h-2.5 rounded-full transition-all duration-300"></button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Stacked List Cards -->
                <div class="lg:col-span-5 xl:col-span-5 flex flex-col justify-between gap-4">
                    
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
                </div>
            </div>

            <!-- Bottom CTA Button -->
            <div class="mt-12">
                <a href="/berita" class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 font-semibold hover:bg-blue-600 hover:text-white rounded-full shadow-sm transition-all mx-auto w-max flex mx-auto">
                    Lihat Lebih Banyak &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- 6.5 Survei Kepuasan Masyarakat -->
    <section class="py-24 bg-slate-50 relative border-t border-slate-100 font-sans">
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
                
                <!-- Pills Filter -->
                <div class="flex items-center gap-2 bg-white p-1.5 rounded-full border border-slate-200 shadow-sm">
                    <button class="px-6 py-2.5 rounded-full text-sm font-bold bg-blue-600 text-white shadow-sm transition-all">2026</button>
                    <button class="px-6 py-2.5 rounded-full text-sm font-bold text-slate-600 hover:text-blue-600 hover:bg-slate-50 transition-all">2025</button>
                    <button class="px-6 py-2.5 rounded-full text-sm font-bold text-slate-600 hover:text-blue-600 hover:bg-slate-50 transition-all">2024</button>
                </div>
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
                            <h3 class="text-blue-100 font-bold tracking-wider text-xs md:text-sm uppercase mb-2">NILAI IKM — TRIWULAN 1 TAHUN 2026</h3>
                            <div class="flex items-center justify-center md:justify-start gap-4">
                                <span class="text-5xl md:text-6xl font-extrabold text-white">79,17</span>
                                <span class="bg-emerald-400 text-emerald-950 font-extrabold px-4 py-1.5 rounded-full text-sm shadow-sm tracking-widest">BAIK</span>
                            </div>
                        </div>
                        
                        <!-- Right Text -->
                        <div class="text-center md:text-right md:max-w-[200px]">
                            <p class="text-white/80 text-xs font-semibold leading-relaxed">Kementerian Pendidikan Dasar & Menengah</p>
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
                                <p class="text-blue-600 font-extrabold text-lg">3.20</p>
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
                                <p class="text-blue-600 font-extrabold text-lg">3.18</p>
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
                                <p class="text-blue-600 font-extrabold text-lg">3.15</p>
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
                                <p class="text-blue-600 font-extrabold text-lg">4.00</p>
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
                                <p class="text-blue-600 font-extrabold text-lg">3.22</p>
                            </div>
                        </div>

                        <!-- Card 6 (Highlight) -->
                        <div class="bg-emerald-50/50 rounded-2xl p-5 border border-emerald-200 shadow-sm hover:shadow-md transition-shadow flex items-center gap-4 relative overflow-hidden group">
                            <div class="absolute top-0 right-0 w-1.5 h-full bg-emerald-500 rounded-r-2xl"></div>
                            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-emerald-600 font-bold uppercase tracking-wider mb-1">Unsur 6</p>
                                <h4 class="font-bold text-slate-800 text-sm mb-1">Kompetensi</h4>
                                <p class="text-emerald-600 font-extrabold text-lg">3.30</p>
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
                                <p class="text-blue-600 font-extrabold text-lg">3.25</p>
                            </div>
                        </div>

                        <!-- Card 8 (Highlight) -->
                        <div class="bg-emerald-50/50 rounded-2xl p-5 border border-emerald-200 shadow-sm hover:shadow-md transition-shadow flex items-center gap-4 relative overflow-hidden group">
                            <div class="absolute top-0 right-0 w-1.5 h-full bg-emerald-500 rounded-r-2xl"></div>
                            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-emerald-600 font-bold uppercase tracking-wider mb-1">Unsur 8</p>
                                <h4 class="font-bold text-slate-800 text-sm mb-1">Pengaduan</h4>
                                <p class="text-emerald-600 font-extrabold text-lg">3.28</p>
                            </div>
                        </div>

                        <!-- Card 9 -->
                        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Unsur 9</p>
                                <h4 class="font-bold text-slate-800 text-sm mb-1">Sarana & Prasarana</h4>
                                <p class="text-blue-600 font-extrabold text-lg">3.15</p>
                            </div>
                        </div>

                    </div>
                </div>
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

            <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">
                <!-- Form Kontak -->
                <div class="w-full lg:w-3/5">
                    <span class="text-blue-600 font-bold tracking-wider text-sm uppercase mb-2 block">Pengaduan & Pertanyaan</span>
                    <h3 class="font-display text-3xl font-extrabold text-blue-900 mb-8">Kirim Pesan</h3>
                    
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" class="w-full px-5 py-4 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors outline-none" placeholder="Masukkan nama Anda">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                                <input type="email" class="w-full px-5 py-4 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors outline-none" placeholder="alamat@email.com">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Subjek</label>
                            <input type="text" class="w-full px-5 py-4 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors outline-none" placeholder="Perihal pesan">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Pesan</label>
                            <textarea rows="5" class="w-full px-5 py-4 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors outline-none resize-none" placeholder="Tuliskan pesan atau pertanyaan Anda di sini..."></textarea>
                        </div>
                        <button type="button" class="px-8 py-4 bg-blue-700 hover:bg-blue-800 text-white font-bold rounded-xl shadow-lg shadow-blue-700/30 transition-all hover:-translate-y-1 block w-full md:w-auto text-center">Kirim Pesan Sekarang</button>
                    </form>
                </div>

                <!-- Info Kontak & Jam Kerja -->
                <div class="w-full lg:w-2/5">
                    <span class="text-blue-600 font-bold tracking-wider text-sm uppercase mb-2 block">Informasi</span>
                    <h3 class="font-display text-3xl font-extrabold text-blue-900 mb-8">Jam Kerja & Lokasi</h3>
                    
                    <div class="bg-gray-50 p-8 md:p-10 rounded-3xl border border-gray-100 shadow-sm space-y-10">
                        <!-- Lokasi -->
                        <div class="flex gap-5">
                            <div class="w-14 h-14 shrink-0 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg mb-1.5">Alamat Kantor</h4>
                                <p class="text-gray-600 text-sm leading-relaxed">Jl. D.I. Panjaitan No. 83, Wundudopi, Kec. Baruga, Kota Kendari, Sulawesi Tenggara 93116</p>
                            </div>
                        </div>

                        <!-- Jam Kerja -->
                        <div class="flex gap-5">
                            <div class="w-14 h-14 shrink-0 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="w-full">
                                <h4 class="font-bold text-gray-900 text-lg mb-3">Jam Pelayanan</h4>
                                <div class="space-y-2.5 text-sm text-gray-600">
                                    <div class="flex justify-between border-b border-gray-200 pb-2">
                                        <span class="font-medium">Senin - Kamis</span>
                                        <span class="font-bold text-blue-900">07.30 - 16.00</span>
                                    </div>
                                    <div class="flex justify-between border-b border-gray-200 pb-2">
                                        <span class="font-medium">Jumat</span>
                                        <span class="font-bold text-blue-900">07.30 - 16.30</span>
                                    </div>
                                    <p class="text-xs text-red-500 font-bold mt-3">*Sabtu, Minggu & Libur Nasional Tutup</p>
                                </div>
                            </div>
                        </div>

                        <!-- Telepon/Email -->
                        <div class="flex gap-5">
                            <div class="w-14 h-14 shrink-0 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg mb-1.5">Email</h4>
                                <a href="mailto:bpmpsultra@kemendikdasmen.go.id" class="text-blue-600 hover:text-blue-800 text-sm font-bold transition-colors">bpmpsultra@kemendikdasmen.go.id</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 10. Deep Footer -->
    <footer class="bg-blue-950 pt-20 pb-10">
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 mb-12">
                <!-- Column 1 -->
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/9/9c/Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg" alt="Logo" class="h-12 w-12 drop-shadow-md">
                        <div class="flex flex-col">
                            <span class="font-display font-bold text-xl text-white leading-tight">BPMP SULTRA</span>
                            <span class="text-xs font-medium text-blue-300">Kemdikbudristek RI</span>
                        </div>
                    </div>
                    <p class="text-blue-100/70 text-sm leading-relaxed mb-6">Mewujudkan pendidikan bermutu yang merata di seluruh wilayah Sulawesi Tenggara melalui penjaminan mutu yang berkelanjutan.</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-white/5 hover:bg-white/15 backdrop-blur-md rounded-xl text-xs font-bold text-white border border-white/10 hover:border-white/30 shadow-sm transition-all duration-300">BerAKHLAK</span>
                        <span class="px-3 py-1 bg-white/5 hover:bg-white/15 backdrop-blur-md rounded-xl text-xs font-bold text-white border border-white/10 hover:border-white/30 shadow-sm transition-all duration-300">#Bangga Melayani Bangsa</span>
                    </div>
                </div>

                <!-- Column 2 -->
                <div>
                    <h4 class="font-display text-lg font-bold text-white mb-6">Program & Layanan</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm text-blue-100/70 hover:text-white transition-colors">Program Sekolah Penggerak</a></li>
                        <li><a href="#" class="text-sm text-blue-100/70 hover:text-white transition-colors">Program Kurikulum Merdeka</a></li>
                        <li><a href="#" class="text-sm text-blue-100/70 hover:text-white transition-colors">Program PBD</a></li>
                        <li><a href="#" class="text-sm text-blue-100/70 hover:text-white transition-colors">Layanan ULT Online</a></li>
                        <li><a href="#" class="text-sm text-blue-100/70 hover:text-white transition-colors">Layanan ULT Keliling</a></li>
                    </ul>
                </div>

                <!-- Column 3 -->
                <div class="lg:col-span-2">
                    <h4 class="font-display text-lg font-bold text-white mb-6">Tautan Terkait</h4>
                    <div class="grid grid-cols-2 gap-x-4 gap-y-3">
                        <ul class="space-y-3">
                            <li><a href="#" class="text-sm text-blue-100/70 hover:text-white transition-colors">Survei Layanan BPMP Sultra</a></li>
                            <li><a href="#" class="text-sm text-blue-100/70 hover:text-white transition-colors">UKS</a></li>
                            <li><a href="#" class="text-sm text-blue-100/70 hover:text-white transition-colors">TKSI</a></li>
                            <li><a href="#" class="text-sm text-blue-100/70 hover:text-white transition-colors">SIBI</a></li>
                            <li><a href="#" class="text-sm text-blue-100/70 hover:text-white transition-colors">Info Sekolah</a></li>
                        </ul>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-sm text-blue-100/70 hover:text-white transition-colors">LPSE Kemendikdasmen</a></li>
                            <li><a href="#" class="text-sm text-blue-100/70 hover:text-white transition-colors">Program Indonesia Pintar</a></li>
                            <li><a href="#" class="text-sm text-blue-100/70 hover:text-white transition-colors">Whistleblowing System</a></li>
                            <li><a href="#" class="text-sm text-blue-100/70 hover:text-white transition-colors">Kemendikdasmen</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Column 4 -->
                <div>
                    <h4 class="font-display text-lg font-bold text-white mb-6">Media Sosial</h4>
                    <div class="flex gap-3 mb-6">
                        <a href="https://www.tiktok.com/@bpmp.sulawesitenggara" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-black transition-colors"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.28 6.28 0 005.4 15.6a6.28 6.28 0 0012.06 3.05 6.29 6.29 0 002.13-4.69V10.6a8.2 8.2 0 003.81 1.13V8.28a5 5 0 01-3.81-1.59z"/></svg></a>
                        <a href="https://www.instagram.com/bpmpsultra/" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-pink-600 transition-colors"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
                        <a href="https://www.youtube.com/@bpmpsultra" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-red-600 transition-colors"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-blue-900/50 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-blue-100/50 font-medium">&copy; 2026 BPMP Provinsi Sulawesi Tenggara. Hak Cipta Dilindungi.</p>
                <div class="flex gap-6 text-sm text-blue-100/50 font-medium">
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    
    
    
    <!-- Native Accessibility Popup Modal & Trigger -->
    <div x-data="{ 
            openA11y: false,
            contrast: false,
            highlightLinks: false,
            biggerText: false,
            textSpacing: false,
            pauseAnimations: false,
            hideImages: false,
            dyslexia: false,
            bigCursor: false,
            lineHeight: false,
            textAlign: 0,
            saturation: false,
            toggle(setting) {
                this[setting] = !this[setting];
                this.applySettings();
            },
            cycleAlign() {
                this.textAlign = (this.textAlign + 1) % 3;
                this.applySettings();
            },
            reset() {
                this.contrast = false;
                this.highlightLinks = false;
                this.biggerText = false;
                this.textSpacing = false;
                this.pauseAnimations = false;
                this.hideImages = false;
                this.dyslexia = false;
                this.bigCursor = false;
                this.lineHeight = false;
                this.textAlign = 0;
                this.saturation = false;
                this.applySettings();
            },
            applySettings() {
                const b = document.body;
                b.style.filter = this.contrast ? 'contrast(150%)' : (this.saturation ? 'grayscale(100%)' : 'none');
                this.highlightLinks ? b.classList.add('a11y-highlight-links') : b.classList.remove('a11y-highlight-links');
                b.style.fontSize = this.biggerText ? '110%' : '';
                b.style.letterSpacing = this.textSpacing ? '0.1em' : '';
                b.style.wordSpacing = this.textSpacing ? '0.2em' : '';
                this.pauseAnimations ? b.classList.add('a11y-pause-animations') : b.classList.remove('a11y-pause-animations');
                this.hideImages ? b.classList.add('a11y-hide-images') : b.classList.remove('a11y-hide-images');
                b.style.fontFamily = this.dyslexia ? 'Arial, sans-serif' : '';
                this.bigCursor ? b.classList.add('a11y-big-cursor') : b.classList.remove('a11y-big-cursor');
                b.style.lineHeight = this.lineHeight ? '2' : '';
                if (this.textAlign === 1) b.style.textAlign = 'left';
                else if (this.textAlign === 2) b.style.textAlign = 'center';
                else b.style.textAlign = '';
                
                localStorage.setItem('a11ySettings', JSON.stringify({
                    contrast: this.contrast,
                    highlightLinks: this.highlightLinks,
                    biggerText: this.biggerText,
                    textSpacing: this.textSpacing,
                    pauseAnimations: this.pauseAnimations,
                    hideImages: this.hideImages,
                    dyslexia: this.dyslexia,
                    bigCursor: this.bigCursor,
                    lineHeight: this.lineHeight,
                    textAlign: this.textAlign,
                    saturation: this.saturation
                }));
            },
            init() {
                let saved = localStorage.getItem('a11ySettings');
                if (saved) {
                    try {
                        let s = JSON.parse(saved);
                        this.contrast = s.contrast || false;
                        this.highlightLinks = s.highlightLinks || false;
                        this.biggerText = s.biggerText || false;
                        this.textSpacing = s.textSpacing || false;
                        this.pauseAnimations = s.pauseAnimations || false;
                        this.hideImages = s.hideImages || false;
                        this.dyslexia = s.dyslexia || false;
                        this.bigCursor = s.bigCursor || false;
                        this.lineHeight = s.lineHeight || false;
                        this.textAlign = s.textAlign || 0;
                        this.saturation = s.saturation || false;
                        this.applySettings();
                    } catch(e) {}
                }
                
                window.addEventListener('keydown', (e) => {
                    if (e.ctrlKey && e.key.toLowerCase() === 'u') {
                        e.preventDefault();
                        this.openA11y = !this.openA11y;
                    }
                });
                
                if (!document.getElementById('a11y-styles')) {
                    const style = document.createElement('style');
                    style.id = 'a11y-styles';
                    style.innerHTML = `
                        .a11y-highlight-links a { text-decoration: underline !important; text-decoration-color: #fbbf24 !important; text-decoration-thickness: 3px !important; color: #d97706 !important; }
                        .a11y-pause-animations * { animation: none !important; transition: none !important; }
                        .a11y-hide-images img, .a11y-hide-images [style*="background-image"] { opacity: 0 !important; }
                        .a11y-big-cursor * { cursor: zoom-in !important; }
                        
                        @keyframes ripple-wave {
                          0% { transform: scale(0.95); opacity: 0.8; }
                          100% { transform: scale(1.6); opacity: 0; }
                        }
                        .animate-ripple {
                          animation: ripple-wave 2.4s cubic-bezier(0, 0.2, 0.8, 1) infinite;
                        }
                    `;
                    document.head.appendChild(style);
                }
            }
        }"
         class="fixed bottom-6 left-6 z-50 flex flex-col items-start"
         @keydown.escape.window="openA11y = false">
        
        <!-- Modal Container -->
        <div id="accessibility-modal"
             x-show="openA11y"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-6 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-6 scale-95"
             class="w-[min(24rem,calc(100vw-2rem))] max-h-[80vh] flex flex-col bg-slate-50 dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden mb-4 transition-all"
             style="display: none;">
             
             <!-- Body Content -->
             <div class="overflow-y-auto flex-1">
             
             <!-- Header -->
             <div class="bg-blue-600 text-white p-4 flex items-center justify-between sticky top-0 z-10">
                 <h4 class="font-bold text-sm sm:text-base flex items-center gap-2">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                     Accessibility Menu <span class="text-[10px] font-normal opacity-80 bg-blue-700 px-1.5 py-0.5 rounded">(CTRL+U)</span>
                 </h4>
                 <button @click="openA11y = false" class="w-7 h-7 rounded-full border border-white/30 flex items-center justify-center hover:bg-white/20 transition-colors">
                     <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                 </button>
             </div>
             
             <!-- Banner Button -->
             <button class="bg-blue-600 text-white text-xs font-bold py-2 px-4 rounded-xl flex items-center justify-center gap-2 mx-4 mt-4 w-[calc(100%-2rem)] shadow-sm hover:bg-blue-700 transition-colors">
                 <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> How UserWay Works
             </button>
             
             <!-- Oversized Widget Toggle -->
             <div class="flex items-center justify-between px-5 py-3 mt-2 text-xs font-semibold text-slate-700 dark:text-slate-300">
                 <span>Oversized Widget</span>
                 <div class="w-8 h-4 bg-slate-300 dark:bg-slate-600 rounded-full relative cursor-pointer">
                     <div class="w-4 h-4 bg-white rounded-full shadow absolute left-0 top-0 border border-slate-200"></div>
                 </div>
             </div>
             
             <!-- Grid Features -->
             <div class="grid grid-cols-2 gap-2.5 p-4 pt-0">
                 
                 <!-- Contrast + -->
                 <div @click="toggle('contrast')" :class="contrast ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <svg class="w-6 h-6 text-slate-700 dark:text-slate-200" :class="contrast ? 'text-blue-600 dark:text-blue-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2V4c-4.418 0-8 3.582-8 8s3.582 8 8 8z"></path></svg>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Contrast +</span>
                 </div>
                 
                 <!-- Highlight Links -->
                 <div @click="toggle('highlightLinks')" :class="highlightLinks ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <svg class="w-6 h-6 text-slate-700 dark:text-slate-200" :class="highlightLinks ? 'text-blue-600 dark:text-blue-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Highlight Links</span>
                 </div>
                 
                 <!-- Bigger Text -->
                 <div @click="toggle('biggerText')" :class="biggerText ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <div class="flex items-end text-slate-700 dark:text-slate-200 gap-0.5" :class="biggerText ? 'text-blue-600 dark:text-blue-400' : ''">
                         <span class="font-serif text-lg leading-none font-bold">T</span><span class="font-serif text-2xl leading-none font-bold">T</span>
                     </div>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Bigger Text</span>
                 </div>
                 
                 <!-- Text Spacing -->
                 <div @click="toggle('textSpacing')" :class="textSpacing ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <svg class="w-6 h-6 text-slate-700 dark:text-slate-200" :class="textSpacing ? 'text-blue-600 dark:text-blue-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l-4 3 4 3m8-6l4 3-4 3m-9-3h10"></path></svg>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Text Spacing</span>
                 </div>
                 
                 <!-- Pause Animations -->
                 <div @click="toggle('pauseAnimations')" :class="pauseAnimations ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <svg class="w-6 h-6 text-slate-700 dark:text-slate-200" :class="pauseAnimations ? 'text-blue-600 dark:text-blue-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Pause Animations</span>
                 </div>
                 
                 <!-- Hide Images -->
                 <div @click="toggle('hideImages')" :class="hideImages ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <svg class="w-6 h-6 text-slate-700 dark:text-slate-200 relative" :class="hideImages ? 'text-blue-600 dark:text-blue-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" class="text-red-500"></path></svg>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Hide Images</span>
                 </div>
                 
                 <!-- Dyslexia Friendly -->
                 <div @click="toggle('dyslexia')" :class="dyslexia ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <div class="w-6 h-6 bg-slate-100 dark:bg-slate-700 rounded flex items-center justify-center text-sm font-bold text-slate-700 dark:text-slate-200" :class="dyslexia ? 'text-blue-600 bg-blue-100 dark:text-blue-400 dark:bg-blue-900/40' : ''">Df</div>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Dyslexia Friendly</span>
                 </div>
                 
                 <!-- Cursor -->
                 <div @click="toggle('bigCursor')" :class="bigCursor ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <svg class="w-6 h-6 text-slate-700 dark:text-slate-200" :class="bigCursor ? 'text-blue-600 dark:text-blue-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Cursor</span>
                 </div>
                 
                 <!-- Tooltips -->
                 <div @click="toggle('tooltips')" :class="tooltips ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <svg class="w-6 h-6 text-slate-700 dark:text-slate-200" :class="tooltips ? 'text-blue-600 dark:text-blue-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Tooltips</span>
                 </div>
                 
                 <!-- Line Height -->
                 <div @click="toggle('lineHeight')" :class="lineHeight ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <svg class="w-6 h-6 text-slate-700 dark:text-slate-200" :class="lineHeight ? 'text-blue-600 dark:text-blue-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16M8 9l-4-3 4-3m8 12l4 3-4 3"></path></svg>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Line Height</span>
                 </div>
                 
                 <!-- Text Align -->
                 <div @click="cycleAlign()" :class="textAlign !== 0 ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <svg class="w-6 h-6 text-slate-700 dark:text-slate-200" :class="textAlign !== 0 ? 'text-blue-600 dark:text-blue-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h10M4 18h16"></path></svg>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Text Align</span>
                 </div>
                 
                 <!-- Saturation -->
                 <div @click="toggle('saturation')" :class="saturation ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <svg class="w-6 h-6 text-slate-700 dark:text-slate-200" :class="saturation ? 'text-blue-600 dark:text-blue-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S12 3 12 3s-4.5 3.97-4.5 9 2.015 9 4.5 9zM9 12h6"></path></svg>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Saturation</span>
                 </div>
                 
             </div>
             
             <!-- Bottom Action Buttons -->
             <button @click="reset()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-4 rounded-xl mx-4 mb-3 flex items-center justify-center gap-2 w-[calc(100%-2rem)] transition-colors shadow-sm">
                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                 Reset All Accessibility Settings
             </button>
             
             <!-- Footer Links -->
             <div class="px-5 pb-5 flex flex-col gap-2">
                 <a href="#" class="text-xs font-semibold text-blue-600 dark:text-blue-400 flex items-center gap-1 hover:underline">
                     Move/Hide Accessibility Widget
                 </a>
             </div>
             </div>
                 <div class="flex items-center gap-2 mt-1">
                     <span class="bg-slate-200 dark:bg-slate-700 text-[9px] font-bold px-1.5 py-0.5 rounded text-slate-600 dark:text-slate-300">MANAGE</span>
                     <span class="text-[10px] font-black tracking-widest text-blue-800 dark:text-blue-500">USERWAY</span>
                 </div>
             </div>
        </div>

        <!-- Floating Trigger Button (A11y) -->
        <div class="relative flex items-center justify-center w-14 h-14 mt-4">
            <span class="absolute inline-flex h-full w-full rounded-full bg-blue-500/40 animate-ripple pointer-events-none"></span>
            <button id="btn-accessibility" @click="openA11y = !openA11y" class="relative z-10 w-14 h-14 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-2xl flex items-center justify-center transition duration-300 transform hover:-translate-y-1 active:scale-95 focus:outline-none">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </button>
        </div>
    </div>

    <!-- Floating WhatsApp Helpdesk Popup -->
    <div x-data="{ openWA: false }" class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
        
        <!-- Popup Modal Card -->
        <div id="whatsapp-modal"
             x-show="openWA"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-6 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-6 scale-95"
             class="w-[min(24rem,calc(100vw-2rem))] max-h-[80vh] flex flex-col rounded-3xl bg-white dark:bg-slate-900 shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden mb-4"
             style="display: none;">
            
            <!-- Header (Green Banner) -->
            <div class="bg-emerald-500 p-5 text-white flex items-center gap-3 rounded-t-3xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                <div>
                    <h4 class="text-base font-bold">Mulai Percakapan</h4>
                    <p class="text-xs text-emerald-100">Pilih saluran bantuan kami</p>
                </div>
            </div>

            <!-- Body Content -->
            <div class="pt-4 pb-2 overflow-y-auto flex-1">
                <p class="text-xs font-medium text-slate-400 dark:text-slate-500 px-5 mb-3">Klik link dibawah ini :</p>
                
                <!-- Option 1: Helpdesk Kemdikbud -->
                <a href="https://wa.me/6281281435091" target="_blank" class="mx-4 mb-3 p-3.5 rounded-2xl bg-white dark:bg-slate-800 border-l-4 border-l-emerald-500 shadow-sm border border-slate-100 dark:border-slate-700/60 flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-800/80 transition cursor-pointer group">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 bg-emerald-500 text-white rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-slate-800 dark:text-slate-100">Helpdesk Kemdikbud</h5>
                            <p class="text-xs text-slate-500">+62 812-8143-5091</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-slate-300 group-hover:text-emerald-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>

                <!-- Option 2: ULT BPMP Sultra -->
                <a href="https://chat.whatsapp.com/CfzJauo1F17I5sTHXmme2L?mode=r_c" target="_blank" class="mx-4 mb-4 p-3.5 rounded-2xl bg-white dark:bg-slate-800 border-l-4 border-l-emerald-500 shadow-sm border border-slate-100 dark:border-slate-700/60 flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-800/80 transition cursor-pointer group">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 bg-teal-600 text-white rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-slate-800 dark:text-slate-100">ULT BPMP Sultra</h5>
                            <p class="text-xs text-slate-500">Grup WhatsApp Resmi</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-slate-300 group-hover:text-emerald-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>

        <!-- Floating Trigger Button (WhatsApp) -->
        <div class="relative flex items-center justify-center w-14 h-14 mt-4">
            <span class="absolute inline-flex h-full w-full rounded-full bg-emerald-500/40 animate-ripple pointer-events-none"></span>
            <button id="btn-whatsapp" @click="openWA = !openWA" class="relative z-10 w-14 h-14 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full shadow-2xl flex items-center justify-center transition duration-300 transform hover:-translate-y-1 active:scale-95 focus:outline-none">
                <!-- WhatsApp Icon (shows when closed) -->
                <svg x-show="!openWA" class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.559 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                <!-- Close Cross Icon (shows when open) -->
                <svg x-show="openWA" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>

</body>
</html>