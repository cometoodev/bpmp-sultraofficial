<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check-In Berhasil - ULT BPMP Sultra</title>
    <link rel="icon" href="{{ asset('tutwurihandayani.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-display { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.78);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.9);
        }
        .pulse-subtle {
            animation: pulse-ring 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse-ring {
            0%, 100% { transform: scale(1); opacity: 0.9; }
            50% { transform: scale(1.06); opacity: 1; }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-100 via-sky-50/70 to-blue-100/80 min-h-screen text-slate-800 antialiased selection:bg-blue-600 selection:text-white flex flex-col justify-between relative overflow-x-hidden p-4 sm:p-6">

    <!-- Ambient Glowing Orbs -->
    <div class="fixed inset-0 pointer-events-none -z-10 overflow-hidden">
        <div class="absolute -top-24 left-1/3 w-96 h-96 bg-emerald-300/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 right-1/4 w-96 h-96 bg-blue-400/25 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -left-20 w-80 h-80 bg-amber-200/25 rounded-full blur-3xl"></div>
    </div>

    <!-- Top Minimal Brand -->
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
        <div class="glass-panel rounded-3xl shadow-2xl shadow-blue-900/10 p-6 sm:p-10 text-center relative overflow-hidden border border-white/80">
            <!-- Decorative Accent line -->
            <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-emerald-400 via-teal-500 to-blue-600"></div>

            <!-- Ikon Centang Hijau Besar -->
            <div class="mb-6 flex justify-center">
                <div class="relative">
                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-emerald-100/90 border-4 border-emerald-400/30 flex items-center justify-center shadow-xl shadow-emerald-500/20 pulse-subtle">
                        <svg class="w-12 h-12 sm:w-14 sm:h-14 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="absolute -top-1 -right-1 w-7 h-7 rounded-full bg-white shadow-md flex items-center justify-center text-emerald-600 font-bold text-sm">
                        ✨
                    </div>
                </div>
            </div>

            <!-- Teks Check-In Berhasil -->
            <span class="inline-block px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold uppercase tracking-wider mb-2">
                Registrasi Sukses
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display tracking-tight">
                Check-In Berhasil!
            </h1>
            <p class="text-sm text-slate-600 mt-2 leading-relaxed">
                Terima kasih atas kehadiran Anda di Unit Layanan Terpadu BPMP Provinsi Sulawesi Tenggara.
            </p>

            <!-- Card Rincian Pengunjung dari Database -->
            <div class="my-6 p-4 sm:p-5 rounded-2xl bg-white/70 border border-slate-200/80 shadow-sm text-left space-y-3">
                <div class="flex items-start justify-between gap-3 border-b border-slate-100 pb-2.5">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Pengunjung</span>
                    <span class="text-sm font-bold text-slate-900 text-right font-display">{{ $guestbook->nama }}</span>
                </div>
                <div class="flex items-start justify-between gap-3 border-b border-slate-100 pb-2.5">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Asal Instansi</span>
                    <span class="text-sm font-semibold text-slate-800 text-right">{{ $guestbook->asal_instansi }}</span>
                </div>
                <div class="flex items-start justify-between gap-3 border-b border-slate-100 pb-2.5">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kabupaten / Kota</span>
                    <span class="text-xs font-medium text-slate-700 text-right">{{ $guestbook->asal_kabupaten }}</span>
                </div>
                <div class="flex items-start justify-between gap-3">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Layanan</span>
                    <span class="text-xs font-semibold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-lg text-right max-w-[65%] truncate">
                        {{ $guestbook->jenis_layanan }}
                    </span>
                </div>
            </div>

            <!-- Prompt Ajakan Penilaian -->
            <div class="mb-6 p-3.5 rounded-2xl bg-gradient-to-r from-amber-50 to-yellow-50/80 border border-amber-200/70 text-amber-900 text-xs sm:text-sm text-center">
                <p class="font-medium">
                    Bantu kami meningkatkan kualitas layanan dengan mengisi <strong>kuisioner singkat (1 menit)</strong> berikut.
                </p>
            </div>

            <!-- Tombol Utama: Emas / Kuning mengarah ke route kuisioner -->
            <div class="space-y-3">
                <a href="{{ route('survey.create', $guestbook->id) }}"
                   class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-amber-400 via-amber-500 to-yellow-500 hover:from-amber-500 hover:via-amber-600 hover:to-yellow-600 text-slate-950 font-black text-base sm:text-lg shadow-xl shadow-amber-500/30 hover:shadow-amber-500/40 transform hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2 font-display">
                    <span>⭐</span>
                    <span>Beri Penilaian Layanan</span>
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>

                <div class="pt-2 flex items-center justify-center gap-4 text-xs">
                    <a href="{{ route('guestbook.create') }}" class="text-slate-500 hover:text-blue-600 font-medium transition-colors">
                        + Tamu Berikutnya
                    </a>
                    <span class="text-slate-300">•</span>
                    <a href="/" class="text-slate-500 hover:text-blue-600 font-medium transition-colors">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full max-w-lg mx-auto text-center py-4 text-xs text-slate-500">
        &copy; {{ date('Y') }} BPMP Provinsi Sulawesi Tenggara
    </footer>

</body>
</html>
