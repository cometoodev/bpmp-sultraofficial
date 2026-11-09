<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', View::yieldContent('header_title', 'Dashboard')) - CMS BPMP Sultra</title>
    <link rel="icon" href="{{ asset('tutwurihandayani.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        /* Mengaktifkan native smooth scrolling pada seluruh halaman */
        html {
            scroll-behavior: smooth;
        }

        /* Meredam loncatan scroll yang terlalu sensitif pada touchpad */
        body { 
            font-family: 'Poppins', sans-serif; 
            -webkit-overflow-scrolling: touch;
        }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            body, html {
                height: auto !important;
                overflow: visible !important;
                background-color: #ffffff !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gradient-to-br from-slate-100 via-slate-50 to-blue-50/40 text-slate-800 antialiased min-h-screen selection:bg-blue-600 selection:text-white" x-data="{ sidebarOpen: false }">

    <div class="flex min-h-screen bg-slate-50/50 font-sans print:h-auto print:overflow-visible">

        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false" 
             x-transition:enter="transition-opacity ease-linear duration-200" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition-opacity ease-linear duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-md lg:hidden print:hidden"></div>

        <!-- SIDEBAR KIRI -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="w-64 fixed inset-y-0 left-0 z-50 bg-white border-r border-slate-200 flex flex-col shadow-sm transition-transform duration-300 ease-in-out shrink-0 print:hidden">
            
            <!-- Logo Area: Wajib setinggi persis 72px (h-18) dan flex terpusat -->
            <div class="h-18 px-6 flex items-center justify-between border-b border-transparent">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                    <img src="{{ asset('tutwurihandayani.png') }}" class="h-8 w-auto mr-3" alt="Logo">
                    <div class="leading-tight">
                        <span class="block text-sm font-extrabold text-blue-600">BPMP CMS</span>
                        <span class="block text-[10px] text-slate-500 font-medium">Provinsi Sultra</span>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-gray-700 hover:bg-gray-100 p-1.5 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Menu Sidebar Navigation -->
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-3 text-xs font-medium">
                @php
                    $pendingUltCount = \App\Models\UltRequest::where('status', 'pending')->count();
                    $spmbPendingCount = \App\Models\SpmbReport::where('status', 'pending')->count();
                    $gratPendingCount = \App\Models\GratificationReport::where('status', 'pending')->count();
                    $contactCount = \App\Models\ContactMessage::count();
                    $totalAduanBadge = $spmbPendingCount + $gratPendingCount + $contactCount;
                @endphp

                <!-- SECTION 1: MENU UTAMA -->
                <div class="space-y-1">
                    <div class="px-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                        Menu Utama
                    </div>

                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-700 hover:bg-slate-50 hover:text-blue-600' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </div>

                <!-- SECTION 2: PUBLIKASI & KONTEN -->
                <div class="space-y-1 pt-1">
                    <div class="px-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                        Publikasi & Konten
                    </div>

                    @if(Auth::user()?->isSuperAdmin())
                    <!-- Dropdown: Homepage -->
                    <div x-data="{ open: {{ request()->routeIs('admin.awards.*', 'admin.agendas.*', 'admin.events.*', 'admin.social.*') ? 'true' : 'false' }} }" class="space-y-1">
                        <button type="button" 
                                @click="open = !open" 
                                class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium transition-all group {{ request()->routeIs('admin.awards.*', 'admin.agendas.*', 'admin.events.*', 'admin.social.*') ? 'text-blue-700 bg-blue-50/70 font-semibold' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                            <div class="flex items-center gap-3 min-w-0">
                                <svg class="w-4 h-4 shrink-0 transition-colors {{ request()->routeIs('admin.awards.*', 'admin.agendas.*', 'admin.events.*', 'admin.social.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span class="truncate">Homepage</span>
                            </div>
                            <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 shrink-0 ml-2" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-collapse x-cloak class="ml-4 pl-3 border-l border-slate-200/80 space-y-0.5 py-0.5">
                            <a href="{{ route('admin.awards.index') }}"
                               class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.awards.*') ? 'bg-blue-600 text-white font-medium shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ request()->routeIs('admin.awards.*') ? 'bg-white' : 'bg-slate-300 group-hover:bg-blue-500' }}"></span>
                                    <span class="truncate">Maklumat & Penghargaan</span>
                                </div>
                            </a>
                            <a href="{{ route('admin.agendas.index') }}"
                               class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.agendas.*') ? 'bg-blue-600 text-white font-medium shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ request()->routeIs('admin.agendas.*') ? 'bg-white' : 'bg-slate-300 group-hover:bg-blue-500' }}"></span>
                                    <span class="truncate">Agenda Kegiatan</span>
                                </div>
                            </a>
                            <a href="{{ route('admin.events.index') }}"
                               class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.events.*') ? 'bg-blue-600 text-white font-medium shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ request()->routeIs('admin.events.*') ? 'bg-white' : 'bg-slate-300 group-hover:bg-blue-500' }}"></span>
                                    <span class="truncate">Events & Webinar</span>
                                </div>
                            </a>
                            <a href="{{ route('admin.social.index') }}"
                               class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.social.*') ? 'bg-blue-600 text-white font-medium shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ request()->routeIs('admin.social.*') ? 'bg-white' : 'bg-slate-300 group-hover:bg-blue-500' }}"></span>
                                    <span class="truncate">Integrasi Media Sosial</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Pages (Halaman) - Standalone Menu -->
                    <a href="{{ route('admin.pages.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs transition-all {{ request()->routeIs('admin.pages.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-700 hover:bg-slate-50 hover:text-blue-600' }}">
                        <svg class="w-4 h-4 shrink-0 transition-colors {{ request()->routeIs('admin.pages.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="truncate">Pages (Halaman)</span>
                    </a>
                    @endif

                    <!-- Dropdown: Elemen & Unggahan Page -->
                    <div x-data="{ open: {{ request()->routeIs('admin.standar-pelayanan.*') ? 'true' : 'false' }} }" class="space-y-1">
                        <button type="button" 
                                @click="open = !open" 
                                class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium transition-all group {{ request()->routeIs('admin.standar-pelayanan.*') ? 'text-blue-700 bg-blue-50/70 font-semibold' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                            <div class="flex items-center gap-3 min-w-0">
                                <svg class="w-4 h-4 shrink-0 transition-colors {{ request()->routeIs('admin.standar-pelayanan.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <span class="truncate">Elemen & Unggahan Page</span>
                            </div>
                            <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 shrink-0 ml-2" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-collapse x-cloak class="ml-4 pl-3 border-l border-slate-200/80 space-y-0.5 py-0.5">
                            <a href="{{ route('admin.standar-pelayanan.index') }}"
                               class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.standar-pelayanan.*') ? 'bg-blue-600 text-white font-medium shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ request()->routeIs('admin.standar-pelayanan.*') ? 'bg-white' : 'bg-slate-300 group-hover:bg-blue-500' }}"></span>
                                    <span class="truncate">Standar Pelayanan</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Dropdown: Kabar & Informasi -->
                    <div x-data="{ open: {{ request()->routeIs('admin.posts.*', 'admin.categories.*', 'admin.announcements.*') ? 'true' : 'false' }} }" class="space-y-1">
                        <button type="button" 
                                @click="open = !open" 
                                class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium transition-all group {{ request()->routeIs('admin.posts.*', 'admin.categories.*', 'admin.announcements.*') ? 'text-blue-700 bg-blue-50/70 font-semibold' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                            <div class="flex items-center gap-3 min-w-0">
                                <svg class="w-4 h-4 shrink-0 transition-colors {{ request()->routeIs('admin.posts.*', 'admin.categories.*', 'admin.announcements.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path>
                                </svg>
                                <span class="truncate">Kabar & Informasi</span>
                            </div>
                            <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 shrink-0 ml-2" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-collapse x-cloak class="ml-4 pl-3 border-l border-slate-200/80 space-y-0.5 py-0.5">
                            <a href="{{ route('admin.posts.index') }}"
                               class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.posts.*') ? 'bg-blue-600 text-white font-medium shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ request()->routeIs('admin.posts.*') ? 'bg-white' : 'bg-slate-300 group-hover:bg-blue-500' }}"></span>
                                    <span class="truncate">Berita & Artikel</span>
                                </div>
                            </a>
                            <a href="{{ route('admin.categories.index') }}"
                               class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600 text-white font-medium shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-white' : 'bg-slate-300 group-hover:bg-blue-500' }}"></span>
                                    <span class="truncate">Kategori Berita</span>
                                </div>
                            </a>
                            <a href="{{ route('admin.announcements.index') }}"
                               class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.announcements.*') ? 'bg-blue-600 text-white font-medium shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ request()->routeIs('admin.announcements.*') ? 'bg-white' : 'bg-slate-300 group-hover:bg-blue-500' }}"></span>
                                    <span class="truncate">Pengumuman</span>
                                </div>
                            </a>
                        </div>
                    </div>



                    <!-- Dropdown: Media & Tampilan -->
                    <div x-data="{ open: {{ request()->routeIs('admin.banners.*', 'admin.media.*') ? 'true' : 'false' }} }" class="space-y-1">
                        <button type="button" 
                                @click="open = !open" 
                                class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium transition-all group {{ request()->routeIs('admin.banners.*', 'admin.media.*') ? 'text-blue-700 bg-blue-50/70 font-semibold' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                            <div class="flex items-center gap-3 min-w-0">
                                <svg class="w-4 h-4 shrink-0 transition-colors {{ request()->routeIs('admin.banners.*', 'admin.media.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="truncate">Media & Tampilan</span>
                            </div>
                            <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 shrink-0 ml-2" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-collapse x-cloak class="ml-4 pl-3 border-l border-slate-200/80 space-y-0.5 py-0.5">
                            @if(Auth::user()?->isSuperAdmin())
                            <a href="{{ route('admin.banners.index') }}"
                               class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.banners.*') ? 'bg-blue-600 text-white font-medium shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ request()->routeIs('admin.banners.*') ? 'bg-white' : 'bg-slate-300 group-hover:bg-blue-500' }}"></span>
                                    <span class="truncate">Banner / Hero</span>
                                </div>
                            </a>
                            @endif
                            <a href="{{ route('admin.media.index') }}"
                               class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.media.*') ? 'bg-blue-600 text-white font-medium shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ request()->routeIs('admin.media.*') ? 'bg-white' : 'bg-slate-300 group-hover:bg-blue-500' }}"></span>
                                    <span class="truncate">Media Library</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                @if(Auth::user()?->isSuperAdmin())
                <!-- SECTION 3: LAYANAN & PENGADUAN -->
                <div class="space-y-1 pt-1">
                    <div class="px-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                        Layanan & Pengaduan
                    </div>

                    <!-- Dropdown: Layanan ULT -->
                    <div x-data="{ open: {{ request()->routeIs('admin.ult.*', 'admin.guestbook.*', 'admin.skm.*') ? 'true' : 'false' }} }" class="space-y-1">
                        <button type="button" 
                                @click="open = !open" 
                                class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium transition-all group {{ request()->routeIs('admin.ult.*', 'admin.guestbook.*', 'admin.skm.*') ? 'text-blue-700 bg-blue-50/70 font-semibold' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                            <div class="flex items-center gap-3 min-w-0">
                                <svg class="w-4 h-4 shrink-0 transition-colors {{ request()->routeIs('admin.ult.*', 'admin.guestbook.*', 'admin.skm.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                <span class="truncate">Layanan ULT</span>
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0 ml-2">
                                @if($pendingUltCount > 0)
                                     <span class="text-[10px] px-1.5 py-0.5 rounded-full font-bold bg-amber-500 text-white leading-none">{{ $pendingUltCount }}</span>
                                @endif
                                <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>
                        <div x-show="open" x-collapse x-cloak class="ml-4 pl-3 border-l border-slate-200/80 space-y-0.5 py-0.5">
                            <a href="{{ route('admin.ult.index') }}"
                               class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.ult.*') ? 'bg-blue-600 text-white font-medium shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ request()->routeIs('admin.ult.*') ? 'bg-white' : 'bg-slate-300 group-hover:bg-blue-500' }}"></span>
                                    <span class="truncate">Permohonan ULT</span>
                                </div>
                                @if($pendingUltCount > 0)
                                    <span class="text-[10px] px-1.5 py-0.5 rounded-full font-bold ml-1.5 shrink-0 leading-none {{ request()->routeIs('admin.ult.*') ? 'bg-white text-blue-700' : 'bg-amber-500 text-white' }}">{{ $pendingUltCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('admin.guestbook.index') }}"
                               class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.guestbook.*') ? 'bg-blue-600 text-white font-medium shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ request()->routeIs('admin.guestbook.*') ? 'bg-white' : 'bg-slate-300 group-hover:bg-blue-500' }}"></span>
                                    <span class="truncate">Buku Tamu ULT</span>
                                </div>
                            </a>
                            <a href="{{ route('admin.skm.dashboard') }}"
                               class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.skm.*') ? 'bg-blue-600 text-white font-medium shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ request()->routeIs('admin.skm.*') ? 'bg-white' : 'bg-slate-300 group-hover:bg-blue-500' }}"></span>
                                    <span class="truncate">Analitik SKM ULT</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Dropdown: Aduan & Kontak -->
                    <div x-data="{ open: {{ request()->routeIs('admin.spmb.*', 'admin.gratification.*', 'admin.contacts.*') ? 'true' : 'false' }} }" class="space-y-1">
                        <button type="button" 
                                @click="open = !open" 
                                class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium transition-all group {{ request()->routeIs('admin.spmb.*', 'admin.gratification.*', 'admin.contacts.*') ? 'text-blue-700 bg-blue-50/70 font-semibold' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                            <div class="flex items-center gap-3 min-w-0">
                                <svg class="w-4 h-4 shrink-0 transition-colors {{ request()->routeIs('admin.spmb.*', 'admin.gratification.*', 'admin.contacts.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                </svg>
                                <span class="truncate">Aduan & Kontak</span>
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0 ml-2">
                                @if($totalAduanBadge > 0)
                                    <span class="text-[10px] px-1.5 py-0.5 rounded-full font-bold bg-amber-500 text-white leading-none">{{ $totalAduanBadge }}</span>
                                @endif
                                <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>
                        <div x-show="open" x-collapse x-cloak class="ml-4 pl-3 border-l border-slate-200/80 space-y-0.5 py-0.5">
                            <a href="{{ route('admin.spmb.index') }}"
                               class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.spmb.*') ? 'bg-blue-600 text-white font-medium shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ request()->routeIs('admin.spmb.*') ? 'bg-white' : 'bg-slate-300 group-hover:bg-blue-500' }}"></span>
                                    <span class="truncate">Pengaduan SPMB</span>
                                </div>
                                @if($spmbPendingCount > 0)
                                    <span class="text-[10px] px-1.5 py-0.5 rounded-full font-bold ml-1.5 shrink-0 leading-none {{ request()->routeIs('admin.spmb.*') ? 'bg-white text-blue-700' : 'bg-amber-500 text-white' }}">{{ $spmbPendingCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('admin.gratification.index') }}"
                               class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.gratification.*') ? 'bg-blue-600 text-white font-medium shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ request()->routeIs('admin.gratification.*') ? 'bg-white' : 'bg-slate-300 group-hover:bg-blue-500' }}"></span>
                                    <span class="truncate">Lapor Gratifikasi</span>
                                </div>
                                @if($gratPendingCount > 0)
                                    <span class="text-[10px] px-1.5 py-0.5 rounded-full font-bold ml-1.5 shrink-0 leading-none {{ request()->routeIs('admin.gratification.*') ? 'bg-white text-blue-700' : 'bg-amber-500 text-white' }}">{{ $gratPendingCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('admin.contacts.index') }}"
                               class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.contacts.*') ? 'bg-blue-600 text-white font-medium shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ request()->routeIs('admin.contacts.*') ? 'bg-white' : 'bg-slate-300 group-hover:bg-blue-500' }}"></span>
                                    <span class="truncate">Pesan Masuk</span>
                                </div>
                                @if($contactCount > 0)
                                    <span class="text-[10px] px-1.5 py-0.5 rounded-full font-bold ml-1.5 shrink-0 leading-none {{ request()->routeIs('admin.contacts.*') ? 'bg-white text-blue-700' : 'bg-indigo-500 text-white' }}">{{ $contactCount }}</span>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>

                <!-- SECTION 4: SISTEM & IT -->
                <div class="space-y-1 pt-1">
                    <div class="px-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                        Sistem & IT
                    </div>

                    <!-- Manajemen Pengguna (Super Admin) -->
                    <a href="{{ route('admin.users.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs transition-all {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-700 hover:bg-slate-50 hover:text-blue-600' }}">
                        <svg class="w-4 h-4 shrink-0 transition-colors {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="truncate">Manajemen Pengguna</span>
                    </a>

                    <!-- Dropdown: Pengaturan Teknis -->
                    <div x-data="{ open: {{ request()->routeIs('admin.menus.*', 'admin.seo.*', 'admin.settings.*') ? 'true' : 'false' }} }" class="space-y-1">
                        <button type="button" 
                                @click="open = !open" 
                                class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium transition-all group {{ request()->routeIs('admin.menus.*', 'admin.seo.*', 'admin.settings.*') ? 'text-blue-700 bg-blue-50/70 font-semibold' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                            <div class="flex items-center gap-3 min-w-0">
                                <svg class="w-4 h-4 shrink-0 transition-colors {{ request()->routeIs('admin.menus.*', 'admin.seo.*', 'admin.settings.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="truncate">Pengaturan Teknis</span>
                            </div>
                            <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 shrink-0 ml-2" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-collapse x-cloak class="ml-4 pl-3 border-l border-slate-200/80 space-y-0.5 py-0.5">
                            <a href="{{ route('admin.menus.index') }}"
                               class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.menus.*') ? 'bg-blue-600 text-white font-medium shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ request()->routeIs('admin.menus.*') ? 'bg-white' : 'bg-slate-300 group-hover:bg-blue-500' }}"></span>
                                    <span class="truncate">Menu Navigasi</span>
                                </div>
                            </a>
                            <a href="{{ route('admin.seo.index') }}"
                               class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.seo.*') ? 'bg-blue-600 text-white font-medium shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ request()->routeIs('admin.seo.*') ? 'bg-white' : 'bg-slate-300 group-hover:bg-blue-500' }}"></span>
                                    <span class="truncate">SEO Dasar</span>
                                </div>
                            </a>
                            <a href="{{ route('admin.settings.index') }}"
                               class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-blue-600 text-white font-medium shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-white' : 'bg-slate-300 group-hover:bg-blue-500' }}"></span>
                                    <span class="truncate">Pengaturan Website</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- SECTION: AKUN SAYA (Bisa Diakses Semua Akun) -->
                <div class="space-y-1 pt-1">
                    <div class="px-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                        Akun Saya
                    </div>
                    <a href="{{ route('admin.profile.edit') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs transition-all {{ request()->routeIs('admin.profile.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-700 hover:bg-slate-50 hover:text-blue-600' }}">
                        <svg class="w-4 h-4 shrink-0 transition-colors {{ request()->routeIs('admin.profile.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="truncate">Profil & Keamanan</span>
                    </a>
                </div>
            </nav>

            <!-- User Info & Logout -->
            <div class="p-3 border-t border-slate-200/50 bg-white/40 backdrop-blur-md flex items-center justify-between">
                <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-2.5 min-w-0 group hover:opacity-90 transition-opacity" title="Kelola Profil & Kredensial">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-600 to-sky-500 text-white font-bold flex items-center justify-center text-xs shrink-0 shadow-xs group-hover:ring-2 group-hover:ring-blue-400 transition-all">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-gray-800 truncate group-hover:text-blue-600">{{ Auth::user()->name ?? 'Administrator' }}</p>
                        <p class="text-[10px] text-gray-500 truncate flex items-center gap-1">
                            <span>{{ Auth::user()->email ?? '' }}</span>
                            @if(Auth::user()?->isSuperAdmin())
                                <span class="inline-block px-1 py-0.2 bg-blue-100 text-blue-700 rounded text-[9px] font-bold">Admin Utama</span>
                            @else
                                <span class="inline-block px-1 py-0.2 bg-slate-100 text-slate-700 rounded text-[9px] font-semibold">Editor</span>
                            @endif
                        </p>
                    </div>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Keluar" class="p-1.5 text-gray-400 hover:text-rose-600 hover:bg-rose-50/80 rounded-lg transition-colors cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </aside>

        <!-- KONTEN KANAN -->
        <div class="flex-1 ml-0 lg:ml-64 flex flex-col min-h-screen w-full min-w-0 bg-slate-50/50 print:overflow-visible">
            
            <!-- HEADER KONTEN GLOBAL -->
            <!-- Tinggi h-18 (72px) sejajar persis dengan area logo di sidebar -->
            <header class="h-18 sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-slate-200/50 px-6 lg:px-8 flex items-center justify-between transition-all print:hidden">
                <!-- Slot untuk Judul Halaman -->
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 text-slate-600 hover:text-slate-900 rounded-lg hover:bg-slate-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div class="flex flex-col justify-center">
                        <!-- Ukuran diperkecil (text-lg) dan warna dilembutkan (text-slate-700) -->
                        <h1 class="text-lg font-bold text-slate-700 tracking-tight">
                            @yield('header_title', View::yieldContent('page_title', 'Dashboard'))
                        </h1>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">
                            @yield('header_subtitle', 'Kelola konten website resmi BPMP Provinsi Sulawesi Tenggara')
                        </p>
                    </div>
                </div>
                
                <!-- Slot untuk Tombol Tambah/Aksi Kanan -->
                <div class="flex items-center gap-2.5">
                    @yield('header_action')
                    @yield('header_actions')
                    <a href="{{ route('admin.profile.edit') }}"
                       class="hidden sm:inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-slate-600 hover:text-blue-600 bg-white/80 hover:bg-white backdrop-blur-sm border border-slate-200/80 rounded-xl transition-all shadow-xs hover:shadow-sm" title="Pengaturan Profil & Akun">
                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span>Profil Saya</span>
                    </a>
                    <a href="{{ url('/') }}" target="_blank"
                       class="hidden sm:inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-slate-600 hover:text-blue-600 bg-white/80 hover:bg-white backdrop-blur-sm border border-slate-200/80 rounded-xl transition-all shadow-xs hover:shadow-sm">
                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        <span>Lihat Website</span>
                    </a>
                </div>
            </header>

            <!-- AREA KONTEN (Tabel, Form, dll) -->
            <main class="flex-1 p-6 md:p-8 w-full overflow-x-hidden">
                
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50/80 backdrop-blur-md border border-emerald-200/60 text-emerald-800 rounded-2xl flex items-center justify-between shadow-xs" x-data="{ show: true }" x-show="show">
                        <div class="flex items-center gap-3 text-sm">
                            <span class="p-1 bg-emerald-100/80 rounded-full text-emerald-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </span>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 text-sm">&times;</button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-rose-50/80 backdrop-blur-md border border-rose-200/60 text-rose-800 rounded-2xl flex items-center justify-between shadow-xs" x-data="{ show: true }" x-show="show">
                        <div class="flex items-center gap-3 text-sm">
                            <span class="p-1 bg-rose-100/80 rounded-full text-rose-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </span>
                            <span>{{ session('error') }}</span>
                        </div>
                        <button @click="show = false" class="text-rose-500 hover:text-rose-700 text-sm">&times;</button>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- FOOTER -->
            <footer class="mt-auto py-6 border-t border-slate-200 bg-transparent text-center">
                <p class="text-xs text-slate-400 font-medium">&copy; {{ date('Y') }} CMS BPMP Provinsi Sulawesi Tenggara</p>
            </footer>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

    <!-- Skrip Opsional untuk meredam kepekaan scroll touchpad yang berlebihan -->
    <script>
        let isScrolling = false;
        window.addEventListener('wheel', function(e) {
            // Jika deltaY kecil (biasanya ciri khas gesekan touchpad yang terlalu sensitif),
            // kita berikan sedikit redaman agar terasa lebih "berat" dan elegan.
            if (Math.abs(e.deltaY) < 50 && !isScrolling) {
                // Anda bisa menyesuaikan pembagi di bawah ini (misal * 0.6) untuk memperlambat
            }
        }, { passive: true });
    </script>

    @stack('scripts')
</body>
</html>

