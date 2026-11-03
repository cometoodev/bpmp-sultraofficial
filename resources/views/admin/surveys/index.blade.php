@extends('layouts.admin')

@section('title', 'Survei Kepuasan Masyarakat (SKM)')
@section('header_title', 'Survei Kepuasan Masyarakat (SKM)')
@section('header_subtitle', 'Data responden dan pengisian kuesioner mutu layanan publik')

@section('content')
<div class="space-y-6">

    {{-- Notifikasi Sukses / Error --}}
    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-800 p-4 rounded-2xl text-xs font-semibold border border-emerald-200/80 shadow-xs flex items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-emerald-500 text-white flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-50 text-rose-800 p-4 rounded-2xl text-xs font-semibold border border-rose-200/80 shadow-xs flex items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-rose-500 text-white flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    {{-- Header Actions --}}
    <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-lg font-bold text-slate-800 font-heading">Manajemen Survei Kepuasan (SKM)</h1>
            <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">
                Perhitungan otomatis IKM / SKM Permenpan RB No 14 Tahun 2017 berbasis import data Excel kuesioner.
            </p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.surveys.template') }}" class="px-4 py-2.5 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-bold rounded-xl border border-slate-200 transition flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                <span>Unduh Template Excel</span>
            </a>
            <a href="{{ route('admin.surveys.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition flex items-center gap-2 shadow-sm shadow-blue-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>+ Isi / Import SKM Baru</span>
            </a>
        </div>
    </div>

    {{-- Active Survey Highlight Card --}}
    @if($activeSurvey)
        <div class="bg-gradient-to-r from-blue-700 via-indigo-600 to-slate-900 rounded-3xl p-6 md:p-8 text-white shadow-lg relative overflow-hidden border border-blue-600/30">
            <!-- Decorative Glow Elements -->
            <div class="absolute -right-16 -top-16 w-64 h-64 bg-cyan-400/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-12 -bottom-12 w-48 h-48 bg-blue-500/20 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="space-y-2.5 max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 text-xs font-extrabold uppercase tracking-wider backdrop-blur-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Survei Aktif di Beranda Publik
                    </div>
                    <h2 class="text-xl md:text-2xl font-bold font-heading text-white leading-tight">
                        {{ $activeSurvey->title }}
                    </h2>
                    <p class="text-blue-100/90 text-xs md:text-sm">
                        Periode: <span class="font-bold text-white">{{ $activeSurvey->period }} {{ $activeSurvey->year }}</span> &bull; 
                        Total Responden: <strong class="text-white">{{ number_format($activeSurvey->total_respondents) }} orang</strong>
                    </p>
                </div>

                <div class="flex items-center gap-5 bg-white/10 backdrop-blur-md px-6 py-4 rounded-2xl border border-white/20 shadow-md shrink-0">
                    <div>
                        <span class="text-[11px] uppercase tracking-wider text-blue-200 font-bold block">
                            Nilai SKM (Skala 100)
                        </span>
                        <div class="flex items-baseline gap-2 mt-0.5">
                            <span class="text-4xl md:text-5xl font-black text-white tracking-tight">
                                {{ number_format($activeSurvey->ikm_score, 2, ',', '.') }}
                            </span>
                            <span class="text-xs font-black px-2.5 py-1 rounded-lg bg-white text-blue-900 shadow-xs">
                                Mutu {{ $activeSurvey->ikm_service_quality }}
                            </span>
                        </div>
                        <span class="text-xs font-bold text-emerald-300 mt-1 block">
                            Kinerja: {{ $activeSurvey->ikm_performance_category }}
                        </span>
                    </div>
                    <a href="{{ route('admin.surveys.show', $activeSurvey) }}" class="p-3 bg-white text-blue-700 rounded-xl hover:bg-blue-50 transition shadow-sm font-bold text-xs flex items-center gap-1.5 shrink-0">
                        <span>Lihat Rincian</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- Table of Surveys --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-sm text-slate-800">Daftar Hasil Survei Tersimpan</h3>
            <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-lg">
                Total: {{ $surveys->total() }} Periode
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/80 text-xs uppercase tracking-wider text-slate-500">
                        <th class="p-4 font-bold">Judul & Periode</th>
                        <th class="p-4 font-bold text-center">Tahun</th>
                        <th class="p-4 font-bold text-center">Responden</th>
                        <th class="p-4 font-bold text-center">Nilai SKM</th>
                        <th class="p-4 font-bold text-center">Mutu / Kinerja</th>
                        <th class="p-4 font-bold text-center">Status Web</th>
                        <th class="p-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($surveys as $survey)
                        <tr class="hover:bg-slate-50/60 transition-colors {{ $survey->is_active ? 'bg-blue-50/20' : '' }}">
                            <td class="p-4">
                                <a href="{{ route('admin.surveys.show', $survey) }}" class="font-bold text-slate-800 hover:text-blue-600 transition">
                                    {{ $survey->title }}
                                </a>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $survey->period }}</p>
                            </td>
                            <td class="p-4 text-center font-semibold text-slate-600">
                                {{ $survey->year }}
                            </td>
                            <td class="p-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-bold text-xs border border-slate-200/60">
                                    {{ number_format($survey->total_respondents) }}
                                </span>
                            </td>
                            <td class="p-4 text-center font-extrabold text-blue-600 text-base">
                                {{ number_format($survey->ikm_score, 2, ',', '.') }}
                            </td>
                            <td class="p-4 text-center">
                                @if($survey->ikm_service_quality === 'A')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Mutu A &bull; Sangat Baik
                                    </span>
                                @elseif($survey->ikm_service_quality === 'B')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                        Mutu B &bull; Baik
                                    </span>
                                @elseif($survey->ikm_service_quality === 'C')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Mutu C &bull; Kurang Baik
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Mutu D &bull; Tidak Baik
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                @if($survey->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Tampil di Web
                                    </span>
                                @else
                                    <form action="{{ route('admin.surveys.active', $survey) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 text-xs font-semibold text-slate-500 hover:text-blue-700 bg-slate-100 hover:bg-blue-50 rounded-lg transition border border-slate-200/80">
                                            Jadikan Aktif
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.surveys.show', $survey) }}" class="p-2 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition" title="Lihat Detail & 9 Unsur">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>

                                    <a href="{{ route('admin.surveys.edit', $survey) }}" class="p-2 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition" title="Edit Data & Nilai Triwulan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    <form action="{{ route('admin.surveys.recalculate', $survey) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-2 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition" title="Hitung Ulang SKM">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.surveys.destroy', $survey) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data survei ini beserta seluruh data kuesionernya?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition" title="Hapus Survei">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400">
                                Belum ada data survei kepuasan masyarakat yang diimpor.
                                <div class="mt-3">
                                    <a href="{{ route('admin.surveys.create') }}" class="text-blue-600 font-bold hover:underline text-xs">
                                        + Unggah data kuesioner pertama Anda
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($surveys->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $surveys->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
