@extends('layouts.admin')

@section('title', 'Tambah Menu Navigasi')
@section('header_title', 'Tambah Menu Navigasi')
@section('header_subtitle', 'Tambahkan item menu baru ke dalam navigasi website')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.menus.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 flex items-center gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.menus.store') }}" method="POST" class="space-y-6" x-data="{ linkType: 'page', urlPage: '{{ old('url', '') }}', urlCustom: '{{ old('url_custom', '') }}', menuTitle: '{{ old('title', '') }}' }">
        @csrf

        <div class="bg-white/60 backdrop-blur-2xl rounded-[2.5rem] shadow-xl border border-white/80 p-6 sm:p-8 relative overflow-hidden">
            <!-- Efek Cahaya Latar -->
            <div class="absolute -top-20 -right-20 w-64 h-64 bg-blue-400/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="space-y-1.5 md:col-span-2">
                    <label for="title" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Judul/Teks Menu <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" x-model="menuTitle" required 
                        class="w-full bg-white/80 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3 shadow-sm outline-none font-semibold"
                        placeholder="Contoh: LK">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Sub-Judul / Deskripsi Menu -->
                <div class="space-y-1.5 md:col-span-2">
                    <label for="description" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Sub-Judul / Deskripsi Menu (Opsional)</label>
                    <textarea name="description" id="description" rows="2" 
                        class="w-full bg-white/80 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3 shadow-sm outline-none" 
                        placeholder="Contoh: Laporan Keuangan berkala...">{{ old('description') }}</textarea>
                    <p class="text-[11px] text-slate-400 mt-1">Teks pendukung yang tampil di bawah judul menu pada kotak dropdown (seperti pada menu SAKIP).</p>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Tipe Link / Sumber & URL Dropdown/Input -->
                <div class="space-y-3 md:col-span-2 border-t border-slate-100 pt-4">
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
                        <select name="url" x-model="urlPage" :disabled="linkType !== 'page'"
                            @change="if (!menuTitle || menuTitle.trim() === '') { const opt = $event.target.options[$event.target.selectedIndex]; if (opt && opt.dataset.title) menuTitle = opt.dataset.title; }"
                            class="w-full bg-white/80 border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none shadow-sm text-slate-700 text-sm">
                            <option value="">-- Pilih Halaman Website --</option>
                            @foreach($pages as $p)
                                <option value="/{{ ltrim($p->slug, '/') }}" data-title="{{ $p->title }}" {{ old('url') === ('/' . ltrim($p->slug, '/')) ? 'selected' : '' }}>
                                    {{ $p->title }} (/{{ ltrim($p->slug, '/') }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[11px] text-slate-400 mt-1">URL akan disinkronkan secara otomatis dengan slug halaman yang dipilih.</p>
                    </div>

                    <!-- Jika pilih Custom URL -->
                    <div x-show="linkType === 'custom'" class="w-full" style="display: none;">
                        <input type="text" name="url_custom" x-model="urlCustom" :disabled="linkType !== 'custom'"
                            value="{{ old('url_custom') }}"
                            placeholder="Contoh: https://google.com atau /external-path" 
                            class="w-full bg-white/80 border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none shadow-sm text-slate-700 text-sm font-mono">
                        <p class="text-[11px] text-slate-400 mt-1">Ketik URL lengkap untuk link eksternal atau path internal kustom (misal: /berita).</p>
                    </div>

                    @error('url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Parent Menu -->
                <div class="space-y-1.5">
                    <label for="parent_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Induk Menu (Parent)</label>
                    <select name="parent_id" id="parent_id" class="w-full bg-white/80 border border-slate-200 text-slate-800 text-sm rounded-xl p-3 shadow-sm outline-none">
                        <option value="">Tidak Ada (Menu Utama)</option>
                        @foreach($parentMenus as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->title }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-slate-400 mt-1">Pilih jika menu ini adalah submenu (dropdown).</p>
                </div>

                <!-- Urutan -->
                <div class="space-y-1.5">
                    <label for="order" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Urutan (Order) <span class="text-red-500">*</span></label>
                    <input type="number" name="order" id="order" value="{{ old('order', 0) }}" required 
                        class="w-full bg-white/80 border border-slate-200 text-slate-800 text-sm rounded-xl p-3 shadow-sm outline-none">
                    <p class="text-xs text-slate-400 mt-1">Angka lebih kecil akan tampil lebih dulu/kiri.</p>
                    @error('order') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Target -->
                <div class="space-y-1.5">
                    <label for="target" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Buka Link di</label>
                    <select name="target" id="target" class="w-full bg-white/80 border border-slate-200 text-slate-800 text-sm rounded-xl p-3 shadow-sm outline-none">
                        <option value="_self">Tab Saat Ini (_self)</option>
                        <option value="_blank">Tab Baru (_blank)</option>
                    </select>
                </div>

                <!-- Status -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Status</label>
                    <label class="flex items-center gap-3 cursor-pointer mt-2">
                        <div class="relative">
                            <input type="checkbox" name="status" value="1" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </div>
                        <span class="text-sm font-medium text-slate-700">Tampilkan Menu</span>
                    </label>
                </div>

                <div class="pt-4 border-t border-slate-100 md:col-span-2 flex justify-end gap-3">
                    <a href="{{ route('admin.menus.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-600 font-bold text-sm hover:bg-slate-200 transition-all">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/25 transition-all">
                        Simpan Menu
                    </button>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection
