@extends('admin.layouts.app')

@section('title', 'CMS Dashboard')
@section('page_title', 'Dashboard CMS')

@section('content')
<div class="space-y-6">

    <!-- Welcome Card -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-900 via-blue-800 to-indigo-900 p-6 sm:p-8 text-white shadow-lg">
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="inline-block px-3 py-1 bg-white/15 backdrop-blur-md rounded-full text-xs font-semibold text-sky-200 mb-2">
                    Portal Manajemen Konten
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat Datang, {{ Auth::user()->name }}!</h1>
                <p class="text-sm text-blue-100/90 mt-1 max-w-xl">
                    Kelola seluruh konten website resmi BPMP Provinsi Sulawesi Tenggara secara dinamis, terpusat, dan cepat.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.pages.create') }}" class="px-4 py-2.5 bg-white text-blue-900 hover:bg-blue-50 text-xs font-bold rounded-xl shadow transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Tambah Halaman</span>
                </a>
                <a href="{{ route('admin.posts.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow transition-all flex items-center gap-2 border border-blue-400/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <span>Tulis Berita</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Pages -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Halaman</p>
                <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['total_pages'] }}</h3>
                <div class="flex items-center gap-2 mt-2 text-[11px] font-medium">
                    <span class="text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">{{ $stats['published_pages'] }} Publish</span>
                    <span class="text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full">{{ $stats['draft_pages'] }} Draft</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </div>

        <!-- Total Posts -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Berita</p>
                <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['total_posts'] }}</h3>
                <div class="flex items-center gap-2 mt-2 text-[11px] font-medium">
                    <span class="text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">{{ $stats['published_posts'] }} Tayang</span>
                    <span class="text-slate-500">Artikel edukasi</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
            </div>
        </div>

        <!-- Media & Categories -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Media & Kategori</p>
                <div class="flex items-baseline gap-3 mt-1">
                    <h3 class="text-2xl font-black text-slate-800">{{ $stats['total_media'] }}</h3>
                    <span class="text-xs text-slate-500">/ {{ $stats['total_categories'] }} Kategori</span>
                </div>
                <p class="text-[11px] text-slate-500 mt-2">File foto & kategori aktif</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        </div>

        <!-- Announcements -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Pengumuman</p>
                <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['total_announcements'] }}</h3>
                <p class="text-[11px] text-slate-500 mt-2">Pengumuman dinas aktif</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
            </div>
        </div>

    </div>

    <!-- Quick Navigation Shortcuts -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
        <h3 class="text-sm font-bold text-slate-800 mb-3">Akses Cepat Pengelolaan</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
            <a href="{{ route('admin.pages.index') }}" class="p-3 text-center rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200/60 hover:border-blue-200 transition-all group">
                <div class="w-8 h-8 mx-auto mb-1.5 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 block">Pages</span>
            </a>
            <a href="{{ route('admin.posts.index') }}" class="p-3 text-center rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200/60 hover:border-blue-200 transition-all group">
                <div class="w-8 h-8 mx-auto mb-1.5 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 block">Berita</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="p-3 text-center rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200/60 hover:border-blue-200 transition-all group">
                <div class="w-8 h-8 mx-auto mb-1.5 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 block">Kategori</span>
            </a>
            <a href="{{ route('admin.media.index') }}" class="p-3 text-center rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200/60 hover:border-blue-200 transition-all group">
                <div class="w-8 h-8 mx-auto mb-1.5 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 block">Media</span>
            </a>
            <a href="{{ route('admin.menus.index') }}" class="p-3 text-center rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200/60 hover:border-blue-200 transition-all group">
                <div class="w-8 h-8 mx-auto mb-1.5 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 block">Menu</span>
            </a>
            <a href="{{ route('admin.banners.index') }}" class="p-3 text-center rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200/60 hover:border-blue-200 transition-all group">
                <div class="w-8 h-8 mx-auto mb-1.5 rounded-lg bg-violet-100 text-violet-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6z"></path></svg>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 block">Banner</span>
            </a>
            <a href="{{ route('admin.seo.index') }}" class="p-3 text-center rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200/60 hover:border-blue-200 transition-all group">
                <div class="w-8 h-8 mx-auto mb-1.5 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 block">SEO</span>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="p-3 text-center rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200/60 hover:border-blue-200 transition-all group">
                <div class="w-8 h-8 mx-auto mb-1.5 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 block">Settings</span>
            </a>
        </div>
    </div>

    <!-- Recent Content Two Columns -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Recent Pages -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Halaman Website Terbaru</h3>
                    <p class="text-[11px] text-slate-500">Daftar halaman yang baru dibuat atau diperbarui</p>
                </div>
                <a href="{{ route('admin.pages.index') }}" class="text-xs text-blue-600 hover:text-blue-800 font-semibold">Lihat Semua &rarr;</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentPages as $page)
                    <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                        <div class="min-w-0 pr-3">
                            <a href="{{ route('admin.pages.edit', $page) }}" class="text-xs font-semibold text-slate-800 hover:text-blue-600 truncate block">
                                {{ $page->title }}
                            </a>
                            <p class="text-[11px] text-slate-400 font-mono mt-0.5">/{{ $page->slug }}</p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            @if($page->status === 'published')
                                <span class="px-2 py-0.5 text-[10px] font-semibold rounded-full bg-emerald-50 text-emerald-700">Published</span>
                            @else
                                <span class="px-2 py-0.5 text-[10px] font-semibold rounded-full bg-amber-50 text-amber-700">Draft</span>
                            @endif
                            <a href="{{ url($page->slug) }}" target="_blank" class="p-1 text-slate-400 hover:text-blue-600" title="Buka Halaman">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-xs text-slate-400">
                        Belum ada data halaman website.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Posts -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Berita & Publikasi Terbaru</h3>
                    <p class="text-[11px] text-slate-500">Artikel dan berita terkini di website</p>
                </div>
                <a href="{{ route('admin.posts.index') }}" class="text-xs text-blue-600 hover:text-blue-800 font-semibold">Lihat Semua &rarr;</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentPosts as $post)
                    <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                        <div class="min-w-0 pr-3">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="text-xs font-semibold text-slate-800 hover:text-blue-600 truncate block">
                                {{ $post->title }}
                            </a>
                            <div class="flex items-center gap-2 text-[11px] text-slate-400 mt-0.5">
                                <span>{{ $post->category->name ?? 'Tanpa Kategori' }}</span>
                                <span>&bull;</span>
                                <span>{{ $post->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            @if($post->status === 'published')
                                <span class="px-2 py-0.5 text-[10px] font-semibold rounded-full bg-emerald-50 text-emerald-700">Published</span>
                            @else
                                <span class="px-2 py-0.5 text-[10px] font-semibold rounded-full bg-amber-50 text-amber-700">Draft</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-xs text-slate-400">
                        Belum ada berita yang dipublikasikan.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
