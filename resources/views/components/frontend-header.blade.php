@props(['isPreview' => false])
@php
    $settings = \Illuminate\Support\Facades\DB::table('settings')->where('group', 'general')->pluck('value', 'key');
    $menus = \App\Models\Menu::whereNull('parent_id')->where('status', true)->orderBy('order')->with(['children' => function($q){
        $q->where('status', true)->orderBy('order');
    }])->get();
@endphp

<!-- Single Bar Glassmorphism Header (Bungkus ke bawah otomatis jika overload) -->
<header class="fixed {{ $isPreview ? 'top-8' : 'top-0' }} z-50 w-full transition-all duration-300" 
        x-data="{ mobileMenuOpen: false, scrolled: false, openMenu: null }" 
        @scroll.window="scrolled = (window.pageYOffset > 20)"
        :class="scrolled ? 'bg-white shadow-md border-b border-gray-200' : 'bg-slate-900/85 backdrop-blur-md border-b border-white/20'">
    <nav class="w-full flex items-center justify-between px-4 lg:px-8 py-2.5 relative z-50">
        
        <!-- Logo -->
        <div class="flex items-center shrink-0 mr-3">
            <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0 group">
                <img src="{{ asset('tutwurihandayani.png') }}" alt="Logo BPMP" class="h-10 w-10 md:h-11 md:w-11 transition-transform duration-300 group-hover:scale-105 drop-shadow-md">
                <div class="flex flex-col">
                    <span class="font-bold text-base md:text-lg leading-tight tracking-tight whitespace-nowrap">
                        <span class="text-blue-500">Kemen</span><span class="text-orange-500">dikdasmen</span>
                    </span>
                    <span class="text-[11px] font-medium whitespace-nowrap transition-colors" :class="scrolled ? 'text-gray-700' : 'text-gray-300'">
                        {{ $settings['site_name'] ?? 'BPMP Provinsi Sulawesi Tenggara' }}
                    </span>
                </div>
            </a>
        </div>

        <!-- Desktop Menu: 1 Baris Utama, jika overload/banyak menu otomatis pindah ke baris bawahnya dan rata tengah (justify-center) -->
        <div class="hidden lg:flex items-center justify-center flex-wrap flex-1 gap-x-1.5 gap-y-1 mx-2 text-xs font-semibold">
            @foreach($menus as $menu)
                @if($menu->children->isEmpty())
                    <!-- Single Menu -->
                    <div class="relative group">
                        <a href="{{ $menu->url }}" target="{{ $menu->target }}" class="px-2 py-1.5 rounded-lg whitespace-nowrap transition-colors flex items-center" :class="scrolled ? 'text-gray-700 hover:text-blue-600 hover:bg-gray-100' : 'text-gray-100 hover:text-white hover:bg-white/10'">
                            {{ $menu->title }}
                        </a>
                    </div>
                @else
                    <!-- Dropdown Menu -->
                    <div class="relative" @mouseenter="openMenu = 'menu-{{ $menu->id }}'" @mouseleave="openMenu = null">
                        <button type="button" class="px-2 py-1.5 rounded-lg whitespace-nowrap transition-colors flex items-center gap-1 group" :class="scrolled ? 'text-gray-700 hover:text-blue-600 hover:bg-gray-100' : 'text-gray-100 hover:text-white hover:bg-white/10'">
                            <span>{{ $menu->title }}</span>
                            <svg class="w-3 h-3 opacity-70 transition-transform duration-200" :class="openMenu === 'menu-{{ $menu->id }}' ? 'rotate-180 text-blue-500' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="openMenu === 'menu-{{ $menu->id }}'" 
                             x-transition:enter="transition ease-out duration-150" 
                             x-transition:enter-start="opacity-0 translate-y-1" 
                             x-transition:enter-end="opacity-100 translate-y-0" 
                             x-transition:leave="transition ease-in duration-100" 
                             x-transition:leave-start="opacity-100 translate-y-0" 
                             x-transition:leave-end="opacity-0 translate-y-1" 
                             style="display: none;"
                             class="absolute left-0 mt-1 bg-white shadow-xl border border-gray-100 rounded-xl p-1.5 w-max min-w-[220px] text-gray-800 z-50">
                            @foreach($menu->children as $child)
                                <a href="{{ $child->url }}" target="{{ $child->target }}" class="block px-3.5 py-2 text-xs font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors whitespace-nowrap">
                                    {{ $child->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Search Bar & Mobile Toggle -->
        <div class="flex items-center shrink-0 space-x-2 ml-2">
            <div class="hidden sm:flex items-center shrink-0">
                <div class="relative group">
                    <input type="search" placeholder="Pencarian..." class="border text-xs rounded-full pl-8 pr-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all duration-300 w-28 lg:w-36 focus:w-48" :class="scrolled ? 'bg-gray-100 text-gray-800 border-gray-200 placeholder-gray-500' : 'bg-white/10 border-white/20 text-white placeholder-gray-300 backdrop-blur-sm'">
                    <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                        <svg class="h-3.5 w-3.5 transition-colors" :class="scrolled ? 'text-gray-500' : 'text-gray-300'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Button (Aktif di layar HP/tablet < lg) -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-lg transition-colors" :class="scrolled ? 'text-gray-800 hover:bg-gray-100' : 'text-white hover:bg-white/10'">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>
    </nav>

    <!-- Mobile Drawer Overlay & Sidebar -->
    <div x-show="mobileMenuOpen" 
         style="display: none;"
         class="lg:hidden fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm"
         @click="mobileMenuOpen = false"
         x-transition.opacity>
    </div>
    
    <div x-show="mobileMenuOpen"
         style="display: none;"
         class="lg:hidden fixed top-0 right-0 h-screen w-[290px] bg-white shadow-2xl z-50 flex flex-col overflow-y-auto"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full">
        
        <div class="flex items-center justify-between p-4 border-b border-gray-100 bg-gray-50">
            <span class="font-bold text-gray-800 text-sm">Menu Navigasi</span>
            <button @click="mobileMenuOpen = false" class="p-1.5 bg-white text-gray-500 hover:bg-gray-200 rounded-full border border-gray-200 shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto py-2">
            @foreach($menus as $menu)
                @if($menu->children->isEmpty())
                    <a href="{{ $menu->url }}" class="block px-5 py-2.5 text-xs font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 border-b border-gray-50">{{ $menu->title }}</a>
                @else
                    <div x-data="{ expanded: false }" class="border-b border-gray-50">
                        <button @click="expanded = !expanded" class="w-full flex items-center justify-between px-5 py-2.5 text-xs font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 focus:outline-none">
                            <span>{{ $menu->title }}</span>
                            <svg class="w-3.5 h-3.5 transition-transform" :class="expanded ? 'rotate-180 text-blue-600' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="expanded" style="display: none;" class="bg-gray-50 py-1 border-t border-gray-100">
                            @foreach($menu->children as $child)
                                <a href="{{ $child->url }}" class="block pl-9 pr-5 py-2 text-[11.5px] font-medium text-gray-600 hover:text-blue-600">{{ $child->title }}</a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        
        <div class="p-4 border-t border-gray-100 bg-gray-50">
            <div class="relative w-full">
                <input type="search" placeholder="Pencarian..." class="w-full border border-gray-200 bg-white text-xs rounded-xl pl-8 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                    <svg class="h-3.5 w-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </div>
    </div>
</header>
