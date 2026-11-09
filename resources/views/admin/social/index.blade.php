@extends('layouts.admin')

@section('title', 'Integrasi Media Sosial')
@section('header_title', 'Integrasi Media Sosial')
@section('header_subtitle', 'Kelola widget feed dan tautan profil resmi Instagram, TikTok, dan YouTube di halaman depan')

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-800 p-4 rounded-2xl text-sm font-bold border border-emerald-200 flex items-center gap-3 shadow-sm">
            <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 text-red-900 p-4 rounded-2xl text-sm font-medium border border-red-200 flex flex-col gap-2 shadow-sm">
            <div class="flex items-center gap-2 font-bold text-red-900">
                <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <span>Terjadi kesalahan pada input data:</span>
            </div>
            <ul class="list-disc list-inside text-xs space-y-1 pl-1 text-red-800 font-medium">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Kartu Penjelasan / Banner Info (High Contrast & Nyaman Dibaca) -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-50/90 via-indigo-50/80 to-sky-50/90 border border-blue-200/90 p-5 sm:p-6 shadow-sm flex items-start gap-4">
        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 text-white flex items-center justify-center shrink-0 shadow-md shadow-blue-500/20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="space-y-1">
            <h4 class="text-sm sm:text-base font-black text-slate-900 tracking-tight">Panduan Pengaturan Widget & Fallback Card</h4>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium">
                Jika Anda memiliki kode script widget (seperti dari <strong class="text-slate-900 font-bold">Elfsight, Curator.io, atau SnapWidget</strong>), tempelkan kodenya pada kolom <em>Kode Script / Embed Widget</em> di bawah. Jika kolom tersebut <strong class="text-slate-900 font-bold">dikosongkan</strong>, halaman publik secara otomatis menampilkan <strong class="text-blue-700 font-bold">Fallback Card Resmi yang Elegan</strong> dengan logo platform, username, ajakan follow, dan tautan langsung ke akun resmi.
            </p>
        </div>
    </div>

    <!-- Grid Kartu Platform Media Sosial (Glassmorphism & High Contrast) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @foreach($socials as $social)
            @php
                $isInstagram = $social->platform === 'instagram';
                $isTiktok = $social->platform === 'tiktok';
                $isYoutube = $social->platform === 'youtube';

                $brandHeaderBg = match($social->platform) {
                    'instagram' => 'bg-gradient-to-r from-pink-600 via-rose-600 to-amber-500 text-white',
                    'tiktok' => 'bg-gradient-to-r from-slate-950 via-slate-900 to-zinc-900 text-white border-b border-cyan-500/30',
                    'youtube' => 'bg-gradient-to-r from-red-600 via-rose-600 to-red-700 text-white',
                    default => 'bg-slate-900 text-white',
                };

                $brandSaveBtn = match($social->platform) {
                    'instagram' => 'bg-gradient-to-r from-pink-600 via-rose-600 to-amber-600 hover:from-pink-700 hover:to-amber-700 text-white shadow-md shadow-pink-500/20 hover:shadow-lg hover:shadow-pink-500/30',
                    'tiktok' => 'bg-gradient-to-r from-slate-950 via-slate-900 to-zinc-900 hover:from-black hover:to-slate-800 text-white border border-slate-700 shadow-md shadow-slate-900/30 hover:shadow-lg',
                    'youtube' => 'bg-gradient-to-r from-red-600 via-rose-600 to-red-700 hover:from-red-700 hover:to-rose-800 text-white shadow-md shadow-red-600/20 hover:shadow-lg hover:shadow-red-600/30',
                    default => 'bg-blue-600 hover:bg-blue-700 text-white',
                };
            @endphp

            <div class="backdrop-blur-xl bg-white/95 rounded-3xl border border-slate-200/90 shadow-lg hover:shadow-2xl transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                <div>
                    <!-- Header Kartu Platform -->
                    <div class="p-5 {{ $brandHeaderBg }} flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center p-2.5 text-white shadow-xs border border-white/30">
                                @if($isInstagram)
                                    <svg class="w-full h-full fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                @elseif($isTiktok)
                                    <svg class="w-full h-full" viewBox="0 0 24 24" fill="none">
                                        <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64c.29 0 .58.04.88.13V9.4a6.84 6.84 0 0 0-1-.05A6.28 6.28 0 0 0 3.08 15.6a6.28 6.28 0 0 0 9.16 5.57 6.29 6.29 0 0 0 3.2-5.5V10.6a8.2 8.2 0 0 0 3.81 1.13V8.28a5 5 0 0 1-3.81-1.59z" fill="#FE2C55" transform="translate(0.5, 0.5)"/>
                                        <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64c.29 0 .58.04.88.13V9.4a6.84 6.84 0 0 0-1-.05A6.28 6.28 0 0 0 3.08 15.6a6.28 6.28 0 0 0 9.16 5.57 6.29 6.29 0 0 0 3.2-5.5V10.6a8.2 8.2 0 0 0 3.81 1.13V8.28a5 5 0 0 1-3.81-1.59z" fill="#25F4EE" transform="translate(-0.5, -0.5)"/>
                                        <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64c.29 0 .58.04.88.13V9.4a6.84 6.84 0 0 0-1-.05A6.28 6.28 0 0 0 3.08 15.6a6.28 6.28 0 0 0 9.16 5.57 6.29 6.29 0 0 0 3.2-5.5V10.6a8.2 8.2 0 0 0 3.81 1.13V8.28a5 5 0 0 1-3.81-1.59z" fill="#FFFFFF"/>
                                    </svg>
                                @elseif($isYoutube)
                                    <svg class="w-full h-full fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-black text-base tracking-tight text-white">{{ $social->name }}</h3>
                                <p class="text-xs text-white/90 font-mono font-bold">{{ $social->formatted_username }}</p>
                            </div>
                        </div>

                        <div>
                            @if($social->is_active)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-white text-emerald-800 shadow-sm">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span>Aktif</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-black/40 text-white/90 border border-white/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                    <span>Nonaktif</span>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Form Pengaturan dengan Label & Input Kontras Tinggi -->
                    <form action="{{ route('admin.social.update', $social) }}" method="POST" class="p-6 space-y-5">
                        @csrf
                        @method('PUT')

                        <!-- Toggle Status Aktif (Desain Card Bersih) -->
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-200">
                            <div>
                                <label for="active_{{ $social->id }}" class="text-xs font-black text-slate-900 cursor-pointer block">Tampil di Halaman Publik</label>
                                <span class="text-[11px] text-slate-600 font-medium">Tampilkan tab platform ini di landing page</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" id="active_{{ $social->id }}" value="1" {{ $social->is_active ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600 shadow-inner"></div>
                            </label>
                        </div>

                        <!-- Username / Handle -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-black text-slate-900 uppercase tracking-wider">Username / Handle Akun</label>
                            <input type="text" name="username" value="{{ old('username', $social->username) }}" placeholder="Contoh: @bpmpsultra" class="w-full bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm font-semibold rounded-xl focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 p-3 shadow-2xs transition-all">
                        </div>

                        <!-- Tautan Profil Resmi -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-black text-slate-900 uppercase tracking-wider">Tautan Profil Resmi (URL)</label>
                            <input type="url" name="profile_url" value="{{ old('profile_url', $social->profile_url) }}" placeholder="https://..." class="w-full bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm font-semibold rounded-xl focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 p-3 shadow-2xs transition-all">
                            <span class="text-[11px] text-slate-600 font-medium block">Tautan tujuan tombol "Follow" / "Subscribe"</span>
                        </div>

                        <!-- Kode Embed Script -->
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-black text-slate-900 uppercase tracking-wider">Kode Script / Embed Widget</label>
                                @if($social->hasEmbedCode())
                                    <span class="text-[11px] font-bold text-emerald-800 bg-emerald-100 px-2.5 py-0.5 rounded-full border border-emerald-300">Widget Terpasang</span>
                                @else
                                    <span class="text-[11px] font-bold text-amber-900 bg-amber-100 px-2.5 py-0.5 rounded-full border border-amber-300">Mode Fallback Card</span>
                                @endif
                            </div>
                            <textarea name="embed_code" rows="4" placeholder="Tempelkan kode &lt;script&gt; atau &lt;div class='elfsight-app-...'&gt;&lt;/div&gt; di sini..." class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-xs rounded-xl focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 p-3 font-mono transition-all">{{ old('embed_code', $social->embed_code) }}</textarea>
                            <p class="text-[11px] text-slate-600 font-medium leading-relaxed">
                                Kosongkan kolom ini jika ingin menampilkan kartu fallback ajakan resmi tanpa widget pihak ketiga.
                            </p>
                        </div>

                        <!-- Tombol Simpan Per Platform (Futuristic Glow) -->
                        <div class="pt-2">
                            <button type="submit" class="w-full py-3.5 px-4 {{ $brandSaveBtn }} text-xs sm:text-sm font-black rounded-xl hover:scale-102 active:scale-98 transition-all duration-200 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Simpan Perubahan {{ $social->name }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
