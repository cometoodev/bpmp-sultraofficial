@extends('layouts.app')

@section('title', $page->getSeoTitle())
@section('meta_description', $page->getSeoDescription())

@section('content')
<!-- HEADER UNIVERSAL (BIRU SOLID / BG-BLUE-900) -->
<div class="relative pt-28 pb-40 overflow-hidden bg-blue-900">
    
    <!-- Konten Judul Header -->
    <div class="relative z-10 text-center px-4 max-w-4xl mx-auto flex flex-col items-center">
        
        <!-- Badge Kategori / Label -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-white font-extrabold text-[10px] sm:text-xs uppercase tracking-widest shadow-sm mb-6">
            <div class="w-2 h-2 rounded-full bg-blue-400"></div>
            Sistem Informasi Publik
        </div>

        <!-- Judul Halaman Dinamis -->
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight mb-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            {{ $page->title ?? 'Judul Halaman' }}
        </h1>

        <!-- Breadcrumbs & Meta Date -->
        <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 text-xs sm:text-sm font-medium text-blue-200">
            <a href="/" class="hover:text-white transition-colors">Beranda</a>
            <span class="text-blue-400/60">›</span>
            <span class="text-white font-semibold">{{ $page->title ?? 'Judul Halaman' }}</span>
            
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
    
    <!-- KARTU RAKSASA PERMANEN (Membungkus otomatis semua halaman CMS) -->
    <div class="bg-white/95 backdrop-blur-xl rounded-[2.5rem] md:rounded-[3rem] shadow-xl border border-slate-100 p-6 md:p-12 lg:p-16 w-full overflow-hidden">
        
        @if($page->featured_image)
            <div class="mb-8 rounded-3xl overflow-hidden shadow-md max-h-[460px]">
                <img src="{{ Storage::disk('public')->url($page->featured_image) }}" alt="{{ $page->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        <!-- Output murni dari Visual Builder / CMS -->
        @if(($page->design_method === 'builder' || $page->editor_mode === 'visual' || $page->editor_mode === 'html') && !empty($page->builder_data))
            @php
                $builderBlocks = json_decode($page->builder_data, true);
            @endphp
            @if(is_array($builderBlocks) && count($builderBlocks) > 0)
                @foreach($builderBlocks as $block)
                    @if(($block['type'] ?? '') === 'glass_split')
                        <x-builder.glass-split :block="$block" />
                    @elseif(($block['type'] ?? '') === 'glass_cards')
                        <x-builder.glass-cards :block="$block" />
                    @else
                        {!! $block['html_content'] ?? app(\App\Http\Controllers\Admin\PageController::class)->compileSingleBlock($block) !!}
                    @endif
                @endforeach
            @else
                {!! $page->content !!}
            @endif
        @elseif($page->slug === 'struktur-organisasi')
            <!-- TAHAP 1: BINGKAI GAMBAR STRUKTUR ORGANISASI -->
            <div class="w-full max-w-5xl mx-auto my-12">
                <!-- Container Bingkai Modern -->
                <div class="relative bg-white p-2 md:p-4 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-slate-100 group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-[2rem] blur opacity-0 group-hover:opacity-50 transition duration-1000 group-hover:duration-500 -z-10"></div>
                    <div class="overflow-hidden rounded-2xl border border-slate-50 bg-slate-50">
                        <img src="{{ asset('images/1.2 Struktur Organisasi.jpg') }}" onerror="this.onerror=null; this.src='https://placehold.co/1200x800/f8fafc/1e3a8a?text=1.2+Struktur+Organisasi';" alt="Bagan Struktur Organisasi BPMP Sultra" class="w-full h-auto object-contain cursor-zoom-in hover:scale-[1.01] transition-transform duration-500">
                    </div>
                </div>
                
                <!-- Keterangan SK -->
                <p class="text-center text-sm text-slate-500 mt-6 italic">
                    Berdasarkan Surat Keputusan Kepala BPMP Provinsi Sulawesi Tenggara Nomor: 0072/C7.26 /PR.01.02.1/2026 tentang Pembentukan Tim Kerja BPMP Provinsi Sulawesi Tenggara Tahun 2026 
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold underline underline-offset-2 transition-colors">(lihat SK di sini)</a>
                </p>
            </div>

            <!-- TAHAP 2: TOMBOL TIM KERJA INTERAKTIF -->
            <div class="flex flex-col items-center justify-center my-16 bg-blue-50/50 rounded-3xl py-10 px-4 border border-blue-100/50">
                <h3 class="text-2xl font-bold text-slate-800 mb-2">Informasi Tim Kerja</h3>
                <p class="text-slate-600 text-center max-w-lg mb-8">
                    Kenali lebih dekat susunan anggota, tugas, dan fungsi dari masing-masing Tim Kerja (PAUD, SD, SMP, SMA) di lingkungan BPMP Sultra.
                </p>
                <a href="/tim-kerja" class="group relative inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-white transition-all duration-200 bg-blue-600 border border-transparent rounded-full shadow-lg hover:bg-blue-700 hover:shadow-xl hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
                    Lihat Detail Tim Kerja
                    <svg class="w-5 h-5 ml-2 -mr-1 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </div>
        @else
            <div class="prose prose-lg prose-blue max-w-none text-slate-600 leading-relaxed text-justify">
                {!! $page->content !!}
            </div>
        @endif

        {{-- DOKUMEN & LAMPIRAN TERKAIT HALAMAN (Jika ada lampiran aktif) --}}
        @if(isset($page) && $page->activeAttachments && $page->activeAttachments->isNotEmpty())
            <div id="dokumen-lampiran" class="mt-16 pt-12 border-t border-slate-100" x-data="{
                searchQuery: '',
                activeCategory: 'all',
                matchesFilter(title, category) {
                    const matchSearch = this.searchQuery === '' || title.toLowerCase().includes(this.searchQuery.toLowerCase());
                    const matchCategory = this.activeCategory === 'all' || category === this.activeCategory;
                    return matchSearch && matchCategory;
                }
            }">
                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold uppercase tracking-wider mb-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Unduhan &amp; Berkas Resmi
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            Dokumen &amp; Lampiran Terkait
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Akses dan unduh berkas publik, regulasi, atau materi pendukung untuk halaman ini.
                        </p>
                    </div>

                    <!-- Search Input Filter -->
                    <div class="relative w-full md:w-72">
                        <input type="text" x-model="searchQuery" placeholder="Cari nama dokumen..."
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-10 pr-4 py-2.5 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:bg-white transition-all">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </div>
                </div>

                @php
                    $attachmentCategories = $page->activeAttachments->pluck('category')->filter()->unique()->values();
                @endphp

                <!-- Kategori Filter Chips (Jika ada kategori) -->
                @if($attachmentCategories->isNotEmpty())
                    <div class="flex flex-wrap items-center gap-2 mb-6">
                        <button type="button" @click="activeCategory = 'all'"
                            :class="activeCategory === 'all' ? 'bg-emerald-600 text-white shadow-sm font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-medium'"
                            class="px-4 py-1.5 rounded-full text-xs transition-all">
                            Semua Berkas ({{ $page->activeAttachments->count() }})
                        </button>
                        @foreach($attachmentCategories as $cat)
                            <button type="button" @click="activeCategory = '{{ $cat }}'"
                                :class="activeCategory === '{{ $cat }}' ? 'bg-emerald-600 text-white shadow-sm font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-medium'"
                                class="px-4 py-1.5 rounded-full text-xs transition-all">
                                {{ $cat }} ({{ $page->activeAttachments->where('category', $cat)->count() }})
                            </button>
                        @endforeach
                    </div>
                @endif

                <!-- Daftar Dokumen Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($page->activeAttachments as $doc)
                        <div id="document-{{ $doc->id }}"
                            x-show="matchesFilter('{{ addslashes($doc->title) }}', '{{ addslashes($doc->category ?? '') }}')"
                            x-transition
                            class="document-item scroll-mt-32 bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md hover:border-emerald-200 transition-all group flex flex-col justify-between">
                            
                            <div>
                                <div class="flex items-start justify-between gap-3 mb-3">
                                    <div class="flex items-center gap-3">
                                        <!-- Ikon Dokumen -->
                                        @if($doc->isDriveLink())
                                            <div class="w-11 h-11 rounded-2xl bg-amber-50 text-amber-600 border border-amber-200/80 flex items-center justify-center shrink-0 shadow-xs group-hover:scale-105 transition-transform">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                            </div>
                                        @elseif($doc->isWord())
                                            <div class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-600 border border-blue-200/80 flex items-center justify-center shrink-0 shadow-xs group-hover:scale-105 transition-transform">
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zM6 20V4h7v5h5v11H6z"/></svg>
                                            </div>
                                        @elseif($doc->isExcel())
                                            <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-200/80 flex items-center justify-center shrink-0 shadow-xs group-hover:scale-105 transition-transform">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </div>
                                        @else
                                            <div class="w-11 h-11 rounded-2xl bg-red-50 text-red-600 border border-red-200/80 flex items-center justify-center shrink-0 shadow-xs group-hover:scale-105 transition-transform">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                            </div>
                                        @endif

                                        <div>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-black border uppercase {{ $doc->badge_color_class }}">
                                                {{ $doc->badge_label }}
                                            </span>
                                            @if($doc->category)
                                                <span class="ml-1.5 inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-slate-100 text-slate-600 border border-slate-200/60">
                                                    {{ $doc->category }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Tombol Salin Anchor Link -->
                                    <button type="button"
                                        @click="navigator.clipboard.writeText('{{ url($page->slug) }}#document-{{ $doc->id }}'); $el.setAttribute('title', 'Tersalin!'); setTimeout(() => $el.setAttribute('title', 'Salin Tautan Dokumen'), 2000)"
                                        class="p-1.5 rounded-lg text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-colors"
                                        title="Salin Tautan Dokumen">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                    </button>
                                </div>

                                <h3 class="text-base font-bold text-slate-800 group-hover:text-emerald-700 transition-colors mb-2 leading-snug">
                                    {{ $doc->title }}
                                </h3>

                                <div class="flex items-center gap-2 text-xs text-slate-400 font-medium mb-4">
                                    <span>{{ $doc->formatted_size }}</span>
                                    <span>&bull;</span>
                                    <span>Diunduh {{ number_format($doc->download_count) }}x</span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-3">
                                @if($doc->isDriveLink())
                                    <a href="{{ route('pages.attachments.download', $doc) }}" target="_blank"
                                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs font-bold shadow-xs hover:shadow transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        <span>Buka di Google Drive</span>
                                    </a>
                                @elseif($doc->isPdf())
                                    <a href="{{ route('pages.attachments.download', $doc) }}" target="_blank"
                                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-xs hover:shadow transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.264 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span>Lihat / Unduh Dokumen</span>
                                    </a>
                                @else
                                    <a href="{{ route('pages.attachments.download', $doc) }}"
                                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-xs hover:shadow transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        <span>Unduh Berkas</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Target Highlight Styling -->
            <style>
                [id^="document-"]:target {
                    outline: 3px solid #10b981;
                    outline-offset: 4px;
                    border-radius: 1rem;
                    animation: documentHighlight 2s ease-in-out;
                }
                @keyframes documentHighlight {
                    0% { transform: scale(1.02); box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.3); }
                    100% { transform: scale(1); }
                }
            </style>
        @endif

        <!-- TOMBOL BAGIKAN HALAMAN (GLASSMORPHISM WRAPPER) -->
        <div class="mt-12 pt-8 border-t border-slate-100" x-data="{ copied: false }">
            <div class="flex items-center gap-2 mb-4 text-blue-800 font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                <h3>Bagikan Halaman Ini</h3>
            </div>
            
            <div class="flex flex-wrap items-center gap-3">
                <!-- WhatsApp -->
                <a href="https://api.whatsapp.com/send?text={{ urlencode($page->title . ' - ' . url($page->slug)) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 rounded-full text-sm font-semibold transition-colors border border-emerald-100">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    WhatsApp
                </a>

                <!-- Facebook -->
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url($page->slug)) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-full text-sm font-semibold transition-colors border border-blue-100">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    Facebook
                </a>

                <!-- Twitter / X -->
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url($page->slug)) }}&text={{ urlencode($page->title) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-sky-50 hover:bg-sky-100 text-sky-500 rounded-full text-sm font-semibold transition-colors border border-sky-100">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    Twitter / X
                </a>

                <!-- Salin Link -->
                <button type="button" @click="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2000)" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-50 hover:bg-slate-100 text-slate-700 rounded-full text-sm font-semibold transition-colors border border-slate-200 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    <span x-text="copied ? 'Tersalin!' : 'Salin Link'">Salin Link</span>
                </button>
            </div>
        </div>

    </div>

</div>
@endsection
