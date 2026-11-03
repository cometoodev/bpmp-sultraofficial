@props(['block'])

@php
    $content = is_array($block['content'] ?? null) ? $block['content'] : (json_decode(json_encode($block['content'] ?? []), true) ?: []);
    $imgPos = $content['image_position'] ?? 'left';
@endphp

<div class="flex flex-col lg:flex-row gap-12 items-center mb-16 {{ $imgPos === 'right' ? 'lg:flex-row-reverse' : '' }}">
    <!-- Gambar -->
    <div class="w-full lg:w-1/3 shrink-0">
        <div class="relative rounded-[2rem] overflow-hidden shadow-lg border-4 border-slate-50 group">
            @if(!empty($content['image_url']))
                <img src="{{ $content['image_url'] }}" alt="{{ $content['title'] ?? 'Gambar' }}" class="w-full h-auto aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-700">
            @else
                <div class="w-full aspect-[3/4] bg-slate-100 flex items-center justify-center text-slate-400 text-xs font-semibold">Area Gambar</div>
            @endif
        </div>
    </div>
    <!-- Teks -->
    <div class="w-full lg:w-2/3 space-y-6">
        @if(!empty($content['tagline']))
            <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-blue-50 text-blue-600 font-bold text-sm uppercase tracking-widest border border-blue-100">{{ $content['tagline'] }}</div>
        @endif
        <h2 class="text-3xl md:text-5xl font-extrabold text-slate-800 leading-tight">{{ $content['title'] ?? '' }}</h2>
        <div class="prose prose-slate prose-lg max-w-none text-slate-600 leading-relaxed">
            {!! $content['description'] ?? '' !!}
        </div>
        @if(!empty($content['button_text']))
            <a href="{{ $content['button_link'] ?? '#' }}" class="inline-block mt-4 px-6 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-md hover:bg-blue-700 transition-colors">{{ $content['button_text'] }}</a>
        @endif
    </div>
</div>

