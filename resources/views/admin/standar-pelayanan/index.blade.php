@extends('layouts.admin')

@section('title', 'Standar Pelayanan')
@section('header_title', 'Standar Pelayanan')
@section('header_subtitle', 'Kelola dokumen Standar Pelayanan publik (PDF, Word, & Google Drive) secara dinamis')

@section('content')
<div class="space-y-8" x-data="standarPelayananManager()">

    <!-- FORM UPLOAD DOKUMEN BARU (Glassmorphic Card) -->
    <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-lg border border-white p-6 sm:p-8 relative overflow-hidden">
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-indigo-400/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10">
            <div class="flex items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-100 flex-wrap">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold shadow-xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-800">Unggah Dokumen Standar Pelayanan Baru</h2>
                        <p class="text-xs text-slate-500">Mendukung upload file lokal (PDF, Word, Excel) atau tautan Google Drive resmi.</p>
                    </div>
                </div>

                <!-- Source Type Selector Tabs -->
                <div class="flex items-center gap-1.5 p-1 bg-slate-100/90 rounded-2xl border border-slate-200/80">
                    <button type="button" @click="sourceType = 'file'" :class="sourceType === 'file' ? 'bg-white text-indigo-600 shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'" class="px-3.5 py-1.5 rounded-xl text-xs transition-all flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>File Lokal (PDF/Word)</span>
                    </button>
                    <button type="button" @click="sourceType = 'drive_link'" :class="sourceType === 'drive_link' ? 'bg-white text-indigo-600 shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'" class="px-3.5 py-1.5 rounded-xl text-xs transition-all flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        <span>Link Google Drive</span>
                    </button>
                </div>
            </div>

            <form action="{{ route('admin.standar-pelayanan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="hidden" name="source_type" :value="sourceType">

                <div class="grid grid-cols-1 md:grid-cols-12 gap-5 items-end">
                    <!-- Judul Dokumen -->
                    <div class="md:col-span-5 space-y-1.5">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Judul Dokumen <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Standar Pelayanan Permohonan Informasi Publik"
                            class="w-full bg-white/80 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 outline-none shadow-sm text-slate-800 font-medium">
                        @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Kategori Dokumen -->
                    <div class="md:col-span-3 space-y-1.5">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Kategori / Klasifikasi</label>
                        <select name="category" class="w-full bg-white/80 border border-slate-200 rounded-xl px-3 py-2.5 text-xs font-medium focus:ring-2 focus:ring-indigo-500 outline-none shadow-sm text-slate-700">
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Input Dinamis: File Lokal VS Google Drive -->
                    <div class="md:col-span-4 space-y-1.5" x-show="sourceType === 'file'">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">File Dokumen <span class="text-red-500">*</span></label>
                        <input type="file" name="file_dokumen" accept=".pdf,.doc,.docx,.xls,.xlsx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            :required="sourceType === 'file'"
                            class="w-full bg-white/80 border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-indigo-500 outline-none shadow-sm text-slate-600 file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        <span class="text-[10px] text-slate-400 block">Format: PDF, Word (.doc/.docx), Excel. Maks: 30 MB</span>
                        @error('file_dokumen') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-4 space-y-1.5" x-show="sourceType === 'drive_link'" style="display: none;">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">URL Google Drive / Cloud <span class="text-red-500">*</span></label>
                        <input type="url" name="drive_url" value="{{ old('drive_url') }}" placeholder="https://drive.google.com/file/d/..."
                            :required="sourceType === 'drive_link'"
                            class="w-full bg-white/80 border border-slate-200 rounded-xl px-4 py-2.5 text-xs focus:ring-2 focus:ring-indigo-500 outline-none shadow-sm text-slate-800 font-mono">
                        <span class="text-[10px] text-slate-400 block">Pastikan akses share link disetel ke "Siapa saja yang memiliki link"</span>
                        @error('drive_url') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-xs font-semibold text-slate-600">Langsung publikasikan dokumen (Status Aktif)</span>
                    </label>

                    <button type="submit" class="py-2.5 px-6 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md shadow-indigo-600/20 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        <span>Simpan Dokumen</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- FILTER & DAFTAR DOKUMEN STANDAR PELAYANAN -->
    <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-lg border border-white p-6 sm:p-8 space-y-6">
        
        <!-- Header & Action Bar -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 pb-4 border-b border-slate-100">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Daftar Dokumen Standar Pelayanan</h3>
                <p class="text-xs text-slate-500">Geser ikon titik-titik untuk mengubah urutan nomor tampil secara *real-time*.</p>
            </div>

            <!-- Global Actions & Badges -->
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ url('/standar-pelayanan') }}" target="_blank" class="px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors flex items-center gap-1.5 border border-slate-200/80">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>Buka Halaman Publik</span>
                </a>
                <span class="px-3.5 py-1.5 rounded-full bg-indigo-50 text-indigo-700 font-bold text-xs border border-indigo-100 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    Total: {{ $dokumens->count() }} Dokumen
                </span>
            </div>
        </div>

        <!-- SEARCH BAR & FILTER TABS -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3.5 items-center">
            <!-- Search Bar -->
            <div class="md:col-span-5 relative">
                <input type="text" x-model="searchQuery" placeholder="Cari judul dokumen..."
                    class="w-full bg-white border border-slate-200 rounded-xl pl-9 pr-4 py-2 text-xs focus:ring-2 focus:ring-indigo-500 outline-none shadow-xs text-slate-800 font-medium">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <button type="button" x-show="searchQuery" @click="searchQuery = ''" class="absolute right-2.5 top-2 text-slate-400 hover:text-slate-600 text-xs">✕</button>
            </div>

            <!-- Filter Kategori -->
            <div class="md:col-span-4">
                <select x-model="selectedCategory" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold focus:ring-2 focus:ring-indigo-500 outline-none shadow-xs text-slate-700">
                    <option value="all">Semua Kategori ({{ $dokumens->count() }})</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Status -->
            <div class="md:col-span-3">
                <select x-model="selectedStatus" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold focus:ring-2 focus:ring-indigo-500 outline-none shadow-xs text-slate-700">
                    <option value="all">Semua Status</option>
                    <option value="active">Aktif Saja</option>
                    <option value="inactive">Nonaktif Saja</option>
                </select>
            </div>
        </div>

        @if($dokumens->isEmpty())
            <div class="py-16 text-center text-slate-400 bg-slate-50/50 rounded-2xl border border-slate-200/60">
                <svg class="w-16 h-16 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <p class="font-medium">Belum ada dokumen standar pelayanan yang diunggah.</p>
                <p class="text-xs text-slate-400 mt-1">Gunakan formulir di atas untuk mengunggah dokumen baru.</p>
            </div>
        @else
            <!-- DAFTAR DOKUMEN REORDERABLE (SortableJS) -->
            <div class="space-y-3" id="sortable-document-list">
                @foreach($dokumens as $index => $item)
                    <div class="document-row bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 hover:border-indigo-200 hover:shadow-md transition-all group"
                         data-id="{{ $item->id }}"
                         data-title="{{ strtolower($item->title) }}"
                         data-category="{{ $item->category }}"
                         data-status="{{ $item->is_active ? 'active' : 'inactive' }}"
                         x-show="isItemVisible('{{ strtolower($item->title) }}', '{{ $item->category }}', '{{ $item->is_active ? 'active' : 'inactive' }}')">
                        
                        <div class="flex items-center gap-3.5 flex-1 min-w-0">
                            <!-- Drag Handle -->
                            <span class="drag-handle cursor-grab active:cursor-grabbing p-1.5 text-slate-300 group-hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors shrink-0" title="Klik dan geser untuk memindahkan urutan">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                    <circle cx="8" cy="6" r="1.5"/><circle cx="16" cy="6" r="1.5"/>
                                    <circle cx="8" cy="12" r="1.5"/><circle cx="16" cy="12" r="1.5"/>
                                    <circle cx="8" cy="18" r="1.5"/><circle cx="16" cy="18" r="1.5"/>
                                </svg>
                            </span>

                            <!-- Nomor Urut -->
                            <span class="row-index w-7 h-7 rounded-lg bg-slate-100 text-slate-600 font-extrabold text-xs flex items-center justify-center shrink-0">
                                {{ $index + 1 }}
                            </span>

                            <!-- Ikon Dokumen Otomatis -->
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center font-black text-xs shrink-0 border {{ $item->badge_color_class }}">
                                @if($item->isDriveLink())
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM19 18H6c-2.21 0-4-1.79-4-4 0-2.05 1.53-3.76 3.56-3.97l1.07-.11.5-.95C8.08 7.14 9.94 6 12 6c2.62 0 4.88 1.86 5.39 4.43l.3 1.5 1.53.11c1.56.1 2.78 1.41 2.78 2.96 0 1.65-1.35 3-3 3z"/>
                                    </svg>
                                @elseif($item->isWord())
                                    <span>DOC</span>
                                @elseif($item->isExcel())
                                    <span>XLS</span>
                                @else
                                    <span>PDF</span>
                                @endif
                            </div>

                            <!-- Detail Dokumen -->
                            <div class="min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h4 class="font-bold text-slate-800 text-sm md:text-base leading-snug truncate">{{ $item->title }}</h4>
                                    <!-- Badge Kategori -->
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-semibold uppercase tracking-wider border border-slate-200/60">
                                        {{ $item->category ?: 'Umum' }}
                                    </span>
                                </div>
                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-500 mt-1">
                                    <span class="flex items-center gap-1 font-medium">
                                        📅 {{ \Carbon\Carbon::parse($item->uploaded_at)->translatedFormat('d F Y') }}
                                    </span>
                                    <span>•</span>
                                    <span class="px-2 py-0.5 rounded-md {{ $item->isDriveLink() ? 'bg-amber-50 text-amber-700 border border-amber-200/60' : 'bg-slate-100 text-slate-700' }} font-mono text-[11px] font-semibold flex items-center gap-1">
                                        @if($item->isDriveLink())
                                            <span>🔗 Google Drive</span>
                                        @else
                                            <span>📁 {{ $item->file_size }}</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Toolbar -->
                        <div class="flex items-center gap-2 self-end md:self-center flex-wrap shrink-0">
                            <!-- Toggle Status Publikasi -->
                            <button type="button" @click="toggleStatus({{ $item->id }}, $event)"
                                class="px-3 py-1.5 rounded-xl font-bold text-xs transition-all flex items-center gap-1.5 border {{ $item->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 border-slate-200 hover:bg-slate-200' }}"
                                title="Klik untuk mengaktifkan / menonaktifkan tampil di publik">
                                <span class="w-2 h-2 rounded-full {{ $item->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                <span class="status-text">{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                            </button>

                            <!-- Direct Jump: Tombol "Lihat Section" -->
                            <a href="{{ url('/standar-pelayanan') }}#document-{{ $item->id }}" target="_blank"
                                class="px-3 py-1.5 rounded-xl bg-sky-50 text-sky-700 hover:bg-sky-600 hover:text-white font-bold text-xs transition-all flex items-center gap-1.5 border border-sky-200/80 hover:border-transparent shadow-2xs"
                                title="Buka dan lompat langsung ke posisi kartu dokumen di halaman publik">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                <span>Lihat Section</span>
                            </a>

                            <!-- Tombol Edit Data -->
                            <button type="button" @click="openEditModal({{ json_encode($item) }})"
                                class="px-3 py-1.5 rounded-xl bg-amber-50 text-amber-700 hover:bg-amber-600 hover:text-white font-bold text-xs transition-all flex items-center gap-1.5 border border-amber-200/80 hover:border-transparent shadow-2xs"
                                title="Sunting judul, kategori, atau file dokumen">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                <span>Edit</span>
                            </button>

                            <!-- Preview / Open File -->
                            @if($item->isPdf())
                                <button type="button" @click="openModal('{{ $item->title }}', '{{ $item->file_path }}', 'Diperbarui: {{ \Carbon\Carbon::parse($item->uploaded_at)->translatedFormat('d M Y') }} • {{ $item->file_size }}')"
                                    class="px-3 py-1.5 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white font-bold text-xs transition-all flex items-center gap-1.5 border border-indigo-200/80 hover:border-transparent"
                                    title="Pratinjau PDF">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <span>Preview</span>
                                </button>
                            @else
                                <a href="{{ $item->file_path }}" target="_blank"
                                    class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 font-bold text-xs transition-all flex items-center gap-1.5 border border-slate-200/80"
                                    title="Buka Dokumen di Tab Baru">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    <span>Buka</span>
                                </a>
                            @endif

                            <!-- Delete Form -->
                            <form action="{{ route('admin.standar-pelayanan.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini? File fisik di server juga akan dihapus.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all" title="Hapus Dokumen">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- MODAL EDIT DOKUMEN -->
    <template x-teleport="body">
        <div x-show="showEditModal" class="fixed inset-0 z-[998] flex items-center justify-center p-4 sm:p-6" style="display: none;" @keydown.escape.window="showEditModal = false">
            <div x-show="showEditModal" x-transition.opacity class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showEditModal = false"></div>

            <div x-show="showEditModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden border border-slate-200 z-10">
                
                <div class="px-6 py-5 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white flex justify-between items-center border-b border-indigo-900/40">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-base text-white">Edit Dokumen Standar Pelayanan</h3>
                            <p class="text-xs text-indigo-200/80">Perbarui judul, kategori, atau ganti file/link Google Drive.</p>
                        </div>
                    </div>
                    <button type="button" @click="showEditModal = false" class="p-1.5 text-slate-400 hover:text-white rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form :action="'{{ url('admin/standar-pelayanan') }}/' + editData.id" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="source_type" :value="editData.source_type">

                    <!-- Judul -->
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Judul Dokumen <span class="text-red-500">*</span></label>
                        <input type="text" name="title" x-model="editData.title" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 outline-none font-medium text-slate-800">
                    </div>

                    <!-- Kategori & Tipe Sumber -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kategori / Klasifikasi</label>
                            <select name="category" x-model="editData.category" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs font-semibold focus:ring-2 focus:ring-indigo-500 outline-none text-slate-700">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Tipe Sumber</label>
                            <div class="flex items-center gap-2 pt-1">
                                <label class="inline-flex items-center gap-1.5 text-xs font-semibold cursor-pointer">
                                    <input type="radio" x-model="editData.source_type" value="file" class="text-indigo-600 focus:ring-indigo-500">
                                    <span>File Lokal</span>
                                </label>
                                <label class="inline-flex items-center gap-1.5 text-xs font-semibold cursor-pointer ml-3">
                                    <input type="radio" x-model="editData.source_type" value="drive_link" class="text-indigo-600 focus:ring-indigo-500">
                                    <span>Google Drive</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- File / URL Edit Container -->
                    <div x-show="editData.source_type === 'file'" class="p-4 bg-slate-50 rounded-2xl border border-slate-200 space-y-2">
                        <div class="flex items-center justify-between text-xs text-slate-600">
                            <span class="font-bold">File Saat Ini:</span>
                            <a :href="editData.file_path" target="_blank" class="text-indigo-600 font-bold hover:underline flex items-center gap-1">
                                <span>Lihat File</span> &rarr;
                            </a>
                        </div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mt-2">Unggah File Pengganti (Opsional):</label>
                        <input type="file" name="file_dokumen" accept=".pdf,.doc,.docx,.xls,.xlsx"
                            class="w-full bg-white border border-slate-200 rounded-xl px-3 py-1.5 text-xs file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        <span class="text-[10px] text-slate-400 block">Kosongkan jika tidak ingin mengganti file lama.</span>
                    </div>

                    <div x-show="editData.source_type === 'drive_link'" style="display: none;" class="p-4 bg-amber-50/60 rounded-2xl border border-amber-200/80 space-y-2">
                        <label class="block text-xs font-bold text-amber-800 uppercase tracking-wider">Tautan Google Drive / Cloud Eksternal:</label>
                        <input type="url" name="drive_url" x-model="editData.drive_url" placeholder="https://drive.google.com/..."
                            class="w-full bg-white border border-amber-200 rounded-xl px-4 py-2.5 text-xs font-mono text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>

                    <!-- Status Publikasi -->
                    <div class="pt-2">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" x-model="editData.is_active" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-xs font-semibold text-slate-700">Publikasikan dokumen (Status Aktif)</span>
                        </label>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                        <button type="button" @click="showEditModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow-md shadow-indigo-600/20">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>

    <!-- MODAL POP-UP PREVIEW PDF (Dark Mode Elegan) -->
    <template x-teleport="body">
        <div x-show="showModal" class="fixed inset-0 z-[999] flex items-center justify-center p-4 sm:p-6" style="display: none;">
            <div x-show="showModal" x-transition.opacity class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm" @click="showModal = false"></div>
            
            <div x-show="showModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-8"
                 class="relative bg-[#1e2329] rounded-2xl shadow-2xl w-full max-w-5xl h-[85vh] flex flex-col overflow-hidden border border-slate-700 z-10">
                
                <!-- Header Modal -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 border-b border-slate-700/50 bg-[#161b22] gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-indigo-500/20 text-indigo-400 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-100 text-sm md:text-base" x-text="pdfTitle"></h4>
                            <p class="text-xs text-slate-400 mt-0.5" x-text="fileInfo"></p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <a :href="pdfUrl" target="_blank" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-emerald-600 text-white hover:bg-emerald-500 transition-colors text-xs font-bold shadow-lg shadow-emerald-900/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Download
                        </a>
                        <button @click="showModal = false" class="w-9 h-9 ml-2 flex items-center justify-center rounded-lg bg-slate-800 text-slate-400 hover:bg-red-500/20 hover:text-red-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
                
                <!-- Body Modal (Iframe PDF Viewer) -->
                <div class="flex-grow bg-[#525659] w-full relative">
                    <template x-if="showModal">
                        <iframe :src="pdfUrl" class="absolute inset-0 w-full h-full border-0" allow="autoplay"></iframe>
                    </template>
                </div>
            </div>
        </div>
    </template>

</div>

<!-- SortableJS CDN untuk Drag & Drop -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script>
function standarPelayananManager() {
    return {
        sourceType: 'file',
        searchQuery: '',
        selectedCategory: 'all',
        selectedStatus: 'all',

        // Preview Modal
        showModal: false,
        pdfTitle: '',
        pdfUrl: '',
        fileInfo: '',

        // Edit Modal
        showEditModal: false,
        editData: {
            id: null,
            title: '',
            category: 'Umum',
            source_type: 'file',
            file_path: '',
            drive_url: '',
            is_active: true
        },

        init() {
            this.initSortable();
        },

        isItemVisible(title, category, status) {
            const matchesSearch = !this.searchQuery || title.includes(this.searchQuery.toLowerCase().trim());
            const matchesCategory = this.selectedCategory === 'all' || category === this.selectedCategory;
            const matchesStatus = this.selectedStatus === 'all' || status === this.selectedStatus;
            return matchesSearch && matchesCategory && matchesStatus;
        },

        openModal(title, url, info) {
            this.pdfTitle = title;
            this.pdfUrl = url;
            this.fileInfo = info;
            this.showModal = true;
        },

        openEditModal(item) {
            this.editData = {
                id: item.id,
                title: item.title,
                category: item.category || 'Umum',
                source_type: item.source_type || 'file',
                file_path: item.file_path,
                drive_url: item.source_type === 'drive_link' ? item.file_path : '',
                is_active: Boolean(item.is_active)
            };
            this.showEditModal = true;
        },

        async toggleStatus(id, event) {
            const btn = event.currentTarget;
            btn.disabled = true;

            try {
                const response = await fetch(`{{ url('admin/standar-pelayanan') }}/${id}/toggle-status`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                if (data.success) {
                    const row = btn.closest('.document-row');
                    const dot = btn.querySelector('.rounded-full');
                    const text = btn.querySelector('.status-text');

                    if (data.is_active) {
                        btn.className = 'px-3 py-1.5 rounded-xl font-bold text-xs transition-all flex items-center gap-1.5 border bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100';
                        dot.className = 'w-2 h-2 rounded-full bg-emerald-500';
                        text.textContent = 'Aktif';
                        if (row) row.dataset.status = 'active';
                    } else {
                        btn.className = 'px-3 py-1.5 rounded-xl font-bold text-xs transition-all flex items-center gap-1.5 border bg-slate-100 text-slate-500 border-slate-200 hover:bg-slate-200';
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
                alert('Gagal memperbarui status publikasi.');
            } finally {
                btn.disabled = false;
            }
        },

        initSortable() {
            const listEl = document.getElementById('sortable-document-list');
            if (!listEl || !window.Sortable) return;

            new Sortable(listEl, {
                animation: 200,
                handle: '.drag-handle',
                ghostClass: 'opacity-40',
                chosenClass: 'bg-indigo-50/70',
                onEnd: async (evt) => {
                    const rows = Array.from(listEl.querySelectorAll('.document-row'));
                    const orderedIds = rows.map(r => Number(r.dataset.id));

                    // Re-index displayed numbers
                    rows.forEach((r, idx) => {
                        const indexBadge = r.querySelector('.row-index');
                        if (indexBadge) indexBadge.textContent = idx + 1;
                    });

                    try {
                        const response = await fetch('{{ route('admin.standar-pelayanan.reorder') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ ids: orderedIds })
                        });

                        const resData = await response.json();
                        if (resData.success && window.Swal) {
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
