@extends('layouts.admin')

@section('title', 'Edit Menu Navigasi')
@section('header_title', 'Edit Menu Navigasi')
@section('header_subtitle', 'Perbarui label tautan atau struktur hierarki menu')

@section('content')
@php
    $matchedPage = $pages->first(function($p) use ($menu) {
        $cleanMenu = ltrim($menu->url, '/');
        $cleanSlug = ltrim($p->slug, '/');
        return $cleanMenu === $cleanSlug;
    });
    $initialLinkType = $matchedPage ? 'page' : 'custom';
@endphp

<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.menus.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 flex items-center gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white/70 backdrop-blur-xl rounded-[2.5rem] shadow-lg border border-white p-8 relative overflow-hidden">
        <!-- Efek Cahaya Latar -->
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-blue-400/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="mb-6 pb-4 border-b border-slate-100 relative z-10">
            <h2 class="text-lg font-bold text-slate-700">Edit Menu Navigasi</h2>
            <p class="text-xs text-slate-500 mt-0.5">Perbarui label tautan, URL, atau sub-judul deskripsi menu.</p>
        </div>

        <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" class="space-y-6 relative z-10" 
              x-data="{ 
                  linkType: '{{ old('link_type', $initialLinkType) }}', 
                  urlPage: '{{ old('url', $matchedPage ? '/' . ltrim($matchedPage->slug, '/') : '') }}', 
                  urlCustom: '{{ old('url_custom', $menu->url) }}' 
              }">
            @csrf
            @method('PUT')
            <input type="hidden" name="_has_status_field" value="1">

            <!-- Judul Menu -->
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul/Teks Menu *</label>
                <input type="text" name="title" value="{{ old('title', $menu->title) }}" class="w-full bg-white/80 border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none shadow-sm text-slate-700 font-semibold" required>
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Sub-Judul / Deskripsi Menu (Sesuai Permintaan) -->
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Sub-Judul / Deskripsi Menu (Opsional)</label>
                <textarea name="description" rows="2" class="w-full bg-white/80 border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none shadow-sm text-slate-600 text-sm" placeholder="Contoh: Laporan Keuangan berkala...">{{ old('description', $menu->description) }}</textarea>
                <p class="text-[11px] text-slate-400 mt-1">Teks pendukung yang akan tampil di bawah judul menu pada kotak dropdown halaman utama website.</p>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- URL / Tipe Link (Dropdown Otomatis dari Pages & Custom URL) -->
            <div class="space-y-3 border-t border-slate-100 pt-4">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Tipe Link / Sumber <span class="text-red-500">*</span></label>
                
                <!-- Pilihan Tipe Link -->
                <div class="flex flex-wrap gap-5">
                    <label class="flex items-center gap-2 text-sm text-slate-700 font-medium cursor-pointer">
                        <input type="radio" name="link_type" value="page" x-model="linkType" class="text-blue-600 focus:ring-blue-500 border-slate-300">
                        <span>Pilih dari Halaman (Pages)</span>
                    </label>
                    <label class="flex items-center gap-2 text-sm text-slate-700 font-medium cursor-pointer">
                        <input type="radio" name="link_type" value="custom" x-model="linkType" class="text-blue-600 focus:ring-blue-500 border-slate-300">
                        <span>Custom URL / External Link</span>
                    </label>
                </div>

                <!-- Jika pilih Halaman: Tampilkan Dropdown Otomatis dari Database -->
                <div x-show="linkType === 'page'" class="w-full">
                    <select name="url" x-model="urlPage" :disabled="linkType !== 'page'" class="w-full bg-white/80 border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none shadow-sm text-slate-700 text-sm">
                        <option value="">-- Pilih Halaman Website --</option>
                        @foreach($pages as $p)
                            <option value="/{{ ltrim($p->slug, '/') }}" {{ ('/' . ltrim($p->slug, '/')) === $menu->url ? 'selected' : '' }}>
                                {{ $p->title }} (/{{ ltrim($p->slug, '/') }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-[11px] text-slate-400 mt-1">URL akan disinkronkan secara otomatis dengan slug halaman yang dipilih.</p>
                </div>

                <!-- Jika pilih Custom URL -->
                <div x-show="linkType === 'custom'" class="w-full" style="display: none;">
                    <input type="text" name="url_custom" x-model="urlCustom" :disabled="linkType !== 'custom'"
                        value="{{ old('url_custom', $menu->url) }}"
                        placeholder="Contoh: https://google.com atau /external-path" 
                        class="w-full bg-white/80 border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none shadow-sm text-slate-700 text-sm font-mono">
                    <p class="text-[11px] text-slate-400 mt-1">Ketik URL lengkap untuk link eksternal atau path internal khusus (misal: /berita).</p>
                </div>

                @error('url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Pengaturan Tambahan (Parent, Order, Target, Status) -->
            <div class="pt-4 border-t border-slate-100 grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Parent Menu -->
                <div class="space-y-1.5">
                    <label for="parent_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Induk Menu (Parent)</label>
                    <select name="parent_id" id="parent_id" class="w-full bg-white/80 border border-slate-200 text-slate-800 text-sm rounded-xl p-3 shadow-sm outline-none">
                        <option value="">Tidak Ada (Menu Utama)</option>
                        @foreach($parentMenus as $parent)
                            <option value="{{ $parent->id }}" {{ $menu->parent_id == $parent->id ? 'selected' : '' }}>{{ $parent->title }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Urutan -->
                <div class="space-y-1.5">
                    <label for="order" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Urutan (Order)</label>
                    <input type="number" name="order" id="order" value="{{ old('order', $menu->order) }}" 
                        class="w-full bg-white/80 border border-slate-200 text-slate-800 text-sm rounded-xl p-3 shadow-sm outline-none">
                    @error('order') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Target -->
                <div class="space-y-1.5">
                    <label for="target" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Buka Link di</label>
                    <select name="target" id="target" class="w-full bg-white/80 border border-slate-200 text-slate-800 text-sm rounded-xl p-3 shadow-sm outline-none">
                        <option value="_self" {{ $menu->target == '_self' ? 'selected' : '' }}>Tab Saat Ini (_self)</option>
                        <option value="_blank" {{ $menu->target == '_blank' ? 'selected' : '' }}>Tab Baru (_blank)</option>
                    </select>
                </div>

                <!-- Status -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Status</label>
                    <label class="flex items-center gap-3 cursor-pointer mt-2">
                        <div class="relative">
                            <input type="checkbox" name="status" value="1" class="sr-only peer" {{ $menu->status ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </div>
                        <span class="text-sm font-medium text-slate-700">Tampilkan Menu</span>
                    </label>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.menus.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-600 font-bold text-sm hover:bg-slate-200 transition-all">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 text-white font-bold text-sm shadow-lg shadow-blue-600/30 hover:bg-blue-500 transition-all">Simpan Perubahan</button>
            </div>
        </form>
    </div>

</div>
@endsection
