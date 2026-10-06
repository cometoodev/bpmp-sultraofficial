<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Berita - BPMP Provinsi Sulawesi Tenggara</title>
    <link rel="icon" href="{{ asset('tutwurihandayani.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .prose-custom p { margin-bottom: 1.25rem; color: #374151; line-height: 1.8; }
        .prose-custom h2 { font-size: 1.25rem; font-weight: 700; color: #1e3a8a; margin-top: 2rem; margin-bottom: 0.75rem; }
        .prose-custom a { color: #2563eb; text-decoration: underline; }
    </style>
</head>
<body class="bg-gray-50 antialiased overflow-x-hidden">

    {{-- NAVBAR --}}
    <x-navbar :alwaysScrolled="true" />

    {{-- MAIN LAYOUT --}}
    <main class="pt-[80px] pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 text-xs text-gray-400 font-medium mb-8">
                <a href="/" class="hover:text-blue-600 transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <a href="/berita" class="hover:text-blue-600 transition-colors">Berita</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-gray-600">Sosialisasi Rapor Pendidikan 2026</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

                {{-- === LEFT: MAIN ARTICLE (lg:col-span-8) === --}}
                <div class="lg:col-span-8">

                    {{-- Category Pill --}}
                    <div class="mb-4">
                        <span class="inline-block bg-blue-600 text-white text-xs font-extrabold uppercase tracking-wider px-3 py-1.5 rounded-full">Berita Terkini</span>
                    </div>

                    {{-- Article Title --}}
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-blue-950 leading-tight mb-6" style="font-family:'Plus Jakarta Sans',sans-serif;">
                        Sosialisasi Rapor Pendidikan 2026 di Kabupaten Konawe
                    </h1>

                    {{-- Meta Data Row --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-5 mb-6 border-b border-gray-200">
                        {{-- Left: Date & Author --}}
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 font-medium">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                02 Oct 2026, 08:00 WITA
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Oleh <strong class="text-gray-800 ml-0.5">Admin BPMP</strong>
                            </span>
                        </div>

                        {{-- Right: Share Buttons --}}
                        <div class="flex items-center gap-2" x-data="{ copied: false }">
                            {{-- Facebook --}}
                            <a href="#" title="Bagikan ke Facebook" class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-200">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path></svg>
                            </a>
                            {{-- X (Twitter) --}}
                            <a href="#" title="Bagikan ke X" class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-900 hover:text-white hover:border-gray-900 transition-all duration-200">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path></svg>
                            </a>
                            {{-- WhatsApp --}}
                            <a href="#" title="Bagikan ke WhatsApp" class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-green-500 hover:text-white hover:border-green-500 transition-all duration-200">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"></path></svg>
                            </a>
                            {{-- Copy Link --}}
                            <button @click="copied = true; navigator.clipboard.writeText(window.location.href); setTimeout(() => copied = false, 2000)" title="Salin Tautan" class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-100 hover:text-blue-600 transition-all duration-200 relative">
                                <svg x-show="!copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                <svg x-show="copied" class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                        </div>
                    </div>

                    {{-- Main Cover Image --}}
                    <div class="rounded-2xl overflow-hidden mb-8 shadow-md">
                        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&w=1200&q=85" alt="Sosialisasi Rapor Pendidikan" class="w-full h-auto object-cover" style="max-height:480px;object-fit:cover;">
                    </div>

                    {{-- Article Content --}}
                    <div class="prose-custom text-gray-700">
                        <p>
                            <strong>KENDARI</strong> - Balai Penjaminan Mutu Pendidikan (BPMP) Provinsi Sulawesi Tenggara menyelenggarakan kegiatan sosialisasi pemanfaatan Rapor Pendidikan untuk perencanaan berbasis data (PBD) di tingkat daerah. Kegiatan ini berlangsung di Kabupaten Konawe dan dihadiri oleh ratusan kepala sekolah, pengawas, dan pejabat dinas pendidikan setempat.
                        </p>
                        <p>
                            Acara yang berlangsung selama dua hari tersebut bertujuan untuk meningkatkan kapasitas satuan pendidikan dalam memahami dan memanfaatkan data dari Rapor Pendidikan sebagai basis pengambilan keputusan yang lebih tepat sasaran dalam perbaikan mutu pendidikan di daerah.
                        </p>

                        <h2>Tujuan dan Manfaat Kegiatan</h2>
                        <p>
                            Kepala BPMP Provinsi Sulawesi Tenggara menyatakan bahwa kegiatan ini merupakan bagian dari upaya berkelanjutan untuk mendorong transformasi pendidikan yang berbasis data. "Kami ingin setiap kepala sekolah dan pengawas memiliki kemampuan membaca data Rapor Pendidikan secara mandiri, sehingga dapat merumuskan strategi peningkatan mutu yang tepat," ujarnya.
                        </p>
                        <p>
                            Peserta kegiatan mendapatkan pemahaman mendalam tentang cara mengakses, menginterpretasi, dan memanfaatkan berbagai indikator yang tersaji dalam platform Rapor Pendidikan. Mereka juga dipandu dalam mengidentifikasi masalah utama di satuan pendidikan masing-masing dan menyusun rencana tindak lanjut yang konkret dan terukur.
                        </p>

                        <h2>Antusiasme Peserta</h2>
                        <p>
                            Seluruh peserta menunjukkan antusiasme yang tinggi. Salah seorang kepala sekolah dari Kecamatan Anggaberi mengungkapkan bahwa kegiatan ini sangat membantu mereka dalam memahami kondisi riil sekolahnya. "Selama ini kami sering membuat program berdasarkan asumsi, tapi sekarang kami tahu harus fokus ke mana berdasarkan data yang ada," kata beliau.
                        </p>
                        <p>
                            Kegiatan sosialisasi ini juga dirangkaikan dengan sesi pendampingan langsung di mana tim fasilitator BPMP membantu peserta menganalisis data Rapor Pendidikan sekolah mereka masing-masing secara real-time, sehingga proses pembelajaran menjadi lebih kontekstual dan relevan.
                        </p>
                        <p>
                            Dengan terselenggaranya kegiatan ini, BPMP Provinsi Sulawesi Tenggara berharap semakin banyak satuan pendidikan yang mampu melaksanakan siklus penjaminan mutu secara mandiri dan berkelanjutan demi terwujudnya pendidikan yang berkualitas dan berkeadilan di seluruh wilayah Bumi Anoa.
                        </p>
                        <p class="text-gray-400 text-sm">(AAA)</p>
                    </div>

                    {{-- Back to list --}}
                    <div class="mt-10 pt-6 border-t border-gray-200">
                        <a href="/berita" class="inline-flex items-center gap-2 text-sm font-bold text-blue-600 hover:text-blue-800 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali ke Daftar Berita
                        </a>
                    </div>
                </div>

                {{-- === RIGHT: SIDEBAR (lg:col-span-4) === --}}
                <aside class="lg:col-span-4">
                    <div class="sticky top-[90px] space-y-6">

                        {{-- Berita Terkini Lainnya --}}
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-700 to-blue-900 px-5 py-4">
                                <h3 class="text-white font-bold text-sm tracking-wide">Berita Terkini Lainnya</h3>
                            </div>
                            <div class="divide-y divide-gray-100">
                                @php
                                $sidebar = [
                                    ['id'=>2,'cat'=>'Program Prioritas','cat_color'=>'text-emerald-600','title'=>'Pendampingan Implementasi Kurikulum Merdeka di Sekolah Sasaran','date'=>'30 Sep 2026','img'=>'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=160&q=80'],
                                    ['id'=>4,'cat'=>'Pengumuman','cat_color'=>'text-red-600','title'=>'Seleksi Fasilitator Sekolah Penggerak Angkatan IV Dibuka','date'=>'29 Sep 2026','img'=>'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=160&q=80'],
                                    ['id'=>5,'cat'=>'Artikel','cat_color'=>'text-purple-600','title'=>'Refleksi Satu Tahun Kurikulum Merdeka di Sulawesi Tenggara','date'=>'28 Sep 2026','img'=>'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=160&q=80'],
                                    ['id'=>7,'cat'=>'Berita Terkini','cat_color'=>'text-blue-600','title'=>'BPMP Sultra Raih Penghargaan ZI WBK dari Kemendikdasmen','date'=>'25 Sep 2026','img'=>'https://images.unsplash.com/photo-1531545514256-b1400bc00f31?auto=format&fit=crop&w=160&q=80'],
                                ];
                                @endphp
                                @foreach($sidebar as $s)
                                <a href="/berita/{{ $s['id'] }}" class="flex gap-3 p-4 hover:bg-gray-50 transition-colors group">
                                    <div class="w-16 h-16 shrink-0 rounded-xl overflow-hidden bg-gray-100">
                                        <img src="{{ $s['img'] }}" alt="{{ $s['title'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <span class="text-[10px] font-bold uppercase tracking-wider {{ $s['cat_color'] }}">{{ $s['cat'] }}</span>
                                        <p class="text-gray-800 text-xs font-semibold leading-snug mt-0.5 line-clamp-2 group-hover:text-blue-700 transition-colors">{{ $s['title'] }}</p>
                                        <span class="text-gray-400 text-[10px] font-medium mt-1 block">{{ $s['date'] }}</span>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                            <div class="px-5 py-4 bg-gray-50 border-t border-gray-100">
                                <a href="/berita" class="text-sm font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 transition-colors">
                                    Lihat Semua Berita
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>
                        </div>

                        {{-- Tags --}}
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                            <h3 class="font-bold text-gray-800 text-sm mb-3">Kategori</h3>
                            <div class="flex flex-wrap gap-2">
                                <a href="/berita" class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold hover:bg-blue-600 hover:text-white transition-colors">Berita Terkini</a>
                                <a href="/berita" class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold hover:bg-emerald-600 hover:text-white transition-colors">Program Prioritas</a>
                                <a href="/berita" class="px-3 py-1 rounded-full bg-purple-50 text-purple-700 text-xs font-semibold hover:bg-purple-600 hover:text-white transition-colors">Artikel</a>
                                <a href="/berita" class="px-3 py-1 rounded-full bg-red-50 text-red-700 text-xs font-semibold hover:bg-red-600 hover:text-white transition-colors">Pengumuman</a>
                                <a href="/berita" class="px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-semibold hover:bg-amber-500 hover:text-white transition-colors">Dokumentasi</a>
                            </div>
                        </div>

                    </div>
                </aside>
            </div>
        </div>
    </main>

    <footer class="bg-blue-950 py-8">
        <div class="container mx-auto px-4 text-center">
            <p class="text-sm text-blue-100/50 font-medium">&copy; 2026 BPMP Provinsi Sulawesi Tenggara. Hak Cipta Dilindungi.</p>
        </div>
    </footer>


    
    
    <!-- Native Accessibility Popup Modal & Trigger -->
    <div x-data="{ 
            openA11y: false,
            contrast: false,
            highlightLinks: false,
            biggerText: false,
            textSpacing: false,
            pauseAnimations: false,
            hideImages: false,
            dyslexia: false,
            bigCursor: false,
            lineHeight: false,
            textAlign: 0,
            saturation: false,
            toggle(setting) {
                this[setting] = !this[setting];
                this.applySettings();
            },
            cycleAlign() {
                this.textAlign = (this.textAlign + 1) % 3;
                this.applySettings();
            },
            reset() {
                this.contrast = false;
                this.highlightLinks = false;
                this.biggerText = false;
                this.textSpacing = false;
                this.pauseAnimations = false;
                this.hideImages = false;
                this.dyslexia = false;
                this.bigCursor = false;
                this.lineHeight = false;
                this.textAlign = 0;
                this.saturation = false;
                this.applySettings();
            },
            applySettings() {
                const b = document.body;
                b.style.filter = this.contrast ? 'contrast(150%)' : (this.saturation ? 'grayscale(100%)' : 'none');
                this.highlightLinks ? b.classList.add('a11y-highlight-links') : b.classList.remove('a11y-highlight-links');
                b.style.fontSize = this.biggerText ? '110%' : '';
                b.style.letterSpacing = this.textSpacing ? '0.1em' : '';
                b.style.wordSpacing = this.textSpacing ? '0.2em' : '';
                this.pauseAnimations ? b.classList.add('a11y-pause-animations') : b.classList.remove('a11y-pause-animations');
                this.hideImages ? b.classList.add('a11y-hide-images') : b.classList.remove('a11y-hide-images');
                b.style.fontFamily = this.dyslexia ? 'Arial, sans-serif' : '';
                this.bigCursor ? b.classList.add('a11y-big-cursor') : b.classList.remove('a11y-big-cursor');
                b.style.lineHeight = this.lineHeight ? '2' : '';
                if (this.textAlign === 1) b.style.textAlign = 'left';
                else if (this.textAlign === 2) b.style.textAlign = 'center';
                else b.style.textAlign = '';
                
                localStorage.setItem('a11ySettings', JSON.stringify({
                    contrast: this.contrast,
                    highlightLinks: this.highlightLinks,
                    biggerText: this.biggerText,
                    textSpacing: this.textSpacing,
                    pauseAnimations: this.pauseAnimations,
                    hideImages: this.hideImages,
                    dyslexia: this.dyslexia,
                    bigCursor: this.bigCursor,
                    lineHeight: this.lineHeight,
                    textAlign: this.textAlign,
                    saturation: this.saturation
                }));
            },
            init() {
                let saved = localStorage.getItem('a11ySettings');
                if (saved) {
                    try {
                        let s = JSON.parse(saved);
                        this.contrast = s.contrast || false;
                        this.highlightLinks = s.highlightLinks || false;
                        this.biggerText = s.biggerText || false;
                        this.textSpacing = s.textSpacing || false;
                        this.pauseAnimations = s.pauseAnimations || false;
                        this.hideImages = s.hideImages || false;
                        this.dyslexia = s.dyslexia || false;
                        this.bigCursor = s.bigCursor || false;
                        this.lineHeight = s.lineHeight || false;
                        this.textAlign = s.textAlign || 0;
                        this.saturation = s.saturation || false;
                        this.applySettings();
                    } catch(e) {}
                }
                
                window.addEventListener('keydown', (e) => {
                    if (e.ctrlKey && e.key.toLowerCase() === 'u') {
                        e.preventDefault();
                        this.openA11y = !this.openA11y;
                    }
                });
                
                if (!document.getElementById('a11y-styles')) {
                    const style = document.createElement('style');
                    style.id = 'a11y-styles';
                    style.innerHTML = `
                        .a11y-highlight-links a { text-decoration: underline !important; text-decoration-color: #fbbf24 !important; text-decoration-thickness: 3px !important; color: #d97706 !important; }
                        .a11y-pause-animations * { animation: none !important; transition: none !important; }
                        .a11y-hide-images img, .a11y-hide-images [style*="background-image"] { opacity: 0 !important; }
                        .a11y-big-cursor * { cursor: zoom-in !important; }
                        
                        @keyframes ripple-wave {
                          0% { transform: scale(0.95); opacity: 0.8; }
                          100% { transform: scale(1.6); opacity: 0; }
                        }
                        .animate-ripple {
                          animation: ripple-wave 2.4s cubic-bezier(0, 0.2, 0.8, 1) infinite;
                        }
                    `;
                    document.head.appendChild(style);
                }
            }
        }"
         class="fixed bottom-6 left-6 z-50 flex flex-col items-start"
         @keydown.escape.window="openA11y = false">
        
        <!-- Modal Container -->
        <div id="accessibility-modal"
             x-show="openA11y"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-6 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-6 scale-95"
             class="w-80 sm:w-96 bg-slate-50 dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden mb-4 transition-all"
             style="display: none; max-height: 85vh; overflow-y: auto;">
             
             <!-- Header -->
             <div class="bg-blue-600 text-white p-4 flex items-center justify-between sticky top-0 z-10">
                 <h4 class="font-bold text-sm sm:text-base flex items-center gap-2">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                     Accessibility Menu <span class="text-[10px] font-normal opacity-80 bg-blue-700 px-1.5 py-0.5 rounded">(CTRL+U)</span>
                 </h4>
                 <button @click="openA11y = false" class="w-7 h-7 rounded-full border border-white/30 flex items-center justify-center hover:bg-white/20 transition-colors">
                     <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                 </button>
             </div>
             
             <!-- Banner Button -->
             <button class="bg-blue-600 text-white text-xs font-bold py-2 px-4 rounded-xl flex items-center justify-center gap-2 mx-4 mt-4 w-[calc(100%-2rem)] shadow-sm hover:bg-blue-700 transition-colors">
                 <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> How UserWay Works
             </button>
             
             <!-- Oversized Widget Toggle -->
             <div class="flex items-center justify-between px-5 py-3 mt-2 text-xs font-semibold text-slate-700 dark:text-slate-300">
                 <span>Oversized Widget</span>
                 <div class="w-8 h-4 bg-slate-300 dark:bg-slate-600 rounded-full relative cursor-pointer">
                     <div class="w-4 h-4 bg-white rounded-full shadow absolute left-0 top-0 border border-slate-200"></div>
                 </div>
             </div>
             
             <!-- Grid Features -->
             <div class="grid grid-cols-2 gap-2.5 p-4 pt-0">
                 
                 <!-- Contrast + -->
                 <div @click="toggle('contrast')" :class="contrast ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <svg class="w-6 h-6 text-slate-700 dark:text-slate-200" :class="contrast ? 'text-blue-600 dark:text-blue-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2V4c-4.418 0-8 3.582-8 8s3.582 8 8 8z"></path></svg>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Contrast +</span>
                 </div>
                 
                 <!-- Highlight Links -->
                 <div @click="toggle('highlightLinks')" :class="highlightLinks ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <svg class="w-6 h-6 text-slate-700 dark:text-slate-200" :class="highlightLinks ? 'text-blue-600 dark:text-blue-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Highlight Links</span>
                 </div>
                 
                 <!-- Bigger Text -->
                 <div @click="toggle('biggerText')" :class="biggerText ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <div class="flex items-end text-slate-700 dark:text-slate-200 gap-0.5" :class="biggerText ? 'text-blue-600 dark:text-blue-400' : ''">
                         <span class="font-serif text-lg leading-none font-bold">T</span><span class="font-serif text-2xl leading-none font-bold">T</span>
                     </div>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Bigger Text</span>
                 </div>
                 
                 <!-- Text Spacing -->
                 <div @click="toggle('textSpacing')" :class="textSpacing ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <svg class="w-6 h-6 text-slate-700 dark:text-slate-200" :class="textSpacing ? 'text-blue-600 dark:text-blue-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l-4 3 4 3m8-6l4 3-4 3m-9-3h10"></path></svg>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Text Spacing</span>
                 </div>
                 
                 <!-- Pause Animations -->
                 <div @click="toggle('pauseAnimations')" :class="pauseAnimations ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <svg class="w-6 h-6 text-slate-700 dark:text-slate-200" :class="pauseAnimations ? 'text-blue-600 dark:text-blue-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Pause Animations</span>
                 </div>
                 
                 <!-- Hide Images -->
                 <div @click="toggle('hideImages')" :class="hideImages ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <svg class="w-6 h-6 text-slate-700 dark:text-slate-200 relative" :class="hideImages ? 'text-blue-600 dark:text-blue-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" class="text-red-500"></path></svg>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Hide Images</span>
                 </div>
                 
                 <!-- Dyslexia Friendly -->
                 <div @click="toggle('dyslexia')" :class="dyslexia ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <div class="w-6 h-6 bg-slate-100 dark:bg-slate-700 rounded flex items-center justify-center text-sm font-bold text-slate-700 dark:text-slate-200" :class="dyslexia ? 'text-blue-600 bg-blue-100 dark:text-blue-400 dark:bg-blue-900/40' : ''">Df</div>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Dyslexia Friendly</span>
                 </div>
                 
                 <!-- Cursor -->
                 <div @click="toggle('bigCursor')" :class="bigCursor ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <svg class="w-6 h-6 text-slate-700 dark:text-slate-200" :class="bigCursor ? 'text-blue-600 dark:text-blue-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Cursor</span>
                 </div>
                 
                 <!-- Tooltips -->
                 <div @click="toggle('tooltips')" :class="tooltips ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <svg class="w-6 h-6 text-slate-700 dark:text-slate-200" :class="tooltips ? 'text-blue-600 dark:text-blue-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Tooltips</span>
                 </div>
                 
                 <!-- Line Height -->
                 <div @click="toggle('lineHeight')" :class="lineHeight ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <svg class="w-6 h-6 text-slate-700 dark:text-slate-200" :class="lineHeight ? 'text-blue-600 dark:text-blue-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16M8 9l-4-3 4-3m8 12l4 3-4 3"></path></svg>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Line Height</span>
                 </div>
                 
                 <!-- Text Align -->
                 <div @click="cycleAlign()" :class="textAlign !== 0 ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <svg class="w-6 h-6 text-slate-700 dark:text-slate-200" :class="textAlign !== 0 ? 'text-blue-600 dark:text-blue-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h10M4 18h16"></path></svg>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Text Align</span>
                 </div>
                 
                 <!-- Saturation -->
                 <div @click="toggle('saturation')" :class="saturation ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-700/60'" class="bg-white dark:bg-slate-800 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-sm hover:border-blue-500 cursor-pointer transition-all border">
                     <svg class="w-6 h-6 text-slate-700 dark:text-slate-200" :class="saturation ? 'text-blue-600 dark:text-blue-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S12 3 12 3s-4.5 3.97-4.5 9 2.015 9 4.5 9zM9 12h6"></path></svg>
                     <span class="text-xs font-semibold text-slate-800 dark:text-slate-100 mt-2">Saturation</span>
                 </div>
                 
             </div>
             
             <!-- Bottom Action Buttons -->
             <button @click="reset()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-4 rounded-xl mx-4 mb-3 flex items-center justify-center gap-2 w-[calc(100%-2rem)] transition-colors shadow-sm">
                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                 Reset All Accessibility Settings
             </button>
             
             <!-- Footer Links -->
             <div class="px-5 pb-5 flex flex-col gap-2">
                 <a href="#" class="text-xs font-semibold text-blue-600 dark:text-blue-400 flex items-center gap-1 hover:underline">
                     Move/Hide Accessibility Widget
                     <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                 </a>
                 <div class="flex items-center gap-2 mt-1">
                     <span class="bg-slate-200 dark:bg-slate-700 text-[9px] font-bold px-1.5 py-0.5 rounded text-slate-600 dark:text-slate-300">MANAGE</span>
                     <span class="text-[10px] font-black tracking-widest text-blue-800 dark:text-blue-500">USERWAY</span>
                 </div>
             </div>
        </div>

        <!-- Floating Trigger Button (A11y) -->
        <div class="relative flex items-center justify-center w-14 h-14 mt-4">
            <span class="absolute inline-flex h-full w-full rounded-full bg-blue-500/40 animate-ripple pointer-events-none"></span>
            <button id="btn-accessibility" @click="openA11y = !openA11y" class="relative z-10 w-14 h-14 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-2xl flex items-center justify-center transition duration-300 transform hover:-translate-y-1 active:scale-95 focus:outline-none">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </button>
        </div>
    </div>

    <!-- Floating WhatsApp Helpdesk Popup -->
    <div x-data="{ openWA: false }" class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
        
        <!-- Popup Modal Card -->
        <div id="whatsapp-modal"
             x-show="openWA"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-6 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-6 scale-95"
             class="w-80 sm:w-96 rounded-3xl bg-white dark:bg-slate-900 shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden mb-4"
             style="display: none;">
            
            <!-- Header (Green Banner) -->
            <div class="bg-emerald-500 p-5 text-white flex items-center gap-3 rounded-t-3xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                <div>
                    <h4 class="text-base font-bold">Mulai Percakapan</h4>
                    <p class="text-xs text-emerald-100">Pilih saluran bantuan kami</p>
                </div>
            </div>

            <!-- Body Content -->
            <div class="pt-4 pb-2">
                <p class="text-xs font-medium text-slate-400 dark:text-slate-500 px-5 mb-3">Klik link dibawah ini :</p>
                
                <!-- Option 1: Helpdesk Kemdikbud -->
                <a href="https://wa.me/6281281435091" target="_blank" class="mx-4 mb-3 p-3.5 rounded-2xl bg-white dark:bg-slate-800 border-l-4 border-l-emerald-500 shadow-sm border border-slate-100 dark:border-slate-700/60 flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-800/80 transition cursor-pointer group">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 bg-emerald-500 text-white rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-slate-800 dark:text-slate-100">Helpdesk Kemdikbud</h5>
                            <p class="text-xs text-slate-500">+62 812-8143-5091</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-slate-300 group-hover:text-emerald-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>

                <!-- Option 2: ULT BPMP Sultra -->
                <a href="https://chat.whatsapp.com/CfzJauo1F17I5sTHXmme2L?mode=r_c" target="_blank" class="mx-4 mb-4 p-3.5 rounded-2xl bg-white dark:bg-slate-800 border-l-4 border-l-emerald-500 shadow-sm border border-slate-100 dark:border-slate-700/60 flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-800/80 transition cursor-pointer group">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 bg-teal-600 text-white rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-slate-800 dark:text-slate-100">ULT BPMP Sultra</h5>
                            <p class="text-xs text-slate-500">Grup WhatsApp Resmi</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-slate-300 group-hover:text-emerald-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>

        <!-- Floating Trigger Button (WhatsApp) -->
        <div class="relative flex items-center justify-center w-14 h-14 mt-4">
            <span class="absolute inline-flex h-full w-full rounded-full bg-emerald-500/40 animate-ripple pointer-events-none"></span>
            <button id="btn-whatsapp" @click="openWA = !openWA" class="relative z-10 w-14 h-14 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full shadow-2xl flex items-center justify-center transition duration-300 transform hover:-translate-y-1 active:scale-95 focus:outline-none">
                <!-- WhatsApp Icon (shows when closed) -->
                <svg x-show="!openWA" class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.559 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                <!-- Close Cross Icon (shows when open) -->
                <svg x-show="openWA" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>

</body>
</html>
