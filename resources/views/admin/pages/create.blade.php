@extends('admin.layouts.app')

@section('title', 'Tambah Halaman Baru')
@section('page_title', 'Tambah Halaman Baru')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/codemirror.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/theme/monokai.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/addon/dialog/dialog.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/addon/search/matchesonscrollbar.min.css">
<style>
    .CodeMirror {
        height: 520px;
        border-bottom-left-radius: 0.75rem;
        border-bottom-right-radius: 0.75rem;
        font-family: 'JetBrains Mono', 'Fira Code', 'Courier New', Courier, monospace;
        font-size: 14px;
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .cm-searching {
        background-color: rgba(250, 204, 21, 0.45) !important;
        outline: 1px solid rgba(250, 204, 21, 0.8) !important;
        border-radius: 2px;
    }
    .cm-searching-active {
        background-color: rgba(59, 130, 246, 0.75) !important;
        outline: 2px solid #60a5fa !important;
        color: #ffffff !important;
        border-radius: 2px;
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
                <div x-show="editorMode === 'html'" style="display: none;" class="rounded-xl overflow-hidden border border-slate-700 shadow-md">
                    <!-- Search & Navigation Toolbar (Tailwind) -->
                    <div class="bg-slate-800 text-slate-200 px-4 py-2.5 border-b border-slate-700 flex flex-wrap items-center justify-between gap-3 text-xs select-none">
                        <!-- Left: Search & Replace Controls -->
                        <div class="flex flex-wrap items-center gap-2">
                            <!-- Search Input -->
                            <div class="relative flex items-center">
                                <span class="absolute left-2.5 text-slate-400 pointer-events-none">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input type="text" id="cm_search_input" placeholder="Cari kata / fungsi (Ctrl+F)..."
                                       class="pl-8 pr-16 py-1.5 bg-slate-900 border border-slate-700 focus:border-blue-500 rounded-lg text-slate-100 placeholder-slate-500 text-xs w-60 sm:w-64 focus:outline-none focus:ring-1 focus:ring-blue-500 font-mono">
                                <span id="cm_match_badge" class="absolute right-2 text-[10px] text-slate-400 font-mono hidden">
                                    0/0
                                </span>
                            </div>

                            <!-- Prev / Next Buttons -->
                            <div class="flex items-center bg-slate-900 rounded-lg border border-slate-700 overflow-hidden">
                                <button type="button" id="cm_btn_prev" title="Cari Sebelumnya (Shift+Enter / Shift+F3)" class="p-1.5 hover:bg-slate-700 text-slate-300 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                </button>
                                <div class="w-px h-4 bg-slate-700"></div>
                                <button type="button" id="cm_btn_next" title="Cari Berikutnya (Enter / F3)" class="p-1.5 hover:bg-slate-700 text-slate-300 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                            </div>

                            <!-- Toggle Replace Mode Button -->
                            <button type="button" id="cm_btn_toggle_replace" class="px-2.5 py-1.5 bg-slate-900 hover:bg-slate-700 text-slate-300 rounded-lg border border-slate-700 font-medium transition-colors flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                <span>Ganti</span>
                            </button>

                            <!-- Replace Container (Toggled via JS) -->
                            <div id="cm_replace_box" class="hidden flex items-center gap-1.5">
                                <input type="text" id="cm_replace_input" placeholder="Ganti dengan..."
                                       class="px-2.5 py-1.5 bg-slate-900 border border-slate-700 focus:border-blue-500 rounded-lg text-slate-100 placeholder-slate-500 text-xs w-40 sm:w-48 focus:outline-none focus:ring-1 focus:ring-blue-500 font-mono">
                                <button type="button" id="cm_btn_replace" class="px-2.5 py-1.5 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-xs font-semibold transition-colors">
                                    Ganti
                                </button>
                                <button type="button" id="cm_btn_replace_all" class="px-2.5 py-1.5 bg-slate-700 hover:bg-slate-600 text-white rounded-lg text-xs font-semibold transition-colors">
                                    Semua
                                </button>
                            </div>
                        </div>

                        <!-- Right: Quick Jump Elements & Editor Options -->
                        <div class="flex items-center gap-2">
                            <!-- Quick Jump to Function / Tag Dropdown -->
                            <div class="relative" x-data="{ jumpOpen: false }">
                                <button type="button" @click="jumpOpen = !jumpOpen" class="px-2.5 py-1.5 bg-slate-900 hover:bg-slate-700 text-slate-300 rounded-lg border border-slate-700 font-medium transition-colors flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    <span>Lompat ke Fungsi / Tag</span>
                                    <svg class="w-3 h-3 text-slate-400 transition-transform" :class="jumpOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>

                                <div x-show="jumpOpen" @click.away="jumpOpen = false" x-transition
                                     class="absolute right-0 mt-1 w-60 bg-slate-900 border border-slate-700 rounded-xl shadow-xl py-1 z-30 text-xs font-sans">
                                    <div class="px-3 py-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-800">
                                        Pencarian Cepat
                                    </div>
                                    <button type="button" onclick="cmQuickSearch('function')" @click="jumpOpen = false" class="w-full text-left px-3 py-2 hover:bg-slate-800 text-slate-200 flex items-center justify-between">
                                        <span>Fungsi Javascript</span>
                                        <code class="text-blue-400 text-[11px]">function</code>
                                    </button>
                                    <button type="button" onclick="cmQuickSearch('x-data')" @click="jumpOpen = false" class="w-full text-left px-3 py-2 hover:bg-slate-800 text-slate-200 flex items-center justify-between">
                                        <span>Komponen Alpine.js</span>
                                        <code class="text-purple-400 text-[11px]">x-data</code>
                                    </button>
                                    <button type="button" onclick="cmQuickSearch('<section')" @click="jumpOpen = false" class="w-full text-left px-3 py-2 hover:bg-slate-800 text-slate-200 flex items-center justify-between">
                                        <span>Tag Section</span>
                                        <code class="text-emerald-400 text-[11px]">&lt;section&gt;</code>
                                    </button>
                                    <button type="button" onclick="cmQuickSearch('<div')" @click="jumpOpen = false" class="w-full text-left px-3 py-2 hover:bg-slate-800 text-slate-200 flex items-center justify-between">
                                        <span>Tag Container Div</span>
                                        <code class="text-emerald-400 text-[11px]">&lt;div&gt;</code>
                                    </button>
                                    <button type="button" onclick="cmQuickSearch('<script')" @click="jumpOpen = false" class="w-full text-left px-3 py-2 hover:bg-slate-800 text-slate-200 flex items-center justify-between">
                                        <span>Blok Script JS</span>
                                        <code class="text-amber-400 text-[11px]">&lt;script&gt;</code>
                                    </button>
                                    <button type="button" onclick="cmQuickSearch('class=')" @click="jumpOpen = false" class="w-full text-left px-3 py-2 hover:bg-slate-800 text-slate-200 flex items-center justify-between border-t border-slate-800">
                                        <span>Class Tailwind</span>
                                        <code class="text-teal-400 text-[11px]">class=</code>
                                    </button>
                                    <button type="button" onclick="cmPromptJumpToLine()" @click="jumpOpen = false" class="w-full text-left px-3 py-2 hover:bg-slate-800 text-slate-200 flex items-center justify-between border-t border-slate-800">
                                        <span>Lompat ke No. Baris...</span>
                                        <span class="text-[10px] text-slate-400 font-mono">:baris</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Jump to Line Input -->
                            <div class="flex items-center bg-slate-900 border border-slate-700 rounded-lg overflow-hidden px-2 py-1">
                                <span class="text-[10px] text-slate-400 font-mono mr-1">Ln:</span>
                                <input type="number" id="cm_line_jump_input" placeholder="Baris" min="1"
                                       class="bg-transparent text-slate-100 text-xs w-11 focus:outline-none font-mono">
                                <button type="button" id="cm_btn_jump_line" title="Lompat ke baris" class="text-slate-400 hover:text-blue-400 ml-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                            </div>

                            <!-- Expand Height Button -->
                            <button type="button" id="cm_btn_toggle_height" title="Perbesar / Perkecil Editor"
                                    class="p-1.5 bg-slate-900 hover:bg-slate-700 text-slate-300 rounded-lg border border-slate-700 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- CodeMirror Textarea -->
                    <textarea id="html_editor" name="content" class="w-full h-[520px]" placeholder="<!-- Ketik HTML di sini -->" spellcheck="false">{{ old('content') }}</textarea>
                </div>
                <div x-show="editorMode === 'html'" style="display: none;">
                    <div class="flex flex-wrap items-center justify-between text-[11px] text-slate-400 mt-2 px-1 gap-2">
                        <span>Mode HTML khusus developer. Menggunakan mode ini berarti data Visual Builder akan diabaikan dan konten halaman sepenuhnya menggunakan kode HTML di atas saat disimpan.</span>
                        <span class="font-mono text-slate-500">Shortcut: <strong class="text-slate-400">Ctrl+F</strong> (Cari), <strong class="text-slate-400">F3</strong> (Lanjut), <strong class="text-slate-400">Shift+F3</strong> (Sebelumnya), <strong class="text-slate-400">Esc</strong> (Hapus Seleksi)</span>
                    </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/addon/dialog/dialog.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/addon/search/searchcursor.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/addon/search/search.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/addon/search/jump-to-line.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editor = CodeMirror.fromTextArea(document.getElementById('html_editor'), {
            mode: "htmlmixed",
            theme: "monokai",
            lineNumbers: true,
            lineWrapping: true,
            tabSize: 4,
            extraKeys: {
                "Ctrl-F": function(cm) {
                    openAndFocusSearch();
                },
                "Cmd-F": function(cm) {
                    openAndFocusSearch();
                },
                "F3": function(cm) {
                    findNext();
                },
                "Shift-F3": function(cm) {
                    findPrev();
                },
                "Esc": function(cm) {
                    clearHighlights();
                }
            }
        });

        editor.on('change', function() {
            editor.save();
        });

        window.refreshHtmlEditor = function() {
            setTimeout(() => {
                editor.refresh();
            }, 50);
        };

        // --- Fitur Pencarian Kata & Fungsi ---
        var currentMarkers = [];
        var activeMarker = null;
        var currentMatchIndex = -1;
        var matches = [];

        var searchInput = document.getElementById('cm_search_input');
        var matchBadge = document.getElementById('cm_match_badge');
        var btnPrev = document.getElementById('cm_btn_prev');
        var btnNext = document.getElementById('cm_btn_next');
        var btnToggleReplace = document.getElementById('cm_btn_toggle_replace');
        var replaceBox = document.getElementById('cm_replace_box');
        var replaceInput = document.getElementById('cm_replace_input');
        var btnReplace = document.getElementById('cm_btn_replace');
        var btnReplaceAll = document.getElementById('cm_btn_replace_all');
        var lineJumpInput = document.getElementById('cm_line_jump_input');
        var btnJumpLine = document.getElementById('cm_btn_jump_line');
        var btnToggleHeight = document.getElementById('cm_btn_toggle_height');

        function openAndFocusSearch() {
            var selectedText = editor.getSelection();
            if (selectedText && selectedText.trim() !== '') {
                searchInput.value = selectedText.trim();
                doSearch(selectedText.trim());
            }
            searchInput.focus();
            searchInput.select();
        }

        function clearHighlights() {
            for (var i = 0; i < currentMarkers.length; i++) {
                currentMarkers[i].clear();
            }
            currentMarkers = [];
            if (activeMarker) {
                activeMarker.clear();
                activeMarker = null;
            }
            matches = [];
            currentMatchIndex = -1;
            if (matchBadge) {
                matchBadge.classList.add('hidden');
                matchBadge.textContent = '0/0';
            }
        }

        function doSearch(query, keepActiveIndex) {
            clearHighlights();
            if (!query || query.trim() === '') return;

            var cursor = editor.getSearchCursor(query, {line: 0, ch: 0}, {caseFold: true});
            while (cursor.findNext()) {
                matches.push({
                    from: cursor.from(),
                    to: cursor.to()
                });
                var mark = editor.markText(cursor.from(), cursor.to(), { className: 'cm-searching' });
                currentMarkers.push(mark);
            }

            if (!matchBadge) return;
            matchBadge.classList.remove('hidden');

            if (matches.length > 0) {
                if (!keepActiveIndex || currentMatchIndex === -1 || currentMatchIndex >= matches.length) {
                    currentMatchIndex = 0;
                }
                highlightActiveMatch();
            } else {
                matchBadge.textContent = '0 hasil';
                matchBadge.classList.add('text-rose-400');
                matchBadge.classList.remove('text-slate-400');
            }
        }

        function highlightActiveMatch() {
            if (currentMatchIndex < 0 || currentMatchIndex >= matches.length) return;

            if (activeMarker) activeMarker.clear();

            var target = matches[currentMatchIndex];
            activeMarker = editor.markText(target.from, target.to, { className: 'cm-searching-active' });
            editor.setSelection(target.from, target.to);
            editor.scrollIntoView({from: target.from, to: target.to}, 80);

            if (matchBadge) {
                matchBadge.textContent = (currentMatchIndex + 1) + ' / ' + matches.length;
                matchBadge.classList.remove('text-rose-400');
                matchBadge.classList.add('text-slate-400');
            }
        }

        function findNext() {
            if (matches.length === 0) {
                var q = searchInput.value;
                if (q) doSearch(q);
                return;
            }
            currentMatchIndex = (currentMatchIndex + 1) % matches.length;
            highlightActiveMatch();
        }

        function findPrev() {
            if (matches.length === 0) {
                var q = searchInput.value;
                if (q) doSearch(q);
                return;
            }
            currentMatchIndex = (currentMatchIndex - 1 + matches.length) % matches.length;
            highlightActiveMatch();
        }

        function replaceCurrent() {
            if (currentMatchIndex < 0 || currentMatchIndex >= matches.length) return;
            var target = matches[currentMatchIndex];
            var repVal = replaceInput ? replaceInput.value : '';
            editor.replaceRange(repVal, target.from, target.to);
            var q = searchInput.value;
            doSearch(q, true);
        }

        function replaceAll() {
            var q = searchInput.value;
            var repVal = replaceInput ? replaceInput.value : '';
            if (!q) return;

            var cursor = editor.getSearchCursor(q, {line: 0, ch: 0}, {caseFold: true});
            var allItems = [];
            while (cursor.findNext()) {
                allItems.push({from: cursor.from(), to: cursor.to()});
            }
            for (var i = allItems.length - 1; i >= 0; i--) {
                editor.replaceRange(repVal, allItems[i].from, allItems[i].to);
            }
            clearHighlights();
            doSearch(q);
        }

        // Search Input Events
        var searchDebounceTimer;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchDebounceTimer);
            searchDebounceTimer = setTimeout(function() {
                doSearch(searchInput.value);
            }, 200);
        });

        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (e.shiftKey) {
                    findPrev();
                } else {
                    findNext();
                }
            } else if (e.key === 'Escape') {
                clearHighlights();
                editor.focus();
            }
        });

        btnPrev.addEventListener('click', findPrev);
        btnNext.addEventListener('click', findNext);

        // Toggle Replace Box
        btnToggleReplace.addEventListener('click', function() {
            if (replaceBox.classList.contains('hidden')) {
                replaceBox.classList.remove('hidden');
                replaceInput.focus();
            } else {
                replaceBox.classList.add('hidden');
            }
        });

        btnReplace.addEventListener('click', replaceCurrent);
        btnReplaceAll.addEventListener('click', replaceAll);

        // Jump to Line
        function doLineJump() {
            var val = parseInt(lineJumpInput.value);
            if (!isNaN(val) && val > 0) {
                editor.setCursor({line: val - 1, ch: 0});
                editor.scrollIntoView({line: val - 1, ch: 0}, 80);
                editor.focus();
            }
        }
        btnJumpLine.addEventListener('click', doLineJump);
        lineJumpInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                doLineJump();
            }
        });

        // Quick Search Helper
        window.cmQuickSearch = function(term) {
            searchInput.value = term;
            doSearch(term);
            searchInput.focus();
            searchInput.select();
        };

        window.cmPromptJumpToLine = function() {
            var line = prompt('Masukkan nomor baris yang ingin dituju:');
            if (line) {
                var num = parseInt(line);
                if (!isNaN(num) && num > 0) {
                    lineJumpInput.value = num;
                    doLineJump();
                }
            }
        };

        // Toggle Editor Height
        var isEditorExpanded = false;
        btnToggleHeight.addEventListener('click', function() {
            isEditorExpanded = !isEditorExpanded;
            var wrapper = editor.getWrapperElement();
            if (isEditorExpanded) {
                wrapper.style.height = '850px';
                btnToggleHeight.classList.add('bg-blue-600', 'text-white');
                btnToggleHeight.classList.remove('bg-slate-900', 'text-slate-300');
            } else {
                wrapper.style.height = '520px';
                btnToggleHeight.classList.remove('bg-blue-600', 'text-white');
                btnToggleHeight.classList.add('bg-slate-900', 'text-slate-300');
            }
            editor.refresh();
        });
    });
</script>
@endpush
