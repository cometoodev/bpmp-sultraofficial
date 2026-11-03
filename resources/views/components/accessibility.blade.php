<!-- ========================================== -->
<!-- 1. FLOATING BUTTONS (Aksesibilitas & WhatsApp) -->
<!-- ========================================== -->

<!-- Tombol Aksesibilitas di Pojok Kiri Bawah (Sesuai Referensi Gambar Mobile) -->
<div class="fixed bottom-6 left-6 z-[9999]">
    <button type="button" onclick="toggleAccessibilityMenu()" 
            aria-label="Buka Menu Aksesibilitas"
            title="Menu Aksesibilitas (Ctrl + U)"
            class="relative w-14 h-14 rounded-full bg-blue-600 text-white flex items-center justify-center shadow-2xl hover:bg-blue-700 transition-all duration-300 transform hover:scale-110 hover:-rotate-12 focus:outline-none cursor-pointer group">
        <!-- Ripple Pulse Wave Animation -->
        <span class="absolute inline-flex h-full w-full rounded-full bg-blue-500/50 animate-ping opacity-75 pointer-events-none"></span>
        <svg class="w-7 h-7 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
    </button>
</div>

<!-- FLOATING WHATSAPP WIDGET DENGAN POP-UP PILIHAN CHAT (Pojok Kanan Bawah) -->
<div class="fixed bottom-6 right-6 z-[9999] flex items-end gap-3" x-data="{ waOpen: false }" @keydown.escape.window="waOpen = false">

    <!-- 1. KOTAK BALON PESAN (Tampil saat belum diklik / waOpen = false) -->
    <div x-show="!waOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
         @click="waOpen = true"
         class="hidden sm:flex cursor-pointer bg-white/95 backdrop-blur-xl border border-slate-200/80 shadow-2xl rounded-2xl py-2.5 px-4 flex-col gap-0.5 hover:shadow-emerald-500/10 hover:border-emerald-300 transition-all group mb-1 select-none">
        <span class="text-xs font-bold text-slate-800 group-hover:text-emerald-600 transition-colors">Perlu Bantuan?</span>
        <span class="text-sm font-black text-slate-900 group-hover:text-emerald-700 transition-colors">Hubungi kami sekarang</span>
    </div>

    <!-- 2. KARTU POP-UP PILIHAN CHAT (Tampil saat diklik / waOpen = true) -->
    <div x-show="waOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         @click.away="waOpen = false"
         class="absolute bottom-20 right-0 w-80 bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden flex flex-col z-[10000]" 
         style="display: none;">
        
        <!-- Header Pop-up Hijau -->
        <div class="bg-emerald-500 text-white p-5 flex items-center gap-3 shadow-md">
            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
            </div>
            <div>
                <h4 class="font-black text-base text-white m-0 leading-tight">Mulai Percakapan</h4>
                <p class="text-xs text-emerald-100 m-0 opacity-90">Pilih layanan bantuan di bawah ini</p>
            </div>
        </div>

        <!-- Daftar Pilihan Kontak -->
        <div class="p-4 flex flex-col gap-3 bg-slate-50/50">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider px-1">Klik link dibawah ini :</span>

            <!-- Opsi 1: Helpdesk Kemdikbud -->
            <a href="https://api.whatsapp.com/send?phone=6281281435091" target="_blank" rel="noopener noreferrer"
               class="bg-white hover:bg-emerald-50/50 border border-slate-200/80 rounded-2xl p-3.5 flex items-center justify-between shadow-sm hover:border-emerald-300 transition-all group cursor-pointer">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="block font-extrabold text-slate-800 text-sm group-hover:text-emerald-600 transition-colors">Helpdesk Kemdikbud</span>
                        <span class="block text-[11px] text-slate-400">Online • Balas cepat</span>
                    </div>
                </div>
                <div class="text-emerald-500 font-bold text-xs bg-emerald-50 px-2.5 py-1 rounded-lg">Chat</div>
            </a>

            <!-- Opsi 2: ULT BPMP Sultra -->
            <a href="https://chat.whatsapp.com/CfzJauo1F17I5sTHXmme2L?mode=r_c" target="_blank" rel="noopener noreferrer"
               class="bg-white hover:bg-emerald-50/50 border border-slate-200/80 rounded-2xl p-3.5 flex items-center justify-between shadow-sm hover:border-emerald-300 transition-all group cursor-pointer">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="block font-extrabold text-slate-800 text-sm group-hover:text-emerald-600 transition-colors">ult bpmp sultra</span>
                        <span class="block text-[11px] text-slate-400">Grup Layanan Resmi</span>
                    </div>
                </div>
                <div class="text-emerald-500 font-bold text-xs bg-emerald-50 px-2.5 py-1 rounded-lg">Join</div>
            </a>
        </div>
    </div>

    <!-- 3. TOMBOL UTAMA WHATSAPP (Berubah menjadi ikon X saat diklik) -->
    <button type="button" @click="waOpen = !waOpen" 
            aria-label="Buka Chat WhatsApp"
            class="w-14 h-14 rounded-full bg-emerald-500 text-white flex items-center justify-center shadow-2xl hover:bg-emerald-600 transition-all duration-300 transform hover:scale-110 focus:outline-none relative group cursor-pointer shrink-0">
        
        <!-- Ikon WhatsApp (Tampil saat waOpen = false) -->
        <svg x-show="!waOpen" class="w-8 h-8 transition-transform duration-300 group-hover:rotate-12" fill="currentColor" viewBox="0 0 24 24">
            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
        </svg>

        <!-- Ikon Close / Silang (Tampil saat waOpen = true) -->
        <svg x-show="waOpen" class="w-7 h-7 transition-transform duration-300 rotate-0 hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

</div>

<!-- ========================================== -->
<!-- 2. PANEL MENU AKSESIBILITAS (Glassmorphism) -->
<!-- ========================================== -->
<div id="accessibilityModal" 
     class="fixed inset-0 z-[10000] flex justify-end bg-black/40 backdrop-blur-sm transition-all duration-500 opacity-0 pointer-events-none" 
     style="display: none;"
     onclick="if(event.target === this) toggleAccessibilityMenu()">
    
    <div id="accessibilityPanel" 
         class="w-full max-w-md bg-white/95 backdrop-blur-2xl h-full shadow-2xl flex flex-col transform translate-x-full transition-transform duration-500 ease-out overflow-y-auto border-l border-white/40">
        
        <!-- Header Menu -->
        <div class="bg-purple-700 text-white p-4 flex items-center justify-between sticky top-0 z-10 shadow-md">
            <div class="flex items-center gap-2 font-black text-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span>Menu Aksesibilitas</span>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" onclick="resetAccessibility()" title="Atur Ulang Pengaturan" class="hover:bg-purple-800 p-1.5 rounded-lg transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </button>
                <button type="button" onclick="toggleAccessibilityMenu()" title="Tutup Menu" class="hover:bg-purple-800 p-1.5 rounded-lg transition-colors cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Konten Isi Menu -->
        <div class="p-6 flex flex-col gap-6 text-slate-700">
            
            <!-- Kategori: Teks dan Membaca -->
            <div>
                <h4 class="text-xs font-black uppercase text-slate-400 tracking-wider mb-3">Teks dan Membaca</h4>
                
                <!-- Sesuaikan Ukuran Font -->
                <div class="bg-slate-50 border border-slate-200 p-4 rounded-2xl mb-3 shadow-sm">
                    <span class="block text-xs font-bold text-slate-600 mb-2">Sesuaikan Ukuran Font</span>
                    <div class="flex items-center justify-between gap-4">
                        <button type="button" onclick="changeFontSize(-10)" class="w-12 h-12 rounded-xl bg-white border border-slate-300 font-bold text-lg hover:bg-slate-100 shadow-sm transition-all cursor-pointer">-</button>
                        <span id="fontSizeDisplay" class="font-black text-lg text-slate-800">100%</span>
                        <button type="button" onclick="changeFontSize(10)" class="w-12 h-12 rounded-xl bg-white border border-slate-300 font-bold text-lg hover:bg-slate-100 shadow-sm transition-all cursor-pointer">+</button>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <!-- Font Disleksia -->
                    <button type="button" onclick="toggleDyslexiaFont()" id="btnDyslexia" class="flex flex-col items-center justify-center p-4 bg-slate-50 border border-slate-200 rounded-2xl hover:border-purple-500 hover:bg-purple-50/50 transition-all text-center gap-2 shadow-sm cursor-pointer">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        <span class="text-xs font-bold text-slate-700">Font Disleksia</span>
                    </button>

                    <!-- Sorot Tautan -->
                    <button type="button" onclick="toggleHighlightLinks()" id="btnHighlight" class="flex flex-col items-center justify-center p-4 bg-slate-50 border border-slate-200 rounded-2xl hover:border-purple-500 hover:bg-purple-50/50 transition-all text-center gap-2 shadow-sm cursor-pointer">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                        <span class="text-xs font-bold text-slate-700">Sorot Tautan</span>
                    </button>
                </div>

                <!-- Spasi Teks -->
                <button type="button" onclick="toggleTextSpacing()" id="btnSpacing" class="w-full mt-3 flex items-center justify-center gap-3 p-4 bg-slate-50 border border-slate-200 rounded-2xl hover:border-purple-500 hover:bg-purple-50/50 transition-all shadow-sm cursor-pointer">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                    <span class="text-xs font-bold text-slate-700">Spasi Teks Renggang</span>
                </button>
            </div>

            <!-- Kategori: Navigasi & Interaksi -->
            <div>
                <h4 class="text-xs font-black uppercase text-slate-400 tracking-wider mb-3">Navigasi dan Interaksi</h4>
                
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <!-- Bisukan Suara -->
                    <button type="button" onclick="toggleMuteAudio()" id="btnMute" class="flex flex-col items-center justify-center p-4 bg-slate-50 border border-slate-200 rounded-2xl hover:border-purple-500 hover:bg-purple-50/50 transition-all text-center gap-2 shadow-sm cursor-pointer">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"/>
                        </svg>
                        <span class="text-xs font-bold text-slate-700">Bisukan Suara</span>
                    </button>

                    <!-- Hentikan Animasi -->
                    <button type="button" onclick="toggleStopAnimations()" id="btnAnim" class="flex flex-col items-center justify-center p-4 bg-slate-50 border border-slate-200 rounded-2xl hover:border-purple-500 hover:bg-purple-50/50 transition-all text-center gap-2 shadow-sm cursor-pointer">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-xs font-bold text-slate-700">Hentikan Animasi</span>
                    </button>
                </div>

                <!-- Kursor Besar -->
                <button type="button" onclick="toggleBigCursor()" id="btnCursor" class="w-full mb-3 flex items-center justify-center gap-3 p-4 bg-slate-50 border border-slate-200 rounded-2xl hover:border-purple-500 hover:bg-purple-50/50 transition-all shadow-sm cursor-pointer">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                    </svg>
                    <span class="text-xs font-bold text-slate-700">Kursor Besar</span>
                </button>

                <!-- FITUR KHUSUS: Pengatur Kecepatan Gulir Touchpad (Smooth Scrolling Speed) -->
                <div class="bg-slate-50 border border-slate-200 p-4 rounded-2xl shadow-sm">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-slate-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7"/>
                            </svg>
                            Kecepatan Gulir Touchpad
                        </span>
                        <span id="speedValueLabel" class="text-xs font-black text-purple-600">Normal (1x)</span>
                    </div>
                    <input type="range" id="touchpadSpeedRange" min="0.3" max="2.5" step="0.1" value="1" 
                           class="w-full accent-purple-600 cursor-pointer" oninput="adjustTouchpadSpeed(this.value)">
                    <div class="flex justify-between text-[10px] text-slate-400 mt-1 font-semibold">
                        <span>Lambat (Halus)</span>
                        <span>Normal</span>
                        <span>Cepat</span>
                    </div>
                </div>

            </div>

        </div>

        <!-- Footer Reset -->
        <div class="p-4 bg-slate-50 border-t border-slate-200 mt-auto">
            <button type="button" onclick="resetAccessibility()" class="w-full py-3 bg-purple-700 text-white font-bold rounded-xl hover:bg-purple-800 transition-colors shadow-lg shadow-purple-600/30 text-sm cursor-pointer">
                Atur Ulang Pengaturan
            </button>
        </div>

    </div>
</div>

<!-- ========================================== -->
<!-- 3. SCRIPT LOGIKA JAVASCRIPT & INTERAKSI -->
<!-- ========================================== -->
<script>
let currentScale = 100;
let customScrollMultiplier = 1.0;

// Pulihkan pengaturan dari localStorage jika tersedia
document.addEventListener('DOMContentLoaded', function() {
    try {
        const savedSpeed = localStorage.getItem('touchpad_scroll_speed');
        if (savedSpeed) {
            adjustTouchpadSpeed(savedSpeed);
            const slider = document.getElementById('touchpadSpeedRange');
            if (slider) slider.value = savedSpeed;
        }
        const savedScale = localStorage.getItem('a11y_font_scale');
        if (savedScale) {
            currentScale = parseInt(savedScale, 10);
            document.documentElement.style.fontSize = currentScale + '%';
            const display = document.getElementById('fontSizeDisplay');
            if (display) display.innerText = currentScale + '%';
        }
    } catch(e) {}
});

function toggleAccessibilityMenu() {
    const modal = document.getElementById('accessibilityModal');
    const panel = document.getElementById('accessibilityPanel');
    if (!modal || !panel) return;
    
    if (modal.style.display === 'none' || modal.classList.contains('pointer-events-none')) {
        modal.style.display = 'flex';
        setTimeout(() => {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            panel.classList.remove('translate-x-full');
        }, 10);
    } else {
        modal.classList.add('opacity-0', 'pointer-events-none');
        panel.classList.add('translate-x-full');
        setTimeout(() => {
            modal.style.display = 'none';
        }, 500);
    }
}

// Pintasan Keyboard Escape & Ctrl + U
window.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('accessibilityModal');
        if (modal && modal.style.display !== 'none' && !modal.classList.contains('pointer-events-none')) {
            toggleAccessibilityMenu();
        }
    }
    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'u') {
        e.preventDefault();
        toggleAccessibilityMenu();
    }
});

function changeFontSize(amount) {
    currentScale += amount;
    if (currentScale < 80) currentScale = 80;
    if (currentScale > 150) currentScale = 150;
    
    document.documentElement.style.fontSize = currentScale + '%';
    const display = document.getElementById('fontSizeDisplay');
    if (display) display.innerText = currentScale + '%';
    try { localStorage.setItem('a11y_font_scale', currentScale); } catch(e){}
}

function toggleDyslexiaFont() {
    document.body.classList.toggle('font-dyslexic');
    const btn = document.getElementById('btnDyslexia');
    if (btn) {
        btn.classList.toggle('border-purple-600');
        btn.classList.toggle('bg-purple-50');
    }
}

function toggleHighlightLinks() {
    document.body.classList.toggle('highlight-links-mode');
    const btn = document.getElementById('btnHighlight');
    if (btn) {
        btn.classList.toggle('border-purple-600');
        btn.classList.toggle('bg-purple-50');
    }
}

function toggleTextSpacing() {
    document.body.classList.toggle('tracking-wide');
    document.body.classList.toggle('leading-loose');
    const btn = document.getElementById('btnSpacing');
    if (btn) {
        btn.classList.toggle('border-purple-600');
        btn.classList.toggle('bg-purple-50');
    }
}

function toggleMuteAudio() {
    const audios = document.querySelectorAll('audio, video');
    audios.forEach(el => el.muted = !el.muted);
    const btn = document.getElementById('btnMute');
    if (btn) {
        btn.classList.toggle('border-purple-600');
        btn.classList.toggle('bg-purple-50');
    }
}

function toggleStopAnimations() {
    document.body.classList.toggle('stop-animations');
    const btn = document.getElementById('btnAnim');
    if (btn) {
        btn.classList.toggle('border-purple-600');
        btn.classList.toggle('bg-purple-50');
    }
}

function toggleBigCursor() {
    document.body.classList.toggle('big-cursor');
    const btn = document.getElementById('btnCursor');
    if (btn) {
        btn.classList.toggle('border-purple-600');
        btn.classList.toggle('bg-purple-50');
    }
}

// Fitur Pengatur Kecepatan Gulir Touchpad (Smooth Scrolling Speed)
function adjustTouchpadSpeed(val) {
    customScrollMultiplier = parseFloat(val);
    const label = document.getElementById('speedValueLabel');
    if (label) {
        if (customScrollMultiplier === 1.0) {
            label.innerText = 'Normal (1x)';
        } else if (customScrollMultiplier < 1.0) {
            label.innerText = 'Lambat / Halus (' + val + 'x)';
        } else {
            label.innerText = 'Cepat (' + val + 'x)';
        }
    }
    try { localStorage.setItem('touchpad_scroll_speed', val); } catch(e){}
}

// Mencegat event wheel gulir untuk memberikan sensasi sensitivitas touchpad yang disesuaikan
window.addEventListener('wheel', function(e) {
    if (customScrollMultiplier !== 1.0 && !e.ctrlKey) {
        // Hanya atur jika bukan pinch-to-zoom
        if (Math.abs(e.deltaY) < 120) { // Ciri khas gesekan touchpad scroll halus
            window.scrollBy({
                top: e.deltaY * customScrollMultiplier,
                left: 0,
                behavior: 'auto'
            });
            e.preventDefault();
        }
    }
}, { passive: false });

function resetAccessibility() {
    currentScale = 100;
    customScrollMultiplier = 1.0;
    document.documentElement.style.fontSize = '100%';
    const display = document.getElementById('fontSizeDisplay');
    if (display) display.innerText = '100%';
    const slider = document.getElementById('touchpadSpeedRange');
    if (slider) slider.value = '1';
    const label = document.getElementById('speedValueLabel');
    if (label) label.innerText = 'Normal (1x)';
    
    document.body.classList.remove('font-dyslexic', 'highlight-links-mode', 'tracking-wide', 'leading-loose', 'stop-animations', 'big-cursor');
    
    document.querySelectorAll('[id^="btn"]').forEach(btn => {
        btn.classList.remove('border-purple-600', 'bg-purple-50');
    });

    try {
        localStorage.removeItem('touchpad_scroll_speed');
        localStorage.removeItem('a11y_font_scale');
    } catch(e) {}
}
</script>

<!-- ========================================== -->
<!-- 4. CSS TAMBAHAN UTILITY & EFEK ANIMASI     -->
<!-- ========================================== -->
<style>
/* Font Disleksia Simulasi & Utilitas */
.font-dyslexic { 
    font-family: 'Comic Sans MS', 'Arial Rounded MT Bold', sans-serif !important; 
    letter-spacing: 0.05em !important; 
}

/* Sorot Tautan */
.highlight-links-mode a { 
    background-color: #fef08a !important; 
    color: #1e1b4b !important; 
    text-decoration: underline !important; 
    text-decoration-thickness: 2px !important; 
    border-radius: 4px;
    padding: 0 2px;
}

/* Hentikan Animasi */
.stop-animations *, 
.stop-animations *::before, 
.stop-animations *::after {
    animation: none !important;
    transition: none !important;
}

/* Kursor Besar */
.big-cursor, 
.big-cursor * { 
    cursor: zoom-in !important; 
}
</style>
