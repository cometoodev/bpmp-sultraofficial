<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih - ULT BPMP Sulawesi Tenggara</title>
    <link rel="icon" href="{{ asset('tutwurihandayani.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-display { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.9);
        }
        @keyframes heartbeat {
            0% { transform: scale(1); }
            14% { transform: scale(1.22); }
            28% { transform: scale(1); }
            42% { transform: scale(1.18); }
            70% { transform: scale(1); }
        }
        .heart-pulse {
            animation: heartbeat 2.2s infinite ease-in-out;
            display: inline-block;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-100 via-sky-50/70 to-blue-100/80 min-h-screen text-slate-800 antialiased selection:bg-blue-600 selection:text-white flex flex-col justify-between relative overflow-x-hidden p-4 sm:p-6">

    <!-- Ambient Glowing Orbs -->
    <div class="fixed inset-0 pointer-events-none -z-10 overflow-hidden">
        <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-96 h-96 bg-blue-300/25 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 right-1/4 w-96 h-96 bg-rose-200/25 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 -left-24 w-80 h-80 bg-sky-200/25 rounded-full blur-3xl"></div>
    </div>

    <!-- Header Brand -->
    <header class="w-full max-w-lg mx-auto text-center pt-4">
        <a href="/" class="inline-flex items-center gap-2.5 group">
            <img src="{{ asset('tutwurihandayani.png') }}" alt="Logo BPMP Sultra" class="h-10 w-10 drop-shadow">
            <div class="text-left">
                <span class="block text-base font-extrabold text-slate-900 font-display leading-tight">
                    <span class="text-blue-600">BPMP</span> SULTRA
                </span>
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">
                    Unit Layanan Terpadu
                </span>
            </div>
        </a>
    </header>

    <!-- Center Card Glassmorphism -->
    <main class="w-full max-w-lg mx-auto my-auto py-6">
        <div class="glass-panel rounded-3xl shadow-2xl shadow-blue-900/10 overflow-hidden relative border border-white/80">

            <!-- Header Biru Gelap: Teks "Terima Kasih!" -->
            <div class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 px-6 py-8 text-center text-white relative">
                <div class="absolute -top-12 -right-12 w-32 h-32 bg-blue-500/20 rounded-full blur-2xl pointer-events-none"></div>

                <span class="inline-block px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-sky-200 text-xs font-bold uppercase tracking-wider mb-2">
                    Survei Selesai Disimpan
                </span>
                <h1 class="text-3xl sm:text-4xl font-extrabold font-display tracking-tight text-white">
                    Terima Kasih!
                </h1>
                <p class="text-xs sm:text-sm text-sky-200/80 mt-1.5">
                    Unit Layanan Terpadu BPMP Provinsi Sulawesi Tenggara
                </p>
            </div>

            <!-- Card Content -->
            <div class="p-6 sm:p-10 text-center">

                <!-- Ikon Merah Heart Pulse -->
                <div class="mb-6 flex justify-center">
                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-rose-50 border-4 border-rose-200/70 flex items-center justify-center shadow-xl shadow-rose-500/15">
                        <span class="text-5xl sm:text-6xl heart-pulse filter drop-shadow">
                            ❤️
                        </span>
                    </div>
                </div>

                <!-- Teks Apresiasi -->
                <div class="mb-6">
                    <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 font-display">
                        Apresiasi dari Kami
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 mt-2.5 leading-relaxed">
                        Penilaian dan masukan Anda sangat berharga dalam membantu kami meningkatkan mutu dan standar pelayanan publik yang prima, bersih, dan akuntabel di Unit Layanan Terpadu (ULT) BPMP Provinsi Sulawesi Tenggara.
                    </p>
                </div>

                <!-- Quote / Maklumat -->
                <div class="mb-8 p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 text-slate-600 text-xs italic">
                    "Melayani dengan Hati, Menjaga Mutu Pendidikan Sulawesi Tenggara"
                </div>

                <!-- Tombol Kembali ke Beranda -->
                <div class="space-y-3">
                    <a href="{{ url('/') }}"
                       class="w-full py-3.5 px-6 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 hover:from-blue-700 hover:via-blue-800 hover:to-indigo-800 text-white font-extrabold text-base shadow-xl shadow-blue-600/30 hover:shadow-blue-600/40 transform hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2 font-display">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span>Kembali ke Beranda</span>
                    </a>

                    <a href="{{ route('guestbook.create') }}"
                       class="inline-block text-xs font-semibold text-slate-500 hover:text-blue-600 transition-colors pt-2">
                        + Isi Buku Tamu Kunjungan Baru
                    </a>
                </div>

            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full max-w-lg mx-auto text-center py-4 text-xs text-slate-500">
        &copy; {{ date('Y') }} Balai Penjaminan Mutu Pendidikan (BPMP) Sulawesi Tenggara
    </footer>

</body>
</html>
