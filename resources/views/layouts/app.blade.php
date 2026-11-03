@php
    $seo = \Illuminate\Support\Facades\DB::table('settings')->where('group', 'seo')->pluck('value', 'key');
    $general = \Illuminate\Support\Facades\DB::table('settings')->where('group', 'general')->pluck('value', 'key');
    $site_name = $general['site_name'] ?? ($seo['meta_title'] ?? 'BPMP Provinsi Sulawesi Tenggara');
    $pageModel = (isset($page) && is_object($page) && $page instanceof \App\Models\Page) ? $page : null;
@endphp
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $pageModel ? $pageModel->getSeoTitle() : 'Halaman') - {{ $site_name }}</title>
    <meta name="description" content="@yield('meta_description', $pageModel ? $pageModel->getSeoDescription() : ($seo['meta_description'] ?? ''))">
    <meta name="keywords" content="@yield('meta_keywords', $pageModel ? $pageModel->meta_keywords : ($seo['meta_keywords'] ?? ''))">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="@yield('title', $pageModel ? $pageModel->getSeoTitle() : 'Halaman')">
    <meta property="og:description" content="@yield('meta_description', $pageModel ? $pageModel->getSeoDescription() : ($seo['meta_description'] ?? ''))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $pageModel && $pageModel->featured_image ? Storage::disk('public')->url($pageModel->featured_image) : asset('tutwurihandayani.png') }}">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $pageModel ? $pageModel->getSeoTitle() : 'Halaman')">
    <meta name="twitter:description" content="@yield('meta_description', $pageModel ? $pageModel->getSeoDescription() : ($seo['meta_description'] ?? ''))">
    <meta name="twitter:image" content="{{ $pageModel && $pageModel->featured_image ? Storage::disk('public')->url($pageModel->featured_image) : asset('tutwurihandayani.png') }}">

    <link rel="icon" href="{{ asset('tutwurihandayani.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Mengaktifkan native smooth scrolling pada seluruh halaman */
        html {
            scroll-behavior: smooth;
        }

        /* Meredam loncatan scroll yang terlalu sensitif pada touchpad */
        body { 
            font-family: 'Poppins', sans-serif; 
            -webkit-overflow-scrolling: touch;
        }
    </style>
    @stack('styles')

    <!-- GLOBAL CSS OVERRIDE UNTUK KARTU CMS -->
    <style>
        .cms-master-wrapper .grid > a,
        .cms-master-wrapper .grid > button,
        .cms-master-wrapper .grid > div.bg-white,
        .cms-master-wrapper .grid > div.bg-slate-50,
        .cms-master-wrapper .grid > div.bg-slate-100 {
            border-radius: 2rem !important;
            overflow: hidden !important;
        }
        
        .cms-master-wrapper .grid > a > div:first-child,
        .cms-master-wrapper .grid > button > div:first-child,
        .cms-master-wrapper .grid > div > div:first-child,
        .cms-master-wrapper .grid > a > img,
        .cms-master-wrapper .grid > div > img {
            border-top-left-radius: 2rem !important;
            border-top-right-radius: 2rem !important;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased overflow-x-hidden selection:bg-blue-600 selection:text-white">

    @if(!empty($isPreview))
        <!-- Preview Mode Banner -->
        <div class="bg-amber-500 text-slate-950 px-4 py-2 text-center text-xs font-bold fixed top-0 inset-x-0 z-[60] shadow-md flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <span>MODE PRATINJAU (PREVIEW): Halaman ini berstatus draft dan belum dipublikasikan ke publik.</span>
            @if(isset($page))
                <a href="{{ route('admin.pages.edit', $page) }}" class="underline ml-2 hover:text-white">Kembali ke Editor</a>
            @endif
        </div>
    @endif

    {{-- NAVBAR --}}
    <x-navbar :alwaysScrolled="true" :isPreview="!empty($isPreview)" />

    {{-- MAIN CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER GLOBAL --}}
    <x-footer />

    <!-- KOMPONEN AKSESIBILITAS & FLOATING BUTTONS -->
    <x-accessibility />

    <!-- LIVE PREVIEW MODAL GLASSMORPHISM -->
    <div id="image-preview-modal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/40 backdrop-blur-md opacity-0 pointer-events-none transition-all duration-300">
        <img id="image-preview-src" src="" class="max-w-[90vw] max-h-[90vh] object-contain rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.3)] border border-white/20 scale-95 transition-transform duration-300" alt="Live Preview">
    </div>

    <!-- LIVE PREVIEW JAVASCRIPT LOGIC (LONG PRESS / HOLD) -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        let pressTimer;
        const modal = document.getElementById('image-preview-modal');
        const modalImg = document.getElementById('image-preview-src');
        const images = document.querySelectorAll('.live-preview, .prose img, .page-content img');

        if (modal && modalImg && images.length > 0) {
            const showModal = (src) => {
                modalImg.src = src;
                modal.classList.remove('opacity-0', 'pointer-events-none');
                modal.classList.add('opacity-100');
                modalImg.classList.remove('scale-95');
                modalImg.classList.add('scale-100');
            };

            const hideModal = () => {
                clearTimeout(pressTimer);
                modal.classList.remove('opacity-100');
                modal.classList.add('opacity-0', 'pointer-events-none');
                modalImg.classList.remove('scale-100');
                modalImg.classList.add('scale-95');
            };

            images.forEach(img => {
                img.classList.add('live-preview', 'cursor-pointer');

                img.addEventListener('mousedown', (e) => {
                    if (e.button === 0) {
                        pressTimer = setTimeout(() => showModal(e.target.src), 400);
                    }
                });
                img.addEventListener('mouseup', hideModal);
                img.addEventListener('mouseleave', hideModal);

                img.addEventListener('touchstart', (e) => {
                    pressTimer = setTimeout(() => showModal(e.target.src), 400);
                });
                img.addEventListener('touchend', hideModal);
                img.addEventListener('touchcancel', hideModal);
                
                img.addEventListener('contextmenu', (e) => e.preventDefault());
                img.addEventListener('dragstart', (e) => e.preventDefault());
            });
        }
    });
    </script>

    @stack('scripts')
</body>
</html>

