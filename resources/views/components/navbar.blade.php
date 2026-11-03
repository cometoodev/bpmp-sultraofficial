@props(['alwaysScrolled' => false, 'isPreview' => false])

<!-- Styles for running text marquee -->
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

<!-- Glassmorphism Main Header -->
<header class="fixed {{ $isPreview ? 'top-8' : 'top-0' }} z-50 w-full transition-all duration-300" 
        x-data="{ mobileMenuOpen: false, scrolled: {{ $alwaysScrolled ? 'true' : 'false' }} }" 
        @scroll.window="if (!{{ $alwaysScrolled ? 'true' : 'false' }}) scrolled = (window.pageYOffset > 20)"
        :class="scrolled ? 'bg-white shadow-md border-b border-gray-200' : 'bg-white/80 backdrop-blur-md border-b border-white/40 shadow-sm'">
    
    <!-- 1. Top Bar (Email, Marquee, Sosmed) -->
    @include('components.navbar.topbar')

    <!-- 2. Main Navigation Bar -->
    <nav class="w-full flex items-center justify-between px-4 lg:px-8 py-2.5 lg:py-3 relative z-50">
        
        <!-- Logo Brand -->
        <div class="flex items-center shrink-0 mr-3">
            <a href="{{ url('/') }}" class="flex items-center gap-3 shrink-0 group">
                <img src="{{ asset('tutwurihandayani.png') }}" 
                     alt="Logo BPMP" 
                     width="48" 
                     height="48"
                     style="max-width: 48px; max-height: 48px; object-fit: contain;"
                     class="h-10 w-10 md:h-12 md:w-12 transition-transform duration-300 group-hover:scale-105 drop-shadow-md">
                <div class="flex flex-col">
                    <span class="font-bold text-lg md:text-xl leading-tight tracking-tight whitespace-nowrap">
                        <span class="text-blue-600">Kemen</span><span class="text-orange-500">dikdasmen</span>
                    </span>
                    <span class="text-[11px] md:text-[12px] font-medium whitespace-nowrap text-slate-700">
                        BPMP Provinsi Sulawesi Tenggara
                    </span>
                </div>
            </a>
        </div>

        <!-- 3. Desktop Navigation & Mega Menu Cards -->
        @include('components.navbar.desktop-menu')

        <!-- 4. Interactive Search Bar & Mobile Hamburger -->
        <div class="flex items-center shrink-0 space-x-2 xl:space-x-3 ml-2">
            <!-- Search Form -->
            <form action="{{ route('berita.index') }}" method="GET" class="hidden lg:flex items-center shrink-0">
                <div class="relative group">
                    <input type="search" name="q" placeholder="Pencarian..." class="border border-slate-200/90 bg-slate-100/90 text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400 text-[12px] md:text-[13px] rounded-full pl-9 pr-3 py-1.5 transition-all duration-300 w-28 xl:w-36 focus:w-48">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-3.5 w-3.5 text-slate-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
            </form>

            <!-- Mobile Menu Toggle Button (Layar < lg) -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-lg text-slate-700 hover:text-slate-900 hover:bg-slate-100 transition-colors" aria-label="Buka Menu Navigasi">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>
    </nav>

    <!-- 5. Mobile Drawer Menu (Slide-in Accordion) -->
    @include('components.navbar.mobile-drawer')

</header>
