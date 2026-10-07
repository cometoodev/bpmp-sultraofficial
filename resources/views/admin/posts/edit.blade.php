@extends('admin.layouts.app')

@section('title', 'Edit Berita')
@section('page_title', 'Edit Berita')

@push('styles')
<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .ql-toolbar.ql-snow { border-color: #e2e8f0; border-top-left-radius: 0.75rem; border-top-right-radius: 0.75rem; background-color: #f8fafc; padding: 0.75rem; }
    .ql-container.ql-snow { border-color: #e2e8f0; border-bottom-left-radius: 0.75rem; border-bottom-right-radius: 0.75rem; background-color: #fff; min-height: 400px; font-family: inherit; font-size: 1rem; }
    .ql-editor { padding: 1.5rem; }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pb-12">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.posts.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 flex items-center gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="postForm">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-6">
                    <!-- Title -->
                    <div class="space-y-1.5">
                        <label for="title" class="block text-sm font-bold text-slate-700">Judul Berita <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required 
                            class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3 transition-colors">
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Content (Quill Editor) -->
                    <div class="space-y-1.5">
                        <label class="block text-sm font-bold text-slate-700">Isi Berita <span class="text-red-500">*</span></label>
                        <div>
                            <div id="editor-container">{!! old('content', $post->content) !!}</div>
                            <input type="hidden" name="content" id="content" value="{{ old('content', $post->content) }}">
                        </div>
                        @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Excerpt -->
                    <div class="space-y-1.5">
                        <label for="excerpt" class="block text-sm font-bold text-slate-700">Kutipan / Ringkasan (Opsional)</label>
                        <textarea name="excerpt" id="excerpt" rows="3" 
                            class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3 transition-colors">{{ old('excerpt', $post->excerpt) }}</textarea>
                        <p class="text-[11px] text-slate-500">Ditampilkan di daftar berita/kartu berita.</p>
                        @error('excerpt') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar Options -->
            <div class="space-y-6">
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-5">
                    
                    <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-2">Pengaturan Berita</h3>

                    <!-- Status -->
                    <div class="space-y-1.5">
                        <label for="status" class="block text-sm font-bold text-slate-700">Status</label>
                        <select name="status" id="status" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3 transition-colors">
                            <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Published (Terbit)</option>
                            <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Draft (Konsep)</option>
                            <option value="archived" {{ old('status', $post->status) == 'archived' ? 'selected' : '' }}>Archived (Arsip)</option>
                        </select>
                        @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Category -->
                    <div class="space-y-1.5">
                        <label for="category_id" class="block text-sm font-bold text-slate-700">Kategori <span class="text-red-500">*</span></label>
                        <select name="category_id" id="category_id" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3 transition-colors">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Slug -->
                    <div class="space-y-1.5">
                        <label for="slug" class="block text-sm font-bold text-slate-700">Slug URL (Opsional)</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $post->slug) }}" placeholder="judul-berita"
                            class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3 transition-colors">
                        @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Featured -->
                    <label class="flex items-center gap-3 cursor-pointer p-3 rounded-xl border border-slate-200/80 bg-slate-50/50">
                        <input type="checkbox" name="is_featured" value="1" class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500" {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}>
                        <div>
                            <span class="text-sm font-bold text-slate-700 block">Jadikan Pilihan/Unggulan</span>
                        </div>
                    </label>

                    <!-- Featured Image -->
                    <div class="space-y-3 pt-2 border-t border-slate-100">
                        <label for="featured_image" class="block text-sm font-bold text-slate-700">Gambar Utama (Featured Image)</label>
                        @if($post->featured_image)
                            <div class="rounded-xl overflow-hidden border border-slate-200 relative group">
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Preview" class="w-full h-auto object-cover aspect-video">
                            </div>
                        @endif
                        <input type="file" name="featured_image" id="featured_image" accept="image/*"
                            class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-2 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-[11px] text-slate-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                        @error('featured_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <button type="submit" class="w-full px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-colors">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection

@push('scripts')
<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            placeholder: 'Tulis isi berita di sini...',
            modules: {
                toolbar: [
                    [{ 'header': [2, 3, 4, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            }
        });

        // Sync Quill content to hidden input before submit
        var form = document.getElementById('postForm');
        form.onsubmit = function() {
            var contentInput = document.querySelector('input[name=content]');
            contentInput.value = quill.root.innerHTML;
        };
    });
</script>
@endpush
