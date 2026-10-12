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

    @if($errors->any())
        <div class="bg-red-50 text-red-700 p-4 rounded-xl text-sm font-medium border border-red-100 flex flex-col gap-1.5">
            <div class="flex items-center gap-2 font-bold text-red-800">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span>Terjadi kesalahan saat menyimpan pengaturan:</span>
            </div>
            <ul class="list-disc list-inside text-xs space-y-1 pl-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-base font-bold text-slate-800">Pengaturan Informasi Website</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola data dasar yang ditampilkan pada website publik.</p>
        </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
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

            <!-- Profil Pimpinan BPMP Sultra -->
            <div class="space-y-6 pt-4 border-t border-slate-100">
                <div class="border-b border-slate-100 pb-2">
                    <h3 class="font-bold text-slate-800">Profil Pimpinan & Komitmen</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Kelola foto pimpinan resmi, nama, jabatan, dan kutipan komitmen yang tampil di halaman beranda.</p>
                </div>

                <!-- Header Section Beranda -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-slate-50/70 p-4 rounded-xl border border-slate-200/80">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Judul Bagian Pimpinan</label>
                        <input type="text" name="leader_section_title" value="{{ $settings['leader_section_title'] ?? 'Profil Pimpinan' }}" class="w-full bg-white border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-2.5">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Subjudul / Deskripsi Bagian</label>
                        <input type="text" name="leader_section_subtitle" value="{{ $settings['leader_section_subtitle'] ?? 'Mengenal jajaran kepemimpinan yang berdedikasi mengawal penjaminan dan peningkatan mutu pendidikan di Sulawesi Tenggara.' }}" class="w-full bg-white border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-2.5">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Pimpinan 1 (Kepala Balai) -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-4"
                         x-data="{ 
                             preview1: '{{ !empty($settings['leader_1_photo']) ? (\Illuminate\Support\Str::startsWith($settings['leader_1_photo'], 'http') ? $settings['leader_1_photo'] : asset('storage/' . ltrim($settings['leader_1_photo'], '/'))) : 'https://ui-avatars.com/api/?name=' . urlencode($settings['leader_1_name'] ?? 'Junaiddin Pagala') . '&background=1e3a8a&color=fff&size=200' }}' 
                         }">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-2.5 py-1 rounded-md">Pimpinan 1 (Kepala Balai)</span>
                        </div>

                        <!-- Foto Pimpinan 1 -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-700">Foto Resmi</label>
                            <div class="flex items-start gap-4">
                                <div class="w-20 h-24 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center shrink-0 shadow-xs">
                                    <img :src="preview1" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 space-y-2">
                                    <div>
                                        <input type="file" name="leader_1_photo" accept="image/*,.avif" 
                                            @change="const f = $event.target.files[0]; if(f) { const r = new FileReader(); r.onload = (e) => preview1 = e.target.result; r.readAsDataURL(f); }"
                                            class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                        <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, WebP, AVIF. Maks 10MB. Rasio vertikal (3:4).</p>
                                    </div>

                                    @if(isset($mediaPhotos) && $mediaPhotos->isNotEmpty())
                                        <div class="pt-1">
                                            <label class="block text-[11px] font-semibold text-slate-500 mb-1">Atau pilih dari Media Library:</label>
                                            <select name="leader_1_media_choice" 
                                                @change="if($event.target.value) { preview1 = '{{ asset('storage') }}/' + $event.target.value; }"
                                                class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-xs rounded-lg p-2 focus:ring-1 focus:ring-blue-500">
                                                <option value="">-- Pilih dari file Media yang sudah diunggah --</option>
                                                @foreach($mediaPhotos as $photo)
                                                    <option value="{{ $photo->path }}" {{ ($settings['leader_1_photo'] ?? '') == $photo->path ? 'selected' : '' }}>
                                                        {{ $photo->filename }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                    @error('leader_1_photo')
                                        <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
                                    @enderror

                                    @if(!empty($settings['leader_1_photo']))
                                        <label class="inline-flex items-center gap-1.5 text-xs text-red-600 cursor-pointer pt-1">
                                            <input type="checkbox" name="remove_leader_1_photo" value="1" class="rounded text-red-600">
                                            <span>Hapus foto khusus (kembali ke avatar)</span>
                                        </label>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Nama Lengkap & Gelar</label>
                            <input type="text" name="leader_1_name" value="{{ $settings['leader_1_name'] ?? 'Junaiddin Pagala, S.T., M.T.' }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-2.5">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Jabatan Resmi</label>
                            <input type="text" name="leader_1_position" value="{{ $settings['leader_1_position'] ?? 'KEPALA BPMP PROVINSI SULAWESI TENGGARA' }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-2.5">
                        </div>
                    </div>

                    <!-- Pimpinan 2 (Kasubbag Umum) -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-4"
                         x-data="{ 
                             preview2: '{{ !empty($settings['leader_2_photo']) ? (\Illuminate\Support\Str::startsWith($settings['leader_2_photo'], 'http') ? $settings['leader_2_photo'] : asset('storage/' . ltrim($settings['leader_2_photo'], '/'))) : 'https://ui-avatars.com/api/?name=' . urlencode($settings['leader_2_name'] ?? 'Rika Ernita') . '&background=1e3a8a&color=fff&size=200' }}' 
                         }">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-2.5 py-1 rounded-md">Pimpinan 2 (Kasubbag Umum)</span>
                        </div>

                        <!-- Foto Pimpinan 2 -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-700">Foto Resmi</label>
                            <div class="flex items-start gap-4">
                                <div class="w-20 h-24 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center shrink-0 shadow-xs">
                                    <img :src="preview2" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 space-y-2">
                                    <div>
                                        <input type="file" name="leader_2_photo" accept="image/*,.avif" 
                                            @change="const f = $event.target.files[0]; if(f) { const r = new FileReader(); r.onload = (e) => preview2 = e.target.result; r.readAsDataURL(f); }"
                                            class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                        <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, WebP, AVIF. Maks 10MB. Rasio vertikal (3:4).</p>
                                    </div>

                                    @if(isset($mediaPhotos) && $mediaPhotos->isNotEmpty())
                                        <div class="pt-1">
                                            <label class="block text-[11px] font-semibold text-slate-500 mb-1">Atau pilih dari Media Library:</label>
                                            <select name="leader_2_media_choice" 
                                                @change="if($event.target.value) { preview2 = '{{ asset('storage') }}/' + $event.target.value; }"
                                                class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-xs rounded-lg p-2 focus:ring-1 focus:ring-blue-500">
                                                <option value="">-- Pilih dari file Media yang sudah diunggah --</option>
                                                @foreach($mediaPhotos as $photo)
                                                    <option value="{{ $photo->path }}" {{ ($settings['leader_2_photo'] ?? '') == $photo->path ? 'selected' : '' }}>
                                                        {{ $photo->filename }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                    @error('leader_2_photo')
                                        <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
                                    @enderror

                                    @if(!empty($settings['leader_2_photo']))
                                        <label class="inline-flex items-center gap-1.5 text-xs text-red-600 cursor-pointer pt-1">
                                            <input type="checkbox" name="remove_leader_2_photo" value="1" class="rounded text-red-600">
                                            <span>Hapus foto khusus (kembali ke avatar)</span>
                                        </label>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Nama Lengkap & Gelar</label>
                            <input type="text" name="leader_2_name" value="{{ $settings['leader_2_name'] ?? 'Rika Ernita Mekuo, S.Si., M.Si.' }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-2.5">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Jabatan Resmi</label>
                            <input type="text" name="leader_2_position" value="{{ $settings['leader_2_position'] ?? 'KASUBBAG UMUM BPMP SULTRA' }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-2.5">
                        </div>
                    </div>
                </div>

                <!-- Kutipan Komitmen Pimpinan (The Quote Box) -->
                <div class="bg-slate-50/70 p-5 rounded-2xl border border-slate-200 space-y-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-700 block">Pesan / Kutipan Komitmen Pimpinan (Quote Box)</span>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Isi Kutipan Komitmen</label>
                        <textarea name="leader_quote" rows="3" class="w-full bg-white border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">{{ $settings['leader_quote'] ?? 'Berkomitmen penuh mewujudkan Zona Integritas Wilayah Bebas dari Korupsi (ZI WBK) dan Pelayanan Prima bagi seluruh insan pendidikan serta mendukung tata kelola organisasi yang transparan dan akuntabel.' }}</textarea>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Label Pengutip (Bawah Kutipan)</label>
                        <input type="text" name="leader_quote_author" value="{{ $settings['leader_quote_author'] ?? 'Pimpinan BPMP Provinsi Sulawesi Tenggara' }}" class="w-full bg-white border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-2.5">
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
