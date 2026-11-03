@extends('layouts.app')

@section('title', isset($page) ? $page->getSeoTitle() : 'Lapor Gratifikasi - BPMP Provinsi Sulawesi Tenggara')
@section('meta_description', isset($page) ? $page->getSeoDescription() : 'Instrumen pengendalian gratifikasi internal pegawai BPMP Provinsi Sulawesi Tenggara untuk mendukung Zona Integritas.')

@section('content')
<!-- HEADER UNIVERSAL (BIRU SOLID / BG-BLUE-900) -->
<div class="relative pt-28 pb-40 overflow-hidden bg-blue-900">
    <div class="relative z-10 text-center px-4 max-w-4xl mx-auto flex flex-col items-center">
        <!-- Badge Kategori / Label -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-white font-extrabold text-[10px] sm:text-xs uppercase tracking-widest shadow-sm mb-6">
            <div class="w-2 h-2 rounded-full bg-blue-400"></div>
            Zona Integritas &amp; UPG
        </div>

        <!-- Judul Halaman Dinamis -->
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight mb-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            {{ $page->title ?? 'Lapor Gratifikasi' }}
        </h1>

        <!-- Breadcrumbs & Meta Date -->
        <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 text-xs sm:text-sm font-medium text-blue-200">
            <a href="/" class="hover:text-white transition-colors">Beranda</a>
            <span class="text-blue-400/60">›</span>
            <a href="/zi-wbk" class="hover:text-white transition-colors">ZI-WBK</a>
            <span class="text-blue-400/60">›</span>
            <span class="text-white font-semibold">{{ $page->title ?? 'Lapor Gratifikasi' }}</span>
            <span class="hidden sm:inline-block text-blue-400/60 mx-2">|</span>
            <div class="flex items-center gap-1.5 mt-2 sm:mt-0 px-3 py-1 rounded-lg bg-black/10 border border-white/10 text-blue-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                Unit Pengendalian Gratifikasi (UPG)
            </div>
        </div>
    </div>
</div>

<!-- KONTEN HALAMAN UNIVERSAL (Overlap menimpa header biru) -->
<div class="cms-master-wrapper relative z-20 w-full max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 -mt-24 mb-20">
    <div class="bg-white/95 backdrop-blur-xl rounded-[2.5rem] md:rounded-[3rem] shadow-xl border border-slate-100 p-6 md:p-12 lg:p-16 w-full overflow-hidden">

        <!-- NOTIFIKASI SUKSES -->
        @if(session('success'))
            <div style="width: 100%; max-width: 950px; margin: 0 auto 2rem auto;" class="p-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 shadow-sm flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <h4 class="font-extrabold text-base text-emerald-900">Laporan Berhasil Terkirim!</h4>
                    <p class="text-sm text-emerald-700 mt-1 leading-relaxed">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- WRAPPER MULTI-STEP DENGAN ALPINE.JS & POP-UP ALERT GLASSMORPHISM -->
        <div style="width: 100%; display: flex; flex-direction: column; gap: 3rem;" x-data="{ 
            step: 1,
            showAlert: {{ $errors->any() ? 'true' : 'false' }},
            alertMessage: '{{ $errors->any() ? addslashes(collect($errors->all())->implode('. ')) : '' }}',
            validateStep1() {
                let name = document.getElementById('name') ? document.getElementById('name').value : '';
                let email = document.getElementById('email') ? document.getElementById('email').value : '';
                let pos = document.getElementById('position') ? document.getElementById('position').value : '';
                let actName = document.getElementById('activity_name') ? document.getElementById('activity_name').value : '';
                let actDate = document.getElementById('activity_date') ? document.getElementById('activity_date').value : '';
                let actLoc = document.getElementById('activity_location') ? document.getElementById('activity_location').value : '';

                if(!name || !email || !pos) {
                    this.alertMessage = 'Mohon lengkapi data wajib (Nama, Email, dan Jabatan) pada tahap ini terlebih dahulu.';
                    this.showAlert = true;
                    return;
                }
                if(!actName || !actDate || !actLoc) {
                    this.alertMessage = 'Mohon lengkapi informasi kegiatan (Nama Kegiatan, Tanggal, dan Tempat Pelaksanaan).';
                    this.showAlert = true;
                    return;
                }
                this.step = 2;
            }
        }">

            <!-- DESKRIPSI & INFORMASI UTAMA -->
            <div style="width: 100%; max-width: 950px; margin: 0 auto; display: block;">
                <div class="shadow-sm" style="background-color: #eef2ff; border-radius: 1.5rem; padding: 2rem; display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap; border: 1px solid #e0e7ff;">
                    <div class="shadow-lg" style="background-color: #4f46e5; color: white; width: 4rem; height: 4rem; border-radius: 1rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg style="width: 2rem; height: 2rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <p style="color: #475569; font-size: 1.05rem; line-height: 1.6; flex: 1; min-width: 250px; margin: 0;">
                        Instrumen pengendalian gratifikasi internal pegawai <strong style="color: #3730a3; font-weight: 800;">BPMP Provinsi Sulawesi Tenggara</strong>. Instrumen ini digunakan untuk mendukung Zona Integritas dan kepatuhan kode etik pegawai.
                    </p>
                </div>
            </div>

            <!-- INDIKATOR TAB KARTU (Modern Center, Berlogo, Sudut Melengkung Rapih) -->
            <div style="width: 100%; max-width: 950px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.25rem;">
                <!-- Tab 1 -->
                <div @click="step = 1" style="cursor: pointer; transition: all 0.3s ease; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1.5rem 1rem; border-radius: 1.5rem; text-align: center;"
                     :style="step === 1 ? 'background: #eff6ff; border: 2px solid #3b82f6; box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.2);' : 'background: rgba(255, 255, 255, 0.9); border: 1px solid #e2e8f0; opacity: 0.75;'">
                    <div style="width: 3rem; height: 3rem; border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin-bottom: 0.75rem;"
                         :style="step === 1 ? 'background: #3b82f6; color: white; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);' : 'background: #f1f5f9; color: #64748b;'">
                        <svg style="width: 1.4rem; height: 1.4rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <span style="font-weight: 800; font-size: 0.95rem;" :style="step === 1 ? 'color: #1d4ed8;' : 'color: #475569;'">Data &amp; Kegiatan</span>
                </div>

                <!-- Tab 2 -->
                <div @click="step === 1 ? validateStep1() : step = 2" style="cursor: pointer; transition: all 0.3s ease; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1.5rem 1rem; border-radius: 1.5rem; text-align: center;"
                     :style="step === 2 ? 'background: #eff6ff; border: 2px solid #3b82f6; box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.2);' : 'background: rgba(255, 255, 255, 0.9); border: 1px solid #e2e8f0; opacity: 0.75;'">
                    <div style="width: 3rem; height: 3rem; border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin-bottom: 0.75rem;"
                         :style="step === 2 ? 'background: #3b82f6; color: white; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);' : 'background: #f1f5f9; color: #64748b;'">
                        <svg style="width: 1.4rem; height: 1.4rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span style="font-weight: 800; font-size: 0.95rem;" :style="step === 2 ? 'color: #1d4ed8;' : 'color: #475569;'">Layanan Gratis</span>
                </div>

                <!-- Tab 3 -->
                <div @click="step === 1 ? validateStep1() : step = 3" style="cursor: pointer; transition: all 0.3s ease; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1.5rem 1rem; border-radius: 1.5rem; text-align: center;"
                     :style="step === 3 ? 'background: #eff6ff; border: 2px solid #3b82f6; box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.2);' : 'background: rgba(255, 255, 255, 0.9); border: 1px solid #e2e8f0; opacity: 0.75;'">
                    <div style="width: 3rem; height: 3rem; border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin-bottom: 0.75rem;"
                         :style="step === 3 ? 'background: #3b82f6; color: white; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);' : 'background: #f1f5f9; color: #64748b;'">
                        <svg style="width: 1.4rem; height: 1.4rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 10v10l8 4"/></svg>
                    </div>
                    <span style="font-weight: 800; font-size: 0.95rem;" :style="step === 3 ? 'color: #1d4ed8;' : 'color: #475569;'">Ole-ole &amp; Bukti</span>
                </div>
            </div>

            <!-- BINGKAI UTAMA MULTI-STEP FORM -->
            <div style="width: 100%; max-width: 950px; margin: 0 auto; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 2.5rem; padding: 2.5rem; box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05);">

                <form action="{{ route('gratification.store') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.5rem;">
                    @csrf

                    <!-- TAHAP 1: DATA PEGAWAI & KEGIATAN -->
                    <div x-show="step === 1" style="display: flex; flex-direction: column; gap: 1.25rem;">
                        <h4 style="color: #1e293b; font-weight: 800; font-size: 1.15rem; margin-bottom: 0.5rem;">Tahap 1: Informasi Pegawai &amp; Penugasan Kegiatan</h4>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
                            <div>
                                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.4rem;">Email *</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com" style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 0.85rem; padding: 0.75rem 1rem; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.4rem;">Nama Pegawai *</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Nama Lengkap..." style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 0.85rem; padding: 0.75rem 1rem; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
                            <div>
                                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.4rem;">NIP (Tulis 0 jika tidak ada) *</label>
                                <input type="text" name="nip" value="{{ old('nip', '0') }}" required style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 0.85rem; padding: 0.75rem 1rem; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.4rem;">Jabatan *</label>
                                <input type="text" id="position" name="position" value="{{ old('position') }}" required placeholder="Jabatan Anda..." style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 0.85rem; padding: 0.75rem 1rem; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                        </div>

                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.4rem;">Nama Kegiatan yang diikuti/dilaksanakan *</label>
                            <input type="text" id="activity_name" name="activity_name" value="{{ old('activity_name') }}" required placeholder="Nama Kegiatan..." style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 0.85rem; padding: 0.75rem 1rem; font-size: 0.9rem; box-sizing: border-box;">
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
                            <div>
                                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.4rem;">Tanggal Kegiatan *</label>
                                <input type="date" id="activity_date" name="activity_date" value="{{ old('activity_date') }}" required style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 0.85rem; padding: 0.75rem 1rem; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.4rem;">Tempat Kegiatan *</label>
                                <input type="text" id="activity_location" name="activity_location" value="{{ old('activity_location') }}" required placeholder="Gedung / Hotel / Kota..." style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 0.85rem; padding: 0.75rem 1rem; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                        </div>

                        <div style="display: flex; justify-content: flex-end; margin-top: 1rem;">
                            <button type="button" @click="validateStep1()" style="background: #4f46e5; color: white; padding: 0.75rem 2rem; border-radius: 0.85rem; font-weight: 700; border: none; cursor: pointer;">
                                Selanjutnya &rarr;
                            </button>
                        </div>
                    </div>

                    <!-- TAHAP 2: GRATIFIKASI DALAM BENTUK LAYANAN GRATIS -->
                    <div x-show="step === 2" style="display: flex; flex-direction: column; gap: 1.25rem;" style="display: none;">
                        <h4 style="color: #1e293b; font-weight: 800; font-size: 1.15rem; margin-bottom: 0.2rem;">Tahap 2: Penerimaan Layanan Gratis</h4>
                        <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 1rem;">Layanan berupa fasilitas yang membuat pegawai tidak perlu mengeluarkan biaya.</p>

                        <div style="display: flex; flex-direction: column; gap: 0.6rem; background: #f8fafc; padding: 1.25rem; border-radius: 1rem; border: 1px solid #e2e8f0;">
                            <label style="font-size: 0.9rem; font-weight: 600; color: #334155; display: flex; align-items: center; gap: 0.5rem;">
                                <input type="checkbox" name="free_services[]" value="Transportasi"> Layanan Transportasi pergi dan/atau pulang
                            </label>
                            <label style="font-size: 0.9rem; font-weight: 600; color: #334155; display: flex; align-items: center; gap: 0.5rem;">
                                <input type="checkbox" name="free_services[]" value="Akomodasi"> Layanan pembayaran biaya akomodasi
                            </label>
                            <label style="font-size: 0.9rem; font-weight: 600; color: #334155; display: flex; align-items: center; gap: 0.5rem;">
                                <input type="checkbox" name="free_services[]" value="Konsumsi"> Layanan 'traktir' makan pagi/siang/malam
                            </label>
                            <label style="font-size: 0.9rem; font-weight: 600; color: #334155; display: flex; align-items: center; gap: 0.5rem;">
                                <input type="checkbox" name="free_services[]" value="Tidak Ada"> Tidak ada layanan gratis yang diterima
                            </label>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
                            <div>
                                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.4rem;">Tanggal Terjadinya Layanan</label>
                                <input type="date" name="service_date" value="{{ old('service_date') }}" style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 0.85rem; padding: 0.75rem 1rem; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.4rem;">Nama Pemberi Layanan (Tulis 0 jika nihil)</label>
                                <input type="text" name="service_provider_name" value="{{ old('service_provider_name', '0') }}" placeholder="Nama..." style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 0.85rem; padding: 0.75rem 1rem; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                        </div>

                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.4rem;">Jabatan Pemberi Layanan (Tulis 0 jika nihil)</label>
                            <input type="text" name="service_provider_position" value="{{ old('service_provider_position', '0') }}" placeholder="Jabatan..." style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 0.85rem; padding: 0.75rem 1rem; font-size: 0.9rem; box-sizing: border-box;">
                        </div>

                        <div style="display: flex; justify-content: space-between; margin-top: 1rem;">
                            <button type="button" @click="step = 1" style="background: #e2e8f0; color: #475569; padding: 0.75rem 1.5rem; border-radius: 0.85rem; font-weight: 700; border: none; cursor: pointer;">
                                &larr; Kembali
                            </button>
                            <button type="button" @click="step = 3" style="background: #4f46e5; color: white; padding: 0.75rem 2rem; border-radius: 0.85rem; font-weight: 700; border: none; cursor: pointer;">
                                Selanjutnya &rarr;
                            </button>
                        </div>
                    </div>

                    <!-- TAHAP 3: MENERIMA OLE-OLE & BUKTI -->
                    <div x-show="step === 3" style="display: flex; flex-direction: column; gap: 1.25rem;" style="display: none;">
                        <h4 style="color: #1e293b; font-weight: 800; font-size: 1.15rem; margin-bottom: 0.2rem;">Tahap 3: Penerimaan Ole-ole / Barang &amp; Tindak Lanjut</h4>

                        <div style="background: #f8fafc; padding: 1.25rem; border-radius: 1rem; border: 1px solid #e2e8f0;">
                            <label style="font-size: 0.85rem; font-weight: 700; color: #334155; display: block; margin-bottom: 0.5rem;">Jenis Ole-Ole Habis Pakai yang diterima:</label>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 0.5rem;">
                                <label style="font-size: 0.85rem; color: #475569;"><input type="checkbox" name="gift_consumable_types[]" value="Makanan siap saji"> Makanan siap saji</label>
                                <label style="font-size: 0.85rem; color: #475569;"><input type="checkbox" name="gift_consumable_types[]" value="Kue/Kripik"> Penganan kecil (kue, keripik)</label>
                                <label style="font-size: 0.85rem; color: #475569;"><input type="checkbox" name="gift_consumable_types[]" value="Minuman"> Minuman</label>
                                <label style="font-size: 0.85rem; color: #475569;"><input type="checkbox" name="gift_consumable_types[]" value="Buah-buahan"> Buah-buahan</label>
                            </div>
                        </div>

                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.4rem;">Nama Ole-Ole Barang/Benda TIDAK Habis Pakai (Tulis "tidak menerima" jika nihil)</label>
                            <input type="text" name="gift_non_consumable_desc" value="{{ old('gift_non_consumable_desc', 'tidak menerima') }}" placeholder="Contoh: Pakaian, kain..." style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 0.85rem; padding: 0.75rem 1rem; font-size: 0.9rem; box-sizing: border-box;">
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
                            <div>
                                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.4rem;">Nama Pemberi Ole-Ole</label>
                                <input type="text" name="gift_giver_name" value="{{ old('gift_giver_name') }}" placeholder="Nama pemberi..." style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 0.85rem; padding: 0.75rem 1rem; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.4rem;">Jabatan Pemberi Ole-Ole</label>
                                <input type="text" name="gift_giver_position" value="{{ old('gift_giver_position') }}" placeholder="Jabatan pemberi..." style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 0.85rem; padding: 0.75rem 1rem; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                        </div>

                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.4rem;">Tanggal Menerima Ole-Ole</label>
                            <input type="date" name="gift_received_date" value="{{ old('gift_received_date') }}" style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 0.85rem; padding: 0.75rem 1rem; font-size: 0.9rem; box-sizing: border-box;">
                        </div>

                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.4rem;">Tindak lanjut setelah menerima Ole-ole</label>
                            <select name="follow_up_action" style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 0.85rem; padding: 0.75rem 1rem; font-size: 0.9rem; box-sizing: border-box;">
                                <option value="Dimakan sendiri" {{ old('follow_up_action') === 'Dimakan sendiri' ? 'selected' : '' }}>Dimakan sendiri</option>
                                <option value="Dibagikan keluarga" {{ old('follow_up_action') === 'Dibagikan keluarga' ? 'selected' : '' }}>Dibagikan kepada keluarga/kerabat</option>
                                <option value="Dibagikan pegawai" {{ old('follow_up_action') === 'Dibagikan pegawai' ? 'selected' : '' }}>Dibagikan kepada pegawai kantor</option>
                                <option value="Dipajang" {{ old('follow_up_action') === 'Dipajang' ? 'selected' : '' }}>Dipajang di lemari gratifikasi / kantor</option>
                            </select>
                        </div>

                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.4rem;">Unggah Dokumentasi Foto Barang / Bill / Tiket (Maks. 10MB)</label>
                            <input type="file" name="evidence_file" accept=".pdf,.jpg,.jpeg,.png" style="width: 100%; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 0.85rem; padding: 0.75rem 1rem; font-size: 0.9rem; box-sizing: border-box;">
                            <p style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.35rem;">Format didukung: PDF, JPG, JPEG, PNG (Maksimal 10 MB).</p>
                        </div>

                        <div style="display: flex; justify-content: space-between; margin-top: 1rem;">
                            <button type="button" @click="step = 2" style="background: #e2e8f0; color: #475569; padding: 0.75rem 1.5rem; border-radius: 0.85rem; font-weight: 700; border: none; cursor: pointer;">
                                &larr; Kembali
                            </button>
                            <button type="submit" style="background: #10b981; color: white; padding: 0.85rem 2.5rem; border-radius: 0.85rem; font-weight: 800; border: none; cursor: pointer; box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);">
                                Kirim Laporan Gratifikasi
                            </button>
                        </div>
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

            <!-- Judul & Pesan Kesalahan Backend -->
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
