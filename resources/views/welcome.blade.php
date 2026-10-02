<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
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
    <!-- 6. Alpine.js for Background Slider -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
    </style>
</head>
<body class="bg-slate-900 text-white antialiased overflow-x-hidden selection:bg-blue-600 selection:text-white">

    <!-- 4. Glassmorphism Navbar (Fixed to top to overlay Hero) -->
    <header class="fixed top-0 z-50 w-full transition-all duration-300" 
            x-data="{ mobileMenuOpen: false, scrolled: false }" 
            @scroll.window="scrolled = (window.pageYOffset > 20)"
            :class="scrolled ? 'bg-white shadow-md border-b border-gray-200' : 'bg-white/10 backdrop-blur-md border-b border-white/20'">
        <nav class="w-full flex items-center justify-between px-4 lg:px-8 py-3 relative z-50">
                
                <!-- 3. Logo Text -->
                <div class="flex items-center shrink-0 space-x-3">
                    <a href="#" class="flex items-center gap-3 shrink-0 group">
                        <img src="{{ asset('tutwurihandayani.png') }}" alt="Logo BPMP" class="h-10 w-10 md:h-12 md:w-12 transition-transform duration-300 group-hover:scale-105 drop-shadow-md">
                        <div class="flex flex-col">
                            <span class="font-bold text-lg md:text-xl leading-tight tracking-tight whitespace-nowrap">
                                <span class="text-blue-600">Kemen</span><span class="text-orange-500">dikdasmen</span>
                            </span>
                            <span class="text-[11px] md:text-[12px] font-medium whitespace-nowrap" :class="scrolled ? 'text-gray-800' : 'text-gray-300'">BPMP Provinsi Sulawesi Tenggara</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-4 xl:space-x-6 text-sm font-medium" x-data="{ openMenu: null }">
                    <!-- 1. Profil -->
                    <div class="relative group" @mouseenter="openMenu = 'profil'" @mouseleave="openMenu = null">
                        <button class="px-1.5 lg:px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
                            <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Profil
                            <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="openMenu === 'profil' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="openMenu === 'profil'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute left-0 mt-2 bg-white shadow-xl border border-gray-100 rounded-xl p-1.5 w-max min-w-[240px] text-gray-800 z-50">
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Profil Lembaga</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Struktur Organisasi</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Profil Pegawai</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Visi Misi</a>
                        </div>
                    </div>
                    
                    <!-- 2. Program -->
                    <div class="relative group" @mouseenter="openMenu = 'program'" @mouseleave="openMenu = null">
                        <button class="px-1.5 lg:px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
                            <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            Program
                            <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="openMenu === 'program' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="openMenu === 'program'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute left-0 mt-2 bg-white shadow-xl border border-gray-100 rounded-xl p-1.5 w-max min-w-[240px] text-gray-800 z-50">
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Program Prioritas</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Rapor Pendidikan</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">PBD</a>
                        </div>
                    </div>
                    
                    <!-- 3. ULT -->
                    <div class="relative group" @mouseenter="openMenu = 'ult'" @mouseleave="openMenu = null">
                        <button class="px-1.5 lg:px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
                            <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            ULT
                            <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="openMenu === 'ult' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="openMenu === 'ult'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute left-0 mt-2 bg-white shadow-xl border border-gray-100 rounded-xl p-1.5 w-max min-w-[240px] text-gray-800 z-50">
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Unit Layanan Terpadu</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Hasil SKM</a>
                        </div>
                    </div>
                    
                    <!-- 4. Publikasi -->
                    <div class="relative group" @mouseenter="openMenu = 'publikasi'" @mouseleave="openMenu = null">
                        <button class="px-1.5 lg:px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
                            <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                            Publikasi
                            <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="openMenu === 'publikasi' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="openMenu === 'publikasi'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute left-0 mt-2 bg-white shadow-xl border border-gray-100 rounded-xl p-1.5 w-max min-w-[240px] text-gray-800 z-50">
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">SINONGGI</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Profil Mutu Pendidikan</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Regulasi dan Peraturan</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Kisah Inspiratif</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">JURNAL</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Majalah</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Artikel</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Berita</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Goes to School</a>
                        </div>
                    </div>
                    
                    <!-- 5. SAKIP -->
                    <div class="relative group" @mouseenter="openMenu = 'sakip'" @mouseleave="openMenu = null">
                        <button class="px-1.5 lg:px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
                            <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            SAKIP
                            <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="openMenu === 'sakip' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="openMenu === 'sakip'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute left-0 mt-2 bg-white shadow-xl border border-gray-100 rounded-xl p-1.5 w-max min-w-[240px] text-gray-800 z-50">
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">RENSTRA</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Perjanjian Kinerja</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">LAKIN</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">LHE</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">LK</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">DIPA 2026</a>
                        </div>
                    </div>
                    
                    <!-- 6. Link Terkait (Nested Flyout) -->
                    <div class="relative group" @mouseenter="openMenu = 'link'" @mouseleave="openMenu = null">
                        <button class="px-1.5 lg:px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
                            <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            Link Terkait
                            <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="openMenu === 'link' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="openMenu === 'link'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute left-0 mt-2 bg-white shadow-xl border border-gray-100 rounded-xl p-1.5 w-max min-w-[240px] text-gray-800 z-50">
                            <!-- Nested: Layanan Kepegawaian -->
                            <div class="relative w-full block" x-data="{ subOpen: false }" @mouseenter="subOpen = true" @mouseleave="subOpen = false">
                                <button class="w-full text-left flex justify-between items-center px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">
                                    Layanan Kepegawaian
                                    <svg class="w-3.5 h-3.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                                <div style="left: 100%;" x-show="subOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-x-2" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-2" class="absolute top-0 ml-1 z-50 bg-white shadow-xl border border-gray-100 rounded-lg min-w-[240px] py-2 w-max text-gray-800">
                                    <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">e-skp</a>
                                    <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">e-kehadiran</a>
                                    <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Portal Kemdikdasmen</a>
                                </div>
                            </div>
                            <!-- Nested: Layanan Data Dan Informasi -->
                            <div class="relative w-full block" x-data="{ subOpen: false }" @mouseenter="subOpen = true" @mouseleave="subOpen = false">
                                <button class="w-full text-left flex justify-between items-center px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">
                                    Layanan Data Dan Informasi
                                    <svg class="w-3.5 h-3.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                                <div style="left: 100%;" x-show="subOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-x-2" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-2" class="absolute top-0 ml-1 z-50 bg-white shadow-xl border border-gray-100 rounded-lg min-w-[240px] py-2 w-max text-gray-800">
                                    <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Data Profil Sekolah</a>
                                    <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Raport Pendidikan</a>
                                    <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">PMP</a>
                                    <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">DAPODIK</a>
                                    <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">BOS</a>
                                    <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Rumah Pendidikan</a>
                                    <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">SIBI</a>
                                    <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Data Referensi</a>
                                    <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">PUSPEKA</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 7. PPID -->
                    <div class="relative group" @mouseenter="openMenu = 'ppid'" @mouseleave="openMenu = null">
                        <button class="px-1.5 lg:px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
                            <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            PPID
                            <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="openMenu === 'ppid' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="openMenu === 'ppid'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute left-0 mt-2 bg-white shadow-xl border border-gray-100 rounded-xl p-1.5 w-max min-w-[240px] text-gray-800 z-50">
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Profil PPID</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Daftar Informasi Publik</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Transparansi Publik</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">e-PPID</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Laporan PPID 2025</a>
                        </div>
                    </div>
                    
                    <!-- 8. ZI WBK -->
                    <div class="relative group" @mouseenter="openMenu = 'ziwbk'" @mouseleave="openMenu = null">
                        <button class="px-1.5 lg:px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
                            <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                            ZI WBK
                            <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="openMenu === 'ziwbk' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="openMenu === 'ziwbk'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute left-0 lg:right-0 mt-2 bg-white shadow-xl border border-gray-100 rounded-xl p-1.5 w-max min-w-[240px] text-gray-800 z-50">
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Standar Pelayanan</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Maklumat Pelayanan</a>
                            <!-- Nested: Area Pemenuhan -->
                            <div class="relative w-full block" x-data="{ subOpen: false }" @mouseenter="subOpen = true" @mouseleave="subOpen = false">
                                <button class="w-full text-left flex justify-between items-center px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">
                                    Area Pemenuhan
                                    <svg class="w-3.5 h-3.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                                <div style="left: 100%;" x-show="subOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-x-2" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-2" class="absolute top-0 ml-1 z-50 bg-white shadow-xl border border-gray-100 rounded-lg min-w-[240px] py-2 w-max text-gray-800">
                                    <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Manajemen Perubahan</a>
                                    <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Penataan Tata Laksana</a>
                                    <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Penataan Sistem Manajemen SDM</a>
                                    <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Penguatan Akuntabilitas</a>
                                    <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Penguatan Pengawasan</a>
                                    <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Peningkatan Kualitas Layanan Publik</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 9. Pengaduan -->
                    <div class="relative group" @mouseenter="openMenu = 'pengaduan'" @mouseleave="openMenu = null">
                        <button class="px-1.5 lg:px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
                            <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                            Pengaduan
                            <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="openMenu === 'pengaduan' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="openMenu === 'pengaduan'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 mt-2 bg-white shadow-xl border border-gray-100 rounded-xl p-1.5 w-max min-w-[240px] text-gray-800 z-50">
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">SPMB</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">SP4N Lapor</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Lapor Gratifikasi</a>
                            <a href="#" class="block px-4 py-2.5 text-[13px] md:text-sm text-gray-700 font-medium hover:bg-gray-50 hover:text-blue-600 rounded-md transition-colors whitespace-nowrap">Whistle Blowing System</a>
                        </div>
                    </div>
                    
                    <!-- 10. Hubungi Kami -->
                    <div class="relative group">
                        <a href="#hubungi" class="px-1.5 lg:px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
                            <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            Hubungi Kami
                        </a>
                    </div>
                </div>

                <!-- Interactive Search Input -->
                <div class="flex items-center shrink-0 space-x-3">
                    <div class="hidden lg:flex items-center shrink-0">
                        <div class="relative group">
                            <input type="search" placeholder="Pencarian..." class="border text-[12px] md:text-[13px] rounded-full pl-9 pr-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-400/50 focus:border-transparent transition-all duration-300 w-32 focus:w-48" :class="scrolled ? 'bg-gray-100 text-gray-800 border-gray-200 placeholder-gray-500' : 'bg-white/10 border-white/20 text-white placeholder-gray-300 backdrop-blur-sm'">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-3.5 w-3.5 transition-colors" :class="scrolled ? 'text-gray-500 group-focus-within:text-blue-600' : 'text-gray-300 group-focus-within:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="xl:hidden p-2 rounded-lg transition-colors" :class="scrolled ? 'text-gray-800 hover:bg-gray-100' : 'text-white hover:bg-white/10'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>
            </nav>
    </header>

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
                    Balai Penjaminan Mutu Pendidikan
                    <span class="block text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-sky-300 via-blue-400 to-cyan-300 mt-3 drop-shadow-[0_2px_10px_rgba(0,0,0,0.9)] pb-3 leading-normal">
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
                
                <!-- Social Media Glass Pills -->
                <div class="flex flex-wrap items-center gap-3 pt-6">
                    <a href="https://www.instagram.com/bpmpsultra/" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 hover:bg-white/15 backdrop-blur-md border border-white/10 hover:border-white/30 text-slate-200 hover:text-white text-sm font-medium transition-all duration-300 hover:-translate-y-1 shadow-lg hover:shadow-xl hover:shadow-pink-500/20">
                        <svg class="w-4 h-4 text-pink-400 group-hover:text-pink-300 transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        @bpmpsultra
                    </a>
                    <a href="https://www.tiktok.com/@bpmp.sulawesitenggara" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 hover:bg-white/15 backdrop-blur-md border border-white/10 hover:border-white/30 text-slate-200 hover:text-white text-sm font-medium transition-all duration-300 hover:-translate-y-1 shadow-lg hover:shadow-xl hover:shadow-cyan-500/20">
                        <svg class="w-4 h-4 text-cyan-400 group-hover:text-cyan-300 transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.28 6.28 0 005.4 15.6a6.28 6.28 0 0012.06 3.05 6.29 6.29 0 002.13-4.69V10.6a8.2 8.2 0 003.81 1.13V8.28a5 5 0 01-3.81-1.59z"/></svg>
                        @bpmp.sulawesitenggara
                    </a>
                    <a href="https://www.youtube.com/@bpmpsultra" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 hover:bg-white/15 backdrop-blur-md border border-white/10 hover:border-white/30 text-slate-200 hover:text-white text-sm font-medium transition-all duration-300 hover:-translate-y-1 shadow-lg hover:shadow-xl hover:shadow-red-500/20">
                        <svg class="w-4 h-4 text-red-500 group-hover:text-red-400 transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        BPMP Sultra Official
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

        <!-- Floating Glassmorphism Stats Bar (Refined for Airiness) -->
        <div class="relative z-20 w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mb-10 sm:mb-12">
            <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl py-5 px-6 shadow-[0_8px_32px_rgba(0,0,0,0.25)]">
                <div class="grid grid-cols-3 divide-x divide-white/20 text-center text-white">
                    <div class="px-2 flex flex-col items-center justify-center">
                        <div class="text-2xl sm:text-4xl font-extrabold font-['Plus_Jakarta_Sans'] drop-shadow-md">17</div>
                        <div class="text-[10px] sm:text-sm text-sky-200 font-semibold tracking-widest mt-1 uppercase text-center">Kabupaten / Kota</div>
                    </div>
                    <div class="px-2 flex flex-col items-center justify-center">
                        <div class="text-2xl sm:text-4xl font-extrabold font-['Plus_Jakarta_Sans'] drop-shadow-md">8+</div>
                        <div class="text-[10px] sm:text-sm text-sky-200 font-semibold tracking-widest mt-1 uppercase text-center">Layanan Prioritas</div>
                    </div>
                    <div class="px-2 flex flex-col items-center justify-center">
                        <div class="text-2xl sm:text-4xl font-extrabold font-['Plus_Jakarta_Sans'] drop-shadow-md">100%</div>
                        <div class="text-[10px] sm:text-sm text-sky-200 font-semibold tracking-widest mt-1 uppercase text-center">Akses Digital</div>
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
            <div class="pt-12 border-t border-gray-100">
                <div class="text-center mb-10">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Profil Pimpinan</h2>
                    <p class="text-gray-500 mt-2">Pimpinan Balai Penjaminan Mutu Pendidikan Provinsi Sulawesi Tenggara yang berkomitmen melayani sepenuh hati</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-3xl mx-auto">
                    
                    <!-- Kartu 1 -->
                    <div class="w-full max-w-[300px] mx-auto bg-white rounded-[2rem] shadow-lg border border-gray-100 overflow-hidden flex flex-col">
                        <img src="https://ui-avatars.com/api/?name=JP&background=1e3a8a&color=fff&size=500" alt="Kepala BPMP" class="w-full h-80 object-cover rounded-t-[2rem] bg-blue-900">
                        <div class="p-6 text-center bg-white">
                            <h3 class="text-base font-bold text-gray-900">Junaiddin Pagala, S.T., M.T.</h3>
                            <p class="text-sm uppercase text-blue-600 font-semibold mt-1">KEPALA BPMP PROVINSI SULAWESI TENGGARA</p>
                        </div>
                    </div>

                    <!-- Kartu 2 -->
                    <div class="w-full max-w-[300px] mx-auto bg-white rounded-[2rem] shadow-lg border border-gray-100 overflow-hidden flex flex-col">
                        <img src="https://ui-avatars.com/api/?name=KU&background=1e3a8a&color=fff&size=500" alt="Kasubbag Umum" class="w-full h-80 object-cover rounded-t-[2rem] bg-blue-900">
                        <div class="p-6 text-center bg-white">
                            <h3 class="text-base font-bold text-gray-900">Nama Kasubbag Umum, S.Pd., M.Si.</h3>
                            <p class="text-sm uppercase text-blue-600 font-semibold mt-1">KASUBBAG UMUM BPMP SULTRA</p>
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
        <div class="container mx-auto px-4">
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
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
                <!-- Left: Calendar Widget -->
                <div>
                    <div class="mb-10">
                        <span class="text-blue-600 font-bold tracking-wider text-sm uppercase mb-2 block">Jadwal & Kegiatan</span>
                        <h2 class="font-display text-3xl font-extrabold text-blue-900">Agenda BPMP Sultra</h2>
                    </div>
                    
                    <div class="bg-white rounded-3xl p-6 md:p-8 border border-gray-100 shadow-xl shadow-gray-200/50 relative overflow-hidden">
                        <!-- Header Calendar -->
                        <div class="flex justify-between items-center mb-6 pb-6 border-b border-gray-100 relative z-10">
                            <button class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-gray-50 text-gray-500 border border-gray-200 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                            <h3 class="font-display text-xl font-bold text-blue-900">September 2026</h3>
                            <button class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-gray-50 text-gray-500 border border-gray-200 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                        </div>
                        
                        <!-- Grid Calendar -->
                        <div class="mb-8 relative z-10">
                            <div class="grid grid-cols-7 gap-2 text-center text-xs font-bold text-gray-400 mb-4 uppercase">
                                <div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
                            </div>
                            <div class="grid grid-cols-7 gap-2 text-center text-sm font-medium">
                                <div class="py-2 text-gray-300">30</div><div class="py-2 text-gray-300">31</div>
                                <div class="py-2 text-gray-600 hover:bg-blue-50 rounded-lg cursor-pointer transition-colors">1</div>
                                <div class="py-2 text-gray-600 hover:bg-blue-50 rounded-lg cursor-pointer transition-colors">2</div>
                                <div class="py-2 text-gray-600 hover:bg-blue-50 rounded-lg cursor-pointer transition-colors">3</div>
                                <div class="py-2 bg-blue-600 text-white rounded-lg shadow-md shadow-blue-600/30 cursor-pointer transform scale-110">4</div>
                                <div class="py-2 text-gray-600 hover:bg-blue-50 rounded-lg cursor-pointer transition-colors">5</div>
                                <!-- Mock rows -->
                                <div class="py-2 text-gray-600 hover:bg-blue-50 rounded-lg cursor-pointer transition-colors">6</div>
                                <div class="py-2 text-gray-600 hover:bg-blue-50 rounded-lg cursor-pointer transition-colors">7</div>
                                <div class="py-2 text-gray-600 hover:bg-blue-50 rounded-lg cursor-pointer transition-colors">8</div>
                                <div class="py-2 text-gray-600 hover:bg-blue-50 rounded-lg cursor-pointer transition-colors">9</div>
                                <div class="py-2 text-blue-600 border border-blue-200 bg-blue-50 rounded-lg cursor-pointer font-bold">10</div>
                                <div class="py-2 text-gray-600 hover:bg-blue-50 rounded-lg cursor-pointer transition-colors">11</div>
                                <div class="py-2 text-gray-600 hover:bg-blue-50 rounded-lg cursor-pointer transition-colors">12</div>
                            </div>
                        </div>
                        
                        <!-- Events List -->
                        <div class="space-y-4 relative z-10">
                            <div class="flex gap-4 p-5 rounded-2xl bg-blue-50 border border-blue-100 items-center transition-all hover:shadow-md">
                                <div class="flex flex-col items-center justify-center min-w-[50px] bg-white p-2 rounded-xl shadow-sm">
                                    <span class="text-[10px] font-bold text-blue-500 uppercase">Sep</span>
                                    <span class="text-xl font-extrabold text-blue-800 leading-none">04</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm mb-1">Pendampingan Perencanaan Berbasis Data</h4>
                                    <p class="text-xs text-gray-500 font-medium flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 08.00 - Selesai</p>
                                </div>
                            </div>
                            <div class="flex gap-4 p-5 rounded-2xl bg-white border border-gray-100 shadow-sm items-center hover:shadow-md transition-all">
                                <div class="flex flex-col items-center justify-center min-w-[50px] bg-gray-50 p-2 rounded-xl border border-gray-100">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase">Sep</span>
                                    <span class="text-xl font-extrabold text-gray-700 leading-none">10</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm mb-1">Evaluasi SAKIP Internal Tahap II</h4>
                                    <p class="text-xs text-gray-500 font-medium flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 09.00 - 15.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Multimedia -->
                <div>
                    <div class="mb-10">
                        <span class="text-blue-600 font-bold tracking-wider text-sm uppercase mb-2 block">Galeri & Media</span>
                        <h2 class="font-display text-3xl font-extrabold text-blue-900">Multimedia</h2>
                    </div>
                    
                    <div class="flex flex-col gap-6">
                        <!-- YouTube Embed -->
                        <div class="bg-white rounded-3xl p-5 border border-gray-100 shadow-xl shadow-gray-200/50">
                            <h3 class="font-display font-bold text-gray-800 mb-4 ml-1 flex items-center gap-2">
                                <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"></path></svg>
                                Profil BPMP Sultra
                            </h3>
                            <div class="relative w-full aspect-video rounded-2xl overflow-hidden bg-gray-100 group cursor-pointer shadow-inner">
                                <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Video Cover" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                                    <div class="w-16 h-16 bg-white/90 backdrop-blur rounded-full flex items-center justify-center shadow-lg group-hover:bg-red-600 group-hover:text-white transition-colors duration-300 text-red-600">
                                        <svg class="w-8 h-8 ml-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Instagram Grid 2x2 -->
                        <div class="bg-white rounded-3xl p-5 border border-gray-100 shadow-xl shadow-gray-200/50">
                            <h3 class="font-display font-bold text-gray-800 mb-4 ml-1 flex items-center gap-2">
                                <svg class="w-5 h-5 text-pink-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"></path></svg>
                                Instagram Feed
                            </h3>
                            <div class="grid grid-cols-2 gap-4">
                                <a href="#" class="block aspect-square rounded-2xl overflow-hidden relative group shadow-sm">
                                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="IG 1" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-blue-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white"><svg class="w-8 h-8 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg></div>
                                </a>
                                <a href="#" class="block aspect-square rounded-2xl overflow-hidden relative group shadow-sm">
                                    <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="IG 2" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-blue-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white"><svg class="w-8 h-8 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg></div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Berita & Publikasi (Crisp Cards) -->
    <section id="berita" class="py-24 bg-gray-50 relative" x-data="{ tab: 'berita' }">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <span class="text-blue-600 font-bold tracking-wider text-sm uppercase mb-2 block">Pusat Informasi</span>
                <h2 class="font-display text-3xl md:text-4xl font-extrabold text-blue-900 mb-4">Berita & <span class="text-blue-600">Publikasi</span></h2>
                <div class="w-20 h-1.5 bg-blue-600 mx-auto rounded-full mb-10"></div>

                <!-- Alpine Tabs - 5 categories -->
                <div class="inline-flex flex-wrap justify-center bg-white/70 backdrop-blur-md p-1.5 rounded-full border border-gray-200/80 shadow-sm gap-1">
                    <button @click="tab = 'berita'" :class="tab === 'berita' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50/80'" class="px-5 py-2 rounded-full text-sm font-bold transition-all">Berita Terkini</button>
                    <button @click="tab = 'artikel'" :class="tab === 'artikel' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50/80'" class="px-5 py-2 rounded-full text-sm font-bold transition-all">Artikel</button>
                    <button @click="tab = 'program'" :class="tab === 'program' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50/80'" class="px-5 py-2 rounded-full text-sm font-bold transition-all">Program Prioritas</button>
                    <button @click="tab = 'pengumuman'" :class="tab === 'pengumuman' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50/80'" class="px-5 py-2 rounded-full text-sm font-bold transition-all">Pengumuman</button>
                    <button @click="tab = 'dokumentasi'" :class="tab === 'dokumentasi' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50/80'" class="px-5 py-2 rounded-full text-sm font-bold transition-all">Dokumentasi</button>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <article class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-lg shadow-gray-200/50 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col group">
                    <div class="relative h-60 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="News Image" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute top-4 left-4 bg-blue-600 text-white text-xs font-extrabold px-3 py-1.5 rounded-full shadow-sm uppercase tracking-wide" x-text="tab === 'berita' ? 'Berita Terkini' : tab === 'artikel' ? 'Artikel' : tab === 'program' ? 'Program' : tab === 'pengumuman' ? 'Pengumuman' : 'Dokumentasi'"></div>
                        <div class="absolute top-4 right-4 bg-white/95 backdrop-blur text-blue-700 text-xs font-extrabold px-3 py-1.5 rounded-full shadow-sm">Terbaru</div>
                    </div>
                    <div class="p-8 flex flex-col flex-grow">
                        <div class="flex items-center gap-2 text-sm text-gray-500 font-bold mb-3">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            20 September 2026
                        </div>
                        <h3 class="font-display text-xl font-bold text-blue-900 mb-4 group-hover:text-blue-600 transition-colors line-clamp-2" x-text="tab === 'berita' ? 'Sosialisasi Rapor Pendidikan 2026 di Kabupaten Konawe' : 'Panduan Implementasi Kebijakan Baru'"></h3>
                        <p class="text-gray-600 text-sm leading-relaxed mb-8 line-clamp-3">BPMP Sultra menyelenggarakan kegiatan sosialisasi pemanfaatan Rapor Pendidikan untuk perencanaan berbasis data di tingkat daerah guna meningkatkan mutu pembelajaran secara menyeluruh.</p>
                        <div class="mt-auto pt-5 border-t border-gray-100">
                            <a href="/berita/1" class="inline-flex items-center gap-2 text-blue-600 font-bold text-sm hover:text-blue-800 group-hover:translate-x-1 transition-transform">Baca &rarr;</a>
                        </div>
                    </div>
                </article>

                <!-- Card 2 -->
                <article class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-lg shadow-gray-200/50 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col group">
                    <div class="relative h-60 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="News Image" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute top-4 left-4 bg-emerald-600 text-white text-xs font-extrabold px-3 py-1.5 rounded-full shadow-sm uppercase tracking-wide">Program Prioritas</div>
                    </div>
                    <div class="p-8 flex flex-col flex-grow">
                        <div class="flex items-center gap-2 text-sm text-gray-500 font-bold mb-3">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            15 September 2026
                        </div>
                        <h3 class="font-display text-xl font-bold text-blue-900 mb-4 group-hover:text-blue-600 transition-colors line-clamp-2">Pendampingan Implementasi Kurikulum Merdeka</h3>
                        <p class="text-gray-600 text-sm leading-relaxed mb-8 line-clamp-3">Tim fasilitator BPMP Provinsi Sulawesi Tenggara melakukan pendampingan intensif bagi sekolah-sekolah sasaran IKM di wilayah kepulauan terluar.</p>
                        <div class="mt-auto pt-5 border-t border-gray-100">
                            <a href="/berita/2" class="inline-flex items-center gap-2 text-blue-600 font-bold text-sm hover:text-blue-800 group-hover:translate-x-1 transition-transform">Baca &rarr;</a>
                        </div>
                    </div>
                </article>

                <!-- Card 3 -->
                <article class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-lg shadow-gray-200/50 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col group hidden lg:flex">
                    <div class="relative h-60 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="News Image" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute top-4 left-4 bg-amber-500 text-white text-xs font-extrabold px-3 py-1.5 rounded-full shadow-sm uppercase tracking-wide">Dokumentasi</div>
                    </div>
                    <div class="p-8 flex flex-col flex-grow">
                        <div class="flex items-center gap-2 text-sm text-gray-500 font-bold mb-3">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            10 September 2026
                        </div>
                        <h3 class="font-display text-xl font-bold text-blue-900 mb-4 group-hover:text-blue-600 transition-colors line-clamp-2">Kunjungan Kerja Tim Pusat ke BPMP Sultra</h3>
                        <p class="text-gray-600 text-sm leading-relaxed mb-8 line-clamp-3">Menerima kunjungan tim dari kementerian pusat dalam rangka monitoring dan evaluasi penjaminan mutu pendidikan di Sulawesi Tenggara.</p>
                        <div class="mt-auto pt-5 border-t border-gray-100">
                            <a href="/berita/3" class="inline-flex items-center gap-2 text-blue-600 font-bold text-sm hover:text-blue-800 group-hover:translate-x-1 transition-transform">Baca &rarr;</a>
                        </div>
                    </div>
                </article>
            </div>

            <div class="mt-16 text-center">
                <a href="/berita" class="inline-flex items-center gap-2 px-8 py-3.5 bg-white text-blue-700 font-bold border-2 border-blue-100 hover:border-blue-700 hover:bg-blue-50 rounded-full transition-all shadow-sm">
                    Lihat Semua Berita &rarr;
                </a>
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
        <div class="container mx-auto px-4">
            <!-- Google Maps -->
            <div class="w-full aspect-[21/9] bg-gray-100 rounded-2xl overflow-hidden mb-16 border border-slate-200/80 shadow-lg relative">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15920.084478832598!2d122.4939764!3d-4.0470535!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d98f2abdf837c73%3A0xdabf7f6a27e1f40d!2sBPMP%20Provinsi%20Sulawesi%20Tenggara!5e0!3m2!1sid!2sid!4v1684307525359!5m2!1sid!2sid" 
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
        <div class="container mx-auto px-4">
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

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer" class="fixed bottom-6 right-6 z-50 group flex items-center gap-3">
        <div class="px-4 py-2 bg-white text-gray-800 text-sm font-bold rounded-xl shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-4 group-hover:translate-x-0 pointer-events-none whitespace-nowrap">
            Hubungi Kami via WhatsApp
        </div>
        <div class="w-14 h-14 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center shadow-lg transition-transform transform group-hover:scale-110">
            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.898-4.45 9.896-9.898-.001-5.45-4.449-9.896-9.897-9.896-5.448 0-9.898 4.45-9.897 9.896 0 2.115.602 3.734 1.595 5.412l-1.066 3.896 3.973-1.002zm10.536-7.147c-.574-.287-3.411-1.683-3.939-1.875-.528-.192-.912-.287-1.295.287-.383.574-1.488 1.875-1.82 2.257-.333.383-.664.431-1.238.144-.574-.287-2.433-.897-4.636-2.868-1.713-1.534-2.871-3.428-3.204-4.002-.333-.574-.036-.884.25-.17.287.287.574.67.861 1.002.287.333.383.574.574.956.191.383.096.717-.048 1.002-.144.287-1.295 3.123-1.774 4.272-.462 1.11-9.932.956-1.295.956-.383 0-.912-.144-1.439-.717-.528-.574-2.01-1.961-2.01-4.782 0-2.82 2.058-5.547 2.345-5.93.287-.383 4.02-6.143 9.734-8.611 1.36-.587 2.418-.938 3.242-1.202 1.36-.431 2.6-.37 3.585-.224 1.109.165 3.411 1.393 3.89 2.74.479 1.347.479 2.502.336 2.74-.143.239-.527.383-1.101.67z"/></svg>
        </div>
    </a>
</body>
</html>