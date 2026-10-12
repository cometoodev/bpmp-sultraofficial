@php
    $seo = \Illuminate\Support\Facades\DB::table('settings')->where('group', 'seo')->pluck('value', 'key');
    $site_name = $seo['meta_title'] ?? 'BPMP Provinsi Sulawesi Tenggara';
@endphp
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->getSeoTitle() }} - {{ $site_name }}</title>
    <meta name="description" content="{{ $page->getSeoDescription() ?: ($seo['meta_description'] ?? '') }}">
    <meta name="keywords" content="{{ $page->meta_keywords ?: ($seo['meta_keywords'] ?? '') }}">
    @if($page->meta_keywords)
        <meta name="keywords" content="{{ $page->meta_keywords }}">
    @endif

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $page->getSeoTitle() }}">
    <meta property="og:description" content="{{ $page->getSeoDescription() }}">
    <meta property="og:url" content="{{ url($page->slug) }}">
    <meta property="og:image" content="{{ $page->featured_image ? Storage::disk('public')->url($page->featured_image) : asset('tutwurihandayani.png') }}">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $page->getSeoTitle() }}">
    <meta name="twitter:description" content="{{ $page->getSeoDescription() }}">
    <meta name="twitter:image" content="{{ $page->featured_image ? Storage::disk('public')->url($page->featured_image) : asset('tutwurihandayani.png') }}">

    <link rel="icon" href="{{ asset('tutwurihandayani.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .page-content { color: #334155; line-height: 1.8; font-size: 0.95rem; }
        .page-content p { margin-bottom: 1.25rem; }
        .page-content h1, .page-content h2, .page-content h3, .page-content h4 { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: #0f172a; margin-top: 2rem; margin-bottom: 0.75rem; }
        .page-content h2 { font-size: 1.5rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; }
        .page-content h3 { font-size: 1.25rem; }
        .page-content ul { list-style-type: disc; margin-left: 1.5rem; margin-bottom: 1.25rem; }
        .page-content ol { list-style-type: decimal; margin-left: 1.5rem; margin-bottom: 1.25rem; }
        .page-content li { margin-bottom: 0.4rem; }
        .page-content a { color: #2563eb; text-decoration: underline; font-weight: 500; }
        .page-content blockquote { border-left: 4px solid #3b82f6; padding-left: 1rem; font-style: italic; color: #64748b; margin: 1.5rem 0; }
        .page-content img { border-radius: 0.75rem; max-width: 100%; height: auto; margin: 1.5rem auto; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased overflow-x-hidden selection:bg-blue-600 selection:text-white">

    @if(!empty($isPreview))
        <!-- Preview Mode Banner -->
        <div class="bg-amber-500 text-slate-950 px-4 py-2 text-center text-xs font-bold fixed top-0 inset-x-0 z-[60] shadow-md flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <span>MODE PRATINJAU (PREVIEW): Halaman ini berstatus draft dan belum dipublikasikan ke publik.</span>
            <a href="{{ route('admin.pages.edit', $page) }}" class="underline ml-2 hover:text-white">Kembali ke Editor</a>
        </div>
    @endif

    {{-- NAVBAR --}}
    <x-navbar :alwaysScrolled="true" :isPreview="!empty($isPreview)" />

    {{-- HERO HEADER --}}
    <section class="bg-gradient-to-b from-slate-950 via-blue-950 to-blue-900 {{ !empty($isPreview) ? 'pt-36' : 'pt-28' }} pb-14 relative overflow-hidden text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Breadcrumbs -->
            <div class="flex items-center gap-2 text-xs text-blue-200/70 font-medium mb-4">
                <a href="/" class="hover:text-white transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span>Halaman</span>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-white font-semibold">{{ $page->title }}</span>
            </div>

            <!-- Page Title -->
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white leading-tight" style="font-family:'Plus Jakarta Sans',sans-serif;">
                {{ $page->title }}
            </h1>

            <div class="flex flex-wrap items-center gap-4 mt-4 text-xs text-sky-200/80">
                @if($page->published_at)
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Diperbarui: {{ $page->updated_at->format('d M Y') }}</span>
                    </div>
                @endif
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <span>BPMP Provinsi Sulawesi Tenggara</span>
                </div>
            </div>

        </div>
    </section>

    {{-- MAIN CONTENT AREA --}}
    <main class="py-12">
        @if(($page->editor_mode ?? 'html') === 'visual')
            <!-- Visual Builder Content (Full Width) -->
            <div class="w-full">
                {!! $page->content !!}
            </div>
        @else
            <!-- Standard HTML Content with Constraints -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <article class="bg-white p-6 sm:p-10 rounded-3xl border border-slate-200/80 shadow-xs">
                    
                    @if($page->featured_image)
                        <div class="mb-8 rounded-2xl overflow-hidden shadow-md max-h-[460px]">
                            <img src="{{ Storage::disk('public')->url($page->featured_image) }}" alt="{{ $page->title }}" class="w-full h-full object-cover">
                        </div>
                    @endif

                    <div class="page-content">
                        {!! $page->content !!}
                    </div>

                    <!-- Share Section -->
                    <div class="mt-12 pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4">
                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Bagikan Informasi Ini:</span>
                        <div class="flex items-center gap-2">
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($page->title . ' - ' . url($page->slug)) }}" target="_blank"
                               class="px-3 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 rounded-lg text-xs font-semibold transition-colors flex items-center gap-1.5">
                                WhatsApp
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url($page->slug)) }}" target="_blank"
                               class="px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg text-xs font-semibold transition-colors flex items-center gap-1.5">
                                Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url($page->slug)) }}&text={{ urlencode($page->title) }}" target="_blank"
                               class="px-3 py-1.5 bg-sky-50 text-sky-700 hover:bg-sky-100 rounded-lg text-xs font-semibold transition-colors flex items-center gap-1.5">
                                X (Twitter)
                            </a>
                        </div>
                    </div>
                </article>
            </div>
        @endif
    </main>

    {{-- FOOTER --}}
    <footer class="bg-slate-900 text-slate-300 pt-12 pb-8 border-t border-slate-800 text-xs">
        @php
            $settings = \Illuminate\Support\Facades\DB::table('settings')->where('group', 'general')->pluck('value', 'key');
        @endphp
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 pb-8 border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('tutwurihandayani.png') }}" alt="Logo" class="h-10 w-10">
                    <div>
                        <p class="font-bold text-white text-sm">{{ $settings['site_name'] ?? 'BPMP Provinsi Sulawesi Tenggara' }}</p>
                        <p class="text-slate-400 text-[11px]">Kementerian Pendidikan Dasar dan Menengah Republik Indonesia</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 text-slate-400">
                    <a href="/" class="hover:text-white transition-colors">Beranda</a>
                    <a href="/berita" class="hover:text-white transition-colors">Berita</a>
                    <a href="{{ route('login') }}" class="hover:text-white transition-colors font-medium text-blue-400">Admin Login</a>
                </div>
            </div>
            <div class="pt-6 text-center text-slate-500 text-[11px]">
                {!! $settings['footer_copyright'] ?? '&copy; ' . date('Y') . ' BPMP Provinsi Sulawesi Tenggara. All rights reserved.' !!}
            </div>
        </div>
    </footer>

</body>
</html>
