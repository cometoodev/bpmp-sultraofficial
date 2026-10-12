@php
    $mobileMenus = \App\Models\Menu::whereNull('parent_id')
        ->where('status', true)
        ->orderBy('order')
        ->with(['children' => fn($q) => $q->where('status', true)->orderBy('order')])
        ->get();

    $getMenuIcon = function($title) {
        $slug = \Illuminate\Support\Str::slug($title);
        if (\Illuminate\Support\Str::contains($slug, 'profil')) {
            return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>';
        } elseif (\Illuminate\Support\Str::contains($slug, 'program')) {
            return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>';
        } elseif (\Illuminate\Support\Str::contains($slug, 'ult')) {
            return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>';
        } elseif (\Illuminate\Support\Str::contains($slug, 'publikasi')) {
            return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"/>';
        } elseif (\Illuminate\Support\Str::contains($slug, 'sakip')) {
            return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>';
        } elseif (\Illuminate\Support\Str::contains($slug, 'link')) {
            return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>';
        } elseif (\Illuminate\Support\Str::contains($slug, 'ppid')) {
            return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>';
        } elseif (\Illuminate\Support\Str::contains($slug, 'zi-wbk') || \Illuminate\Support\Str::contains($slug, 'zi')) {
            return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>';
        } elseif (\Illuminate\Support\Str::contains($slug, 'pengaduan')) {
            return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>';
        } else {
            return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>';
        }
    };
@endphp

<!-- Mobile Menu Overlay -->
<div x-show="mobileMenuOpen" 
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-xs lg:hidden" 
     @click="mobileMenuOpen = false" 
     style="display: none;"></div>

<!-- Mobile Menu Drawer -->
<div x-show="mobileMenuOpen" 
     x-transition:enter="transition ease-in-out duration-300 transform"
     x-transition:enter-start="-translate-x-full"
     x-transition:enter-end="translate-x-0"
     x-transition:leave="transition ease-in-out duration-300 transform"
     x-transition:leave-start="translate-x-0"
     x-transition:leave-end="-translate-x-full"
     class="fixed inset-y-0 left-0 z-50 w-full max-w-sm bg-white shadow-2xl lg:hidden flex flex-col h-full overflow-hidden text-slate-800" 
     style="display: none;">
    
    <!-- Drawer Header -->
    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 bg-slate-50">
        <div class="flex items-center gap-2.5">
            <img src="{{ asset('tutwurihandayani.png') }}" alt="Logo BPMP" class="h-8 w-8 drop-shadow-xs">
            <div class="flex flex-col">
                <span class="font-bold text-sm text-slate-800 leading-tight">BPMP Sultra</span>
                <span class="text-[10px] text-slate-500 font-medium">Kemendikdasmen</span>
            </div>
        </div>
        <button @click="mobileMenuOpen = false" class="p-1.5 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-200/60 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    
    <!-- Drawer Search Bar -->
    <div class="px-5 pt-4 pb-2">
        <form action="{{ route('berita.index') }}" method="GET">
            <div class="relative">
                <input type="search" name="q" placeholder="Cari info atau berita..." class="w-full text-xs bg-slate-100 border border-slate-200 rounded-xl pl-9 pr-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:bg-white transition-all text-slate-800 placeholder-slate-400">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </form>
    </div>

    <!-- Scrollable Accordion Content -->
    <div class="flex-1 overflow-y-auto px-5 py-4" x-data="{ activeAccordion: null }">
        <nav class="space-y-1.5 text-xs font-semibold">
            
            @foreach($mobileMenus as $m)
                @if($m->children->isEmpty())
                    <!-- Direct Link Menu -->
                    <div class="border-b border-gray-100 pb-1">
                        <a href="{{ $m->url }}" target="{{ $m->target }}" class="flex items-center gap-2 font-bold text-slate-800 py-2.5 hover:text-blue-600 transition-colors">
                            <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $getMenuIcon($m->title) !!}
                            </svg>
                            <span>{{ $m->title }}</span>
                            @if($m->target == '_blank')
                                <svg class="w-3.5 h-3.5 opacity-60 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            @endif
                        </a>
                    </div>
                @else
                    <!-- Accordion Dropdown Menu -->
                    <div class="border-b border-gray-100 pb-1">
                        <button @click="activeAccordion = activeAccordion === '{{ $m->id }}' ? null : '{{ $m->id }}'" class="flex items-center justify-between w-full text-left font-bold text-slate-800 py-2.5 hover:text-blue-600 transition-colors">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $getMenuIcon($m->title) !!}
                                </svg>
                                <span>{{ $m->title }}</span>
                            </span>
                            <svg class="w-4 h-4 transition-transform duration-200 opacity-60 shrink-0" :class="activeAccordion === '{{ $m->id }}' ? 'rotate-180 text-blue-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="activeAccordion === '{{ $m->id }}'" x-collapse class="pl-6 space-y-2 pb-2 text-slate-600 font-normal">
                            @foreach($m->children as $child)
                                <a href="{{ $child->url }}" target="{{ $child->target }}" class="flex items-center justify-between py-1 hover:text-blue-600 transition-colors">
                                    <span>{{ $child->title }}</span>
                                    @if($child->target == '_blank')
                                        <svg class="w-3 h-3 opacity-50 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach

        </nav>
    </div>
</div>
