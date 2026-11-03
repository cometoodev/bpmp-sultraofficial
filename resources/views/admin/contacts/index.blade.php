@extends('layouts.admin')

@section('title', 'Pesan Masuk (Hubungi Kami)')
@section('header_title', 'Pesan Masuk')
@section('header_subtitle', 'Rekapitulasi pesan, aspirasi, dan pertanyaan dari pengunjung melalui formulir Hubungi Kami')

@section('content')
<div class="space-y-6" x-data="{ 
    selectedMessage: null,
    showDetailModal: false,
    openDetail(item) {
        this.selectedMessage = item;
        this.showDetailModal = true;
    }
}">

    <!-- STATS CARDS (Glassmorphism) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Total Pesan -->
        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-5 border border-white/80 shadow-xs relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pesan</p>
                    <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ number_format($stats['total'] ?? $messages->total()) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <div class="mt-3 text-[11px] text-slate-500 font-medium">Semua pesan dari formulir Hubungi Kami</div>
        </div>

        <!-- Pesan Hari Ini -->
        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-5 border border-white/80 shadow-xs relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-emerald-500 uppercase tracking-wider">Hari Ini</p>
                    <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ number_format($stats['today'] ?? 0) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="mt-3 text-[11px] text-slate-500 font-medium">Pesan masuk hari ini</div>
        </div>

        <!-- Pesan Bulan Ini -->
        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-5 border border-white/80 shadow-xs relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-blue-500 uppercase tracking-wider">Bulan Ini</p>
                    <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ number_format($stats['this_month'] ?? 0) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <div class="mt-3 text-[11px] text-slate-500 font-medium">{{ now()->translatedFormat('F Y') }}</div>
        </div>
    </div>

    <!-- FILTER & SEARCH BAR -->
    <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-4 border border-white/80 shadow-xs flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
        <form action="{{ route('admin.contacts.index') }}" method="GET" class="flex flex-1 flex-col sm:flex-row items-center gap-3">
            <div class="relative w-full sm:w-80">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, email, subjek, pesan..."
                    class="w-full bg-white border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-xs text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            <button type="submit" class="w-full sm:w-auto px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow-xs">
                Cari
            </button>

            @if(request()->filled('q'))
                <a href="{{ route('admin.contacts.index') }}" class="text-xs text-slate-500 hover:text-slate-800 underline">Reset</a>
            @endif
        </form>

        <a href="{{ url('/kontak') }}" target="_blank" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition-all flex items-center justify-center gap-1.5 shrink-0" title="Buka Halaman Kontak Publik">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            <span>Buka Halaman Kontak Publik</span>
        </a>
    </div>

    <!-- FLASH MESSAGES -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- TABEL DATA (Glassmorphism) -->
    <div class="bg-white/70 backdrop-blur-xl rounded-2xl border border-white/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Pengirim</th>
                        <th class="py-3.5 px-4">Subjek</th>
                        <th class="py-3.5 px-4">Uraian Pesan</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Waktu Masuk</th>
                        <th class="py-3.5 px-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($messages as $index => $msg)
                        <tr class="hover:bg-indigo-50/30 transition-colors">
                            <td class="py-3.5 px-4 text-center text-slate-400">
                                {{ $messages->firstItem() + $index }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-800">{{ $msg->name }}</div>
                                <div class="text-[11px] text-indigo-600 font-semibold flex items-center gap-1 mt-0.5">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <a href="mailto:{{ $msg->email }}" class="hover:underline">{{ $msg->email }}</a>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded-md text-[11px]">
                                    {{ $msg->subject }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 max-w-xs">
                                <p class="text-slate-600 line-clamp-2 leading-relaxed">
                                    {{ $msg->message }}
                                </p>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-[11px] text-slate-500">
                                <div class="font-bold text-slate-700">{{ $msg->created_at->format('d M Y') }}</div>
                                <div>{{ $msg->created_at->format('H:i') }} WITA</div>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Tombol Baca Detail -->
                                    <button type="button" 
                                        @click="openDetail({{ json_encode($msg) }})"
                                        class="p-2 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 transition-colors"
                                        title="Baca Pesan Lengkap">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.contacts.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors" title="Hapus Pesan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                    <p class="text-sm font-semibold">Belum ada pesan masuk</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="p-4 border-t border-slate-100 bg-white/50">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL DETAIL PESAN (Glassmorphic Modal) -->
    <template x-teleport="body">
        <div x-show="showDetailModal" class="fixed inset-0 z-[999] flex items-center justify-center p-4" style="display: none;">
            <!-- Backdrop -->
            <div x-show="showDetailModal" x-transition.opacity class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showDetailModal = false"></div>

            <!-- Modal Content Card -->
            <div x-show="showDetailModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 class="relative bg-white/95 backdrop-blur-2xl border border-white/80 rounded-3xl shadow-2xl p-6 sm:p-8 w-full max-w-xl flex flex-col text-left">
                
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                            ✉️
                        </div>
                        <div>
                            <h3 class="text-base font-extrabold text-slate-800">Detail Pesan Masuk</h3>
                            <p class="text-xs text-slate-500" x-text="selectedMessage ? selectedMessage.email : ''"></p>
                        </div>
                    </div>
                    <button @click="showDetailModal = false" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="py-4 space-y-4" x-if="selectedMessage">
                    <div>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Pengirim</span>
                        <p class="text-sm font-bold text-slate-800" x-text="selectedMessage ? selectedMessage.name : ''"></p>
                    </div>

                    <div>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Subjek</span>
                        <p class="text-sm font-bold text-indigo-700 bg-indigo-50 px-3 py-1.5 rounded-xl inline-block mt-1" x-text="selectedMessage ? selectedMessage.subject : ''"></p>
                    </div>

                    <div>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Isi Pesan</span>
                        <div class="mt-1 p-4 bg-slate-50 rounded-2xl border border-slate-200 text-sm leading-relaxed text-slate-700 whitespace-pre-wrap max-h-60 overflow-y-auto" x-text="selectedMessage ? selectedMessage.message : ''"></div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                    <a :href="'mailto:' + (selectedMessage ? selectedMessage.email : '') + '?subject=Re: ' + encodeURIComponent(selectedMessage ? selectedMessage.subject : '')"
                       class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-bold text-xs hover:bg-indigo-700 transition-all flex items-center gap-1.5 shadow-md shadow-indigo-600/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                        <span>Balas via Email</span>
                    </a>

                    <button @click="showDetailModal = false" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200 transition-all">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </template>

</div>
@endsection

