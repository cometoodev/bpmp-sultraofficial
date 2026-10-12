@extends('admin.layouts.app')

@section('title', 'Menu Navigasi')
@section('page_title', 'Menu Navigasi')

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-700 p-4 rounded-xl text-sm font-medium border border-emerald-100 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
        <div>
            <h1 class="text-base font-bold text-slate-800">Manajemen Menu Navigasi</h1>
            <p class="text-xs text-slate-500 mt-1">Atur struktur menu navigasi website utama</p>
        </div>
        <a href="{{ route('admin.menus.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Menu
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-6">
            @if($menus->isEmpty())
                <div class="py-12 text-center text-slate-500">
                    <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <p class="font-medium">Belum ada menu navigasi.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($menus as $menu)
                        <div class="border border-slate-200 rounded-xl overflow-hidden">
                            <!-- Parent Menu Item -->
                            <div class="bg-slate-50 p-4 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">
                                        {{ $menu->order }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h3 class="font-bold text-slate-800">{{ $menu->title }}</h3>
                                            @if($menu->children->count() > 0)
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-200/50">{{ $menu->children->count() }} Submenu</span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-slate-500 font-mono">{{ $menu->url }} 
                                            @if($menu->target == '_blank') <span class="text-blue-500 ml-1 font-sans font-bold">(Tab Baru)</span> @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    @if($menu->status)
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/50">Aktif</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200/50">Nonaktif</span>
                                    @endif
                                    
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.menus.edit', $menu) }}" class="p-1.5 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>
                                        <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" onsubmit="return confirm('Hapus menu ini beserta semua submenunya?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Child Menus -->
                            @if($menu->children->count() > 0)
                                <div class="border-t border-slate-200 divide-y divide-slate-100">
                                    @foreach($menu->children as $child)
                                        <div class="p-3 pl-14 flex items-center justify-between bg-white hover:bg-slate-50/50">
                                            <div class="flex items-center gap-3">
                                                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                                <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">{{ $child->order }}</span>
                                                <div>
                                                    <h4 class="font-medium text-slate-700 text-sm">{{ $child->title }}</h4>
                                                    <p class="text-xs text-slate-400 font-mono">{{ $child->url }}
                                                        @if($child->target == '_blank') <span class="text-blue-500 ml-1 font-sans font-bold">(Tab Baru)</span> @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-4">
                                                @if(!$child->status)
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-500">Nonaktif</span>
                                                @endif
                                                <div class="flex gap-2">
                                                    <a href="{{ route('admin.menus.edit', $child) }}" class="p-1 text-slate-400 hover:text-amber-600 transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                    </a>
                                                    <form action="{{ route('admin.menus.destroy', $child) }}" method="POST" onsubmit="return confirm('Hapus submenu ini?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="p-1 text-slate-400 hover:text-red-600 transition-colors">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
