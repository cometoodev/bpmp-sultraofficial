@extends('layouts.app')

@section('title', isset($page) ? $page->getSeoTitle() : 'Hubungi Kami - BPMP Provinsi Sulawesi Tenggara')
@section('meta_description', isset($page) ? $page->getSeoDescription() : 'Hubungi kantor operasional BPMP Provinsi Sulawesi Tenggara melalui peta lokasi, kirim pesan langsung, atau informasi jam layanan.')

@section('content')
<!-- HEADER UNIVERSAL (BIRU SOLID / BG-BLUE-900) -->
<div class="relative pt-28 pb-40 overflow-hidden bg-blue-900">
    <div class="relative z-10 text-center px-4 max-w-4xl mx-auto flex flex-col items-center">
        <!-- Badge Kategori / Label -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-white font-extrabold text-[10px] sm:text-xs uppercase tracking-widest shadow-sm mb-6">
            <div class="w-2 h-2 rounded-full bg-blue-400"></div>
            Layanan Komunikasi &amp; Informasi
        </div>

        <!-- Judul Halaman Dinamis -->
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight mb-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            {{ $page->title ?? 'Hubungi Kami' }}
        </h1>

        <!-- Breadcrumbs & Meta Date -->
        <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 text-xs sm:text-sm font-medium text-blue-200">
            <a href="/" class="hover:text-white transition-colors">Beranda</a>
            <span class="text-blue-400/60">›</span>
            <span class="text-white font-semibold">{{ $page->title ?? 'Hubungi Kami' }}</span>
            <span class="hidden sm:inline-block text-blue-400/60 mx-2">|</span>
            <div class="flex items-center gap-1.5 mt-2 sm:mt-0 px-3 py-1 rounded-lg bg-black/10 border border-white/10 text-blue-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Kendari, Sulawesi Tenggara
            </div>
        </div>
    </div>
</div>

<!-- KONTEN HALAMAN UNIVERSAL (Overlap menimpa header biru) -->
<div class="cms-master-wrapper relative z-20 w-full max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 -mt-24 mb-20"
     x-data="{ 
        showAlert: {{ session('success') || $errors->any() ? 'true' : 'false' }},
        alertType: '{{ session('success') ? 'success' : ($errors->any() ? 'error' : '') }}',
        alertTitle: '{{ session('success') ? 'Pesan Terkirim!' : ($errors->any() ? 'Pemberitahuan Sistem' : '') }}',
        alertMessage: '{{ session('success') ? addslashes(session('success')) : ($errors->any() ? addslashes(collect($errors->all())->implode('. ')) : '') }}',
        validateContactForm(e) {
            let form = e.target;
            let name = form.name ? form.name.value.trim() : '';
            let email = form.email ? form.email.value.trim() : '';
            let subject = form.subject ? form.subject.value.trim() : '';
            let message = form.message ? form.message.value.trim() : '';

            if(!name || !email || !subject || !message) {
                e.preventDefault();
                this.alertType = 'error';
                this.alertTitle = 'Form Belum Lengkap';
                this.alertMessage = 'Mohon lengkapi seluruh isian formulir (Nama, Email, Subjek, dan Pesan) sebelum mengirim.';
                this.showAlert = true;
                return false;
            }

            let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if(!emailPattern.test(email)) {
                e.preventDefault();
                this.alertType = 'error';
                this.alertTitle = 'Format Email Keliru';
                this.alertMessage = 'Format alamat email tidak valid. Pastikan penulisan email sudah benar (contoh: nama@email.com).';
                this.showAlert = true;
                return false;
            }
        }
     }">

    <div class="bg-white/95 backdrop-blur-xl rounded-[2.5rem] md:rounded-[3rem] shadow-xl border border-slate-100 p-6 md:p-12 lg:p-16 w-full overflow-hidden">
        
        <div style="width: 100%; display: flex; flex-direction: column; gap: 3rem;">

            <!-- 1. KOTAK PENGANTAR UTAMA -->
            <div style="width: 100%; max-width: 1100px; margin: 0 auto; display: block;">
                <div class="shadow-sm" style="background-color: #eef2ff; border-radius: 1.5rem; padding: 2rem; display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap; border: 1px solid #e0e7ff;">
                    <div class="shadow-lg" style="background-color: #4f46e5; color: white; width: 4rem; height: 4rem; border-radius: 1rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg style="width: 2rem; height: 2rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <p style="color: #475569; font-size: 1.05rem; line-height: 1.6; flex: 1; min-width: 250px; margin: 0;">
                        Hubungi kantor operasional <strong style="color: #3730a3; font-weight: 800;">BPMP Provinsi Sulawesi Tenggara</strong> melalui peta lokasi, kirim pesan langsung, atau informasi jam layanan di bawah ini.
                    </p>
                </div>
            </div>

            <!-- 2. BINGKAI UTAMA GLASSMORPHISM -->
            <div style="width: 100%; max-width: 1100px; margin: 0 auto; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 2.5rem; padding: 2.5rem; box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05); display: flex; flex-direction: column; gap: 3rem;">
                
                <!-- PETA GOOGLE MAPS INTERAKTIF -->
                <div style="width: 100%; display: flex; flex-direction: column; gap: 1rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                        <div>
                            <h3 style="color: #1e293b; font-weight: 900; font-size: 1.25rem; margin: 0;">Lokasi Kantor Operasional BPMP Sultra</h3>
                            <p style="color: #64748b; font-size: 0.9rem; margin: 0.2rem 0 0 0;">Jl. D.I Panjaitan No. 83, Wundudopi, Kota Kendari, Sulawesi Tenggara</p>
                        </div>
                        <a href="https://maps.google.com/?q=BPMP+Provinsi+Sulawesi+Tenggara,+Jl.+DI+Panjaitan+No.83,+Kendari" target="_blank" rel="noopener noreferrer" class="hover:bg-indigo-700 transition-colors shadow-sm" style="background: #4f46e5; color: white; padding: 0.65rem 1.35rem; border-radius: 0.85rem; font-weight: 700; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                            <span>📍 Open in Maps</span>
                            <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </div>
                    
                    <div style="width: 100%; height: 420px; border-radius: 1.75rem; overflow: hidden; border: 1px solid #cbd5e1; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);">
                        <iframe src="https://maps.google.com/maps?q=BPMP+Sultra,+Jl.+DI+Panjaitan,+Kendari&t=&z=17&ie=UTF8&iwloc=&output=embed" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                <!-- GRID FORM PESAN & INFO JAM KERJA -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2.5rem; align-items: start;">
                    
                    <!-- Kolom Kiri: Form Kirim Pesan -->
                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 2rem; padding: 2rem; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.02);">
                        <h4 style="color: #1e293b; font-weight: 900; font-size: 1.15rem; margin: 0 0 0.5rem 0;">Kirim Pesan</h4>
                        <p style="color: #64748b; font-size: 0.85rem; margin-bottom: 1.5rem; line-height: 1.5;">Pertanyaan atau pesan Anda akan langsung diteruskan ke email instansi.</p>

                        <form action="{{ route('contact.store') }}" method="POST" @submit="validateContactForm($event)" style="display: flex; flex-direction: column; gap: 1.25rem;">
                            @csrf
                            <div>
                                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.4rem; letter-spacing: 0.05em;">Nama Lengkap *</label>
                                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama Anda..."
                                    style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 0.85rem; padding: 0.75rem 1rem; font-size: 0.9rem; outline: none; box-sizing: border-box; color: #0f172a !important;"
                                    class="text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.4rem; letter-spacing: 0.05em;">Email *</label>
                                <input type="email" name="email" value="{{ old('email') }}" required placeholder="alamat@email.com"
                                    style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 0.85rem; padding: 0.75rem 1rem; font-size: 0.9rem; outline: none; box-sizing: border-box; color: #0f172a !important;"
                                    class="text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                                @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.4rem; letter-spacing: 0.05em;">Subjek *</label>
                                <input type="text" name="subject" value="{{ old('subject') }}" required placeholder="Perihal pesan..."
                                    style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 0.85rem; padding: 0.75rem 1rem; font-size: 0.9rem; outline: none; box-sizing: border-box; color: #0f172a !important;"
                                    class="text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                                @error('subject') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.4rem; letter-spacing: 0.05em;">Pesan *</label>
                                <textarea name="message" rows="4" required placeholder="Tuliskan pesan atau pertanyaan Anda di sini..."
                                    style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 0.85rem; padding: 0.75rem 1rem; font-size: 0.9rem; outline: none; resize: vertical; box-sizing: border-box; color: #0f172a !important;"
                                    class="text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">{{ old('message') }}</textarea>
                                @error('message') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <button type="submit" style="background: #4f46e5; color: white; padding: 0.85rem 1.5rem; border-radius: 0.85rem; font-weight: 800; border: none; cursor: pointer; box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3); transition: all 0.3s; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;" class="hover:bg-indigo-700">
                                <span>Kirim Pesan Sekarang</span>
                                <span>&rarr;</span>
                            </button>
                        </form>
                    </div>

                    <!-- Kolom Kanan: Informasi Jam Kerja & Lokasi -->
                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 2rem; padding: 2rem; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.02); display: flex; flex-direction: column; gap: 1.5rem;">
                        <h4 style="color: #1e293b; font-weight: 900; font-size: 1.15rem; margin: 0;">Jam Kerja &amp; Lokasi</h4>

                        <div style="display: flex; gap: 1rem; align-items: flex-start;">
                            <div style="background: #e0e7ff; color: #4338ca; width: 2.75rem; height: 2.75rem; border-radius: 0.85rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.2rem;">📍</div>
                            <div>
                                <h5 style="color: #1e293b; font-weight: 800; font-size: 0.95rem; margin: 0 0 0.2rem 0;">Alamat Kantor</h5>
                                <p style="color: #64748b; font-size: 0.85rem; line-height: 1.5; margin: 0;">Jl. D.I. Panjaitan No. 83, Wundudopi, Kec. Baruga, Kota Kendari, Sulawesi Tenggara 93116</p>
                            </div>
                        </div>

                        <div style="display: flex; gap: 1rem; align-items: flex-start;">
                            <div style="background: #e0e7ff; color: #4338ca; width: 2.75rem; height: 2.75rem; border-radius: 0.85rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.2rem;">⏰</div>
                            <div style="flex: 1;">
                                <h5 style="color: #1e293b; font-weight: 800; font-size: 0.95rem; margin: 0 0 0.4rem 0;">Jam Pelayanan</h5>
                                <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: #475569; margin-bottom: 0.2rem;">
                                    <span>Senin - Kamis</span> <strong style="color: #1e293b;">07.30 - 16.00</strong>
                                </div>
                                <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: #475569; margin-bottom: 0.4rem;">
                                    <span>Jumat</span> <strong style="color: #1e293b;">07.30 - 16.30</strong>
                                </div>
                                <p style="color: #dc2626; font-size: 0.75rem; font-weight: 700; margin: 0;">*Sabtu, Minggu &amp; Libur Nasional Tutup</p>
                            </div>
                        </div>

                        <div style="display: flex; gap: 1rem; align-items: flex-start;">
                            <div style="background: #e0e7ff; color: #4338ca; width: 2.75rem; height: 2.75rem; border-radius: 0.85rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.2rem;">✉️</div>
                            <div>
                                <h5 style="color: #1e293b; font-weight: 800; font-size: 0.95rem; margin: 0 0 0.2rem 0;">Email Resmi</h5>
                                <p style="color: #64748b; font-size: 0.85rem; margin: 0;">
                                    <a href="mailto:bpmpsultra@kemendikdasmen.go.id" class="text-indigo-600 hover:underline font-semibold">bpmpsultra@kemendikdasmen.go.id</a>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

<!-- POP-UP MODAL GLASSMORPHISM UNTUK NOTIFIKASI BERHASIL / VALIDASI -->
<template x-teleport="body">
    <div x-show="showAlert" class="fixed inset-0 z-[999] flex items-center justify-center p-4" style="display: none;">
        <!-- Backdrop Blur -->
        <div x-show="showAlert" x-transition.opacity class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showAlert = false"></div>
        
        <!-- Modal Box -->
        <div x-show="showAlert" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-90 translate-y-4"
             class="relative bg-white/90 backdrop-blur-2xl border border-white/80 rounded-3xl shadow-2xl p-6 sm:p-8 w-full max-w-md flex flex-col items-center text-center">
            
            <div x-show="alertType === 'success'" class="w-14 h-14 rounded-2xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center mb-4 shadow-inner">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>

            <div x-show="alertType !== 'success'" class="w-14 h-14 rounded-2xl bg-amber-500/10 text-amber-500 flex items-center justify-center mb-4 shadow-inner">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>

            <h3 class="text-xl font-black text-slate-800 mb-2" x-text="alertTitle"></h3>
            <p class="text-slate-600 text-sm leading-relaxed mb-6" x-text="alertMessage"></p>
            
            <button @click="showAlert = false" class="w-full py-3 px-6 rounded-xl bg-indigo-600 text-white font-bold text-sm shadow-lg shadow-indigo-600/30 hover:bg-indigo-700 transition-all cursor-pointer">
                <span x-text="alertType === 'success' ? 'Tutup' : 'Mengerti & Periksa Kembali'"></span>
            </button>
        </div>
    </div>
</template>
@endsection

