@extends('layouts.admin')

@section('title', 'CMS Dashboard')
@section('header_title', 'Dashboard')
@section('header_subtitle', 'Ringkasan statistik dan aktivitas website BPMP Sulawesi Tenggara')

@section('content')
<div class="space-y-6">

    <!-- 1. Welcome Banner (Lebih Gelap & Pekat untuk Kontras Tinggi) -->
    <div class="relative overflow-hidden bg-gradient-to-r from-blue-800 to-indigo-900 backdrop-blur-xl border border-white/10 shadow-2xl rounded-3xl p-8 text-white">
        <!-- Ambient Decorative Glows & Radial Overlay -->
        <div class="absolute -right-12 -bottom-12 w-72 h-72 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-12 -top-12 w-60 h-60 bg-indigo-500/20 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-white/10 via-transparent to-transparent pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/15 backdrop-blur-md rounded-full text-xs font-semibold text-sky-200 border border-white/20 mb-3 shadow-xs">
                    <span>✨</span>
                    <span>Portal Manajemen Konten</span>
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight drop-shadow-md">Selamat Datang, {{ Auth::user()->name }}!</h1>
                <p class="text-sm text-blue-100 mt-1.5 max-w-xl leading-relaxed drop-shadow-xs">
                    Kelola seluruh konten website resmi BPMP Provinsi Sulawesi Tenggara secara dinamis, terpusat, dan cepat.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="{{ route('admin.pages.create') }}" class="px-5 py-2.5 bg-white hover:bg-blue-50 text-blue-900 text-xs font-bold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2 hover:-translate-y-0.5">
                    <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    <span>Tambah Halaman</span>
                </a>
                <a href="{{ route('admin.posts.create') }}" class="px-5 py-2.5 bg-white/15 hover:bg-white/25 text-white backdrop-blur-md text-xs font-bold rounded-xl shadow transition-all duration-200 flex items-center gap-2 border border-white/30 hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <span>Tulis Berita</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 2. Statistics Grid (Konsistensi Base Class Glassmorphism) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Pages -->
        <div class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl p-6 transition-all duration-300 hover:bg-white/90 hover:shadow-lg flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Halaman</p>
                <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['total_pages'] }}</h3>
                <div class="flex items-center gap-2 mt-2 text-[11px] font-medium">
                    <span class="text-emerald-700 bg-emerald-50/80 border border-emerald-200/50 px-2 py-0.5 rounded-full font-semibold">{{ $stats['published_pages'] }} Publish</span>
                    <span class="text-amber-700 bg-amber-50/80 border border-amber-200/50 px-2 py-0.5 rounded-full font-semibold">{{ $stats['draft_pages'] }} Draft</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-500/10 border border-blue-500/20 text-blue-600 flex items-center justify-center shrink-0 shadow-xs">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </div>

        <!-- Total Posts -->
        <div class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl p-6 transition-all duration-300 hover:bg-white/90 hover:shadow-lg flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Berita</p>
                <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['total_posts'] }}</h3>
                <div class="flex items-center gap-2 mt-2 text-[11px] font-medium">
                    <span class="text-emerald-700 bg-emerald-50/80 border border-emerald-200/50 px-2 py-0.5 rounded-full font-semibold">{{ $stats['published_posts'] }} Tayang</span>
                    <span class="text-slate-500">Artikel edukasi</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-600 flex items-center justify-center shrink-0 shadow-xs">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
            </div>
        </div>

        <!-- Media & Categories -->
        <div class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl p-6 transition-all duration-300 hover:bg-white/90 hover:shadow-lg flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Media & Kategori</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <h3 class="text-2xl font-black text-slate-800">{{ $stats['total_media'] }}</h3>
                    <span class="text-xs text-slate-500 font-medium">/ {{ $stats['total_categories'] }} Kategori</span>
                </div>
                <p class="text-[11px] text-slate-500 mt-2">File foto & kategori aktif</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-sky-500/10 border border-sky-500/20 text-sky-600 flex items-center justify-center shrink-0 shadow-xs">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        </div>

        <!-- Announcements -->
        <div class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl p-6 transition-all duration-300 hover:bg-white/90 hover:shadow-lg flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Pengumuman</p>
                <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['total_announcements'] }}</h3>
                <p class="text-[11px] text-slate-500 mt-2">Pengumuman dinas aktif</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shrink-0 shadow-xs">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
            </div>
        </div>

    </div>

    <!-- 3. Quick Navigation Shortcuts (Base Class Seragam) -->
    <div class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl p-6 transition-all duration-300 hover:bg-white/90 hover:shadow-lg">
        <div class="flex items-center gap-2.5 mb-5">
            <span class="w-2.5 h-6 bg-blue-600 rounded-full"></span>
            <h3 class="text-sm font-bold text-slate-800" style="font-family:'Plus Jakarta Sans',sans-serif;">Akses Cepat Pengelolaan</h3>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
            <a href="{{ route('admin.pages.index') }}" class="p-3 text-center rounded-xl bg-white/70 hover:bg-white border border-white/80 hover:border-blue-200/80 backdrop-blur-sm transition-all duration-300 group shadow-xs hover:shadow-md hover:-translate-y-0.5">
                <div class="w-9 h-9 mx-auto mb-1.5 rounded-xl bg-blue-500/10 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 block">Pages</span>
            </a>
            <a href="{{ route('admin.posts.index') }}" class="p-3 text-center rounded-xl bg-white/70 hover:bg-white border border-white/80 hover:border-indigo-200/80 backdrop-blur-sm transition-all duration-300 group shadow-xs hover:shadow-md hover:-translate-y-0.5">
                <div class="w-9 h-9 mx-auto mb-1.5 rounded-xl bg-indigo-500/10 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 block">Berita</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="p-3 text-center rounded-xl bg-white/70 hover:bg-white border border-white/80 hover:border-emerald-200/80 backdrop-blur-sm transition-all duration-300 group shadow-xs hover:shadow-md hover:-translate-y-0.5">
                <div class="w-9 h-9 mx-auto mb-1.5 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 block">Kategori</span>
            </a>
            <a href="{{ route('admin.media.index') }}" class="p-3 text-center rounded-xl bg-white/70 hover:bg-white border border-white/80 hover:border-sky-200/80 backdrop-blur-sm transition-all duration-300 group shadow-xs hover:shadow-md hover:-translate-y-0.5">
                <div class="w-9 h-9 mx-auto mb-1.5 rounded-xl bg-sky-500/10 text-sky-600 flex items-center justify-center group-hover:scale-110 transition-transform shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 block">Media</span>
            </a>
            <a href="{{ route('admin.menus.index') }}" class="p-3 text-center rounded-xl bg-white/70 hover:bg-white border border-white/80 hover:border-teal-200/80 backdrop-blur-sm transition-all duration-300 group shadow-xs hover:shadow-md hover:-translate-y-0.5">
                <div class="w-9 h-9 mx-auto mb-1.5 rounded-xl bg-teal-500/10 text-teal-600 flex items-center justify-center group-hover:scale-110 transition-transform shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 block">Menu</span>
            </a>
            <a href="{{ route('admin.banners.index') }}" class="p-3 text-center rounded-xl bg-white/70 hover:bg-white border border-white/80 hover:border-violet-200/80 backdrop-blur-sm transition-all duration-300 group shadow-xs hover:shadow-md hover:-translate-y-0.5">
                <div class="w-9 h-9 mx-auto mb-1.5 rounded-xl bg-violet-500/10 text-violet-600 flex items-center justify-center group-hover:scale-110 transition-transform shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 block">Banner</span>
            </a>
            <a href="{{ route('admin.seo.index') }}" class="p-3 text-center rounded-xl bg-white/70 hover:bg-white border border-white/80 hover:border-amber-200/80 backdrop-blur-sm transition-all duration-300 group shadow-xs hover:shadow-md hover:-translate-y-0.5">
                <div class="w-9 h-9 mx-auto mb-1.5 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 block">SEO</span>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="p-3 text-center rounded-xl bg-white/70 hover:bg-white border border-white/80 hover:border-rose-200/80 backdrop-blur-sm transition-all duration-300 group shadow-xs hover:shadow-md hover:-translate-y-0.5">
                <div class="w-9 h-9 mx-auto mb-1.5 rounded-xl bg-rose-500/10 text-rose-600 flex items-center justify-center group-hover:scale-110 transition-transform shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 block">Settings</span>
            </a>
        </div>
    </div>

    <!-- 4. Tabel Data Glassmorphism & Header Ikon Navbar -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Tabel Halaman Website Terbaru -->
        <div class="bg-white/60 backdrop-blur-xl border border-white/50 shadow-sm rounded-3xl p-6 transition-all duration-300">
            <!-- Header Judul Tabel dengan Ikon Bergaya Navbar -->
            <div class="flex items-center justify-between gap-4 mb-6">
                <div class="flex items-center gap-4 min-w-0">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 border border-blue-100 shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-base sm:text-lg font-bold text-slate-800 truncate" style="font-family:'Plus Jakarta Sans',sans-serif;">Halaman Website Terbaru</h3>
                        <p class="text-xs sm:text-sm text-slate-500 truncate">Daftar halaman yang baru dibuat atau diperbarui</p>
                    </div>
                </div>
                <a href="{{ route('admin.pages.index') }}" class="text-xs text-blue-600 hover:text-blue-800 font-semibold shrink-0 transition-colors">Lihat Semua &rarr;</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200/60 text-slate-500 text-xs uppercase tracking-wider">
                            <th class="pb-3 font-semibold">Judul Halaman</th>
                            <th class="pb-3 font-semibold text-right">Status &amp; Tautan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPages as $page)
                            <tr class="border-b border-slate-100/50 hover:bg-white/40 transition-colors">
                                <td class="py-3.5 pr-3 min-w-[180px]">
                                    <a href="{{ route('admin.pages.edit', $page) }}" class="text-xs font-semibold text-slate-800 hover:text-blue-600 truncate block transition-colors">
                                        {{ $page->title }}
                                    </a>
                                    <p class="text-[11px] text-slate-400 font-mono mt-0.5">/{{ $page->slug }}</p>
                                </td>
                                <td class="py-3.5 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-2">
                                        @if($page->status === 'published')
                                            <span class="px-2.5 py-0.5 text-[10px] font-semibold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/50">Published</span>
                                        @else
                                            <span class="px-2.5 py-0.5 text-[10px] font-semibold rounded-full bg-amber-50 text-amber-700 border border-amber-200/50">Draft</span>
                                        @endif
                                        <a href="{{ url($page->slug) }}" target="_blank" class="p-1.5 text-slate-400 hover:text-blue-600 rounded-lg hover:bg-blue-50/60 transition-colors" title="Buka Halaman">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-8 text-center text-xs text-slate-400">
                                    Belum ada data halaman website.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel Berita & Publikasi Terbaru -->
        <div class="bg-white/60 backdrop-blur-xl border border-white/50 shadow-sm rounded-3xl p-6 transition-all duration-300">
            <!-- Header Judul Tabel dengan Ikon Bergaya Navbar -->
            <div class="flex items-center justify-between gap-4 mb-6">
                <div class="flex items-center gap-4 min-w-0">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 border border-blue-100 shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-base sm:text-lg font-bold text-slate-800 truncate" style="font-family:'Plus Jakarta Sans',sans-serif;">Berita & Publikasi Terbaru</h3>
                        <p class="text-xs sm:text-sm text-slate-500 truncate">Artikel dan berita terkini di website</p>
                    </div>
                </div>
                <a href="{{ route('admin.posts.index') }}" class="text-xs text-blue-600 hover:text-blue-800 font-semibold shrink-0 transition-colors">Lihat Semua &rarr;</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200/60 text-slate-500 text-xs uppercase tracking-wider">
                            <th class="pb-3 font-semibold">Judul Berita</th>
                            <th class="pb-3 font-semibold text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPosts as $post)
                            <tr class="border-b border-slate-100/50 hover:bg-white/40 transition-colors">
                                <td class="py-3.5 pr-3 min-w-[180px]">
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="text-xs font-semibold text-slate-800 hover:text-blue-600 truncate block transition-colors">
                                        {{ $post->title }}
                                    </a>
                                    <div class="flex items-center gap-2 text-[11px] text-slate-400 mt-0.5">
                                        <span>{{ $post->category->name ?? 'Tanpa Kategori' }}</span>
                                        <span>&bull;</span>
                                        <span>{{ $post->created_at->format('d M Y') }}</span>
                                    </div>
                                </td>
                                <td class="py-3.5 text-right whitespace-nowrap">
                                    @if($post->status === 'published')
                                        <span class="px-2.5 py-0.5 text-[10px] font-semibold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/50">Published</span>
                                    @else
                                        <span class="px-2.5 py-0.5 text-[10px] font-semibold rounded-full bg-amber-50 text-amber-700 border border-amber-200/50">Draft</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-8 text-center text-xs text-slate-400">
                                    Belum ada berita yang dipublikasikan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection
