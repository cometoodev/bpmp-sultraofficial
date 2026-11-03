@php
    $generalSettings = \Illuminate\Support\Facades\DB::table('settings')->where('group', 'general')->pluck('value', 'key');
    $siteName = $generalSettings['site_name'] ?? 'BPMP Provinsi Sulawesi Tenggara';
@endphp
<footer class="bg-blue-950 pt-16 pb-10 border-t border-blue-900/40 text-slate-300">
    <div class="w-full max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 mb-12">
            <!-- Column 1: Brand & Visi -->
            <div>
                <div class="flex items-center gap-3 mb-5">
                    <img src="{{ asset('tutwurihandayani.png') }}" alt="Logo Kemendikdasmen" class="h-12 w-12 drop-shadow-md object-contain">
                    <div class="flex flex-col">
                        <span class="font-bold text-lg text-white leading-tight">BPMP SULTRA</span>
                        <span class="text-xs font-medium text-blue-300">Kemendikdasmen RI</span>
                    </div>
                </div>
                <p class="text-blue-100/70 text-sm leading-relaxed mb-5">
                    Mewujudkan pendidikan bermutu yang merata di seluruh wilayah Sulawesi Tenggara melalui penjaminan mutu yang berkelanjutan.
                </p>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1 bg-white/5 hover:bg-white/15 backdrop-blur-md rounded-xl text-xs font-bold text-white border border-white/10 hover:border-white/30 shadow-sm transition-all duration-300">BerAKHLAK</span>
                    <span class="px-3 py-1 bg-white/5 hover:bg-white/15 backdrop-blur-md rounded-xl text-xs font-bold text-white border border-white/10 hover:border-white/30 shadow-sm transition-all duration-300">#Bangga Melayani Bangsa</span>
                </div>
            </div>

            <!-- Column 2: Program & Layanan -->
            <div>
                <h4 class="font-bold text-white mb-5 uppercase tracking-wider text-xs">Program &amp; Layanan</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ url('/program-prioritas') }}" class="text-blue-100/70 hover:text-white transition-colors">Program Prioritas</a></li>
                    <li><a href="{{ url('/layanan-konsultasi-mutu') }}" class="text-blue-100/70 hover:text-white transition-colors">Layanan Konsultasi Mutu</a></li>
                    <li><a href="{{ url('/ult-unit-layanan-terpadu') }}" class="text-blue-100/70 hover:text-white transition-colors">Unit Layanan Terpadu (ULT)</a></li>
                    <li><a href="{{ url('/buku-tamu') }}" class="text-blue-100/70 hover:text-white transition-colors">Buku Tamu ULT</a></li>
                    <li><a href="{{ url('/hasil-skm') }}" class="text-blue-100/70 hover:text-white transition-colors">Hasil Survei SKM</a></li>
                </ul>
            </div>

            <!-- Column 3 & 4: Tautan Terkait -->
            <div class="lg:col-span-2">
                <h4 class="font-bold text-white mb-5 uppercase tracking-wider text-xs">Tautan Terkait</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2.5 text-sm">
                    <ul class="space-y-2.5">
                        <li><a href="https://kemdikbud.go.id" target="_blank" rel="noopener noreferrer" class="text-blue-100/70 hover:text-white transition-colors">Kemendikdasmen RI</a></li>
                        <li><a href="https://dapo.kemdikbud.go.id" target="_blank" rel="noopener noreferrer" class="text-blue-100/70 hover:text-white transition-colors">Dapodikdasmen</a></li>
                        <li><a href="https://raporpendidikan.kemdikbud.go.id" target="_blank" rel="noopener noreferrer" class="text-blue-100/70 hover:text-white transition-colors">Rapor Pendidikan</a></li>
                        <li><a href="https://guru.kemdikbud.go.id" target="_blank" rel="noopener noreferrer" class="text-blue-100/70 hover:text-white transition-colors">Platform Merdeka Mengajar</a></li>
                        <li><a href="https://pip.kemdikbud.go.id" target="_blank" rel="noopener noreferrer" class="text-blue-100/70 hover:text-white transition-colors">Program Indonesia Pintar</a></li>
                    </ul>
                    <ul class="space-y-2.5">
                        <li><a href="{{ url('/ppid') }}" class="text-blue-100/70 hover:text-white transition-colors">PPID BPMP Sultra</a></li>
                        <li><a href="{{ url('/zi-wbk') }}" class="text-blue-100/70 hover:text-white transition-colors">Zona Integritas (ZI-WBK)</a></li>
                        <li><a href="{{ url('/spmb') }}" class="text-blue-100/70 hover:text-white transition-colors">Pengaduan SPMB</a></li>
                        <li><a href="{{ url('/kontak') }}" class="text-blue-100/70 hover:text-white transition-colors">Kontak &amp; Alamat Lembaga</a></li>
                        <li><a href="https://wbs.kemdikbud.go.id" target="_blank" rel="noopener noreferrer" class="text-blue-100/70 hover:text-white transition-colors">Whistleblowing System</a></li>
                    </ul>
                </div>
            </div>

            <!-- Column 5: Kontak & Media Sosial -->
            <div>
                <h4 class="font-bold text-white mb-5 uppercase tracking-wider text-xs">Media Sosial</h4>
                <p class="text-xs text-blue-100/70 mb-4 leading-relaxed">Ikuti perkembangan dan publikasi terkini kami melalui akun resmi BPMP Sultra:</p>
                <div class="flex items-center gap-3 mb-6">
                    <a href="https://www.tiktok.com/@bpmp.sulawesitenggara" target="_blank" rel="noopener noreferrer" title="TikTok" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-black transition-all hover:scale-105">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.24-2.61.94-5.22 3.02-6.72 1.02-.74 2.27-1.15 3.51-1.25V13.3c-1.05.08-2.1.51-2.9 1.19-1.07 1.05-1.57 2.62-1.27 4.1.28 1.25 1.15 2.37 2.29 2.96 1.21.6 2.68.62 3.91.07 1.57-.75 2.5-2.39 2.55-4.14.08-3.41.03-6.82.04-10.23h-.01z"/></svg>
                    </a>
                    <a href="https://www.instagram.com/bpmpsultra/" target="_blank" rel="noopener noreferrer" title="Instagram" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-pink-600 transition-all hover:scale-105">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    <a href="https://www.youtube.com/@bpmpsultra" target="_blank" rel="noopener noreferrer" title="YouTube" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-red-600 transition-all hover:scale-105">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="pt-8 border-t border-blue-900/50 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-blue-200/60 font-medium">
            <p>&copy; {{ date('Y') }} {{ $siteName }}. Hak Cipta Dilindungi.</p>
            <div class="flex gap-6">
                <a href="{{ url('/') }}" class="hover:text-white transition-colors">Beranda</a>
                <a href="{{ url('/berita') }}" class="hover:text-white transition-colors">Berita</a>
                <a href="{{ url('/profil-lembaga') }}" class="hover:text-white transition-colors">Profil Lembaga</a>
            </div>
        </div>
    </div>
</footer>

