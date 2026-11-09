@extends('layouts.admin')

@section('title', 'Dokumen & Lampiran: ' . $page->title)
@section('header_title', 'Dokumen & Lampiran Halaman')
@section('header_subtitle', 'Kelola lampiran berkas PDF, Word, Excel, atau tautan Google Drive untuk halaman: ' . $page->title)

@section('header_action')
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.pages.index') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold rounded-xl shadow-xs transition-all inline-flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Pages</span>
        </a>
        <a href="{{ url($page->slug) }}" target="_blank" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-md transition-all inline-flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            <span>Lihat Halaman Publik</span>
        </a>
    </div>
@endsection

@section('content')
<div class="space-y-8" x-data="pageAttachmentsManager()">

    <!-- INFO BANNER HALAMAN INDUK & STATISTIK -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Kartu Info Halaman -->
        <div class="bg-white/80 backdrop-blur-xl border border-white/60 shadow-xs rounded-2xl p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div class="min-w-0">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Halaman Terkait</span>
                <h3 class="text-sm font-extrabold text-slate-800 truncate" title="{{ $page->title }}">{{ $page->title }}</h3>
                <span class="text-xs text-blue-600 font-mono">/{{ $page->slug }}</span>
            </div>
        </div>

        <!-- Kartu Total Dokumen -->
        <div class="bg-white/80 backdrop-blur-xl border border-white/60 shadow-xs rounded-2xl p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/></svg>
            </div>
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Lampiran</span>
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl font-black text-slate-800">{{ $totalCount }}</span>
                    <span class="text-xs font-semibold text-slate-500">Berkas</span>
                </div>
            </div>
        </div>

        <!-- Kartu Status Publikasi -->
        <div class="bg-white/80 backdrop-blur-xl border border-white/60 shadow-xs rounded-2xl p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Aktif Publik</span>
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl font-black text-emerald-600">{{ $activeCount }}</span>
                    <span class="text-xs font-semibold text-slate-500">dari {{ $totalCount }} Dokumen</span>
                </div>
            </div>
        </div>
    </div>

    <!-- FORM UPLOAD / TAMBAH DOKUMEN BARU (Glassmorphism Card) -->
    <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-lg border border-white p-6 sm:p-8 relative overflow-hidden">
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-emerald-400/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10">
            <div class="flex items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-100 flex-wrap">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold shadow-xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-800">Tambah Dokumen / Lampiran Baru</h2>
                        <p class="text-xs text-slate-500">Unggah file lokal (PDF, Word, Excel, ZIP) atau sematkan tautan Google Drive untuk halaman ini.</p>
                    </div>
                </div>

                <!-- Source Type Switcher Tabs -->
                <div class="flex items-center gap-1.5 p-1 bg-slate-100/90 rounded-2xl border border-slate-200/80">
                    <button type="button" @click="sourceType = 'file'" :class="sourceType === 'file' ? 'bg-white text-emerald-600 shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'" class="px-3.5 py-1.5 rounded-xl text-xs transition-all flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>File Lokal (PDF/Word/Excel)</span>
                    </button>
                    <button type="button" @click="sourceType = 'drive'" :class="sourceType === 'drive' ? 'bg-white text-emerald-600 shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'" class="px-3.5 py-1.5 rounded-xl text-xs transition-all flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        <span>Link Google Drive / Cloud</span>
                    </button>
                </div>
            </div>

            <form action="{{ route('admin.pages.attachments.store', $page) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <input type="hidden" name="source_type" :value="sourceType">

                <div class="grid grid-cols-1 md:grid-cols-12 gap-5 items-end">
                    <!-- Judul Dokumen -->
                    <div class="md:col-span-5 space-y-1.5">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Judul Dokumen <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Rencana Strategis (RENSTRA) Tahun 2024-2029"
                            class="w-full bg-white/80 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 outline-none shadow-xs text-slate-800 font-medium">
                        @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Kategori Dokumen (Bisa pilih atau ketik) -->
                    <div class="md:col-span-3 space-y-1.5" x-data="{ customCat: false }">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Kategori / Klasifikasi</label>
                            <button type="button" @click="customCat = !customCat" class="text-[10px] text-emerald-600 hover:underline font-semibold">
                                <span x-show="!customCat">+ Ketik Kategori Baru</span>
                                <span x-show="customCat">Pilih dari Daftar</span>
                            </button>
                        </div>
                        
                        <div x-show="!customCat">
                            <select name="category" class="w-full bg-white/80 border border-slate-200 rounded-xl px-3 py-2.5 text-xs font-medium focus:ring-2 focus:ring-emerald-500 outline-none shadow-xs text-slate-700">
                                <option value="">-- Tanpa Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                                <option value="Regulasi & SK">Regulasi &amp; SK</option>
                                <option value="Laporan Kinerja">Laporan Kinerja</option>
                                <option value="Rencana Kerja">Rencana Kerja</option>
                                <option value="Pedoman & Juknis">Pedoman &amp; Juknis</option>
                                <option value="Buku & Publikasi">Buku &amp; Publikasi</option>
                            </select>
                        </div>

                        <div x-show="customCat" style="display: none;">
                            <input type="text" name="category" placeholder="Ketik nama kategori baru..."
                                class="w-full bg-white/80 border border-slate-200 rounded-xl px-3 py-2.5 text-xs font-medium focus:ring-2 focus:ring-emerald-500 outline-none shadow-xs text-slate-700">
                        </div>
                        @error('category') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Input Dinamis: File Lokal VS Google Drive -->
                    <div class="md:col-span-4 space-y-1.5" x-show="sourceType === 'file'">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Pilih Berkas <span class="text-red-500">*</span></label>
                        <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar,.csv,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            :required="sourceType === 'file'"
                            class="w-full bg-white/80 border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-500 outline-none shadow-xs text-slate-600 file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                        <span class="text-[10px] text-slate-400 block">Maksimal 25 MB (PDF, Word, Excel, PowerPoint, ZIP)</span>
                        @error('file') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-4 space-y-1.5" x-show="sourceType === 'drive'" style="display: none;">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">URL Tautan Google Drive <span class="text-red-500">*</span></label>
                        <input type="url" name="drive_url" value="{{ old('drive_url') }}" placeholder="https://drive.google.com/file/d/..."
                            :required="sourceType === 'drive'"
                            class="w-full bg-white/80 border border-slate-200 rounded-xl px-4 py-2.5 text-xs focus:ring-2 focus:ring-emerald-500 outline-none shadow-xs text-slate-800 font-mono">
                        <span class="text-[10px] text-slate-400 block">Pastikan share link publik disetel ke "Siapa saja yang memiliki link"</span>
                        @error('drive_url') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between pt-3 border-t border-slate-100 flex-wrap gap-3">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        <span class="text-xs font-semibold text-slate-600">Publikasikan langsung (Dokumen tampil di website publik)</span>
                    </label>

                    <button type="submit" class="py-2.5 px-6 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-md shadow-emerald-600/20 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        <span>Simpan &amp; Lampirkan Dokumen</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- FILTER & DAFTAR DOKUMEN TERLAMPIR -->
    <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-lg border border-white p-6 sm:p-8 space-y-6">
        
        <!-- Header Tabel & Filter Bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-slate-100">
            <div>
                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <span>Daftar Dokumen Terlampir Pada Halaman Ini</span>
                    <span class="text-xs bg-emerald-50 text-emerald-700 px-2.5 py-0.5 rounded-full font-bold border border-emerald-200">
                        {{ count($attachments) }} Berkas
                    </span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Gunakan ikon drag di sebelah kiri nomor untuk mengatur urutan tampilan di halaman website.</p>
            </div>

            <!-- Toolbar Filter & Search -->
            <form method="GET" action="{{ route('admin.pages.attachments', $page) }}" class="flex flex-wrap items-center gap-2.5">
                <!-- Search Input -->
                <div class="relative min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul lampiran..."
                        class="w-full bg-white border border-slate-200 rounded-xl pl-9 pr-3 py-2 text-xs focus:ring-2 focus:ring-emerald-500 outline-none text-slate-700">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>

                <!-- Category Filter -->
                <select name="category" onchange="this.form.submit()" class="bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium text-slate-700 focus:ring-2 focus:ring-emerald-500 outline-none cursor-pointer">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>

                <!-- Status Filter -->
                <select name="status" onchange="this.form.submit()" class="bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium text-slate-700 focus:ring-2 focus:ring-emerald-500 outline-none cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif Publik</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif / Draft</option>
                </select>

                <button type="submit" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-semibold transition-colors shadow-xs">
                    Filter
                </button>

                @if(request()->filled('search') || request()->filled('category') || request()->filled('status'))
                    <a href="{{ route('admin.pages.attachments', $page) }}" class="text-xs text-slate-500 hover:text-slate-800 underline transition-colors">Reset</a>
                @endif
            </form>
        </div>

        <!-- Tabel Dokumen dengan SortableJS -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[850px]">
                <thead>
                    <tr class="bg-slate-50/70 text-slate-500 uppercase tracking-wider text-[11px] font-bold border-b border-slate-100">
                        <th class="py-3.5 px-4 w-16 text-center">Urutan</th>
                        <th class="py-3.5 px-4 min-w-[280px]">Judul Dokumen &amp; Format</th>
                        <th class="py-3.5 px-4 w-40">Kategori</th>
                        <th class="py-3.5 px-4 w-32 text-center">Tipe / Ukuran</th>
                        <th class="py-3.5 px-4 w-28 text-center">Status</th>
                        <th class="py-3.5 px-4 w-20 text-center" title="Total Unduhan / Akses">Unduhan</th>
                        <th class="py-3.5 px-4 w-44 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="sortable-attachment-list" class="divide-y divide-slate-100 text-xs">
                    @forelse($attachments as $index => $item)
                        <tr class="attachment-row hover:bg-emerald-50/20 transition-colors group cursor-default" data-id="{{ $item->id }}" data-status="{{ $item->is_active ? 'active' : 'inactive' }}">
                            <!-- Urutan & Drag Handle -->
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <div class="drag-handle cursor-grab active:cursor-grabbing text-slate-300 hover:text-slate-600 transition-colors p-1 rounded hover:bg-slate-100" title="Geser untuk mengubah urutan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 9h.01M8 15h.01M16 9h.01M16 15h.01M12 9h.01M12 15h.01"/></svg>
                                    </div>
                                    <span class="row-index font-bold text-slate-500 w-5 text-right">{{ $index + 1 }}</span>
                                </div>
                            </td>

                            <!-- Judul & Badge Format -->
                            <td class="py-3.5 px-4">
                                <div class="flex items-start gap-3">
                                    <!-- Ikon Format Dokumen -->
                                    <div class="shrink-0 mt-0.5">
                                        @if($item->isDriveLink())
                                            <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 border border-amber-200/80 flex items-center justify-center shadow-xs" title="Google Drive Link">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                            </div>
                                        @elseif($item->isWord())
                                            <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 border border-blue-200/80 flex items-center justify-center shadow-xs" title="Microsoft Word">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zM6 20V4h7v5h5v11H6z"/></svg>
                                            </div>
                                        @elseif($item->isExcel())
                                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-200/80 flex items-center justify-center shadow-xs" title="Microsoft Excel">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </div>
                                        @else
                                            <div class="w-9 h-9 rounded-xl bg-red-50 text-red-600 border border-red-200/80 flex items-center justify-center shadow-xs" title="PDF Document">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <div class="font-bold text-slate-800 text-sm hover:text-emerald-600 transition-colors leading-snug">
                                            {{ $item->title }}
                                        </div>
                                        <div class="flex items-center gap-2 mt-1 text-[11px] text-slate-400">
                                            <span class="font-mono truncate max-w-[220px]" title="{{ $item->file_name ?? $item->file_path }}">
                                                {{ $item->file_name ?: basename($item->file_path) }}
                                            </span>
                                            @if($item->uploaded_at)
                                                <span>&bull;</span>
                                                <span>{{ $item->uploaded_at->format('d M Y') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Kategori -->
                            <td class="py-3.5 px-4">
                                @if($item->category)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200/60">
                                        {{ $item->category }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">Umum</span>
                                @endif
                            </td>

                            <!-- Tipe & Ukuran -->
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-black border uppercase {{ $item->badge_color_class }}">
                                    {{ $item->badge_label }}
                                </span>
                                <span class="block text-[11px] text-slate-400 mt-0.5 font-medium">
                                    {{ $item->formatted_size }}
                                </span>
                            </td>

                            <!-- Status Toggle Button -->
                            <td class="py-3.5 px-4 text-center">
                                <button type="button" @click="toggleStatus({{ $item->id }}, $event.currentTarget)"
                                    class="px-3 py-1.5 rounded-xl font-bold text-xs transition-all inline-flex items-center gap-1.5 border {{ $item->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 border-slate-200 hover:bg-slate-200' }}"
                                    title="Klik untuk mengubah status publikasi">
                                    <span class="w-2 h-2 rounded-full {{ $item->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    <span class="status-text">{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                </button>
                            </td>

                            <!-- Download Count -->
                            <td class="py-3.5 px-4 text-center font-bold text-slate-600">
                                {{ number_format($item->download_count) }}
                            </td>

                            <!-- Aksi -->
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Tombol Jump ke Section Halaman Publik -->
                                    <a href="{{ url($page->slug) }}#document-{{ $item->id }}" target="_blank"
                                        class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-emerald-600 hover:border-emerald-300 hover:bg-emerald-50/50 shadow-xs transition-all flex items-center justify-center"
                                        title="Lihat dokumen di Halaman Publik (#document-{{ $item->id }})">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>

                                    <!-- Tombol Download / Akses File Langsung -->
                                    <a href="{{ route('pages.attachments.download', $item) }}" target="_blank"
                                        class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-300 hover:bg-blue-50/50 shadow-xs transition-all flex items-center justify-center"
                                        title="Unduh / Buka Dokumen">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    </a>

                                    <!-- Tombol Edit Dokumen (Modal) -->
                                    <button type="button" @click="openEditModal({{ json_encode($item) }})"
                                        class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-amber-600 hover:border-amber-300 hover:bg-amber-50/50 shadow-xs transition-all flex items-center justify-center cursor-pointer"
                                        title="Edit Dokumen">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>

                                    <!-- Tombol Hapus Dokumen -->
                                    <form method="POST" action="{{ route('admin.pages.attachments.destroy', [$page, $item]) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen \'{{ $item->title }}\' dari halaman ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-rose-600 hover:border-rose-300 hover:bg-rose-50/50 shadow-xs transition-all flex items-center justify-center cursor-pointer" title="Hapus Dokumen">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="text-xs font-semibold text-slate-600">Belum ada dokumen yang dilampirkan pada halaman "{{ $page->title }}".</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Gunakan formulir di atas untuk mengunggah PDF, Word, Excel, atau menyematkan Link Google Drive.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL EDIT DOKUMEN (Alpine.js) -->
    <div x-show="showEditModal" x-cloak
        class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <div class="bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-xl w-full p-6 sm:p-8 relative overflow-hidden"
            @click.away="showEditModal = false">
            
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Edit Dokumen Lampiran</h3>
                    <p class="text-xs text-slate-500">Perbarui judul, kategori, atau ganti file/link untuk halaman ini.</p>
                </div>
                <button type="button" @click="showEditModal = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form :action="editActionUrl" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" name="source_type" :value="editItem.source_type">

                <!-- Source Switcher in Modal -->
                <div class="flex items-center gap-1.5 p-1 bg-slate-100/90 rounded-2xl border border-slate-200/80 mb-4">
                    <button type="button" @click="editItem.source_type = 'file'" :class="editItem.source_type === 'file' ? 'bg-white text-emerald-600 shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'" class="flex-1 py-1.5 rounded-xl text-xs transition-all text-center">
                        Berkas Lokal (PDF/Word/Excel)
                    </button>
                    <button type="button" @click="editItem.source_type = 'drive'" :class="editItem.source_type === 'drive' ? 'bg-white text-emerald-600 shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'" class="flex-1 py-1.5 rounded-xl text-xs transition-all text-center">
                        Link Google Drive
                    </button>
                </div>

                <!-- Judul Dokumen -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Judul Dokumen <span class="text-red-500">*</span></label>
                    <input type="text" name="title" x-model="editItem.title" required
                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 font-medium">
                </div>

                <!-- Kategori Dokumen -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Kategori / Klasifikasi</label>
                    <input type="text" name="category" x-model="editItem.category" placeholder="Contoh: Regulasi, Laporan Kinerja, dll"
                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs focus:ring-2 focus:ring-emerald-500 outline-none text-slate-700 font-medium">
                </div>

                <!-- Ganti File / Link -->
                <div class="space-y-1.5" x-show="editItem.source_type === 'file'">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Ganti Berkas Dokumen (Opsional)</label>
                    <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar,.csv"
                        class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-500 outline-none text-slate-600 file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                    <span class="text-[10px] text-slate-400 block" x-show="editItem.file_name">File saat ini: <span class="font-mono text-slate-600" x-text="editItem.file_name"></span></span>
                </div>

                <div class="space-y-1.5" x-show="editItem.source_type === 'drive'" style="display: none;">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">URL Tautan Google Drive <span class="text-red-500">*</span></label>
                    <input type="url" name="drive_url" x-model="editItem.file_path" placeholder="https://drive.google.com/file/d/..."
                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 font-mono">
                </div>

                <!-- Status Aktif Checkbox -->
                <div class="pt-2">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" x-model="editItem.is_active" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        <span class="text-xs font-semibold text-slate-700">Publikasikan dokumen ini (Status Aktif)</span>
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="showEditModal = false" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 rounded-xl hover:bg-slate-100 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-md shadow-emerald-600/20 transition-all flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- SortableJS Script -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

<script>
function pageAttachmentsManager() {
    return {
        sourceType: 'file',
        showEditModal: false,
        editItem: {
            id: null,
            title: '',
            category: '',
            source_type: 'file',
            file_path: '',
            file_name: '',
            is_active: true
        },
        editActionUrl: '',

        init() {
            this.initSortable();
        },

        openEditModal(item) {
            this.editItem = {
                id: item.id,
                title: item.title,
                category: item.category || '',
                source_type: (item.source_type === 'drive' || item.source_type === 'drive_link') ? 'drive' : 'file',
                file_path: item.file_path || '',
                file_name: item.file_name || '',
                is_active: Boolean(item.is_active)
            };
            this.editActionUrl = `{{ url('admin/pages/' . $page->id . '/attachments') }}/${item.id}`;
            this.showEditModal = true;
        },

        async toggleStatus(id, btn) {
            btn.disabled = true;

            try {
                const response = await fetch(`{{ url('admin/pages/' . $page->id . '/attachments') }}/${id}/toggle-status`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                if (data.status === 'success') {
                    const row = btn.closest('.attachment-row');
                    const dot = btn.querySelector('.rounded-full');
                    const text = btn.querySelector('.status-text');

                    if (data.is_active) {
                        btn.className = 'px-3 py-1.5 rounded-xl font-bold text-xs transition-all inline-flex items-center gap-1.5 border bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100';
                        dot.className = 'w-2 h-2 rounded-full bg-emerald-500';
                        text.textContent = 'Aktif';
                        if (row) row.dataset.status = 'active';
                    } else {
                        btn.className = 'px-3 py-1.5 rounded-xl font-bold text-xs transition-all inline-flex items-center gap-1.5 border bg-slate-100 text-slate-500 border-slate-200 hover:bg-slate-200';
                        dot.className = 'w-2 h-2 rounded-full bg-slate-400';
                        text.textContent = 'Nonaktif';
                        if (row) row.dataset.status = 'inactive';
                    }

                    if (window.Swal) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                }
            } catch (err) {
                console.error(err);
                alert('Gagal memperbarui status publikasi dokumen.');
            } finally {
                btn.disabled = false;
            }
        },

        initSortable() {
            const listEl = document.getElementById('sortable-attachment-list');
            if (!listEl || !window.Sortable) return;

            new Sortable(listEl, {
                animation: 200,
                handle: '.drag-handle',
                ghostClass: 'opacity-40',
                chosenClass: 'bg-emerald-50/70',
                onEnd: async (evt) => {
                    const rows = Array.from(listEl.querySelectorAll('.attachment-row'));
                    const orderedIds = rows.map(r => Number(r.dataset.id));

                    // Live update row index numbers
                    rows.forEach((r, idx) => {
                        const indexBadge = r.querySelector('.row-index');
                        if (indexBadge) indexBadge.textContent = idx + 1;
                    });

                    try {
                        const response = await fetch('{{ route('admin.pages.attachments.reorder', $page) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ order: orderedIds })
                        });

                        const resData = await response.json();
                        if (resData.status === 'success' && window.Swal) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Urutan dokumen berhasil disimpan!',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                    } catch (err) {
                        console.error('Reorder error:', err);
                    }
                }
            });
        }
    };
}
</script>
@endsection

