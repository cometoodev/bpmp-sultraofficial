<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita &amp; Publikasi - BPMP Provinsi Sulawesi Tenggara</title>
    <meta name="description" content="Dapatkan informasi terkini seputar kebijakan pendidikan, kegiatan operasional, dan program penjaminan mutu dari BPMP Provinsi Sulawesi Tenggara.">
    <link rel="icon" href="{{ asset('tutwurihandayani.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased overflow-x-hidden">

    {{-- NAVBAR --}}
    <x-navbar :alwaysScrolled="true" />

    {{-- HERO HEADER --}}
    <section class="bg-gradient-to-b from-blue-950 to-blue-900 pt-28 pb-14 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 20% 50%, #3b82f6 0%, transparent 60%), radial-gradient(circle at 80% 20%, #1d4ed8 0%, transparent 50%);"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-blue-200 text-xs font-semibold mb-5">
                <span>&#128240;</span>
                <span>Pusat Informasi Publik</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 leading-tight" style="font-family:'Plus Jakarta Sans',sans-serif;">
                Berita &amp; <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-300 to-blue-400">Publikasi</span> BPMP
            </h1>
            <p class="text-blue-200/80 text-base md:text-lg max-w-2xl mx-auto leading-relaxed">
                Dapatkan informasi terkini seputar kebijakan pendidikan, kegiatan operasional, dan program penjaminan mutu dari BPMP Provinsi Sulawesi Tenggara.
            </p>
            <div class="flex items-center justify-center gap-2 mt-6 text-xs text-blue-300/70 font-medium">
                <a href="/" class="hover:text-white transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-white">Berita &amp; Publikasi</span>
            </div>
        </div>
    </section>

    {{-- FILTER & SEARCH BAR --}}
    <div class="sticky top-[64px] z-40 bg-white/80 backdrop-blur-xl border-b border-gray-200/60 shadow-sm" x-data="{ activeTab: 'semua' }">
        <div class="container mx-auto px-4 py-3">
            <div class="flex flex-col md:flex-row items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-2">
                    <button @click="activeTab = 'semua'" :class="activeTab === 'semua' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all">Semua Kategori</button>
                    <button @click="activeTab = 'berita'" :class="activeTab === 'berita' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all">Berita Terkini</button>
                    <button @click="activeTab = 'artikel'" :class="activeTab === 'artikel' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all">Artikel</button>
                    <button @click="activeTab = 'program'" :class="activeTab === 'program' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all">Program Prioritas</button>
                    <button @click="activeTab = 'pengumuman'" :class="activeTab === 'pengumuman' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all">Pengumuman</button>
                    <button @click="activeTab = 'dokumentasi'" :class="activeTab === 'dokumentasi' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all">Dokumentasi</button>
                </div>
                <div class="relative w-full md:w-64">
                    <input type="search" placeholder="Ketik kata kunci..." class="w-full pl-9 pr-4 py-2 text-sm rounded-full bg-gray-100 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400/50 focus:bg-white transition-all">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <main class="container mx-auto px-4 py-12">
        <div class="flex items-center justify-between mb-8">
            <p class="text-sm text-gray-500 font-medium">Showing <strong class="text-gray-800">1</strong> to <strong class="text-gray-800">9</strong> of <strong class="text-gray-800">143</strong> results</p>
        </div>

        @php
        $articles = [
            ['id'=>1,'cat'=>'Berita Terkini','color'=>'bg-blue-600','title'=>'Sosialisasi Rapor Pendidikan 2026 di Kabupaten Konawe','date'=>'02 Okt 2026','excerpt'=>'KENDARI - BPMP Sultra menyelenggarakan kegiatan sosialisasi pemanfaatan Rapor Pendidikan untuk perencanaan berbasis data di tingkat daerah guna meningkatkan mutu...','img'=>'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&w=600&q=80'],
            ['id'=>2,'cat'=>'Program Prioritas','color'=>'bg-emerald-600','title'=>'Pendampingan Implementasi Kurikulum Merdeka di Sekolah Sasaran','date'=>'30 Sep 2026','excerpt'=>'KENDARI - Tim fasilitator BPMP Provinsi Sulawesi Tenggara melakukan pendampingan intensif bagi sekolah-sekolah sasaran IKM di wilayah kepulauan terluar...','img'=>'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=600&q=80'],
            ['id'=>3,'cat'=>'Dokumentasi','color'=>'bg-amber-500','title'=>'Kunjungan Kerja Tim Pusat ke BPMP Sultra','date'=>'30 Sep 2026','excerpt'=>'KENDARI - Menerima kunjungan tim dari kementerian pusat dalam rangka monitoring dan evaluasi penjaminan mutu pendidikan di Sulawesi Tenggara...','img'=>'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=600&q=80'],
            ['id'=>4,'cat'=>'Pengumuman','color'=>'bg-red-600','title'=>'Pengumuman Seleksi Fasilitator Sekolah Penggerak Angkatan IV','date'=>'29 Sep 2026','excerpt'=>'KENDARI - BPMP Provinsi Sulawesi Tenggara membuka pendaftaran seleksi fasilitator program Sekolah Penggerak angkatan keempat untuk tahun pelajaran 2026/2027...','img'=>'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=600&q=80'],
            ['id'=>5,'cat'=>'Artikel','color'=>'bg-purple-600','title'=>'Transformasi Pembelajaran: Refleksi Satu Tahun Kurikulum Merdeka','date'=>'28 Sep 2026','excerpt'=>'KENDARI - Satu tahun setelah implementasi penuh Kurikulum Merdeka, berbagai satuan pendidikan di Sulawesi Tenggara menunjukkan perkembangan signifikan...','img'=>'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=600&q=80'],
            ['id'=>6,'cat'=>'Program Prioritas','color'=>'bg-emerald-600','title'=>'Pelatihan Perencanaan Berbasis Data untuk Kepala Sekolah','date'=>'26 Sep 2026','excerpt'=>'KENDARI - BPMP Sultra menyelenggarakan pelatihan PBD bagi ratusan kepala sekolah dan pengawas dari 17 kabupaten/kota se-Sulawesi Tenggara...','img'=>'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=600&q=80'],
            ['id'=>7,'cat'=>'Berita Terkini','color'=>'bg-blue-600','title'=>'BPMP Sultra Raih Penghargaan ZI WBK dari Kemendikdasmen','date'=>'25 Sep 2026','excerpt'=>'KENDARI - BPMP Provinsi Sulawesi Tenggara kembali berhasil mempertahankan predikat Wilayah Bebas dari Korupsi dalam penilaian zona integritas tahun 2026...','img'=>'https://images.unsplash.com/photo-1531545514256-b1400bc00f31?auto=format&fit=crop&w=600&q=80'],
            ['id'=>8,'cat'=>'Dokumentasi','color'=>'bg-amber-500','title'=>'Galeri Kegiatan Bulan September 2026','date'=>'24 Sep 2026','excerpt'=>'KENDARI - Dokumentasi berbagai kegiatan BPMP Provinsi Sulawesi Tenggara selama bulan September 2026, mulai dari pendampingan sekolah hingga rapat koordinasi daerah...','img'=>'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=600&q=80'],
            ['id'=>9,'cat'=>'Artikel','color'=>'bg-purple-600','title'=>'Pentingnya Data Dalam Pengambilan Keputusan Pendidikan','date'=>'22 Sep 2026','excerpt'=>'KENDARI - Pemanfaatan data pendidikan secara akurat merupakan kunci keberhasilan dalam merumuskan kebijakan yang tepat sasaran dan berdampak nyata bagi peserta didik...','img'=>'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=600&q=80'],
        ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-7">
            @foreach($articles as $a)
            <article class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                <div class="relative overflow-hidden h-48">
                    <img src="{{ $a['img'] }}" alt="{{ $a['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <span class="absolute top-3 left-3 {{ $a['color'] }} text-white text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-1 rounded-full">{{ $a['cat'] }}</span>
                </div>
                <div class="p-5 flex flex-col flex-grow">
                    <div class="flex items-center gap-1.5 text-xs text-gray-400 font-medium mb-2">
                        <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $a['date'] }}
                    </div>
                    <h2 class="font-bold text-gray-900 text-base leading-snug mb-3 group-hover:text-blue-700 transition-colors line-clamp-2">{{ $a['title'] }}</h2>
                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 flex-grow mb-4">{{ $a['excerpt'] }}</p>
                    <div class="pt-4 border-t border-gray-100 mt-auto">
                        <a href="/berita/{{ $a['id'] }}" class="text-blue-600 font-bold text-sm hover:text-blue-800 inline-flex items-center gap-1 group-hover:gap-2 transition-all">Baca &rarr;</a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="flex items-center justify-center gap-1.5 mt-14">
            <button class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button class="w-9 h-9 flex items-center justify-center rounded-lg bg-blue-600 text-white font-bold text-sm shadow-md">1</button>
            <button class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 font-medium text-sm">2</button>
            <button class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 font-medium text-sm">3</button>
            <button class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 font-medium text-sm">4</button>
            <button class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 font-medium text-sm">5</button>
            <span class="text-gray-400 text-sm px-1">...</span>
            <button class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 font-medium text-sm">15</button>
            <button class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 font-medium text-sm">16</button>
            <button class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>
    </main>

    <footer class="bg-blue-950 py-8 mt-8">
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
