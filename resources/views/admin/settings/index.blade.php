@extends('admin.layouts.app')

@section('title', 'Pengaturan Website')
@section('page_title', 'Pengaturan Website')

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
            <h1 class="text-base font-bold text-slate-800">Pengaturan Informasi Website</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola data dasar yang ditampilkan pada website publik.</p>
        </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        @csrf @method('PUT')

        <div class="p-6 md:p-8 space-y-8">
            <!-- Informasi Umum -->
            <div class="space-y-6">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-2">Informasi Umum</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5 md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700">Nama Website / Institusi</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'BPMP Provinsi Sulawesi Tenggara' }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                    </div>

                    <div class="space-y-1.5 md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700">Alamat Lengkap</label>
                        <textarea name="address" rows="3" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">{{ $settings['address'] ?? 'Jl. W. Monginsidi No.108, Mandonga, Kota Kendari, Sulawesi Tenggara' }}</textarea>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-sm font-bold text-slate-700">Email Resmi</label>
                        <input type="email" name="email" value="{{ $settings['email'] ?? 'bpmp.sultra@kemdikbud.go.id' }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-sm font-bold text-slate-700">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="phone" value="{{ $settings['phone'] ?? '+62 811-1234-5678' }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                    </div>
                    
                    <div class="space-y-1.5">
                        <label class="block text-sm font-bold text-slate-700">Jam Operasional</label>
                        <input type="text" name="operational_hours" value="{{ $settings['operational_hours'] ?? 'Senin - Jumat: 08.00 - 16.00 WITA' }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                    </div>
                    
                    <div class="space-y-1.5">
                        <label class="block text-sm font-bold text-slate-700">Link Google Maps (URL Embed)</label>
                        <input type="url" name="maps_url" value="{{ $settings['maps_url'] ?? '' }}" placeholder="https://www.google.com/maps/embed?pb=..." class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                    </div>
                </div>
            </div>

            <!-- Sosial Media -->
            <div class="space-y-6 pt-4 border-t border-slate-100">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-2">Sosial Media</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label class="block text-sm font-bold text-slate-700">Instagram</label>
                        <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? 'https://www.instagram.com/bpmpsultra/' }}" placeholder="https://..." class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                    </div>
                    
                    <div class="space-y-1.5">
                        <label class="block text-sm font-bold text-slate-700">Facebook</label>
                        <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}" placeholder="https://..." class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-sm font-bold text-slate-700">YouTube</label>
                        <input type="url" name="social_youtube" value="{{ $settings['social_youtube'] ?? '' }}" placeholder="https://..." class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                    </div>
                    
                    <div class="space-y-1.5">
                        <label class="block text-sm font-bold text-slate-700">TikTok</label>
                        <input type="url" name="social_tiktok" value="{{ $settings['social_tiktok'] ?? '' }}" placeholder="https://..." class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                    </div>
                </div>
            </div>

            <!-- Footer Text -->
            <div class="space-y-6 pt-4 border-t border-slate-100">
                <div class="space-y-1.5">
                    <label class="block text-sm font-bold text-slate-700">Teks Copyright Footer</label>
                    <input type="text" name="footer_copyright" value="{{ $settings['footer_copyright'] ?? '2026 BPMP Provinsi Sulawesi Tenggara. Seluruh Hak Cipta Dilindungi.' }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                </div>
            </div>

        </div>

        <div class="px-6 py-4 md:px-8 border-t border-slate-100 bg-slate-50 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-colors">
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection
