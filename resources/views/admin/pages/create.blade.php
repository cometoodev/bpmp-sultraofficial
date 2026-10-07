@extends('admin.layouts.app')

@section('title', 'Tambah Halaman Baru')
@section('page_title', 'Tambah Halaman Baru')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/codemirror.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/theme/monokai.min.css">
<style>
    .CodeMirror {
        height: 500px;
        border-radius: 0.75rem;
        font-family: 'JetBrains Mono', 'Fira Code', 'Courier New', Courier, monospace;
        font-size: 14px;
        padding-top: 10px;
        padding-bottom: 10px;
    }
</style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto space-y-6" x-data="{
    title: '{{ old('title', '') }}',
    slug: '{{ old('slug', '') }}',
    autoSlug: true,
    generateSlug(text) {
        if (!this.autoSlug) return;
        this.slug = text.toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .trim()
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }
}">

    <!-- Page Header & Back Button -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.pages.index') }}" class="p-2 bg-white border border-slate-200 text-slate-600 hover:text-slate-900 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-slate-900">Buat Halaman Baru</h1>
                <p class="text-xs text-slate-500">Buat halaman dinamis untuk website BPMP Sultra</p>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-800 text-xs">
            <div class="font-bold mb-1">Terdapat kesalahan pada formulir:</div>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.pages.store') }}" enctype="multipart/form-data" class="space-y-6" id="pageForm">
        @csrf

        <!-- Top Settings Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left 2 Cols: Title & Slug & SEO -->
            <div class="lg:col-span-2 space-y-5">
                <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Judul Halaman <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" x-model="title" @input="generateSlug(title)" required
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"
                               placeholder="Contoh: Profil Lembaga BPMP Sultra">
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            URL Slug (Tautan) <span class="text-rose-500">*</span>
                        </label>
                        <div class="flex rounded-xl overflow-hidden border border-slate-200 focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-500">
                            <span class="inline-flex items-center px-3 bg-slate-100 text-slate-500 text-xs font-mono border-r border-slate-200">
                                {{ url('/') }}/
                            </span>
                            <input type="text" id="slug" name="slug" x-model="slug" @input="autoSlug = false" required
                                   class="w-full px-3 py-2 bg-slate-50 text-xs font-mono text-slate-800 focus:outline-none"
                                   placeholder="profil-lembaga-bpmp-sultra">
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Slug otomatis dibuat dari judul namun dapat disesuaikan manual.</p>
                    </div>
                </div>

                <!-- SEO Section Accordion -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden" x-data="{ seoOpen: false }">
                    <button type="button" @click="seoOpen = !seoOpen" class="w-full p-4 sm:p-5 flex items-center justify-between text-left hover:bg-slate-50/50 transition-colors">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">Pengaturan SEO (Mesin Pencari &amp; Social Share)</span>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="seoOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="seoOpen" x-transition class="p-5 border-t border-slate-100 space-y-4 bg-slate-50/30">
                        <div>
                            <label for="meta_title" class="block text-xs font-semibold text-slate-700 mb-1">Meta Title</label>
                            <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title') }}"
                                   class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                                   placeholder="Kosongkan jika sama dengan judul halaman">
                        </div>
                        <div>
                            <label for="meta_description" class="block text-xs font-semibold text-slate-700 mb-1">Meta Description</label>
                            <textarea id="meta_description" name="meta_description" rows="3"
                                      class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                                      placeholder="Deskripsi singkat konten untuk mesin pencari Google...">{{ old('meta_description') }}</textarea>
                        </div>
                        <div>
                            <label for="meta_keywords" class="block text-xs font-semibold text-slate-700 mb-1">Meta Keywords</label>
                            <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}"
                                   class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                                   placeholder="bpmp sultra, pendidikan, profil">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right 1 Col: Publishing Settings & Image -->
            <div class="space-y-5">
                <!-- Status & Publish Date Card -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider pb-2 border-b border-slate-100">
                        Publikasi
                    </h3>
                    <div>
                        <label for="status" class="block text-xs font-semibold text-slate-700 mb-1">Status Publikasi</label>
                        <select id="status" name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft (Konsep)</option>
                            <option value="published" {{ old('status', 'published') === 'published' ? 'selected' : '' }}>Published (Terbit)</option>
                        </select>
                    </div>
                    <div>
                        <label for="published_at" class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Terbit</label>
                        <input type="datetime-local" id="published_at" name="published_at" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}"
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs shadow-md shadow-blue-600/25 transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Simpan Halaman</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <!-- CONTENT EDITOR SECTION -->
        <div class="w-full mt-8" x-data="{ editorMode: '{{ old('editor_mode', 'visual') }}' }" x-init="$watch('editorMode', value => { if(value === 'html') window.refreshHtmlEditor() })">
            <input type="hidden" name="editor_mode" x-model="editorMode">
            
            <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-slate-100">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Metode Desain Halaman</h3>
                        <p class="text-xs text-slate-500 mt-1">Pilih metode yang ingin Anda gunakan untuk merancang konten halaman ini.</p>
                    </div>
                    <div class="flex bg-slate-100 p-1 rounded-xl border border-slate-200">
                        <button type="button" @click="editorMode = 'visual'" :class="editorMode === 'visual' ? 'bg-white shadow-sm text-blue-600' : 'text-slate-500 hover:text-slate-700'" class="px-4 py-2 text-xs font-bold rounded-lg transition-all">Visual Builder</button>
                        <button type="button" @click="editorMode = 'html'; window.refreshHtmlEditor();" :class="editorMode === 'html' ? 'bg-white shadow-sm text-blue-600' : 'text-slate-500 hover:text-slate-700'" class="px-4 py-2 text-xs font-bold rounded-lg transition-all flex items-center gap-1">
                            HTML / Tailwind
                        </button>
                    </div>
                </div>

                <!-- Mode Visual Builder (Banner to Standalone Page) -->
                <div x-show="editorMode === 'visual'" class="py-8 text-center bg-slate-50 rounded-xl border border-slate-200 border-dashed">
                    <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-slate-800 mb-2">Visual Page Builder Belum Tersedia</h4>
                    <p class="text-sm text-slate-500 max-w-md mx-auto mb-6">Anda sedang membuat halaman baru. Untuk masuk ke tampilan Visual Page Builder secara penuh, <strong>simpan halaman ini terlebih dahulu</strong> (sebagai Draft atau Published) dengan mengklik tombol "Simpan Halaman" di atas.</p>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm shadow-lg shadow-blue-600/30 transition-all hover:-translate-y-1">
                        Simpan Halaman Sekarang
                    </button>
                </div>

                <!-- Mode HTML / Tailwind -->
                <div x-show="editorMode === 'html'" style="display: none;" class="rounded-xl overflow-hidden border border-slate-700">
                    <textarea id="html_editor" name="content" class="w-full h-[500px]" placeholder="<!-- Ketik HTML di sini -->" spellcheck="false">{{ old('content') }}</textarea>
                </div>
                <div x-show="editorMode === 'html'" style="display: none;">
                    <p class="text-[11px] text-slate-400 mt-2">Mode HTML khusus developer. Menggunakan mode ini berarti data Visual Builder akan diabaikan dan konten halaman sepenuhnya menggunakan kode HTML di atas saat disimpan.</p>
                </div>

            </div>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/xml/xml.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/javascript/javascript.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/css/css.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/htmlmixed/htmlmixed.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editor = CodeMirror.fromTextArea(document.getElementById('html_editor'), {
            mode: "htmlmixed",
            theme: "monokai",
            lineNumbers: true,
            lineWrapping: true,
            tabSize: 4
        });

        editor.on('change', function() {
            editor.save();
        });

        window.refreshHtmlEditor = function() {
            setTimeout(() => {
                editor.refresh();
            }, 50);
        };
    });
</script>
@endpush
