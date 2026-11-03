<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuisioner Kepuasan Layanan ULT - BPMP Provinsi Sulawesi Tenggara</title>
    <link rel="icon" href="{{ asset('tutwurihandayani.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-display { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.85);
        }
        .glass-question {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.85);
            transition: all 0.25s ease-in-out;
        }
        .glass-question:hover {
            background: rgba(255, 255, 255, 0.85);
            border-color: rgba(147, 197, 253, 0.9);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.08);
        }
        /* Pure CSS Emoji Card States */
        .emoji-box {
            background: rgba(255, 255, 255, 0.7);
            border: 1.5px solid rgba(226, 232, 240, 0.9);
            backdrop-filter: blur(8px);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .emoji-box:hover {
            background: rgba(255, 255, 255, 0.95);
            border-color: #93c5fd;
            transform: translateY(-2px);
        }
        .emoji-input:checked + .emoji-box {
            background: linear-gradient(135deg, rgba(239, 246, 255, 0.95), rgba(219, 234, 254, 0.95));
            border-color: #3b82f6;
            box-shadow: 0 8px 20px -3px rgba(59, 130, 246, 0.28), 0 0 0 2px rgba(59, 130, 246, 0.35);
            transform: translateY(-3px);
        }
        .emoji-input:checked + .emoji-box .emoji-char {
            transform: scale(1.22);
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.15));
        }
        .emoji-input:checked + .emoji-box .emoji-text {
            color: #1e40af;
            font-weight: 700;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-100 via-sky-50/60 to-blue-100/70 min-h-screen text-slate-800 antialiased selection:bg-blue-600 selection:text-white relative overflow-x-hidden">

    <!-- Ambient Glowing Orbs -->
    <div class="fixed inset-0 pointer-events-none -z-10 overflow-hidden">
        <div class="absolute -top-32 right-10 w-96 h-96 bg-blue-300/20 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -left-32 w-96 h-96 bg-amber-200/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 right-1/4 w-96 h-96 bg-indigo-300/20 rounded-full blur-3xl"></div>
    </div>

    <!-- Header Navigation -->
    <header class="w-full px-4 sm:px-8 pt-4 pb-2">
        <div class="max-w-5xl mx-auto flex items-center justify-between">
            <a href="/" class="inline-flex items-center gap-3 group">
                <img src="{{ asset('tutwurihandayani.png') }}" alt="Logo BPMP Sultra" class="h-10 w-10 drop-shadow group-hover:scale-105 transition-transform duration-200">
                <div>
                    <span class="block text-base font-extrabold text-slate-900 font-display leading-tight">
                        <span class="text-blue-600">BPMP</span> SULTRA
                    </span>
                    <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider block">
                        Survei Kepuasan Layanan ULT
                    </span>
                </div>
            </a>
            <div class="text-right">
                <span class="text-xs text-slate-500 block">Tamu Terdaftar</span>
                <span class="text-xs font-bold text-blue-700 font-display block">{{ $guestbook->nama }}</span>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-5xl mx-auto px-4 sm:px-6 py-6">
        <div class="glass-panel rounded-3xl shadow-2xl shadow-blue-900/10 p-6 sm:p-10 relative overflow-hidden">
            <!-- Decorative Accent line -->
            <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-blue-500 via-sky-400 to-indigo-600"></div>

            <!-- Page Header -->
            <div class="text-center max-w-2xl mx-auto mb-8">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-xs font-bold uppercase tracking-wider mb-2">
                    <span>⭐</span>
                    <span>Kuisioner Mutu Pelayanan</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display tracking-tight">
                    Penilaian Kepuasan Layanan ULT
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 mt-2 leading-relaxed">
                    Mohon berikan penilaian objektif atas layanan yang Anda terima di Unit Layanan Terpadu (ULT) BPMP Provinsi Sulawesi Tenggara dengan memilih emoji yang paling sesuai.
                </p>

                <!-- Visitor Quick Tag -->
                <div class="mt-4 inline-flex items-center gap-2 px-4 py-1.5 rounded-xl bg-white/80 border border-slate-200 text-xs text-slate-700 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Pengunjung: <strong>{{ $guestbook->nama }}</strong></span>
                    <span class="text-slate-300">•</span>
                    <span class="text-slate-500 truncate max-w-xs">{{ $guestbook->asal_instansi }}</span>
                </div>
            </div>

            @if($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm">
                    <p class="font-bold">Mohon lengkapi semua pertanyaan kuisioner sebelum mengirimkan formulir.</p>
                </div>
            @endif

            <!-- Form Kuisioner -->
            <form action="{{ route('survey.store', $guestbook->id) }}" method="POST" class="space-y-6">
                @csrf

                @php
                    $questions = [
                        [
                            'key' => 'q1',
                            'num' => 1,
                            'title' => 'Kesesuaian Persyaratan',
                            'desc' => 'Bagaimana kesesuaian persyaratan pelayanan yang dipersyaratkan dengan jenis layanan yang Anda terima?'
                        ],
                        [
                            'key' => 'q2',
                            'num' => 2,
                            'title' => 'Kemudahan Prosedur',
                            'desc' => 'Bagaimana kemudahan prosedur dan alur pelayanan di loket Unit Layanan Terpadu?'
                        ],
                        [
                            'key' => 'q3',
                            'num' => 3,
                            'title' => 'Kecepatan Waktu Pelayanan',
                            'desc' => 'Bagaimana kecepatan dan ketepatan waktu petugas dalam memberikan respon serta penyelesaian layanan?'
                        ],
                        [
                            'key' => 'q4',
                            'num' => 4,
                            'title' => 'Tidak Ada Biaya / Bebas Pungli',
                            'desc' => 'Apakah pelayanan yang diberikan bebas dari pungutan biaya tambahan, gratifikasi, atau imbalan apapun?'
                        ],
                        [
                            'key' => 'q5',
                            'num' => 5,
                            'title' => 'Kesesuaian Produk Layanan',
                            'desc' => 'Bagaimana kesesuaian hasil/produk pelayanan yang Anda terima dengan standar yang telah dijanjikan?'
                        ],
                        [
                            'key' => 'q6',
                            'num' => 6,
                            'title' => 'Kompetensi Petugas',
                            'desc' => 'Bagaimana kecakapan, pengetahuan, dan keahlian petugas dalam melayani kebutuhan konsultasi/permohonan Anda?'
                        ],
                        [
                            'key' => 'q7',
                            'num' => 7,
                            'title' => 'Sikap & Keramahan Petugas',
                            'desc' => 'Bagaimana kesopanan, keramahan, dan kepedulian petugas ULT saat menyambut dan melayani Anda?'
                        ],
                        [
                            'key' => 'q8',
                            'num' => 8,
                            'title' => 'Kualitas Sarana & Prasarana',
                            'desc' => 'Bagaimana kebersihan, kenyamanan ruang tunggu, fasilitas, dan kelengkapan sarana pendukung di ULT?'
                        ],
                        [
                            'key' => 'q9',
                            'num' => 9,
                            'title' => 'Penanganan Pengaduan Layanan',
                            'desc' => 'Bagaimana kejelasan informasi dan penanganan tindak lanjut apabila ada pertanyaan, kritik, atau pengaduan?'
                        ],
                    ];

                    $emojiOptions = [
                        ['val' => 1, 'emoji' => '😡', 'label' => 'Sangat Tidak Puas'],
                        ['val' => 2, 'emoji' => '🙁', 'label' => 'Tidak Puas'],
                        ['val' => 3, 'emoji' => '😊', 'label' => 'Puas'],
                        ['val' => 4, 'emoji' => '😍', 'label' => 'Sangat Puas'],
                    ];
                @endphp

                <!-- 9 Pertanyaan Kuisioner dengan Emoji Glassmorphism -->
                <div class="space-y-4">
                    @foreach($questions as $q)
                        <div class="glass-question p-4 sm:p-5 rounded-2xl">
                            <div class="flex items-start gap-3 mb-3">
                                <span class="w-7 h-7 rounded-xl bg-blue-600 text-white font-extrabold text-xs flex items-center justify-center shrink-0 shadow-md shadow-blue-500/20 font-display">
                                    {{ $q['num'] }}
                                </span>
                                <div>
                                    <h3 class="text-sm sm:text-base font-bold text-slate-900 font-display">
                                        {{ $q['title'] }}
                                    </h3>
                                    <p class="text-xs text-slate-600 mt-0.5 leading-relaxed">
                                        {{ $q['desc'] }}
                                    </p>
                                </div>
                            </div>

                            <!-- 4 Emoji Radio Options Horizontal -->
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 sm:gap-3 pt-1">
                                @foreach($emojiOptions as $opt)
                                    <div>
                                        <input type="radio"
                                               name="{{ $q['key'] }}"
                                               id="{{ $q['key'] }}_{{ $opt['val'] }}"
                                               value="{{ $opt['val'] }}"
                                               {{ old($q['key']) == $opt['val'] ? 'checked' : '' }}
                                               required
                                               class="emoji-input sr-only">
                                        <label for="{{ $q['key'] }}_{{ $opt['val'] }}"
                                               class="emoji-box flex flex-col items-center justify-center p-3 rounded-2xl cursor-pointer text-center select-none group">
                                            <span class="emoji-char text-3xl sm:text-4xl transition-transform duration-200 transform group-hover:scale-110">
                                                {{ $opt['emoji'] }}
                                            </span>
                                            <span class="emoji-text text-[11px] font-semibold text-slate-600 mt-1.5 transition-colors duration-200 leading-tight">
                                                {{ $opt['label'] }}
                                            </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Textarea Saran dan Masukan -->
                <div class="glass-question p-4 sm:p-5 rounded-2xl">
                    <div class="flex items-start gap-3 mb-2">
                        <span class="w-7 h-7 rounded-xl bg-indigo-600 text-white font-extrabold text-xs flex items-center justify-center shrink-0 shadow-md shadow-indigo-500/20 font-display">
                            ✍️
                        </span>
                        <div>
                            <label for="saran" class="block text-sm sm:text-base font-bold text-slate-900 font-display">
                                Saran dan Masukan <span class="text-slate-400 font-normal text-xs">(Opsional)</span>
                            </label>
                            <p class="text-xs text-slate-600 mt-0.5">
                                Tuliskan aspirasi, kritik, atau saran perbaikan untuk kemajuan pelayanan BPMP Provinsi Sulawesi Tenggara.
                            </p>
                        </div>
                    </div>
                    <div class="pt-2">
                        <textarea id="saran" name="saran" rows="3"
                                  class="w-full px-4 py-3 rounded-2xl bg-white/80 border border-slate-200 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                  placeholder="Tuliskan pengalaman atau saran Anda di sini...">{{ old('saran') }}</textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                            class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 hover:from-blue-700 hover:via-blue-800 hover:to-indigo-800 text-white font-extrabold text-base sm:text-lg shadow-xl shadow-blue-600/30 hover:shadow-blue-600/40 transform hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-3 font-display">
                        <svg class="w-5 h-5 text-sky-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        <span>Kirim Penilaian</span>
                    </button>
                </div>

                <p class="text-center text-xs text-slate-500 pt-1">
                    Seluruh penilaian Anda dilindungi kerahasiaannya dan digunakan semata-mata untuk peningkatan mutu layanan.
                </p>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="max-w-5xl mx-auto px-4 text-center py-6 text-xs text-slate-500">
        &copy; {{ date('Y') }} BPMP Provinsi Sulawesi Tenggara.
    </footer>

</body>
</html>
