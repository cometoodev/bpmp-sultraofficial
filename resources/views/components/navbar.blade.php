@props(['alwaysScrolled' => false])

<!-- 4. Glassmorphism Navbar (Fixed to top to overlay Hero) -->
<style>
@keyframes marquee {
  0% { transform: translateX(100%); }
  100% { transform: translateX(-100%); }
}
.animate-marquee {
  display: inline-block;
  animation: marquee 25s linear infinite;
  white-space: nowrap;
}
</style>
<header class="fixed top-0 z-50 w-full transition-all duration-300" 
        x-data="{ mobileMenuOpen: false, scrolled: {{ $alwaysScrolled ? 'true' : 'false' }} }" 
        @scroll.window="if (!{{ $alwaysScrolled ? 'true' : 'false' }}) scrolled = (window.pageYOffset > 20)"
        :class="scrolled ? 'bg-white shadow-md border-b border-gray-200' : 'bg-white/10 backdrop-blur-md border-b border-white/20'">
    
    <!-- Top Bar -->
    <div class="hidden lg:flex items-center justify-between w-full px-6 lg:px-12 py-2 bg-slate-950/40 backdrop-blur-md border-b border-white/10 text-xs text-white/90 transition-all duration-300"
         :class="scrolled ? 'h-0 py-0 opacity-0 overflow-hidden border-none' : 'h-auto opacity-100'">
        
        <!-- Left: Email -->
        <div class="flex items-center gap-1.5 opacity-90 hover:opacity-100 transition-opacity whitespace-nowrap">
            <svg class="w-3.5 h-3.5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            <a href="mailto:bpmpsultra@kemendikdasmen.go.id" class="tracking-wide">bpmpsultra@kemendikdasmen.go.id</a>
        </div>
        
        <!-- Center: Marquee -->
        <div class="flex-1 px-8 overflow-hidden relative flex items-center justify-center opacity-85">
            <div class="w-full max-w-2xl overflow-hidden relative">
                <p class="animate-marquee tracking-wide">
                    Selamat Datang di Portal Resmi Balai Penjaminan Mutu Pendidikan (BPMP) Provinsi Sulawesi Tenggara &mdash; Menjamin Mutu Pendidikan Berkualitas dan Merata
                </p>
            </div>
        </div>

        <!-- Right: Social Icons -->
        <div class="flex items-center gap-3 shrink-0">
            <a href="https://www.tiktok.com/@bpmp.sulawesitenggara" target="_blank" class="p-1.5 rounded-full bg-white/5 hover:bg-white/20 transition-all opacity-80 hover:opacity-100 hover:text-blue-300">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.24-2.61.94-5.22 3.02-6.72 1.02-.74 2.27-1.15 3.51-1.25V13.3c-1.05.08-2.1.51-2.9 1.19-1.07 1.05-1.57 2.62-1.27 4.1.28 1.25 1.15 2.37 2.29 2.96 1.21.6 2.68.62 3.91.07 1.57-.75 2.5-2.39 2.55-4.14.08-3.41.03-6.82.04-10.23h-.01z"/></svg>
            </a>
            <a href="https://www.instagram.com/bpmpsultra/" target="_blank" class="p-1.5 rounded-full bg-white/5 hover:bg-white/20 transition-all opacity-80 hover:opacity-100 hover:text-pink-400">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.16c3.2 0 3.58.01 4.85.07 3.25.15 4.77 1.69 4.92 4.92.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.15 3.23-1.67 4.77-4.92 4.92-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-3.26-.15-4.77-1.7-4.92-4.92-.06-1.27-.07-1.64-.07-4.85s.01-3.58.07-4.85c.15-3.23 1.66-4.77 4.92-4.92 1.27-.06 1.64-.07 4.85-.07zm0-2.16C8.74 0 8.33.01 7.05.07 2.7.27.27 2.69.07 7.05.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.2 4.36 2.62 6.78 6.98 6.98 1.28.06 1.69.07 4.95.07s3.67-.01 4.95-.07c4.35-.2 6.78-2.62 6.98-6.98.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.2-4.35-2.62-6.78-6.98-6.98C15.67.01 15.26 0 12 0zm0 5.84a6.16 6.16 0 100 12.32 6.16 6.16 0 000-12.32zM12 16a4 4 0 110-8 4 4 0 010 8zm6.41-11.85a1.44 1.44 0 100 2.88 1.44 1.44 0 000-2.88z"/></svg>
            </a>
            <a href="https://www.youtube.com/@bpmpsultra" target="_blank" class="p-1.5 rounded-full bg-white/5 hover:bg-white/20 transition-all opacity-80 hover:opacity-100 hover:text-red-500">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.5 6.19a3 3 0 00-2.11-2.13C19.53 3.5 12 3.5 12 3.5s-7.53 0-9.39.56A3 3 0 00.5 6.19C0 8.07 0 12 0 12s0 3.93.5 5.81a3 3 0 002.11 2.13c1.86.56 9.39.56 9.39.56s7.53 0 9.39-.56a3 3 0 002.11-2.13c.5-1.88.5-5.81.5-5.81s0-3.93-.5-5.81zM9.55 15.56V8.44L15.64 12l-6.09 3.56z"/></svg>
            </a>
        </div>
    </div>

    <nav class="w-full flex items-center justify-between px-4 lg:px-8 py-3 relative z-50">
            
            <!-- 3. Logo Text -->
            <div class="flex items-center shrink-0 space-x-3">
                <a href="{{ url('/') }}" class="flex items-center gap-3 shrink-0 group">
                    <img src="{{ asset('tutwurihandayani.png') }}" alt="Logo BPMP" class="h-10 w-10 md:h-12 md:w-12 transition-transform duration-300 group-hover:scale-105 drop-shadow-md">
                    <div class="flex flex-col">
                        <span class="font-bold text-lg md:text-xl leading-tight tracking-tight whitespace-nowrap">
                            <span class="text-blue-600">Kemen</span><span class="text-orange-500">dikdasmen</span>
                        </span>
                        <span class="text-[11px] md:text-[12px] font-medium whitespace-nowrap" :class="scrolled ? 'text-gray-800' : 'text-gray-300'">BPMP Provinsi Sulawesi Tenggara</span>
                    </div>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center space-x-4 xl:space-x-6 text-sm font-medium" 
                 x-data="{ activeMenu: null }" 
                 @click.outside="activeMenu = null" 
                 @keydown.escape.window="activeMenu = null">

                <!-- A. PROFIL -->
                <div class="group" @mouseenter="activeMenu = 'profil'" @click="activeMenu = activeMenu === 'profil' ? null : 'profil'">
                    <button class="px-1.5 lg:px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
                        <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Profil
                        <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="activeMenu === 'profil' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    
                    <div x-show="activeMenu === 'profil'" 
                         x-transition:enter="transition ease-out duration-200" 
                         x-transition:enter-start="opacity-0 translate-y-2" 
                         x-transition:enter-end="opacity-100 translate-y-0" 
                         x-transition:leave="transition ease-in duration-150" 
                         x-transition:leave-start="opacity-100 translate-y-0" 
                         x-transition:leave-end="opacity-0 translate-y-2" 
                         class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[92vw] max-w-5xl rounded-2xl bg-white dark:bg-[#0f1b38] shadow-2xl border border-slate-100 dark:border-slate-800 p-6 md:p-8 z-50">
                        
                         <h3 class="text-xl font-bold text-blue-900 dark:text-blue-400">Profil</h3>
                         <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 mb-6 pb-2 border-b border-slate-100 dark:border-slate-800/80">Mengenal lebih dekat Balai Penjaminan Mutu Pendidikan Provinsi Sulawesi Tenggara</p>
                         
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">Profil Lembaga</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Gambaran umum dan identitas instansi.</p>
                                 </div>
                             </a>
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">Struktur Organisasi</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Susunan kepemimpinan dan tata kelola.</p>
                                 </div>
                             </a>
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">Profil Pegawai</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Mengenal sumber daya manusia dan tenaga kependidikan.</p>
                                 </div>
                             </a>
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">Visi Misi</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Arah, tujuan, dan komitmen lembaga.</p>
                                 </div>
                             </a>
                         </div>
                    </div>
                </div>

                <!-- B. PROGRAM -->
                <div class="group" @mouseenter="activeMenu = 'program'" @click="activeMenu = activeMenu === 'program' ? null : 'program'">
                    <button class="px-1.5 lg:px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
                        <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Program
                        <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="activeMenu === 'program' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    
                    <div x-show="activeMenu === 'program'" 
                         x-transition:enter="transition ease-out duration-200" 
                         x-transition:enter-start="opacity-0 translate-y-2" 
                         x-transition:enter-end="opacity-100 translate-y-0" 
                         x-transition:leave="transition ease-in duration-150" 
                         x-transition:leave-start="opacity-100 translate-y-0" 
                         x-transition:leave-end="opacity-0 translate-y-2" 
                         class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[92vw] max-w-5xl rounded-2xl bg-white dark:bg-[#0f1b38] shadow-2xl border border-slate-100 dark:border-slate-800 p-6 md:p-8 z-50">
                        
                         <h3 class="text-xl font-bold text-blue-900 dark:text-blue-400">Program Kerja</h3>
                         <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 mb-6 pb-2 border-b border-slate-100 dark:border-slate-800/80">Program prioritas penjaminan dan peningkatan mutu pendidikan</p>
                         
                         <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">Program Prioritas</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Fokus utama dan inisiatif strategis tahun berjalan.</p>
                                 </div>
                             </a>
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">Rapor Pendidikan</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Indikator capaian dan evaluasi mutu pendidikan.</p>
                                 </div>
                             </a>
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">PBD</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Perencanaan Berbasis Data untuk satuan pendidikan.</p>
                                 </div>
                             </a>
                         </div>
                    </div>
                </div>

                <!-- C. ULT -->
                <div class="group" @mouseenter="activeMenu = 'ult'" @click="activeMenu = activeMenu === 'ult' ? null : 'ult'">
                    <button class="px-1.5 lg:px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
                        <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        ULT
                        <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="activeMenu === 'ult' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    
                    <div x-show="activeMenu === 'ult'" 
                         x-transition:enter="transition ease-out duration-200" 
                         x-transition:enter-start="opacity-0 translate-y-2" 
                         x-transition:enter-end="opacity-100 translate-y-0" 
                         x-transition:leave="transition ease-in duration-150" 
                         x-transition:leave-start="opacity-100 translate-y-0" 
                         x-transition:leave-end="opacity-0 translate-y-2" 
                         class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[92vw] max-w-5xl rounded-2xl bg-white dark:bg-[#0f1b38] shadow-2xl border border-slate-100 dark:border-slate-800 p-6 md:p-8 z-50">
                        
                         <h3 class="text-xl font-bold text-blue-900 dark:text-blue-400">Unit Layanan Terpadu (ULT)</h3>
                         <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 mb-6 pb-2 border-b border-slate-100 dark:border-slate-800/80">Layanan keterbukaan informasi dan survei kepuasan masyarakat</p>
                         
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">Hasil SKM</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Laporan dan indeks Survei Kepuasan Masyarakat.</p>
                                 </div>
                             </a>
                         </div>
                    </div>
                </div>

                <!-- D. PUBLIKASI -->
                <div class="group" @mouseenter="activeMenu = 'publikasi'" @click="activeMenu = activeMenu === 'publikasi' ? null : 'publikasi'">
                    <button class="px-1.5 lg:px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
                        <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                        Publikasi
                        <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="activeMenu === 'publikasi' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    
                    <div x-show="activeMenu === 'publikasi'" 
                         x-transition:enter="transition ease-out duration-200" 
                         x-transition:enter-start="opacity-0 translate-y-2" 
                         x-transition:enter-end="opacity-100 translate-y-0" 
                         x-transition:leave="transition ease-in duration-150" 
                         x-transition:leave-start="opacity-100 translate-y-0" 
                         x-transition:leave-end="opacity-0 translate-y-2" 
                         class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[92vw] max-w-5xl rounded-2xl bg-white dark:bg-[#0f1b38] shadow-2xl border border-slate-100 dark:border-slate-800 p-6 md:p-8 z-50">
                        
                         <h3 class="text-xl font-bold text-blue-900 dark:text-blue-400">Publikasi</h3>
                         <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 mb-6 pb-2 border-b border-slate-100 dark:border-slate-800/80">Kumpulan dokumen, rilis berkala, artikel, dan materi edukasi</p>
                         
                         <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">SINONGGI</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Sistem Inovasi Online Berbagi Informasi BPMP Sultra.</p>
                                 </div>
                             </a>
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">Profil Mutu Pendidikan</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Data capaian dan profil mutu sekolah se-Sultra.</p>
                                 </div>
                             </a>
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">Regulasi dan Peraturan</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Himpunan undang-undang, permen, dan keputusan resmi.</p>
                                 </div>
                             </a>
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">Kisah Inspiratif</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Cerita sukses dan praktik baik insan pendidikan.</p>
                                 </div>
                             </a>
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">JURNAL</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Karya ilmiah dan penelitian pendidikan terakreditasi.</p>
                                 </div>
                             </a>
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">Majalah</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Edisi buletin dan majalah berkala instansi.</p>
                                 </div>
                             </a>
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">Artikel</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Opini, tulisan edukatif, dan analisis mutu.</p>
                                 </div>
                             </a>
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">Berita</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Kabar kegiatan terkini BPMP Provinsi Sulawesi Tenggara.</p>
                                 </div>
                             </a>
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">Goes to School</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Dokumentasi kunjungan edukasi langsung ke sekolah.</p>
                                 </div>
                             </a>
                         </div>
                    </div>
                </div>

                <!-- E. SAKIP -->
                <div class="group" @mouseenter="activeMenu = 'sakip'" @click="activeMenu = activeMenu === 'sakip' ? null : 'sakip'">
                    <button class="px-1.5 lg:px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
                        <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        SAKIP
                        <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="activeMenu === 'sakip' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    
                    <div x-show="activeMenu === 'sakip'" 
                         x-transition:enter="transition ease-out duration-200" 
                         x-transition:enter-start="opacity-0 translate-y-2" 
                         x-transition:enter-end="opacity-100 translate-y-0" 
                         x-transition:leave="transition ease-in duration-150" 
                         x-transition:leave-start="opacity-100 translate-y-0" 
                         x-transition:leave-end="opacity-0 translate-y-2" 
                         class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[92vw] max-w-5xl rounded-2xl bg-white dark:bg-[#0f1b38] shadow-2xl border border-slate-100 dark:border-slate-800 p-6 md:p-8 z-50">
                        
                         <h3 class="text-xl font-bold text-blue-900 dark:text-blue-400">SAKIP</h3>
                         <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 mb-6 pb-2 border-b border-slate-100 dark:border-slate-800/80">Transparansi dan akuntabilitas kinerja BPMP Sulawesi Tenggara</p>
                         
                         <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">RENSTRA</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Rencana Strategis jangka menengah lembaga.</p>
                                 </div>
                             </a>
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">PERJANJIAN KINERJA</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Komitmen capaian target kinerja tahunan.</p>
                                 </div>
                             </a>
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">LAKIN</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Laporan Akuntabilitas Kinerja Instansi Pemerintah.</p>
                                 </div>
                             </a>
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">LHE</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Laporan Hasil Evaluasi akuntabilitas kinerja.</p>
                                 </div>
                             </a>
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">LK</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Laporan Kinerja berkala.</p>
                                 </div>
                             </a>
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">DIPA 2026</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Daftar Isian Pelaksanaan Anggaran tahun 2026.</p>
                                 </div>
                             </a>
                         </div>
                    </div>
                </div>

                <!-- F. LINK TERKAIT -->
                <div class="group" @mouseenter="activeMenu = 'link'" @click="activeMenu = activeMenu === 'link' ? null : 'link'">
                    <button class="px-1.5 lg:px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
                        <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        Link Terkait
                        <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="activeMenu === 'link' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    
                    <div x-show="activeMenu === 'link'" 
                         x-transition:enter="transition ease-out duration-200" 
                         x-transition:enter-start="opacity-0 translate-y-2" 
                         x-transition:enter-end="opacity-100 translate-y-0" 
                         x-transition:leave="transition ease-in duration-150" 
                         x-transition:leave-start="opacity-100 translate-y-0" 
                         x-transition:leave-end="opacity-0 translate-y-2" 
                         class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[92vw] max-w-5xl rounded-2xl bg-white dark:bg-[#0f1b38] shadow-2xl border border-slate-100 dark:border-slate-800 p-6 md:p-8 z-50">
                        
                         <h3 class="text-xl font-bold text-blue-900 dark:text-blue-400">Link Terkait</h3>
                         <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 mb-6 pb-2 border-b border-slate-100 dark:border-slate-800/80">Akses cepat ke portal layanan kepegawaian dan pangkalan data pendidikan</p>
                         
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                             <!-- Panel 1 -->
                             <div class="bg-slate-50/70 dark:bg-slate-800/40 p-5 rounded-xl border border-slate-100 dark:border-slate-800">
                                 <h4 class="text-xs font-bold uppercase tracking-wider text-blue-700 dark:text-blue-400 mb-4">Layanan Kepegawaian</h4>
                                 <div class="space-y-2">
                                     <a href="#" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 dark:hover:bg-slate-700/50 transition-all group/item">
                                         <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                         </div>
                                         <span class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">e-SKP</span>
                                     </a>
                                     <a href="#" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 dark:hover:bg-slate-700/50 transition-all group/item">
                                         <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                         </div>
                                         <span class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">e-Kehadiran</span>
                                     </a>
                                     <a href="#" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 dark:hover:bg-slate-700/50 transition-all group/item">
                                         <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                         </div>
                                         <span class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">Portal Kemdikdasmen</span>
                                     </a>
                                 </div>
                             </div>
                             <!-- Panel 2 -->
                             <div class="bg-slate-50/70 dark:bg-slate-800/40 p-5 rounded-xl border border-slate-100 dark:border-slate-800">
                                 <h4 class="text-xs font-bold uppercase tracking-wider text-blue-700 dark:text-blue-400 mb-4">Layanan Data dan Informasi</h4>
                                 <div class="grid grid-cols-2 gap-2">
                                     <a href="#" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 dark:hover:bg-slate-700/50 transition-all group/item">
                                         <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                         </div>
                                         <span class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">Data Profil Sekolah</span>
                                     </a>
                                     <a href="#" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 dark:hover:bg-slate-700/50 transition-all group/item">
                                         <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                         </div>
                                         <span class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">Raport Pendidikan</span>
                                     </a>
                                     <a href="#" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 dark:hover:bg-slate-700/50 transition-all group/item">
                                         <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                         </div>
                                         <span class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">PMP</span>
                                     </a>
                                     <a href="#" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 dark:hover:bg-slate-700/50 transition-all group/item">
                                         <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                                         </div>
                                         <span class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">DAPODIK</span>
                                     </a>
                                     <a href="#" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 dark:hover:bg-slate-700/50 transition-all group/item">
                                         <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                         </div>
                                         <span class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">BOS</span>
                                     </a>
                                     <a href="#" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 dark:hover:bg-slate-700/50 transition-all group/item">
                                         <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                         </div>
                                         <span class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">Rumah Pendidikan</span>
                                     </a>
                                     <a href="#" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 dark:hover:bg-slate-700/50 transition-all group/item">
                                         <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                         </div>
                                         <span class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">SIBI</span>
                                     </a>
                                     <a href="#" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 dark:hover:bg-slate-700/50 transition-all group/item">
                                         <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                         </div>
                                         <span class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">Data Referensi</span>
                                     </a>
                                     <a href="#" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 dark:hover:bg-slate-700/50 transition-all group/item">
                                         <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                         </div>
                                         <span class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">PUSPEKA</span>
                                     </a>
                                 </div>
                             </div>
                         </div>
                    </div>
                </div>

                <!-- G. PPID (Direct Link) -->
                <div class="group" @mouseenter="activeMenu = null">
                    <a href="https://ppid-bpmpsultra.page.gd/" target="_blank" class="px-1.5 lg:px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
                        <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        PPID
                        <svg class="w-3.5 h-3.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                </div>

                <!-- H. ZI WBK -->
                <div class="group" @mouseenter="activeMenu = 'ziwbk'" @click="activeMenu = activeMenu === 'ziwbk' ? null : 'ziwbk'">
                    <button class="px-1.5 lg:px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
                        <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                        ZI WBK
                        <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="activeMenu === 'ziwbk' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    
                    <div x-show="activeMenu === 'ziwbk'" 
                         x-transition:enter="transition ease-out duration-200" 
                         x-transition:enter-start="opacity-0 translate-y-2" 
                         x-transition:enter-end="opacity-100 translate-y-0" 
                         x-transition:leave="transition ease-in duration-150" 
                         x-transition:leave-start="opacity-100 translate-y-0" 
                         x-transition:leave-end="opacity-0 translate-y-2" 
                         class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[92vw] max-w-5xl rounded-2xl bg-white dark:bg-[#0f1b38] shadow-2xl border border-slate-100 dark:border-slate-800 p-6 md:p-8 z-50">
                        
                         <h3 class="text-xl font-bold text-blue-900 dark:text-blue-400">Zona Integritas (WBK/WBBM)</h3>
                         <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 mb-6 pb-2 border-b border-slate-100 dark:border-slate-800/80">Pembangunan zona integritas menuju Wilayah Bebas dari Korupsi</p>
                         
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">Standar Pelayanan</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Maklumat standar mutu pelayanan.</p>
                                 </div>
                             </a>
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">Maklumat Pelayanan</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Pernyataan kesanggupan melayani dengan integritas.</p>
                                 </div>
                             </a>
                         </div>

                         <div class="mt-4 p-4 rounded-xl bg-slate-50/70 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                             <h4 class="text-xs font-bold uppercase tracking-wider text-blue-700 dark:text-blue-400 mb-4">Area Pemenuhan Zona Integritas</h4>
                             <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                 <a href="#" class="flex items-center gap-3 p-2 bg-white dark:bg-[#0f1b38] rounded-lg border border-slate-100 dark:border-slate-800/80 hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-sm transition-all group/sub">
                                     <div class="w-7 h-7 rounded bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                                         <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                     </div>
                                     <span class="text-xs font-semibold text-slate-700 dark:text-slate-200 group-hover/sub:text-blue-600">Manajemen Perubahan</span>
                                 </a>
                                 <a href="#" class="flex items-center gap-3 p-2 bg-white dark:bg-[#0f1b38] rounded-lg border border-slate-100 dark:border-slate-800/80 hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-sm transition-all group/sub">
                                     <div class="w-7 h-7 rounded bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                                         <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                     </div>
                                     <span class="text-xs font-semibold text-slate-700 dark:text-slate-200 group-hover/sub:text-blue-600">Penataan Tata Laksana</span>
                                 </a>
                                 <a href="#" class="flex items-center gap-3 p-2 bg-white dark:bg-[#0f1b38] rounded-lg border border-slate-100 dark:border-slate-800/80 hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-sm transition-all group/sub">
                                     <div class="w-7 h-7 rounded bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                                         <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                     </div>
                                     <span class="text-xs font-semibold text-slate-700 dark:text-slate-200 group-hover/sub:text-blue-600">Manajemen SDM</span>
                                 </a>
                                 <a href="#" class="flex items-center gap-3 p-2 bg-white dark:bg-[#0f1b38] rounded-lg border border-slate-100 dark:border-slate-800/80 hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-sm transition-all group/sub">
                                     <div class="w-7 h-7 rounded bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                                         <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                     </div>
                                     <span class="text-xs font-semibold text-slate-700 dark:text-slate-200 group-hover/sub:text-blue-600">Penguatan Akuntabilitas</span>
                                 </a>
                                 <a href="#" class="flex items-center gap-3 p-2 bg-white dark:bg-[#0f1b38] rounded-lg border border-slate-100 dark:border-slate-800/80 hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-sm transition-all group/sub">
                                     <div class="w-7 h-7 rounded bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                                         <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                     </div>
                                     <span class="text-xs font-semibold text-slate-700 dark:text-slate-200 group-hover/sub:text-blue-600">Penguatan Pengawasan</span>
                                 </a>
                                 <a href="#" class="flex items-center gap-3 p-2 bg-white dark:bg-[#0f1b38] rounded-lg border border-slate-100 dark:border-slate-800/80 hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-sm transition-all group/sub">
                                     <div class="w-7 h-7 rounded bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                                         <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                     </div>
                                     <span class="text-xs font-semibold text-slate-700 dark:text-slate-200 group-hover/sub:text-blue-600">Peningkatan Kualitas Layanan</span>
                                 </a>
                             </div>
                         </div>
                    </div>
                </div>

                <!-- I. PENGADUAN -->
                <div class="group" @mouseenter="activeMenu = 'pengaduan'" @click="activeMenu = activeMenu === 'pengaduan' ? null : 'pengaduan'">
                    <button class="px-1.5 lg:px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
                        <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                        Pengaduan
                        <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="activeMenu === 'pengaduan' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    
                    <div x-show="activeMenu === 'pengaduan'" 
                         x-transition:enter="transition ease-out duration-200" 
                         x-transition:enter-start="opacity-0 translate-y-2" 
                         x-transition:enter-end="opacity-100 translate-y-0" 
                         x-transition:leave="transition ease-in duration-150" 
                         x-transition:leave-start="opacity-100 translate-y-0" 
                         x-transition:leave-end="opacity-0 translate-y-2" 
                         class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[92vw] max-w-5xl rounded-2xl bg-white dark:bg-[#0f1b38] shadow-2xl border border-slate-100 dark:border-slate-800 p-6 md:p-8 z-50">
                        
                         <h3 class="text-xl font-bold text-blue-900 dark:text-blue-400">Saluran Pengaduan</h3>
                         <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 mb-6 pb-2 border-b border-slate-100 dark:border-slate-800/80">Kanal resmi penyampaian aspirasi, laporan, dan pengaduan masyarakat</p>
                         
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">SPMB</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Saluran Pengaduan Masyarakat Balai.</p>
                                 </div>
                             </a>
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">SP4N Lapor</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Sistem Pengelolaan Pengaduan Pelayanan Publik Nasional.</p>
                                 </div>
                             </a>
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">Lapor Gratifikasi</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Pelaporan penerimaan atau penolakan gratifikasi.</p>
                                 </div>
                             </a>
                             <a href="#" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/60 dark:hover:bg-slate-800/60 transition-all group/item">
                                 <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-slate-800 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0 group-hover/item:scale-110 transition-transform">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                 </div>
                                 <div>
                                     <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover/item:text-blue-600 transition-colors">Whistle Blowing System (WBS)</h4>
                                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Mekanisme pelaporan pelanggaran rahasia dan aman.</p>
                                 </div>
                             </a>
                         </div>
                    </div>
                </div>

                <!-- Hubungi Kami -->
                <div class="group" @mouseenter="activeMenu = null">
                    <a href="{{ url('/kontak') }}" class="px-1.5 lg:px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
                        <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Hubungi Kami
                    </a>
                </div>
            </div>
            <!-- Interactive Search Input -->
            <div class="flex items-center shrink-0 space-x-3">
                <div class="hidden lg:flex items-center shrink-0">
                    <div class="relative group">
                        <input type="search" placeholder="Pencarian..." class="border text-[12px] md:text-[13px] rounded-full pl-9 pr-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-400/50 focus:border-transparent transition-all duration-300 w-32 focus:w-48" :class="scrolled ? 'bg-gray-100 text-gray-800 border-gray-200 placeholder-gray-500' : 'bg-white/10 border-white/20 text-white placeholder-gray-300 backdrop-blur-sm'">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-3.5 w-3.5 transition-colors" :class="scrolled ? 'text-gray-500 group-focus-within:text-blue-600' : 'text-gray-300 group-focus-within:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-lg transition-colors" :class="scrolled ? 'text-gray-800 hover:bg-gray-100' : 'text-white hover:bg-white/10'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </nav>

    <!-- Mobile Menu Overlay -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 bg-black/50 lg:hidden" 
         @click="mobileMenuOpen = false" style="display: none;"></div>

    <!-- Mobile Menu Drawer -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed inset-y-0 left-0 z-50 w-full max-w-sm bg-white dark:bg-slate-900 shadow-xl lg:hidden flex flex-col h-full overflow-hidden" style="display: none;">
        
        <div class="flex items-center justify-between px-4 py-4 border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-center gap-2">
                <img src="{{ asset('tutwurihandayani.png') }}" alt="Logo BPMP" class="h-8 w-8">
                <span class="font-bold text-sm text-slate-800 dark:text-white">BPMP Sultra</span>
            </div>
            <button @click="mobileMenuOpen = false" class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto max-h-[85vh] px-4 py-6" x-data="{ activeAccordion: null }">
            <nav class="space-y-4">
                
                <!-- Profil -->
                <div class="border-b border-gray-100 dark:border-gray-800 pb-2">
                    <button @click="activeAccordion = activeAccordion === 'profil' ? null : 'profil'" class="flex items-center justify-between w-full text-left font-bold text-slate-800 dark:text-slate-200 py-2">
                        Profil
                        <svg class="w-4 h-4 transition-transform duration-200" :class="activeAccordion === 'profil' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="activeAccordion === 'profil'" x-collapse class="pl-4 space-y-2 mt-2 text-sm text-slate-600 dark:text-slate-400">
                        <a href="#" class="block py-1 hover:text-blue-600">Profil Lembaga</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Struktur Organisasi</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Profil Pegawai</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Visi Misi</a>
                    </div>
                </div>

                <!-- Program -->
                <div class="border-b border-gray-100 dark:border-gray-800 pb-2">
                    <button @click="activeAccordion = activeAccordion === 'program' ? null : 'program'" class="flex items-center justify-between w-full text-left font-bold text-slate-800 dark:text-slate-200 py-2">
                        Program
                        <svg class="w-4 h-4 transition-transform duration-200" :class="activeAccordion === 'program' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="activeAccordion === 'program'" x-collapse class="pl-4 space-y-2 mt-2 text-sm text-slate-600 dark:text-slate-400">
                        <a href="#" class="block py-1 hover:text-blue-600">Program Prioritas</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Rapor Pendidikan</a>
                        <a href="#" class="block py-1 hover:text-blue-600">PBD</a>
                    </div>
                </div>

                <!-- ULT -->
                <div class="border-b border-gray-100 dark:border-gray-800 pb-2">
                    <button @click="activeAccordion = activeAccordion === 'ult' ? null : 'ult'" class="flex items-center justify-between w-full text-left font-bold text-slate-800 dark:text-slate-200 py-2">
                        ULT
                        <svg class="w-4 h-4 transition-transform duration-200" :class="activeAccordion === 'ult' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="activeAccordion === 'ult'" x-collapse class="pl-4 space-y-2 mt-2 text-sm text-slate-600 dark:text-slate-400">
                        <a href="#" class="block py-1 hover:text-blue-600">Hasil SKM</a>
                    </div>
                </div>
                
                <!-- Publikasi -->
                <div class="border-b border-gray-100 dark:border-gray-800 pb-2">
                    <button @click="activeAccordion = activeAccordion === 'publikasi' ? null : 'publikasi'" class="flex items-center justify-between w-full text-left font-bold text-slate-800 dark:text-slate-200 py-2">
                        Publikasi
                        <svg class="w-4 h-4 transition-transform duration-200" :class="activeAccordion === 'publikasi' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="activeAccordion === 'publikasi'" x-collapse class="pl-4 space-y-2 mt-2 text-sm text-slate-600 dark:text-slate-400">
                        <a href="#" class="block py-1 hover:text-blue-600">SINONGGI</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Profil Mutu Pendidikan</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Regulasi dan Peraturan</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Kisah Inspiratif</a>
                        <a href="#" class="block py-1 hover:text-blue-600">JURNAL</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Majalah</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Artikel</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Berita</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Goes to School</a>
                    </div>
                </div>

                <!-- SAKIP -->
                <div class="border-b border-gray-100 dark:border-gray-800 pb-2">
                    <button @click="activeAccordion = activeAccordion === 'sakip' ? null : 'sakip'" class="flex items-center justify-between w-full text-left font-bold text-slate-800 dark:text-slate-200 py-2">
                        SAKIP
                        <svg class="w-4 h-4 transition-transform duration-200" :class="activeAccordion === 'sakip' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="activeAccordion === 'sakip'" x-collapse class="pl-4 space-y-2 mt-2 text-sm text-slate-600 dark:text-slate-400">
                        <a href="#" class="block py-1 hover:text-blue-600">RENSTRA</a>
                        <a href="#" class="block py-1 hover:text-blue-600">PERJANJIAN KINERJA</a>
                        <a href="#" class="block py-1 hover:text-blue-600">LAKIN</a>
                        <a href="#" class="block py-1 hover:text-blue-600">LHE</a>
                        <a href="#" class="block py-1 hover:text-blue-600">LK</a>
                        <a href="#" class="block py-1 hover:text-blue-600">DIPA 2026</a>
                    </div>
                </div>

                <!-- Link Terkait -->
                <div class="border-b border-gray-100 dark:border-gray-800 pb-2">
                    <button @click="activeAccordion = activeAccordion === 'link' ? null : 'link'" class="flex items-center justify-between w-full text-left font-bold text-slate-800 dark:text-slate-200 py-2">
                        Link Terkait
                        <svg class="w-4 h-4 transition-transform duration-200" :class="activeAccordion === 'link' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="activeAccordion === 'link'" x-collapse class="pl-4 space-y-2 mt-2 text-sm text-slate-600 dark:text-slate-400">
                        <a href="#" class="block py-1 hover:text-blue-600">e-SKP</a>
                        <a href="#" class="block py-1 hover:text-blue-600">e-Kehadiran</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Portal Kemdikdasmen</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Data Profil Sekolah</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Raport Pendidikan</a>
                        <a href="#" class="block py-1 hover:text-blue-600">PMP</a>
                        <a href="#" class="block py-1 hover:text-blue-600">DAPODIK</a>
                        <a href="#" class="block py-1 hover:text-blue-600">BOS</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Rumah Pendidikan</a>
                        <a href="#" class="block py-1 hover:text-blue-600">SIBI</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Data Referensi</a>
                        <a href="#" class="block py-1 hover:text-blue-600">PUSPEKA</a>
                    </div>
                </div>

                <!-- PPID -->
                <div class="border-b border-gray-100 dark:border-gray-800 pb-2">
                    <a href="https://ppid-bpmpsultra.page.gd/" target="_blank" class="block font-bold text-slate-800 dark:text-slate-200 py-2">PPID</a>
                </div>

                <!-- ZI WBK -->
                <div class="border-b border-gray-100 dark:border-gray-800 pb-2">
                    <button @click="activeAccordion = activeAccordion === 'ziwbk' ? null : 'ziwbk'" class="flex items-center justify-between w-full text-left font-bold text-slate-800 dark:text-slate-200 py-2">
                        ZI WBK
                        <svg class="w-4 h-4 transition-transform duration-200" :class="activeAccordion === 'ziwbk' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="activeAccordion === 'ziwbk'" x-collapse class="pl-4 space-y-2 mt-2 text-sm text-slate-600 dark:text-slate-400">
                        <a href="#" class="block py-1 hover:text-blue-600">Standar Pelayanan</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Maklumat Pelayanan</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Manajemen Perubahan</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Penataan Tata Laksana</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Manajemen SDM</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Penguatan Akuntabilitas</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Penguatan Pengawasan</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Peningkatan Kualitas Layanan</a>
                    </div>
                </div>
                
                <!-- Pengaduan -->
                <div class="border-b border-gray-100 dark:border-gray-800 pb-2">
                    <button @click="activeAccordion = activeAccordion === 'pengaduan' ? null : 'pengaduan'" class="flex items-center justify-between w-full text-left font-bold text-slate-800 dark:text-slate-200 py-2">
                        Pengaduan
                        <svg class="w-4 h-4 transition-transform duration-200" :class="activeAccordion === 'pengaduan' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="activeAccordion === 'pengaduan'" x-collapse class="pl-4 space-y-2 mt-2 text-sm text-slate-600 dark:text-slate-400">
                        <a href="#" class="block py-1 hover:text-blue-600">SPMB</a>
                        <a href="#" class="block py-1 hover:text-blue-600">SP4N Lapor</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Lapor Gratifikasi</a>
                        <a href="#" class="block py-1 hover:text-blue-600">Whistle Blowing System (WBS)</a>
                    </div>
                </div>

                <!-- Hubungi Kami -->
                <div class="border-b border-gray-100 dark:border-gray-800 pb-2">
                    <a href="{{ url('/kontak') }}" class="block font-bold text-slate-800 dark:text-slate-200 py-2">Hubungi Kami</a>
                </div>

            </nav>
        </div>
    </div>
</header>
