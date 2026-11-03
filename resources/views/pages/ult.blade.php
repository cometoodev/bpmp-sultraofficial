@extends('layouts.app')

@section('title', 'Unit Layanan Terpadu (ULT) - BPMP Provinsi Sulawesi Tenggara')
@section('meta_description', 'Portal resmi Unit Layanan Terpadu (ULT) Balai Penjaminan Mutu Pendidikan Provinsi Sulawesi Tenggara. Layanan Online, Tatap Muka, dan Mobile Service.')

@section('content')
<div class="relative min-h-screen bg-slate-50 overflow-hidden font-['Poppins',sans-serif]" 
     x-data="{
        activeTab: '{{ request('tab', 'online') }}',
        trackInput: '{{ request('ticket', '') }}',
        trackLoading: false,
        trackResult: null,
        trackError: '',
        tatapMukaLocked: true,
        tatapMukaPin: '',
        tatapMukaError: false,
        
        unlockTatapMuka() {
            if (this.tatapMukaPin.trim() === 'ULT2026') {
                this.tatapMukaLocked = false;
                this.tatapMukaError = false;
                this.tatapMukaPin = '';
            } else {
                this.tatapMukaError = true;
            }
        },

        lockTatapMuka() {
            this.tatapMukaLocked = true;
            this.tatapMukaPin = '';
            this.tatapMukaError = false;
        },

        async checkTracking() {
            if (!this.trackInput.trim()) {
                this.trackError = 'Silakan masukkan nomor tiket permohonan Anda.';
                this.trackResult = null;
                return;
            }
            this.trackLoading = true;
            this.trackError = '';
            this.trackResult = null;
            try {
                const res = await fetch('{{ route('ult.track') }}?ticket=' + encodeURIComponent(this.trackInput.trim()));
                const data = await res.json();
                if (res.ok && data.found) {
                    this.trackResult = data;
                } else {
                    this.trackError = data.message || 'Nomor tiket tidak ditemukan.';
                }
            } catch (err) {
                this.trackError = 'Gagal menghubungi server untuk verifikasi tiket.';
            } finally {
                this.trackLoading = false;
            }
        }
     }"
     x-init="if (trackInput) { checkTracking(); }">

    <!-- HEADER UNIVERSAL (BIRU SOLID / BG-BLUE-900) -->
    <div class="relative pt-28 pb-40 overflow-hidden bg-blue-900">
        
        <!-- Konten Judul Header -->
        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto flex flex-col items-center">
            
            <!-- Badge Kategori / Label -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-white font-extrabold text-[10px] sm:text-xs uppercase tracking-widest shadow-sm mb-6">
                <div class="w-2 h-2 rounded-full bg-blue-400"></div>
                Sistem Informasi Publik
            </div>

            <!-- Judul Halaman Dinamis / Statis ULT -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight mb-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Unit Layanan Terpadu (ULT)
            </h1>

            <!-- Breadcrumbs & Meta Date -->
            <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 text-xs sm:text-sm font-medium text-blue-200">
                <a href="/" class="hover:text-white transition-colors">Beranda</a>
                <span class="text-blue-400/60">›</span>
                <span class="text-white font-semibold">Unit Layanan Terpadu (ULT)</span>
                
                <span class="hidden sm:inline-block text-blue-400/60 mx-2">|</span>
                
                <div class="flex items-center gap-1.5 mt-2 sm:mt-0 px-3 py-1 rounded-lg bg-black/10 border border-white/10 text-blue-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Diperbarui: {{ isset($page) ? $page->updated_at->format('d M Y') : date('d M Y') }}
                </div>
            </div>
        </div>
    </div>

    <!-- KONTEN HALAMAN (Overlap) -->
    <div class="relative z-20 w-full max-w-[1440px] mx-auto px-4 md:px-8 lg:px-12 -mt-24 mb-20 space-y-10">

        <!-- NOTIFIKASI SUKSES (FLASH MESSAGE) -->
        @if(session('success'))
            <div class="max-w-2xl mx-auto bg-emerald-500/10 border-2 border-emerald-500/40 backdrop-blur-xl p-5 sm:p-6 rounded-3xl shadow-xl shadow-emerald-500/10 text-emerald-900">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-md shadow-emerald-500/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-base font-['Plus_Jakarta_Sans']">Permohonan Berhasil Dikirim!</h4>
                        <p class="text-xs sm:text-sm text-emerald-800 mt-1 leading-relaxed">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- LACAK STATUS TIKET (QUICK TRACKING BAR) -->
        <div class="max-w-2xl mx-auto">
            <div class="bg-white/80 backdrop-blur-xl border border-white/80 shadow-lg shadow-blue-500/5 rounded-3xl p-4 sm:p-5">
                <div class="flex items-center gap-2 mb-2 text-xs font-bold text-slate-700 uppercase tracking-wider font-['Plus_Jakarta_Sans']">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <span>Lacak Status Tiket Permohonan</span>
                </div>
                <form @submit.prevent="checkTracking" class="flex flex-col sm:flex-row gap-2">
                    <input type="text" x-model="trackInput" placeholder="Masukkan Nomor Tiket (Contoh: ULT-20261031-ABCD)"
                           class="flex-1 bg-white/90 border border-slate-200/90 rounded-2xl px-4 py-2.5 text-xs sm:text-sm font-mono text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all uppercase placeholder-slate-400">
                    <button type="submit" 
                            :disabled="trackLoading"
                            class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-xs sm:text-sm rounded-2xl shadow-md shadow-blue-500/25 transition-all flex items-center justify-center gap-2 cursor-pointer shrink-0 disabled:opacity-50">
                        <span x-show="!trackLoading">Cek Status</span>
                        <span x-show="trackLoading" class="inline-flex items-center gap-1.5">
                            <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Memeriksa...
                        </span>
                    </button>
                </form>

                <!-- Pesan Error Tracking -->
                <div x-show="trackError" style="display: none;" class="mt-3 p-3 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span x-text="trackError"></span>
                </div>

                <!-- Hasil Pelacakan Tiket -->
                <template x-if="trackResult">
                    <div class="mt-4 p-4 rounded-2xl bg-blue-50/70 border border-blue-200/70 text-slate-800 text-xs space-y-2">
                        <div class="flex items-center justify-between border-b border-blue-100 pb-2">
                            <span class="font-mono font-black text-blue-900 text-sm" x-text="trackResult.ticket_number"></span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider"
                                  :class="{
                                      'bg-amber-100 text-amber-800 border border-amber-200': trackResult.status === 'pending',
                                      'bg-blue-100 text-blue-800 border border-blue-200': trackResult.status === 'diproses',
                                      'bg-emerald-100 text-emerald-800 border border-emerald-200': trackResult.status === 'selesai',
                                      'bg-rose-100 text-rose-800 border border-rose-200': trackResult.status === 'ditolak'
                                  }" x-text="trackResult.status_label"></span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-[11px] pt-1">
                            <div><span class="text-slate-400">Pemohon:</span> <strong x-text="trackResult.nama"></strong></div>
                            <div><span class="text-slate-400">Tipe:</span> <span x-text="trackResult.type_label"></span></div>
                            <div class="col-span-2"><span class="text-slate-400">Kategori:</span> <span class="font-medium text-slate-700" x-text="trackResult.kategori"></span></div>
                            <div class="col-span-2"><span class="text-slate-400">Tanggal Pengajuan:</span> <span x-text="trackResult.created_at"></span></div>
                        </div>
                        <template x-if="trackResult.catatan_petugas">
                            <div class="mt-2 p-2.5 bg-white/80 rounded-xl border border-blue-100">
                                <span class="font-bold text-blue-900 block text-[10px] uppercase">Catatan Petugas ULT:</span>
                                <p class="text-slate-700 italic mt-0.5" x-text="trackResult.catatan_petugas"></p>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>

        <!-- TAHAP 1: KARTU & TAB JENIS LAYANAN UTAMA -->
        <div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
            <!-- 1. Layanan Online -->
            <button @click="activeTab = 'online'"
                    :class="activeTab === 'online' ? 'border-blue-500 bg-blue-50/80 shadow-md ring-2 ring-blue-500/20' : 'border-slate-200/80 bg-white/80 hover:bg-white hover:border-slate-300'"
                    class="flex flex-col items-center justify-center p-6 rounded-2xl border transition-all duration-300 text-center group cursor-pointer">
                <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                </div>
                <span class="font-bold text-slate-800 text-sm font-['Plus_Jakarta_Sans']">Layanan Online</span>
                <span class="text-xs text-slate-500 mt-1">Permohonan & Tiket Digital</span>
            </button>

            <!-- 2. Layanan Tatap Muka -->
            <button @click="activeTab = 'tatap-muka'"
                    :class="activeTab === 'tatap-muka' ? 'border-blue-500 bg-blue-50/80 shadow-md ring-2 ring-blue-500/20' : 'border-slate-200/80 bg-white/80 hover:bg-white hover:border-slate-300'"
                    class="flex flex-col items-center justify-center p-6 rounded-2xl border transition-all duration-300 text-center group cursor-pointer">
                <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <span class="font-bold text-slate-800 text-sm font-['Plus_Jakarta_Sans']">Layanan Tatap Muka</span>
                <span class="text-xs text-slate-500 mt-1">Buku Tamu Meja Front Office</span>
            </button>

            <!-- 3. Layanan Keliling -->
            <button @click="activeTab = 'keliling'"
                    :class="activeTab === 'keliling' ? 'border-blue-500 bg-blue-50/80 shadow-md ring-2 ring-blue-500/20' : 'border-slate-200/80 bg-white/80 hover:bg-white hover:border-slate-300'"
                    class="flex flex-col items-center justify-center p-6 rounded-2xl border transition-all duration-300 text-center group cursor-pointer">
                <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                </div>
                <span class="font-bold text-slate-800 text-sm font-['Plus_Jakarta_Sans']">Layanan Keliling</span>
                <span class="text-xs text-slate-500 mt-1">Mobile Service 17 Kab/Kota</span>
            </button>

            <!-- 4. Tim ULT (Sesuai Permintaan Tahap 1) -->
            <button @click="activeTab = 'tim-ult'"
                    :class="activeTab === 'tim-ult' ? 'border-blue-500 bg-blue-50/80 shadow-md ring-2 ring-blue-500/20' : 'border-slate-200/80 bg-white/80 hover:bg-white hover:border-slate-300'"
                    class="flex flex-col items-center justify-center p-6 rounded-2xl border transition-all duration-300 text-center group cursor-pointer">
                <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <!-- Ikon User Group/Support -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <span class="font-bold text-slate-800 text-sm font-['Plus_Jakarta_Sans']">Tim ULT</span>
                <span class="text-xs text-slate-500 mt-1">Profil & Susunan Petugas</span>
            </button>
        </div>

        <!-- =============================================================== -->
        <!-- TAB 1: FORMULIR LAYANAN ONLINE (TAHAP 2)                         -->
        <!-- =============================================================== -->
        <div x-show="activeTab === 'online'" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="space-y-8">

            <div class="bg-white/70 backdrop-blur-xl border border-white/80 shadow-xl shadow-blue-500/5 rounded-3xl p-6 sm:p-10">
                <!-- Header Formulir -->
                <div class="border-b border-slate-200/70 pb-6 mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100/80 text-blue-700 text-xs font-bold font-['Plus_Jakarta_Sans'] mb-2">
                            Formulir Pengajuan Online Resmi
                        </div>
                        <h2 class="text-2xl font-black text-slate-900 font-['Plus_Jakarta_Sans']">Permohonan Layanan Daring Satu Pintu</h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">Silakan lengkapi identitas dan pilih 1 dari 8 kategori layanan resmi ULT BPMP Provinsi Sulawesi Tenggara.</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-500 bg-slate-100/80 px-4 py-2 rounded-2xl shrink-0">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Estimasi Respon: <strong>1x24 Jam Kerja</strong></span>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                        <div class="font-bold flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Terdapat kendala pada data formulir yang Anda masukkan:
                        </div>
                        <ul class="list-disc list-inside space-y-0.5 pl-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Pengajuan Online -->
                <form action="{{ route('ult.online.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                                Nama Lengkap Pemohon <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Masukkan nama lengkap beserta gelar jika ada..."
                                   class="w-full bg-white/90 border border-slate-200/90 rounded-2xl px-4 py-3 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all placeholder-slate-400">
                        </div>

                        <!-- Email Aktif -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                                Alamat Email Aktif <span class="text-rose-500">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="email.anda@instansi.go.id..."
                                   class="w-full bg-white/90 border border-slate-200/90 rounded-2xl px-4 py-3 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all placeholder-slate-400">
                        </div>

                        <!-- Nomor WhatsApp / HP -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                                No. HP / WhatsApp <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" required placeholder="08xxxxxxxxxx (untuk konfirmasi progres tiket)..."
                                   class="w-full bg-white/90 border border-slate-200/90 rounded-2xl px-4 py-3 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all placeholder-slate-400">
                        </div>

                        <!-- Asal Instansi / Sekolah / Lembaga -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                                Asal Instansi / Satuan Pendidikan
                            </label>
                            <input type="text" name="instansi" value="{{ old('instansi') }}" placeholder="Contoh: Dinas Pendidikan Prov. Sultra / SMAN 1 Kendari..."
                                   class="w-full bg-white/90 border border-slate-200/90 rounded-2xl px-4 py-3 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all placeholder-slate-400">
                        </div>

                        <!-- Profesi / Pekerjaan -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                                Profesi / Jabatan Pemohon
                            </label>
                            <input type="text" name="profesi" value="{{ old('profesi') }}" placeholder="Contoh: Guru, Kepala Sekolah, Pengawas, Mahasiswa, ASN..."
                                   class="w-full bg-white/90 border border-slate-200/90 rounded-2xl px-4 py-3 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all placeholder-slate-400">
                        </div>

                        <!-- SELECT 8 KATEGORI PERMOHONAN RESMI TERBARU -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                                Kategori Layanan <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="kategori" required
                                        class="w-full bg-white/90 border border-slate-200/90 rounded-2xl px-4 py-3 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all appearance-none cursor-pointer">
                                    <option value="" disabled {{ old('kategori') ? '' : 'selected' }}>-- Pilih Kategori Layanan --</option>
                                    <option value="Pelayanan Permohonan Informasi" {{ old('kategori') === 'Pelayanan Permohonan Informasi' ? 'selected' : '' }}>1. Pelayanan Permohonan Informasi</option>
                                    <option value="Pelayanan Peminjaman Fasilitas" {{ old('kategori') === 'Pelayanan Peminjaman Fasilitas' ? 'selected' : '' }}>2. Pelayanan Peminjaman Fasilitas</option>
                                    <option value="Pelayanan Data dan Informasi Mutu Pendidikan" {{ old('kategori') === 'Pelayanan Data dan Informasi Mutu Pendidikan' ? 'selected' : '' }}>3. Pelayanan Data dan Informasi Mutu Pendidikan</option>
                                    <option value="Pelayanan Supervisi Mutu Pendidikan" {{ old('kategori') === 'Pelayanan Supervisi Mutu Pendidikan' ? 'selected' : '' }}>4. Pelayanan Supervisi Mutu Pendidikan</option>
                                    <option value="Pelayanan Kerja sama Peningkatan Mutu" {{ old('kategori') === 'Pelayanan Kerja sama Peningkatan Mutu' ? 'selected' : '' }}>5. Pelayanan Kerja sama Peningkatan Mutu</option>
                                    <option value="Pelayanan Permohonan Narasumber" {{ old('kategori') === 'Pelayanan Permohonan Narasumber' ? 'selected' : '' }}>6. Pelayanan Permohonan Narasumber</option>
                                    <option value="Pelayanan Pengaduan" {{ old('kategori') === 'Pelayanan Pengaduan' ? 'selected' : '' }}>7. Pelayanan Pengaduan</option>
                                    <option value="Pelayanan Magang/Prakerin/Penelitian" {{ old('kategori') === 'Pelayanan Magang/Prakerin/Penelitian' ? 'selected' : '' }}>8. Pelayanan Magang/Prakerin/Penelitian</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Maksud / Uraian Keperluan Permohonan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                            Maksud &amp; Uraian Rincian Permohonan <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="keperluan" rows="4" required placeholder="Tuliskan secara jelas maksud permohonan, data yang diminta, tujuan penggunaan, atau kronologi pengaduan Anda..."
                                  class="w-full bg-white/90 border border-slate-200/90 rounded-2xl p-4 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all placeholder-slate-400">{{ old('keperluan') }}</textarea>
                    </div>

                    <!-- Upload Berkas Pendukung -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                            Unggah Berkas Pendukung (Surat Permohonan / KTP / Proposal) <span class="text-slate-400 font-normal lowercase">(opsional, maks 5MB)</span>
                        </label>
                        <div class="relative flex items-center justify-center w-full">
                            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-slate-300 hover:border-blue-500 rounded-3xl cursor-pointer bg-slate-50/50 hover:bg-blue-50/30 transition-all">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
                                    <svg class="w-8 h-8 mb-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <p class="text-xs text-slate-600 font-medium"><span class="font-bold text-blue-600">Klik untuk unggah dokumen</span> atau seret file ke area ini</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Format file yang didukung: PDF, DOCX, JPG, PNG (Maksimal 5 MB)</p>
                                </div>
                                <input type="file" name="dokumen" class="hidden" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-[11px] text-slate-500 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            <span>Data Anda dienkripsi secara aman dan dijaga kerahasiaannya oleh ULT BPMP Sultra.</span>
                        </div>
                        <button type="submit"
                                class="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-sm rounded-2xl shadow-xl shadow-blue-500/25 hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2 cursor-pointer">
                            <span>Kirim Permohonan &amp; Dapatkan Tiket</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- =============================================================== -->
        <!-- TAB 2: LAYANAN TATAP MUKA (TAHAP 3 - LOCK SCREEN PIN ULT2026)    -->
        <!-- =============================================================== -->
        <div x-show="activeTab === 'tatap-muka'"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="space-y-8">

            <!-- 1. MODE TERKUNCI (LOCK SCREEN OKSORISASI RESEPSIONIS) -->
            <div x-show="tatapMukaLocked"
                 class="bg-white/70 backdrop-blur-xl border border-white/80 shadow-xl shadow-blue-500/5 rounded-3xl p-8 sm:p-14 text-center max-w-xl mx-auto">
                <div class="w-20 h-20 rounded-full bg-emerald-100/80 text-emerald-600 flex items-center justify-center mx-auto mb-6 shadow-md shadow-emerald-500/10">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>

                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100/80 text-emerald-800 text-xs font-bold font-['Plus_Jakarta_Sans'] mb-3">
                    Terminal Resepsionis ULT Terkunci
                </div>

                <h3 class="text-2xl font-black text-slate-900 font-['Plus_Jakarta_Sans']">Buku Tamu Digital Meja Layanan</h3>
                <p class="text-xs sm:text-sm text-slate-600 mt-2 leading-relaxed">
                    Formulir buku tamu tatap muka ini dikhususkan bagi tamu yang hadir langsung di meja front office ULT BPMP Sultra. Masukkan kode otorisasi petugas untuk membuka terminal.
                </p>

                <div class="mt-8 max-w-sm mx-auto">
                    <form @submit.prevent="unlockTatapMuka" class="space-y-4">
                        <div class="relative">
                            <input type="password" x-model="tatapMukaPin" placeholder="Masukkan PIN Otorisasi..."
                                   class="w-full text-center tracking-widest font-mono text-base font-bold bg-white/90 border border-slate-200/90 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all text-slate-800 placeholder-slate-400">
                        </div>

                        <!-- Pesan Error PIN -->
                        <div x-show="tatapMukaError" style="display: none;" class="p-3 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Kode otorisasi tidak valid! Silakan periksa kembali.</span>
                        </div>

                        <button type="submit"
                                class="w-full py-3 px-6 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-2xl shadow-lg shadow-emerald-600/25 transition-all flex items-center justify-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                            <span>Buka Formulir Buku Tamu</span>
                        </button>
                    </form>
                    <span class="text-[11px] text-slate-400 block mt-3">Petunjuk: Kode otorisasi resmi resepsionis adalah <strong>ULT2026</strong></span>
                </div>
            </div>

            <!-- 2. MODE TERBUKA (FORMULIR BUKU TAMU NATIVE LARAVEL) -->
            <div x-show="!tatapMukaLocked" style="display: none;"
                 class="bg-white/70 backdrop-blur-xl border border-white/80 shadow-xl shadow-blue-500/5 rounded-3xl p-6 sm:p-10">
                <div class="border-b border-slate-200/70 pb-6 mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold font-['Plus_Jakarta_Sans'] mb-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                            Terminal Meja Front Office Terbuka
                        </div>
                        <h2 class="text-2xl font-black text-slate-900 font-['Plus_Jakarta_Sans']">Registrasi Buku Tamu Kunjungan Tatap Muka</h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">Silakan mengisi daftar kunjungan resmi sebelum menemui petugas atau unit kerja terkait.</p>
                    </div>

                    <!-- Tombol Kunci Kembali -->
                    <button type="button" @click="lockTatapMuka"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors shrink-0">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <span>Kunci Terminal</span>
                    </button>
                </div>

                <!-- Form Buku Tamu Tatap Muka Native -->
                <form action="{{ route('ult.tatapmuka.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Pengunjung -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                                Nama Pengunjung / Tamu <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Nama lengkap pengunjung..."
                                   class="w-full bg-white/90 border border-slate-200/90 rounded-2xl px-4 py-3 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all placeholder-slate-400">
                        </div>

                        <!-- No. HP / WhatsApp -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                                Nomor WhatsApp / HP <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" required placeholder="08xxxxxxxxxx..."
                                   class="w-full bg-white/90 border border-slate-200/90 rounded-2xl px-4 py-3 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all placeholder-slate-400">
                        </div>

                        <!-- Asal Instansi / Kabupaten / Kota -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                                Asal Instansi / Kabupaten / Kota <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="instansi" value="{{ old('instansi') }}" required placeholder="Contoh: Disdikbud Kota Kendari / SMPN 9 Baubau..."
                                   class="w-full bg-white/90 border border-slate-200/90 rounded-2xl px-4 py-3 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all placeholder-slate-400">
                        </div>

                        <!-- Profesi / Jabatan -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                                Profesi / Jabatan Tamu
                            </label>
                            <input type="text" name="profesi" value="{{ old('profesi') }}" placeholder="Contoh: Pengawas Sekolah, Guru, Dosen, Kepala Dinas..."
                                   class="w-full bg-white/90 border border-slate-200/90 rounded-2xl px-4 py-3 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all placeholder-slate-400">
                        </div>

                        <!-- Email Tamu (Opsional) -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                                Alamat Email Tamu <span class="text-slate-400 font-normal lowercase">(opsional)</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="tamu@instansi.go.id..."
                                   class="w-full bg-white/90 border border-slate-200/90 rounded-2xl px-4 py-3 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all placeholder-slate-400">
                        </div>

                        <!-- Tujuan Unit / Subbagian yang Ditemui -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                                Tujuan Unit Kerja / Petugas yang Ditemui <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="tujuan_kunjungan" required
                                        class="w-full bg-white/90 border border-slate-200/90 rounded-2xl px-4 py-3 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all appearance-none cursor-pointer">
                                    <option value="" disabled selected>-- Pilih Unit Kerja / Tujuan --</option>
                                    <option value="Front Office ULT (Konsultasi Layanan Umum)">Front Office ULT (Konsultasi Layanan Umum)</option>
                                    <option value="Subbagian Umum (Tata Usaha & Kepegawaian)">Subbagian Umum (Tata Usaha & Kepegawaian)</option>
                                    <option value="Subbagian Umum (Keuangan & BMN/Perlengkapan)">Subbagian Umum (Keuangan & BMN/Perlengkapan)</option>
                                    <option value="Tim Kerja 1 - Kemitraan & Transformasi Tata Kelola">Tim Kerja 1 - Kemitraan & Transformasi Tata Kelola</option>
                                    <option value="Tim Kerja 2 - Inovasi Mutu & Supervisi Pendidikan">Tim Kerja 2 - Inovasi Mutu & Supervisi Pendidikan</option>
                                    <option value="Kepala Balai / Pimpinan BPMP Sultra">Kepala Balai / Pimpinan BPMP Sultra</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Maksud dan Keperluan Kunjungan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                            Maksud dan Keperluan Kunjungan <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="keperluan" rows="3" required placeholder="Tuliskan tujuan dan agenda kunjungan Anda secara spesifik..."
                                  class="w-full bg-white/90 border border-slate-200/90 rounded-2xl p-4 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all placeholder-slate-400">{{ old('keperluan') }}</textarea>
                    </div>

                    <!-- Jumlah Rombongan -->
                    <div class="max-w-xs">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                            Jumlah Tamu / Rombongan (Orang)
                        </label>
                        <input type="number" name="jumlah_orang" value="1" min="1" max="100"
                               class="w-full bg-white/90 border border-slate-200/90 rounded-2xl px-4 py-2.5 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                    </div>

                    <div class="pt-4 flex items-center justify-end">
                        <button type="submit"
                                class="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold text-sm rounded-2xl shadow-xl shadow-emerald-600/25 transition-all flex items-center justify-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Simpan Kunjungan &amp; Cetak Antrean</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- =============================================================== -->
        <!-- TAB 3: LAYANAN KELILING (MOBILE SERVICE 17 KAB/KOTA)             -->
        <!-- =============================================================== -->
        <div x-show="activeTab === 'keliling'"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="space-y-8">

            <div class="bg-white/70 backdrop-blur-xl border border-white/80 shadow-xl shadow-blue-500/5 rounded-3xl p-6 sm:p-10">
                <div class="border-b border-slate-200/70 pb-6 mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold font-['Plus_Jakarta_Sans'] mb-2">
                            Layanan Bergerak (Mobile Service ULT)
                        </div>
                        <h2 class="text-2xl font-black text-slate-900 font-['Plus_Jakarta_Sans']">Permohonan Kunjungan ULT Keliling</h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">Fasilitasi layanan jemput bola langsung ke Dinas Pendidikan, MKKS, K3S, atau Gugus Sekolah di 17 Kabupaten/Kota se-Sulawesi Tenggara.</p>
                    </div>
                </div>

                <!-- Formulir Layanan Keliling -->
                <form action="{{ route('ult.keliling.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Penanggung Jawab -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                                Nama Penanggung Jawab / Pemohon <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Nama lengkap..."
                                   class="w-full bg-white/90 border border-slate-200/90 rounded-2xl px-4 py-3 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500/50 transition-all placeholder-slate-400">
                        </div>

                        <!-- Kontak WhatsApp -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                                Nomor WhatsApp / HP <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" required placeholder="08xxxxxxxxxx..."
                                   class="w-full bg-white/90 border border-slate-200/90 rounded-2xl px-4 py-3 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500/50 transition-all placeholder-slate-400">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                                Email Resmi Pemohon <span class="text-rose-500">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="dinas@kabupaten.go.id..."
                                   class="w-full bg-white/90 border border-slate-200/90 rounded-2xl px-4 py-3 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500/50 transition-all placeholder-slate-400">
                        </div>

                        <!-- Asal Instansi / Penyelenggara -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                                Instansi / Asosiasi Pemohon <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="instansi" value="{{ old('instansi') }}" required placeholder="Contoh: Dinas Pendidikan Kab. Kolaka / MKKS SMP Konawe..."
                                   class="w-full bg-white/90 border border-slate-200/90 rounded-2xl px-4 py-3 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500/50 transition-all placeholder-slate-400">
                        </div>

                        <!-- Kabupaten / Kota Sasaran -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                                Wilayah Kabupaten / Kota Sasaran <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="kabupaten_kota" value="{{ old('kabupaten_kota') }}" placeholder="Contoh: Buton, Muna, Wakatobi, Konawe Selatan..."
                                   class="w-full bg-white/90 border border-slate-200/90 rounded-2xl px-4 py-3 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500/50 transition-all placeholder-slate-400">
                        </div>

                        <!-- Tanggal Kegiatan Diusulkan -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                                Usulan Tanggal Pelaksanaan
                            </label>
                            <input type="date" name="tanggal_pelaksanaan" value="{{ old('tanggal_pelaksanaan') }}"
                                   class="w-full bg-white/90 border border-slate-200/90 rounded-2xl px-4 py-3 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500/50 transition-all">
                        </div>
                    </div>

                    <!-- Uraian Kebutuhan Layanan Mobile -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                            Deskripsi Layanan &amp; Kebutuhan Fasilitasi di Daerah
                        </label>
                        <textarea name="keperluan" rows="3" placeholder="Jelaskan kebutuhan fasilitasi (misal: Layanan Konsultasi Rapor Pendidikan, Verifikasi Data PTK, atau Pendampingan Akreditasi)..."
                                  class="w-full bg-white/90 border border-slate-200/90 rounded-2xl p-4 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500/50 transition-all placeholder-slate-400">{{ old('keperluan') }}</textarea>
                    </div>

                    <!-- Upload Surat Permohonan Resmi -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['Plus_Jakarta_Sans']">
                            Unggah Surat Permohonan Resmi dari Pimpinan Instansi <span class="text-slate-400 font-normal lowercase">(PDF / Maks 5MB)</span>
                        </label>
                        <input type="file" name="dokumen" accept=".pdf,.doc,.docx"
                               class="w-full bg-white/90 border border-slate-200/90 rounded-2xl px-4 py-2.5 text-xs text-slate-600 focus:outline-none focus:ring-2 focus:ring-amber-500/50">
                    </div>

                    <div class="pt-4 flex items-center justify-end">
                        <button type="submit"
                                class="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-bold text-sm rounded-2xl shadow-xl shadow-amber-600/25 transition-all flex items-center justify-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Kirim Pengajuan Layanan Keliling</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- =============================================================== -->
        <!-- TAB 4: SUSUNAN TIM RESMI ULT (TAHAP 4)                            -->
        <!-- =============================================================== -->
        <div x-show="activeTab === 'tim-ult'"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="space-y-10">

            <!-- Card Profil Koordinator ULT -->
            <div class="bg-white/70 backdrop-blur-xl border border-white/80 shadow-xl shadow-blue-500/5 rounded-3xl p-6 sm:p-10 relative overflow-hidden">
                <div class="absolute -right-16 -top-16 w-64 h-64 bg-indigo-100/50 rounded-full blur-3xl pointer-events-none"></div>

                <div class="flex flex-col md:flex-row items-center gap-8 relative z-10">
                    <div class="w-32 h-32 sm:w-40 sm:h-40 rounded-3xl bg-gradient-to-tr from-blue-600 to-indigo-600 p-1 shadow-xl shadow-blue-600/20 shrink-0">
                        <div class="w-full h-full rounded-[22px] bg-slate-100 flex items-center justify-center overflow-hidden">
                            <svg class="w-20 h-20 text-indigo-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                    </div>

                    <div class="text-center md:text-left flex-1">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-bold font-['Plus_Jakarta_Sans'] mb-2">
                            Koordinator Resmi ULT
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 font-['Plus_Jakarta_Sans']">Sitti Samsuria, S.E.</h2>
                        <p class="text-sm font-semibold text-blue-600 mt-0.5">Koordinator Unit Layanan Terpadu (ULT)</p>
                        <p class="text-xs sm:text-sm text-slate-600 mt-3 leading-relaxed">
                            Bertanggung jawab dalam memimpin operasionalisasi satu pintu, penjaminan standar mutu layanan, serta memastikan setiap aspirasi, permohonan informasi, dan kebutuhan pemangku kepentingan pendidikan terlayani secara adil, cepat, dan profesional.
                        </p>
                    </div>
                </div>
            </div>

            <!-- 4 BAGIAN / PETUGAS PELAYANAN -->
            <div>
                <div class="text-center max-w-xl mx-auto mb-8">
                    <h3 class="text-xl sm:text-2xl font-black text-slate-900 font-['Plus_Jakarta_Sans']">Bidang &amp; Petugas Pelayanan ULT</h3>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">Struktur pilar pelayanan terpadu BPMP Provinsi Sulawesi Tenggara</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <!-- 1. Pelayanan Permohonan Informasi & Pengaduan -->
                    <div class="bg-white/70 backdrop-blur-xl border border-white/80 shadow-md shadow-blue-500/5 rounded-3xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-blue-600 font-['Plus_Jakarta_Sans'] block mb-1">Bidang 01</span>
                        <h4 class="font-bold text-slate-900 text-base font-['Plus_Jakarta_Sans']">Pelayanan Informasi &amp; Pengaduan</h4>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Pemberian informasi publik, PPID, penanganan keluhan, saran, serta tindak lanjut pengaduan masyarakat secara akuntabel.
                        </p>
                    </div>

                    <!-- 2. Pelayanan Data & Mutu Pendidikan -->
                    <div class="bg-white/70 backdrop-blur-xl border border-white/80 shadow-md shadow-blue-500/5 rounded-3xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="w-12 h-12 rounded-2xl bg-cyan-100 text-cyan-600 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-cyan-600 font-['Plus_Jakarta_Sans'] block mb-1">Bidang 02</span>
                        <h4 class="font-bold text-slate-900 text-base font-['Plus_Jakarta_Sans']">Pelayanan Data &amp; Mutu Pendidikan</h4>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Fasilitasi data profil pendidikan, Rapor Pendidikan daerah/satuan pendidikan, verifikasi validasi Dapodik, dan statistik mutu.
                        </p>
                    </div>

                    <!-- 3. Pelayanan Fasilitas & Sarana Prasarana -->
                    <div class="bg-white/70 backdrop-blur-xl border border-white/80 shadow-md shadow-blue-500/5 rounded-3xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 font-['Plus_Jakarta_Sans'] block mb-1">Bidang 03</span>
                        <h4 class="font-bold text-slate-900 text-base font-['Plus_Jakarta_Sans']">Pelayanan Fasilitas &amp; Kerja Sama</h4>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Peminjaman aula serbaguna, laboratorium komputer, asrama diklat, dan administrasi kemitraan antarkelembagaan.
                        </p>
                    </div>

                    <!-- 4. Pelayanan Kemitraan & Supervisi Mutu -->
                    <div class="bg-white/70 backdrop-blur-xl border border-white/80 shadow-md shadow-blue-500/5 rounded-3xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 font-['Plus_Jakarta_Sans'] block mb-1">Bidang 04</span>
                        <h4 class="font-bold text-slate-900 text-base font-['Plus_Jakarta_Sans']">Pelayanan Kemitraan &amp; Supervisi</h4>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Permohonan narasumber ahli, pendampingan PBD, supervisi teknis kurikulum, dan fasilitasi magang/penelitian pendidikan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- MAKLUMAT PELAYANAN & JAM OPERASIONAL RESMI -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Maklumat Pelayanan -->
                <div class="md:col-span-2 bg-gradient-to-br from-blue-900 to-indigo-900 text-white rounded-3xl p-6 sm:p-8 shadow-xl relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-blue-500/20 rounded-full blur-2xl"></div>
                    <div class="relative z-10">
                        <span class="px-3 py-1 rounded-full bg-white/10 border border-white/20 text-[11px] font-bold uppercase tracking-wider">Maklumat Pelayanan</span>
                        <h4 class="text-xl font-black font-['Plus_Jakarta_Sans'] mt-3">Janji Standar Pelayanan ULT</h4>
                        <p class="text-xs sm:text-sm text-blue-100 mt-3 leading-relaxed italic font-serif">
                            &ldquo;Dengan ini kami pimpinan dan seluruh aparatur BPMP Provinsi Sulawesi Tenggara menyatakan sanggup menyelenggarakan pelayanan sesuai standar pelayanan yang telah ditetapkan, serta siap menerima sanksi sesuai ketentuan peraturan perundang-undangan yang berlaku apabila pelayanan yang diberikan tidak sesuai dengan janji layanan ini.&rdquo;
                        </p>
                        <div class="mt-4 pt-4 border-t border-white/10 flex items-center gap-3 text-xs text-blue-200">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            <span>Wilayah Bebas dari Korupsi (WBK) &amp; Wilayah Birokrasi Bersih dan Melayani (WBBM)</span>
                        </div>
                    </div>
                </div>

                <!-- Jam Operasional -->
                <div class="bg-white/70 backdrop-blur-xl border border-white/80 shadow-md shadow-blue-500/5 rounded-3xl p-6 sm:p-8 flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="font-bold text-slate-900 text-base font-['Plus_Jakarta_Sans']">Jam Operasional Pelayanan</h4>
                        <ul class="text-xs text-slate-600 mt-4 space-y-2.5">
                            <li class="flex items-center justify-between border-b border-slate-100 pb-2">
                                <span class="font-medium">Senin - Kamis</span>
                                <span class="font-bold text-slate-800">08.00 - 16.00 WITA</span>
                            </li>
                            <li class="flex items-center justify-between border-b border-slate-100 pb-2">
                                <span class="font-medium">Jumat</span>
                                <span class="font-bold text-slate-800">08.00 - 16.30 WITA</span>
                            </li>
                            <li class="flex items-center justify-between text-slate-400">
                                <span>Sabtu &amp; Minggu</span>
                                <span class="font-semibold text-rose-500">Tutup / Libur</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-4 p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-[11px] text-slate-500">
                        *Waktu Istirahat Siang: 12.00 - 13.00 WITA (Jumat 11.30 - 13.00 WITA)
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

