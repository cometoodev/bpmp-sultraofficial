<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator - CMS BPMP Sultra</title>
    <link rel="icon" href="{{ asset('tutwurihandayani.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 selection:bg-blue-600 selection:text-white">

    <div class="min-h-screen flex flex-col items-center justify-center relative overflow-hidden py-12 px-4">
        
        <!-- Elemen Dekorasi Futuristik (Blur Blobs) di Background -->
        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-300/40 rounded-full mix-blend-multiply filter blur-[100px] opacity-70 animate-pulse pointer-events-none"></div>
        <div class="absolute top-[20%] right-[-10%] w-96 h-96 bg-indigo-300/40 rounded-full mix-blend-multiply filter blur-[100px] opacity-70 animate-pulse pointer-events-none" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-[-20%] left-[20%] w-96 h-96 bg-sky-300/40 rounded-full mix-blend-multiply filter blur-[100px] opacity-70 animate-pulse pointer-events-none" style="animation-delay: 4s;"></div>

        <!-- Header / Logo Area -->
        <div class="z-10 mb-8 text-center flex flex-col items-center">
            <a href="/" class="inline-flex items-center gap-3.5 group mb-4">
                <img src="{{ asset('tutwurihandayani.png') }}" alt="Logo Kemendikdasmen" class="h-14 w-14 transition-transform duration-300 group-hover:scale-105 drop-shadow-sm">
                <div class="text-left">
                    <span class="block text-2xl font-black tracking-tight" style="font-family:'Plus Jakarta Sans',sans-serif;">
                        <span class="text-blue-600">Kemen</span><span class="text-orange-500">dikdasmen</span>
                    </span>
                    <span class="text-xs font-semibold text-slate-600 tracking-wide block">BPMP Provinsi Sulawesi Tenggara</span>
                </div>
            </a>
            <span class="inline-block px-4 py-1.5 rounded-full bg-white/60 backdrop-blur-md border border-white/60 text-blue-700 text-xs font-bold tracking-wide shadow-sm">
                Content Management System
            </span>
        </div>

        <!-- KARTU LOGIN (LIGHT GLASSMORPHISM) -->
        <div class="z-10 w-full max-w-md p-8 sm:p-10 bg-white/40 backdrop-blur-2xl border border-white/60 shadow-[0_8px_32px_0_rgba(31,38,135,0.07)] rounded-[2.5rem]">
            <h2 class="text-2xl font-extrabold text-slate-800 mb-2" style="font-family:'Plus Jakarta Sans',sans-serif;">Masuk Administrator</h2>
            <p class="text-sm text-slate-500 mb-8 leading-relaxed">Silakan masukkan email dan kata sandi Anda untuk mengelola konten website BPMP Sultra.</p>

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50/80 backdrop-blur-sm border border-emerald-200/80 rounded-2xl text-emerald-700 text-xs flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-rose-50/80 backdrop-blur-sm border border-rose-200/80 rounded-2xl text-rose-700 text-xs">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- FORM -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Email -->
                <div class="mb-5">
                    <label for="email" class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full pl-11 pr-4 py-3.5 bg-white/60 border border-white/80 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:bg-white/90 transition-all text-slate-700 placeholder-slate-400 shadow-sm" placeholder="admin@bpmp.kemdikbud.go.id" required autofocus>
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input type="password" id="password" name="password" class="w-full pl-11 pr-4 py-3.5 bg-white/60 border border-white/80 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:bg-white/90 transition-all text-slate-700 placeholder-slate-400 shadow-sm" placeholder="••••••••" required>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-8 px-1">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 bg-white/50 border-slate-200 rounded focus:ring-blue-500 shadow-sm">
                        <span class="ml-2 text-sm text-slate-600 font-medium">Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <!-- Button -->
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-2xl shadow-[0_8px_20px_rgb(37,99,235,0.25)] hover:-translate-y-0.5 hover:shadow-[0_12px_25px_rgb(37,99,235,0.35)] transition-all duration-300 cursor-pointer">
                    Masuk ke Dashboard
                </button>
            </form>
            
            <div class="mt-8 text-center">
                <a href="/" class="text-sm text-slate-400 hover:text-blue-600 font-semibold transition-colors flex items-center justify-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Beranda Website
                </a>
            </div>
        </div>

        <!-- Footer Copyright -->
        <div class="z-10 mt-12 text-xs text-slate-400 font-medium">
            &copy; {{ date('Y') }} BPMP Provinsi Sulawesi Tenggara. All rights reserved.
        </div>
    </div>

</body>
</html>
