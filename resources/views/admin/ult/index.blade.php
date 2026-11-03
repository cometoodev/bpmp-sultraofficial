@extends('layouts.admin')

@section('title', 'Manajemen Permohonan & Tiket ULT')
@section('header_title', 'Unit Layanan Terpadu (ULT)')
@section('header_subtitle', 'Manajemen permohonan dan tiket layanan informasi dan aduan')

@section('content')
<div class="space-y-6" x-data="{
    detailModalOpen: false,
    selectedItem: null,
    updateStatusAction: '',
    openDetail(item, updateUrl) {
        this.selectedItem = item;
        this.updateStatusAction = updateUrl;
        this.detailModalOpen = true;
    }
}">

    <!-- Alert Notifikasi Flash -->
    @if(session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-800 px-5 py-4 rounded-2xl flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
            <button @click="$el.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    <!-- STATS COUNTER GLASSMORPHISM -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Total Semua -->
        <a href="{{ route('admin.ult.index', ['tab' => 'all']) }}" 
           class="p-4 rounded-2xl border transition-all duration-300 {{ $activeTab === 'all' && !request('status') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/25 border-transparent' : 'bg-white/70 backdrop-blur-md border-white/60 hover:border-blue-300 hover:shadow-sm text-slate-800' }}">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold uppercase tracking-wider {{ $activeTab === 'all' && !request('status') ? 'text-blue-100' : 'text-slate-500' }}">Total Tiket</span>
                <span class="p-1.5 rounded-lg {{ $activeTab === 'all' && !request('status') ? 'bg-white/20' : 'bg-blue-50 text-blue-600' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </span>
            </div>
            <div class="text-2xl font-black font-['Plus_Jakarta_Sans']">{{ $stats['all'] }}</div>
            <span class="text-[11px] {{ $activeTab === 'all' && !request('status') ? 'text-blue-100' : 'text-slate-400' }}">Semua Permohonan</span>
        </a>

        <!-- Layanan Online -->
        <a href="{{ route('admin.ult.index', ['tab' => 'online']) }}" 
           class="p-4 rounded-2xl border transition-all duration-300 {{ $activeTab === 'online' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/25 border-transparent' : 'bg-white/70 backdrop-blur-md border-white/60 hover:border-blue-300 hover:shadow-sm text-slate-800' }}">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold uppercase tracking-wider {{ $activeTab === 'online' ? 'text-blue-100' : 'text-slate-500' }}">Online</span>
                <span class="p-1.5 rounded-lg {{ $activeTab === 'online' ? 'bg-white/20' : 'bg-sky-50 text-sky-600' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                </span>
            </div>
            <div class="text-2xl font-black font-['Plus_Jakarta_Sans']">{{ $stats['online'] }}</div>
            <span class="text-[11px] {{ $activeTab === 'online' ? 'text-blue-100' : 'text-slate-400' }}">Permohonan Daring</span>
        </a>

        <!-- Layanan Tatap Muka -->
        <a href="{{ route('admin.ult.index', ['tab' => 'tatap_muka']) }}" 
           class="p-4 rounded-2xl border transition-all duration-300 {{ $activeTab === 'tatap_muka' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/25 border-transparent' : 'bg-white/70 backdrop-blur-md border-white/60 hover:border-blue-300 hover:shadow-sm text-slate-800' }}">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold uppercase tracking-wider {{ $activeTab === 'tatap_muka' ? 'text-blue-100' : 'text-slate-500' }}">Tatap Muka</span>
                <span class="p-1.5 rounded-lg {{ $activeTab === 'tatap_muka' ? 'bg-white/20' : 'bg-emerald-50 text-emerald-600' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </span>
            </div>
            <div class="text-2xl font-black font-['Plus_Jakarta_Sans']">{{ $stats['tatap_muka'] }}</div>
            <span class="text-[11px] {{ $activeTab === 'tatap_muka' ? 'text-blue-100' : 'text-slate-400' }}">Kunjungan Meja ULT</span>
        </a>

        <!-- Layanan Keliling -->
        <a href="{{ route('admin.ult.index', ['tab' => 'keliling']) }}" 
           class="p-4 rounded-2xl border transition-all duration-300 {{ $activeTab === 'keliling' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/25 border-transparent' : 'bg-white/70 backdrop-blur-md border-white/60 hover:border-blue-300 hover:shadow-sm text-slate-800' }}">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold uppercase tracking-wider {{ $activeTab === 'keliling' ? 'text-blue-100' : 'text-slate-500' }}">Keliling</span>
                <span class="p-1.5 rounded-lg {{ $activeTab === 'keliling' ? 'bg-white/20' : 'bg-amber-50 text-amber-600' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                </span>
            </div>
            <div class="text-2xl font-black font-['Plus_Jakarta_Sans']">{{ $stats['keliling'] }}</div>
            <span class="text-[11px] {{ $activeTab === 'keliling' ? 'text-blue-100' : 'text-slate-400' }}">Mobile Service</span>
        </a>

        <!-- Pending / Menunggu -->
        <a href="{{ route('admin.ult.index', ['status' => 'pending']) }}" 
           class="p-4 rounded-2xl border transition-all duration-300 {{ request('status') === 'pending' ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/25 border-transparent' : 'bg-white/70 backdrop-blur-md border-white/60 hover:border-amber-300 hover:shadow-sm text-slate-800' }}">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold uppercase tracking-wider {{ request('status') === 'pending' ? 'text-amber-100' : 'text-slate-500' }}">Pending</span>
                <span class="p-1.5 rounded-lg {{ request('status') === 'pending' ? 'bg-white/20' : 'bg-amber-50 text-amber-600' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
            </div>
            <div class="text-2xl font-black font-['Plus_Jakarta_Sans']">{{ $stats['pending'] }}</div>
            <span class="text-[11px] {{ request('status') === 'pending' ? 'text-amber-100' : 'text-amber-600 font-medium' }}">Perlu Ditindaklanjuti</span>
        </a>
    </div>

    <!-- FILTER & ACTION BAR -->
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 bg-white/60 backdrop-blur-xl border border-white/60 shadow-xs rounded-3xl p-5">
        <!-- Tab Navigasi Tipe Layanan -->
        <div class="flex items-center gap-1.5 p-1 bg-slate-100/80 rounded-2xl w-full md:w-auto overflow-x-auto">
            <a href="{{ route('admin.ult.index', array_merge(request()->except('tab', 'page'), ['tab' => 'all'])) }}"
               class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all shrink-0 {{ $activeTab === 'all' ? 'bg-white text-blue-600 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Semua Tipe
            </a>
            <a href="{{ route('admin.ult.index', array_merge(request()->except('tab', 'page'), ['tab' => 'online'])) }}"
               class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all shrink-0 {{ $activeTab === 'online' ? 'bg-white text-blue-600 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Online ({{ $stats['online'] }})
            </a>
            <a href="{{ route('admin.ult.index', array_merge(request()->except('tab', 'page'), ['tab' => 'tatap_muka'])) }}"
               class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all shrink-0 {{ $activeTab === 'tatap_muka' ? 'bg-white text-blue-600 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Tatap Muka ({{ $stats['tatap_muka'] }})
            </a>
            <a href="{{ route('admin.ult.index', array_merge(request()->except('tab', 'page'), ['tab' => 'keliling'])) }}"
               class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all shrink-0 {{ $activeTab === 'keliling' ? 'bg-white text-blue-600 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Keliling ({{ $stats['keliling'] }})
            </a>
        </div>

        <!-- Search & Filter Form -->
        <form method="GET" action="{{ route('admin.ult.index') }}" class="flex flex-wrap items-center gap-2.5 w-full md:w-auto">
            <input type="hidden" name="tab" value="{{ $activeTab }}">
            
            <div class="relative flex-1 sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari tiket, nama, instansi..."
                       class="w-full bg-white/80 border border-slate-200/80 rounded-xl pl-9 pr-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all text-slate-800 placeholder-slate-400">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <select name="status" onchange="this.form.submit()" class="py-2 px-3 bg-white/80 border border-slate-200/80 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/50 cursor-pointer">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>

            <button type="submit" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-semibold shadow-xs transition-colors">
                Filter
            </button>

            @if(request()->filled('search') || request()->filled('status'))
                <a href="{{ route('admin.ult.index', ['tab' => $activeTab]) }}" class="text-xs text-slate-500 hover:text-slate-800 underline">Reset</a>
            @endif

            <!-- Ekspor CSV -->
            <a href="{{ route('admin.ult.export', request()->all()) }}" 
               class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-xs transition-colors shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                <span>Unduh CSV</span>
            </a>
        </form>
    </div>

    <!-- MAIN TABLE GLASSMORPHISM -->
    <div class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-[0_8px_30px_rgb(0,0,0,0.03)] rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-slate-200/60 text-slate-500 text-[11px] font-bold uppercase tracking-wider bg-slate-50/50">
                        <th class="py-4 px-5">Nomor Tiket & Tipe</th>
                        <th class="py-4 px-5">Pemohon & Kontak</th>
                        <th class="py-4 px-5">Instansi & Kategori</th>
                        <th class="py-4 px-5">Tanggal Masuk</th>
                        <th class="py-4 px-5 text-center">Status</th>
                        <th class="py-4 px-5 text-center">Lampiran</th>
                        <th class="py-4 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/60 text-slate-700">
                    @forelse($requests as $item)
                        <tr class="border-b border-slate-100/60 hover:bg-blue-50/30 transition-colors">
                            <!-- Nomor Tiket & Tipe -->
                            <td class="py-4 px-5">
                                <span class="font-mono font-bold text-slate-900 block text-xs tracking-wide">
                                    {{ $item->ticket_number }}
                                </span>
                                @if($item->layanan_type === 'online')
                                    <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-sky-100 text-sky-700 border border-sky-200">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                        Online
                                    </span>
                                @elseif($item->layanan_type === 'tatap_muka')
                                    <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        Tatap Muka
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 border border-amber-200">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                                        Keliling
                                    </span>
                                @endif
                            </td>

                            <!-- Pemohon & Kontak -->
                            <td class="py-4 px-5">
                                <div class="font-bold text-slate-900 text-sm">{{ $item->nama }}</div>
                                <div class="text-[11px] text-slate-500 flex flex-col gap-0.5 mt-0.5">
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->no_hp) }}" target="_blank" class="hover:text-emerald-600 transition-colors flex items-center gap-1">
                                        <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.353.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.174.086.275.072.376-.043.101-.116.433-.506.549-.68.116-.173.231-.144.39-.086s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824z"/></svg>
                                        {{ $item->no_hp }}
                                    </a>
                                    @if($item->email)
                                        <span class="text-slate-400">{{ $item->email }}</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Instansi & Kategori -->
                            <td class="py-4 px-5">
                                <div class="font-medium text-slate-800">{{ $item->instansi ?? '-' }}</div>
                                <div class="text-[11px] text-blue-600 font-semibold mt-0.5 line-clamp-1" title="{{ $item->kategori }}">
                                    {{ $item->kategori }}
                                </div>
                                @if($item->profesi)
                                    <span class="text-[10px] text-slate-400 block">({{ $item->profesi }})</span>
                                @endif
                            </td>

                            <!-- Tanggal Masuk -->
                            <td class="py-4 px-5 text-slate-500 whitespace-nowrap">
                                <div>{{ $item->created_at->format('d M Y') }}</div>
                                <span class="text-[10px] text-slate-400 font-mono">{{ $item->created_at->format('H:i') }} WITA</span>
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-5 text-center">
                                @if($item->status === 'pending')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800 border border-amber-200 shadow-2xs">
                                        Pending
                                    </span>
                                @elseif($item->status === 'diproses')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-100 text-blue-800 border border-blue-200 shadow-2xs">
                                        Diproses
                                    </span>
                                @elseif($item->status === 'selesai')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200 shadow-2xs">
                                        Selesai
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800 border border-rose-200 shadow-2xs">
                                        Ditolak
                                    </span>
                                @endif
                            </td>

                            <!-- Lampiran Dokumen -->
                            <td class="py-4 px-5 text-center">
                                @if($item->dokumen_path)
                                    <a href="{{ Storage::disk('public')->url($item->dokumen_path) }}" target="_blank"
                                       class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-blue-50 text-blue-600 border border-slate-200 text-[11px] font-bold transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Berkas
                                    </a>
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="py-4 px-5 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Tombol Detail / Tindak Lanjut -->
                                    <button type="button"
                                            @click="openDetail({{ json_encode($item) }}, '{{ route('admin.ult.status.update', $item) }}')"
                                            class="px-2.5 py-1.5 bg-blue-50 hover:bg-blue-600 hover:text-white text-blue-600 rounded-lg text-xs font-bold transition-all flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Detail
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.ult.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tiket permohonan {{ $item->ticket_number }} ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-3 text-slate-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                </div>
                                <span class="font-medium text-slate-600 block">Tidak ada permohonan layanan ditemukan</span>
                                <span class="text-xs text-slate-400">Silakan ubah kata kunci pencarian atau filter status.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($requests->hasPages())
            <div class="p-5 border-t border-slate-100/60 bg-slate-50/30">
                {{ $requests->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL DETAIL & UPDATE STATUS (GLASSMORPHISM) -->
    <div x-show="detailModalOpen"
         style="display: none;"
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
        <!-- Backdrop Glassmorphism -->
        <div x-show="detailModalOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/50 backdrop-blur-md transition-opacity"
             @click="detailModalOpen = false"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div x-show="detailModalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-white/60">

                <template x-if="selectedItem">
                    <div>
                        <!-- Modal Header -->
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-5 text-white flex items-center justify-between">
                            <div>
                                <span class="text-xs uppercase font-bold tracking-wider text-blue-200">Detail Permohonan Layanan</span>
                                <h3 class="text-lg font-black font-['Plus_Jakarta_Sans'] flex items-center gap-2 mt-0.5">
                                    <span x-text="selectedItem.ticket_number"></span>
                                </h3>
                            </div>
                            <button @click="detailModalOpen = false" class="text-white/80 hover:text-white transition-colors p-1 rounded-lg hover:bg-white/10">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="p-6 space-y-5 max-h-[70vh] overflow-y-auto">
                            <!-- Ringkasan Info -->
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 p-4 bg-slate-50/80 rounded-2xl border border-slate-100 text-xs">
                                <div>
                                    <span class="text-slate-400 block text-[10px] uppercase font-bold">Tipe Layanan</span>
                                    <span class="font-bold text-slate-800 capitalize" x-text="selectedItem.layanan_type.replace('_', ' ')"></span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[10px] uppercase font-bold">Waktu Submit</span>
                                    <span class="font-semibold text-slate-800" x-text="new Date(selectedItem.created_at).toLocaleString('id-ID')"></span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[10px] uppercase font-bold">Status Saat Ini</span>
                                    <span class="font-bold text-blue-600 uppercase" x-text="selectedItem.status"></span>
                                </div>
                            </div>

                            <!-- Data Pemohon -->
                            <div class="space-y-3">
                                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Identitas Pemohon / Tamu</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs bg-white p-4 rounded-2xl border border-slate-100">
                                    <div>
                                        <span class="text-slate-400 block text-[10px]">Nama Lengkap</span>
                                        <span class="font-bold text-slate-900 text-sm" x-text="selectedItem.nama"></span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[10px]">Instansi / Lembaga</span>
                                        <span class="font-semibold text-slate-800" x-text="selectedItem.instansi || '-'"></span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[10px]">No. HP / WhatsApp</span>
                                        <span class="font-semibold text-slate-800" x-text="selectedItem.no_hp"></span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[10px]">Email</span>
                                        <span class="font-semibold text-slate-800" x-text="selectedItem.email || '-'"></span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[10px]">Profesi / Jabatan</span>
                                        <span class="font-semibold text-slate-800" x-text="selectedItem.profesi || '-'"></span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[10px]">Kategori Layanan</span>
                                        <span class="font-bold text-blue-700" x-text="selectedItem.kategori"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Uraian Keperluan -->
                            <div class="space-y-2">
                                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Uraian Maksud / Keperluan</h4>
                                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-xs text-slate-800 leading-relaxed whitespace-pre-line" x-text="selectedItem.keperluan">
                                </div>
                            </div>

                            <!-- Berkas Pendukung -->
                            <template x-if="selectedItem.dokumen_path">
                                <div class="p-3 bg-blue-50/50 rounded-xl border border-blue-100 flex items-center justify-between">
                                    <div class="flex items-center gap-2 text-xs text-blue-900 font-semibold">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                        <span>Berkas Lampiran Pemohon Terlampir</span>
                                    </div>
                                    <a :href="'/storage/' + selectedItem.dokumen_path" target="_blank" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold transition-colors">
                                        Buka Berkas
                                    </a>
                                </div>
                            </template>

                            <hr class="border-slate-100">

                            <!-- Form Update Status & Catatan Petugas -->
                            <form :action="updateStatusAction" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')

                                <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Tindak Lanjut Petugas ULT</h4>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Perbarui Status Permohonan</label>
                                    <select name="status" x-model="selectedItem.status" class="w-full text-xs font-semibold rounded-xl border-slate-200 py-2.5 px-3 focus:ring-2 focus:ring-blue-500/50">
                                        <option value="pending">Pending (Menunggu Otorisasi/Verifikasi)</option>
                                        <option value="diproses">Diproses (Sedang Dikerjakan / Dikoordinasikan)</option>
                                        <option value="selesai">Selesai (Layanan Telah Diberikan)</option>
                                        <option value="ditolak">Ditolak (Permohonan Tidak Sesuai Ketentuan)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Catatan Tindak Lanjut / Keterangan Petugas</label>
                                    <textarea name="catatan_petugas" rows="3" x-model="selectedItem.catatan_petugas" placeholder="Tambahkan catatan tindak lanjut, disposisi, atau keterangan penyelesaian..."
                                              class="w-full text-xs rounded-xl border-slate-200 py-2 px-3 focus:ring-2 focus:ring-blue-500/50"></textarea>
                                </div>

                                <div class="flex items-center justify-end gap-2 pt-2">
                                    <button type="button" @click="detailModalOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-colors">
                                        Batal
                                    </button>
                                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-md shadow-blue-500/25 transition-colors">
                                        Simpan Perubahan Status
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

</div>
@endsection

