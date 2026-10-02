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
    <header class="fixed top-0 z-50 w-full bg-white shadow-md border-b border-gray-200" x-data="{ mobileMenuOpen: false }">
        <nav class="w-full flex items-center justify-between px-4 lg:px-8 py-3">
            <div class="flex items-center shrink-0 space-x-3">
                <a href="/" class="flex items-center gap-3 shrink-0 group">
                    <img src="{{ asset('tutwurihandayani.png') }}" alt="Logo BPMP" class="h-10 w-10 md:h-12 md:w-12 group-hover:scale-105 transition-transform drop-shadow-md">
                    <div class="flex flex-col">
                        <span class="font-bold text-lg md:text-xl leading-tight tracking-tight whitespace-nowrap">
                            <span class="text-blue-600">Kemen</span><span class="text-orange-500">dikdasmen</span>
                        </span>
                        <span class="text-[11px] md:text-[12px] font-medium whitespace-nowrap text-gray-800">BPMP Provinsi Sulawesi Tenggara</span>
                    </div>
                </a>
            </div>

            <div class="hidden lg:flex items-center space-x-1 xl:space-x-2 text-sm font-medium" x-data="{ openMenu: null }">
                <div class="relative" @mouseenter="openMenu = 'profil'" @mouseleave="openMenu = null">
                    <button class="px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap flex items-center gap-1 text-gray-700 hover:text-blue-600 transition-colors">
                        Profil
                        <svg class="w-3 h-3" :class="openMenu==='profil'?'rotate-180':''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openMenu === 'profil'" x-transition class="absolute left-0 mt-1 bg-white shadow-xl border border-gray-100 rounded-xl p-1.5 min-w-[180px] z-50">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 rounded-md">Profil Lembaga</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 rounded-md">Struktur Organisasi</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 rounded-md">Visi Misi</a>
                    </div>
                </div>
                <a href="/#layanan" class="px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap text-gray-700 hover:text-blue-600 transition-colors">Program</a>
                <a href="/#layanan" class="px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap text-gray-700 hover:text-blue-600 transition-colors">ULT</a>
                <a href="/berita" class="px-2 py-2 text-[11.5px] lg:text-[12.5px] font-bold whitespace-nowrap text-blue-600 border-b-2 border-blue-600">Berita</a>
                <a href="#" class="px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap text-gray-700 hover:text-blue-600 transition-colors">Publikasi</a>
                <a href="#" class="px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap text-gray-700 hover:text-blue-600 transition-colors">SAKIP</a>
                <a href="#" class="px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap text-gray-700 hover:text-blue-600 transition-colors">Link Terkait</a>
                <a href="#" class="px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap text-gray-700 hover:text-blue-600 transition-colors">PPID</a>
                <a href="#" class="px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap text-gray-700 hover:text-blue-600 transition-colors">ZI WBK</a>
                <a href="#" class="px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap text-gray-700 hover:text-blue-600 transition-colors">Pengaduan</a>
                <a href="/#kontak" class="px-2 py-2 text-[11.5px] lg:text-[12.5px] font-medium whitespace-nowrap text-gray-700 hover:text-blue-600 transition-colors">Hubungi Kami</a>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden lg:block relative">
                    <input type="search" placeholder="Pencarian..." class="border text-sm rounded-full pl-9 pr-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-400/50 transition-all w-36 focus:w-48 bg-gray-100 border-gray-200 placeholder-gray-400">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-3.5 w-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="xl:hidden p-2 rounded-lg text-gray-800 hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </nav>
    </header>

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

</body>
</html>
