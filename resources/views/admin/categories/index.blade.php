@extends('layouts.admin')

@section('title', 'Kategori Berita')
@section('header_title', 'Kategori Berita')
@section('header_subtitle', 'Kelompokkan berita berdasarkan bidang dan topik bahasan')

@section('header_action')
    <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-md transition-all inline-flex items-center gap-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        <span>+ Tambah Kategori</span>
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
                    <th class="p-4">Nama Kategori</th>
                    <th class="p-4">Slug</th>
                    <th class="p-4 text-center">Status</th>
                    <th class="p-4 text-center">Jumlah Berita</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($categories as $index => $cat)
                    <tr class="hover:bg-blue-50/30 transition-colors group">
                        <td class="p-4 text-center text-slate-500 font-medium text-xs">{{ $categories->firstItem() + $index }}</td>
                        <td class="p-4 font-bold text-slate-700 text-sm group-hover:text-blue-600 transition-colors">{{ $cat->name }}</td>
                        <td class="p-4 font-mono text-slate-400 text-xs">/{{ $cat->slug }}</td>
                        <td class="p-4 text-center">
                            @if($cat->is_active)
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/50 shadow-xs">Aktif</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200/50 shadow-xs">Nonaktif</span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200/50 shadow-xs">
                                {{ $cat->posts_count }} Berita
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.categories.edit', $cat) }}" class="w-8 h-8 rounded-xl bg-white/50 backdrop-blur-md border border-slate-200 text-slate-400 hover:text-amber-600 hover:border-amber-300 hover:shadow-md transition-all flex items-center justify-center" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-xl bg-white/50 backdrop-blur-md border border-slate-200 text-slate-400 hover:text-rose-600 hover:border-rose-300 hover:shadow-md transition-all flex items-center justify-center cursor-pointer" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-500">
                            <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <p class="font-medium">Belum ada data kategori</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    @if($categories->hasPages())
        <div class="mt-8">
            {{ $categories->links() }}
        </div>
    @endif
</div>
@endsection
