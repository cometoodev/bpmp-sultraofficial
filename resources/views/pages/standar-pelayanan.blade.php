@extends('layouts.app')

@php
    $dokumens = $dokumens ?? \App\Models\StandarPelayanan::where('is_active', true)->orderBy('order_position', 'asc')->orderBy('id', 'asc')->get();
    $categories = $dokumens->pluck('category')->filter()->unique()->values();
@endphp

@section('title', isset($page) ? $page->getSeoTitle() : 'Standar Pelayanan - BPMP Provinsi Sulawesi Tenggara')
@section('meta_description', isset($page) ? $page->getSeoDescription() : 'Tolok ukur pedoman penyelenggaraan pelayanan dan acuan penilaian kualitas pelayanan BPMP Provinsi Sulawesi Tenggara.')

@section('content')
<style>
    /* Smooth Scroll & Anchor Target Highlight */
    html {
        scroll-behavior: smooth;
    }
    div[id^="document-"]:target {
        animation: documentTargetGlow 2.5s ease-out;
    }
    @keyframes documentTargetGlow {
        0% {
            outline: 3px solid #4f46e5;
            outline-offset: 4px;
            box-shadow: 0 10px 30px -5px rgba(79, 70, 229, 0.3);
            transform: scale(1.01);
        }
        70% {
            outline: 3px solid rgba(79, 70, 229, 0.6);
            outline-offset: 4px;
        }
        100% {
            outline: 3px solid transparent;
            outline-offset: 0;
            transform: scale(1);
        }
    }
</style>

<!-- HEADER UNIVERSAL (BIRU SOLID / BG-BLUE-900) -->
<div class="relative pt-28 pb-40 overflow-hidden bg-blue-900">
    <div class="relative z-10 text-center px-4 max-w-4xl mx-auto flex flex-col items-center">
        <!-- Badge Kategori / Label -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-white font-extrabold text-[10px] sm:text-xs uppercase tracking-widest shadow-sm mb-6">
            <div class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></div>
            Sistem Informasi Publik
        </div>

        <!-- Judul Halaman Dinamis -->
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight mb-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            {{ $page->title ?? 'Standar Pelayanan' }}
        </h1>

        <!-- Breadcrumbs & Meta Date -->
        <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 text-xs sm:text-sm font-medium text-blue-200">
            <a href="/" class="hover:text-white transition-colors">Beranda</a>
            <span class="text-blue-400/60">›</span>
            <span class="text-white font-semibold">{{ $page->title ?? 'Standar Pelayanan' }}</span>
            <span class="hidden sm:inline-block text-blue-400/60 mx-2">|</span>
            <div class="flex items-center gap-1.5 mt-2 sm:mt-0 px-3 py-1 rounded-lg bg-black/10 border border-white/10 text-blue-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Diperbarui: {{ isset($page) && $page->updated_at ? $page->updated_at->format('d M Y') : date('d M Y') }}
            </div>
        </div>
    </div>
</div>

<!-- KONTEN HALAMAN UNIVERSAL (Overlap menimpa header biru) -->
<div class="cms-master-wrapper relative z-20 w-full max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 -mt-24 mb-20">
    <div class="bg-white/95 backdrop-blur-xl rounded-[2.5rem] md:rounded-[3rem] shadow-xl border border-slate-100 p-6 md:p-12 lg:p-16 w-full overflow-hidden">

        <div style="width: 100%; display: flex; flex-direction: column; gap: 2rem;" x-data="{ 
                showModal: false, 
                pdfTitle: '', 
                pdfUrl: '', 
                fileInfo: '',
                searchKeyword: '',
                activeCategory: 'all',
                openModal(title, url, info) {
                    this.pdfTitle = title;
                    this.pdfUrl = url;
                    this.fileInfo = info;
                    this.showModal = true;
                },
                copyLink(docId, directUrl) {
                    const fullAnchorUrl = window.location.origin + window.location.pathname + '#document-' + docId;
                    navigator.clipboard.writeText(fullAnchorUrl).then(() => {
                        alert('Tautan langsung ke section dokumen ini berhasil disalin!');
                    });
                },
                isMatch(title, category) {
                    const matchSearch = !this.searchKeyword || title.toLowerCase().includes(this.searchKeyword.toLowerCase().trim());
                    const matchCat = this.activeCategory === 'all' || category === this.activeCategory;
                    return matchSearch && matchCat;
                }
            }">

            <!-- DESKRIPSI HALAMAN -->
            <div style="width: 100%; max-width: 950px; margin: 0 auto; display: block;">
                <div class="shadow-sm" style="background-color: #eef2ff; border-radius: 1.5rem; padding: 2rem; display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap; border: 1px solid #e0e7ff;">
                    <div class="shadow-lg" style="background-color: #4f46e5; color: white; width: 4rem; height: 4rem; border-radius: 1rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg style="width: 2rem; height: 2rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <p style="color: #475569; font-size: 1.05rem; line-height: 1.6; flex: 1; min-width: 250px; margin: 0;">
                        Tolok ukur yang dipergunakan sebagai pedoman penyelenggaraan pelayanan dan acuan penilaian kualitas pelayanan sebagai kewajiban dan janji penyelenggara kepada masyarakat.
                    </p>
                </div>
            </div>

            <!-- SEARCH BAR & FILTER KATEGORI UNTUK MASYARAKAT -->
            <div style="width: 100%; max-width: 950px; margin: 0 auto; display: flex; flex-direction: column; gap: 1rem;">
                <div class="relative w-full">
                    <input type="text" x-model="searchKeyword" placeholder="Cari nama standar pelayanan / dokumen..."
                           class="w-full bg-slate-50/80 border border-slate-200 rounded-2xl pl-11 pr-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none shadow-xs text-slate-800 transition-all font-medium">
                    <svg class="w-5 h-5 text-slate-400 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <button type="button" x-show="searchKeyword" @click="searchKeyword = ''" class="absolute right-3.5 top-3 text-slate-400 hover:text-slate-600 text-sm">✕</button>
                </div>

                @if($categories->count() > 1)
                <!-- Category Pills -->
                <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
                    <button type="button" @click="activeCategory = 'all'"
                            :class="activeCategory === 'all' ? 'bg-indigo-600 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold'"
                            class="px-4 py-1.5 rounded-xl text-xs whitespace-nowrap transition-all">
                        Semua Kategori ({{ $dokumens->count() }})
                    </button>
                    @foreach($categories as $cat)
                        <button type="button" @click="activeCategory = '{{ $cat }}'"
                                :class="activeCategory === '{{ $cat }}' ? 'bg-indigo-600 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold'"
                                class="px-4 py-1.5 rounded-xl text-xs whitespace-nowrap transition-all">
                            {{ $cat }} ({{ $dokumens->where('category', $cat)->count() }})
                        </button>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- DAFTAR KARTU LIST DOKUMEN DINAMIS DARI BACKEND -->
            <div style="width: 100%; max-width: 950px; margin: 0 auto; display: flex; flex-direction: column; gap: 1.25rem;">
                
                @forelse($dokumens as $item)
                <div id="document-{{ $item->id }}"
                     class="scroll-mt-32 bg-white hover:shadow-xl transition-all duration-300 rounded-[1.25rem] p-5 sm:p-6 border border-slate-200/90 flex items-center justify-between gap-5 flex-wrap"
                     x-show="isMatch('{{ addslashes($item->title) }}', '{{ $item->category ?: 'Umum' }}')">
                    
                    <div class="flex items-center gap-4 flex-1 min-w-[280px]">
                        <!-- Auto-detected Document Icon Badge -->
                        <div class="w-14 h-14 rounded-2xl flex flex-col items-center justify-center font-black text-xs shrink-0 border shadow-xs {{ $item->badge_color_class }}">
                            @if($item->isDriveLink())
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM19 18H6c-2.21 0-4-1.79-4-4 0-2.05 1.53-3.76 3.56-3.97l1.07-.11.5-.95C8.08 7.14 9.94 6 12 6c2.62 0 4.88 1.86 5.39 4.43l.3 1.5 1.53.11c1.56.1 2.78 1.41 2.78 2.96 0 1.65-1.35 3-3 3z"/>
                                </svg>
                                <span class="text-[9px] font-extrabold uppercase mt-0.5">DRIVE</span>
                            @elseif($item->isWord())
                                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span class="text-[9px] font-extrabold uppercase">WORD</span>
                            @elseif($item->isExcel())
                                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span class="text-[9px] font-extrabold uppercase">EXCEL</span>
                            @else
                                <span class="text-sm font-black tracking-tight">PDF</span>
                            @endif
                        </div>

                        <div>
                            <!-- Judul Dokumen -->
                            <div class="flex items-center gap-2 flex-wrap mb-1">
                                <h3 class="text-slate-800 font-extrabold text-base sm:text-lg leading-snug">{{ $item->title }}</h3>
                                <span class="px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-700 text-[10px] font-bold uppercase tracking-wider border border-indigo-100">
                                    {{ $item->category ?: 'Umum' }}
                                </span>
                            </div>

                            <div class="flex items-center gap-3 text-xs text-slate-500 font-medium flex-wrap">
                                <span>📅 {{ \Carbon\Carbon::parse($item->uploaded_at)->translatedFormat('d F Y') }}</span>
                                <span>•</span>
                                @if($item->isDriveLink())
                                    <span class="text-amber-700 font-semibold flex items-center gap-1">🔗 Google Drive Cloud</span>
                                @else
                                    <span>📁 {{ $item->file_size }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2.5">
                        @if($item->isPdf())
                            <!-- Tombol Preview Membuka Pop-up PDF Viewer -->
                            <button type="button" @click="openModal('{{ $item->title }}', '{{ $item->file_path }}', 'Diperbarui: {{ \Carbon\Carbon::parse($item->uploaded_at)->translatedFormat('d M Y') }} • {{ $item->file_size }}')"
                                    class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs flex items-center gap-2 shadow-sm transition-all hover:scale-[1.02] active:scale-[0.98]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <span>Preview</span>
                            </button>
                        @elseif($item->isDriveLink())
                            <!-- Tombol Buka Link Google Drive -->
                            <a href="{{ $item->file_path }}" target="_blank"
                               class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs flex items-center gap-2 shadow-sm transition-all hover:scale-[1.02] active:scale-[0.98]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                <span>Buka Drive</span>
                            </a>
                        @else
                            <!-- Tombol Download Dokumen Word / Excel -->
                            <a href="{{ $item->file_path }}" target="_blank" download
                               class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs flex items-center gap-2 shadow-sm transition-all hover:scale-[1.02] active:scale-[0.98]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                <span>Download</span>
                            </a>
                        @endif

                        <!-- Tombol Salin Tautan Langsung ke Section Dokumen Ini -->
                        <button type="button" @click="copyLink({{ $item->id }}, '{{ $item->file_path }}')"
                                class="p-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition-colors border border-slate-200" title="Salin Tautan Langsung ke Section Dokumen Ini">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </button>
                    </div>
                </div>
                @empty
                <div class="text-center py-16 bg-slate-50/70 rounded-3xl border border-slate-200 text-slate-500">
                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Belum ada dokumen standar pelayanan yang tersedia.
                </div>
                @endforelse

            </div>

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
                         class="relative bg-[#1e2329] rounded-2xl shadow-2xl w-full max-w-5xl h-[85vh] flex flex-col overflow-hidden border border-slate-700">
                        
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

    </div>
</div>
@endsection
