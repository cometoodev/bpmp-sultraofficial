@extends('layouts.app')

@section('title', isset($page) ? $page->getSeoTitle() : 'Kisah Inspiratif - BPMP Provinsi Sulawesi Tenggara')
@section('meta_description', isset($page) ? $page->getSeoDescription() : 'Himpunan tulisan narasi kisah inspirasi dari pelaksana Sekolah Penggerak di Sulawesi Tenggara.')

@section('content')
<!-- HEADER UNIVERSAL (BIRU SOLID / BG-BLUE-900) -->
<div class="relative pt-28 pb-40 overflow-hidden bg-blue-900">
    <div class="relative z-10 text-center px-4 max-w-4xl mx-auto flex flex-col items-center">
        <!-- Badge Kategori / Label -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-white font-extrabold text-[10px] sm:text-xs uppercase tracking-widest shadow-sm mb-6">
            <div class="w-2 h-2 rounded-full bg-blue-400"></div>
            Program Sekolah Penggerak
        </div>

        <!-- Judul Halaman Dinamis -->
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight mb-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            {{ $page->title ?? 'Kisah Inspiratif' }}
        </h1>

        <!-- Breadcrumbs & Meta Date -->
        <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 text-xs sm:text-sm font-medium text-blue-200">
            <a href="/" class="hover:text-white transition-colors">Beranda</a>
            <span class="text-blue-400/60">›</span>
            <span class="text-blue-200">Program</span>
            <span class="text-blue-400/60">›</span>
            <span class="text-white font-semibold">{{ $page->title ?? 'Kisah Inspiratif' }}</span>
            <span class="hidden sm:inline-block text-blue-400/60 mx-2">|</span>
            <div class="flex items-center gap-1.5 mt-2 sm:mt-0 px-3 py-1 rounded-lg bg-black/10 border border-white/10 text-blue-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Praktik Baik Pendidikan
            </div>
        </div>
    </div>
</div>

<!-- KONTEN HALAMAN UNIVERSAL (Overlap menimpa header biru) -->
<div class="cms-master-wrapper relative z-20 w-full max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 -mt-24 mb-20">
    <div class="bg-white/95 backdrop-blur-xl rounded-[2.5rem] md:rounded-[3rem] shadow-xl border border-slate-100 p-6 md:p-12 lg:p-16 w-full overflow-hidden">
        
        <div style="width: 100%; display: flex; flex-direction: column; gap: 3rem;">

            <!-- 1. NARASI / DESKRIPSI PENGANTAR -->
            <div style="width: 100%; max-width: 1000px; margin: 0 auto; display: flex; flex-direction: column; gap: 1.25rem; color: #475569; font-size: 0.95rem; line-height: 1.7;">
                <p>
                    Program sekolah penggerak diawali dengan proses seleksi kepala sekolah yang diharapkan memiliki kemampuan dan pengalaman dalam melakukan transformasi sekolah menuju pada terwujudnya pelajar yang memiliki profil pelajar pancasila, yaitu bertakwa kepada Tuhan YME dan berakhlak mulia, bernalar kritis, kreatif, mandiri, beriman, bergotong-royong dan berkebhinekaan global.
                </p>
                <p>
                    Program Sekolah Penggerak berfokus pada pengembangan hasil belajar siswa secara holistik yang mencakup kompetensi (literasi dan numerasi) dan karakter, diawali dengan peningkatan sumber daya manusia yang unggul. Terdapat 5 intervensi yang dilakukan: (1) pendampingan konsultatif dan asimetris, (2) penguatan sumber daya manusia di Sekolah, (3) pembelajaran dengan paradigma baru, (4) perencanaan berbasis data, dan (5) digitalisasi sekolah.
                </p>
                <p>
                    Saat ini jumlah sekolah penggerak di Indonesia sebanyak 14.219 sekolah. Di Sulawesi Tenggara terdapat 233 sekolah penggerak, yang terdiri dari 41 sekolah angkatan I, 111 sekolah angkatan 2, dan 81 sekolah angkatan 3.
                </p>
                <p>
                    Untuk mendokumentasikan praktik-praktik baik, Balai Penjaminan Mutu Pendidikan Provinsi Sulawesi Tenggara menghimpun tulisan narasi kisah inspirasi dari pelaksana sekolah penggerak ke dalam buku ini. Kiranya buku ini dapat menjadi inspirasi bagi sekolah lainnya dalam melakukan transformasi yang sama.
                </p>
            </div>

            <!-- 2. DAFTAR KISAH INSPIRATIF (Otomatis dari Database Berita) -->
            <div style="width: 100%; max-width: 1000px; margin: 0 auto; display: flex; flex-direction: column; gap: 1.5rem;">
                
                <div style="display: flex; align-items: center; gap: 0.75rem; border-bottom: 2px solid #f1f5f9; padding-bottom: 0.75rem;">
                    <div style="background-color: #4f46e5; color: white; width: 2.5rem; height: 2.5rem; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h3 style="color: #1e293b; font-weight: 900; font-size: 1.35rem; margin: 0;">Daftar Kisah Inspiratif</h3>
                </div>

                <!-- Grid Kartu Berita Kisah Inspiratif -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem;">
                    
                    @forelse($kisahList ?? [] as $item)
                        <div class="hover:shadow-xl hover:-translate-y-1 transition-all duration-300" style="background: white; border: 1px solid #e2e8f0; border-radius: 1.25rem; overflow: hidden; display: flex; flex-direction: column;">
                            <div style="width: 100%; height: 140px; overflow: hidden; background: #f1f5f9;">
                                <img src="{{ $item->thumbnail_url }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&w=600&q=80'">
                            </div>
                            <div style="padding: 1.25rem; display: flex; flex-direction: column; flex-grow: 1; gap: 0.5rem;">
                                <span style="font-size: 0.7rem; font-weight: 700; color: #64748b; text-transform: uppercase;">{{ \Carbon\Carbon::parse($item->published_at ?? $item->created_at)->translatedFormat('d M Y') }}</span>
                                <h4 style="color: #1e293b; font-weight: 800; font-size: 0.95rem; margin: 0; line-height: 1.4;">{{ $item->title }}</h4>
                                <p style="color: #64748b; font-size: 0.8rem; line-height: 1.5; margin: 0; flex-grow: 1;">{{ Str::limit(strip_tags($item->excerpt ?? $item->content), 80) }}</p>
                                <a href="{{ route('berita.show', $item->slug ?? $item->id) }}" style="color: #4f46e5; font-weight: 800; font-size: 0.85rem; text-decoration: none; margin-top: 0.5rem; display: inline-flex; align-items: center; gap: 0.25rem;">
                                    Baca &rarr;
                                </a>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: #94a3b8; font-size: 0.95rem;">
                            Belum ada artikel dengan kategori Kisah Inspiratif yang dipublikasikan.
                        </div>
                    @endforelse

                </div>

                <!-- Tombol Lihat Seluruh Kisah Inspiratif -->
                <div style="display: flex; justify-content: center; margin-top: 1.5rem;">
                    <a href="{{ route('berita.index', ['category' => 'Kisah Inspiratif']) }}" class="hover:bg-indigo-700 transition-colors" style="background: #4f46e5; color: white; padding: 0.75rem 2rem; border-radius: 9999px; font-weight: 800; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);">
                        Lihat Seluruh Kisah Inspiratif &rarr;
                    </a>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection

