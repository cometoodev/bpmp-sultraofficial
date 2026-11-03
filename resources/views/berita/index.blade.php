<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita &amp; Publikasi - BPMP Provinsi Sulawesi Tenggara</title>
    <meta name="description" content="Dapatkan informasi terkini seputar kebijakan pendidikan, kegiatan operasional, dan program penjaminan mutu dari BPMP Provinsi Sulawesi Tenggara.">
    <link rel="icon" href="{{ asset('tutwurihandayani.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased overflow-x-hidden">

    {{-- NAVBAR --}}
    <x-navbar :alwaysScrolled="true" />

    {{-- HERO HEADER (Sama Persis Master Template: Biru Solid & Teks Putih) --}}
    <div style="width: 100%; background-color: #1e3a8a; padding: 7rem 1.5rem 4.5rem 1.5rem; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
        
        <div style="max-width: 900px; width: 100%; display: flex; flex-direction: column; align-items: center; gap: 1rem;">
            
            <!-- Badge Kapsul Atas (Pusat Informasi Publik) -->
            <div style="background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.2); padding: 0.4rem 1.25rem; border-radius: 9999px; display: inline-flex; align-items: center; gap: 0.5rem; backdrop-filter: blur(8px);">
                <span style="width: 0.5rem; height: 0.5rem; border-radius: 50%; background: #60a5fa;"></span>
                <span style="color: white; font-weight: 700; font-size: 0.8rem; letter-spacing: 0.05em; text-transform: uppercase;">Pusat Informasi Publik</span>
            </div>

            <!-- Judul Utama (Putih Bersih & Ukuran Proporsional Master Template) -->
            <h1 style="color: white; font-weight: 900; font-size: clamp(2.25rem, 4vw, 3.25rem); margin: 0; letter-spacing: -0.02em; font-family: 'Plus Jakarta Sans', sans-serif;">
                Berita &amp; Publikasi BPMP
            </h1>

            <!-- Deskripsi Singkat (Putih Bersih) -->
            <p style="color: rgba(255, 255, 255, 0.9); font-size: 1.05rem; line-height: 1.6; max-width: 650px; margin: 0; font-weight: 400;">
                Dapatkan informasi terkini dari BPMP Provinsi Sulawesi Tenggara.
            </p>

            <!-- Breadcrumb Navigasi (Putih) -->
            <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; font-weight: 600; color: rgba(255, 255, 255, 0.8); margin-top: 0.75rem;">
                <a href="/" style="color: white; text-decoration: none;" class="hover:underline">Beranda</a>
                <span style="color: rgba(255, 255, 255, 0.5);">&#8250;</span>
                <span style="color: white;">Berita &amp; Publikasi</span>
            </div>

        </div>
    </div>

    {{-- FILTER & SEARCH BAR --}}
    <div class="sticky top-[64px] z-40 bg-white/80 backdrop-blur-xl border-b border-gray-200/60 shadow-sm" x-data="{ activeTab: '{{ request('category', request('kategori', 'semua')) }}' }">
        <div class="container mx-auto px-4 py-3">
            <div class="flex flex-col md:flex-row items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('berita.index') }}" :class="activeTab === 'semua' || activeTab === 'Semua Kategori' || activeTab === '' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all">Semua Kategori</a>
                    @if(isset($categories) && $categories->isNotEmpty())
                        @foreach($categories as $cat)
                            <a href="{{ route('berita.index', ['category' => $cat->slug]) }}" :class="activeTab === '{{ $cat->slug }}' || activeTab === '{{ $cat->name }}' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all whitespace-nowrap">{{ $cat->name }}</a>
                        @endforeach
                    @endif
                </div>
                <form method="GET" action="{{ route('berita.index') }}" class="relative w-full md:w-64">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @elseif(request('kategori'))
                        <input type="hidden" name="category" value="{{ request('kategori') }}">
                    @endif
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Ketik kata kunci..." class="w-full pl-9 pr-4 py-2 text-sm rounded-full bg-gray-100 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400/50 focus:bg-white transition-all">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <main class="container mx-auto px-4 py-12">
        <div class="flex items-center justify-between mb-8">
            @if(isset($posts) && $posts->total() > 0)
                <p class="text-sm text-gray-500 font-medium">Menampilkan <strong class="text-gray-800">{{ $posts->firstItem() }}</strong> sampai <strong class="text-gray-800">{{ $posts->lastItem() }}</strong> dari <strong class="text-gray-800">{{ $posts->total() }}</strong> berita</p>
            @endif
        </div>

        @if(isset($posts) && $posts->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-7">
                @foreach($posts as $post)
                <article class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                    <div class="relative overflow-hidden h-48">
                        <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <span class="absolute top-3 left-3 bg-blue-600 text-white text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-1 rounded-full">{{ $post->category->name ?? 'BERITA' }}</span>
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="flex items-center gap-1.5 text-xs text-gray-400 font-medium mb-2">
                            <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
                        </div>
                        <h2 class="font-bold text-gray-900 text-base leading-snug mb-3 group-hover:text-blue-700 transition-colors line-clamp-2">{{ $post->title }}</h2>
                        <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 flex-grow mb-4">{{ Str::limit(strip_tags($post->content), 140) }}</p>
                        <div class="pt-4 border-t border-gray-100 mt-auto">
                            <a href="{{ route('berita.show', $post->slug ?? $post->id) }}" class="text-blue-600 font-bold text-sm hover:text-blue-800 inline-flex items-center gap-1 group-hover:gap-2 transition-all">Baca &rarr;</a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            {{-- Kustomisasi Pagination Modern (Tanpa teks "Showing...", Berpusat di tengah dengan tombol Prev & Next) --}}
            @php
                $newsList = $newsList ?? ($posts ?? null);
            @endphp
            @if (isset($newsList) && $newsList->hasPages())
                <div style="width: 100%; display: flex; justify-content: center; align-items: center; gap: 0.5rem; margin-top: 3rem; margin-bottom: 2rem; flex-wrap: wrap;">
                    
                    {{-- Tombol Previous --}}
                    @if ($newsList->onFirstPage())
                        <span style="padding: 0.6rem 1.25rem; border-radius: 0.75rem; background: #f1f5f9; color: #94a3b8; font-size: 0.85rem; font-weight: 700; cursor: not-allowed; border: 1px solid #e2e8f0;">
                            &laquo; Previous
                        </span>
                    @else
                        <a href="{{ $newsList->previousPageUrl() }}" style="padding: 0.6rem 1.25rem; border-radius: 0.75rem; background: white; color: #475569; font-size: 0.85rem; font-weight: 700; text-decoration: none; border: 1px solid #cbd5e1; transition: all 0.2s;" class="hover:bg-slate-50 hover:text-indigo-600">
                            &laquo; Previous
                        </a>
                    @endif

                    {{-- Nomor Halaman --}}
                    @foreach ($newsList->getUrlRange(1, $newsList->lastPage()) as $pageNum => $url)
                        @if ($pageNum == $newsList->currentPage())
                            <span style="width: 2.5rem; height: 2.5rem; border-radius: 0.75rem; background: #4f46e5; color: white; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 800; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);">
                                {{ $pageNum }}
                            </span>
                        @else
                            <a href="{{ $url }}" style="width: 2.5rem; height: 2.5rem; border-radius: 0.75rem; background: white; color: #475569; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 700; text-decoration: none; border: 1px solid #cbd5e1; transition: all 0.2s;" class="hover:bg-slate-50 hover:text-indigo-600">
                                {{ $pageNum }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Tombol Next --}}
                    @if ($newsList->hasMorePages())
                        <a href="{{ $newsList->nextPageUrl() }}" style="padding: 0.6rem 1.25rem; border-radius: 0.75rem; background: white; color: #475569; font-size: 0.85rem; font-weight: 700; text-decoration: none; border: 1px solid #cbd5e1; transition: all 0.2s;" class="hover:bg-slate-50 hover:text-indigo-600">
                            Next &raquo;
                        </a>
                    @else
                        <span style="padding: 0.6rem 1.25rem; border-radius: 0.75rem; background: #f1f5f9; color: #94a3b8; font-size: 0.85rem; font-weight: 700; cursor: not-allowed; border: 1px solid #e2e8f0;">
                            Next &raquo;
                        </span>
                    @endif

                </div>
            @endif
        @elseif(request()->filled('category') || request()->filled('kategori') || request()->filled('q'))
            <div class="text-center py-16 bg-white rounded-3xl border border-gray-100 shadow-sm p-8 max-w-xl mx-auto">
                <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Belum ada berita ditemukan</h3>
                <p class="text-gray-500 text-sm max-w-md mx-auto mb-6">Artikel untuk kategori atau kata kunci pencarian yang Anda pilih belum tersedia atau sedang dalam proses penyusunan.</p>
                <a href="{{ route('berita.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-md">
                    <span>Lihat Semua Kategori</span>
                    <span>&rarr;</span>
                </a>
            </div>
        @else
            @php
            $articles = [
                ['id'=>1,'cat'=>'Berita Terkini','color'=>'bg-blue-600','title'=>'Sosialisasi Rapor Pendidikan 2026 di Kabupaten Konawe','date'=>'02 Okt 2026','excerpt'=>'KENDARI - BPMP Sultra menyelenggarakan kegiatan sosialisasi pemanfaatan Rapor Pendidikan untuk perencanaan berbasis data di tingkat daerah guna meningkatkan mutu...','img'=>'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&w=600&q=80'],
                ['id'=>2,'cat'=>'Program Prioritas','color'=>'bg-emerald-600','title'=>'Pendampingan Implementasi Kurikulum Merdeka di Sekolah Sasaran','date'=>'30 Sep 2026','excerpt'=>'KENDARI - Tim fasilitator BPMP Provinsi Sulawesi Tenggara melakukan pendampingan intensif bagi sekolah-sekolah sasaran IKM di wilayah kepulauan terluar...','img'=>'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=600&q=80'],
                ['id'=>3,'cat'=>'Dokumentasi','color'=>'bg-amber-500','title'=>'Kunjungan Kerja Tim Pusat ke BPMP Sultra','date'=>'30 Sep 2026','excerpt'=>'KENDARI - Menerima kunjungan tim dari kementerian pusat dalam rangka monitoring dan evaluasi penjaminan mutu pendidikan di Sulawesi Tenggara...','img'=>'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=600&q=80'],
                ['id'=>4,'cat'=>'Pengumuman','color'=>'bg-red-600','title'=>'Pengumuman Seleksi Fasilitator Sekolah Penggerak Angkatan IV','date'=>'29 Sep 2026','excerpt'=>'KENDARI - BPMP Provinsi Sulawesi Tenggara membuka pendaftaran seleksi fasilitator program Sekolah Penggerak angkatan keempat untuk tahun pelajaran 2026/2027...','img'=>'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=600&q=80'],
                ['id'=>5,'cat'=>'Artikel','color'=>'bg-purple-600','title'=>'Transformasi Pembelajaran: Refleksi Satu Tahun Kurikulum Merdeka','date'=>'28 Sep 2026','excerpt'=>'KENDARI - Satu tahun setelah implementasi penuh Kurikulum Merdeka, berbagai satuan pendidikan di Sulawesi Tenggara menunjukkan perkembangan signifikan...','img'=>'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=600&q=80'],
                ['id'=>6,'cat'=>'Program Prioritas','color'=>'bg-emerald-600','title'=>'Pelatihan Perencanaan Berbasis Data untuk Kepala Sekolah','date'=>'26 Sep 2026','excerpt'=>'KENDARI - BPMP Sultra menyelenggarakan pelatihan PBD bagi ratusan kepala sekolah dan pengawas dari 17 kabupaten/kota se-Sulawesi Tenggara...','img'=>'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=600&q=80'],
                ['id'=>7,'cat'=>'Berita Terkini','color'=>'bg-blue-600','title'=>'BPMP Sultra Raih Penghargaan ZI WBK dari Kemendikdasmen','date'=>'25 Sep 2026','excerpt'=>'KENDARI - BPMP Provinsi Sulawesi Tenggara kembali berhasil mempertahankan predikat Wilayah Bebas dari Korupsi dalam penilaian zona integritas tahun 2026...','img'=>'https://images.unsplash.com/photo-1531545514256-b1400bc00f31?auto=format&fit=crop&w=600&q=80'],
                ['id'=>8,'cat'=>'Dokumentasi','color'=>'bg-amber-500','title'=>'Galeri Kegiatan Bulan September 2026','date'=>'24 Sep 2026','excerpt'=>'KENDARI - Dokumentasi berbagai kegiatan BPMP Provinsi Sulawesi Tenggara selama bulan September 2026, mulai dari pendampingan sekolah hingga rapat koordinasi daerah...','img'=>'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=600&q=80'],
                ['id'=>9,'cat'=>'Artikel','color'=>'bg-purple-600','title'=>'Pentingnya Data Dalam Pengambilan Keputusan Pendidikan','date'=>'22 Sep 2026','excerpt'=>'KENDARI - Pemanfaatan data pendidikan secara akurat merupakan kunci keberhasilan dalam merumuskan kebijakan yang tepat sasaran dan berdampak nyata bagi peserta didik...','img'=>'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=600&q=80'],
            ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-7">
                @foreach($articles as $a)
                <article class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                    <div class="relative overflow-hidden h-48">
                        <img src="{{ $a['img'] }}" alt="{{ $a['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <span class="absolute top-3 left-3 {{ $a['color'] }} text-white text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-1 rounded-full">{{ $a['cat'] }}</span>
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="flex items-center gap-1.5 text-xs text-gray-400 font-medium mb-2">
                            <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $a['date'] }}
                        </div>
                        <h2 class="font-bold text-gray-900 text-base leading-snug mb-3 group-hover:text-blue-700 transition-colors line-clamp-2">{{ $a['title'] }}</h2>
                        <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 flex-grow mb-4">{{ $a['excerpt'] }}</p>
                        <div class="pt-4 border-t border-gray-100 mt-auto">
                            <a href="/berita/{{ $a['id'] }}" class="text-blue-600 font-bold text-sm hover:text-blue-800 inline-flex items-center gap-1 group-hover:gap-2 transition-all">Baca &rarr;</a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            {{-- Fallback Pagination --}}
            <div style="width: 100%; display: flex; justify-content: center; align-items: center; gap: 0.5rem; margin-top: 3rem; margin-bottom: 2rem; flex-wrap: wrap;">
                <span style="padding: 0.6rem 1.25rem; border-radius: 0.75rem; background: #f1f5f9; color: #94a3b8; font-size: 0.85rem; font-weight: 700; cursor: not-allowed; border: 1px solid #e2e8f0;">
                    &laquo; Previous
                </span>
                <span style="width: 2.5rem; height: 2.5rem; border-radius: 0.75rem; background: #4f46e5; color: white; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 800; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);">
                    1
                </span>
                <button type="button" style="width: 2.5rem; height: 2.5rem; border-radius: 0.75rem; background: white; color: #475569; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 700; border: 1px solid #cbd5e1; cursor: pointer;">
                    2
                </button>
                <button type="button" style="width: 2.5rem; height: 2.5rem; border-radius: 0.75rem; background: white; color: #475569; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 700; border: 1px solid #cbd5e1; cursor: pointer;">
                    3
                </button>
                <button type="button" style="padding: 0.6rem 1.25rem; border-radius: 0.75rem; background: white; color: #475569; font-size: 0.85rem; font-weight: 700; border: 1px solid #cbd5e1; cursor: pointer;">
                    Next &raquo;
                </button>
            </div>
        @endif
    </main>

    {{-- GLOBAL FOOTER --}}
    <x-footer />


    
    
    <x-accessibility />
</body>
</html>
