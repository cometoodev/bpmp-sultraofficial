@props(['block'])

@php
    $content = is_array($block['content'] ?? null) ? $block['content'] : (json_decode(json_encode($block['content'] ?? []), true) ?: []);
    $cards = $content['cards'] ?? [];
@endphp

<div class="my-12">
    @if(!empty($content['section_title']) || !empty($content['section_subtitle']))
        <div class="text-center mb-10">
            @if(!empty($content['section_title']))
                <h3 class="text-3xl font-extrabold text-slate-800">{{ $content['section_title'] }}</h3>
            @endif
            @if(!empty($content['section_subtitle']))
                <p class="text-slate-500 mt-2">{{ $content['section_subtitle'] }}</p>
            @endif
        </div>
    @endif
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($cards as $card)
            @php
                $cardTitle = $card['title'] ?? '';
                $cardSubtitle = $card['subtitle'] ?? 'Laporan Daerah';
                $cardLink = $card['link'] ?? '#';
                $cardIcon = $card['icon'] ?? 'pdf';
            @endphp
            <a href="{{ $cardLink }}" class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-xl hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 min-h-[120px] flex flex-col justify-center overflow-hidden">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    @if($cardIcon === 'pdf')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    @elseif($cardIcon === 'link')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    @else
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    @endif
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-blue-500 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-600 transition-colors">{{ $cardSubtitle }}</span>
                    <h4 class="text-base sm:text-lg font-bold text-slate-700 group-hover:text-blue-700 leading-snug transition-colors">{{ $cardTitle }}</h4>
                </div>
            </a>
        @endforeach
    </div>
</div>

