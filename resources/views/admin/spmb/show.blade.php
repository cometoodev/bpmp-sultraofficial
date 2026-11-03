@extends('layouts.admin')

@section('title', 'Detail Pengaduan SPMB #' . $report->id)
@section('header_title', 'Detail Pengaduan SPMB')
@section('header_subtitle', 'Rincian data laporan dan bukti kejadian dari masyarakat')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- TOP BAR / ACTION -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <a href="{{ route('admin.spmb.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Pengaduan
        </a>

        <!-- Status Penanganan Form -->
        <form action="{{ route('admin.spmb.status', $report->id) }}" method="POST" class="flex items-center gap-2">
            @csrf
            @method('PATCH')
            <label class="text-xs font-bold text-slate-500">Ubah Status:</label>
            <select name="status" onchange="this.form.submit()" class="bg-white border border-slate-200 text-xs font-bold rounded-xl px-3 py-2 outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>⏳ Menunggu (Pending)</option>
                <option value="processed" {{ $report->status === 'processed' ? 'selected' : '' }}>⚡ Sedang Diproses</option>
                <option value="completed" {{ $report->status === 'completed' ? 'selected' : '' }}>✅ Selesai</option>
            </select>
        </form>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-semibold flex items-center gap-2 shadow-xs">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- MAIN CARD (Glassmorphism) -->
    <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] p-6 sm:p-10 border border-white/80 shadow-md relative overflow-hidden">
        <!-- Efek Cahaya Latar -->
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 space-y-8">

            <!-- HEADER INFO -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-100 gap-4">
                <div>
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-indigo-50 text-indigo-600 border border-indigo-100">
                            SPMB #{{ $report->id }}
                        </span>
                        @if($report->status === 'completed')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Selesai
                            </span>
                        @elseif($report->status === 'processed')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                Sedang Diproses
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                Menunggu Verifikasi
                            </span>
                        @endif
                    </div>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-800 mt-2">{{ $report->name }}</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Diterima pada: {{ $report->created_at->translatedFormat('l, d F Y - H:i') }} WITA</p>
                </div>

                <!-- Action Button Hubungi -->
                <div class="flex items-center gap-2">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $report->phone) }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold flex items-center gap-2 shadow-xs transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.173.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.086s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824z"/></svg>
                        <span>Hubungi via WA</span>
                    </a>
                    <a href="mailto:{{ $report->email }}" class="px-4 py-2.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold flex items-center gap-2 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>Kirim Email</span>
                    </a>
                </div>
            </div>

            <!-- GRID DETAIL -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- IDENTITAS PELAPOR -->
                <div class="space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Identitas Pelapor</h3>
                    
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-3">
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400">Nama Lengkap</span>
                            <span class="block text-sm font-bold text-slate-800">{{ $report->name }}</span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400">Email</span>
                            <span class="block text-sm font-semibold text-slate-700">{{ $report->email }}</span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400">Nomor WhatsApp / HP</span>
                            <span class="block text-sm font-mono font-semibold text-slate-800">{{ $report->phone }}</span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400">Alamat Domisili</span>
                            <span class="block text-xs text-slate-700 leading-relaxed">{{ $report->address }}</span>
                        </div>
                    </div>
                </div>

                <!-- ISI PENGADUAN & LAMPIRAN -->
                <div class="md:col-span-2 space-y-6">
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Uraian / Isi Pengaduan</h3>
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 text-sm text-slate-700 leading-relaxed whitespace-pre-line font-normal">
                            {{ $report->message }}
                        </div>
                    </div>

                    <!-- BUKTI LAMPIRAN KEJADIAN -->
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Bukti Lampiran Kejadian</h3>
                        @if($report->evidence_file)
                            @php
                                $ext = strtolower(pathinfo($report->evidence_file, PATHINFO_EXTENSION));
                                $url = Storage::disk('public')->url($report->evidence_file);
                            @endphp

                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                @if(in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
                                    <div class="space-y-3">
                                        <div class="rounded-xl overflow-hidden max-h-96 border border-slate-200">
                                            <img src="{{ $url }}" alt="Bukti Lampiran" class="w-full object-contain max-h-96 bg-black/5">
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs text-slate-500 font-medium">Format: {{ strtoupper($ext) }}</span>
                                            <a href="{{ $url }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                                                <span>Buka Gambar Ukuran Penuh</span>
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                            </a>
                                        </div>
                                    </div>
                                @elseif($ext === 'pdf')
                                    <div class="flex items-center justify-between p-3 bg-white rounded-xl border border-slate-200">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 font-extrabold text-xs flex items-center justify-center">PDF</div>
                                            <div>
                                                <span class="block text-xs font-bold text-slate-800">Dokumen Bukti Lampiran (PDF)</span>
                                                <span class="block text-[11px] text-slate-400">{{ basename($report->evidence_file) }}</span>
                                            </div>
                                        </div>
                                        <a href="{{ $url }}" target="_blank" class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-xs font-bold hover:bg-indigo-700 transition-colors flex items-center gap-1.5 shadow-xs">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <span>Buka Dokumen</span>
                                        </a>
                                    </div>
                                @else
                                    <div class="flex items-center justify-between p-3 bg-white rounded-xl border border-slate-200">
                                        <span class="text-xs text-slate-700 font-semibold">{{ basename($report->evidence_file) }}</span>
                                        <a href="{{ $url }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:underline">Download File</a>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-xs text-slate-400 italic">
                                Pelapor tidak melampirkan berkas bukti kejadian (opsional).
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- FOOTER DANGER ZONE -->
            <div class="pt-6 border-t border-slate-100 flex justify-between items-center">
                <span class="text-xs text-slate-400">ID Laporan: SPMB-{{ $report->id }}</span>

                <form action="{{ route('admin.spmb.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pengaduan ini secara permanen? File bukti juga akan dihapus.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white text-xs font-bold transition-all flex items-center gap-1.5 shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        <span>Hapus Pengaduan</span>
                    </button>
                </form>
            </div>

        </div>
    </div>

</div>
@endsection

