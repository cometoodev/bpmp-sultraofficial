@extends('layouts.admin')

@section('title', 'Isi & Kelola Data SKM Per Triwulan')
@section('header_title', 'Isi & Kelola Data SKM')
@section('header_subtitle', 'Entri data survei kepuasan masyarakat per triwulan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="skmForm()">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.surveys.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 flex items-center gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Survei
        </a>

        <a href="{{ route('admin.surveys.template') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 bg-blue-50 px-3 py-1.5 rounded-lg flex items-center gap-1.5 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Unduh Template Excel (.xlsx)
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-50 text-red-700 p-4 rounded-xl text-sm font-medium border border-red-100 flex flex-col gap-1.5">
            <div class="flex items-center gap-2 font-bold text-red-800">
                <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span>Terdapat kendala pada isian data:</span>
            </div>
            <ul class="list-disc list-inside text-xs space-y-1 pl-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.surveys.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        @csrf
        <input type="hidden" name="entry_type" :value="tab">

        <div class="p-6 md:p-8 space-y-6">
            <div>
                <h2 class="text-base font-bold text-slate-800">Pengisian Data SKM (Permenpan RB No. 14 / 2017)</h2>
                <p class="text-xs text-slate-500 mt-0.5">Pilih metode pengisian: isi nilai rata-rata per triwulan secara langsung atau unggah berkas Excel responden.</p>
            </div>

            <!-- Tab Pemilihan Metode Pengisian -->
            <div class="flex border-b border-slate-200">
                <button type="button" @click="tab = 'manual'"
                    :class="tab === 'manual' ? 'border-blue-600 text-blue-600 font-bold border-b-2 bg-blue-50/50' : 'text-slate-500 hover:text-slate-700'"
                    class="flex items-center gap-2 px-5 py-3 text-xs rounded-t-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <span>Isi Nilai Per Triwulan (Manual Form)</span>
                </button>
                <button type="button" @click="tab = 'excel'"
                    :class="tab === 'excel' ? 'border-blue-600 text-blue-600 font-bold border-b-2 bg-blue-50/50' : 'text-slate-500 hover:text-slate-700'"
                    class="flex items-center gap-2 px-5 py-3 text-xs rounded-t-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    <span>Import dari Berkas Excel (.xlsx/.csv)</span>
                </button>
            </div>

            <!-- Informasi Pokok Survei -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="space-y-1.5 md:col-span-3">
                    <label class="block text-xs font-bold text-slate-700">Nama / Judul Survei <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', 'Survei Kepuasan Masyarakat BPMP Provinsi Sulawesi Tenggara') }}" required
                        class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Periode Triwulan <span class="text-red-500">*</span></label>
                    <select name="period" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                        <option value="Triwulan 1" {{ old('period') == 'Triwulan 1' ? 'selected' : '' }}>Triwulan 1 (Januari - Maret)</option>
                        <option value="Triwulan 2" {{ old('period') == 'Triwulan 2' ? 'selected' : '' }}>Triwulan 2 (April - Juni)</option>
                        <option value="Triwulan 3" {{ old('period') == 'Triwulan 3' ? 'selected' : '' }}>Triwulan 3 (Juli - September)</option>
                        <option value="Triwulan 4" {{ old('period') == 'Triwulan 4' ? 'selected' : '' }}>Triwulan 4 (Oktober - Desember)</option>
                        <option value="Semester 1" {{ old('period') == 'Semester 1' ? 'selected' : '' }}>Semester 1 (Januari - Juni)</option>
                        <option value="Semester 2" {{ old('period') == 'Semester 2' ? 'selected' : '' }}>Semester 2 (Juli - Desember)</option>
                        <option value="Tahunan" {{ old('period') == 'Tahunan' ? 'selected' : '' }}>Tahunan (1 Tahun Penuh)</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Tahun <span class="text-red-500">*</span></label>
                    <input type="number" name="year" value="{{ old('year', date('Y')) }}" min="2000" max="2099" required
                        class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                </div>

                <div class="space-y-1.5 flex flex-col justify-end">
                    <label class="inline-flex items-center gap-2 p-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100 transition">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded text-blue-600 focus:ring-blue-500">
                        <span class="text-xs font-bold text-slate-700">Tampilkan Aktif di Web</span>
                    </label>
                </div>

                <div class="space-y-1.5 md:col-span-3">
                    <label class="block text-xs font-bold text-slate-700">Keterangan / Catatan Tambahan (Opsional)</label>
                    <textarea name="description" rows="2" placeholder="Catatan analisis, lingkup layanan, atau unit kerja pelaksana..."
                        class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Bagian 1: FORM PENGISIAN MANUAL 9 UNSUR PER TRIWULAN -->
            <div x-show="tab === 'manual'" class="space-y-5 pt-3 border-t border-slate-200/80">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Jumlah Responden Terkumpul <span class="text-red-500">*</span></label>
                    <input type="number" name="total_respondents" x-model.number="totalRespondents" min="1"
                        :required="tab === 'manual'"
                        placeholder="Contoh: 150"
                        class="w-full md:w-1/3 bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                    <span class="text-[11px] text-slate-400">Total kuisioner responden yang mengisi survei pada triwulan ini.</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nilai Rata-Rata (NRR) 9 Unsur Layanan (Skala 1.00 s/d 4.00) <span class="text-red-500">*</span></label>
                    <p class="text-xs text-slate-500 mb-4">Masukkan nilai rata-rata tiap unsur berdasarkan hasil olah kuesioner pada triwulan ini. Skor SKM akan otomatis dikalkulasi secara langsung.</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3.5">
                        <!-- U1 -->
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 space-y-1">
                            <span class="text-[11px] font-extrabold text-blue-600 block">U1: Persyaratan</span>
                            <input type="number" step="0.01" min="1" max="4" name="u1" x-model.number="u1"
                                :required="tab === 'manual'" placeholder="3.50"
                                class="w-full bg-white border border-slate-200 text-slate-800 text-sm font-bold rounded-lg p-2 focus:ring-2 focus:ring-blue-500/20">
                        </div>

                        <!-- U2 -->
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 space-y-1">
                            <span class="text-[11px] font-extrabold text-blue-600 block">U2: Prosedur</span>
                            <input type="number" step="0.01" min="1" max="4" name="u2" x-model.number="u2"
                                :required="tab === 'manual'" placeholder="3.50"
                                class="w-full bg-white border border-slate-200 text-slate-800 text-sm font-bold rounded-lg p-2 focus:ring-2 focus:ring-blue-500/20">
                        </div>

                        <!-- U3 -->
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 space-y-1">
                            <span class="text-[11px] font-extrabold text-blue-600 block">U3: Waktu Pelayanan</span>
                            <input type="number" step="0.01" min="1" max="4" name="u3" x-model.number="u3"
                                :required="tab === 'manual'" placeholder="3.50"
                                class="w-full bg-white border border-slate-200 text-slate-800 text-sm font-bold rounded-lg p-2 focus:ring-2 focus:ring-blue-500/20">
                        </div>

                        <!-- U4 -->
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 space-y-1">
                            <span class="text-[11px] font-extrabold text-blue-600 block">U4: Biaya / Tarif</span>
                            <input type="number" step="0.01" min="1" max="4" name="u4" x-model.number="u4"
                                :required="tab === 'manual'" placeholder="4.00"
                                class="w-full bg-white border border-slate-200 text-slate-800 text-sm font-bold rounded-lg p-2 focus:ring-2 focus:ring-blue-500/20">
                        </div>

                        <!-- U5 -->
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 space-y-1">
                            <span class="text-[11px] font-extrabold text-blue-600 block">U5: Produk Pelayanan</span>
                            <input type="number" step="0.01" min="1" max="4" name="u5" x-model.number="u5"
                                :required="tab === 'manual'" placeholder="3.50"
                                class="w-full bg-white border border-slate-200 text-slate-800 text-sm font-bold rounded-lg p-2 focus:ring-2 focus:ring-blue-500/20">
                        </div>

                        <!-- U6 -->
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 space-y-1">
                            <span class="text-[11px] font-extrabold text-blue-600 block">U6: Kompetensi Pelaksana</span>
                            <input type="number" step="0.01" min="1" max="4" name="u6" x-model.number="u6"
                                :required="tab === 'manual'" placeholder="3.50"
                                class="w-full bg-white border border-slate-200 text-slate-800 text-sm font-bold rounded-lg p-2 focus:ring-2 focus:ring-blue-500/20">
                        </div>

                        <!-- U7 -->
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 space-y-1">
                            <span class="text-[11px] font-extrabold text-blue-600 block">U7: Perilaku Pelaksana</span>
                            <input type="number" step="0.01" min="1" max="4" name="u7" x-model.number="u7"
                                :required="tab === 'manual'" placeholder="3.50"
                                class="w-full bg-white border border-slate-200 text-slate-800 text-sm font-bold rounded-lg p-2 focus:ring-2 focus:ring-blue-500/20">
                        </div>

                        <!-- U8 -->
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 space-y-1">
                            <span class="text-[11px] font-extrabold text-blue-600 block">U8: Penanganan Pengaduan</span>
                            <input type="number" step="0.01" min="1" max="4" name="u8" x-model.number="u8"
                                :required="tab === 'manual'" placeholder="3.50"
                                class="w-full bg-white border border-slate-200 text-slate-800 text-sm font-bold rounded-lg p-2 focus:ring-2 focus:ring-blue-500/20">
                        </div>

                        <!-- U9 -->
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 space-y-1">
                            <span class="text-[11px] font-extrabold text-blue-600 block">U9: Sarana & Prasarana</span>
                            <input type="number" step="0.01" min="1" max="4" name="u9" x-model.number="u9"
                                :required="tab === 'manual'" placeholder="3.50"
                                class="w-full bg-white border border-slate-200 text-slate-800 text-sm font-bold rounded-lg p-2 focus:ring-2 focus:ring-blue-500/20">
                        </div>
                    </div>
                </div>

                <!-- Live Hasil Perhitungan Otomatis -->
                <div class="p-4 bg-gradient-to-r from-blue-900 to-indigo-900 rounded-2xl text-white flex flex-wrap items-center justify-between gap-4 shadow-md">
                    <div>
                        <span class="text-[11px] font-bold text-blue-200 uppercase tracking-wider block">Kalkulasi Otomatis (Live Preview):</span>
                        <div class="flex items-baseline gap-3 mt-1">
                            <span class="text-3xl font-black text-white" x-text="calculatedScore.toFixed(2)"></span>
                            <span class="text-xs font-bold px-2 py-0.5 rounded bg-white text-blue-900" x-text="'Mutu ' + qualityGrade"></span>
                            <span class="text-xs font-bold text-emerald-300" x-text="performanceCategory"></span>
                        </div>
                    </div>
                    <div class="text-right text-xs text-blue-200">
                        <span class="block">Bobot Tertimbang per Unsur: <strong>0,111</strong></span>
                        <span class="block">Skala Konversi Permenpan RB: <strong>25 &times; ∑NRT</strong></span>
                    </div>
                </div>
            </div>

            <!-- Bagian 2: FORM UNGGAH FILE EXCEL -->
            <div x-show="tab === 'excel'" class="space-y-4 pt-3 border-t border-slate-200/80" style="display: none;">
                <!-- Petunjuk Kolom Excel -->
                <div class="bg-blue-50/70 border border-blue-100 rounded-xl p-4 text-xs text-blue-900 space-y-2">
                    <div class="font-bold flex items-center gap-2 text-blue-800">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Format Kolom File Excel:
                    </div>
                    <p class="leading-relaxed">
                        File Excel harus memuat kolom:
                        <code class="bg-white px-1.5 py-0.5 rounded font-bold border border-blue-200">Nama</code>,
                        <code class="bg-white px-1.5 py-0.5 rounded font-bold border border-blue-200">Usia</code>,
                        <code class="bg-white px-1.5 py-0.5 rounded font-bold border border-blue-200">Pekerjaan</code>, serta
                        <code class="bg-white px-1.5 py-0.5 rounded font-bold border border-blue-200">U1</code> sampai
                        <code class="bg-white px-1.5 py-0.5 rounded font-bold border border-blue-200">U9</code> (nilai 1-4).
                    </p>
                </div>

                <div class="space-y-2" x-data="{ fileName: null }">
                    <label class="block text-xs font-bold text-slate-700">Berkas Excel Kuesioner Responden <span class="text-red-500">*</span></label>
                    
                    <div class="relative w-full p-8 rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 flex flex-col items-center justify-center text-center hover:bg-slate-100/70 hover:border-blue-400 transition cursor-pointer">
                        <input type="file" name="file" accept=".xlsx,.xls,.csv"
                            :required="tab === 'excel'"
                            @change="fileName = $event.target.files[0] ? $event.target.files[0].name : null"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                        <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center mb-3">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        </div>

                        <div x-show="!fileName">
                            <p class="text-sm font-bold text-slate-700">Pilih atau Drag & Drop Berkas Excel Anda</p>
                            <p class="text-xs text-slate-400 mt-1">Ekstensi .xlsx, .xls, atau .csv (Maks 10MB)</p>
                        </div>

                        <div x-show="fileName" class="text-emerald-700 font-bold text-sm flex items-center gap-2" style="display: none;">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span x-text="fileName"></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="px-6 py-4 md:px-8 border-t border-slate-100 bg-slate-50 flex items-center justify-end gap-3">
            <a href="{{ route('admin.surveys.index') }}" class="px-5 py-2.5 text-slate-600 hover:text-slate-800 text-sm font-semibold transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Simpan & Hitung Nilai SKM
            </button>
        </div>
    </form>

</div>

<script>
function skmForm() {
    return {
        tab: 'manual',
        totalRespondents: {{ old('total_respondents', 100) }},
        u1: {{ old('u1', 3.60) }},
        u2: {{ old('u2', 3.55) }},
        u3: {{ old('u3', 3.50) }},
        u4: {{ old('u4', 3.90) }},
        u5: {{ old('u5', 3.65) }},
        u6: {{ old('u6', 3.75) }},
        u7: {{ old('u7', 3.70) }},
        u8: {{ old('u8', 3.60) }},
        u9: {{ old('u9', 3.55) }},

        get calculatedScore() {
            let elements = [this.u1, this.u2, this.u3, this.u4, this.u5, this.u6, this.u7, this.u8, this.u9];
            let totalNrt = 0;
            elements.forEach(val => {
                let nrr = parseFloat(val) || 0;
                let nrt = nrr * 0.111;
                totalNrt += nrt;
            });
            return totalNrt * 25;
        },

        get qualityGrade() {
            let s = this.calculatedScore;
            if (s >= 88.31) return 'A';
            if (s >= 76.61) return 'B';
            if (s >= 65.31) return 'C';
            return 'D';
        },

        get performanceCategory() {
            let s = this.calculatedScore;
            if (s >= 88.31) return 'Sangat Baik';
            if (s >= 76.61) return 'Baik';
            if (s >= 65.31) return 'Kurang Baik';
            return 'Tidak Baik';
        }
    }
}
</script>
@endsection
