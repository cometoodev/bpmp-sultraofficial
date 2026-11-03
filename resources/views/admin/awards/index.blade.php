@extends('layouts.admin')

@section('title', 'Manajemen Maklumat & Penghargaan')
@section('header_title', 'Maklumat & Penghargaan')
@section('header_subtitle', 'Kelola piagam penghargaan, sertifikat prestasi, dan maklumat pelayanan resmi')

@section('content')
<div class="space-y-8" x-data="{
    editModalOpen: false,
    editId: null,
    editTitle: '',
    editBadge: '',
    editDescription: '',
    editOrder: 0,
    editActionUrl: '',
    openEdit(item, url) {
        this.editId = item.id;
        this.editTitle = item.title;
        this.editBadge = item.badge;
        this.editDescription = item.description;
        this.editOrder = item.order ?? 0;
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
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-base leading-tight">Tambah Penghargaan</h3>
                    <p class="text-xs text-slate-500">Tampil pada slider di beranda utama.</p>
                </div>
            </div>

            <form action="{{ route('admin.awards.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Judul Penghargaan / Piagam <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: Zona Integritas WBBM..."
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all">
                    @error('title') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Label Badge / Instansi <span class="text-rose-500">*</span></label>
                    <input type="text" name="badge" required value="{{ old('badge') }}" placeholder="Contoh: Penghargaan Kemendikdasmen"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all">
                    @error('badge') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Keterangan / Deskripsi Lengkap <span class="text-rose-500">*</span></label>
                    <textarea name="description" rows="3" required placeholder="Tuliskan keterangan detail penghargaan atau komitmen maklumat..."
                              class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all">{{ old('description') }}</textarea>
                    @error('description') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Urutan Tampil (Order)</label>
                    <input type="number" name="order" value="{{ old('order', 0) }}" min="0" placeholder="0"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none text-slate-800 font-medium focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all">
                    <p class="text-[11px] text-slate-400 mt-1">Semakin kecil angkanya, semakin awal tampil di slider.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Upload Foto Piagam / Sertifikat</label>
                    <input type="file" name="image" accept="image/png,image/jpeg,image/jpg,image/webp"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, WEBP (Maksimal 5MB).</p>
                    @error('image') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="w-full mt-2 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-indigo-600/30 transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Simpan Penghargaan</span>
                </button>
            </form>
        </div>

        <!-- Tabel Daftar Penghargaan (Kolom Kanan: 8 Kolom) -->
        <div class="lg:col-span-8 bg-white/90 backdrop-blur-xl rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Daftar Maklumat & Penghargaan</h3>
                    <p class="text-xs text-slate-500">Total {{ $awards->total() }} penghargaan terdaftar.</p>
                </div>

                <form method="GET" action="{{ route('admin.awards.index') }}" class="relative w-full sm:w-64">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari penghargaan..."
                           class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:bg-white focus:border-indigo-500 outline-none transition-all">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            <th class="py-3.5 px-5">Foto / Piagam</th>
                            <th class="py-3.5 px-5">Judul & Badge</th>
                            <th class="py-3.5 px-5">Deskripsi</th>
                            <th class="py-3.5 px-5 text-center">Urutan</th>
                            <th class="py-3.5 px-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($awards as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-3.5 px-5">
                                    <div class="w-16 h-16 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0 shadow-xs flex items-center justify-center">
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="text-[10px] font-bold text-slate-400 text-center p-1">Default Template</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3.5 px-5">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wide bg-blue-50 text-blue-700 mb-1 border border-blue-100">
                                        {{ $item->badge }}
                                    </span>
                                    <div class="font-extrabold text-slate-900 leading-snug line-clamp-2">{{ $item->title }}</div>
                                </td>
                                <td class="py-3.5 px-5 max-w-xs text-xs text-slate-500 font-medium">
                                    <p class="line-clamp-2 m-0">{{ $item->description }}</p>
                                </td>
                                <td class="py-3.5 px-5 text-center font-bold text-slate-700 text-xs">
                                    <span class="px-2 py-1 rounded-md bg-slate-100 text-slate-600">{{ $item->order }}</span>
                                </td>
                                <td class="py-3.5 px-5 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button type="button"
                                                @click="openEdit({{ json_encode($item) }}, '{{ route('admin.awards.update', $item) }}')"
                                                class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all flex items-center justify-center"
                                                title="Edit Penghargaan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        <form action="{{ route('admin.awards.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus penghargaan ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all flex items-center justify-center"
                                                    title="Hapus Penghargaan">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <span class="text-xs font-semibold">Belum ada data piagam atau penghargaan.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($awards->hasPages())
                <div class="p-4 border-t border-slate-100 flex justify-center">
                    {{ $awards->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Edit Penghargaan (Alpine.js) -->
    <template x-teleport="body">
        <div x-show="editModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
            <div x-show="editModalOpen" x-transition.opacity class="absolute inset-0 bg-slate-900/60 backdrop-blur-xs" @click="editModalOpen = false"></div>

            <div x-show="editModalOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 class="relative bg-white rounded-3xl shadow-2xl max-w-lg w-full p-6 sm:p-7 z-10 overflow-hidden">
                
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                    <h3 class="font-extrabold text-slate-800 text-base">Edit Data Penghargaan</h3>
                    <button type="button" @click="editModalOpen = false" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-500 hover:bg-slate-200 flex items-center justify-center font-bold">&times;</button>
                </div>

                <form :action="editActionUrl" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Judul Piagam / Penghargaan *</label>
                        <input type="text" name="title" x-model="editTitle" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none focus:bg-white focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Label Badge / Instansi *</label>
                        <input type="text" name="badge" x-model="editBadge" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none focus:bg-white focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Keterangan / Deskripsi *</label>
                        <textarea name="description" x-model="editDescription" rows="3" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none focus:bg-white focus:border-indigo-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Urutan Tampil (Order)</label>
                        <input type="number" name="order" x-model="editOrder" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm outline-none focus:bg-white focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Ganti Foto Piagam (Opsional)</label>
                        <input type="file" name="image" accept="image/png,image/jpeg,image/jpg,image/webp"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs text-slate-600 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700">
                    </div>

                    <div class="flex items-center justify-end gap-3 mt-4 pt-4 border-t border-slate-100">
                        <button type="button" @click="editModalOpen = false" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-bold text-xs hover:bg-indigo-700 shadow-md shadow-indigo-600/20">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</div>
@endsection

