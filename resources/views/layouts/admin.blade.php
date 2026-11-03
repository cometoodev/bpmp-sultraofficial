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
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1 text-xs font-medium">
                
                <div class="px-3 pb-2 pt-1 text-[11px] font-bold uppercase tracking-wider text-gray-500">
                    Menu Utama
                </div>

                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-gray-700 hover:bg-slate-50 hover:text-blue-600 hover:shadow-xs' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>Dashboard</span>
                </a>

                <!-- Pages -->
                <a href="{{ route('admin.pages.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.pages.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-gray-700 hover:bg-slate-50 hover:text-blue-600 hover:shadow-xs' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Pages (Halaman)</span>
                </a>

                <!-- Berita -->
                <a href="{{ route('admin.posts.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.posts.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-gray-700 hover:bg-slate-50 hover:text-blue-600 hover:shadow-xs' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                    <span>Berita & Artikel</span>
                </a>

                <!-- Kategori Berita -->
                <a href="{{ route('admin.categories.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-gray-700 hover:bg-slate-50 hover:text-blue-600 hover:shadow-xs' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    <span>Kategori Berita</span>
                </a>

                <!-- Media -->
                <a href="{{ route('admin.media.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.media.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-gray-700 hover:bg-slate-50 hover:text-blue-600 hover:shadow-xs' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>Media Library</span>
                </a>

                <div class="px-3 pb-2 pt-3 text-[11px] font-bold uppercase tracking-wider text-gray-500">
                    Navigasi & Tampilan
                </div>

                <!-- Menu Navigasi -->
                <a href="{{ route('admin.menus.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.menus.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-gray-700 hover:bg-slate-50 hover:text-blue-600 hover:shadow-xs' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <span>Menu Navigasi</span>
                </a>

                <!-- Banner / Hero -->
                <a href="{{ route('admin.banners.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.banners.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-gray-700 hover:bg-slate-50 hover:text-blue-600 hover:shadow-xs' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>
                    <span>Banner / Hero</span>
                </a>

                <!-- Pengumuman -->
                <a href="{{ route('admin.announcements.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.announcements.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-gray-700 hover:bg-slate-50 hover:text-blue-600 hover:shadow-xs' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    <span>Pengumuman</span>
                </a>

                <!-- Agenda Kegiatan -->
                <a href="{{ route('admin.agendas.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.agendas.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-gray-700 hover:bg-slate-50 hover:text-blue-600 hover:shadow-xs' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>Agenda Kegiatan</span>
                </a>

                <!-- Events & Webinar -->
                <a href="{{ route('admin.events.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.events.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-gray-700 hover:bg-slate-50 hover:text-blue-600 hover:shadow-xs' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    <span>Events & Webinar</span>
                </a>

                <!-- Maklumat & Penghargaan -->
                <a href="{{ route('admin.awards.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.awards.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-gray-700 hover:bg-slate-50 hover:text-blue-600 hover:shadow-xs' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    <span>Maklumat & Penghargaan</span>
                </a>

                <!-- Survei Kepuasan Masyarakat (SKM) -->
                <a href="{{ route('admin.surveys.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.surveys.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-gray-700 hover:bg-slate-50 hover:text-blue-600 hover:shadow-xs' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <span>Survei SKM</span>
                </a>

                <div class="px-3 pb-2 pt-3 text-[11px] font-bold uppercase tracking-wider text-gray-500">
                    Layanan ULT & SKM
                </div>

                <!-- Permohonan & Tiket Layanan ULT -->
                <a href="{{ route('admin.ult.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.ult.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-gray-700 hover:bg-slate-50 hover:text-blue-600 hover:shadow-xs' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    <span>Permohonan ULT</span>
                    @php
                        $pendingUltCount = \App\Models\UltRequest::where('status', 'pending')->count();
                    @endphp
                    @if($pendingUltCount > 0)
                        <span class="ml-auto text-[10px] px-2 py-0.5 rounded-full font-bold {{ request()->routeIs('admin.ult.*') ? 'bg-white text-blue-700' : 'bg-amber-500 text-white' }}">{{ $pendingUltCount }}</span>
                    @endif
                </a>

                <!-- Standar Pelayanan (Dokumen PDF) -->
                <a href="{{ route('admin.standar-pelayanan.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.standar-pelayanan.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-gray-700 hover:bg-slate-50 hover:text-blue-600 hover:shadow-xs' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    <span>Standar Pelayanan</span>
                </a>

                <!-- Pengaduan Masyarakat (SPMB) -->
                <a href="{{ route('admin.spmb.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.spmb.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-gray-700 hover:bg-slate-50 hover:text-blue-600 hover:shadow-xs' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    <span>Pengaduan SPMB</span>
                    @php
                        $spmbPendingCount = \App\Models\SpmbReport::where('status', 'pending')->count();
                    @endphp
                    @if($spmbPendingCount > 0)
                        <span class="ml-auto text-[10px] px-2 py-0.5 rounded-full font-bold {{ request()->routeIs('admin.spmb.*') ? 'bg-white text-blue-700' : 'bg-amber-500 text-white' }}">{{ $spmbPendingCount }}</span>
                    @endif
                </a>

                <!-- Lapor Gratifikasi (UPG) -->
                <a href="{{ route('admin.gratification.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.gratification.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-gray-700 hover:bg-slate-50 hover:text-blue-600 hover:shadow-xs' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span>Lapor Gratifikasi</span>
                    @php
                        $gratPendingCount = \App\Models\GratificationReport::where('status', 'pending')->count();
                    @endphp
                    @if($gratPendingCount > 0)
                        <span class="ml-auto text-[10px] px-2 py-0.5 rounded-full font-bold {{ request()->routeIs('admin.gratification.*') ? 'bg-white text-blue-700' : 'bg-amber-500 text-white' }}">{{ $gratPendingCount }}</span>
                    @endif
                </a>

                <!-- Buku Tamu & Kuisioner ULT -->
                <a href="{{ route('admin.guestbook.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.guestbook.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-gray-700 hover:bg-slate-50 hover:text-blue-600 hover:shadow-xs' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <span>Buku Tamu ULT</span>
                </a>

                <!-- Dashboard Analitik SKM ULT -->
                <a href="{{ route('admin.skm.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.skm.dashboard') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-gray-700 hover:bg-slate-50 hover:text-blue-600 hover:shadow-xs' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <span>Analitik SKM ULT</span>
                    <span class="ml-auto flex items-center gap-0.5 text-[10px] px-1.5 py-0.5 rounded-full {{ request()->routeIs('admin.skm.dashboard') ? 'bg-white/20 text-white' : 'bg-blue-50 text-blue-600 border border-blue-200' }} font-bold">NEW</span>
                </a>

                <!-- Pesan Masuk (Hubungi Kami) -->
                <a href="{{ route('admin.contacts.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.contacts.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-gray-700 hover:bg-slate-50 hover:text-blue-600 hover:shadow-xs' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>Pesan Masuk</span>
                    @php
                        $contactCount = \App\Models\ContactMessage::count();
                    @endphp
                    @if($contactCount > 0)
                        <span class="ml-auto text-[10px] px-2 py-0.5 rounded-full font-bold {{ request()->routeIs('admin.contacts.*') ? 'bg-white text-blue-700' : 'bg-indigo-500 text-white' }}">{{ $contactCount }}</span>
                    @endif
                </a>

                <div class="px-3 pb-2 pt-3 text-[11px] font-bold uppercase tracking-wider text-gray-500">
                    Konfigurasi
                </div>

                <!-- SEO -->
                <a href="{{ route('admin.seo.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.seo.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-gray-700 hover:bg-slate-50 hover:text-blue-600 hover:shadow-xs' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <span>SEO Dasar</span>
                </a>

                <!-- Settings -->
                <a href="{{ route('admin.settings.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-gray-700 hover:bg-slate-50 hover:text-blue-600 hover:shadow-xs' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Pengaturan Website</span>
                </a>

            </nav>

            <!-- User Info & Logout -->
            <div class="p-3 border-t border-slate-200/50 bg-white/40 backdrop-blur-md flex items-center justify-between">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-600 to-sky-500 text-white font-bold flex items-center justify-center text-xs shrink-0 shadow-xs">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-gray-800 truncate">{{ Auth::user()->name ?? 'Administrator' }}</p>
                        <p class="text-[10px] text-gray-500 truncate">{{ Auth::user()->email ?? '' }}</p>
                    </div>
                </div>
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
                <div class="flex items-center gap-3">
                    @yield('header_action')
                    @yield('header_actions')
                    <a href="{{ url('/') }}" target="_blank"
                       class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-slate-600 hover:text-blue-600 bg-white/80 hover:bg-white backdrop-blur-sm border border-slate-200/80 rounded-xl transition-all shadow-xs hover:shadow-sm">
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

