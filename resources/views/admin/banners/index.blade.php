@extends('layouts.admin')

@section('title', 'Manajemen Banner')
@section('header_title', 'Banner (Hero Section)')
@section('header_subtitle', 'Kelola slider banner yang tampil di halaman depan website')

@section('header_action')
    <a href="{{ route('admin.banners.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-md transition-all inline-flex items-center gap-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        <span>+ Tambah Banner</span>
    </a>
@endsection

@section('content')
<div class="space-y-6">

    <!-- KARTU TABEL GLASSMORPHISM -->
    <div class="bg-white/70 backdrop-blur-xl rounded-[2rem] shadow-sm border border-white p-2 sm:p-4 overflow-hidden overflow-x-auto w-full">
        <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                        <th class="p-4 w-12 text-center">No</th>
                        <th class="p-4">Gambar &amp; Judul</th>
                        <th class="p-4 text-center">Urutan</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($banners as $index => $banner)
                        <tr class="hover:bg-blue-50/30 transition-colors group">
                            <td class="p-4 text-center text-slate-500 font-medium text-xs">{{ $index + 1 }}</td>
                            <td class="p-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-24 h-14 rounded-xl bg-slate-100 overflow-hidden shrink-0 border border-slate-200/50 shadow-xs">
                                        <img src="{{ \Illuminate\Support\Str::startsWith($banner->image, 'http') ? $banner->image : asset('storage/' . ltrim($banner->image, '/')) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-sm text-slate-700 group-hover:text-blue-600 transition-colors">{{ $banner->title }}</h3>
                                        @if($banner->button_text)
                                            <p class="text-xs text-slate-400 font-mono mt-0.5">Tombol: {{ $banner->button_text }} ({{ $banner->button_url }})</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-xl bg-blue-50/80 text-blue-600 font-bold text-xs border border-blue-100 shadow-xs">
                                    {{ $banner->order }}
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                @if($banner->status)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/50 shadow-xs">Aktif</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200/50 shadow-xs">Nonaktif</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.banners.edit', $banner) }}" class="w-8 h-8 rounded-xl bg-white/50 backdrop-blur-md border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-300 hover:shadow-md transition-all flex items-center justify-center" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus banner ini?');" class="inline-block">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-xl bg-white/50 backdrop-blur-md border border-slate-200 text-slate-400 hover:text-rose-600 hover:border-rose-300 hover:shadow-md transition-all flex items-center justify-center cursor-pointer" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500">
                                <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="font-medium">Belum ada banner.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
    </div>
</div>
@endsection
