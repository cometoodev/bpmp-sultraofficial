@extends('admin.layouts.app')

@section('title', 'Edit Menu Navigasi')
@section('page_title', 'Edit Menu')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.menus.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 flex items-center gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.menus.update', $menu) }}" method="POST" class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-6" x-data="{ type: 'custom', selectedUrl: '{{ $menu->url }}' }">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Title -->
            <div class="space-y-1.5 md:col-span-2">
                <label for="title" class="block text-sm font-bold text-slate-700">Judul/Teks Menu <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $menu->title) }}" required 
                    class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
            </div>

            <!-- Tipe URL -->
            <div class="space-y-1.5 md:col-span-2 border-t border-slate-100 pt-4">
                <label class="block text-sm font-bold text-slate-700">Tipe Link / URL <span class="text-red-500">*</span></label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" x-model="type" value="page" class="text-blue-600 focus:ring-blue-500 border-slate-300">
                        <span class="text-sm text-slate-700">Pilih dari Halaman (Pages)</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" x-model="type" value="custom" class="text-blue-600 focus:ring-blue-500 border-slate-300">
                        <span class="text-sm text-slate-700">Custom URL</span>
                    </label>
                </div>
            </div>

            <!-- URL Input -->
            <div class="space-y-1.5 md:col-span-2">
                <div x-show="type === 'page'">
                    <select x-on:change="selectedUrl = '/' + $event.target.value" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl p-3 mb-2">
                        <option value="">-- Pilih Halaman --</option>
                        @foreach($pages as $page)
                            <option value="{{ $page->slug }}" {{ ('/'.$page->slug) == $menu->url ? 'selected' : '' }}>{{ $page->title }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="text" name="url" id="url" x-model="selectedUrl" required placeholder="/url-tujuan"
                    class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3 font-mono">
            </div>

            <!-- Parent Menu -->
            <div class="space-y-1.5">
                <label for="parent_id" class="block text-sm font-bold text-slate-700">Induk Menu (Parent)</label>
                <select name="parent_id" id="parent_id" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl p-3">
                    <option value="">Tidak Ada (Menu Utama)</option>
                    @foreach($parentMenus as $parent)
                        <option value="{{ $parent->id }}" {{ $menu->parent_id == $parent->id ? 'selected' : '' }}>{{ $parent->title }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Urutan -->
            <div class="space-y-1.5">
                <label for="order" class="block text-sm font-bold text-slate-700">Urutan (Order) <span class="text-red-500">*</span></label>
                <input type="number" name="order" id="order" value="{{ old('order', $menu->order) }}" required 
                    class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl p-3">
            </div>

            <!-- Target -->
            <div class="space-y-1.5">
                <label for="target" class="block text-sm font-bold text-slate-700">Buka Link di</label>
                <select name="target" id="target" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl p-3">
                    <option value="_self" {{ $menu->target == '_self' ? 'selected' : '' }}>Tab Saat Ini (_self)</option>
                    <option value="_blank" {{ $menu->target == '_blank' ? 'selected' : '' }}>Tab Baru (_blank)</option>
                </select>
            </div>

            <!-- Status -->
            <div class="space-y-1.5">
                <label class="block text-sm font-bold text-slate-700">Status</label>
                <label class="flex items-center gap-3 cursor-pointer mt-2">
                    <div class="relative">
                        <input type="checkbox" name="status" value="1" class="sr-only peer" {{ $menu->status ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </div>
                    <span class="text-sm font-medium text-slate-700">Tampilkan Menu</span>
                </label>
            </div>

        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-colors">
                Simpan Perubahan
            </button>
        </div>
    </form>

</div>
@endsection
