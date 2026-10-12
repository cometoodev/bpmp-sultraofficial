@php
    $dbMenus = \App\Models\Menu::whereNull('parent_id')
        ->where('status', true)
        ->orderBy('order')
        ->with(['children' => fn($q) => $q->where('status', true)->orderBy('order')])
        ->get();

    $menuBySlug = [];
    foreach ($dbMenus as $m) {
        $slug = \Illuminate\Support\Str::slug($m->title);
        $menuBySlug[$slug] = $m;
    }

    $getChild = function($parentSlug, $childSlug, $fallbackTitle, $fallbackUrl, $fallbackTarget = '_self') use ($menuBySlug) {
        if (isset($menuBySlug[$parentSlug])) {
            foreach ($menuBySlug[$parentSlug]->children as $c) {
                $cSlug = \Illuminate\Support\Str::slug($c->title);
                if ($cSlug === $childSlug || \Illuminate\Support\Str::contains($cSlug, $childSlug) || \Illuminate\Support\Str::contains($childSlug, $cSlug)) {
                    return [
                        'title' => $c->title,
                        'url' => $c->url,
                        'target' => $c->target ?? '_self',
                    ];
                }
            }
        }
        return [
            'title' => $fallbackTitle,
            'url' => $fallbackUrl,
            'target' => $fallbackTarget,
        ];
    };

    $getParent = function($parentSlug, $fallbackTitle, $fallbackUrl = '#', $fallbackTarget = '_self') use ($menuBySlug) {
        if (isset($menuBySlug[$parentSlug])) {
            return [
                'title' => $menuBySlug[$parentSlug]->title,
                'url' => $menuBySlug[$parentSlug]->url,
                'target' => $menuBySlug[$parentSlug]->target ?? '_self',
            ];
        }
        return [
            'title' => $fallbackTitle,
            'url' => $fallbackUrl,
            'target' => $fallbackTarget,
        ];
    };

    $handledParents = ['profil', 'program', 'ult', 'publikasi', 'sakip', 'link-terkait', 'ppid', 'zi-wbk', 'pengaduan', 'hubungi-kami'];
@endphp

<!-- Desktop Menu: 1 Baris Utama, jika overload otomatis bungkus ke baris bawahnya & rata tengah -->
<div class="hidden lg:flex items-center justify-center flex-wrap gap-x-1.5 xl:gap-x-3 gap-y-1 text-sm font-medium" 
     x-data="{ activeMenu: null }" 
     @click.outside="activeMenu = null" 
     @keydown.escape.window="activeMenu = null">

    <!-- 1. PROFIL -->
    @if(isset($menuBySlug['profil']))
    @php $pProfil = $getParent('profil', 'Profil'); @endphp
    <div class="group" @mouseenter="activeMenu = 'profil'" @click="activeMenu = activeMenu === 'profil' ? null : 'profil'">
        <button class="px-2 xl:px-2.5 py-1.5 text-[11.5px] xl:text-[12.5px] font-semibold whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
            <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            {{ $pProfil['title'] }}
            <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="activeMenu === 'profil' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
        
        <div x-show="activeMenu === 'profil'" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0 translate-y-2" 
             x-transition:enter-end="opacity-100 translate-y-0" 
             x-transition:leave="transition ease-in duration-150" 
             x-transition:leave-start="opacity-100 translate-y-0" 
             x-transition:leave-end="opacity-0 translate-y-2" 
             style="display: none;"
             class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[92vw] max-w-5xl rounded-2xl bg-white shadow-2xl border border-slate-100 p-6 md:p-8 z-50 text-slate-800">
            
             <h3 class="text-xl font-bold text-blue-900">{{ $pProfil['title'] }}</h3>
             <p class="text-sm text-slate-500 mt-1 mb-6 pb-2 border-b border-slate-100">Mengenal lebih dekat Balai Penjaminan Mutu Pendidikan Provinsi Sulawesi Tenggara</p>
             
             <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                 @php $item = $getChild('profil', 'profil-lembaga', 'Profil Lembaga', '/profil-lembaga'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Gambaran umum dan identitas instansi.</p>
                     </div>
                 </a>
                 @php $item = $getChild('profil', 'struktur-organisasi', 'Struktur Organisasi', '/struktur-organisasi'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Susunan kepemimpinan dan tata kelola.</p>
                     </div>
                 </a>
                 @php $item = $getChild('profil', 'profil-pegawai', 'Profil Pegawai', '/profil-pegawai'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Mengenal sumber daya manusia dan tenaga kependidikan.</p>
                     </div>
                 </a>
                 @php $item = $getChild('profil', 'visi-misi', 'Visi Misi', '/visi-misi'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Arah, tujuan, dan komitmen lembaga.</p>
                     </div>
                 </a>
             </div>
        </div>
    </div>
    @endif

    <!-- 2. PROGRAM -->
    @if(isset($menuBySlug['program']))
    @php $pProgram = $getParent('program', 'Program'); @endphp
    <div class="group" @mouseenter="activeMenu = 'program'" @click="activeMenu = activeMenu === 'program' ? null : 'program'">
        <button class="px-2 xl:px-2.5 py-1.5 text-[11.5px] xl:text-[12.5px] font-semibold whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
            <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            {{ $pProgram['title'] }}
            <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="activeMenu === 'program' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
        
        <div x-show="activeMenu === 'program'" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0 translate-y-2" 
             x-transition:enter-end="opacity-100 translate-y-0" 
             x-transition:leave="transition ease-in duration-150" 
             x-transition:leave-start="opacity-100 translate-y-0" 
             x-transition:leave-end="opacity-0 translate-y-2" 
             style="display: none;"
             class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[92vw] max-w-5xl rounded-2xl bg-white shadow-2xl border border-slate-100 p-6 md:p-8 z-50 text-slate-800">
            
             <h3 class="text-xl font-bold text-blue-900">{{ $pProgram['title'] }}</h3>
             <p class="text-sm text-slate-500 mt-1 mb-6 pb-2 border-b border-slate-100">Program prioritas penjaminan dan peningkatan mutu pendidikan</p>
             
             <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                 @php $item = $getChild('program', 'program-prioritas', 'Program Prioritas', '/program-prioritas'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Fokus utama dan inisiatif strategis tahun berjalan.</p>
                     </div>
                 </a>
                 @php $item = $getChild('program', 'rapor-pendidikan', 'Rapor Pendidikan', '/rapor-pendidikan'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Indikator capaian dan evaluasi mutu pendidikan.</p>
                     </div>
                 </a>
                 @php $item = $getChild('program', 'pbd', 'PBD (Perencanaan Berbasis Data)', '/pbd-perencanaan-berbasis-data'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Perencanaan Berbasis Data untuk satuan pendidikan.</p>
                     </div>
                 </a>
             </div>
        </div>
    </div>
    @endif

    <!-- 3. ULT -->
    @if(isset($menuBySlug['ult']))
    @php $pUlt = $getParent('ult', 'ULT'); @endphp
    <div class="group" @mouseenter="activeMenu = 'ult'" @click="activeMenu = activeMenu === 'ult' ? null : 'ult'">
        <button class="px-2 xl:px-2.5 py-1.5 text-[11.5px] xl:text-[12.5px] font-semibold whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
            <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            {{ $pUlt['title'] }}
            <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="activeMenu === 'ult' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
        
        <div x-show="activeMenu === 'ult'" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0 translate-y-2" 
             x-transition:enter-end="opacity-100 translate-y-0" 
             x-transition:leave="transition ease-in duration-150" 
             x-transition:leave-start="opacity-100 translate-y-0" 
             x-transition:leave-end="opacity-0 translate-y-2" 
             style="display: none;"
             class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[92vw] max-w-5xl rounded-2xl bg-white shadow-2xl border border-slate-100 p-6 md:p-8 z-50 text-slate-800">
            
             <h3 class="text-xl font-bold text-blue-900">{{ $pUlt['title'] }} (Unit Layanan Terpadu)</h3>
             <p class="text-sm text-slate-500 mt-1 mb-6 pb-2 border-b border-slate-100">Layanan keterbukaan informasi dan survei kepuasan masyarakat</p>
             
             <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                 @php $item = $getChild('ult', 'unit-layanan-terpadu', 'Unit Layanan Terpadu', '/ult-unit-layanan-terpadu'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Profil layanan terpadu dan informasi prosedur.</p>
                     </div>
                 </a>
                 @php $item = $getChild('ult', 'hasil-skm', 'Hasil SKM', '/hasil-skm'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Laporan dan indeks Survei Kepuasan Masyarakat.</p>
                     </div>
                 </a>
             </div>
        </div>
    </div>
    @endif

    <!-- 4. PUBLIKASI -->
    @if(isset($menuBySlug['publikasi']))
    @php $pPublikasi = $getParent('publikasi', 'Publikasi'); @endphp
    <div class="group" @mouseenter="activeMenu = 'publikasi'" @click="activeMenu = activeMenu === 'publikasi' ? null : 'publikasi'">
        <button class="px-2 xl:px-2.5 py-1.5 text-[11.5px] xl:text-[12.5px] font-semibold whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
            <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
            {{ $pPublikasi['title'] }}
            <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="activeMenu === 'publikasi' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
        
        <div x-show="activeMenu === 'publikasi'" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0 translate-y-2" 
             x-transition:enter-end="opacity-100 translate-y-0" 
             x-transition:leave="transition ease-in duration-150" 
             x-transition:leave-start="opacity-100 translate-y-0" 
             x-transition:leave-end="opacity-0 translate-y-2" 
             style="display: none;"
             class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[92vw] max-w-5xl rounded-2xl bg-white shadow-2xl border border-slate-100 p-6 md:p-8 z-50 text-slate-800">
            
             <h3 class="text-xl font-bold text-blue-900">{{ $pPublikasi['title'] }}</h3>
             <p class="text-sm text-slate-500 mt-1 mb-6 pb-2 border-b border-slate-100">Kumpulan dokumen, rilis berkala, artikel, dan materi edukasi</p>
             
             <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                 @php $item = $getChild('publikasi', 'sinonggi', 'SINONGGI', '/sinonggi'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Sistem Inovasi Online Berbagi Informasi BPMP Sultra.</p>
                     </div>
                 </a>
                 @php $item = $getChild('publikasi', 'profil-mutu-pendidikan', 'Profil Mutu Pendidikan', '/profil-mutu-pendidikan'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Data capaian dan profil mutu sekolah se-Sultra.</p>
                     </div>
                 </a>
                 @php $item = $getChild('publikasi', 'regulasi-dan-peraturan', 'Regulasi dan Peraturan', '/regulasi-dan-peraturan'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Himpunan undang-undang, permen, dan keputusan resmi.</p>
                     </div>
                 </a>
                 @php $item = $getChild('publikasi', 'kisah-inspiratif', 'Kisah Inspiratif', '/kisah-inspiratif'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Cerita sukses dan praktik baik insan pendidikan.</p>
                     </div>
                 </a>
                 @php $item = $getChild('publikasi', 'jurnal', 'JURNAL', '/jurnal'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Karya ilmiah dan penelitian pendidikan terakreditasi.</p>
                     </div>
                 </a>
                 @php $item = $getChild('publikasi', 'majalah', 'Majalah', '/majalah'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Edisi buletin dan majalah berkala instansi.</p>
                     </div>
                 </a>
                 @php $item = $getChild('publikasi', 'artikel', 'Artikel', '/berita?kategori=artikel'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Opini, tulisan edukatif, dan analisis mutu.</p>
                     </div>
                 </a>
                 @php $item = $getChild('publikasi', 'berita', 'Berita', '/berita'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Kabar kegiatan terkini BPMP Provinsi Sulawesi Tenggara.</p>
                     </div>
                 </a>
                 @php $item = $getChild('publikasi', 'goes-to-school', 'Goes to School', '/goes-to-school'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Dokumentasi kunjungan edukasi langsung ke sekolah.</p>
                     </div>
                 </a>
             </div>
        </div>
    </div>
    @endif

    <!-- 5. SAKIP -->
    @if(isset($menuBySlug['sakip']))
    @php $pSakip = $getParent('sakip', 'SAKIP'); @endphp
    <div class="group" @mouseenter="activeMenu = 'sakip'" @click="activeMenu = activeMenu === 'sakip' ? null : 'sakip'">
        <button class="px-2 xl:px-2.5 py-1.5 text-[11.5px] xl:text-[12.5px] font-semibold whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
            <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            {{ $pSakip['title'] }}
            <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="activeMenu === 'sakip' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
        
        <div x-show="activeMenu === 'sakip'" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0 translate-y-2" 
             x-transition:enter-end="opacity-100 translate-y-0" 
             x-transition:leave="transition ease-in duration-150" 
             x-transition:leave-start="opacity-100 translate-y-0" 
             x-transition:leave-end="opacity-0 translate-y-2" 
             style="display: none;"
             class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[92vw] max-w-5xl rounded-2xl bg-white shadow-2xl border border-slate-100 p-6 md:p-8 z-50 text-slate-800">
            
             <h3 class="text-xl font-bold text-blue-900">{{ $pSakip['title'] }}</h3>
             <p class="text-sm text-slate-500 mt-1 mb-6 pb-2 border-b border-slate-100">Transparansi dan akuntabilitas kinerja BPMP Sulawesi Tenggara</p>
             
             <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                 @php $item = $getChild('sakip', 'renstra', 'RENSTRA', '/renstra'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Rencana Strategis jangka menengah lembaga.</p>
                     </div>
                 </a>
                 @php $item = $getChild('sakip', 'perjanjian-kinerja', 'PERJANJIAN KINERJA', '/perjanjian-kinerja'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Komitmen capaian target kinerja tahunan.</p>
                     </div>
                 </a>
                 @php $item = $getChild('sakip', 'lakin', 'LAKIN', '/lakin'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Laporan Akuntabilitas Kinerja Instansi Pemerintah.</p>
                     </div>
                 </a>
                 @php $item = $getChild('sakip', 'lhe', 'LHE', '/lhe'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Laporan Hasil Evaluasi akuntabilitas kinerja.</p>
                     </div>
                 </a>
                 @php $item = $getChild('sakip', 'lk', 'LK', '/lk'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Laporan Kinerja berkala.</p>
                     </div>
                 </a>
                 @php $item = $getChild('sakip', 'dipa-2026', 'DIPA 2026', '/dipa-2026'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Daftar Isian Pelaksanaan Anggaran tahun 2026.</p>
                     </div>
                 </a>
             </div>
        </div>
    </div>
    @endif

    <!-- 6. LINK TERKAIT -->
    @if(isset($menuBySlug['link-terkait']))
    @php $pLink = $getParent('link-terkait', 'Link Terkait'); @endphp
    <div class="group" @mouseenter="activeMenu = 'link'" @click="activeMenu = activeMenu === 'link' ? null : 'link'">
        <button class="px-2 xl:px-2.5 py-1.5 text-[11.5px] xl:text-[12.5px] font-semibold whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
            <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
            {{ $pLink['title'] }}
            <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="activeMenu === 'link' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
        
        <div x-show="activeMenu === 'link'" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0 translate-y-2" 
             x-transition:enter-end="opacity-100 translate-y-0" 
             x-transition:leave="transition ease-in duration-150" 
             x-transition:leave-start="opacity-100 translate-y-0" 
             x-transition:leave-end="opacity-0 translate-y-2" 
             style="display: none;"
             class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[92vw] max-w-5xl rounded-2xl bg-white shadow-2xl border border-slate-100 p-6 md:p-8 z-50 text-slate-800">
            
             <h3 class="text-xl font-bold text-blue-900">{{ $pLink['title'] }}</h3>
             <p class="text-sm text-slate-500 mt-1 mb-6 pb-2 border-b border-slate-100">Akses cepat ke portal layanan kepegawaian dan pangkalan data pendidikan</p>
             
             <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                 <!-- Panel 1: Layanan Kepegawaian -->
                 <div class="bg-slate-50/70 p-5 rounded-xl border border-slate-100">
                     <h4 class="text-xs font-bold uppercase tracking-wider text-blue-700 mb-4">Layanan Kepegawaian</h4>
                     <div class="space-y-2">
                         @php $item = $getChild('link-terkait', 'e-skp', 'e-SKP', 'https://kinerja.bkn.go.id/', '_blank'); @endphp
                         <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" rel="noopener noreferrer" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 transition-all group/item">
                             <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                             </div>
                             <span class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</span>
                         </a>
                         @php $item = $getChild('link-terkait', 'e-kehadiran', 'e-Kehadiran', '/e-kehadiran'); @endphp
                         <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 transition-all group/item">
                             <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                             </div>
                             <span class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</span>
                         </a>
                         @php $item = $getChild('link-terkait', 'portal-kemendikdasmen', 'Portal Kemendikdasmen', 'https://kemdikbud.go.id/', '_blank'); @endphp
                         <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" rel="noopener noreferrer" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 transition-all group/item">
                             <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                             </div>
                             <span class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</span>
                         </a>
                     </div>
                 </div>

                 <!-- Panel 2: Layanan Data & Informasi -->
                 <div class="bg-slate-50/70 p-5 rounded-xl border border-slate-100">
                     <h4 class="text-xs font-bold uppercase tracking-wider text-blue-700 mb-4">Layanan Data dan Informasi</h4>
                     <div class="grid grid-cols-2 gap-2">
                         @php $item = $getChild('link-terkait', 'data-profil-sekolah', 'Data Profil Sekolah', 'https://dapo.kemdikbud.go.id/', '_blank'); @endphp
                         <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" rel="noopener noreferrer" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 transition-all group/item">
                             <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                             </div>
                             <span class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</span>
                         </a>
                         @php $item = $getChild('link-terkait', 'raport-pendidikan', 'Raport Pendidikan', 'https://raporpendidikan.kemdikbud.go.id/', '_blank'); @endphp
                         <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" rel="noopener noreferrer" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 transition-all group/item">
                             <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                             </div>
                             <span class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</span>
                         </a>
                         @php $item = $getChild('link-terkait', 'pmp', 'PMP', '/pmp'); @endphp
                         <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 transition-all group/item">
                             <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                             </div>
                             <span class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</span>
                         </a>
                         @php $item = $getChild('link-terkait', 'dapodik', 'DAPODIK', 'https://dapo.kemdikbud.go.id/', '_blank'); @endphp
                         <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" rel="noopener noreferrer" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 transition-all group/item">
                             <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                             </div>
                             <span class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</span>
                         </a>
                         @php $item = $getChild('link-terkait', 'bos', 'BOS', 'https://bos.kemdikbud.go.id/', '_blank'); @endphp
                         <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" rel="noopener noreferrer" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 transition-all group/item">
                             <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                             </div>
                             <span class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</span>
                         </a>
                         @php $item = $getChild('link-terkait', 'rumah-pendidikan', 'Rumah Pendidikan', '/rumah-pendidikan'); @endphp
                         <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 transition-all group/item">
                             <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                             </div>
                             <span class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</span>
                         </a>
                         @php $item = $getChild('link-terkait', 'sibi', 'SIBI', 'https://buku.kemdikbud.go.id/', '_blank'); @endphp
                         <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" rel="noopener noreferrer" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 transition-all group/item">
                             <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                             </div>
                             <span class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</span>
                         </a>
                         @php $item = $getChild('link-terkait', 'data-referensi', 'Data Referensi', 'https://referensi.data.kemdikbud.go.id/', '_blank'); @endphp
                         <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" rel="noopener noreferrer" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 transition-all group/item">
                             <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                             </div>
                             <span class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</span>
                         </a>
                         @php $item = $getChild('link-terkait', 'puspeka', 'PUSPEKA', 'https://cerdasberkarakter.kemdikbud.go.id/', '_blank'); @endphp
                         <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" rel="noopener noreferrer" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-100/50 transition-all group/item">
                             <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                             </div>
                             <span class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</span>
                         </a>
                     </div>
                 </div>
             </div>
        </div>
    </div>
    @endif

    <!-- 7. PPID (Direct Link) -->
    @if(isset($menuBySlug['ppid']))
    @php $pPpid = $getParent('ppid', 'PPID', 'https://ppid-bpmpsultra.page.gd/', '_blank'); @endphp
    <div class="group" @mouseenter="activeMenu = null">
        <a href="{{ $pPpid['url'] }}" target="{{ $pPpid['target'] }}" rel="noopener noreferrer" class="px-2 xl:px-2.5 py-1.5 text-[11.5px] xl:text-[12.5px] font-semibold whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
            <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            {{ $pPpid['title'] }}
            <svg class="w-3.5 h-3.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
        </a>
    </div>
    @endif

    <!-- 8. ZI WBK -->
    @if(isset($menuBySlug['zi-wbk']))
    @php $pZiwbk = $getParent('zi-wbk', 'ZI WBK'); @endphp
    <div class="group" @mouseenter="activeMenu = 'ziwbk'" @click="activeMenu = activeMenu === 'ziwbk' ? null : 'ziwbk'">
        <button class="px-2 xl:px-2.5 py-1.5 text-[11.5px] xl:text-[12.5px] font-semibold whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
            <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
            {{ $pZiwbk['title'] }}
            <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="activeMenu === 'ziwbk' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
        
        <div x-show="activeMenu === 'ziwbk'" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0 translate-y-2" 
             x-transition:enter-end="opacity-100 translate-y-0" 
             x-transition:leave="transition ease-in duration-150" 
             x-transition:leave-start="opacity-100 translate-y-0" 
             x-transition:leave-end="opacity-0 translate-y-2" 
             style="display: none;"
             class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[92vw] max-w-5xl rounded-2xl bg-white shadow-2xl border border-slate-100 p-6 md:p-8 z-50 text-slate-800">
            
             <h3 class="text-xl font-bold text-blue-900">{{ $pZiwbk['title'] }} (WBK/WBBM)</h3>
             <p class="text-sm text-slate-500 mt-1 mb-6 pb-2 border-b border-slate-100">Pembangunan zona integritas menuju Wilayah Bebas dari Korupsi</p>
             
             <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                 @php $item = $getChild('zi-wbk', 'standar-pelayanan', 'Standar Pelayanan', '/standar-pelayanan'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Maklumat standar mutu pelayanan.</p>
                     </div>
                 </a>
                 @php $item = $getChild('zi-wbk', 'maklumat-pelayanan', 'Maklumat Pelayanan', '/maklumat-pelayanan'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Pernyataan kesanggupan melayani dengan integritas.</p>
                     </div>
                 </a>
             </div>

             <div class="mt-4 p-4 rounded-xl bg-slate-50/70 border border-slate-100">
                 <h4 class="text-xs font-bold uppercase tracking-wider text-blue-700 mb-4">Area Pemenuhan Zona Integritas</h4>
                 <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                     @php $item = $getChild('zi-wbk', 'manajemen-perubahan', 'Manajemen Perubahan', '/manajemen-perubahan'); @endphp
                     <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-center gap-3 p-2 bg-white rounded-lg border border-slate-100 hover:border-blue-300 hover:shadow-xs transition-all group/sub">
                         <div class="w-7 h-7 rounded bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                             <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                         </div>
                         <span class="text-xs font-semibold text-slate-700 group-hover/sub:text-blue-600">{{ $item['title'] }}</span>
                     </a>
                     @php $item = $getChild('zi-wbk', 'penataan-tata-laksana', 'Penataan Tata Laksana', '/penataan-tata-laksana'); @endphp
                     <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-center gap-3 p-2 bg-white rounded-lg border border-slate-100 hover:border-blue-300 hover:shadow-xs transition-all group/sub">
                         <div class="w-7 h-7 rounded bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                             <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                         </div>
                         <span class="text-xs font-semibold text-slate-700 group-hover/sub:text-blue-600">{{ $item['title'] }}</span>
                     </a>
                     @php $item = $getChild('zi-wbk', 'manajemen-sdm', 'Manajemen SDM', '/manajemen-sdm'); @endphp
                     <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-center gap-3 p-2 bg-white rounded-lg border border-slate-100 hover:border-blue-300 hover:shadow-xs transition-all group/sub">
                         <div class="w-7 h-7 rounded bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                             <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                         </div>
                         <span class="text-xs font-semibold text-slate-700 group-hover/sub:text-blue-600">{{ $item['title'] }}</span>
                     </a>
                     @php $item = $getChild('zi-wbk', 'penguatan-akuntabilitas', 'Penguatan Akuntabilitas', '/penguatan-akuntabilitas'); @endphp
                     <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-center gap-3 p-2 bg-white rounded-lg border border-slate-100 hover:border-blue-300 hover:shadow-xs transition-all group/sub">
                         <div class="w-7 h-7 rounded bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                             <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                         </div>
                         <span class="text-xs font-semibold text-slate-700 group-hover/sub:text-blue-600">{{ $item['title'] }}</span>
                     </a>
                     @php $item = $getChild('zi-wbk', 'penguatan-pengawasan', 'Penguatan Pengawasan', '/penguatan-pengawasan'); @endphp
                     <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-center gap-3 p-2 bg-white rounded-lg border border-slate-100 hover:border-blue-300 hover:shadow-xs transition-all group/sub">
                         <div class="w-7 h-7 rounded bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                             <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                         </div>
                         <span class="text-xs font-semibold text-slate-700 group-hover/sub:text-blue-600">{{ $item['title'] }}</span>
                     </a>
                     @php $item = $getChild('zi-wbk', 'peningkatan-kualitas-layanan', 'Peningkatan Kualitas Layanan', '/peningkatan-kualitas-layanan'); @endphp
                     <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-center gap-3 p-2 bg-white rounded-lg border border-slate-100 hover:border-blue-300 hover:shadow-xs transition-all group/sub">
                         <div class="w-7 h-7 rounded bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                             <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                         </div>
                         <span class="text-xs font-semibold text-slate-700 group-hover/sub:text-blue-600">{{ $item['title'] }}</span>
                     </a>
                 </div>
             </div>
        </div>
    </div>
    @endif

    <!-- 9. PENGADUAN -->
    @if(isset($menuBySlug['pengaduan']))
    @php $pPengaduan = $getParent('pengaduan', 'Pengaduan'); @endphp
    <div class="group" @mouseenter="activeMenu = 'pengaduan'" @click="activeMenu = activeMenu === 'pengaduan' ? null : 'pengaduan'">
        <button class="px-2 xl:px-2.5 py-1.5 text-[11.5px] xl:text-[12.5px] font-semibold whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
            <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
            {{ $pPengaduan['title'] }}
            <svg class="w-3.5 h-3.5 opacity-70 transition-transform duration-200" :class="activeMenu === 'pengaduan' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
        
        <div x-show="activeMenu === 'pengaduan'" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0 translate-y-2" 
             x-transition:enter-end="opacity-100 translate-y-0" 
             x-transition:leave="transition ease-in duration-150" 
             x-transition:leave-start="opacity-100 translate-y-0" 
             x-transition:leave-end="opacity-0 translate-y-2" 
             style="display: none;"
             class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[92vw] max-w-5xl rounded-2xl bg-white shadow-2xl border border-slate-100 p-6 md:p-8 z-50 text-slate-800">
            
             <h3 class="text-xl font-bold text-blue-900">{{ $pPengaduan['title'] }}</h3>
             <p class="text-sm text-slate-500 mt-1 mb-6 pb-2 border-b border-slate-100">Kanal resmi penyampaian aspirasi, laporan, dan pengaduan masyarakat</p>
             
             <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                 @php $item = $getChild('pengaduan', 'spmb', 'SPMB', '/spmb'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Saluran Pengaduan Masyarakat Balai.</p>
                     </div>
                 </a>
                 @php $item = $getChild('pengaduan', 'sp4n-lapor', 'SP4N Lapor', 'https://www.lapor.go.id/', '_blank'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" rel="noopener noreferrer" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Sistem Pengelolaan Pengaduan Pelayanan Publik Nasional.</p>
                     </div>
                 </a>
                 @php $item = $getChild('pengaduan', 'lapor-gratifikasi', 'Lapor Gratifikasi', 'https://gol.kpk.go.id/', '_blank'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" rel="noopener noreferrer" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Pelaporan penerimaan atau penolakan gratifikasi.</p>
                     </div>
                 </a>
                 @php $item = $getChild('pengaduan', 'whistle-blowing-system', 'Whistle Blowing System (WBS)', 'https://wbs.kemdikbud.go.id/', '_blank'); @endphp
                 <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" rel="noopener noreferrer" class="flex items-start gap-4 p-3 rounded-xl hover:bg-blue-50/70 transition-all group/item">
                     <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover/item:scale-110 transition-transform">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                     </div>
                     <div>
                         <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-blue-600 transition-colors">{{ $item['title'] }}</h4>
                         <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Mekanisme pelaporan pelanggaran rahasia dan aman.</p>
                     </div>
                 </a>
             </div>
        </div>
    </div>
    @endif

    <!-- 10. HUBUNGI KAMI -->
    @if(isset($menuBySlug['hubungi-kami']))
    @php $pKontak = $getParent('hubungi-kami', 'Hubungi Kami', '/kontak'); @endphp
    <div class="group" @mouseenter="activeMenu = null">
        <a href="{{ $pKontak['url'] }}" target="{{ $pKontak['target'] }}" class="px-2 xl:px-2.5 py-1.5 text-[11.5px] xl:text-[12.5px] font-semibold whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
            <svg class="w-4 h-4 transition-colors" :class="scrolled ? 'text-blue-600 group-hover:text-blue-800' : 'text-blue-300 group-hover:text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            {{ $pKontak['title'] }}
        </a>
    </div>
    @endif

    <!-- Extra dynamic menus added via CMS that are not in the predefined list -->
    @foreach($dbMenus as $extraMenu)
        @php $extraSlug = \Illuminate\Support\Str::slug($extraMenu->title); @endphp
        @if(!in_array($extraSlug, $handledParents))
            @if($extraMenu->children->isEmpty())
                <div class="group" @mouseenter="activeMenu = null">
                    <a href="{{ $extraMenu->url }}" target="{{ $extraMenu->target }}" class="px-2 xl:px-2.5 py-1.5 text-[11.5px] xl:text-[12.5px] font-semibold whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
                        {{ $extraMenu->title }}
                    </a>
                </div>
            @else
                <div class="group relative" @mouseenter="activeMenu = 'menu-{{ $extraMenu->id }}'" @mouseleave="activeMenu = null">
                    <button class="px-2 xl:px-2.5 py-1.5 text-[11.5px] xl:text-[12.5px] font-semibold whitespace-nowrap transition-colors flex items-center gap-1 rounded-lg group" :class="scrolled ? 'text-gray-800 hover:text-blue-600' : 'text-gray-100 hover:text-white'">
                        {{ $extraMenu->title }}
                        <svg class="w-3.5 h-3.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="activeMenu === 'menu-{{ $extraMenu->id }}'" style="display: none;" class="absolute left-0 mt-1 bg-white shadow-xl border border-gray-100 rounded-xl p-2 min-w-[200px] text-gray-800 z-50">
                        @foreach($extraMenu->children as $ch)
                            <a href="{{ $ch->url }}" target="{{ $ch->target }}" class="block px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors whitespace-nowrap">
                                {{ $ch->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    @endforeach

</div>
