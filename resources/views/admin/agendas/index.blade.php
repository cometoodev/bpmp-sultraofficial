@extends('layouts.admin')

@section('title', 'Manajemen Agenda & Kegiatan')
@section('header_title', 'Agenda & Kegiatan')
@section('header_subtitle', 'Kelola jadwal agenda, rapat, dan kegiatan resmi BPMP Sultra secara real-time')

@section('content')
<div class="space-y-8" x-data="{
    editModalOpen: false,
    editId: null,
    editTitle: '',
    editDate: '',
    editTimeStart: '',
    editTimeEnd: '',
    editDescription: '',
    editActionUrl: '',
    openEdit(item, url) {
        this.editId = item.id;
        this.editTitle = item.title;
        this.editDate = item.agenda_date.substring(0, 10);
        this.editTimeStart = item.time_start;
        this.editTimeEnd = item.time_end;
        this.editDescription = item.description || '';
        this.editActionUrl = url;
        this.editModalOpen = true;
    }
}">

    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 text-emerald-800 border border-emerald-200 text-sm font-semibold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 text-sm font-bold">&times;</button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Form Tambah Agenda (Kolom Kiri: 4 kolom) -->
        <div class="lg:col-span-4 bg-white/90 backdrop-blur-xl p-6 sm:p-7 rounded-3xl shadow-sm border border-slate-200/80 sticky top-6">
            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-base leading-tight">Tambah Agenda Baru</h3>
                    <p class="text-xs text-slate-500">Jadwal akan otomatis masuk ke kalender utama.</p>
                </div>
            </div>

            <form action="{{ route('admin.agendas.store') }}" method="POST" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Judul Kegiatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: Rapat Koordinasi Pokja..."
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all">
                    @error('title') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Tanggal Kegiatan <span class="text-rose-500">*</span></label>
                    <input type="date" name="agenda_date" required value="{{ old('agenda_date', date('Y-m-d')) }}"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all">
                    @error('agenda_date') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Jam Mulai <span class="text-rose-500">*</span></label>
                        <input type="text" name="time_start" value="{{ old('time_start', '08.00') }}" required placeholder="08.00"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all">
                        @error('time_start') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Jam Selesai <span class="text-rose-500">*</span></label>
                        <input type="text" name="time_end" value="{{ old('time_end', '16.00') }}" required placeholder="16.00"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all">
                        @error('time_end') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Keterangan / Lokasi (Opsional)</label>
                    <textarea name="description" rows="3" placeholder="Catatan tempat, ruangan, atau tautan daring..."
                              class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all resize-none">{{ old('description') }}</textarea>
                    @error('description') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-indigo-600/25 transition-all flex items-center justify-center gap-2 cursor-pointer mt-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>Simpan Agenda</span>
                </button>
            </form>
        </div>

        <!-- Tabel Daftar Agenda (Kolom Kanan: 8 kolom) -->
        <div class="lg:col-span-8 bg-white/90 backdrop-blur-xl rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-2.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span>
                    <h3 class="font-extrabold text-slate-800 text-sm">Daftar Agenda Kegiatan Masuk</h3>
                </div>
                <span class="text-xs font-bold text-indigo-700 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">
                    Total: {{ $agendas->total() }} Agenda
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-xs font-extrabold text-slate-500 uppercase tracking-wider">
                            <th class="py-3.5 px-5">Tanggal</th>
                            <th class="py-3.5 px-5">Kegiatan</th>
                            <th class="py-3.5 px-5">Waktu</th>
                            <th class="py-3.5 px-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                        @forelse($agendas as $item)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-4 px-5 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="font-extrabold text-slate-900 text-sm">{{ \Carbon\Carbon::parse($item->agenda_date)->translatedFormat('d M Y') }}</span>
                                        <span class="text-[11px] text-slate-400 font-medium">{{ \Carbon\Carbon::parse($item->agenda_date)->translatedFormat('l') }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-5">
                                    <h4 class="font-bold text-slate-900 text-sm mb-0.5 leading-snug">{{ $item->title }}</h4>
                                    @if($item->description)
                                        <p class="text-xs text-slate-500 line-clamp-1 mt-0.5">{{ $item->description }}</p>
                                    @endif
                                </td>
                                <td class="py-4 px-5 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-100/60">
                                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span>{{ $item->time_start }} - {{ $item->time_end }} WITA</span>
                                    </span>
                                </td>
                                <td class="py-4 px-5 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Tombol Edit Modal -->
                                        <button type="button"
                                                @click='openEdit(@json($item), "{{ route("admin.agendas.update", $item) }}")'
                                                title="Edit Agenda"
                                                class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition-all cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('admin.agendas.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus agenda kegiatan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus Agenda" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white flex items-center justify-center transition-all cursor-pointer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-slate-400 text-sm">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <span class="font-bold text-slate-600">Belum ada agenda kegiatan yang ditambahkan.</span>
                                        <span class="text-xs text-slate-400">Gunakan formulir di sebelah kiri untuk menambah agenda kegiatan baru.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($agendas->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $agendas->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- MODAL EDIT AGENDA (Glassmorphic) -->
    <template x-teleport="body">
        <div x-show="editModalOpen" class="fixed inset-0 z-[9999] flex items-center justify-center p-4" style="display: none;">
            <div x-show="editModalOpen" x-transition.opacity class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="editModalOpen = false"></div>
            
            <div x-show="editModalOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="relative bg-white rounded-3xl shadow-2xl border border-slate-200 p-6 sm:p-8 w-full max-w-lg z-10">
                
                <div class="flex items-center justify-between pb-4 mb-5 border-b border-slate-100">
                    <h3 class="font-extrabold text-slate-800 text-lg">Edit Agenda Kegiatan</h3>
                    <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-slate-700 text-xl font-bold">&times;</button>
                </div>

                <form :action="editActionUrl" method="POST" class="flex flex-col gap-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Judul Kegiatan *</label>
                        <input type="text" name="title" x-model="editTitle" required
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Tanggal Kegiatan *</label>
                        <input type="date" name="agenda_date" x-model="editDate" required
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Jam Mulai *</label>
                            <input type="text" name="time_start" x-model="editTimeStart" required
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Jam Selesai *</label>
                            <input type="text" name="time_end" x-model="editTimeEnd" required
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Keterangan / Lokasi</label>
                        <textarea name="description" x-model="editDescription" rows="3"
                                  class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500 resize-none"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                        <button type="button" @click="editModalOpen = false" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50 cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-md shadow-indigo-600/25 cursor-pointer">
                            Perbarui Agenda
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>

</div>
@endsection

