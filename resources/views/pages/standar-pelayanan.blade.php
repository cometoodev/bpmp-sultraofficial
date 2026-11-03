@extends('layouts.app')

@php
    $dokumens = $dokumens ?? \App\Models\StandarPelayanan::orderBy('id', 'asc')->get();
@endphp

@section('title', isset($page) ? $page->getSeoTitle() : 'Standar Pelayanan - BPMP Provinsi Sulawesi Tenggara')
@section('meta_description', isset($page) ? $page->getSeoDescription() : 'Tolok ukur pedoman penyelenggaraan pelayanan dan acuan penilaian kualitas pelayanan BPMP Provinsi Sulawesi Tenggara.')

@section('content')
<!-- HEADER UNIVERSAL (BIRU SOLID / BG-BLUE-900) -->
<div class="relative pt-28 pb-40 overflow-hidden bg-blue-900">
    <div class="relative z-10 text-center px-4 max-w-4xl mx-auto flex flex-col items-center">
        <!-- Badge Kategori / Label -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-white font-extrabold text-[10px] sm:text-xs uppercase tracking-widest shadow-sm mb-6">
            <div class="w-2 h-2 rounded-full bg-blue-400"></div>
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
                openModal(title, url, info) {
                    this.pdfTitle = title;
                    this.pdfUrl = url;
                    this.fileInfo = info;
                    this.showModal = true;
                },
                copyLink(url) {
                    navigator.clipboard.writeText(url).then(() => {
                        alert('Tautan dokumen berhasil disalin!');
                    });
                }
            }">

            <!-- DESKRIPSI HALAMAN -->
            <div style="width: 100%; max-width: 950px; margin: 0 auto; display: block;">
                <div class="shadow-sm" style="background-color: #eef2ff; border-radius: 1.5rem; padding: 2rem; display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap; border: 1px solid #e0e7ff;">
                    <div class="shadow-lg" style="background-color: #4f46e5; color: white; width: 4rem; height: 4rem; border-radius: 1rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg style="width: 2rem; height: 2rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <p style="color: #475569; font-size: 1.1rem; line-height: 1.6; flex: 1; min-width: 250px; margin: 0;">
                        Tolok ukur yang dipergunakan sebagai pedoman penyelenggaraan pelayanan dan acuan penilaian kualitas pelayanan sebagai kewajiban dan janji penyelenggara kepada masyarakat.
                    </p>
                </div>
            </div>

            <!-- DAFTAR KARTU LIST DOKUMEN PDF DINAMIS DARI BACKEND -->
            <div style="width: 100%; max-width: 950px; margin: 0 auto; display: flex; flex-direction: column; gap: 1.25rem;">
                
                @forelse($dokumens as $item)
                <div class="bg-white hover:shadow-xl transition-all duration-300" style="border-radius: 1.25rem; padding: 1.25rem 1.75rem; display: flex; align-items: center; justify-content: space-between; gap: 1.5rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 1.25rem; flex: 1; min-width: 280px;">
                        <div style="background-color: #fee2e2; color: #dc2626; width: 3.5rem; height: 3.5rem; border-radius: 0.85rem; display: flex; flex-direction: column; align-items: center; justify-content: center; font-weight: 900; font-size: 0.75rem; flex-shrink: 0;">
                            PDF
                        </div>
                        <div>
                            <!-- Judul Dokumen dari Backend -->
                            <h3 style="color: #1e293b; font-weight: 800; font-size: 1.05rem; margin: 0 0 0.35rem 0;">{{ $item->title }}</h3>
                            <div style="display: flex; align-items: center; gap: 1rem; color: #64748b; font-size: 0.8rem; font-weight: 500;">
                                <!-- Tanggal Upload Murni dari Backend -->
                                <span style="display: flex; align-items: center; gap: 0.3rem;">📅 {{ \Carbon\Carbon::parse($item->uploaded_at)->translatedFormat('d F Y') }}</span>
                                <span>•</span>
                                <!-- Ukuran File (KB/MB) Murni dari Backend -->
                                <span>📁 {{ $item->file_size }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <!-- Tombol Preview Membuka Pop-up PDF Viewer -->
                        <button @click="openModal('{{ $item->title }}', '{{ $item->file_path }}', 'Diperbarui: {{ \Carbon\Carbon::parse($item->uploaded_at)->translatedFormat('d M Y') }} • {{ $item->file_size }}')" class="hover:bg-indigo-700 transition-colors" style="background-color: #4f46e5; color: white; padding: 0.6rem 1.25rem; border-radius: 0.75rem; font-weight: 700; font-size: 0.85rem; display: flex; align-items: center; gap: 0.5rem; border: none; cursor: pointer;">
                            <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            Preview
                        </button>
                        <button @click="copyLink('{{ $item->file_path }}')" class="hover:bg-slate-100 transition-colors" style="background-color: #f8fafc; color: #475569; padding: 0.6rem; border-radius: 0.75rem; border: 1px solid #cbd5e1; cursor: pointer;" title="Salin Tautan">
                            <svg style="width: 1.15rem; height: 1.15rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </button>
                    </div>
                </div>
                @empty
                <div class="text-center py-12 bg-slate-50 rounded-2xl border border-slate-200 text-slate-500">
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
                                <button @click="copyLink(pdfUrl)" title="Salin Tautan" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-3 py-2 rounded-lg bg-slate-700/50 text-slate-200 hover:bg-slate-700 transition-colors text-xs font-semibold border border-slate-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                    <span class="hidden sm:inline">Salin Tautan</span>
                                </button>
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

