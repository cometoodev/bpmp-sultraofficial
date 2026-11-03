@extends('layouts.admin')

@section('title', 'Dashboard Analitik SKM ULT')
@section('header_title', 'Dashboard Analitik SKM ULT')
@section('header_subtitle', 'Analisis mutu dan kepuasan masyarakat terhadap layanan BPMP')

@section('content')
<div class="space-y-6">

    <!-- Kop Surat Resmi (Hanya Muncul Saat Print Halaman) -->
    <div class="hidden print:block mb-6 text-center border-b-2 border-slate-900 pb-3">
        <h2 class="text-base font-bold uppercase text-slate-900 tracking-wide">KEMENTERIAN PENDIDIKAN DASAR DAN MENENGAH</h2>
        <h3 class="text-sm font-bold uppercase text-slate-900">BALAI PENJAMINAN MUTU PENDIDIKAN PROVINSI SULAWESI TENGGARA</h3>
        <p class="text-[11px] text-slate-600 mt-0.5">Jl. R.E. Martadinata No. 1, Mandonga, Kendari, Sulawesi Tenggara 93111 | Surel: bpmp.sultra@kemdikbud.go.id</p>
        <div class="mt-2 pt-2 border-t border-slate-400">
            <h4 class="text-xs font-bold uppercase text-slate-900">LAPORAN HASIL PENGUKURAN SURVEI KEPUASAN MASYARAKAT (SKM)</h4>
            <p class="text-[10px] text-slate-500">Unit Layanan Terpadu (ULT) &bull; Dicetak pada: {{ now()->locale('id')->translatedFormat('l, d F Y H:i') }} WITA</p>
        </div>
    </div>

    <!-- Notification Messages -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs font-semibold flex items-center justify-between gap-3 shadow-xs">
            <div class="flex items-center gap-2.5">
                <div class="w-6 h-6 rounded-lg bg-emerald-500 text-white flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200/80 text-rose-800 text-xs font-semibold flex items-center justify-between gap-3 shadow-xs">
            <div class="flex items-center gap-2.5">
                <div class="w-6 h-6 rounded-lg bg-rose-500 text-white flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    {{-- ================================================================ --}}
    {{-- 1. HERO BANNER (Paling Atas)                                       --}}
    {{-- ================================================================ --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-800 to-blue-700 p-6 sm:p-8 text-white shadow-lg print:hidden mb-6">
        <div class="absolute -right-16 -bottom-16 w-64 h-64 bg-sky-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-0 left-1/3 w-40 h-40 bg-indigo-500/20 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-xs font-bold text-sky-200 border border-white/15 mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span>Permenpan RB No. 14 Tahun 2017 &bull; Real-Time Analytics</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight font-heading leading-tight">
                    Dashboard Analitik SKM<br>
                    <span class="text-sky-300">Unit Layanan Terpadu (ULT)</span>
                </h1>
                <p class="text-xs sm:text-sm text-sky-100/70 mt-2 max-w-2xl leading-relaxed">
                    Indeks Kepuasan Masyarakat berbasis data Buku Tamu digital dan Kuisioner Pelayanan ULT BPMP Provinsi Sulawesi Tenggara.
                </p>
            </div>

            {{-- IKM Score Highlight --}}
            <div class="flex items-center gap-4">
                <div class="text-center bg-white/10 backdrop-blur-md border border-white/15 rounded-3xl p-5 min-w-[160px]">
                    <span class="text-5xl font-black text-white font-heading block leading-none">
                        {{ number_format($nilai_konversi ?? $totalIkm, 2) }}
                    </span>
                    <span class="text-xs text-sky-200/90 font-semibold uppercase tracking-wider block mt-1">Nilai IKM Konversi</span>
                    <div class="mt-2 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold
                        {{ ($mutu ?? $mutuLayanan['grade']) === 'A' ? 'bg-emerald-400/20 text-emerald-200 border border-emerald-400/30' :
                           (($mutu ?? $mutuLayanan['grade']) === 'B' ? 'bg-blue-400/20 text-blue-200 border border-blue-400/30' :
                           (($mutu ?? $mutuLayanan['grade']) === 'C' ? 'bg-amber-400/20 text-amber-200 border border-amber-400/30' :
                           'bg-rose-400/20 text-rose-200 border border-rose-400/30')) }}">
                        <span class="text-base">{{ ($mutu ?? $mutuLayanan['grade']) === 'A' ? '🏆' : (($mutu ?? $mutuLayanan['grade']) === 'B' ? '👍' : (($mutu ?? $mutuLayanan['grade']) === 'C' ? '⚠️' : '🔴')) }}</span>
                        <span>Mutu {{ $mutu ?? $mutuLayanan['grade'] }} — {{ $kinerja ?? $mutuLayanan['label'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- 2. FILTER BAR (UI Glassmorphism)                                   --}}
    {{-- ================================================================ --}}
    <form method="GET" action="{{ route('admin.skm.dashboard') }}" class="bg-white/40 backdrop-blur-md border border-white/50 p-4 rounded-xl flex flex-wrap gap-4 items-end mb-6 shadow-sm print:hidden">
        <!-- Select Tahun -->
        <div class="flex-1 min-w-[130px]">
            <label for="filter_skm_tahun" class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Tahun</span>
            </label>
            <select name="tahun" id="filter_skm_tahun" class="w-full text-xs font-semibold bg-white/80 border border-slate-200/90 rounded-xl px-3 py-2 text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-all shadow-2xs">
                <option value="all" {{ ($tahun === null || $tahun === 'all') ? 'selected' : '' }}>Semua Tahun</option>
                @foreach($availableYears as $year)
                    <option value="{{ $year }}" {{ ((string) $tahun === (string) $year) ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
        </div>

        <!-- Select Triwulan -->
        <div class="flex-1 min-w-[160px]">
            <label for="filter_skm_triwulan" class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                <span>Triwulan</span>
            </label>
            <select name="triwulan" id="filter_skm_triwulan" class="w-full text-xs font-semibold bg-white/80 border border-slate-200/90 rounded-xl px-3 py-2 text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-all shadow-2xs">
                <option value="" {{ empty($triwulan) ? 'selected' : '' }}>Semua Triwulan</option>
                <option value="1" {{ (string) $triwulan === '1' ? 'selected' : '' }}>Triwulan 1 (Jan - Mar)</option>
                <option value="2" {{ (string) $triwulan === '2' ? 'selected' : '' }}>Triwulan 2 (Apr - Jun)</option>
                <option value="3" {{ (string) $triwulan === '3' ? 'selected' : '' }}>Triwulan 3 (Jul - Sep)</option>
                <option value="4" {{ (string) $triwulan === '4' ? 'selected' : '' }}>Triwulan 4 (Okt - Des)</option>
            </select>
        </div>

        <!-- Select Jenis Layanan -->
        <div class="flex-2 min-w-[220px]">
            <label for="filter_skm_layanan" class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <span>Jenis Layanan</span>
            </label>
            <select name="layanan" id="filter_skm_layanan" class="w-full text-xs font-semibold bg-white/80 border border-slate-200/90 rounded-xl px-3 py-2 text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-all shadow-2xs">
                <option value="" {{ empty($layanan) ? 'selected' : '' }}>Semua Jenis Layanan</option>
                @php
                    $standardServices = [
                        'Konsultasi & Advokasi Program Prioritas Kemendikdasmen',
                        'Layanan Data Pokok Pendidikan (Dapodik) & PDM',
                        'Penjaminan Mutu & Rekomendasi Rapor Pendidikan',
                        'Penerbitan Rekomendasi / Keterangan Dinas',
                        'Pemanfaatan Sarana, Prasarana & Fasilitas Diklat',
                        'Informasi Publik & Penanganan Pengaduan Layanan',
                        'Koordinasi / Audiensi Kedinasan',
                        'Keperluan Lain',
                    ];
                    $allServices = collect(array_merge($standardServices, $availableServices))->unique()->values();
                @endphp
                @foreach($allServices as $svc)
                    <option value="{{ $svc }}" {{ $layanan === $svc ? 'selected' : '' }}>{{ $svc }}</option>
                @endforeach
            </select>
        </div>

        <!-- Select Tampil Data (Per Page) -->
        <div class="w-28 min-w-[110px]">
            <label for="filter_skm_per_page" class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                <span>Tampil</span>
            </label>
            <select name="per_page" id="filter_skm_per_page" onchange="this.form.submit()" class="w-full text-xs font-semibold bg-white/80 border border-slate-200/90 rounded-xl px-3 py-2 text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-all shadow-2xs cursor-pointer">
                <option value="10" {{ (string) request('per_page', $perPage ?? 10) === '10' ? 'selected' : '' }}>10 Data</option>
                <option value="25" {{ (string) request('per_page', $perPage ?? 10) === '25' ? 'selected' : '' }}>25 Data</option>
                <option value="50" {{ (string) request('per_page', $perPage ?? 10) === '50' ? 'selected' : '' }}>50 Data</option>
                <option value="100" {{ (string) request('per_page', $perPage ?? 10) === '100' ? 'selected' : '' }}>100 Data</option>
                <option value="all" {{ request('per_page') === 'all' ? 'selected' : '' }}>Tampil Semua Data</option>
            </select>
        </div>

        <!-- Input Pencarian -->
        <div class="flex-1 min-w-[200px]">
            <label for="filter_skm_search" class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <span>Pencarian</span>
            </label>
            <input type="text"
                   name="search"
                   id="filter_skm_search"
                   value="{{ request('search') }}"
                   placeholder="Cari nama, instansi, atau layanan..."
                   class="bg-white/50 border border-gray-200 rounded-lg px-4 py-2 w-full md:w-64 focus:ring-2 focus:ring-blue-400 outline-none text-xs font-medium text-slate-800 placeholder-slate-400">
        </div>

        <!-- Tombol Filter & Reset -->
        <div class="flex items-center gap-2">
            <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 active:scale-95 transition-all shadow-sm shadow-blue-500/25 flex items-center gap-1.5 cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                <span>Terapkan Filter</span>
            </button>
            <a href="{{ route('admin.skm.dashboard') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-700 bg-slate-200/90 hover:bg-slate-300 active:scale-95 transition-all shadow-2xs flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                <span>Reset</span>
            </a>
        </div>
    </form>

    {{-- ================================================================ --}}
    {{-- 3. EKSPOR, IMPOR & CETAK LAPORAN SKM (Toolbar Aksi)                --}}
    {{-- ================================================================ --}}
    <div x-data="{ importModalOpen: false, showDuplicateModal: false, showLog: false, resetConfirmOpen: false, undoConfirmOpen: false, undoBatchId: '' }" class="mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex flex-wrap items-center justify-between gap-3 print:hidden">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-purple-600 text-white flex items-center justify-center shadow-md shadow-indigo-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900 font-heading">Ekspor, Impor &amp; Cetak Laporan SKM</h3>
                    <p class="text-[11px] text-slate-500">
                        Unduh atau impor hasil analisis kepuasan masyarakat ULT sesuai filter yang sedang aktif
                        @if($tahun || $triwulan || $layanan)
                            <span class="inline-flex items-center gap-1 text-indigo-600 font-bold ml-1">
                                (Tahun: {{ $tahun ?? 'Semua' }}{{ $triwulan ? ', TW '.$triwulan : '' }}{{ $layanan ? ', '.Str::limit($layanan, 20) : '' }})
                            </span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <!-- Tombol Import Data (Ungu/Indigo) -->
                <button type="button"
                        @click="importModalOpen = true"
                        class="h-10 px-4 py-2 inline-flex items-center justify-center gap-2 text-xs sm:text-sm font-semibold rounded-lg border border-indigo-200 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition-colors shadow-xs cursor-pointer"
                        title="Import Data Buku Tamu & SKM dari Excel/CSV">
                    <svg class="w-4 h-4 text-indigo-600 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    <span>Import Data</span>
                </button>

                <!-- Dropdown Export Laporan (Glassmorphism) -->
                <div x-data="{ openExport: false }" class="relative inline-block print:hidden">
                    <button type="button" @click="openExport = !openExport" @click.away="openExport = false" class="h-10 px-4 py-2 inline-flex items-center justify-center gap-2 text-xs sm:text-sm font-semibold rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition-colors shadow-xs cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        <span>Export Laporan ▾</span>
                    </button>
                    <div x-show="openExport"
                         x-cloak
                         style="display: none;"
                         x-transition
                         class="absolute right-0 mt-2 w-48 bg-white/95 backdrop-blur-lg border border-slate-200 rounded-xl shadow-xl z-50 overflow-hidden divide-y divide-slate-100">
                        <a href="{{ route('admin.skm.export', array_merge(request()->query(), ['type' => 'excel'])) }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span>Export Excel (.xlsx)</span>
                        </a>
                        <a href="{{ route('admin.skm.export', array_merge(request()->query(), ['type' => 'csv'])) }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-sky-50 hover:text-sky-700 transition-colors">
                            <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                            <span>Export CSV (.csv)</span>
                        </a>
                        <a href="{{ route('admin.skm.export', array_merge(request()->query(), ['type' => 'pdf'])) }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-rose-50 hover:text-rose-700 transition-colors">
                            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            <span>Export PDF (.pdf)</span>
                        </a>
                    </div>
                </div>

                <!-- Tombol Log Import -->
                <button type="button"
                        @click="showLog = true"
                        class="h-10 px-4 py-2 inline-flex items-center justify-center gap-2 text-xs sm:text-sm font-semibold rounded-lg border border-slate-200 bg-slate-50 text-slate-700 hover:bg-slate-100 transition-colors shadow-xs cursor-pointer"
                        title="Lihat Riwayat &amp; Undo Import Data">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Log Import</span>
                    @if(isset($importLogs) && $importLogs->count() > 0)
                        <span class="px-1.5 py-0.5 bg-slate-200 text-slate-800 rounded-full text-[10px] font-bold">{{ $importLogs->count() }}</span>
                    @endif
                </button>

                <!-- Tombol Cek Duplikat (Amber/Kuning) -->
                <button type="button"
                        @click="showDuplicateModal = true"
                        class="h-10 px-4 py-2 inline-flex items-center justify-center gap-2 text-xs sm:text-sm font-semibold rounded-lg border border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100 transition-colors shadow-xs cursor-pointer"
                        title="Deteksi dan Bersihkan Data Duplikat">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span>Cek Duplikat</span>
                    @if(isset($duplicateCount) && $duplicateCount > 0)
                        <span class="px-1.5 py-0.5 bg-amber-200 text-amber-800 rounded-full text-[10px] font-bold">{{ $duplicateCount }}</span>
                    @endif
                </button>

                <!-- Reset Semua Data (Tombol Merah) -->
                <button type="button"
                        @click="resetConfirmOpen = true"
                        class="h-10 px-4 py-2 inline-flex items-center justify-center gap-2 text-xs sm:text-sm font-semibold rounded-lg border border-red-200 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors shadow-xs cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    <span>Reset Semua Data</span>
                </button>
            </div>
        </div>

        <!-- Modal Import Data (Alpine.js Teleport) -->
        <template x-teleport="body">
            <div x-show="importModalOpen"
                 x-cloak
                 style="display: none;"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-[9999] overflow-y-auto bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4 print:hidden">

                <div @click.away="importModalOpen = false"
                     x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200 transform"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="relative w-full max-w-lg bg-white/80 backdrop-blur-xl border border-white/60 shadow-2xl rounded-3xl p-6 sm:p-7 text-left overflow-hidden">

                    <!-- Modal Header -->
                    <div class="flex items-center justify-between pb-4 border-b border-slate-200/80 mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-indigo-500/10 text-indigo-600 flex items-center justify-center border border-indigo-500/20 shadow-xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900 font-heading">Import Data Excel / CSV</h3>
                                <p class="text-[11px] text-slate-500">Unggah file data buku tamu dan kuisioner survei SKM ULT</p>
                            </div>
                        </div>
                        <button type="button" @click="importModalOpen = false" class="text-slate-400 hover:text-slate-700 p-1.5 rounded-xl hover:bg-slate-100 transition-colors cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Modal Body / Form -->
                    <form action="{{ route('admin.skm.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-200/80">
                            <label class="block text-xs font-bold text-slate-700 mb-2">Pilih File Spreadsheet</label>
                            <input type="file"
                                   name="file_excel"
                                   required
                                   accept=".xlsx,.csv,.xls"
                                   class="block w-full text-xs text-slate-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 file:cursor-pointer file:transition-all cursor-pointer">
                            <p class="text-[11px] text-slate-400 mt-2">Mendukung format <code>.xlsx</code> dan <code>.csv</code> (maksimal 10 MB).</p>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-blue-50/70 border border-blue-200/70 text-blue-800 text-[11px] space-y-1">
                            <div class="font-bold flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Format Kolom yang Didukung:</span>
                            </div>
                            <p class="text-blue-700 leading-relaxed">
                                <code>nama</code>, <code>jenis_kelamin</code> (L/P), <code>usia</code>, <code>telepon</code>, <code>pendidikan</code>, <code>pekerjaan</code>, <code>status_kepegawaian</code>, <code>asal_instansi</code>, <code>asal_kabupaten</code>, <code>jenis_layanan</code>, <code>q1</code> &ndash; <code>q9</code> (nilai 1-4), dan <code>saran</code>.
                            </p>
                        </div>

                        <!-- Modal Actions -->
                        <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-200/80">
                            <button type="button" @click="importModalOpen = false" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 active:scale-95 shadow-md shadow-indigo-500/25 transition-all flex items-center gap-2 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <span>Upload &amp; Proses</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <!-- Modal Pop-up Riwayat Import Data (Alpine.js Teleport) -->
        <template x-teleport="body">
            <div x-show="showLog"
                 x-cloak
                 style="display: none;"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-[9999] overflow-y-auto bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4 print:hidden">

                <div @click.away="showLog = false"
                     x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200 transform"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="relative w-full max-w-3xl bg-white/80 backdrop-blur-xl border border-white/60 shadow-2xl rounded-3xl p-6 sm:p-7 text-left overflow-hidden">

                    <!-- Header Modal -->
                    <div class="flex items-center justify-between pb-4 border-b border-slate-200/80 mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-slate-500/10 text-slate-700 flex items-center justify-center border border-slate-500/20 shadow-xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900 font-heading">Riwayat Import Data (Batch Log)</h3>
                                <p class="text-[11px] text-slate-500">Daftar sesi import Excel/CSV buku tamu &amp; survei SKM. Anda dapat membatalkan (undo) per sesi.</p>
                            </div>
                        </div>
                        <button type="button" @click="showLog = false" class="text-slate-400 hover:text-slate-700 p-1.5 rounded-xl hover:bg-slate-100 transition-colors cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Tabel Riwayat Log Import -->
                    <div class="overflow-x-auto rounded-2xl border border-slate-200/80 bg-white/60">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="bg-slate-50/80 border-b border-slate-200/80 text-slate-700 font-bold uppercase tracking-wider text-[11px]">
                                    <th class="py-3 px-4">Batch ID</th>
                                    <th class="py-3 px-4">Waktu Import</th>
                                    <th class="py-3 px-4 text-center">Jumlah Data</th>
                                    <th class="py-3 px-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($importLogs as $log)
                                    <tr class="hover:bg-slate-50/70 transition-colors">
                                        <td class="py-3 px-4 font-mono font-bold text-indigo-700 text-xs">
                                            {{ $log->import_batch_id }}
                                        </td>
                                        <td class="py-3 px-4 text-slate-600">
                                            {{ \Carbon\Carbon::parse($log->import_time)->locale('id')->translatedFormat('d M Y, H:i') }} WITA
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                                {{ number_format($log->total) }} Data
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            <button type="button"
                                                    @click="undoBatchId = '{{ $log->import_batch_id }}'; undoConfirmOpen = true"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-lg border border-red-200 font-semibold text-xs transition-colors duration-200 cursor-pointer"
                                                    title="Batalkan & Hapus Data Sesi Ini">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                <span>Undo / Hapus</span>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-slate-400">
                                            <div class="flex flex-col items-center justify-center gap-2">
                                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                <p class="text-xs font-medium text-slate-500">Belum ada riwayat sesi import data.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Modal Footer -->
                    <div class="mt-5 flex justify-end">
                        <button type="button" @click="showLog = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors cursor-pointer">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </template>

        <!-- Modal Konfirmasi Undo Import (Custom Glassmorphism Teleport) -->
        <template x-teleport="body">
            <div x-show="undoConfirmOpen"
                 x-cloak
                 style="display: none;"
                 class="fixed inset-0 z-[10000] overflow-y-auto bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4 print:hidden"
                 @keydown.escape.window="undoConfirmOpen = false">
                <div class="fixed inset-0" @click="undoConfirmOpen = false"></div>
                <div class="relative w-full max-w-md bg-white/80 backdrop-blur-xl border border-white/60 shadow-2xl rounded-3xl p-6 sm:p-7 text-left z-10" @click.stop>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center border border-rose-200 shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900 font-heading">Batalkan Sesi Import</h3>
                            <p class="text-[11px] text-slate-500 font-mono font-semibold" x-text="undoBatchId"></p>
                        </div>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-rose-50/80 border border-rose-200/80 text-rose-800 text-xs leading-relaxed mb-6">
                        Yakin ingin membatalkan sesi import ini? Seluruh data pengunjung buku tamu dan kuisioner SKM yang terkait dengan batch ini akan dihapus secara permanen.
                    </div>
                    <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-200/80">
                        <button type="button" @click="undoConfirmOpen = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors cursor-pointer">
                            Batal
                        </button>
                        <form action="{{ route('admin.skm.undo-import') }}" method="POST">
                            @csrf
                            <input type="hidden" name="import_batch_id" :value="undoBatchId">
                            <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 active:scale-95 shadow-md shadow-rose-500/25 transition-all flex items-center gap-2 cursor-pointer">
                                <span>Ya, Hapus Batch Ini</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </template>

        <!-- Modal Cek & Hapus Duplikat (Alpine.js Teleport) -->
        <template x-teleport="body">
            <div x-show="showDuplicateModal"
                 x-cloak
                 style="display: none;"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-[9999] overflow-y-auto bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4 print:hidden">

                <div @click.away="showDuplicateModal = false"
                     x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200 transform"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="relative w-full max-w-md bg-white/80 backdrop-blur-xl border border-white/60 shadow-2xl rounded-3xl p-6 sm:p-7 text-left overflow-hidden">

                    <!-- Modal Header -->
                    <div class="flex items-center justify-between pb-4 border-b border-slate-200/80 mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center border border-amber-500/20 shadow-xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900 font-heading">Deteksi Data Duplikat</h3>
                                <p class="text-[11px] text-slate-500">Pemeriksaan integritas data pengunjung &amp; survei</p>
                            </div>
                        </div>
                        <button type="button" @click="showDuplicateModal = false" class="text-slate-400 hover:text-slate-700 p-1.5 rounded-xl hover:bg-slate-100 transition-colors cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="space-y-4">
                        @if(isset($duplicateCount) && $duplicateCount > 0)
                            <div class="p-4 bg-amber-50 text-amber-800 rounded-2xl border border-amber-200/80 text-xs">
                                Terdeteksi <strong>{{ $duplicateCount }}</strong> data ganda (duplikat) di dalam sistem. Baris data yang sama telah ditandai dengan warna merah muda pada tabel.
                            </div>
                            <form action="{{ route('admin.skm.clean-duplicates') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2.5 bg-amber-500 hover:bg-amber-600 active:scale-95 text-white font-semibold rounded-xl text-xs transition-all shadow-md shadow-amber-500/20 cursor-pointer">
                                    Bersihkan Otomatis Sekarang
                                </button>
                            </form>
                        @else
                            <div class="p-4 bg-emerald-50 text-emerald-800 rounded-2xl border border-emerald-200/80 text-xs text-center py-6">
                                <div class="w-12 h-12 mx-auto rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-2.5">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <p class="font-bold text-sm text-emerald-900 mb-1">Sistem Bersih</p>
                                <p class="text-emerald-700 text-xs">Tidak ditemukan data pengunjung yang terduplikasi.</p>
                            </div>

                            <div class="flex items-center justify-end pt-3 border-t border-slate-200/80">
                                <button type="button" @click="showDuplicateModal = false" class="px-5 py-2 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors cursor-pointer">
                                    Tutup
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </template>

        <!-- Modal Konfirmasi Reset Semua Data (Custom Glassmorphism Teleport) -->
        <template x-teleport="body">
            <div x-show="resetConfirmOpen"
                 x-cloak
                 style="display: none;"
                 class="fixed inset-0 z-[9999] overflow-y-auto bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4 print:hidden"
                 @keydown.escape.window="resetConfirmOpen = false">
                <div class="fixed inset-0" @click="resetConfirmOpen = false"></div>
                <div class="relative w-full max-w-md bg-white/80 backdrop-blur-xl border border-white/60 shadow-2xl rounded-3xl p-6 sm:p-7 text-left z-10" @click.stop>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center border border-rose-200 shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900 font-heading">Reset Semua Data</h3>
                            <p class="text-[11px] text-rose-600 font-semibold">Tindakan ini tidak dapat dibatalkan!</p>
                        </div>
                    </div>
                    <div class="p-4 rounded-2xl bg-rose-50/80 border border-rose-200/80 text-rose-800 text-xs leading-relaxed mb-6">
                        <strong>PERINGATAN BAHAYA:</strong> Anda akan menghapus <strong>SELURUH</strong> data Buku Tamu dan Kuisioner SKM yang tersimpan di sistem. Data yang telah dihapus tidak dapat dipulihkan kembali.
                    </div>
                    <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-200/80">
                        <button type="button" @click="resetConfirmOpen = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors cursor-pointer">
                            Batal
                        </button>
                        <form action="{{ route('admin.skm.reset') }}" method="POST">
                            @csrf
                            <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 active:scale-95 shadow-md shadow-rose-500/25 transition-all flex items-center gap-2 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                <span>Ya, Hapus Semua Data</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </template>
    </div> <!-- PASTIKAN INI DITUTUP SEBELUM GRID STATISTIK -->

    {{-- ================================================================ --}}
    {{-- 4. GRID STATISTIK SKM                                              --}}
    {{-- ================================================================ --}}
    @php
        $totalResponden = $demographics['total'];
        $totalWithSurvey = \App\Models\UltSurveyResponse::count();
        $responseRate = $totalResponden > 0 ? round(($totalWithSurvey / $totalResponden) * 100, 1) : 0;
        $bestUnsur = collect($ikmPerUnsur)->sortByDesc('nr')->first();
        $worstUnsur = collect($ikmPerUnsur)->sortBy('nr')->first();
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

        {{-- Card 1: Total Responden Buku Tamu --}}
        <div class="bg-white/70 backdrop-blur-md border border-white/80 shadow-sm shadow-slate-200/40 rounded-2xl p-4 sm:p-5 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-blue-100/60 rounded-full blur-xl group-hover:bg-blue-200/60 transition-colors"></div>
            <div class="relative z-10">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-3 shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <div class="text-2xl sm:text-3xl font-black text-slate-900 font-heading">{{ number_format($totalResponden) }}</div>
                <div class="text-xs text-slate-600 font-semibold mt-0.5">Total Pengunjung Tamu</div>
                <div class="text-[11px] text-slate-400 mt-1">Sejak sistem berjalan</div>
            </div>
        </div>

        {{-- Card 2: Total Responden Kuisioner --}}
        <div class="bg-white/70 backdrop-blur-md border border-white/80 shadow-sm shadow-slate-200/40 rounded-2xl p-4 sm:p-5 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-emerald-100/60 rounded-full blur-xl group-hover:bg-emerald-200/60 transition-colors"></div>
            <div class="relative z-10">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3 shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
                <div class="text-2xl sm:text-3xl font-black text-slate-900 font-heading">{{ number_format($totalWithSurvey) }}</div>
                <div class="text-xs text-slate-600 font-semibold mt-0.5">Responden Kuisioner</div>
                <div class="text-[11px] text-slate-400 mt-1">Response rate: <strong class="text-emerald-600">{{ $responseRate }}%</strong></div>
            </div>
        </div>

        {{-- Card 3: Unsur Terbaik --}}
        <div class="bg-white/70 backdrop-blur-md border border-white/80 shadow-sm shadow-slate-200/40 rounded-2xl p-4 sm:p-5 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-sky-100/60 rounded-full blur-xl group-hover:bg-sky-200/60 transition-colors"></div>
            <div class="relative z-10">
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center mb-3 shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                @if(!empty($unsur_terbaik) && isset($unsur_terbaik['nilai']))
                    <div class="text-2xl sm:text-3xl font-black text-sky-700 font-heading">{{ number_format($unsur_terbaik['nilai'], 2) }}</div>
                    <div class="text-xs text-slate-600 font-semibold mt-0.5">Unsur Terbaik (NR)</div>
                    <div class="text-[11px] text-slate-500 mt-1 leading-tight truncate" title="{{ $unsur_terbaik['nama'] }}">{{ $unsur_terbaik['nama'] }}</div>
                @elseif($bestUnsur)
                    <div class="text-2xl sm:text-3xl font-black text-sky-700 font-heading">{{ number_format($bestUnsur['nr'], 2) }}</div>
                    <div class="text-xs text-slate-600 font-semibold mt-0.5">Unsur Terbaik (NR)</div>
                    <div class="text-[11px] text-slate-500 mt-1 leading-tight truncate" title="{{ $bestUnsur['label'] }}">{{ $bestUnsur['label'] }}</div>
                @else
                    <div class="text-xl font-bold text-slate-400 font-heading">—</div>
                    <div class="text-xs text-slate-500 mt-0.5">Belum ada data</div>
                @endif
            </div>
        </div>

        {{-- Card 4: Unsur Perlu Perhatian --}}
        <div class="bg-white/70 backdrop-blur-md border border-white/80 shadow-sm shadow-slate-200/40 rounded-2xl p-4 sm:p-5 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-amber-100/60 rounded-full blur-xl group-hover:bg-amber-200/60 transition-colors"></div>
            <div class="relative z-10">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-3 shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                @if(!empty($unsur_terendah) && isset($unsur_terendah['nilai']))
                    <div class="text-2xl sm:text-3xl font-black text-amber-700 font-heading">{{ number_format($unsur_terendah['nilai'], 2) }}</div>
                    <div class="text-xs text-slate-600 font-semibold mt-0.5">Perlu Ditingkatkan (NR)</div>
                    <div class="text-[11px] text-slate-500 mt-1 leading-tight truncate" title="{{ $unsur_terendah['nama'] }}">{{ $unsur_terendah['nama'] }}</div>
                @elseif($worstUnsur)
                    <div class="text-2xl sm:text-3xl font-black text-amber-700 font-heading">{{ number_format($worstUnsur['nr'], 2) }}</div>
                    <div class="text-xs text-slate-600 font-semibold mt-0.5">Perlu Ditingkatkan (NR)</div>
                    <div class="text-[11px] text-slate-500 mt-1 leading-tight truncate" title="{{ $worstUnsur['label'] }}">{{ $worstUnsur['label'] }}</div>
                @else
                    <div class="text-xl font-bold text-slate-400 font-heading">—</div>
                    <div class="text-xs text-slate-500 mt-0.5">Belum ada data</div>
                @endif
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- SECTION: GRAFIK DEMOGRAFI (GRID 2×2)                              --}}
    {{-- ================================================================ --}}
    <div>
        <div class="flex items-center gap-2 mb-4">
            <div class="w-1.5 h-6 bg-gradient-to-b from-blue-600 to-indigo-600 rounded-full"></div>
            <h2 class="text-base font-extrabold text-slate-900 font-heading">Demografi Responden</h2>
            <span class="ml-1 text-xs text-slate-500 font-normal">• Analisis komposisi {{ $demographics['total'] }} pengunjung tamu</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- Chart 1: PIE — Jenis Kelamin --}}
            <div class="bg-white/70 backdrop-blur-md border border-white/80 shadow-sm shadow-slate-200/40 rounded-2xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 font-heading">Jenis Kelamin</h3>
                        <p class="text-xs text-slate-500">Distribusi gender pengunjung</p>
                    </div>
                    <span class="w-8 h-8 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center text-base">🧑‍🤝‍🧑</span>
                </div>
                <div class="h-56 flex items-center justify-center">
                    <canvas id="chartJenisKelamin" style="max-height: 220px;"></canvas>
                </div>
                <div class="flex justify-center gap-6 mt-3 text-xs text-slate-600 font-medium">
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-blue-500 inline-block"></span>Laki-laki: <b>{{ $demographics['jenis_kelamin']['data'][0] }}</b></span>
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-rose-400 inline-block"></span>Perempuan: <b>{{ $demographics['jenis_kelamin']['data'][1] }}</b></span>
                </div>
            </div>

            {{-- Chart 2: BAR — Pendidikan --}}
            <div class="bg-white/70 backdrop-blur-md border border-white/80 shadow-sm shadow-slate-200/40 rounded-2xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 font-heading">Tingkat Pendidikan</h3>
                        <p class="text-xs text-slate-500">Jenjang pendidikan terakhir</p>
                    </div>
                    <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-base">🎓</span>
                </div>
                <div class="h-56">
                    <canvas id="chartPendidikan" style="max-height: 220px;"></canvas>
                </div>
            </div>

            {{-- Chart 3: LINE — Kelompok Usia --}}
            <div class="bg-white/70 backdrop-blur-md border border-white/80 shadow-sm shadow-slate-200/40 rounded-2xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 font-heading">Kelompok Usia</h3>
                        <p class="text-xs text-slate-500">Distribusi usia pengunjung</p>
                    </div>
                    <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-base">📊</span>
                </div>
                <div class="h-56">
                    <canvas id="chartUsia" style="max-height: 220px;"></canvas>
                </div>
            </div>

            {{-- Chart 4: BAR — Pekerjaan --}}
            <div class="bg-white/70 backdrop-blur-md border border-white/80 shadow-sm shadow-slate-200/40 rounded-2xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 font-heading">Profil Pekerjaan</h3>
                        <p class="text-xs text-slate-500">Top jenis pekerjaan pengunjung</p>
                    </div>
                    <span class="w-8 h-8 rounded-xl bg-purple-50 text-purple-500 flex items-center justify-center text-base">💼</span>
                </div>
                <div class="h-56">
                    <canvas id="chartPekerjaan" style="max-height: 220px;"></canvas>
                </div>
            </div>

        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- SECTION: TABEL NILAI PER UNSUR P1–P9                              --}}
    {{-- ================================================================ --}}
    <div>
        <div class="flex items-center gap-2 mb-4">
            <div class="w-1.5 h-6 bg-gradient-to-b from-indigo-600 to-purple-600 rounded-full"></div>
            <h2 class="text-base font-extrabold text-slate-900 font-heading">Nilai IKM Per Unsur Pelayanan</h2>
            <span class="ml-1 text-xs text-slate-500 font-normal">• Perhitungan NR &amp; NRT Permenpan RB 14/2017</span>
        </div>

        <div class="bg-white/70 backdrop-blur-md border border-white/80 shadow-sm shadow-slate-200/40 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-slate-50 to-blue-50/40 border-b border-slate-200/80">
                            <th class="py-3 px-4 text-center text-[11px] font-extrabold uppercase tracking-wider text-slate-600 w-12">No</th>
                            <th class="py-3 px-4 text-[11px] font-extrabold uppercase tracking-wider text-slate-600 min-w-[220px]">Unsur Pelayanan (P1–P9)</th>
                            <th class="py-3 px-4 text-center text-[11px] font-extrabold uppercase tracking-wider text-slate-600 whitespace-nowrap">Nilai Rata-rata (NR)</th>
                            <th class="py-3 px-4 text-center text-[11px] font-extrabold uppercase tracking-wider text-slate-600 whitespace-nowrap">NRT = NR × 0.111</th>
                            <th class="py-3 px-4 text-center text-[11px] font-extrabold uppercase tracking-wider text-slate-600 min-w-[140px]">Progress</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @php
                            $pNum = 1;
                            $colorClasses = ['bg-blue-500', 'bg-indigo-500', 'bg-violet-500', 'bg-sky-500', 'bg-teal-500', 'bg-emerald-500', 'bg-amber-500', 'bg-orange-500', 'bg-rose-500'];
                        @endphp
                        @foreach($ikmPerUnsur as $key => $unsur)
                            @php
                                $progressPct = min(100, round(($unsur['nr'] / 4) * 100));
                                $colorClass = $colorClasses[$loop->index % count($colorClasses)];
                                $nrColor = $unsur['nr'] >= 3.5 ? 'text-emerald-700' : ($unsur['nr'] >= 2.5 ? 'text-blue-700' : ($unsur['nr'] >= 1.5 ? 'text-amber-700' : 'text-rose-700'));
                            @endphp
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="py-3.5 px-4 text-center">
                                    <span class="w-7 h-7 rounded-xl {{ $colorClass }} text-white font-extrabold text-[11px] inline-flex items-center justify-center shadow-sm">P{{ $pNum++ }}</span>
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-slate-800 max-w-xs">
                                    {{ $unsur['label'] }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="inline-block px-3 py-1 rounded-xl font-extrabold text-sm {{ $nrColor }} bg-white border border-slate-200 shadow-xs font-heading">
                                        {{ number_format($unsur['nr'], 3) }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="font-bold text-slate-700">{{ number_format($unsur['nrt'], 4) }}</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                            <div class="{{ $colorClass }} h-2 rounded-full transition-all" style="width: {{ $progressPct }}%"></div>
                                        </div>
                                        <span class="text-[11px] text-slate-500 font-medium w-9 text-right">{{ $progressPct }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    {{-- Baris Total --}}
                    <tfoot>
                        <tr class="bg-gradient-to-r from-blue-700 to-indigo-800 text-white">
                            <td colspan="2" class="py-4 px-4 font-extrabold text-sm font-heading">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M9 14h.01M12 14h.01M15 14h.01M3 5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"></path></svg>
                                    TOTAL NRT &amp; IKM KONVERSI
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="text-sky-200 text-xs font-medium">Rata-rata: <strong class="text-white">{{ number_format(collect($ikmPerUnsur)->avg('nr'), 3) }}</strong></span>
                            </td>
                            <td class="py-4 px-4 text-center font-extrabold text-lg font-heading text-sky-200">
                                {{ number_format($totalNrt, 4) }}
                            </td>
                            <td class="py-4 px-4 text-center">
                                <div class="inline-flex flex-col items-center gap-0.5">
                                    <span class="text-[11px] text-sky-300 font-medium">NRT × 25 =</span>
                                    <span class="text-xl font-black text-white font-heading">{{ number_format($nilai_konversi ?? $totalIkm, 2) }}</span>
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-extrabold mt-0.5
                                        {{ ($mutu ?? $mutuLayanan['grade']) === 'A' ? 'bg-emerald-400/30 text-emerald-200' :
                                           (($mutu ?? $mutuLayanan['grade']) === 'B' ? 'bg-blue-400/30 text-blue-100' :
                                           (($mutu ?? $mutuLayanan['grade']) === 'C' ? 'bg-amber-400/30 text-amber-200' :
                                           'bg-rose-400/30 text-rose-200')) }}">
                                        Mutu {{ $mutu ?? $mutuLayanan['grade'] }} — {{ $kinerja ?? $mutuLayanan['label'] }}
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Skala Referensi Permenpan --}}
            <div class="p-4 bg-slate-50/80 border-t border-slate-200/70">
                <p class="text-[11px] font-bold text-slate-600 mb-2 uppercase tracking-wider">Skala Predikat Mutu Layanan (Permenpan RB No. 14/2017):</p>
                <div class="flex flex-wrap gap-2.5 text-[11px]">
                    <span class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-bold border border-emerald-200">🏆 A — Sangat Baik (88.31 – 100.00)</span>
                    <span class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-100 text-blue-800 font-bold border border-blue-200">👍 B — Baik (76.61 – 88.30)</span>
                    <span class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 text-amber-800 font-bold border border-amber-200">⚠️ C — Kurang Baik (65.00 – 76.60)</span>
                    <span class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-100 text-rose-800 font-bold border border-rose-200">🔴 D — Tidak Baik (25.00 – 64.99)</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- SECTION: TABEL IKM PER JENIS LAYANAN                              --}}
    {{-- ================================================================ --}}
    <div>
        <div class="flex items-center gap-2 mb-4">
            <div class="w-1.5 h-6 bg-gradient-to-b from-emerald-500 to-teal-600 rounded-full"></div>
            <h2 class="text-base font-extrabold text-slate-900 font-heading">Akumulasi IKM Per Jenis Layanan</h2>
            <span class="ml-1 text-xs text-slate-500 font-normal">• Nilai IKM dikelompokkan berdasarkan layanan yang diakses</span>
        </div>

        <div class="bg-white/70 backdrop-blur-md border border-white/80 shadow-sm shadow-slate-200/40 rounded-2xl overflow-hidden">
            @if($ikmPerLayanan->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gradient-to-r from-slate-50 to-emerald-50/40 border-b border-slate-200/80">
                                <th class="py-3 px-4 text-center text-[11px] font-extrabold uppercase tracking-wider text-slate-600 w-12">No</th>
                                <th class="py-3 px-4 text-[11px] font-extrabold uppercase tracking-wider text-slate-600 min-w-[280px]">Jenis Layanan</th>
                                <th class="py-3 px-4 text-center text-[11px] font-extrabold uppercase tracking-wider text-slate-600 whitespace-nowrap">Responden</th>
                                <th class="py-3 px-4 text-center text-[11px] font-extrabold uppercase tracking-wider text-slate-600 whitespace-nowrap">IKM Konversi</th>
                                <th class="py-3 px-4 text-center text-[11px] font-extrabold uppercase tracking-wider text-slate-600">Mutu / Predikat</th>
                                <th class="py-3 px-4 text-center text-[11px] font-extrabold uppercase tracking-wider text-slate-600 min-w-[180px]">Visual IKM</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @foreach($ikmPerLayanan as $idx => $item)
                                @php
                                    $pct = $item['ikm'] > 0 ? min(100, round(($item['ikm'] / 100) * 100)) : 0;
                                    $barColor = match($item['grade']) {
                                        'A' => 'bg-emerald-500',
                                        'B' => 'bg-blue-500',
                                        'C' => 'bg-amber-500',
                                        default => 'bg-rose-500'
                                    };
                                    $badgeColors = match($item['grade']) {
                                        'A' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'B' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'C' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        default => 'bg-rose-50 text-rose-700 border-rose-200'
                                    };
                                @endphp
                                <tr class="hover:bg-emerald-50/30 transition-colors group">
                                    <td class="py-3.5 px-4 text-center font-bold text-slate-500 group-hover:text-emerald-600">{{ ($ikmPerLayanan->firstItem() ?? 1) + $idx }}</td>
                                    <td class="py-3.5 px-4 font-semibold text-slate-800 leading-snug">{{ $item['layanan'] }}</td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-100 text-slate-800 font-extrabold text-sm font-heading shadow-xs">
                                            {{ $item['responden'] }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="text-lg font-black font-heading {{ $item['grade'] === 'A' ? 'text-emerald-700' : ($item['grade'] === 'B' ? 'text-blue-700' : ($item['grade'] === 'C' ? 'text-amber-700' : 'text-rose-700')) }}">
                                            {{ number_format($item['ikm'], 2) }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full font-bold border text-[11px] {{ $badgeColors }}">
                                            <span class="font-black text-base leading-none">{{ $item['grade'] }}</span>
                                            <span>{{ $item['label'] }}</span>
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                                <div class="{{ $barColor }} h-2.5 rounded-full" style="width: {{ $pct }}%"></div>
                                            </div>
                                            <span class="text-[11px] text-slate-500 font-medium w-10 text-right">{{ number_format($item['ikm'], 1) }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Links Akumulasi IKM --}}
                <div class="p-4 border-t border-slate-200/80 bg-slate-50/60 print:hidden flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-xs font-medium text-slate-600">
                        Menampilkan <span class="font-bold text-slate-900">{{ $ikmPerLayanan->firstItem() ?? 0 }}</span> sampai <span class="font-bold text-slate-900">{{ $ikmPerLayanan->lastItem() ?? 0 }}</span> dari total <span class="font-bold text-slate-900">{{ $ikmPerLayanan->total() }}</span> layanan.
                    </div>
                    <div>
                        {{ $ikmPerLayanan->links() }}
                    </div>
                </div>
            @else
                <div class="py-16 text-center text-slate-500">
                    <div class="w-16 h-16 mx-auto rounded-3xl bg-slate-100 flex items-center justify-center text-3xl mb-3">📊</div>
                    <h3 class="text-sm font-bold text-slate-800 font-heading">Data Belum Tersedia</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Data IKM per layanan akan muncul setelah ada pengunjung yang mengisi buku tamu <em>dan</em> menyelesaikan kuisioner.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- CHART: IKM PER LAYANAN — Bar Chart Horizontal                     --}}
    {{-- ================================================================ --}}
    @if((isset($allIkmPerLayanan) ? count($allIkmPerLayanan) : $ikmPerLayanan->count()) > 0)
    <div>
        <div class="flex items-center gap-2 mb-4">
            <div class="w-1.5 h-6 bg-gradient-to-b from-rose-500 to-orange-500 rounded-full"></div>
            <h2 class="text-base font-extrabold text-slate-900 font-heading">Visualisasi IKM Per Layanan</h2>
        </div>
        <div class="bg-white/70 backdrop-blur-md border border-white/80 shadow-sm shadow-slate-200/40 rounded-2xl p-6">
            <canvas id="chartIkmPerLayanan" style="max-height: 340px;"></canvas>
        </div>
    </div>
    @endif

    {{-- ================================================================ --}}
    {{-- CHART: RADAR — Perbandingan NR 9 Unsur Pelayanan                  --}}
    {{-- ================================================================ --}}
    <div>
        <div class="flex items-center gap-2 mb-4">
            <div class="w-1.5 h-6 bg-gradient-to-b from-purple-600 to-pink-600 rounded-full"></div>
            <h2 class="text-base font-extrabold text-slate-900 font-heading">Radar Nilai Rata-rata Per Unsur</h2>
        </div>
        <div class="bg-white/70 backdrop-blur-md border border-white/80 shadow-sm shadow-slate-200/40 rounded-2xl p-6">
            <div class="max-w-lg mx-auto">
                <canvas id="chartRadarUnsur" style="max-height: 420px;"></canvas>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Inject PHP data ──────────────────────────────────────────────
    const demog    = @json($demographics);
    const unsurData = @json($ikmPerUnsur);
    const layananData = @json($allIkmPerLayanan ?? ($ikmPerLayanan instanceof \Illuminate\Pagination\AbstractPaginator ? $ikmPerLayanan->items() : $ikmPerLayanan));

    // ── Chart Defaults ───────────────────────────────────────────────
    Chart.defaults.font.family = "'Poppins', sans-serif";
    Chart.defaults.font.size = 11;
    Chart.defaults.color = '#64748b';

    // ── Helper: modern gradient palette ─────────────────────────────
    const palette = [
        '#3b82f6','#6366f1','#8b5cf6','#06b6d4','#10b981',
        '#f59e0b','#f97316','#ef4444','#ec4899','#14b8a6'
    ];

    // ── Chart 1: PIE — Jenis Kelamin ─────────────────────────────────
    new Chart(document.getElementById('chartJenisKelamin'), {
        type: 'doughnut',
        data: {
            labels: demog.jenis_kelamin.labels,
            datasets: [{
                data: demog.jenis_kelamin.data,
                backgroundColor: ['#3b82f6', '#f43f5e'],
                borderColor: ['#fff','#fff'],
                borderWidth: 3,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '62%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (c) => ` ${c.label}: ${c.raw} orang`
                    }
                }
            }
        }
    });

    // ── Chart 2: BAR — Pendidikan ─────────────────────────────────────
    new Chart(document.getElementById('chartPendidikan'), {
        type: 'bar',
        data: {
            labels: demog.pendidikan.labels.map(l => l.length > 16 ? l.substring(0,14)+'…' : l),
            datasets: [{
                label: 'Responden',
                data: demog.pendidikan.data,
                backgroundColor: palette.map(c => c + 'cc'),
                borderColor: palette,
                borderWidth: 1.5,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: { stepSize: 1, precision: 0 }
                }
            }
        }
    });

    // ── Chart 3: LINE — Kelompok Usia ────────────────────────────────
    new Chart(document.getElementById('chartUsia'), {
        type: 'line',
        data: {
            labels: demog.usia.labels,
            datasets: [{
                label: 'Jumlah',
                data: demog.usia.data,
                borderColor: '#10b981',
                backgroundColor: 'rgba(16,185,129,0.12)',
                pointBackgroundColor: '#10b981',
                pointRadius: 5,
                pointHoverRadius: 8,
                borderWidth: 2.5,
                tension: 0.45,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false } },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: { stepSize: 1, precision: 0 }
                }
            }
        }
    });

    // ── Chart 4: BAR — Pekerjaan (Horizontal) ────────────────────────
    new Chart(document.getElementById('chartPekerjaan'), {
        type: 'bar',
        data: {
            labels: demog.pekerjaan.labels.map(l => l.length > 20 ? l.substring(0,18)+'…' : l),
            datasets: [{
                label: 'Responden',
                data: demog.pekerjaan.data,
                backgroundColor: '#8b5cf6cc',
                borderColor: '#8b5cf6',
                borderWidth: 1.5,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: { stepSize: 1, precision: 0 }
                },
                y: { grid: { display: false }, ticks: { font: { size: 10 } } }
            }
        }
    });

    // ── Chart 5: BAR — IKM Per Layanan ───────────────────────────────
    const layananCanvas = document.getElementById('chartIkmPerLayanan');
    if (layananCanvas && layananData.length > 0) {
        const layananColors = layananData.map(d => {
            if (d.grade === 'A') return '#10b981cc';
            if (d.grade === 'B') return '#3b82f6cc';
            if (d.grade === 'C') return '#f59e0bcc';
            return '#ef4444cc';
        });
        new Chart(layananCanvas, {
            type: 'bar',
            data: {
                labels: layananData.map(d => d.layanan.length > 30 ? d.layanan.substring(0,28)+'…' : d.layanan),
                datasets: [{
                    label: 'Nilai IKM',
                    data: layananData.map(d => d.ikm),
                    backgroundColor: layananColors,
                    borderColor: layananColors.map(c => c.replace('cc','')),
                    borderWidth: 1.5,
                    borderRadius: 10,
                    borderSkipped: false
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            afterLabel: (c) => {
                                const d = layananData[c.dataIndex];
                                return `Mutu: ${d.grade} — ${d.label}\nResponden: ${d.responden}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        min: 0, max: 100,
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            callback: (v) => v,
                            stepSize: 25
                        }
                    },
                    y: { grid: { display: false }, ticks: { font: { size: 10 } } }
                }
            }
        });
    }

    // ── Chart 6: RADAR — 9 Unsur Pelayanan ───────────────────────────
    const unsurKeys   = Object.keys(unsurData);
    const unsurLabels = unsurKeys.map(k => {
        const l = unsurData[k].label;
        return l.length > 18 ? l.substring(0,16)+'…' : l;
    });
    const unsurNr = unsurKeys.map(k => unsurData[k].nr);

    new Chart(document.getElementById('chartRadarUnsur'), {
        type: 'radar',
        data: {
            labels: unsurLabels,
            datasets: [{
                label: 'Nilai Rata-rata (NR)',
                data: unsurNr,
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99,102,241,0.15)',
                pointBackgroundColor: '#6366f1',
                pointBorderColor: '#fff',
                pointRadius: 5,
                pointHoverRadius: 8,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: { boxWidth: 14, padding: 16 }
                }
            },
            scales: {
                r: {
                    min: 0,
                    max: 4,
                    ticks: {
                        stepSize: 1,
                        backdropColor: 'transparent',
                        font: { size: 10 }
                    },
                    grid: { color: '#e2e8f0' },
                    angleLines: { color: '#e2e8f0' },
                    pointLabels: { font: { size: 10, weight: '600' }, color: '#475569' }
                }
            }
        }
    });

}); // end DOMContentLoaded
</script>
@endpush
