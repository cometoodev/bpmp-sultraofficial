@extends('layouts.admin')

@section('title', 'Rekap Buku Tamu & Kuisioner ULT')
@section('header_title', 'Buku Tamu ULT')
@section('header_subtitle', 'Rekapitulasi data pengunjung dan kuesioner Unit Layanan Terpadu')

@section('content')
<div class="space-y-6">

    <!-- Kop Surat Resmi (Hanya Muncul Saat Print Halaman) -->
    <div class="hidden print:block mb-6 text-center border-b-2 border-slate-900 pb-3">
        <h2 class="text-base font-bold uppercase text-slate-900 tracking-wide">KEMENTERIAN PENDIDIKAN DASAR DAN MENENGAH</h2>
        <h3 class="text-sm font-bold uppercase text-slate-900">BALAI PENJAMINAN MUTU PENDIDIKAN PROVINSI SULAWESI TENGGARA</h3>
        <p class="text-[11px] text-slate-600 mt-0.5">Jl. R.E. Martadinata No. 1, Mandonga, Kendari, Sulawesi Tenggara 93111 | Surel: bpmp.sultra@kemdikbud.go.id</p>
        <div class="mt-2 pt-2 border-t border-slate-400">
            <h4 class="text-xs font-bold uppercase text-slate-900">REKAPITULASI BUKU TAMU &amp; KUISIONER UNIT LAYANAN TERPADU (ULT)</h4>
            <p class="text-[10px] text-slate-500">Dicetak pada: {{ now()->locale('id')->translatedFormat('l, d F Y H:i') }} WITA</p>
        </div>
    </div>

    <!-- Top Header Banner & Stats Overview -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-800 to-blue-700 p-6 sm:p-8 text-white shadow-lg print:hidden">
        <div class="absolute -right-12 -bottom-12 w-56 h-56 bg-sky-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-0 right-1/4 w-36 h-36 bg-indigo-500/20 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-xs font-bold text-sky-200 border border-white/15 mb-2.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Unit Layanan Terpadu (ULT) &bull; Akses Terbatas Admin</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight font-heading">
                    Rekap Buku Tamu &amp; Kuisioner
                </h1>
                <p class="text-xs sm:text-sm text-sky-100/80 mt-1.5 max-w-2xl leading-relaxed">
                    Daftar registrasi pengunjung loket ULT BPMP Provinsi Sulawesi Tenggara beserta hasil kuesioner kepuasan pelayanan dan saran perbaikan.
                </p>
            </div>

            <!-- Quick Counter Chips -->
            <div class="flex flex-wrap items-center gap-3">
                <div class="bg-white/10 backdrop-blur-md border border-white/15 px-4 py-2.5 rounded-2xl text-center min-w-[110px]">
                    <span class="block text-2xl font-black text-white font-heading">{{ $guestbooks->total() }}</span>
                    <span class="text-[11px] font-medium text-sky-200/90 uppercase tracking-wider">Total Kunjungan</span>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/15 px-4 py-2.5 rounded-2xl text-center min-w-[110px]">
                    @php
                        $totalWithSurvey = \App\Models\UltSurveyResponse::count();
                    @endphp
                    <span class="block text-2xl font-black text-emerald-300 font-heading">{{ $totalWithSurvey }}</span>
                    <span class="text-[11px] font-medium text-sky-200/90 uppercase tracking-wider">Kuisioner Masuk</span>
                </div>
            </div>
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
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    <!-- Filter Bar (UI Glassmorphism) -->
    <form method="GET" action="{{ route('admin.guestbook.index') }}" class="bg-white/40 backdrop-blur-md border border-white/50 p-4 rounded-xl flex flex-wrap gap-4 items-end mb-6 shadow-sm print:hidden">
        <!-- Select Tahun -->
        <div class="flex-1 min-w-[130px]">
            <label for="filter_gb_tahun" class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Tahun</span>
            </label>
            <select name="tahun" id="filter_gb_tahun" class="w-full text-xs font-semibold bg-white/80 border border-slate-200/90 rounded-xl px-3 py-2 text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-all shadow-2xs">
                <option value="all" {{ ($tahun === null || $tahun === 'all') ? 'selected' : '' }}>Semua Tahun</option>
                @foreach($availableYears as $year)
                    <option value="{{ $year }}" {{ ((string) $tahun === (string) $year) ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
        </div>

        <!-- Select Triwulan -->
        <div class="flex-1 min-w-[160px]">
            <label for="filter_gb_triwulan" class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                <span>Triwulan</span>
            </label>
            <select name="triwulan" id="filter_gb_triwulan" class="w-full text-xs font-semibold bg-white/80 border border-slate-200/90 rounded-xl px-3 py-2 text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-all shadow-2xs">
                <option value="" {{ empty($triwulan) ? 'selected' : '' }}>Semua Triwulan</option>
                <option value="1" {{ (string) $triwulan === '1' ? 'selected' : '' }}>Triwulan 1 (Jan - Mar)</option>
                <option value="2" {{ (string) $triwulan === '2' ? 'selected' : '' }}>Triwulan 2 (Apr - Jun)</option>
                <option value="3" {{ (string) $triwulan === '3' ? 'selected' : '' }}>Triwulan 3 (Jul - Sep)</option>
                <option value="4" {{ (string) $triwulan === '4' ? 'selected' : '' }}>Triwulan 4 (Okt - Des)</option>
            </select>
        </div>

        <!-- Select Jenis Layanan -->
        <div class="flex-2 min-w-[220px]">
            <label for="filter_gb_layanan" class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <span>Jenis Layanan</span>
            </label>
            <select name="layanan" id="filter_gb_layanan" class="w-full text-xs font-semibold bg-white/80 border border-slate-200/90 rounded-xl px-3 py-2 text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-all shadow-2xs">
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
            <label for="filter_gb_per_page" class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                <span>Tampil</span>
            </label>
            <select name="per_page" id="filter_gb_per_page" onchange="this.form.submit()" class="w-full text-xs font-semibold bg-white/80 border border-slate-200/90 rounded-xl px-3 py-2 text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-all shadow-2xs cursor-pointer">
                <option value="10" {{ (string) request('per_page', $perPage ?? 10) === '10' ? 'selected' : '' }}>10 Data</option>
                <option value="25" {{ (string) request('per_page', $perPage ?? 10) === '25' ? 'selected' : '' }}>25 Data</option>
                <option value="50" {{ (string) request('per_page', $perPage ?? 10) === '50' ? 'selected' : '' }}>50 Data</option>
                <option value="100" {{ (string) request('per_page', $perPage ?? 10) === '100' ? 'selected' : '' }}>100 Data</option>
                <option value="all" {{ request('per_page') === 'all' ? 'selected' : '' }}>Tampil Semua Data</option>
            </select>
        </div>

        <!-- Input Pencarian -->
        <div class="flex-1 min-w-[200px]">
            <label for="filter_gb_search" class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <span>Pencarian</span>
            </label>
            <input type="text"
                   name="search"
                   id="filter_gb_search"
                   value="{{ request('search') }}"
                   placeholder="Cari nama, instansi, atau layanan..."
                   class="bg-white/50 border border-gray-200 rounded-lg px-4 py-2 w-full md:w-64 focus:ring-2 focus:ring-blue-400 outline-none text-xs font-medium text-slate-800 placeholder-slate-400">
        </div>

        <!-- Tombol Aksi Filter -->
        <div class="flex items-center gap-2">
            <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 active:scale-95 transition-all shadow-sm shadow-blue-500/25 flex items-center gap-1.5 cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                <span>Terapkan Filter</span>
            </button>
            <a href="{{ route('admin.guestbook.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-700 bg-slate-200/90 hover:bg-slate-300 active:scale-95 transition-all shadow-2xs flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                <span>Reset</span>
            </a>
        </div>
    </form>

    <!-- Modern Glassmorphism Export & Print Action Toolbar -->
    <div x-data="{ importModalOpen: false, showDuplicateModal: false, showLog: false, resetConfirmOpen: false, undoConfirmOpen: false, undoBatchId: '' }" class="mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex flex-wrap items-center justify-between gap-3 print:hidden">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center shadow-md shadow-blue-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900 font-heading">Ekspor, Impor &amp; Cetak Data Tamu</h3>
                    <p class="text-[11px] text-slate-500">
                        Unduh atau impor data buku tamu ULT sesuai filter yang sedang aktif
                        @if($tahun || $triwulan || $layanan)
                            <span class="inline-flex items-center gap-1 text-blue-600 font-bold ml-1">
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
                        <a href="{{ route('admin.guestbook.export', array_merge(request()->query(), ['type' => 'excel'])) }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span>Export Excel (.xlsx)</span>
                        </a>
                        <a href="{{ route('admin.guestbook.export', array_merge(request()->query(), ['type' => 'csv'])) }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-sky-50 hover:text-sky-700 transition-colors">
                            <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                            <span>Export CSV (.csv)</span>
                        </a>
                        <a href="{{ route('admin.guestbook.export', array_merge(request()->query(), ['type' => 'pdf'])) }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-rose-50 hover:text-rose-700 transition-colors">
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
                                <p class="text-[11px] text-slate-500">Unggah file data kunjungan tamu dan kuisioner SKM ULT</p>
                            </div>
                        </div>
                        <button type="button" @click="importModalOpen = false" class="text-slate-400 hover:text-slate-700 p-1.5 rounded-xl hover:bg-slate-100 transition-colors cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Modal Body / Form -->
                    <form action="{{ route('admin.guestbook.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
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
                            <button type="button" @click="importModalOpen = false" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors">
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
                        <form action="{{ route('admin.guestbook.undo-import') }}" method="POST">
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
                            <form action="{{ route('admin.guestbook.clean-duplicates') }}" method="POST">
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
                        <form action="{{ route('admin.guestbook.reset') }}" method="POST">
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
    </div>

    <!-- Modern Glassmorphism Table Container -->
    <div class="bg-white/70 backdrop-blur-md border border-white/80 shadow-lg shadow-slate-200/50 rounded-2xl overflow-hidden transition-all">

        <!-- Table Header Toolbar -->
        <div class="p-5 border-b border-slate-200/70 bg-white/40 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-slate-900 font-heading">Data Kunjungan Buku Tamu</h2>
                    <p class="text-[11px] text-slate-500">Menampilkan {{ $guestbooks->count() }} data per halaman (halaman {{ $guestbooks->currentPage() }} dari {{ $guestbooks->lastPage() }})</p>
                </div>
            </div>

            <!-- External link to Public Form for convenience -->
            <div class="flex items-center gap-2 print:hidden">
                <a href="{{ route('guestbook.create') }}" target="_blank" class="px-3.5 py-1.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold transition flex items-center gap-1.5 border border-blue-200/60 shadow-xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    <span>Buka Form Tamu Publik</span>
                </a>
            </div>
        </div>

        <!-- Responsive Table Wrapper -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200/80 bg-slate-50/80 text-[11px] uppercase tracking-wider font-extrabold text-slate-600 font-heading">
                        <th class="py-3.5 px-4 text-center w-12">No</th>
                        <th class="py-3.5 px-4 whitespace-nowrap min-w-[150px]">Tanggal / Waktu</th>
                        <th class="py-3.5 px-4 min-w-[220px]">Nama Pengunjung</th>
                        <th class="py-3.5 px-4 min-w-[220px]">Instansi / Asal</th>
                        <th class="py-3.5 px-4 min-w-[200px]">Jenis Layanan</th>
                        <th class="py-3.5 px-4 min-w-[280px]">Saran / Masukan</th>
                        <th class="py-3.5 px-4 text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($guestbooks as $index => $item)
                        @php
                            $survey = $item->ultSurveyResponse;
                            $avgScore = null;
                            if ($survey) {
                                $avgScore = round(($survey->q1 + $survey->q2 + $survey->q3 + $survey->q4 + $survey->q5 + $survey->q6 + $survey->q7 + $survey->q8 + $survey->q9) / 9, 2);
                            }
                            $isOriginal = isset($originalIds) && in_array($item->id, $originalIds);
                            $isDuplicate = isset($duplicateIds) && in_array($item->id, $duplicateIds);
                        @endphp
                        <tr x-data="{ showView: false, showEdit: false, showDelete: false }" class="
                            {{ $isOriginal ? 'bg-emerald-50 border-l-4 border-emerald-500 hover:bg-emerald-100' : '' }}
                            {{ $isDuplicate ? 'bg-rose-50 border-l-4 border-rose-500 hover:bg-rose-100' : '' }}
                            {{ !$isOriginal && !$isDuplicate ? 'bg-white hover:bg-gray-50' : '' }}
                            border-b border-gray-100 transition-colors group
                        ">
                            <!-- No -->
                            <td class="py-4 px-4 text-center font-bold text-slate-400 group-hover:text-blue-600">
                                {{ $guestbooks->firstItem() + $index }}
                            </td>

                            <!-- Tanggal / Waktu -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <div class="font-bold text-slate-800 font-heading">
                                    {{ $item->created_at->format('d M Y') }}
                                </div>
                                <div class="text-[11px] text-slate-500 flex items-center gap-1 mt-0.5">
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>{{ $item->created_at->format('H:i') }} WITA</span>
                                </div>
                                <span class="text-[10px] text-slate-400 block mt-0.5">
                                    {{ $item->created_at->diffForHumans() }}
                                </span>
                            </td>

                            <!-- Nama Pengunjung -->
                            <td class="py-4 px-4">
                                <div class="font-extrabold text-slate-900 font-heading flex items-center gap-2">
                                    <span>{{ $item->nama }}</span>
                                    @if($isOriginal)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-100 text-emerald-800 ml-2">Asli</span>
                                    @endif
                                    @if($isDuplicate)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-rose-100 text-rose-800 ml-2">Duplikat</span>
                                    @endif
                                    <span class="inline-flex items-center justify-center px-1.5 py-0.5 rounded text-[10px] font-bold {{ $item->jenis_kelamin === 'L' ? 'bg-blue-100 text-blue-700' : 'bg-rose-100 text-rose-700' }}">
                                        {{ $item->jenis_kelamin === 'L' ? 'L' : 'P' }}
                                    </span>
                                </div>
                                <div class="text-[11px] text-slate-600 mt-1 flex flex-wrap items-center gap-1.5">
                                    <span class="inline-block px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 font-medium text-[10px]">
                                        {{ $item->usia }} Thn
                                    </span>
                                    <span class="inline-block px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 font-medium text-[10px]">
                                        {{ $item->pendidikan }}
                                    </span>
                                </div>
                                @if($item->telepon)
                                    <div class="text-[11px] text-slate-500 mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->telepon) }}" target="_blank" class="hover:text-emerald-600 hover:underline">
                                            {{ $item->telepon }}
                                        </a>
                                    </div>
                                @endif
                            </td>

                            <!-- Instansi / Asal -->
                            <td class="py-4 px-4">
                                <div class="font-bold text-slate-800 leading-tight">
                                    {{ $item->asal_instansi }}
                                </div>
                                <div class="text-[11px] text-slate-500 mt-1 flex items-center gap-1">
                                    <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span>{{ $item->asal_kabupaten }}</span>
                                </div>
                                <div class="text-[10px] text-slate-500 mt-1">
                                    <span class="font-semibold text-slate-700">{{ $item->pekerjaan }}</span>
                                    <span class="text-slate-400">&bull;</span>
                                    <span>{{ $item->status_kepegawaian }}</span>
                                </div>
                            </td>

                            <!-- Jenis Layanan -->
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-xl bg-blue-50 text-blue-700 text-xs font-semibold border border-blue-200/60 leading-relaxed">
                                    {{ $item->jenis_layanan }}
                                </span>
                            </td>

                            <!-- Saran / Masukan (Dari relasi ultSurveyResponse) -->
                            <td class="py-4 px-4">
                                @if($survey)
                                    <div class="space-y-1.5">
                                        <!-- Rating Score Badge -->
                                        <div class="flex items-center gap-1.5">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-bold border border-emerald-200">
                                                <span>⭐</span>
                                                <span>Skor: {{ $avgScore }} / 4.0</span>
                                            </span>
                                            <span class="text-[10px] text-slate-400">
                                                @if($avgScore >= 3.5)
                                                    <span class="text-emerald-600 font-bold">Sangat Puas 😍</span>
                                                @elseif($avgScore >= 2.5)
                                                    <span class="text-blue-600 font-bold">Puas 😊</span>
                                                @elseif($avgScore >= 1.5)
                                                    <span class="text-amber-600 font-bold">Kurang Puas 🙁</span>
                                                @else
                                                    <span class="text-rose-600 font-bold">Tidak Puas 😡</span>
                                                @endif
                                            </span>
                                        </div>

                                        <!-- Saran Text -->
                                        @if($survey->saran)
                                            <p class="text-xs text-slate-700 bg-white/90 p-2.5 rounded-xl border border-slate-200/80 leading-relaxed italic shadow-2xs">
                                                &ldquo;{{ $survey->saran }}&rdquo;
                                            </p>
                                        @else
                                            <span class="text-[11px] text-slate-400 italic block">
                                                (Tidak ada saran tertulis)
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 text-[11px] font-medium border border-slate-200">
                                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span>Belum mengisi kuesioner</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi (View, Edit, Hapus) -->
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="inline-flex items-center justify-center gap-1.5">
                                    <!-- Tombol View Detail -->
                                    <button type="button" @click="showView = true" class="p-2 text-blue-600 hover:text-white bg-blue-50 hover:bg-blue-600 rounded-xl border border-blue-200/80 transition-colors duration-200 shadow-2xs cursor-pointer" title="Lihat Detail Tamu">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>

                                    <!-- Tombol Edit -->
                                    <button type="button" @click="showEdit = true" class="p-2 text-amber-600 hover:text-white bg-amber-50 hover:bg-amber-600 rounded-xl border border-amber-200/80 transition-colors duration-200 shadow-2xs cursor-pointer" title="Edit Data Tamu">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </button>

                                    <!-- Tombol Hapus Satuan -->
                                    <button type="button" @click="showDelete = true" class="p-2 text-rose-600 hover:text-white bg-rose-50 hover:bg-rose-600 rounded-xl border border-rose-200/80 transition-colors duration-200 shadow-2xs cursor-pointer" title="Hapus Data Tamu">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>

                                <!-- MODAL VIEW GLASSMORPHISM TELEPORT -->
                                <template x-teleport="body">
                                    <div x-show="showView" 
                                         x-cloak 
                                         style="display: none;"
                                         class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4 text-left"
                                         @keydown.escape.window="showView = false">
                                        <div class="fixed inset-0" @click="showView = false"></div>
                                        <div class="relative bg-white/80 backdrop-blur-xl border border-white/60 shadow-2xl rounded-3xl p-6 w-full max-w-lg overflow-y-auto max-h-[90vh] z-10"
                                             @click.stop>
                                            <!-- Header Modal -->
                                            <div class="flex items-center justify-between pb-4 border-b border-slate-200/80 mb-5">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                    </div>
                                                    <div>
                                                        <h3 class="text-base font-bold text-slate-800 font-heading">Detail Buku Tamu</h3>
                                                        <p class="text-[11px] text-slate-500">ID Registrasi: #{{ $item->id }} &bull; {{ $item->created_at->format('d M Y H:i') }} WITA</p>
                                                    </div>
                                                </div>
                                                <button type="button" @click="showView = false" class="p-1.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-colors cursor-pointer">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>

                                            <!-- Konten Detail -->
                                            <div class="space-y-4 text-xs">
                                                <div class="grid grid-cols-2 gap-3 bg-slate-50/80 p-3.5 rounded-2xl border border-slate-200/60">
                                                    <div>
                                                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Nama Lengkap</span>
                                                        <span class="font-bold text-slate-800 text-sm">{{ $item->nama }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Usia / Gender</span>
                                                        <span class="font-bold text-slate-800">{{ $item->usia ? $item->usia . ' Tahun' : '-' }} ({{ $item->jenis_kelamin === 'L' ? 'Laki-laki' : ($item->jenis_kelamin === 'P' ? 'Perempuan' : '-') }})</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">No. Telepon / WA</span>
                                                        <span class="font-bold text-slate-800">{{ $item->telepon ?: '-' }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Pendidikan</span>
                                                        <span class="font-bold text-slate-800">{{ $item->pendidikan ?: '-' }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Pekerjaan</span>
                                                        <span class="font-bold text-slate-800">{{ $item->pekerjaan ?: '-' }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Status Pegawai</span>
                                                        <span class="font-bold text-slate-800">{{ $item->status_kepegawaian ?: '-' }}</span>
                                                    </div>
                                                </div>

                                                <div class="space-y-2 bg-slate-50/80 p-3.5 rounded-2xl border border-slate-200/60">
                                                    <div>
                                                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Asal Instansi</span>
                                                        <span class="font-bold text-slate-800">{{ $item->asal_instansi ?: '-' }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Kabupaten / Kota</span>
                                                        <span class="font-bold text-slate-800">{{ $item->asal_kabupaten ?: '-' }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Jenis Layanan</span>
                                                        <span class="font-bold text-blue-700 bg-blue-50 inline-block px-2.5 py-1 rounded-lg border border-blue-200/70 mt-0.5">{{ $item->jenis_layanan }}</span>
                                                    </div>
                                                </div>

                                                <!-- Data Kuesioner SKM -->
                                                <div class="bg-gradient-to-br from-indigo-50/70 to-blue-50/70 p-3.5 rounded-2xl border border-indigo-200/60">
                                                    <div class="flex items-center justify-between mb-2">
                                                        <span class="text-[11px] font-bold text-indigo-900 uppercase tracking-wider">Hasil Kuesioner SKM</span>
                                                        @if($survey)
                                                            <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">Terisi</span>
                                                        @else
                                                            <span class="text-[11px] font-medium px-2 py-0.5 rounded-full bg-slate-200 text-slate-600">Belum Isi</span>
                                                        @endif
                                                    </div>

                                                    @if($survey)
                                                        <div class="flex items-center gap-3 mb-2">
                                                            <div class="text-2xl font-black text-indigo-700 font-heading">
                                                                {{ number_format($avgScore, 2) }}
                                                                <span class="text-xs font-normal text-slate-500">/ 4.00</span>
                                                            </div>
                                                            <div class="text-[11px]">
                                                                @if($avgScore >= 3.53)
                                                                    <span class="font-bold text-emerald-600 block">Sangat Baik (A)</span>
                                                                @elseif($avgScore >= 3.06)
                                                                    <span class="font-bold text-blue-600 block">Baik (B)</span>
                                                                @elseif($avgScore >= 2.60)
                                                                    <span class="font-bold text-amber-600 block">Kurang Baik (C)</span>
                                                                @else
                                                                    <span class="font-bold text-rose-600 block">Tidak Baik (D)</span>
                                                                @endif
                                                                <span class="text-slate-500">Mutu Pelayanan</span>
                                                            </div>
                                                        </div>

                                                        @if($survey->saran)
                                                            <div class="mt-2 pt-2 border-t border-indigo-200/60">
                                                                <span class="text-[10px] font-semibold text-slate-500 uppercase block mb-1">Saran / Masukan:</span>
                                                                <p class="text-xs text-slate-700 bg-white/90 p-2.5 rounded-xl border border-indigo-100 italic leading-relaxed">
                                                                    &ldquo;{{ $survey->saran }}&rdquo;
                                                                </p>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <p class="text-slate-500 text-xs italic">Pengunjung belum mengisi kuesioner survei kepuasan masyarakat.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Footer Modal -->
                                            <div class="mt-6 pt-4 border-t border-slate-200/80 flex justify-end">
                                                <button type="button" @click="showView = false" class="px-5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors cursor-pointer">
                                                    Tutup
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- MODAL EDIT GLASSMORPHISM TELEPORT -->
                                <template x-teleport="body">
                                    <div x-show="showEdit" 
                                         x-cloak 
                                         style="display: none;"
                                         class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4 text-left"
                                         @keydown.escape.window="showEdit = false">
                                        <div class="fixed inset-0" @click="showEdit = false"></div>
                                        <div class="relative bg-white/80 backdrop-blur-xl border border-white/60 shadow-2xl rounded-3xl p-6 w-full max-w-lg overflow-y-auto max-h-[90vh] z-10"
                                             @click.stop>
                                            <form action="{{ route('admin.guestbook.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <!-- Header Modal -->
                                                <div class="flex items-center justify-between pb-4 border-b border-slate-200/80 mb-5">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                        </div>
                                                        <div>
                                                            <h3 class="text-base font-bold text-slate-800 font-heading">Edit Data Buku Tamu</h3>
                                                            <p class="text-[11px] text-slate-500">Perbarui data pengunjung #{{ $item->id }}</p>
                                                        </div>
                                                    </div>
                                                    <button type="button" @click="showEdit = false" class="p-1.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-colors cursor-pointer">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>
                                                </div>

                                                <!-- Form Fields -->
                                                <div class="space-y-3.5 text-xs">
                                                    <div>
                                                        <label class="block font-bold text-slate-700 mb-1">Nama Pengunjung <span class="text-rose-500">*</span></label>
                                                        <input type="text" name="nama" value="{{ old('nama', $item->nama) }}" required class="w-full text-xs font-semibold bg-white/80 border border-slate-200/90 rounded-xl px-3 py-2 text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 transition-all">
                                                    </div>

                                                    <div class="grid grid-cols-2 gap-3">
                                                        <div>
                                                            <label class="block font-bold text-slate-700 mb-1">Usia (Tahun) <span class="text-rose-500">*</span></label>
                                                            <input type="number" name="usia" value="{{ old('usia', $item->usia) }}" min="1" max="120" required class="w-full text-xs font-semibold bg-white/80 border border-slate-200/90 rounded-xl px-3 py-2 text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 transition-all">
                                                        </div>
                                                        <div>
                                                            <label class="block font-bold text-slate-700 mb-1">Pekerjaan</label>
                                                            <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $item->pekerjaan) }}" class="w-full text-xs font-semibold bg-white/80 border border-slate-200/90 rounded-xl px-3 py-2 text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 transition-all">
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label class="block font-bold text-slate-700 mb-1">Asal Instansi <span class="text-rose-500">*</span></label>
                                                        <input type="text" name="asal_instansi" value="{{ old('asal_instansi', $item->asal_instansi) }}" required class="w-full text-xs font-semibold bg-white/80 border border-slate-200/90 rounded-xl px-3 py-2 text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 transition-all">
                                                    </div>

                                                    <div class="grid grid-cols-2 gap-3">
                                                        <div>
                                                            <label class="block font-bold text-slate-700 mb-1">Kabupaten / Kota</label>
                                                            <input type="text" name="asal_kabupaten" value="{{ old('asal_kabupaten', $item->asal_kabupaten) }}" class="w-full text-xs font-semibold bg-white/80 border border-slate-200/90 rounded-xl px-3 py-2 text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 transition-all">
                                                        </div>
                                                        <div>
                                                            <label class="block font-bold text-slate-700 mb-1">No. Telepon / WA</label>
                                                            <input type="text" name="telepon" value="{{ old('telepon', $item->telepon) }}" class="w-full text-xs font-semibold bg-white/80 border border-slate-200/90 rounded-xl px-3 py-2 text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 transition-all">
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label class="block font-bold text-slate-700 mb-1">Jenis Layanan <span class="text-rose-500">*</span></label>
                                                        <select name="jenis_layanan" required class="w-full text-xs font-semibold bg-white/80 border border-slate-200/90 rounded-xl px-3 py-2 text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 transition-all">
                                                            @foreach($allServices as $svc)
                                                                <option value="{{ $svc }}" {{ old('jenis_layanan', $item->jenis_layanan) === $svc ? 'selected' : '' }}>{{ $svc }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Footer Modal -->
                                                <div class="mt-6 pt-4 border-t border-slate-200/80 flex items-center justify-end gap-3">
                                                    <button type="button" @click="showEdit = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors cursor-pointer">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="px-5 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs transition-all shadow-md shadow-amber-500/20 cursor-pointer">
                                                        Simpan Perubahan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </template>

                                <!-- MODAL HAPUS SATUAN CUSTOM TELEPORT -->
                                <template x-teleport="body">
                                    <div x-show="showDelete" 
                                         x-cloak 
                                         style="display: none;"
                                         class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4 text-left"
                                         @keydown.escape.window="showDelete = false">
                                        <div class="fixed inset-0" @click="showDelete = false"></div>
                                        <div class="relative bg-white/80 backdrop-blur-xl border border-white/60 shadow-2xl rounded-3xl p-6 sm:p-7 w-full max-w-md z-10"
                                             @click.stop>
                                            <div class="flex items-center gap-3 mb-4">
                                                <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center border border-rose-200 shrink-0">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-base font-bold text-slate-900 font-heading">Hapus Data Buku Tamu</h3>
                                                    <p class="text-[11px] text-slate-500">ID Registrasi: #{{ $item->id }}</p>
                                                </div>
                                            </div>
                                            <div class="p-3.5 rounded-2xl bg-rose-50/80 border border-rose-200/80 text-rose-800 text-xs leading-relaxed mb-5">
                                                Yakin ingin menghapus data kunjungan atas nama <strong>{{ $item->nama }}</strong>? Seluruh data kuesioner terkait juga akan dihapus secara permanen.
                                            </div>
                                            <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-200/80">
                                                <button type="button" @click="showDelete = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors cursor-pointer">
                                                    Batal
                                                </button>
                                                <form action="{{ route('admin.guestbook.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 active:scale-95 shadow-md shadow-rose-500/25 transition-all flex items-center gap-2 cursor-pointer">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        <span>Hapus Permanen</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center text-slate-500">
                                <div class="w-16 h-16 mx-auto rounded-3xl bg-slate-100 flex items-center justify-center text-slate-400 mb-3">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <h3 class="text-sm font-bold text-slate-800 font-heading">Belum Ada Data Tamu</h3>
                                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                                    Data kunjungan buku tamu yang masuk melalui portal ULT akan otomatis tercatat dan muncul di tabel ini.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
        <div class="p-4 border-t border-slate-200/80 bg-slate-50/60 print:hidden flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-xs font-medium text-slate-600">
                Menampilkan <span class="font-bold text-slate-900">{{ $guestbooks->firstItem() ?? 0 }}</span> sampai <span class="font-bold text-slate-900">{{ $guestbooks->lastItem() ?? 0 }}</span> dari total <span class="font-bold text-slate-900">{{ $guestbooks->total() }}</span> data.
            </div>
            <div>
                {{ $guestbooks->links() }}
            </div>
        </div>

    </div>

</div>
@endsection
