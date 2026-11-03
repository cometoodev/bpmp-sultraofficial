@extends('layouts.app')

@section('title', 'Events & Webinar - BPMP Provinsi Sulawesi Tenggara')
@section('meta_description', 'Jadwal dan informasi lengkap sesi daring serta kegiatan luring pengembangan kompetensi pendidikan di lingkungan BPMP Sulawesi Tenggara.')

@section('content')
<!-- HEADER UNIVERSAL (BIRU SOLID / BG-BLUE-900) -->
<div class="relative pt-28 pb-36 overflow-hidden bg-blue-900">
    <div class="relative z-10 text-center px-4 max-w-4xl mx-auto flex flex-col items-center">
        <!-- Badge Kategori / Label -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-white font-extrabold text-[10px] sm:text-xs uppercase tracking-widest shadow-sm mb-6">
            <div class="w-2 h-2 rounded-full bg-blue-400"></div>
            Pusat Informasi &amp; Kegiatan
        </div>

        <!-- Judul Halaman -->
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            Events &amp; Webinar
        </h1>

        <!-- Deskripsi Singkat -->
        <p class="text-blue-100/90 text-sm sm:text-base max-w-2xl leading-relaxed mb-6 font-medium">
            Ikuti berbagai agenda webinar daring dan kegiatan luring resmi dalam rangka akselerasi mutu pendidikan di Bumi Anoa.
        </p>

        <!-- Breadcrumbs -->
        <div class="flex items-center justify-center gap-2 text-xs sm:text-sm font-medium text-blue-200">
            <a href="/" class="hover:text-white transition-colors">Beranda</a>
            <span class="text-blue-400/60">›</span>
            <span class="text-white font-semibold">Events &amp; Webinar</span>
        </div>
    </div>
</div>

<!-- KONTEN UTAMA DENGAN SEARCH & FILTER -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20 pb-24">
    <!-- Card Filter & Pencarian -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/50 border border-slate-100 mb-12">
        <form method="GET" action="{{ route('events.index') }}" class="flex flex-col md:flex-row items-center justify-between gap-5">
            <!-- Input Cari -->
            <div class="relative w-full md:w-96">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul kegiatan atau penyelenggara..."
                       class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 placeholder:text-slate-400 placeholder:font-normal focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none transition-all">
                <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            <!-- Filter Kategori Tabs -->
            <div class="flex items-center gap-2 p-1.5 bg-slate-100 rounded-2xl w-full md:w-auto overflow-x-auto">
                <a href="{{ route('events.index', array_filter(['search' => request('search')])) }}"
                   class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all whitespace-nowrap {{ !request('type') ? 'bg-white text-indigo-700 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                    Semua ({{ \App\Models\Event::count() }})
                </a>
                <a href="{{ route('events.index', array_filter(['type' => 'Webinar', 'search' => request('search')])) }}"
                   class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all whitespace-nowrap {{ request('type') === 'Webinar' ? 'bg-white text-indigo-700 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                    🎥 Webinar
                </a>
                <a href="{{ route('events.index', array_filter(['type' => 'Event', 'search' => request('search')])) }}"
                   class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all whitespace-nowrap {{ request('type') === 'Event' ? 'bg-white text-indigo-700 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                    🏛️ Event Luring
                </a>
            </div>
        </form>
    </div>

    <!-- Grid Kartu Events & Webinar (2 Kolom x 3 Baris = 6 per Halaman, Horizontal Card) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-7">
        @forelse($events as $item)
            <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-200/80 flex flex-col sm:flex-row items-center gap-5 sm:gap-6 group">
                
                <!-- Kiri: Gambar Poster -->
                <div class="w-full sm:w-44 h-48 sm:h-52 rounded-2xl overflow-hidden bg-slate-100 shrink-0 shadow-sm">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.src='https://via.placeholder.com/400x500/e2e8f0/475569?text=Event'">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-indigo-500/10 via-blue-500/10 to-purple-500/10 flex flex-col items-center justify-center p-3 text-center">
                            <div class="w-10 h-10 rounded-xl bg-indigo-600/10 text-indigo-600 flex items-center justify-center mb-1.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            </div>
                            <span class="text-[11px] font-extrabold text-indigo-900 line-clamp-2">{{ $item->title }}</span>
                        </div>
                    @endif
                </div>

                <!-- Kanan: Detail Teks -->
                <div class="flex-1 w-full flex flex-col gap-3 min-w-0">
                    <!-- Badges Kategori & Status -->
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-extrabold uppercase tracking-wider bg-indigo-50 text-indigo-700">
                            {{ $item->type }}
                        </span>
                        @php $status = $item->status; @endphp
                        <span class="px-2.5 py-1 rounded-lg text-xs font-extrabold uppercase tracking-wider {{ $status === 'Selesai' ? 'bg-slate-100 text-slate-500' : 'bg-emerald-50 text-emerald-700' }}">
                            {{ $status }}
                        </span>
                    </div>

                    <!-- Tanggal WITA -->
                    <div class="flex items-center gap-1.5 text-xs font-semibold text-slate-500">
                        <span>📅</span>
                        <span>{{ \Carbon\Carbon::parse($item->event_date)->translatedFormat('d M Y, H:i') }} WITA</span>
                    </div>

                    <!-- Judul Acara -->
                    <h3 class="font-black text-slate-900 text-base sm:text-lg leading-snug line-clamp-2 group-hover:text-blue-600 transition-colors m-0">
                        {{ $item->title }}
                    </h3>

                    <!-- Penyelenggara -->
                    <p class="text-xs text-slate-500 font-semibold m-0 truncate">
                        🏢 Penyelenggara: <strong class="text-slate-800">{{ $item->organizer }}</strong>
                    </p>

                    <!-- Tombol Info Selengkapnya -->
                    <div class="mt-2">
                        <a href="{{ $item->instagram_url }}" target="_blank" rel="noopener noreferrer"
                           class="hover:bg-blue-700 transition-all duration-300 shadow-md shadow-blue-600/20"
                           style="background: #0284c7; color: white; padding: 0.6rem 1.1rem; border-radius: 0.85rem; font-weight: 700; font-size: 0.8rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem;">
                            <svg style="width: 0.95rem; height: 0.95rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Info selengkapnya &rarr;</span>
                        </a>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full text-center py-16 bg-white rounded-3xl border border-dashed border-slate-200 p-8">
                <div class="w-14 h-14 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </div>
                <h4 class="font-extrabold text-slate-800 text-base mb-1">Belum Ada Agenda Ditemukan</h4>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">Tidak ada jadwal webinar atau kegiatan yang cocok dengan kriteria pencarian Anda.</p>
                @if(request('search') || request('type'))
                    <a href="{{ route('events.index') }}" class="mt-4 inline-block text-xs font-bold text-indigo-600 hover:underline">
                        &larr; Reset Filter
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    <!-- KUSTOMISASI PAGINASI BERSIH (Tanpa Teks Previous/Next & Tanpa Showing...) -->
    @if ($events->hasPages())
        <div style="width: 100%; display: flex; justify-content: center; align-items: center; gap: 0.5rem; margin-top: 3rem; margin-bottom: 2rem;">
            
            {{-- Tombol Panah Kiri (Previous Page) --}}
            @if ($events->onFirstPage())
                <span style="width: 2.5rem; height: 2.5rem; border-radius: 0.75rem; background: #f1f5f9; color: #94a3b8; display: flex; align-items: center; justify-content: center; cursor: not-allowed; border: 1px solid #e2e8f0; font-size: 1.25rem; line-height: 1;">
                    &lsaquo;
                </span>
            @else
                <a href="{{ $events->previousPageUrl() }}" style="width: 2.5rem; height: 2.5rem; border-radius: 0.75rem; background: white; color: #475569; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid #cbd5e1; transition: all 0.2s; font-size: 1.25rem; line-height: 1;" class="hover:bg-slate-50 hover:text-indigo-600">
                    &lsaquo;
                </a>
            @endif

            {{-- Nomor Halaman --}}
            @foreach ($events->getUrlRange(1, $events->lastPage()) as $pageNum => $url)
                @if ($pageNum == $events->currentPage())
                    <span style="width: 2.5rem; height: 2.5rem; border-radius: 0.75rem; background: #4f46e5; color: white; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 800; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);">
                        {{ $pageNum }}
                    </span>
                @else
                    <a href="{{ $url }}" style="width: 2.5rem; height: 2.5rem; border-radius: 0.75rem; background: white; color: #475569; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 700; text-decoration: none; border: 1px solid #cbd5e1; transition: all 0.2s;" class="hover:bg-slate-50 hover:text-indigo-600">
                        {{ $pageNum }}
                    </a>
                @endif
            @endforeach

            {{-- Tombol Panah Kanan (Next Page) --}}
            @if ($events->hasMorePages())
                <a href="{{ $events->nextPageUrl() }}" style="width: 2.5rem; height: 2.5rem; border-radius: 0.75rem; background: white; color: #475569; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid #cbd5e1; transition: all 0.2s; font-size: 1.25rem; line-height: 1;" class="hover:bg-slate-50 hover:text-indigo-600">
                    &rsaquo;
                </a>
            @else
                <span style="width: 2.5rem; height: 2.5rem; border-radius: 0.75rem; background: #f1f5f9; color: #94a3b8; display: flex; align-items: center; justify-content: center; cursor: not-allowed; border: 1px solid #e2e8f0; font-size: 1.25rem; line-height: 1;">
                    &rsaquo;
                </span>
            @endif

        </div>
    @endif
</div>
@endsection

