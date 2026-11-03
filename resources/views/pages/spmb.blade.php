@extends('layouts.app')

@section('title', isset($page) ? $page->getSeoTitle() : 'Saluran Pengaduan Masyarakat Balai (SPMB) - BPMP Provinsi Sulawesi Tenggara')
@section('meta_description', isset($page) ? $page->getSeoDescription() : 'Kanal resmi bagi masyarakat untuk menyampaikan saran, aspirasi, maupun keluhan terkait layanan BPMP Provinsi Sulawesi Tenggara.')

@section('content')
<!-- HEADER UNIVERSAL (BIRU SOLID / BG-BLUE-900) -->
<div class="relative pt-28 pb-40 overflow-hidden bg-blue-900">
    <div class="relative z-10 text-center px-4 max-w-4xl mx-auto flex flex-col items-center">
        <!-- Badge Kategori / Label -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-white font-extrabold text-[10px] sm:text-xs uppercase tracking-widest shadow-sm mb-6">
            <div class="w-2 h-2 rounded-full bg-blue-400"></div>
            Layanan Pengaduan Publik
        </div>

        <!-- Judul Halaman Dinamis -->
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight mb-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            {{ $page->title ?? 'Saluran Pengaduan Masyarakat Balai (SPMB)' }}
        </h1>

        <!-- Breadcrumbs & Meta Date -->
        <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 text-xs sm:text-sm font-medium text-blue-200">
            <a href="/" class="hover:text-white transition-colors">Beranda</a>
            <span class="text-blue-400/60">›</span>
            <span class="text-white font-semibold">{{ $page->title ?? 'Pengaduan SPMB' }}</span>
            <span class="hidden sm:inline-block text-blue-400/60 mx-2">|</span>
            <div class="flex items-center gap-1.5 mt-2 sm:mt-0 px-3 py-1 rounded-lg bg-black/10 border border-white/10 text-blue-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Respons Cepat & Terpercaya
            </div>
        </div>
    </div>
</div>

<!-- KONTEN HALAMAN UNIVERSAL (Overlap menimpa header biru) -->
<div class="cms-master-wrapper relative z-20 w-full max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 -mt-24 mb-20">
    <div class="bg-white/95 backdrop-blur-xl rounded-[2.5rem] md:rounded-[3rem] shadow-xl border border-slate-100 p-6 md:p-12 lg:p-16 w-full overflow-hidden">

        <div style="width: 100%; display: flex; flex-direction: column; gap: 3rem;"
             x-data="{ 
                showAlert: {{ $errors->any() ? 'true' : 'false' }},
                alertMessage: '{{ $errors->any() ? addslashes(collect($errors->all())->implode('. ')) : '' }}',
                validateForm(event) {
                    let form = event.target;
                    let name = form.name ? form.name.value.trim() : '';
                    let email = form.email ? form.email.value.trim() : '';
                    let phone = form.phone ? form.phone.value.trim() : '';
                    let address = form.address ? form.address.value.trim() : '';
                    let message = form.message ? form.message.value.trim() : '';

                    if (!name || !email || !phone || !address || !message) {
                        event.preventDefault();
                        this.alertMessage = 'Mohon lengkapi semua isian formulir wajib (Nama, Email, Nomor HP, Alamat, dan Isi Pengaduan) sebelum mengirim.';
                        this.showAlert = true;
                        return false;
                    }

                    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailPattern.test(email)) {
                        event.preventDefault();
                        this.alertMessage = 'Format alamat email tidak valid. Pastikan penulisan email sudah benar (contoh: nama@email.com).';
                        this.showAlert = true;
                        return false;
                    }
                }
             }">

            <!-- DESKRIPSI & INFORMASI UTAMA -->
            <div style="width: 100%; max-width: 950px; margin: 0 auto; display: block;">
                <div class="shadow-sm" style="background-color: #eef2ff; border-radius: 1.5rem; padding: 2rem; display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap; border: 1px solid #e0e7ff;">
                    <div class="shadow-lg" style="background-color: #4f46e5; color: white; width: 4rem; height: 4rem; border-radius: 1rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg style="width: 2rem; height: 2rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    </div>
                    <p style="color: #475569; font-size: 1.1rem; line-height: 1.6; flex: 1; min-width: 250px; margin: 0;">
                        Kanal resmi bagi masyarakat untuk menyampaikan saran, aspirasi, maupun keluhan terkait layanan <strong style="color: #3730a3; font-weight: 800;">BPMP Provinsi Sulawesi Tenggara</strong>. Identitas pelapor dijamin kerahasiaannya.
                    </p>
                </div>
            </div>

            <!-- NOTIFIKASI SUKSES -->
            @if(session('success'))
                <div style="width: 100%; max-width: 950px; margin: 0 auto;" class="p-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 shadow-sm flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-base text-emerald-900">Laporan Berhasil Terkirim!</h4>
                        <p class="text-sm text-emerald-700 mt-1 leading-relaxed">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- BINGKAI UTAMA FORMULIR SPMB (Persis Sesuai Desain & Gambar) -->
            <div style="width: 100%; max-width: 950px; margin: 0 auto; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 2.5rem; padding: 2.5rem; box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05);">
                
                <div style="margin-bottom: 2rem; border-bottom: 2px solid #f1f5f9; padding-bottom: 1rem;">
                    <h3 style="color: #1e293b; font-weight: 900; font-size: 1.35rem; margin: 0 0 0.25rem 0;">Formulir Pengaduan Masyarakat (SPMB)</h3>
                    <p style="color: #64748b; font-size: 0.9rem; margin: 0;">Silakan isi formulir di bawah ini dengan data yang valid dan uraian pengaduan yang jelas.</p>
                </div>

                <!-- FORMULIR UTAMA -->
                <form action="{{ route('spmb.store') }}" method="POST" enctype="multipart/form-data" @submit="validateForm($event)" style="display: flex; flex-direction: column; gap: 1.5rem;">
                    @csrf
                    <input type="hidden" name="category" value="spmb">

                    <!-- Baris 1: Nama & Email -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.5rem; letter-spacing: 0.05em;">NAMA ANDA *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama Lengkap..."
                                style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 1rem; padding: 0.85rem 1rem; outline: none; font-size: 0.95rem; color: #1e293b; box-sizing: border-box;"
                                class="focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                            @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.5rem; letter-spacing: 0.05em;">EMAIL *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com"
                                style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 1rem; padding: 0.85rem 1rem; outline: none; font-size: 0.95rem; color: #1e293b; box-sizing: border-box;"
                                class="focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                            @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Baris 2: Nomor HP/WhatsApp & Alamat -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.5rem; letter-spacing: 0.05em;">NOMOR HP / WHATSAPP *</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="08xxxxxxxxxx"
                                style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 1rem; padding: 0.85rem 1rem; outline: none; font-size: 0.95rem; color: #1e293b; box-sizing: border-box;"
                                class="focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                            @error('phone') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.5rem; letter-spacing: 0.05em;">ALAMAT ANDA *</label>
                            <input type="text" name="address" value="{{ old('address') }}" required placeholder="Kota Kendari..."
                                style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 1rem; padding: 0.85rem 1rem; outline: none; font-size: 0.95rem; color: #1e293b; box-sizing: border-box;"
                                class="focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                            @error('address') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Baris 3: Isi Pengaduan -->
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.5rem; letter-spacing: 0.05em;">ISI PENGADUAN *</label>
                        <textarea name="message" rows="5" required placeholder="Tuliskan isi pengaduan Anda di sini secara detail..."
                            style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 1rem; padding: 1rem; outline: none; font-size: 0.95rem; color: #1e293b; resize: vertical; box-sizing: border-box;"
                            class="focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">{{ old('message') }}</textarea>
                        @error('message') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Baris 4: Lampiran Bukti (Opsional) -->
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.5rem; letter-spacing: 0.05em;">LENGKAPI LAPORAN DENGAN MELAMPIRKAN BUKTI KEJADIAN (OPSIONAL)</label>
                        <input type="file" name="evidence_file" accept=".pdf,.jpg,.jpeg,.png"
                            style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 1rem; padding: 0.75rem 1rem; font-size: 0.9rem; color: #475569; box-sizing: border-box;"
                            class="focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300">
                        <p class="text-[11px] text-slate-400 mt-1">Format didukung: PDF, JPG, JPEG, PNG (Maksimal 5 MB).</p>
                        @error('evidence_file') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Tombol Kirim Pengaduan -->
                    <div style="display: flex; justify-content: flex-end; margin-top: 1rem;">
                        <button type="submit" class="hover:bg-indigo-700 transition-all duration-300 shadow-lg shadow-indigo-600/30"
                            style="background-color: #4f46e5; color: white; padding: 0.9rem 2.5rem; border-radius: 1rem; font-weight: 800; font-size: 0.95rem; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;">
                            <span>Kirim Pengaduan</span>
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>

<!-- POP-UP MODAL ALERT GLASSMORPHISM UNTUK BACKEND & FRONTEND VALIDATION -->
<template x-teleport="body">
    <div x-show="showAlert" class="fixed inset-0 z-[999] flex items-center justify-center p-4" style="display: none;">
        <!-- Backdrop Blur -->
        <div x-show="showAlert" x-transition.opacity class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showAlert = false"></div>
        
        <!-- Modal Box Glassmorphic Card -->
        <div x-show="showAlert" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-90 translate-y-4"
             class="relative bg-white/90 backdrop-blur-2xl border border-white/80 rounded-3xl shadow-2xl p-6 sm:p-8 w-full max-w-md flex flex-col items-center text-center">
            
            <!-- Icon Peringatan -->
            <div class="w-14 h-14 rounded-2xl bg-amber-500/10 text-amber-500 flex items-center justify-center mb-4 shadow-inner">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>

            <!-- Judul & Pesan Kesalahan Backend / Frontend -->
            <h3 class="text-xl font-black text-slate-800 mb-2">Pemberitahuan Sistem</h3>
            <p class="text-slate-600 text-sm leading-relaxed mb-6" x-text="alertMessage"></p>

            <!-- Tombol OK -->
            <button @click="showAlert = false" class="w-full py-3 px-6 rounded-xl bg-indigo-600 text-white font-bold text-sm shadow-lg shadow-indigo-600/30 hover:bg-indigo-700 transition-all cursor-pointer">
                Mengerti &amp; Periksa Kembali
            </button>
        </div>
    </div>
</template>
@endsection

