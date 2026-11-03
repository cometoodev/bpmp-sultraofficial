@extends('layouts.admin')

@section('title', 'SEO Dasar')
@section('header_title', 'Pengaturan SEO Dasar')
@section('header_subtitle', 'Konfigurasi meta tag, title, deskripsi, dan indeks mesin pencari')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-700 p-4 rounded-xl text-sm font-medium border border-emerald-100 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-base font-bold text-slate-800">Search Engine Optimization (SEO)</h1>
            <p class="text-xs text-slate-500 mt-1">Konfigurasi meta tags untuk membantu pencarian di Google/Bing.</p>
        </div>
    </div>

    <form action="{{ route('admin.seo.update') }}" method="POST" class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        @csrf @method('PUT')

        <div class="p-6 md:p-8 space-y-6">
            <div class="space-y-1.5">
                <label class="block text-sm font-bold text-slate-700">Meta Title (Judul Halaman Pencarian)</label>
                <input type="text" name="meta_title" value="{{ $settings['meta_title'] ?? 'BPMP Provinsi Sulawesi Tenggara' }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                <p class="text-xs text-slate-500 mt-1">Ditampilkan pada tab browser dan hasil pencarian (maks 60 karakter).</p>
            </div>

            <div class="space-y-1.5">
                <label class="block text-sm font-bold text-slate-700">Meta Description (Deskripsi Situs)</label>
                <textarea name="meta_description" rows="3" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">{{ $settings['meta_description'] ?? 'Pusat penjaminan mutu dan referensi pendidikan berkualitas Provinsi Sulawesi Tenggara.' }}</textarea>
                <p class="text-xs text-slate-500 mt-1">Ringkasan singkat tentang institusi Anda yang muncul di hasil pencarian (150-160 karakter).</p>
            </div>

            <div class="space-y-1.5">
                <label class="block text-sm font-bold text-slate-700">Meta Keywords (Kata Kunci)</label>
                <input type="text" name="meta_keywords" value="{{ $settings['meta_keywords'] ?? 'bpmp, sultra, pendidikan, kemdikbud, sulawesi tenggara' }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                <p class="text-xs text-slate-500 mt-1">Pisahkan dengan koma (contoh: sekolah, pendidikan, sultra).</p>
            </div>
            
            <div class="space-y-1.5">
                <label class="block text-sm font-bold text-slate-700">Google Analytics Tracking ID (Opsional)</label>
                <input type="text" name="google_analytics_id" value="{{ $settings['google_analytics_id'] ?? '' }}" placeholder="G-XXXXXXXXXX" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
            </div>
        </div>

        <div class="px-6 py-4 md:px-8 border-t border-slate-100 bg-slate-50 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-colors">
                Simpan SEO
            </button>
        </div>
    </form>
</div>
@endsection
