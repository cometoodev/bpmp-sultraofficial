@extends('layouts.admin')

@section('title', 'Manajemen Events & Webinar')
@section('header_title', 'Events & Webinar')
@section('header_subtitle', 'Kelola jadwal webinar, workshop, atau event luring beserta tautan Instagram resminya')

@section('content')
<div class="space-y-8" x-data="{
    editModalOpen: false,
    editId: null,
    editTitle: '',
    editType: 'Webinar',
    editDate: '',
    editOrganizer: '',
    editInstagramUrl: '',
    editActionUrl: '',
    openEdit(item, url) {
        this.editId = item.id;
        this.editTitle = item.title;
        this.editType = item.type;
        this.editDate = item.event_date.replace(' ', 'T').substring(0, 16);
        this.editOrganizer = item.organizer;
        this.editInstagramUrl = item.instagram_url;
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
        <!-- Form Tambah (Kolom Kiri: 4 Kolom) -->
        <div class="lg:col-span-4 bg-white/90 backdrop-blur-xl p-6 sm:p-7 rounded-3xl shadow-sm border border-slate-200/80 sticky top-6">
            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-base leading-tight">Tambah Event / Webinar</h3>
                    <p class="text-xs text-slate-500">Tampil di beranda dan halaman agenda.</p>
                </div>
            </div>

            <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Judul Kegiatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: Gelar Karya Inovasi..."
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all">
                    @error('title') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Kategori Kegiatan <span class="text-rose-500">*</span></label>
                    <select name="type" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500 cursor-pointer">
                        <option value="Webinar" {{ old('type') === 'Webinar' ? 'selected' : '' }}>🎥 Webinar (Sesi Daring)</option>
                        <option value="Event" {{ old('type') === 'Event' ? 'selected' : '' }}>🏛️ Event (Kegiatan Luring)</option>
                    </select>
                    @error('type') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Tanggal & Waktu Acara <span class="text-rose-500">*</span></label>
                    <input type="datetime-local" name="event_date" required value="{{ old('event_date', date('Y-m-d\TH:i')) }}"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all">
                    @error('event_date') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Penyelenggara (Oleh) <span class="text-rose-500">*</span></label>
                    <input type="text" name="organizer" required value="{{ old('organizer', 'BPMP Provinsi Sulawesi Tenggara') }}" placeholder="BPMP Sultra / Kemendikdasmen..."
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all">
                    @error('organizer') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Link Instagram / Informasi <span class="text-rose-500">*</span></label>
                    <input type="url" name="instagram_url" required value="{{ old('instagram_url') }}" placeholder="https://www.instagram.com/p/..."
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all">
                    @error('instagram_url') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Upload Poster Banner (Opsional)</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs text-slate-600 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                    @error('image') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-indigo-600/25 transition-all flex items-center justify-center gap-2 cursor-pointer mt-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>Simpan Event</span>
                </button>
            </form>
        </div>

        <!-- Tabel Rekap Data (Kolom Kanan: 8 Kolom) -->
        <div class="lg:col-span-8 bg-white/90 backdrop-blur-xl rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-2.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span>
                    <h3 class="font-extrabold text-slate-800 text-sm">Daftar Event &amp; Webinar Aktif</h3>
                </div>
                <span class="text-xs font-bold text-indigo-700 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">
                    Total: {{ $events->total() }} Data
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-xs font-extrabold text-slate-500 uppercase tracking-wider">
                            <th class="py-3.5 px-5">Kegiatan</th>
                            <th class="py-3.5 px-5">Kategori</th>
                            <th class="py-3.5 px-5">Jadwal &amp; Status</th>
                            <th class="py-3.5 px-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                        @forelse($events as $item)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-4 px-5">
                                    <div class="flex items-start gap-3">
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-12 h-12 rounded-xl object-cover shrink-0 border border-slate-200">
                                        @else
                                            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 border border-indigo-100">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <h4 class="font-bold text-slate-900 text-sm leading-snug">{{ $item->title }}</h4>
                                            <span class="block text-xs text-slate-400 font-medium mt-0.5">Oleh: {{ $item->organizer }}</span>
                                            <a href="{{ $item->instagram_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-[11px] text-blue-600 hover:underline mt-1 font-semibold">
                                                <span>🔗 Tautan IG</span>
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-5 whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-indigo-50 text-indigo-600 border border-indigo-100">
                                        {{ $item->type === 'Webinar' ? '🎥 Webinar' : '🏛️ Event' }}
                                    </span>
                                </td>
                                <td class="py-4 px-5 whitespace-nowrap text-xs">
                                    <div class="flex flex-col">
                                        <span class="font-extrabold text-slate-800">{{ \Carbon\Carbon::parse($item->event_date)->translatedFormat('d M Y, H:i') }} WITA</span>
                                        @php $status = $item->status; @endphp
                                        <span class="inline-flex items-center gap-1 mt-1 font-bold {{ $status === 'Selesai' ? 'text-slate-400' : 'text-emerald-600' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $status === 'Selesai' ? 'bg-slate-400' : 'bg-emerald-500' }}"></span>
                                            {{ $status }}
                                        </span>
                                    </div>
                                </td>
                                <td class="py-4 px-5 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Tombol Edit Modal -->
                                        <button type="button"
                                                @click='openEdit(@json($item), "{{ route("admin.events.update", $item) }}")'
                                                title="Edit Event"
                                                class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition-all cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('admin.events.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus Event" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white flex items-center justify-center transition-all cursor-pointer">
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
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                        </div>
                                        <span class="font-bold text-slate-600">Belum ada data event atau webinar.</span>
                                        <span class="text-xs text-slate-400">Gunakan formulir di sebelah kiri untuk menambah event baru.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($events->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $events->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- MODAL EDIT EVENT (Glassmorphic) -->
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
                 class="relative bg-white rounded-3xl shadow-2xl border border-slate-200 p-6 sm:p-8 w-full max-w-lg z-10 max-h-[90vh] overflow-y-auto">
                
                <div class="flex items-center justify-between pb-4 mb-5 border-b border-slate-100">
                    <h3 class="font-extrabold text-slate-800 text-lg">Edit Event / Webinar</h3>
                    <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-slate-700 text-xl font-bold">&times;</button>
                </div>

                <form :action="editActionUrl" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Judul Kegiatan *</label>
                        <input type="text" name="title" x-model="editTitle" required
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Kategori Kegiatan *</label>
                        <select name="type" x-model="editType" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500 cursor-pointer">
                            <option value="Webinar">🎥 Webinar (Sesi Daring)</option>
                            <option value="Event">🏛️ Event (Kegiatan Luring)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Tanggal & Waktu Acara *</label>
                        <input type="datetime-local" name="event_date" x-model="editDate" required
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Penyelenggara *</label>
                        <input type="text" name="organizer" x-model="editOrganizer" required
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Link Instagram / Informasi *</label>
                        <input type="url" name="instagram_url" x-model="editInstagramUrl" required
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Ganti Poster (Opsional)</label>
                        <input type="file" name="image" accept="image/*"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs text-slate-600 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                        <button type="button" @click="editModalOpen = false" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50 cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-md shadow-indigo-600/25 cursor-pointer">
                            Perbarui Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>

</div>
@endsection

