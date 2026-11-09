@extends('layouts.admin')

@section('title', 'Daftar Halaman Website')
@section('header_title', 'Pages (Halaman Website)')
@section('header_subtitle', 'Kelola konten website resmi BPMP Provinsi Sulawesi Tenggara')

@section('header_action')
    <a href="{{ route('admin.pages.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-md transition-all inline-flex items-center gap-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
        <span>+ Tambah Halaman</span>
    </a>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Search & Filter Card Glassmorphism -->
    <div class="bg-white/60 backdrop-blur-xl border border-white/50 shadow-sm rounded-3xl p-5 mb-6">
        <form method="GET" action="{{ route('admin.pages.index') }}" class="flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[220px] max-w-md">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau slug halaman..."
                       @input.debounce.500ms="$el.form.submit()"
                       class="w-full sm:w-96 bg-white/50 border border-slate-200/60 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/50 backdrop-blur-sm transition-all text-slate-800 placeholder-slate-400">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <select name="status" onchange="this.form.submit()" class="py-2.5 px-3.5 bg-white/50 border border-slate-200/60 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/50 backdrop-blur-sm transition-all cursor-pointer">
                <option value="">Semua Status</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            </select>

            <button type="submit" class="px-4 py-2.5 bg-slate-800 text-white rounded-xl text-xs font-semibold hover:bg-slate-900 transition-colors shadow-sm cursor-pointer">
                Filter
            </button>
            @if(request()->filled('search') || request()->filled('status'))
                <a href="{{ route('admin.pages.index') }}" class="text-xs text-slate-500 hover:text-slate-800 underline transition-colors">Reset</a>
            @endif
        </form>
    </div>

    <!-- Main Table Container -->
    <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xs border border-slate-200/80 overflow-hidden w-full">
        <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-wrap items-center justify-between gap-3 bg-white/40">
            <div>
                <h3 class="font-bold text-slate-800 text-sm">Daftar Seluruh Halaman</h3>
                <p class="text-xs text-slate-500 mt-0.5">Kelola halaman dinamis dan template website BPMP Sultra</p>
            </div>
            <span class="text-xs text-slate-600 font-semibold bg-slate-100 px-3 py-1 rounded-full">
                Total: {{ $pages->total() }} Halaman
            </span>
        </div>

        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse min-w-[760px]">
                <thead>
                    <tr class="bg-slate-50/70 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-4 w-14 text-center">No</th>
                        <th class="py-3.5 px-4 min-w-[280px]">Judul &amp; URL Slug</th>
                        <th class="py-3.5 px-4 w-28 text-center">Status</th>
                        <th class="py-3.5 px-4 w-44 text-center">Tanggal Publikasi</th>
                        <th class="py-3.5 px-4 w-20 text-center">SEO</th>
                        <th class="py-3.5 px-4 w-32 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($pages as $index => $page)
                        <tr class="hover:bg-blue-50/30 transition-colors group">
                            <td class="py-3.5 px-4 text-center text-slate-500 font-medium">
                                {{ $pages->firstItem() + $index }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    @if($page->featured_image)
                                        <img src="{{ Storage::disk('public')->url($page->featured_image) }}" alt="{{ $page->title }}" class="w-10 h-10 rounded-xl object-cover border border-white shadow-xs shrink-0">
                                    @else
                                        <div class="w-10 h-10 rounded-xl bg-blue-50/80 border border-blue-100 flex items-center justify-center text-blue-600 shrink-0 shadow-xs">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <a href="{{ route('admin.pages.edit', $page) }}" class="text-sm font-bold text-slate-800 hover:text-blue-600 truncate block transition-colors" style="font-family:'Plus Jakarta Sans',sans-serif;">
                                            {{ $page->title }}
                                        </a>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="text-xs text-slate-400 font-mono">
                                                <a href="{{ url($page->slug) }}" target="_blank" class="hover:text-blue-600 hover:underline">/{{ $page->slug }}</a>
                                            </span>
                                            @if(($page->attachments_count ?? 0) > 0)
                                                <a href="{{ route('admin.pages.attachments', $page) }}" title="Kelola {{ $page->attachments_count }} dokumen terlampir" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 transition-colors">
                                                    <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                    {{ $page->attachments_count }} Dokumen
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($page->status === 'published')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60 shadow-xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/60 shadow-xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center text-xs text-slate-500">
                                {{ $page->published_at ? $page->published_at->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($page->meta_title || $page->meta_description)
                                    <span class="inline-flex items-center justify-center p-1.5 bg-blue-50/80 text-blue-600 rounded-lg border border-blue-100 shadow-xs" title="SEO Dikonfigurasi">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </span>
                                @else
                                    <span class="text-slate-300 font-bold">&bull;</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5 whitespace-nowrap">
                                    <!-- Builder Button -->
                                    <a href="{{ route('admin.pages.builder', $page) }}"
                                       class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-indigo-600 hover:border-indigo-300 hover:bg-indigo-50/50 shadow-xs transition-all flex items-center justify-center" title="Buka Visual Builder (Canva/Figma Style)">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>
                                    </a>

                                    <!-- TOMBOL: Kelola Dokumen & Lampiran (Multi-Dokumen PDF/Word/Drive) -->
                                    <a href="{{ route('admin.pages.attachments', $page) }}"
                                       class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-emerald-600 hover:border-emerald-300 hover:bg-emerald-50/50 shadow-xs transition-all flex items-center justify-center relative group/btn" title="Kelola Dokumen & Lampiran PDF/Drive">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        @if(($page->attachments_count ?? 0) > 0)
                                            <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-emerald-500 text-white rounded-full text-[9px] font-bold flex items-center justify-center leading-none">
                                                {{ $page->attachments_count > 9 ? '9+' : $page->attachments_count }}
                                            </span>
                                        @endif
                                    </a>

                                    <!-- Preview Button -->
                                    <a href="{{ route('admin.pages.preview', $page) }}" target="_blank"
                                       class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-sky-600 hover:border-sky-300 hover:bg-sky-50/50 shadow-xs transition-all flex items-center justify-center" title="Preview Halaman">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.264 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>

                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.pages.edit', $page) }}"
                                       class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-300 hover:bg-blue-50/50 shadow-xs transition-all flex items-center justify-center" title="Edit Halaman">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    <!-- Delete Button Form -->
                                    <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus halaman \'{{ $page->title }}\'? Tindakan ini tidak dapat dibatalkan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-rose-600 hover:border-rose-300 hover:bg-rose-50/50 shadow-xs transition-all flex items-center justify-center cursor-pointer" title="Hapus Halaman">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p class="text-xs font-medium">Tidak ada data halaman yang ditemukan.</p>
                                <a href="{{ route('admin.pages.create') }}" class="mt-3 inline-block text-xs font-bold text-blue-600 hover:underline">
                                    + Buat halaman baru sekarang
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pages->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $pages->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
