@extends('layouts.admin')

@section('title', 'Tulis Pengumuman')
@section('header_title', 'Tulis Pengumuman Baru')
@section('header_subtitle', 'Publikasikan informasi penting atau pengumuman resmi instansi')

@push('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.announcements.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 flex items-center gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.announcements.store') }}" method="POST" id="announcementForm" class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200/80 shadow-xs space-y-6">
        @csrf

        <div class="space-y-1.5">
            <label for="title" class="block text-sm font-bold text-slate-700">Judul Pengumuman <span class="text-red-500">*</span></label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required 
                class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
        </div>

        <div class="space-y-1.5">
            <label class="block text-sm font-bold text-slate-700">Isi Pengumuman <span class="text-red-500">*</span></label>
            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
                <div id="editor-container" class="h-64 sm:h-80 text-sm"></div>
            </div>
            <textarea name="content" id="content" class="hidden">{{ old('content') }}</textarea>
            @error('content') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="space-y-1.5">
            <label for="status" class="block text-sm font-bold text-slate-700">Status <span class="text-red-500">*</span></label>
            <select name="status" id="status" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl p-3">
                <option value="draft">Draft (Belum dipublikasi)</option>
                <option value="published">Publikasi Sekarang</option>
                <option value="archived">Arsip</option>
            </select>
        </div>

        <div class="pt-6 border-t border-slate-100 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-colors">
                Simpan Pengumuman
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            placeholder: 'Tulis isi pengumuman di sini...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    ['link', 'blockquote'],
                    ['clean']
                ]
            }
        });

        // Load old content if validation fails
        var oldContent = document.getElementById('content').value;
        if(oldContent) {
            quill.root.innerHTML = oldContent;
        }

        // Sync Quill with hidden textarea on submit
        document.getElementById('announcementForm').onsubmit = function() {
            var content = document.querySelector('textarea[name=content]');
            var html = quill.root.innerHTML;
            if(html === '<p><br></p>') html = '';
            content.value = html;
        };
    });
</script>
@endpush
