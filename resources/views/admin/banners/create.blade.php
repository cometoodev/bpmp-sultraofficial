@extends('layouts.admin')

@section('title', 'Tambah Banner')
@section('header_title', 'Tambah Banner Baru')
@section('header_subtitle', 'Unggah gambar banner dan konfigurasi link tampilan beranda')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.banners.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 flex items-center gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200/80 shadow-xs space-y-8">
        @csrf

        <div class="space-y-6">
            <div>
                <h2 class="text-base font-bold text-slate-800">Informasi Banner</h2>
                <p class="text-xs text-slate-500">Lengkapi detail banner yang akan ditampilkan.</p>
            </div>

            <!-- Upload Gambar -->
            <div class="space-y-1.5" x-data="{ imagePreview: null }">
                <label class="block text-sm font-bold text-slate-700">Gambar Banner <span class="text-red-500">*</span></label>
                <div class="relative w-full h-48 md:h-64 rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 flex flex-col items-center justify-center overflow-hidden hover:bg-slate-100 transition-colors">
                    <input type="file" name="image" required accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                        @change="const file = $event.target.files[0]; if(file) { const reader = new FileReader(); reader.onload = (e) => imagePreview = e.target.result; reader.readAsDataURL(file); } else { imagePreview = null; }">
                    
                    <div x-show="!imagePreview" class="text-center px-4">
                        <svg class="mx-auto h-10 w-10 text-slate-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <p class="text-sm font-medium text-slate-700">Klik atau drag & drop gambar</p>
                        <p class="text-xs text-slate-500 mt-1">PNG, JPG, WEBP (Max 3MB)</p>
                        <p class="text-xs text-slate-500">Rasio rekomendasi: 16:9 atau lebih lebar</p>
                    </div>

                    <img x-show="imagePreview" :src="imagePreview" class="absolute inset-0 w-full h-full object-cover" style="display: none;">
                </div>
                @error('image') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <!-- Title -->
            <div class="space-y-1.5">
                <label for="title" class="block text-sm font-bold text-slate-700">Judul Banner <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required 
                    class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
            </div>

            <!-- Description -->
            <div class="space-y-1.5">
                <label for="description" class="block text-sm font-bold text-slate-700">Deskripsi Singkat</label>
                <textarea name="description" id="description" rows="2" 
                    class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Button Text -->
                <div class="space-y-1.5">
                    <label for="button_text" class="block text-sm font-bold text-slate-700">Teks Tombol</label>
                    <input type="text" name="button_text" id="button_text" value="{{ old('button_text') }}" placeholder="Misal: Selengkapnya"
                        class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                </div>

                <!-- Button URL -->
                <div class="space-y-1.5">
                    <label for="button_url" class="block text-sm font-bold text-slate-700">Link Tujuan Tombol</label>
                    <input type="text" name="button_url" id="button_url" value="{{ old('button_url') }}" placeholder="/profil-lembaga atau https://..."
                        class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                </div>

                <!-- Order -->
                <div class="space-y-1.5">
                    <label for="order" class="block text-sm font-bold text-slate-700">Urutan Tampil <span class="text-red-500">*</span></label>
                    <input type="number" name="order" id="order" value="{{ old('order', 1) }}" required 
                        class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                </div>

                <!-- Status -->
                <div class="space-y-1.5">
                    <label class="block text-sm font-bold text-slate-700">Status Publikasi</label>
                    <label class="flex items-center gap-3 cursor-pointer mt-3">
                        <div class="relative">
                            <input type="checkbox" name="status" value="1" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </div>
                        <span class="text-sm font-medium text-slate-700">Aktif (Tampilkan Banner)</span>
                    </label>
                </div>
            </div>

        </div>

        <div class="pt-6 border-t border-slate-100 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-colors">
                Simpan Banner
            </button>
        </div>
    </form>

</div>
@endsection
