@extends('layouts.admin')

@section('title', 'Manajemen Pengaduan SPMB')
@section('header_title', 'Pengaduan SPMB')
@section('header_subtitle', 'Manajemen data laporan, keluhan, dan aspirasi masyarakat melalui saluran SPMB')

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
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                </div>
            </div>
            <div class="mt-3 text-[11px] text-slate-500 font-medium">Semua laporan masuk dari kanal SPMB</div>
        </div>

        <!-- Menunggu Tindak Lanjut -->
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
            <div class="mt-3 text-[11px] text-slate-500 font-medium">Belum diverifikasi atau ditindaklanjuti</div>
        </div>

        <!-- Sedang Diproses -->
        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-5 border border-white/80 shadow-xs relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-blue-500 uppercase tracking-wider">Diproses</p>
                    <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ number_format($stats['processed'] ?? 0) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
            </div>
            <div class="mt-3 text-[11px] text-slate-500 font-medium">Dalam penanganan oleh tim terkait</div>
        </div>

        <!-- Selesai -->
        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-5 border border-white/80 shadow-xs relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-emerald-500 uppercase tracking-wider">Selesai</p>
                    <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ number_format($stats['completed'] ?? 0) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="mt-3 text-[11px] text-slate-500 font-medium">Laporan telah tuntas ditangani</div>
        </div>
    </div>

    <!-- FILTER & SEARCH BAR -->
    <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-4 border border-white/80 shadow-xs flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
        <form action="{{ route('admin.spmb.index') }}" method="GET" class="flex flex-1 flex-col sm:flex-row items-center gap-3">
            <div class="relative w-full sm:w-80">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, email, isi pengaduan..."
                    class="w-full bg-white border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-xs text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            <select name="status" onchange="this.form.submit()" class="w-full sm:w-auto bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu (Pending)</option>
                <option value="processed" {{ request('status') === 'processed' ? 'selected' : '' }}>Sedang Diproses</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
            </select>

            <button type="submit" class="w-full sm:w-auto px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow-xs">
                Filter
            </button>

            @if(request()->hasAny(['q', 'status']))
                <a href="{{ route('admin.spmb.index') }}" class="text-xs text-slate-500 hover:text-slate-800 underline">Reset</a>
            @endif
        </form>

        <a href="{{ url('/spmb') }}" target="_blank" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition-all flex items-center justify-center gap-1.5 shrink-0" title="Buka Formulir Publik SPMB">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            <span>Lihat Halaman Publik</span>
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

    <!-- TABEL DATA PENGADUAN SPMB -->
    <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-4 px-6 text-center w-14">No</th>
                        <th class="py-4 px-6">Pelapor</th>
                        <th class="py-4 px-6">Kontak</th>
                        <th class="py-4 px-6">Isi Pengaduan</th>
                        <th class="py-4 px-6 text-center">Status</th>
                        <th class="py-4 px-6">Tanggal</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                    @forelse($reports as $index => $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-6 text-center font-semibold text-xs text-slate-400">
                                {{ $reports->firstItem() + $index }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-800">{{ $item->name }}</div>
                                <div class="text-xs text-slate-400 line-clamp-1 max-w-xs mt-0.5">📍 {{ $item->address }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <a href="mailto:{{ $item->email }}" class="block text-xs font-medium text-slate-700 hover:text-indigo-600 transition-colors">
                                    ✉️ {{ $item->email }}
                                </a>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->phone) }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-slate-500 hover:text-emerald-600 transition-colors mt-0.5 font-mono">
                                    📞 {{ $item->phone }}
                                </a>
                            </td>
                            <td class="py-4 px-6">
                                <p class="line-clamp-2 text-xs text-slate-700 max-w-sm leading-relaxed">{{ $item->message }}</p>
                                @if($item->evidence_file)
                                    <span class="inline-flex items-center gap-1 mt-1 text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md border border-indigo-100">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                        Ada Lampiran Bukti
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                @if($item->status === 'completed')
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Selesai
                                    </span>
                                @elseif($item->status === 'processed')
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                                        Diproses
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
                                    <a href="{{ route('admin.spmb.show', $item->id) }}" class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all shadow-xs" title="Lihat Detail Pengaduan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.spmb.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data laporan pengaduan ini? File lampiran juga akan terhapus.');">
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
                            <td colspan="7" class="py-12 text-center text-slate-400 text-xs">
                                <svg class="w-12 h-12 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                                <p class="font-semibold text-sm text-slate-600">Belum ada pengaduan masyarakat yang masuk.</p>
                                <p class="text-xs text-slate-400 mt-1">Laporan dari formulir SPMB di website publik akan otomatis tampil di sini.</p>
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

