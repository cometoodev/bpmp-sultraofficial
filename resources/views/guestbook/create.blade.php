<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tamu ULT - BPMP Provinsi Sulawesi Tenggara</title>
    <link rel="icon" href="{{ asset('tutwurihandayani.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-display { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.85);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.60);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.75);
        }
        .glass-input {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.9);
            transition: all 0.2s ease-in-out;
        }
        .glass-input:focus {
            background: rgba(255, 255, 255, 1);
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.18);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-100 via-sky-50/60 to-blue-100/70 min-h-screen text-slate-800 antialiased selection:bg-blue-600 selection:text-white relative overflow-x-hidden">

    <!-- Ambient Glassmorphism Glow Orbs -->
    <div class="fixed inset-0 pointer-events-none -z-10 overflow-hidden">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-blue-400/25 rounded-full blur-3xl animate-pulse" style="animation-duration: 8s;"></div>
        <div class="absolute top-1/3 -right-32 w-96 h-96 bg-indigo-300/25 rounded-full blur-3xl animate-pulse" style="animation-duration: 10s;"></div>
        <div class="absolute -bottom-32 left-1/4 w-96 h-96 bg-sky-300/30 rounded-full blur-3xl"></div>
    </div>

    <!-- Header Navigation Bar -->
    <header class="w-full px-4 sm:px-8 pt-4 pb-2">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="/" class="inline-flex items-center gap-3 group">
                <img src="{{ asset('tutwurihandayani.png') }}" alt="Logo BPMP Sultra" class="h-11 w-11 drop-shadow-md group-hover:scale-105 transition-transform duration-200">
                <div>
                    <span class="block text-lg font-extrabold text-slate-900 tracking-tight font-display">
                        <span class="text-blue-600">BPMP</span> <span class="text-amber-500">SULTRA</span>
                    </span>
                    <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block -mt-0.5">
                        Unit Layanan Terpadu (ULT)
                    </span>
                </div>
            </a>
            <div class="flex items-center gap-2">
                <a href="/" class="px-3.5 py-1.5 text-xs font-semibold text-slate-600 hover:text-blue-600 hover:bg-white/60 rounded-xl transition-all border border-slate-200/60 glass-card inline-flex items-center gap-1.5 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span>Beranda</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="glass-panel rounded-3xl shadow-2xl shadow-blue-900/10 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-12">

                <!-- Left Column: Guestbook Form (7 cols on lg) -->
                <div class="lg:col-span-7 p-6 sm:p-10">
                    <div class="mb-8">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-200/60 text-blue-700 text-xs font-bold uppercase tracking-wider mb-3">
                            <span class="w-2 h-2 rounded-full bg-blue-600 animate-ping"></span>
                            Buku Tamu Digital ULT
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display tracking-tight">
                            Formulir Registrasi Kunjungan
                        </h1>
                        <p class="text-sm text-slate-600 mt-1.5 leading-relaxed">
                            Selamat datang di Unit Layanan Terpadu BPMP Provinsi Sulawesi Tenggara. Silakan lengkapi data kunjungan Anda di bawah ini.
                        </p>
                    </div>

                    @if($errors->any())
                        <div class="mb-6 p-4 rounded-2xl bg-rose-50/90 border border-rose-200 text-rose-800 text-sm shadow-sm">
                            <div class="flex items-center gap-2 font-bold mb-1 text-rose-900">
                                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <span>Mohon periksa kembali isian formulir:</span>
                            </div>
                            <ul class="list-disc list-inside text-xs space-y-0.5 text-rose-700 pl-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('guestbook.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <!-- Row 1: Nama Lengkap -->
                        <div>
                            <label for="nama" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Nama Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
                                       class="glass-input w-full pl-10 pr-4 py-2.5 rounded-xl text-sm text-slate-800 placeholder-slate-400"
                                       placeholder="Contoh: Dr. La Ode Muhammad Rizal, M.Pd">
                            </div>
                        </div>

                        <!-- Row 2: Jenis Kelamin & Usia -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                    Jenis Kelamin <span class="text-rose-500">*</span>
                                </label>
                                <div class="grid grid-cols-2 gap-2">
                                    <label class="flex items-center justify-center gap-2 p-2.5 rounded-xl glass-input cursor-pointer hover:bg-white text-sm font-medium text-slate-700">
                                        <input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin') === 'L' ? 'checked' : '' }} required class="text-blue-600 focus:ring-blue-500">
                                        <span>Laki-laki</span>
                                    </label>
                                    <label class="flex items-center justify-center gap-2 p-2.5 rounded-xl glass-input cursor-pointer hover:bg-white text-sm font-medium text-slate-700">
                                        <input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin') === 'P' ? 'checked' : '' }} required class="text-blue-600 focus:ring-blue-500">
                                        <span>Perempuan</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label for="usia" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                    Usia (Tahun) <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <input type="number" id="usia" name="usia" min="1" max="120" value="{{ old('usia') }}" required
                                           class="glass-input w-full pl-10 pr-4 py-2.5 rounded-xl text-sm text-slate-800 placeholder-slate-400"
                                           placeholder="Contoh: 35">
                                </div>
                            </div>
                        </div>

                        <!-- Row 3: Nomor Telepon / WA -->
                        <div>
                            <label for="telepon" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Nomor Telepon / WhatsApp <span class="text-slate-400 font-normal">(Opsional)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <input type="tel" id="telepon" name="telepon" value="{{ old('telepon') }}"
                                       class="glass-input w-full pl-10 pr-4 py-2.5 rounded-xl text-sm text-slate-800 placeholder-slate-400"
                                       placeholder="Contoh: 081234567890">
                            </div>
                        </div>

                        <!-- Row 4: Pendidikan Terakhir & Status Kepegawaian -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="pendidikan" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                    Pendidikan Terakhir <span class="text-rose-500">*</span>
                                </label>
                                <select id="pendidikan" name="pendidikan" required class="glass-input w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-800">
                                    <option value="" disabled {{ old('pendidikan') ? '' : 'selected' }}>Pilih Pendidikan...</option>
                                    <option value="SD / Sederajat" {{ old('pendidikan') === 'SD / Sederajat' ? 'selected' : '' }}>SD / Sederajat</option>
                                    <option value="SMP / Sederajat" {{ old('pendidikan') === 'SMP / Sederajat' ? 'selected' : '' }}>SMP / Sederajat</option>
                                    <option value="SMA / SMK / Sederajat" {{ old('pendidikan') === 'SMA / SMK / Sederajat' ? 'selected' : '' }}>SMA / SMK / Sederajat</option>
                                    <option value="Diploma (D1 - D3)" {{ old('pendidikan') === 'Diploma (D1 - D3)' ? 'selected' : '' }}>Diploma (D1 - D3)</option>
                                    <option value="Sarjana (S1 / D4)" {{ old('pendidikan') === 'Sarjana (S1 / D4)' ? 'selected' : '' }}>Sarjana (S1 / D4)</option>
                                    <option value="Magister (S2)" {{ old('pendidikan') === 'Magister (S2)' ? 'selected' : '' }}>Magister (S2)</option>
                                    <option value="Doktoral (S3)" {{ old('pendidikan') === 'Doktoral (S3)' ? 'selected' : '' }}>Doktoral (S3)</option>
                                </select>
                            </div>
                            <div>
                                <label for="status_kepegawaian" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                    Status Kepegawaian <span class="text-rose-500">*</span>
                                </label>
                                <select id="status_kepegawaian" name="status_kepegawaian" required class="glass-input w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-800">
                                    <option value="" disabled {{ old('status_kepegawaian') ? '' : 'selected' }}>Pilih Status...</option>
                                    <option value="PNS" {{ old('status_kepegawaian') === 'PNS' ? 'selected' : '' }}>PNS (Pegawai Negeri Sipil)</option>
                                    <option value="PPPK" {{ old('status_kepegawaian') === 'PPPK' ? 'selected' : '' }}>PPPK</option>
                                    <option value="Non-ASN / Honorer" {{ old('status_kepegawaian') === 'Non-ASN / Honorer' ? 'selected' : '' }}>Non-ASN / Honorer</option>
                                    <option value="Pegawai Swasta / Yayasan" {{ old('status_kepegawaian') === 'Pegawai Swasta / Yayasan' ? 'selected' : '' }}>Pegawai Swasta / Yayasan</option>
                                    <option value="Masyarakat Umum" {{ old('status_kepegawaian') === 'Masyarakat Umum' ? 'selected' : '' }}>Masyarakat Umum / Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <!-- Row 5: Pekerjaan -->
                        <div>
                            <label for="pekerjaan" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Pekerjaan / Profesi <span class="text-rose-500">*</span>
                            </label>
                            <select id="pekerjaan" name="pekerjaan" required class="glass-input w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-800">
                                <option value="" disabled {{ old('pekerjaan') ? '' : 'selected' }}>Pilih Pekerjaan...</option>
                                <option value="Guru / Pendidik" {{ old('pekerjaan') === 'Guru / Pendidik' ? 'selected' : '' }}>Guru / Pendidik</option>
                                <option value="Kepala Sekolah" {{ old('pekerjaan') === 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                                <option value="Pengawas Sekolah" {{ old('pekerjaan') === 'Pengawas Sekolah' ? 'selected' : '' }}>Pengawas Sekolah</option>
                                <option value="Operator Sekolah / Dapodik" {{ old('pekerjaan') === 'Operator Sekolah / Dapodik' ? 'selected' : '' }}>Operator Sekolah / Dapodik</option>
                                <option value="Pejabat / Staf Dinas Pendidikan" {{ old('pekerjaan') === 'Pejabat / Staf Dinas Pendidikan' ? 'selected' : '' }}>Pejabat / Staf Dinas Pendidikan</option>
                                <option value="Aparatur Sipil Negara (ASN)" {{ old('pekerjaan') === 'Aparatur Sipil Negara (ASN)' ? 'selected' : '' }}>Aparatur Sipil Negara (ASN)</option>
                                <option value="Dosen / Akademisi" {{ old('pekerjaan') === 'Dosen / Akademisi' ? 'selected' : '' }}>Dosen / Akademisi</option>
                                <option value="Mahasiswa / Pelajar" {{ old('pekerjaan') === 'Mahasiswa / Pelajar' ? 'selected' : '' }}>Mahasiswa / Pelajar</option>
                                <option value="Pegawai Swasta" {{ old('pekerjaan') === 'Pegawai Swasta' ? 'selected' : '' }}>Pegawai Swasta</option>
                                <option value="Wiraswasta / Usaha" {{ old('pekerjaan') === 'Wiraswasta / Usaha' ? 'selected' : '' }}>Wiraswasta / Usaha</option>
                                <option value="Lainnya" {{ old('pekerjaan') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>

                        <!-- Row 6: Asal Instansi & Asal Kabupaten/Kota -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="asal_instansi" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                    Asal Instansi / Sekolah <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" id="asal_instansi" name="asal_instansi" value="{{ old('asal_instansi') }}" required
                                       class="glass-input w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-800 placeholder-slate-400"
                                       placeholder="Contoh: SMAN 1 Kendari / Disdikbud Kota">
                            </div>
                            <div>
                                <label for="asal_kabupaten" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                    Asal Kabupaten / Kota <span class="text-rose-500">*</span>
                                </label>
                                <select id="asal_kabupaten" name="asal_kabupaten" required class="glass-input w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-800">
                                    <option value="" disabled {{ old('asal_kabupaten') ? '' : 'selected' }}>Pilih Kab / Kota...</option>
                                    <option value="Kota Kendari" {{ old('asal_kabupaten') === 'Kota Kendari' ? 'selected' : '' }}>Kota Kendari</option>
                                    <option value="Kota Baubau" {{ old('asal_kabupaten') === 'Kota Baubau' ? 'selected' : '' }}>Kota Baubau</option>
                                    <option value="Kab. Konawe" {{ old('asal_kabupaten') === 'Kab. Konawe' ? 'selected' : '' }}>Kab. Konawe</option>
                                    <option value="Kab. Konawe Selatan" {{ old('asal_kabupaten') === 'Kab. Konawe Selatan' ? 'selected' : '' }}>Kab. Konawe Selatan</option>
                                    <option value="Kab. Konawe Utara" {{ old('asal_kabupaten') === 'Kab. Konawe Utara' ? 'selected' : '' }}>Kab. Konawe Utara</option>
                                    <option value="Kab. Konawe Kepulauan" {{ old('asal_kabupaten') === 'Kab. Konawe Kepulauan' ? 'selected' : '' }}>Kab. Konawe Kepulauan</option>
                                    <option value="Kab. Kolaka" {{ old('asal_kabupaten') === 'Kab. Kolaka' ? 'selected' : '' }}>Kab. Kolaka</option>
                                    <option value="Kab. Kolaka Utara" {{ old('asal_kabupaten') === 'Kab. Kolaka Utara' ? 'selected' : '' }}>Kab. Kolaka Utara</option>
                                    <option value="Kab. Kolaka Timur" {{ old('asal_kabupaten') === 'Kab. Kolaka Timur' ? 'selected' : '' }}>Kab. Kolaka Timur</option>
                                    <option value="Kab. Muna" {{ old('asal_kabupaten') === 'Kab. Muna' ? 'selected' : '' }}>Kab. Muna</option>
                                    <option value="Kab. Muna Barat" {{ old('asal_kabupaten') === 'Kab. Muna Barat' ? 'selected' : '' }}>Kab. Muna Barat</option>
                                    <option value="Kab. Buton" {{ old('asal_kabupaten') === 'Kab. Buton' ? 'selected' : '' }}>Kab. Buton</option>
                                    <option value="Kab. Buton Utara" {{ old('asal_kabupaten') === 'Kab. Buton Utara' ? 'selected' : '' }}>Kab. Buton Utara</option>
                                    <option value="Kab. Buton Selatan" {{ old('asal_kabupaten') === 'Kab. Buton Selatan' ? 'selected' : '' }}>Kab. Buton Selatan</option>
                                    <option value="Kab. Buton Tengah" {{ old('asal_kabupaten') === 'Kab. Buton Tengah' ? 'selected' : '' }}>Kab. Buton Tengah</option>
                                    <option value="Kab. Bombana" {{ old('asal_kabupaten') === 'Kab. Bombana' ? 'selected' : '' }}>Kab. Bombana</option>
                                    <option value="Kab. Wakatobi" {{ old('asal_kabupaten') === 'Kab. Wakatobi' ? 'selected' : '' }}>Kab. Wakatobi</option>
                                    <option value="Luar Sulawesi Tenggara" {{ old('asal_kabupaten') === 'Luar Sulawesi Tenggara' ? 'selected' : '' }}>Luar Sulawesi Tenggara</option>
                                </select>
                            </div>
                        </div>

                        <!-- Row 7: Jenis Layanan -->
                        <div>
                            <label for="jenis_layanan" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Jenis Layanan yang Dibutuhkan <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                                <input type="text" id="jenis_layanan" name="jenis_layanan" list="layanan_list" value="{{ old('jenis_layanan') }}" required
                                       class="glass-input w-full pl-10 pr-4 py-2.5 rounded-xl text-sm text-slate-800 placeholder-slate-400"
                                       placeholder="Ketik atau pilih layanan...">
                                <datalist id="layanan_list">
                                    <option value="Konsultasi & Advokasi Program Prioritas Kemendikdasmen">
                                    <option value="Layanan Data Pokok Pendidikan (Dapodik) & PDM">
                                    <option value="Penjaminan Mutu & Rekomendasi Rapor Pendidikan">
                                    <option value="Penerbitan Rekomendasi / Keterangan Dinas">
                                    <option value="Pemanfaatan Sarana, Prasarana & Fasilitas Diklat">
                                    <option value="Informasi Publik & Penanganan Pengaduan Layanan">
                                    <option value="Koordinasi / Audiensi Kedinasan">
                                </datalist>
                            </div>
                        </div>

                        <!-- Submit Button: Warna Biru Sesuai Permintaan -->
                        <div class="pt-4">
                            <button type="submit"
                                    class="w-full py-3.5 px-6 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 hover:from-blue-700 hover:via-blue-800 hover:to-indigo-800 text-white font-extrabold text-base shadow-xl shadow-blue-600/30 hover:shadow-blue-600/40 transform hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-3 font-display">
                                <svg class="w-5 h-5 text-sky-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Check-In Sekarang</span>
                            </button>
                        </div>

                        <p class="text-center text-[11px] text-slate-500 pt-1">
                            Dengan melakukan check-in, data Anda terekam dalam sistem pelayanan publik resmi BPMP Sulawesi Tenggara.
                        </p>
                    </form>
                </div>

                <!-- Right Column: Welcome Banner & Live Statistics (5 cols on lg) -->
                <div class="lg:col-span-5 bg-gradient-to-br from-blue-700 via-indigo-800 to-slate-900 p-8 sm:p-10 text-white flex flex-col justify-between relative overflow-hidden">
                    <!-- Background Glow Elements inside Banner -->
                    <div class="absolute -top-20 -right-20 w-64 h-64 bg-sky-400/20 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

                    <!-- Top Banner Content -->
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-md p-2 border border-white/20 flex items-center justify-center shadow-lg">
                                <img src="{{ asset('tutwurihandayani.png') }}" alt="Logo Tut Wuri Handayani" class="h-10 w-10 drop-shadow">
                            </div>
                            <div>
                                <span class="text-xs font-semibold uppercase tracking-widest text-sky-300 block">KEMENDIKDASMEN</span>
                                <h2 class="text-lg font-extrabold leading-tight tracking-tight font-display text-white">BPMP SULTRA</h2>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-xl sm:text-2xl font-bold font-display text-white leading-snug">
                                Selamat Datang di Unit Layanan Terpadu (ULT)
                            </h3>
                            <p class="text-xs sm:text-sm text-sky-100/80 mt-2 leading-relaxed">
                                Balai Penjaminan Mutu Pendidikan Provinsi Sulawesi Tenggara berkomitmen memberikan pelayanan prima, transparan, dan akuntabel kepada seluruh pemangku kepentingan pendidikan.
                            </p>
                        </div>

                        <!-- Maklumat Layanan / Nilai Inti -->
                        <div class="space-y-3">
                            <div class="p-3.5 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 flex items-start gap-3">
                                <div class="w-8 h-8 rounded-xl bg-blue-500/30 flex items-center justify-center shrink-0 text-sky-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-white uppercase tracking-wider font-display">Layanan Cepat & Pasti</h4>
                                    <p class="text-[11px] text-sky-100/70 mt-0.5">Prosedur sederhana dengan kepastian waktu penyelesaian layanan.</p>
                                </div>
                            </div>

                            <div class="p-3.5 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 flex items-start gap-3">
                                <div class="w-8 h-8 rounded-xl bg-emerald-500/30 flex items-center justify-center shrink-0 text-emerald-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-white uppercase tracking-wider font-display">Bebas Biaya / 0 Rupiah</h4>
                                    <p class="text-[11px] text-sky-100/70 mt-0.5">Seluruh layanan ULT tidak dipungut biaya apapun (Gratis tanpa pungli).</p>
                                </div>
                            </div>

                            <div class="p-3.5 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 flex items-start gap-3">
                                <div class="w-8 h-8 rounded-xl bg-amber-500/30 flex items-center justify-center shrink-0 text-amber-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-white uppercase tracking-wider font-display">Ramah & Profesional</h4>
                                    <p class="text-[11px] text-sky-100/70 mt-0.5">Petugas kompeten siap mendampingi kebutuhan konsultasi Anda.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Banner Footer: Jam Layanan & Lokasi -->
                    <div class="relative z-10 pt-8 mt-6 border-t border-white/15 text-xs text-sky-200/80 space-y-2">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-sky-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Gedung ULT BPMP Sultra, Kendari, Sulawesi Tenggara</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-sky-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Senin - Jumat | 08.00 - 16.00 WITA</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Footer Copyright -->
    <footer class="max-w-7xl mx-auto px-4 text-center py-6 text-xs text-slate-500">
        &copy; {{ date('Y') }} Balai Penjaminan Mutu Pendidikan (BPMP) Provinsi Sulawesi Tenggara.
    </footer>

</body>
</html>
