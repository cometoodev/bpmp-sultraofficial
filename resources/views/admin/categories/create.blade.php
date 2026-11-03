@extends('layouts.admin')

@section('title', 'Tambah Kategori')
@section('header_title', 'Tambah Kategori Berita')
@section('header_subtitle', 'Buat kategori baru untuk pengelompokan konten berita')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.categories.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 flex items-center gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-6">
        @csrf

        <!-- Name -->
        <div class="space-y-1.5">
            <label for="name" class="block text-sm font-bold text-slate-700">Nama Kategori <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3 transition-colors">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Slug -->
        <div class="space-y-1.5">
            <label for="slug" class="block text-sm font-bold text-slate-700">Slug (Opsional)</label>
            <div class="flex items-center">
                <span class="inline-flex items-center px-3 py-3 text-sm text-slate-500 bg-slate-100 border border-r-0 border-slate-200 rounded-l-xl">
                    /
                </span>
                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" 
                    class="rounded-none rounded-r-xl bg-slate-50 border border-slate-200 text-slate-800 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block w-full p-3 transition-colors" placeholder="nama-kategori">
            </div>
            <p class="text-[11px] text-slate-500">Kosongkan untuk membuat otomatis dari nama kategori.</p>
            @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Description -->
        <div class="space-y-1.5">
            <label for="description" class="block text-sm font-bold text-slate-700">Deskripsi (Opsional)</label>
            <textarea name="description" id="description" rows="3" 
                class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3 transition-colors">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Status -->
        <label class="flex items-center gap-3 cursor-pointer p-4 rounded-xl border border-slate-200/80 bg-slate-50/50">
            <div class="relative">
                <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', true) ? 'checked' : '' }}>
                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
            </div>
            <div>
                <span class="text-sm font-bold text-slate-700 block">Kategori Aktif</span>
                <span class="text-xs text-slate-500 block">Kategori akan ditampilkan di publik</span>
            </div>
        </label>

        <div class="pt-4 border-t border-slate-100 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-colors">
                Simpan Kategori
            </button>
        </div>
    </form>

</div>
@endsection
