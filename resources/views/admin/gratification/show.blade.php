@extends('layouts.admin')

@section('title', 'Detail Laporan Gratifikasi #' . $report->id)
@section('header_title', 'Detail Laporan Gratifikasi')
@section('header_subtitle', 'Rincian data 3 tahap instrumen pengendalian gratifikasi pegawai')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- TOP BAR / ACTION -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <a href="{{ route('admin.gratification.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Rekapitulasi
        </a>

        <!-- Status Form -->
        <form action="{{ route('admin.gratification.status', $report->id) }}" method="POST" class="flex items-center gap-2">
            @csrf
            @method('PATCH')
            <label class="text-xs font-bold text-slate-500">Status UPG:</label>
            <select name="status" onchange="this.form.submit()" class="bg-white border border-slate-200 text-xs font-bold rounded-xl px-3 py-2 outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>⏳ Menunggu Verifikasi</option>
                <option value="verified" {{ $report->status === 'verified' ? 'selected' : '' }}>⚡ Terverifikasi UPG</option>
                <option value="recorded" {{ $report->status === 'recorded' ? 'selected' : '' }}>✅ Telah Tercatat di Register</option>
            </select>
        </form>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-semibold flex items-center gap-2 shadow-xs">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- MAIN CARD -->
    <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] p-6 sm:p-10 border border-white/80 shadow-md relative overflow-hidden">
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 space-y-8">

            <!-- HEADER INFO -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-100 gap-4">
                <div>
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-indigo-50 text-indigo-600 border border-indigo-100">
                            Laporan #{{ $report->id }}
                        </span>
                        @if($report->status === 'recorded')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Tercatat di Register UPG
                            </span>
                        @elseif($report->status === 'verified')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                Terverifikasi
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                Menunggu Verifikasi
                            </span>
                        @endif
                    </div>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-800 mt-2">{{ $report->name }}</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Dilaporkan pada: {{ $report->created_at->translatedFormat('l, d F Y - H:i') }} WITA</p>
                </div>

                <div class="flex items-center gap-2">
                    <a href="mailto:{{ $report->email }}" class="px-4 py-2.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold flex items-center gap-2 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>Kirim Email Pegawai</span>
                    </a>
                </div>
            </div>

            <!-- 3 TAHAPAN FORMULIR GRID -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- TAHAP 1: IDENTITAS & KEGIATAN -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                        <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">1</div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Data & Kegiatan</h3>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-3 text-xs">
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400">Nama Lengkap</span>
                            <span class="block font-bold text-slate-800 text-sm">{{ $report->name }}</span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400">NIP</span>
                            <span class="block font-mono text-slate-700">{{ $report->nip && $report->nip !== '0' ? $report->nip : '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400">Email</span>
                            <span class="block text-slate-700">{{ $report->email }}</span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400">Jabatan</span>
                            <span class="block font-semibold text-slate-800">{{ $report->position }}</span>
                        </div>
                        <div class="pt-2 border-t border-slate-200/60">
                            <span class="block text-[11px] font-semibold text-slate-400">Nama Kegiatan</span>
                            <span class="block font-bold text-slate-800 leading-snug mt-0.5">{{ $report->activity_name }}</span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400">Tanggal Kegiatan</span>
                            <span class="block text-slate-700">{{ $report->activity_date ? $report->activity_date->translatedFormat('d F Y') : '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400">Lokasi Kegiatan</span>
                            <span class="block text-slate-700">📍 {{ $report->activity_location }}</span>
                        </div>
                    </div>
                </div>

                <!-- TAHAP 2: LAYANAN / FASILITAS BEBAS BIAYA -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                        <div class="w-7 h-7 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs">2</div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Layanan Gratis</h3>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-3 text-xs">
                        @php
                            $services = $report->free_services_array;
                        @endphp
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400 mb-1.5">Fasilitas Bebas Biaya Diterima:</span>
                            @if(empty($services) || in_array('tidak menerima', array_map('strtolower', $services)))
                                <span class="inline-block px-3 py-1 rounded-lg text-xs font-medium bg-white text-slate-500 border border-slate-200">
                                    Tidak menerima layanan gratis
                                </span>
                            @else
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($services as $s)
                                        <span class="inline-block px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                            ✓ {{ $s }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="pt-2 border-t border-slate-200/60">
                            <span class="block text-[11px] font-semibold text-slate-400">Tanggal Pelayanan</span>
                            <span class="block text-slate-700">{{ $report->service_date ? $report->service_date->translatedFormat('d F Y') : '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400">Nama Penyedia Layanan</span>
                            <span class="block text-slate-800 font-semibold">{{ $report->service_provider_name && $report->service_provider_name !== '0' ? $report->service_provider_name : '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400">Jabatan Penyedia Layanan</span>
                            <span class="block text-slate-700">{{ $report->service_provider_position && $report->service_provider_position !== '0' ? $report->service_provider_position : '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- TAHAP 3: OLE-OLE / BINGKISAN & TINDAK LANJUT -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xs">3</div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Ole-ole & Tindak Lanjut</h3>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-3 text-xs">
                        @php
                            $gifts = $report->gift_consumable_types_array;
                        @endphp
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400 mb-1.5">Jenis Makanan / Habis Pakai:</span>
                            @if(empty($gifts) || in_array('tidak menerima', array_map('strtolower', $gifts)))
                                <span class="inline-block px-3 py-1 rounded-lg text-xs font-medium bg-white text-slate-500 border border-slate-200">
                                    Tidak menerima ole-ole
                                </span>
                            @else
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($gifts as $g)
                                        @if(strtolower($g) !== 'tidak menerima')
                                            <span class="inline-block px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                🎁 {{ $g }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400">Barang Tidak Habis Pakai</span>
                            <span class="block text-slate-700">{{ $report->gift_non_consumable_desc ?: 'Tidak menerima' }}</span>
                        </div>
                        <div class="pt-2 border-t border-slate-200/60">
                            <span class="block text-[11px] font-semibold text-slate-400">Pemberi Ole-Ole</span>
                            <span class="block font-semibold text-slate-800">{{ $report->gift_giver_name ?: '-' }}</span>
                            @if($report->gift_giver_position)
                                <span class="block text-[11px] text-slate-500">{{ $report->gift_giver_position }}</span>
                            @endif
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400">Tanggal Menerima</span>
                            <span class="block text-slate-700">{{ $report->gift_received_date ? $report->gift_received_date->translatedFormat('d F Y') : '-' }}</span>
                        </div>
                        <div class="p-3 rounded-xl bg-amber-50 border border-amber-200">
                            <span class="block text-[11px] font-bold text-amber-800 uppercase tracking-wider">Tindak Lanjut Penerimaan:</span>
                            <span class="block text-xs font-extrabold text-amber-900 mt-0.5">{{ $report->follow_up_action ?: '-' }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- BUKTI DOKUMENTASI LAMPIRAN -->
            <div class="pt-6 border-t border-slate-100 space-y-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Bukti Dokumentasi (Foto Barang / Bill / Tiket)</h3>
                
                @if($report->evidence_file)
                    @php
                        $ext = strtolower(pathinfo($report->evidence_file, PATHINFO_EXTENSION));
                        $url = Storage::disk('public')->url($report->evidence_file);
                    @endphp

                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 max-w-2xl">
                        @if(in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
                            <div class="space-y-3">
                                <div class="rounded-xl overflow-hidden max-h-96 border border-slate-200">
                                    <img src="{{ $url }}" alt="Bukti Dokumentasi" class="w-full object-contain max-h-96 bg-black/5">
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-slate-500 font-medium">Format: {{ strtoupper($ext) }}</span>
                                    <a href="{{ $url }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                                        <span>Buka Foto Ukuran Penuh</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </div>
                            </div>
                        @elseif($ext === 'pdf')
                            <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-slate-200">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 font-extrabold text-xs flex items-center justify-center">PDF</div>
                                    <div>
                                        <span class="block text-xs font-bold text-slate-800">Berkas Bukti / Tiket (PDF)</span>
                                        <span class="block text-[11px] text-slate-400">{{ basename($report->evidence_file) }}</span>
                                    </div>
                                </div>
                                <a href="{{ $url }}" target="_blank" class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-xs font-bold hover:bg-indigo-700 transition-colors flex items-center gap-1.5 shadow-xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <span>Buka Dokumen</span>
                                </a>
                            </div>
                        @else
                            <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-slate-200">
                                <span class="text-xs text-slate-700 font-semibold">{{ basename($report->evidence_file) }}</span>
                                <a href="{{ $url }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:underline">Download File</a>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-xs text-slate-400 italic">
                        Pegawai tidak melampirkan berkas bukti dokumentasi (opsional).
                    </div>
                @endif
            </div>

            <!-- FOOTER DANGER ZONE -->
            <div class="pt-6 border-t border-slate-100 flex justify-between items-center">
                <span class="text-xs text-slate-400 font-mono">ID: GRATIFIKASI-{{ $report->id }}</span>

                <form action="{{ route('admin.gratification.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data laporan gratifikasi ini secara permanen? File bukti juga akan terhapus.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white text-xs font-bold transition-all flex items-center gap-1.5 shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        <span>Hapus Laporan</span>
                    </button>
                </form>
            </div>

        </div>
    </div>

</div>
@endsection

