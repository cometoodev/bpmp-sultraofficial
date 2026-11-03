@extends('layouts.admin')

@section('title', 'Rekapitulasi Lapor Gratifikasi')
@section('header_title', 'Lapor Gratifikasi')
@section('header_subtitle', 'Rekapitulasi laporan pengendalian gratifikasi internal pegawai BPMP Provinsi Sulawesi Tenggara')

@section('content')
<div class="space-y-6">

    <!-- STATS CARDS (Glassmorphism) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Laporan -->
        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-5 border border-white/80 shadow-xs relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Laporan</p>
                    <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ number_format($stats['total'] ?? $reports->total()) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
            </div>
            <div class="mt-3 text-[11px] text-slate-500 font-medium">Rekapitulasi instrumen gratifikasi masuk</div>
        </div>

        <!-- Menunggu Verifikasi -->
        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-5 border border-white/80 shadow-xs relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-amber-500 uppercase tracking-wider">Menunggu</p>
                    <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ number_format($stats['pending'] ?? 0) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="mt-3 text-[11px] text-slate-500 font-medium">Laporan baru belum diverifikasi tim UPG</div>
        </div>

        <!-- Terverifikasi -->
        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-5 border border-white/80 shadow-xs relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-blue-500 uppercase tracking-wider">Terverifikasi</p>
                    <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ number_format($stats['verified'] ?? 0) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
            </div>
            <div class="mt-3 text-[11px] text-slate-500 font-medium">Telah diperiksa kelengkapan datanya</div>
        </div>

        <!-- Telah Dicatat (Recorded) -->
        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-5 border border-white/80 shadow-xs relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-emerald-500 uppercase tracking-wider">Tercatat di UPG</p>
                    <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ number_format($stats['recorded'] ?? 0) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
            </div>
            <div class="mt-3 text-[11px] text-slate-500 font-medium">Selesai dicatat dalam register UPG Balai</div>
        </div>
    </div>

    <!-- FILTER & SEARCH BAR -->
    <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-4 border border-white/80 shadow-xs flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
        <form action="{{ route('admin.gratification.index') }}" method="GET" class="flex flex-1 flex-col sm:flex-row items-center gap-3">
            <div class="relative w-full sm:w-80">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama pegawai, NIP, kegiatan..."
                    class="w-full bg-white border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-xs text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            <select name="status" onchange="this.form.submit()" class="w-full sm:w-auto bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu (Pending)</option>
                <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                <option value="recorded" {{ request('status') === 'recorded' ? 'selected' : '' }}>Tercatat di UPG</option>
            </select>

            <button type="submit" class="w-full sm:w-auto px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow-xs">
                Filter
            </button>

            @if(request()->hasAny(['q', 'status']))
                <a href="{{ route('admin.gratification.index') }}" class="text-xs text-slate-500 hover:text-slate-800 underline">Reset</a>
            @endif
        </form>

        <a href="{{ url('/lapor-gratifikasi') }}" target="_blank" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition-all flex items-center justify-center gap-1.5 shrink-0" title="Buka Formulir Publik Lapor Gratifikasi">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            <span>Buka Form Publik</span>
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-semibold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- TABEL DATA GRATIFIKASI -->
    <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-4 px-6 text-center w-14">No</th>
                        <th class="py-4 px-6">Pegawai Pelapor</th>
                        <th class="py-4 px-6">Kegiatan & Lokasi</th>
                        <th class="py-4 px-6">Layanan Bebas Biaya</th>
                        <th class="py-4 px-6">Ole-Ole / Bingkisan</th>
                        <th class="py-4 px-6 text-center">Status</th>
                        <th class="py-4 px-6">Tanggal Lapor</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                    @forelse($reports as $index => $item)
                        @php
                            $services = $item->free_services_array;
                            $gifts = $item->gift_consumable_types_array;
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-6 text-center font-semibold text-xs text-slate-400">
                                {{ $reports->firstItem() + $index }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-800">{{ $item->name }}</div>
                                <div class="text-xs text-slate-500">{{ $item->position }}</div>
                                @if($item->nip && $item->nip !== '0')
                                    <div class="text-[11px] font-mono text-slate-400 mt-0.5">NIP: {{ $item->nip }}</div>
                                @endif
                                <div class="text-[11px] text-indigo-600 mt-0.5">{{ $item->email }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-xs text-slate-800 max-w-xs leading-snug">{{ $item->activity_name }}</div>
                                <div class="text-[11px] text-slate-400 mt-1 flex items-center gap-1">
                                    <span>📍 {{ $item->activity_location }}</span>
                                    @if($item->activity_date)
                                        <span>•</span>
                                        <span>📅 {{ $item->activity_date->translatedFormat('d M Y') }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                @if(empty($services) || in_array('tidak menerima', array_map('strtolower', $services)))
                                    <span class="inline-block px-2 py-0.5 rounded-md text-[11px] font-medium bg-slate-100 text-slate-500">
                                        Tidak ada
                                    </span>
                                @else
                                    <div class="flex flex-wrap gap-1 max-w-xs">
                                        @foreach($services as $s)
                                            <span class="inline-block px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                                {{ $s }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if((empty($gifts) || in_array('tidak menerima', array_map('strtolower', $gifts))) && (!$item->gift_non_consumable_desc || strtolower($item->gift_non_consumable_desc) === 'tidak menerima'))
                                    <span class="inline-block px-2 py-0.5 rounded-md text-[11px] font-medium bg-slate-100 text-slate-500">
                                        Tidak ada
                                    </span>
                                @else
                                    <div class="flex flex-wrap gap-1 max-w-xs">
                                        @foreach($gifts as $g)
                                            @if(strtolower($g) !== 'tidak menerima')
                                                <span class="inline-block px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    {{ $g }}
                                                </span>
                                            @endif
                                        @endforeach
                                    </div>
                                    @if($item->follow_up_action)
                                        <div class="text-[10px] text-slate-400 mt-1 font-medium">
                                            Tindak lanjut: <span class="text-slate-600 font-semibold">{{ $item->follow_up_action }}</span>
                                        </div>
                                    @endif
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                @if($item->status === 'recorded')
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Tercatat di UPG
                                    </span>
                                @elseif($item->status === 'verified')
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                                        Terverifikasi
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                        Menunggu
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-500 whitespace-nowrap">
                                <div>{{ $item->created_at->translatedFormat('d M Y') }}</div>
                                <div class="text-[10px] text-slate-400 font-mono">{{ $item->created_at->format('H:i') }} WITA</div>
                            </td>
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Tombol Detail -->
                                    <a href="{{ route('admin.gratification.show', $item->id) }}" class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all shadow-xs" title="Lihat Detail Lengkap">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.gratification.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data laporan gratifikasi ini? File bukti juga akan terhapus.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-xl bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all shadow-xs" title="Hapus Laporan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400 text-xs">
                                <svg class="w-12 h-12 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                <p class="font-semibold text-sm text-slate-600">Belum ada laporan gratifikasi yang masuk.</p>
                                <p class="text-xs text-slate-400 mt-1">Laporan dari formulir multi-tahap di website akan otomatis tercatat di sini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reports->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $reports->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

