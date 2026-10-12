@extends('admin.layouts.app')

@section('title', 'Detail & Hasil Perhitungan SKM')
@section('page_title', 'Detail Perhitungan SKM')

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-700 p-4 rounded-xl text-sm font-medium border border-emerald-100 flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Top Navigation & Controls -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <a href="{{ route('admin.surveys.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 flex items-center gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Survei
        </a>

        <div class="flex items-center gap-2">
            @if(! $survey->is_active)
                <form action="{{ route('admin.surveys.active', $survey) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition flex items-center gap-2 shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Aktifkan di Beranda Web
                    </button>
                </form>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-100 text-emerald-800 text-xs font-bold border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                    Aktif di Beranda Publik
                </span>
            @endif

            <form action="{{ route('admin.surveys.recalculate', $survey) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Hitung Ulang
                </button>
            </form>
        </div>
    </div>

    <!-- Main Score Hero Banner -->
    <div class="bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-700 rounded-3xl p-6 md:p-10 text-white shadow-xl relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-8">
            <div class="space-y-3 max-w-xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-white text-xs font-bold uppercase tracking-wider">
                    <span>{{ $survey->period }} Tahun {{ $survey->year }}</span>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold leading-tight">{{ $survey->title }}</h1>
                @if($survey->description)
                    <p class="text-blue-100 text-xs md:text-sm leading-relaxed">{{ $survey->description }}</p>
                @endif
                <div class="flex items-center gap-6 pt-2 text-xs text-blue-100">
                    <div>Total Responden: <strong class="text-white text-sm">{{ number_format($survey->total_respondents) }} orang</strong></div>
                    <div>Bobot per Unsur: <strong class="text-white text-sm">0,111 (1/9)</strong></div>
                    <div>Total NRT: <strong class="text-white text-sm">{{ number_format($calculation['total_nrt'] ?? 0, 4) }}</strong></div>
                </div>
            </div>

            <!-- Score Badge Card -->
            <div class="bg-white/10 backdrop-blur-md p-6 rounded-3xl border border-white/20 flex flex-col items-center justify-center text-center shrink-0 min-w-[240px] shadow-lg">
                <span class="text-xs uppercase font-extrabold tracking-widest text-blue-200 mb-1">NILAI AKHIR SKM</span>
                <span class="text-6xl md:text-7xl font-black text-white drop-shadow-md">
                    {{ number_format($survey->ikm_score, 2, ',', '.') }}
                </span>
                
                <div class="mt-3 flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full bg-white text-blue-900 font-extrabold text-sm shadow-xs">
                        MUTU {{ $survey->ikm_service_quality }}
                    </span>
                    <span class="px-3 py-1 rounded-full bg-emerald-400 text-emerald-950 font-extrabold text-sm shadow-xs">
                        {{ strtoupper($survey->ikm_performance_category) }}
                    </span>
                </div>
                <p class="text-[11px] text-blue-200 mt-2 font-medium">Skala 100 &bull; Permenpan RB 14/2017</p>
            </div>
        </div>
    </div>

    <!-- Rumus & Keterangan Metodologi -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-wrap md:flex-nowrap items-center justify-between gap-6 text-xs text-slate-600">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center shrink-0 font-bold">
                ∑
            </div>
            <div>
                <span class="font-bold text-slate-800 block">Metodologi Perhitungan Permenpan RB No 14 Tahun 2017:</span>
                <span class="text-slate-500">1. NRR = Total Nilai Unsur / N Responden &bull; 2. NRT = NRR &times; 0,111 &bull; 3. SKM = ∑(NRT) &times; 25</span>
            </div>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <span class="px-2 py-1 rounded bg-slate-100 font-bold text-slate-600">A (88.31 - 100)</span>
            <span class="px-2 py-1 rounded bg-slate-100 font-bold text-slate-600">B (76.61 - 88.30)</span>
            <span class="px-2 py-1 rounded bg-slate-100 font-bold text-slate-600">C (65.31 - 76.60)</span>
            <span class="px-2 py-1 rounded bg-slate-100 font-bold text-slate-600">D (25 - 65.30)</span>
        </div>
    </div>

    <!-- 9 Unsur Pelayanan Breakdown -->
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-800">Rincian Nilai 9 Unsur Pelayanan</h2>
            <span class="text-xs text-slate-400">Skala Unsur: 1.00 s/d 4.00</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($calculation['elements_detail'] as $key => $element)
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-blue-300 transition-all space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-md uppercase tracking-wider">
                            {{ strtoupper($key) }}
                        </span>
                        <span class="text-[11px] text-slate-400 font-medium">
                            NRT: <strong>{{ number_format($element['nrt'], 4) }}</strong>
                        </span>
                    </div>

                    <div>
                        <h3 class="font-bold text-sm text-slate-800">{{ $element['label'] }}</h3>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="text-2xl font-extrabold text-slate-900">{{ number_format($element['nrr'], 2) }}</span>
                            <span class="text-xs text-slate-400">NRR</span>
                        </div>
                    </div>

                    <!-- Visual Progress Bar (1-4 scale) -->
                    @php
                        $percentage = min(100, max(0, ($element['nrr'] / 4) * 100));
                    @endphp
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Tabel Data Responden -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h3 class="font-bold text-sm text-slate-800">Data Responden Kuesioner</h3>
                <p class="text-xs text-slate-400 mt-0.5">Menampilkan hasil kuesioner masing-masing responden (nilai 1-4 per unsur).</p>
            </div>
            <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-lg">
                Total {{ number_format($survey->total_respondents) }} Responden
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/80 uppercase tracking-wider text-slate-500 font-bold">
                        <th class="p-3 text-center">#</th>
                        <th class="p-3">Nama</th>
                        <th class="p-3 text-center">Usia</th>
                        <th class="p-3">Pekerjaan</th>
                        <th class="p-3 text-center bg-blue-50/50">U1</th>
                        <th class="p-3 text-center bg-blue-50/50">U2</th>
                        <th class="p-3 text-center bg-blue-50/50">U3</th>
                        <th class="p-3 text-center bg-blue-50/50">U4</th>
                        <th class="p-3 text-center bg-blue-50/50">U5</th>
                        <th class="p-3 text-center bg-blue-50/50">U6</th>
                        <th class="p-3 text-center bg-blue-50/50">U7</th>
                        <th class="p-3 text-center bg-blue-50/50">U8</th>
                        <th class="p-3 text-center bg-blue-50/50">U9</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($responses as $idx => $resp)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-3 text-center font-bold text-slate-400">{{ $responses->firstItem() + $idx }}</td>
                            <td class="p-3 font-semibold text-slate-800">{{ $resp->respondent_name ?? 'Anonim' }}</td>
                            <td class="p-3 text-center">{{ $resp->respondent_age ? $resp->respondent_age . ' th' : '-' }}</td>
                            <td class="p-3 text-slate-600">{{ $resp->respondent_job ?? '-' }}</td>
                            <td class="p-3 text-center font-bold {{ $resp->u1 >= 3 ? 'text-blue-600' : 'text-amber-600' }}">{{ $resp->u1 }}</td>
                            <td class="p-3 text-center font-bold {{ $resp->u2 >= 3 ? 'text-blue-600' : 'text-amber-600' }}">{{ $resp->u2 }}</td>
                            <td class="p-3 text-center font-bold {{ $resp->u3 >= 3 ? 'text-blue-600' : 'text-amber-600' }}">{{ $resp->u3 }}</td>
                            <td class="p-3 text-center font-bold {{ $resp->u4 >= 3 ? 'text-blue-600' : 'text-amber-600' }}">{{ $resp->u4 }}</td>
                            <td class="p-3 text-center font-bold {{ $resp->u5 >= 3 ? 'text-blue-600' : 'text-amber-600' }}">{{ $resp->u5 }}</td>
                            <td class="p-3 text-center font-bold {{ $resp->u6 >= 3 ? 'text-blue-600' : 'text-amber-600' }}">{{ $resp->u6 }}</td>
                            <td class="p-3 text-center font-bold {{ $resp->u7 >= 3 ? 'text-blue-600' : 'text-amber-600' }}">{{ $resp->u7 }}</td>
                            <td class="p-3 text-center font-bold {{ $resp->u8 >= 3 ? 'text-blue-600' : 'text-amber-600' }}">{{ $resp->u8 }}</td>
                            <td class="p-3 text-center font-bold {{ $resp->u9 >= 3 ? 'text-blue-600' : 'text-amber-600' }}">{{ $resp->u9 }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13" class="p-8 text-center text-slate-400">Tidak ada data responden kuesioner.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($responses->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $responses->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
