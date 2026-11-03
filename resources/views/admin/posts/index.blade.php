@extends('layouts.admin')

@section('title', 'Berita & Artikel')
@section('header_title', 'Berita & Artikel')
@section('header_subtitle', 'Kelola publikasi berita dan artikel website BPMP Sultra')

@section('header_action')
    <a href="{{ route('admin.posts.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-md transition-all inline-flex items-center gap-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
        <span>+ Tambah Berita</span>
    </a>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Search & Filter Card Glassmorphism -->
    <div class="bg-white/60 backdrop-blur-xl border border-white/50 shadow-sm rounded-3xl p-5 mb-6">
        <form method="GET" action="{{ route('admin.posts.index') }}" class="flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[220px] max-w-md">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau slug berita..."
                       @input.debounce.500ms="$el.form.submit()"
                       class="w-full sm:w-80 bg-white/50 border border-slate-200/60 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/50 backdrop-blur-sm transition-all text-slate-800 placeholder-slate-400">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <select name="category_id" onchange="this.form.submit()" class="py-2.5 px-3.5 bg-white/50 border border-slate-200/60 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/50 backdrop-blur-sm transition-all cursor-pointer">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>

            <select name="status" onchange="this.form.submit()" class="py-2.5 px-3.5 bg-white/50 border border-slate-200/60 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/50 backdrop-blur-sm transition-all cursor-pointer">
                <option value="">Semua Status</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
            </select>

            <button type="submit" class="px-4 py-2.5 bg-slate-800 text-white rounded-xl text-xs font-semibold hover:bg-slate-900 transition-colors shadow-sm cursor-pointer">
                Filter
            </button>
            @if(request()->filled('search') || request()->filled('status') || request()->filled('category_id'))
                <a href="{{ route('admin.posts.index') }}" class="text-xs text-slate-500 hover:text-slate-800 underline transition-colors">Reset</a>
            @endif
        </form>
    </div>

    <!-- KARTU TABEL GLASSMORPHISM -->
    <div class="bg-white/70 backdrop-blur-xl rounded-[2rem] shadow-sm border border-white p-2 sm:p-4 overflow-hidden overflow-x-auto w-full">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                    <th class="p-4 w-12 text-center">No</th>
                    <th class="p-4">Judul Berita</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4 text-center">Status</th>
                    <th class="p-4 text-center">Tanggal</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($posts as $index => $post)
                    <tr class="hover:bg-blue-50/30 transition-colors group">
                        <td class="p-4 text-center text-slate-500 font-medium text-xs">{{ $posts->firstItem() + $index }}</td>
                        <td class="p-4">
                            <p class="text-sm font-bold text-slate-700 line-clamp-1 group-hover:text-blue-600 transition-colors">{{ $post->title }}</p>
                            <p class="text-xs text-slate-400 font-mono mt-0.5">/{{ $post->slug }}</p>
                        </td>
                        <td class="p-4">
                            <span class="text-xs font-semibold text-slate-600 bg-slate-100/80 px-2.5 py-1 rounded-lg border border-slate-200/50">{{ $post->category->name ?? '-' }}</span>
                        </td>
                        <td class="p-4 text-center">
                            @if($post->status === 'published')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/50 shadow-xs">Published</span>
                            @elseif($post->status === 'draft')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-200/50 shadow-xs">Draft</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200/50 shadow-xs">Archived</span>
                            @endif
                            @if($post->is_featured)
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-200/50 ml-1 shadow-xs">Featured</span>
                            @endif
                        </td>
                        <td class="p-4 text-center text-xs text-slate-500 font-medium">
                            {{ $post->created_at->format('d M Y') }}
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="w-8 h-8 rounded-xl bg-white/50 backdrop-blur-md border border-slate-200 text-slate-400 hover:text-amber-600 hover:border-amber-300 hover:shadow-md transition-all flex items-center justify-center" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');" class="inline">
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
                            <p class="font-medium">Belum ada data berita</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    @if($posts->hasPages())
        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection
