<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visual Builder - {{ $page->title }}</title>
    <link rel="icon" type="image/png" href="{{ asset('tutwurihandayani.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Scope styling untuk kanvas preview agar class Tailwind terisolasi dan bekerja penuh */
        .builder-canvas-scope {
            font-family: inherit;
        }
        .builder-canvas-scope a, .builder-canvas-scope a:hover {
            text-decoration: none;
        }
        .builder-canvas-scope .block-content {
            display: block;
            width: 100%;
        }
        .builder-editable {
            transition: outline 0.15s ease, background-color 0.15s ease;
            border-radius: 6px;
            cursor: text;
        }
        .builder-editable:hover {
            outline: 2px dashed rgba(59, 130, 246, 0.45) !important;
            outline-offset: 3px !important;
            background-color: rgba(59, 130, 246, 0.04) !important;
        }
        .builder-editable:focus {
            outline: 2px solid #2563eb !important;
            outline-offset: 3px !important;
            background-color: rgba(255, 255, 255, 0.95) !important;
        }
        .sortable-ghost {
            opacity: 0.5 !important;
            border: 2px dashed #3b82f6 !important;
            background-color: #eff6ff !important;
            border-radius: 0.75rem !important;
            transform: scale(0.98);
        }
        .sortable-chosen {
            background-color: #f8fafc !important;
            border-color: #93c5fd !important;
        }
        .sortable-drag {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15) !important;
            cursor: grabbing !important;
        }
        @keyframes marquee { 0% { transform: translateX(0%); } 100% { transform: translateX(-50%); } }
        .animate-marquee { display: flex; width: max-content; animation: marquee 30s linear infinite; }
        .animate-marquee:hover { animation-play-state: paused; }

        /* Canva & Figma Interactive Canvas Bounding Box */
        .canvas-block-section {
            position: relative;
            transition: outline 0.15s ease, box-shadow 0.15s ease;
            cursor: pointer;
        }
        .canvas-block-section:hover {
            outline: 2px dashed #60a5fa !important;
            outline-offset: -2px !important;
        }
        .canvas-block-section.is-selected {
            outline: 2px solid #2563eb !important;
            outline-offset: -2px !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2) !important;
            z-index: 35 !important;
        }
        .canvas-anchor-handle {
            position: absolute;
            width: 9px;
            height: 9px;
            background-color: #ffffff;
            border: 2px solid #2563eb;
            border-radius: 2px;
            z-index: 45;
            pointer-events: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }
        .canvas-handle-tl { top: -4.5px; left: -4.5px; }
        .canvas-handle-tr { top: -4.5px; right: -4.5px; }
        .canvas-handle-bl { bottom: -4.5px; left: -4.5px; }
        .canvas-handle-br { bottom: -4.5px; right: -4.5px; }
        .canvas-handle-tc { top: -4.5px; left: calc(50% - 4.5px); }
        .canvas-handle-bc { bottom: -4.5px; left: calc(50% - 4.5px); }
        .canvas-handle-ml { top: calc(50% - 4.5px); left: -4.5px; }
        .canvas-handle-mr { top: calc(50% - 4.5px); right: -4.5px; }

        /* Figma / Canva Floating Action Bar Pop Animation */
        .canvas-action-toolbar {
            filter: drop-shadow(0 12px 28px rgba(15, 23, 42, 0.35));
            animation: figmaActionPop 0.18s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes figmaActionPop {
            0% { opacity: 0; transform: translateY(-6px) scale(0.96); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
    </style>
</head>
<body class="bg-slate-100 font-sans text-slate-800 h-screen flex flex-col overflow-hidden" x-data="pageBuilder()">
    <!-- Hidden input for state synchronization (JSON) -->
    <input type="hidden" name="builder_data" id="builder_data_input" :value="JSON.stringify(blocks)">
    <!-- Hidden input for quick canvas image upload -->
    <input type="file" id="canvas-quick-image-input" accept="image/*" class="hidden" @change="handleCanvasImageUpload($event)">
    
    <!-- Top Navbar -->
    <header class="bg-white border-b border-slate-200 shadow-sm flex items-center justify-between px-6 py-3 shrink-0">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.pages.edit', $page->id) }}" class="text-slate-500 hover:text-slate-800 transition-colors flex items-center gap-1 text-sm font-bold bg-slate-100 hover:bg-slate-200 px-3 py-1.5 rounded-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Edit Page
            </a>
            <div class="h-6 w-px bg-slate-200"></div>
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Visual Builder</span>
                <span class="text-sm font-bold text-slate-900">{{ $page->title }}</span>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="button" @click="openAiModal()" class="px-4 py-2 bg-gradient-to-r from-violet-600 via-indigo-600 to-blue-600 hover:from-violet-700 hover:to-indigo-700 text-white rounded-lg text-sm font-bold transition-all shadow-md shadow-indigo-600/25 flex items-center gap-2 group hover:scale-[1.02] active:scale-[0.98]">
                <svg class="w-4 h-4 text-amber-300 animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/>
                </svg>
                <span>✨ AI Assistant</span>
            </button>
            <button type="button" @click="showTemplateModal = true" class="px-4 py-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-lg text-sm font-bold transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Template
            </button>
            <button type="button" @click="saveBuilder" :disabled="isSaving" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-bold transition-all shadow-md shadow-blue-600/25 flex items-center gap-2">
                <span x-show="!isSaving">Simpan Perubahan</span>
                <span x-show="isSaving">Menyimpan...</span>
            </button>
        </div>
    </header>

    <!-- Main Workspace -->
    <main class="flex-1 flex overflow-hidden">
        <!-- Sidebar Workspace -->
        <aside class="w-[450px] bg-white border-r border-slate-200 flex flex-col overflow-y-auto shrink-0 z-10 shadow-lg">
            <div class="p-4 border-b border-slate-100 flex items-center justify-between sticky top-0 bg-white/90 backdrop-blur-sm z-20">
                <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Struktur Halaman
                </h3>
            </div>

            <div class="p-4 space-y-3" id="blocks-container">
                <template x-for="(block, index) in blocks" :key="block.id">
                    <div class="bg-white border border-slate-200 rounded-xl shadow-xs overflow-hidden group block-item">
                        <!-- Block Header -->
                        <div class="flex items-center justify-between p-3 bg-slate-50/80 cursor-pointer hover:bg-slate-100 transition-colors border-b border-slate-200/80" @click="activeBlockIndex = (activeBlockIndex === index ? null : index)">
                            <div class="flex items-center gap-2.5">
                                <span class="drag-handle cursor-grab active:cursor-grabbing p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors flex items-center justify-center shrink-0" @click.stop title="Klik & geser untuk mengubah urutan">
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-500 transition-colors" viewBox="0 0 24 24" fill="currentColor">
                                        <circle cx="8" cy="6" r="1.5"/>
                                        <circle cx="16" cy="6" r="1.5"/>
                                        <circle cx="8" cy="12" r="1.5"/>
                                        <circle cx="16" cy="12" r="1.5"/>
                                        <circle cx="8" cy="18" r="1.5"/>
                                        <circle cx="16" cy="18" r="1.5"/>
                                    </svg>
                                </span>
                                <span class="font-bold text-slate-700 text-xs sm:text-sm" x-text="getBlockLabel(block.type)"></span>
                            </div>
                            <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button type="button" @click.stop="moveUp(index)" x-show="index > 0" class="p-1 text-slate-400 hover:text-blue-600" title="Geser ke Atas"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg></button>
                                <button type="button" @click.stop="moveDown(index)" x-show="index < blocks.length - 1" class="p-1 text-slate-400 hover:text-blue-600" title="Geser ke Bawah"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
                                <button type="button" @click.stop="duplicateBlock(index)" class="p-1 text-slate-400 hover:text-green-600" title="Duplikasi"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg></button>
                                <button type="button" @click.stop="removeBlock(index)" class="p-1 text-slate-400 hover:text-red-600" title="Hapus"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            </div>
                        </div>
                        
                        <!-- Block Form -->
                        <div x-show="activeBlockIndex === index" style="display: none;" class="p-4 bg-white">
                            
                            <!-- General Settings (Background, Spacing, Align, Wrapper Class) -->
                            <div class="space-y-3 mb-4 pb-4 border-b border-slate-100">
                                <div class="flex gap-3">
                                    <div class="flex-1">
                                        <label class="block text-[10px] uppercase font-bold text-slate-500 mb-1">Background</label>
                                        <select x-model="block.settings.bg" class="w-full text-xs border-slate-200 rounded-md">
                                            <option value="white">Putih</option>
                                            <option value="gray">Abu-abu Muda</option>
                                            <option value="blue">Biru Muda</option>
                                            <option value="transparent">Transparan / Bersih</option>
                                        </select>
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-[10px] uppercase font-bold text-slate-500 mb-1">Padding</label>
                                        <select x-model="block.settings.padding" class="w-full text-xs border-slate-200 rounded-md">
                                            <option value="none">Tanpa Padding (0)</option>
                                            <option value="small">Kecil</option>
                                            <option value="medium">Sedang</option>
                                            <option value="large">Besar</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] uppercase font-bold text-slate-500 mb-1">Custom Wrapper Class (Tailwind)</label>
                                    <input type="text" x-model="block.settings.wrapper_class" placeholder="misal: bg-white rounded-3xl p-6 md:p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] mb-8" class="w-full text-xs font-mono border-slate-200 rounded-md">
                                    <span class="text-[10px] text-slate-400 mt-0.5 block">Class khusus wadah kartu/section (misal: bg-white rounded-3xl p-6...)</span>
                                </div>
                            </div>

                            <!-- Dynamic Form based on Type -->
                            <template x-if="block.type === 'hero'">
                                <div class="space-y-4">
                                    <div>
                                        <div class="flex justify-between items-center mb-1">
                                            <label class="text-xs font-bold">Judul Utama</label>
                                            <button type="button" @click="openTextSettings(block.content, 'title_settings', 'Pengaturan Judul Utama')" class="text-[10px] bg-slate-100 px-2 py-1 rounded text-blue-600 hover:bg-blue-100 font-bold flex items-center gap-1">⚙️ Style Teks</button>
                                        </div>
                                        <input type="text" x-model="block.content.title" class="w-full text-sm rounded-md border-slate-200">
                                    </div>
                                    <div>
                                        <div class="flex justify-between items-center mb-1">
                                            <label class="text-xs font-bold">Deskripsi</label>
                                            <button type="button" @click="openTextSettings(block.content, 'description_settings', 'Pengaturan Deskripsi')" class="text-[10px] bg-slate-100 px-2 py-1 rounded text-blue-600 hover:bg-blue-100 font-bold flex items-center gap-1">⚙️ Style Teks</button>
                                        </div>
                                        <textarea x-model="block.content.description" rows="3" class="w-full text-sm rounded-md border-slate-200"></textarea>
                                    </div>
                                    <div class="flex gap-2">
                                        <div class="flex-1"><label class="text-xs font-bold">Teks Tombol</label><input type="text" x-model="block.content.button_text" class="w-full text-sm rounded-md border-slate-200"></div>
                                        <div class="flex-1"><label class="text-xs font-bold">URL Tombol</label><input type="text" x-model="block.content.button_url" class="w-full text-sm rounded-md border-slate-200"></div>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-slate-700 block mb-1">Gambar Latar (Overlay Gradient)</label>
                                        <div class="flex gap-2">
                                            <input type="text" x-model="block.content.bg_image" placeholder="https://... atau /storage/..." class="flex-1 text-xs rounded-md border-slate-200">
                                            <label class="cursor-pointer px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-md text-xs font-bold flex items-center gap-1 border border-blue-200 shrink-0">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                                <span class="upload-label">Upload</span>
                                                <input type="file" accept="image/*" class="hidden" @change="uploadImage($event, block, 'bg_image')">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            
                            <template x-if="block.type === 'text' || block.type === 'html' || block.type === 'html_custom'">
                                <div class="space-y-3">
                                    <div>
                                        <label class="text-xs font-bold text-slate-700 block mb-1">HTML / Konten Teks</label>
                                        <template x-if="typeof block.content === 'string'">
                                            <textarea x-model="block.content" rows="8" class="w-full font-mono text-xs rounded-md border-slate-200"></textarea>
                                        </template>
                                        <template x-if="typeof block.content === 'object' && block.content !== null">
                                            <textarea x-model="block.content.html" rows="8" class="w-full font-mono text-xs rounded-md border-slate-200"></textarea>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <template x-if="block.type === 'image'">
                                <div class="space-y-4">
                                    <!-- Input & Upload Gambar -->
                                    <div>
                                        <label class="text-xs font-bold text-slate-700 block mb-1">Pilih / URL Gambar</label>
                                        <div class="space-y-2">
                                            <div class="flex gap-2">
                                                <input type="text" x-model="block.content.image" placeholder="https://... atau /storage/..." class="flex-1 text-xs rounded-md border-slate-200">
                                                <label class="cursor-pointer px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-md text-xs font-bold flex items-center gap-1 border border-blue-200 shrink-0">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                                    <span class="upload-label">Upload</span>
                                                    <input type="file" accept="image/*" class="hidden" @change="uploadImage($event, block)">
                                                </label>
                                            </div>

                                            <!-- Thumbnail Preview jika gambar terisi -->
                                            <template x-if="block.content.image">
                                                <div class="relative rounded-lg overflow-hidden border border-slate-200 bg-slate-50 p-2 flex items-center justify-center">
                                                    <img :src="block.content.image" alt="Preview" class="max-h-36 w-auto object-contain rounded">
                                                    <button type="button" @click="block.content.image = ''" class="absolute top-2 right-2 bg-red-600/80 hover:bg-red-700 text-white rounded-full p-1 text-xs shadow" title="Hapus Gambar">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                    </div>

                                    <!-- Lebar Gambar & Perataan -->
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="text-xs font-bold text-slate-700 block mb-1">Lebar Gambar</label>
                                            <select x-model="block.content.width" class="w-full text-xs rounded-md border-slate-200">
                                                <option value="w-full">Penuh Layar (Full Width)</option>
                                                <option value="max-w-5xl">Besar (Maks 5XL)</option>
                                                <option value="max-w-3xl">Sedang (Maks 3XL)</option>
                                                <option value="max-w-xl">Kecil (Maks XL)</option>
                                                <option value="max-w-md">Kompak (Maks MD)</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="text-xs font-bold text-slate-700 block mb-1">Perataan Posisi</label>
                                            <select x-model="block.settings.align" class="w-full text-xs rounded-md border-slate-200">
                                                <option value="center">Tengah (Center)</option>
                                                <option value="left">Rata Kiri</option>
                                                <option value="right">Rata Kanan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Lengkungan Sudut & Bayangan -->
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="text-xs font-bold text-slate-700 block mb-1">Lengkungan Sudut</label>
                                            <select x-model="block.content.rounded" class="w-full text-xs rounded-md border-slate-200">
                                                <option value="rounded-none">Persegi (Tanpa Lengkung)</option>
                                                <option value="rounded-lg">Lengkung Halus (lg)</option>
                                                <option value="rounded-2xl">Lengkung Modern (2xl)</option>
                                                <option value="rounded-3xl">Lengkung Ekstra (3xl)</option>
                                                <option value="rounded-full">Melingkar (Circle)</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="text-xs font-bold text-slate-700 block mb-1">Efek Bayangan</label>
                                            <select x-model="block.content.shadow" class="w-full text-xs rounded-md border-slate-200">
                                                <option value="shadow-none">Tanpa Bayangan</option>
                                                <option value="shadow-md">Bayangan Ringan</option>
                                                <option value="shadow-lg">Bayangan Standar</option>
                                                <option value="shadow-2xl">Bayangan Tebal</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Keterangan / Caption -->
                                    <div>
                                        <label class="text-xs font-bold text-slate-700 block mb-1">Keterangan / Caption (Opsional)</label>
                                        <input type="text" x-model="block.content.caption" placeholder="Contoh: Dokumentasi Kegiatan Sosialisasi 2026" class="w-full text-xs rounded-md border-slate-200">
                                    </div>

                                    <!-- Alt Text -->
                                    <div>
                                        <label class="text-xs font-bold text-slate-700 block mb-1">Alt Text (SEO & Aksesibilitas)</label>
                                        <input type="text" x-model="block.content.alt" placeholder="Deskripsi ringkas isi gambar" class="w-full text-xs rounded-md border-slate-200">
                                    </div>

                                    <!-- Tautan Gambar (Link) -->
                                    <div>
                                        <label class="text-xs font-bold text-slate-700 block mb-1">Tautan / Link Gambar (Opsional)</label>
                                        <input type="text" x-model="block.content.link" placeholder="https://... (ketika gambar diklik)" class="w-full text-xs rounded-md border-slate-200">
                                    </div>
                                </div>
                            </template>
                            
                            <template x-if="block.type === 'image_text'">
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-xs font-bold text-slate-700 block mb-1">URL / File Gambar</label>
                                        <div class="flex gap-2">
                                            <input type="text" x-model="block.content.image" placeholder="https://... atau /storage/..." class="flex-1 text-xs rounded-md border-slate-200">
                                            <label class="cursor-pointer px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-md text-xs font-bold flex items-center gap-1 border border-blue-200 shrink-0">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                                <span class="upload-label">Upload</span>
                                                <input type="file" accept="image/*" class="hidden" @change="uploadImage($event, block)">
                                            </label>
                                        </div>
                                    </div>
                                    <div><label class="text-xs font-bold">Posisi Gambar</label>
                                        <select x-model="block.settings.image_position" class="w-full text-sm rounded-md border-slate-200">
                                            <option value="left">Kiri (50/50)</option>
                                            <option value="right">Kanan (50/50)</option>
                                            <option value="bottom">Gambar di Bawah Teks (Full Width)</option>
                                            <option value="top">Gambar di Atas Teks (Full Width)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <div class="flex justify-between items-center mb-1">
                                            <label class="text-xs font-bold">Judul / Header (Mendukung HTML)</label>
                                            <button type="button" @click="openTextSettings(block.content, 'title_settings', 'Pengaturan Judul')" class="text-[10px] bg-slate-100 px-2 py-1 rounded text-blue-600 hover:bg-blue-100 font-bold flex items-center gap-1">⚙️ Style Teks</button>
                                        </div>
                                        <textarea x-model="block.content.title" :rows="block.content.title && block.content.title.includes('<') ? 4 : 2" class="w-full text-xs font-mono rounded-md border-slate-200"></textarea>
                                    </div>
                                    <div>
                                        <div class="flex justify-between items-center mb-1">
                                            <label class="text-xs font-bold">Deskripsi (HTML)</label>
                                        </div>
                                        <textarea x-model="block.content.description" rows="3" class="w-full text-sm rounded-md border-slate-200"></textarea>
                                    </div>
                                    <div class="flex gap-2">
                                        <div class="flex-1"><label class="text-xs font-bold">Teks Tombol</label><input type="text" x-model="block.content.button_text" class="w-full text-sm rounded-md border-slate-200"></div>
                                        <div class="flex-1"><label class="text-xs font-bold">URL Tombol</label><input type="text" x-model="block.content.button_url" class="w-full text-sm rounded-md border-slate-200"></div>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-slate-700 block mb-1">Gambar Latar (Overlay Gradient)</label>
                                        <div class="flex gap-2">
                                            <input type="text" x-model="block.content.bg_image" placeholder="https://... atau /storage/..." class="flex-1 text-xs rounded-md border-slate-200">
                                            <label class="cursor-pointer px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-md text-xs font-bold flex items-center gap-1 border border-blue-200 shrink-0">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                                <span class="upload-label">Upload</span>
                                                <input type="file" accept="image/*" class="hidden" @change="uploadImage($event, block, 'bg_image')">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <template x-if="block.type === 'cards'">
                                <div class="space-y-4">
                                    <div>
                                        <div class="flex justify-between items-center mb-1">
                                            <label class="text-xs font-bold">Heading Utama</label>
                                            <button type="button" @click="openTextSettings(block.content, 'heading_settings', 'Pengaturan Heading Utama')" class="text-[10px] bg-slate-100 px-2 py-1 rounded text-blue-600 hover:bg-blue-100 font-bold flex items-center gap-1">⚙️ Style Teks</button>
                                        </div>
                                        <input type="text" x-model="block.content.heading" class="w-full text-sm rounded-md border-slate-200">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold">Jumlah Kolom</label>
                                        <select x-model="block.content.columns" class="w-full text-sm rounded-md border-slate-200">
                                            <option value="2">2 Kolom</option><option value="3">3 Kolom</option><option value="4">4 Kolom</option>
                                        </select>
                                    </div>
                                    <div class="border-t border-slate-100 pt-3 mt-3">
                                        <label class="text-xs font-bold mb-2 block">Item Cards</label>
                                        <template x-for="(item, iIndex) in block.content.items" :key="iIndex">
                                            <div class="bg-slate-50 p-3 rounded-lg mb-2 border border-slate-200 relative">
                                                <button type="button" @click="block.content.items.splice(iIndex, 1)" class="absolute top-2 right-2 text-red-500 hover:text-red-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                                <input type="text" x-model="item.image" placeholder="URL Gambar" class="w-full text-xs rounded mb-2 border-slate-200">
                                                
                                                <div class="flex justify-between items-center mb-1">
                                                    <label class="text-[10px] font-bold text-slate-500">Judul Card</label>
                                                    <button type="button" @click="openTextSettings(item, 'title_settings', 'Pengaturan Judul Card')" class="text-[10px] text-blue-600 hover:underline">⚙️ Style</button>
                                                </div>
                                                <input type="text" x-model="item.title" placeholder="Judul Card" class="w-full text-xs font-bold rounded mb-2 border-slate-200">
                                                
                                                <div class="flex justify-between items-center mb-1">
                                                    <label class="text-[10px] font-bold text-slate-500">Deskripsi Card</label>
                                                    <button type="button" @click="openTextSettings(item, 'description_settings', 'Pengaturan Deskripsi Card')" class="text-[10px] text-blue-600 hover:underline">⚙️ Style</button>
                                                </div>
                                                <textarea x-model="item.description" rows="2" placeholder="Deskripsi Singkat" class="w-full text-xs rounded mb-2 border-slate-200"></textarea>
                                                
                                                <div class="flex gap-2 mt-2">
                                                    <input type="text" x-model="item.button_text" placeholder="Teks Tombol" class="w-full text-xs rounded border-slate-200">
                                                    <input type="text" x-model="item.button_url" placeholder="URL Tombol" class="w-full text-xs rounded border-slate-200">
                                                </div>
                                            </div>
                                        </template>
                                        <button type="button" @click="block.content.items.push({image:'', title:'', description:'', button_text:'', button_url:''})" class="w-full py-2 bg-white border border-dashed border-slate-300 text-slate-500 text-xs font-bold rounded-lg hover:border-blue-500 hover:text-blue-500">+ Tambah Card</button>
                                    </div>
                                </div>
                            </template>

                            <template x-if="block.type === 'list' || block.type === 'lists'">
                                <div class="space-y-4">
                                    <!-- Heading -->
                                    <div>
                                        <div class="flex justify-between items-center mb-1">
                                            <label class="text-xs font-bold text-slate-700">Judul / Heading (Opsional)</label>
                                            <button type="button" @click="openTextSettings(block.content, 'heading_settings', 'Pengaturan Judul List')" class="text-[10px] bg-slate-100 px-2 py-1 rounded text-blue-600 hover:bg-blue-100 font-bold flex items-center gap-1">⚙️ Style Teks</button>
                                        </div>
                                        <input type="text" x-model="block.content.heading" placeholder="Contoh: Dokumen Persyaratan Layanan" class="w-full text-sm rounded-md border-slate-200">
                                    </div>

                                    <!-- Deskripsi Pembuka -->
                                    <div>
                                        <label class="text-xs font-bold text-slate-700 block mb-1">Deskripsi Pengantar (Opsional)</label>
                                        <textarea x-model="block.content.description" rows="2" placeholder="Penjelasan singkat pengantar daftar..." class="w-full text-xs rounded-md border-slate-200"></textarea>
                                    </div>

                                    <!-- Gaya List & Jumlah Kolom -->
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="text-xs font-bold text-slate-700 block mb-1">Gaya Tampilan (Ikon)</label>
                                            <select x-model="block.content.style" class="w-full text-xs rounded-md border-slate-200">
                                                <option value="check">Ceklis Hijau (✓)</option>
                                                <option value="number">Angka Bernomor (1, 2, 3)</option>
                                                <option value="arrow">Panah Biru (➔)</option>
                                                <option value="bullet">Bullet Titik Bulat (•)</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="text-xs font-bold text-slate-700 block mb-1">Tata Letak (Kolom)</label>
                                            <select x-model="block.content.columns" class="w-full text-xs rounded-md border-slate-200">
                                                <option value="1">1 Kolom (Menurun)</option>
                                                <option value="2">2 Kolom (Berdampingan)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Daftar Items -->
                                    <div class="border-t border-slate-100 pt-3 mt-3">
                                        <div class="flex items-center justify-between mb-2">
                                            <label class="text-xs font-bold text-slate-700">Daftar Poin / Item</label>
                                            <span class="text-[10px] text-slate-400" x-text="(block.content.items || []).length + ' item'"></span>
                                        </div>
                                        
                                        <div class="space-y-2">
                                            <template x-for="(item, iIndex) in block.content.items" :key="iIndex">
                                                <div class="bg-slate-50 p-3 rounded-lg border border-slate-200 relative group">
                                                    <div class="flex items-center justify-between mb-1.5">
                                                        <span class="text-[10px] font-bold text-slate-400" x-text="'Item #' + (iIndex + 1)"></span>
                                                        <div class="flex items-center gap-1">
                                                            <button type="button" @click="if(iIndex > 0) { const temp = block.content.items[iIndex]; block.content.items[iIndex] = block.content.items[iIndex-1]; block.content.items[iIndex-1] = temp; }" x-show="iIndex > 0" class="text-slate-400 hover:text-blue-600 p-0.5" title="Naik"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg></button>
                                                            <button type="button" @click="if(iIndex < block.content.items.length - 1) { const temp = block.content.items[iIndex]; block.content.items[iIndex] = block.content.items[iIndex+1]; block.content.items[iIndex+1] = temp; }" x-show="iIndex < block.content.items.length - 1" class="text-slate-400 hover:text-blue-600 p-0.5" title="Turun"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
                                                            <button type="button" @click="block.content.items.splice(iIndex, 1)" class="text-red-400 hover:text-red-600 p-0.5 ml-1" title="Hapus"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                                        </div>
                                                    </div>

                                                    <!-- Teks Item -->
                                                    <input type="text" x-model="item.title" placeholder="Teks poin / butir daftar..." class="w-full text-xs font-semibold rounded mb-1.5 border-slate-200">
                                                    
                                                    <!-- Keterangan Tambahan (Opsional) -->
                                                    <textarea x-model="item.description" rows="1" placeholder="Keterangan tambahan (opsional)..." class="w-full text-[11px] rounded mb-1.5 border-slate-200"></textarea>

                                                    <!-- Tautan (Opsional) -->
                                                    <input type="text" x-model="item.link" placeholder="Tautan / Link URL (opsional)..." class="w-full text-[11px] rounded border-slate-200">
                                                </div>
                                            </template>
                                        </div>

                                        <button type="button" @click="block.content.items.push({title:'', description:'', link:''})" class="w-full mt-2 py-2 bg-white border border-dashed border-slate-300 text-slate-600 text-xs font-bold rounded-lg hover:border-blue-500 hover:text-blue-600 transition-colors flex items-center justify-center gap-1.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            + Tambah Item List
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <!-- Dynamic Form: Gallery Slider -->
                            <template x-if="block.type === 'gallery_slider'">
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-xs font-bold text-slate-700 block mb-1">Judul Galeri</label>
                                        <input type="text" x-model="block.content.heading" class="w-full text-xs rounded-md border-slate-200">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-slate-700 block mb-1">Subjudul / Keterangan</label>
                                        <input type="text" x-model="block.content.subheading" class="w-full text-xs rounded-md border-slate-200">
                                    </div>
                                    <div>
                                        <div class="flex justify-between items-center mb-2">
                                            <label class="text-xs font-bold text-slate-700">Daftar Foto Pegawai</label>
                                            <span class="text-[10px] text-slate-400" x-text="(block.content.items || []).length + ' Foto'"></span>
                                        </div>
                                        <div class="space-y-2">
                                            <template x-for="(item, pIdx) in block.content.items" :key="pIdx">
                                                <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 space-y-2">
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-[10px] font-bold text-slate-400" x-text="'Pegawai #' + (pIdx + 1)"></span>
                                                        <div class="flex items-center gap-1">
                                                            <button type="button" @click="if(pIdx > 0) { const temp = block.content.items[pIdx]; block.content.items[pIdx] = block.content.items[pIdx-1]; block.content.items[pIdx-1] = temp; }" x-show="pIdx > 0" class="text-slate-400 hover:text-blue-600 p-0.5"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg></button>
                                                            <button type="button" @click="if(pIdx < block.content.items.length - 1) { const temp = block.content.items[pIdx]; block.content.items[pIdx] = block.content.items[pIdx+1]; block.content.items[pIdx+1] = temp; }" x-show="pIdx < block.content.items.length - 1" class="text-slate-400 hover:text-blue-600 p-0.5"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
                                                            <button type="button" @click="block.content.items.splice(pIdx, 1)" class="text-red-400 hover:text-red-600 p-0.5 ml-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                                        </div>
                                                    </div>
                                                    <input type="text" x-model="item.name" placeholder="Nama Lengkap..." class="w-full text-xs font-semibold rounded border-slate-200">
                                                    <input type="text" x-model="item.role" placeholder="Jabatan / Bidang..." class="w-full text-[11px] rounded border-slate-200">
                                                    <div class="flex gap-2">
                                                        <input type="text" x-model="item.image" placeholder="URL Foto..." class="flex-1 text-[11px] rounded border-slate-200">
                                                        <label class="cursor-pointer px-2.5 py-1 bg-blue-50 text-blue-600 rounded text-xs font-bold border border-blue-200 shrink-0 flex items-center">
                                                            <span class="upload-label">Upload</span>
                                                            <input type="file" accept="image/*" class="hidden" @change="uploadImage($event, item)">
                                                        </label>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                        <button type="button" @click="block.content.items.push({name: 'Nama Pegawai', role: 'Jabatan', image: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=300&h=300&fit=crop'})" class="w-full mt-2 py-2 bg-white border border-dashed border-slate-300 text-slate-600 text-xs font-bold rounded-lg hover:border-blue-500 hover:text-blue-600 transition-colors flex items-center justify-center gap-1.5">
                                            + Tambah Foto Pegawai
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <!-- Dynamic Form: Glass Split (Glassmorphism Split Content) -->
                            <template x-if="block.type === 'glass_split'">
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-xs font-bold text-slate-700 block mb-1">Tagline / Kategori</label>
                                        <input type="text" x-model="block.content.tagline" placeholder="misal: KATA SAMBUTAN" class="w-full text-xs font-bold rounded-lg border-slate-200">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-slate-700 block mb-1">Judul Utama</label>
                                        <input type="text" x-model="block.content.title" placeholder="Judul section..." class="w-full text-sm font-bold rounded-lg border-slate-200">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-slate-700 block mb-1">Deskripsi / Teks Paragraf (HTML)</label>
                                        <textarea x-model="block.content.description" rows="4" placeholder="<p>Teks paragraf sambutan...</p>" class="w-full text-xs rounded-lg border-slate-200 font-mono"></textarea>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-slate-700 block mb-1">Foto / Gambar</label>
                                        <div class="space-y-2">
                                            <div class="flex gap-2">
                                                <input type="text" x-model="block.content.image_url" placeholder="https://... atau /storage/..." class="flex-1 text-xs rounded-lg border-slate-200">
                                                <label class="cursor-pointer px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-xs font-bold flex items-center gap-1 border border-blue-200 shrink-0">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                                    <span class="upload-label">Upload</span>
                                                    <input type="file" accept="image/*" class="hidden" @change="uploadImage($event, block.content, 'image_url')">
                                                </label>
                                            </div>
                                            <template x-if="block.content.image_url">
                                                <div class="relative rounded-xl overflow-hidden border border-slate-200 bg-slate-50 p-2 flex items-center justify-center">
                                                    <img :src="block.content.image_url" alt="Preview" class="max-h-36 w-auto object-cover rounded-lg">
                                                    <button type="button" @click="block.content.image_url = ''" class="absolute top-2 right-2 bg-red-600/80 hover:bg-red-700 text-white rounded-full p-1 text-xs shadow" title="Hapus Gambar">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-slate-700 block mb-1">Posisi Gambar</label>
                                        <select x-model="block.content.image_position" class="w-full text-xs rounded-lg border-slate-200">
                                            <option value="left">Kiri (Teks di Kanan)</option>
                                            <option value="right">Kanan (Teks di Kiri)</option>
                                        </select>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <label class="text-xs font-bold text-slate-700 block mb-1">Teks Tombol</label>
                                            <input type="text" x-model="block.content.button_text" placeholder="BACA SEKARANG" class="w-full text-xs rounded-lg border-slate-200">
                                        </div>
                                        <div>
                                            <label class="text-xs font-bold text-slate-700 block mb-1">URL Tombol</label>
                                            <input type="text" x-model="block.content.button_link" placeholder="#" class="w-full text-xs rounded-lg border-slate-200">
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- Dynamic Form: Glass Cards Grid -->
                            <template x-if="block.type === 'glass_cards'">
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-xs font-bold text-slate-700 block mb-1">Judul Bagian (Section Title)</label>
                                        <input type="text" x-model="block.content.section_title" placeholder="misal: Profil Mutu per Daerah" class="w-full text-sm font-bold rounded-lg border-slate-200">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-slate-700 block mb-1">Subjudul (Subtitle)</label>
                                        <input type="text" x-model="block.content.section_subtitle" placeholder="Keterangan singkat..." class="w-full text-xs rounded-lg border-slate-200">
                                    </div>
                                    <div>
                                        <div class="flex justify-between items-center mb-2">
                                            <label class="text-xs font-bold text-slate-700">Daftar Kartu</label>
                                            <span class="text-[10px] text-slate-400" x-text="(block.content.cards || []).length + ' Kartu'"></span>
                                        </div>
                                        <div class="space-y-3">
                                            <template x-for="(card, cIdx) in block.content.cards" :key="cIdx">
                                                <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 space-y-2 relative group">
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-[10px] font-bold text-blue-600 uppercase" x-text="'Kartu #' + (cIdx + 1)"></span>
                                                        <div class="flex items-center gap-1">
                                                            <button type="button" @click="if(cIdx > 0) { const temp = block.content.cards[cIdx]; block.content.cards[cIdx] = block.content.cards[cIdx-1]; block.content.cards[cIdx-1] = temp; }" x-show="cIdx > 0" class="text-slate-400 hover:text-blue-600 p-0.5" title="Geser Naik"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg></button>
                                                            <button type="button" @click="if(cIdx < block.content.cards.length - 1) { const temp = block.content.cards[cIdx]; block.content.cards[cIdx] = block.content.cards[cIdx+1]; block.content.cards[cIdx+1] = temp; }" x-show="cIdx < block.content.cards.length - 1" class="text-slate-400 hover:text-blue-600 p-0.5" title="Geser Turun"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></button>
                                                            <button type="button" @click="block.content.cards.splice(cIdx, 1)" class="text-red-400 hover:text-red-600 p-0.5 ml-1" title="Hapus Kartu"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="text-[10px] text-slate-500 font-semibold block mb-0.5">Judul Kartu</label>
                                                        <input type="text" x-model="card.title" placeholder="misal: Kota Kendari" class="w-full text-xs font-bold rounded border-slate-200">
                                                    </div>
                                                    <div class="grid grid-cols-2 gap-2">
                                                        <div>
                                                            <label class="text-[10px] text-slate-500 font-semibold block mb-0.5">Subjudul / Label</label>
                                                            <input type="text" x-model="card.subtitle" placeholder="Unduh Profil" class="w-full text-xs rounded border-slate-200">
                                                        </div>
                                                        <div>
                                                            <label class="text-[10px] text-slate-500 font-semibold block mb-0.5">Ikon</label>
                                                            <select x-model="card.icon" class="w-full text-xs rounded border-slate-200">
                                                                <option value="pdf">PDF Dokumen</option>
                                                                <option value="link">Tautan Luar</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="text-[10px] text-slate-500 font-semibold block mb-0.5">Link / URL Dokumen</label>
                                                        <input type="text" x-model="card.link" placeholder="https://..." class="w-full text-xs rounded border-slate-200 font-mono">
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                        <button type="button" @click="if(!block.content.cards) block.content.cards = []; block.content.cards.push({ title: 'Nama Daerah/Item', subtitle: 'Unduh Profil', link: '#', image: '', icon: 'pdf' })" class="w-full mt-2.5 py-2 bg-white border border-dashed border-slate-300 text-slate-600 text-xs font-bold rounded-xl hover:border-blue-500 hover:text-blue-600 transition-colors flex items-center justify-center gap-1.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            + Tambah Kartu
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <!-- Dynamic Form: Profile Table -->
                            <template x-if="block.type === 'profile_table'">
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-xs font-bold text-slate-700 block mb-1">Foto Pegawai</label>
                                        <div class="flex gap-2">
                                            <input type="text" x-model="block.content.image" placeholder="URL Foto..." class="flex-1 text-xs rounded-md border-slate-200">
                                            <label class="cursor-pointer px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-md text-xs font-bold flex items-center gap-1 border border-blue-200 shrink-0">
                                                <span class="upload-label">Upload</span>
                                                <input type="file" accept="image/*" class="hidden" @change="uploadImage($event, block)">
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-slate-700 block mb-1">Nama Lengkap &amp; Gelar</label>
                                        <input type="text" x-model="block.content.name" class="w-full text-xs font-bold rounded border-slate-200">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-slate-700 block mb-1">Jabatan / Posisi</label>
                                        <input type="text" x-model="block.content.role" class="w-full text-xs rounded border-slate-200">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-slate-700 block mb-1">Ringkasan Bio / Pengantar</label>
                                        <textarea x-model="block.content.bio" rows="2" class="w-full text-xs rounded border-slate-200"></textarea>
                                    </div>
                                    <div>
                                        <div class="flex justify-between items-center mb-1">
                                            <label class="text-xs font-bold text-slate-700">Tabel Rincian Biodata</label>
                                        </div>
                                        <div class="space-y-2">
                                            <template x-for="(row, rIdx) in block.content.details" :key="rIdx">
                                                <div class="flex items-center gap-2 bg-slate-50 p-2 rounded-lg border border-slate-200">
                                                    <input type="text" x-model="row.label" placeholder="Label (mis: NIP)" class="w-1/3 text-xs font-semibold rounded border-slate-200">
                                                    <input type="text" x-model="row.value" placeholder="Nilai..." class="flex-1 text-xs rounded border-slate-200">
                                                    <button type="button" @click="block.content.details.splice(rIdx, 1)" class="text-red-400 hover:text-red-600 p-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                                </div>
                                            </template>
                                        </div>
                                        <button type="button" @click="block.content.details.push({label: 'Label', value: 'Keterangan'})" class="w-full mt-2 py-1.5 bg-white border border-dashed border-slate-300 text-slate-600 text-xs font-bold rounded-lg hover:border-blue-500 hover:text-blue-600 transition-colors">
                                            + Tambah Baris Rincian
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <label class="text-xs font-bold text-slate-700 block mb-1">Teks Tombol Unduh</label>
                                            <input type="text" x-model="block.content.button_text" class="w-full text-xs rounded border-slate-200">
                                        </div>
                                        <div>
                                            <label class="text-xs font-bold text-slate-700 block mb-1">URL Tombol</label>
                                            <input type="text" x-model="block.content.button_url" class="w-full text-xs rounded border-slate-200">
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
                
                <div x-show="blocks.length === 0" class="text-center py-8 text-slate-400 text-sm">
                    Belum ada section. Silakan pilih template atau tambahkan blok di bawah.
                </div>

                <div class="mt-4 pt-4 border-t border-slate-200">
                    <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2.5">Tambah Komponen Blok</span>
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" @click="addBlock('hero')" class="p-2.5 bg-white border border-slate-200/80 shadow-xs hover:border-blue-500 hover:bg-blue-50/50 rounded-xl text-xs font-bold text-slate-700 transition-all flex items-center gap-2 group">
                            <span class="w-6 h-6 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>
                            </span>
                            <span>+ Hero Banner</span>
                        </button>
                        <button type="button" @click="addBlock('image_text')" class="p-2.5 bg-white border border-slate-200/80 shadow-xs hover:border-blue-500 hover:bg-blue-50/50 rounded-xl text-xs font-bold text-slate-700 transition-all flex items-center gap-2 group">
                            <span class="w-6 h-6 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                            </span>
                            <span>+ Img &amp; Teks</span>
                        </button>
                        <button type="button" @click="addBlock('cards')" class="p-2.5 bg-white border border-slate-200/80 shadow-xs hover:border-blue-500 hover:bg-blue-50/50 rounded-xl text-xs font-bold text-slate-700 transition-all flex items-center gap-2 group">
                            <span class="w-6 h-6 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z"></path></svg>
                            </span>
                            <span>+ Cards</span>
                        </button>
                        <button type="button" @click="addBlock('list')" class="p-2.5 bg-white border border-slate-200/80 shadow-xs hover:border-blue-500 hover:bg-blue-50/50 rounded-xl text-xs font-bold text-slate-700 transition-all flex items-center gap-2 group">
                            <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            </span>
                            <span>+ Daftar List</span>
                        </button>
                        <button type="button" @click="addBlock('gallery_slider')" class="p-2.5 bg-white border border-slate-200/80 shadow-xs hover:border-blue-500 hover:bg-blue-50/50 rounded-xl text-xs font-bold text-slate-700 transition-all flex items-center gap-2 group">
                            <span class="w-6 h-6 rounded-lg bg-pink-100 text-pink-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </span>
                            <span>+ Galeri Slider</span>
                        </button>
                        <button type="button" @click="addBlock('profile_table')" class="p-2.5 bg-white border border-slate-200/80 shadow-xs hover:border-blue-500 hover:bg-blue-50/50 rounded-xl text-xs font-bold text-slate-700 transition-all flex items-center gap-2 group">
                            <span class="w-6 h-6 rounded-lg bg-cyan-100 text-cyan-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </span>
                            <span>+ Tabel Profil</span>
                        </button>
                        <button type="button" @click="addBlock('image')" class="p-2.5 bg-white border border-slate-200/80 shadow-xs hover:border-blue-500 hover:bg-blue-50/50 rounded-xl text-xs font-bold text-slate-700 transition-all flex items-center gap-2 group">
                            <span class="w-6 h-6 rounded-lg bg-teal-100 text-teal-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </span>
                            <span>+ Gambar Saja</span>
                        </button>
                        <button type="button" @click="addBlock('text')" class="p-2.5 bg-white border border-slate-200/80 shadow-xs hover:border-blue-500 hover:bg-blue-50/50 rounded-xl text-xs font-bold text-slate-700 transition-all flex items-center gap-2 group">
                            <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                            </span>
                            <span>+ HTML Custom</span>
                        </button>
                        <button type="button" @click="addBlock('glass_split')" class="p-2.5 bg-white border border-slate-200/80 shadow-xs hover:border-blue-500 hover:bg-blue-50/50 rounded-xl text-xs font-bold text-slate-700 transition-all flex items-center gap-2 group">
                            <span class="w-6 h-6 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path></svg>
                            </span>
                            <span>+ Split Glass</span>
                        </button>
                        <button type="button" @click="addBlock('glass_cards')" class="p-2.5 bg-white border border-slate-200/80 shadow-xs hover:border-blue-500 hover:bg-blue-50/50 rounded-xl text-xs font-bold text-slate-700 transition-all flex items-center gap-2 group">
                            <span class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            </span>
                            <span>+ Glass Cards</span>
                        </button>
                        <button type="button" @click="openAiModal()" class="col-span-2 p-2.5 bg-gradient-to-r from-violet-600 via-indigo-600 to-blue-600 hover:from-violet-700 hover:to-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow-md shadow-indigo-600/20 flex items-center justify-center gap-2 group mt-1">
                            <svg class="w-3.5 h-3.5 text-amber-300 animate-pulse" fill="currentColor" viewBox="0 0 24 24"><path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/></svg>
                            <span>✨ Buat Section dengan AI Assistant</span>
                        </button>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Preview Workspace -->
        <section class="flex-1 bg-slate-200 relative overflow-y-auto" id="preview-workspace">
            <!-- Floating Inline Editing Toolbar (Canva / Medium Style) -->
            <div id="inline-floating-toolbar" style="display: none;" 
                 class="fixed z-50 bg-slate-900/95 backdrop-blur-xl text-white rounded-2xl shadow-2xl px-3 py-2 flex items-center gap-1.5 border border-slate-700/80 -translate-x-1/2 -translate-y-full transition-all duration-150 pointer-events-auto select-none">
                
                <!-- Font Family Selection -->
                <select onchange="window.pageBuilderApp.formatFontFamily(this.value)" class="bg-slate-800 text-white text-xs font-semibold rounded-lg px-2.5 py-1.5 border border-slate-700 focus:outline-none focus:border-blue-500 cursor-pointer" title="Pilih Font">
                    <option value="ui-sans-serif, system-ui, sans-serif">Sans-Serif (Inter)</option>
                    <option value="ui-serif, Georgia, Cambria, serif">Serif (Merriweather)</option>
                    <option value="ui-monospace, SFMono-Regular, Menlo, monospace">Monospace</option>
                    <option value="'Playfair Display', serif">Playfair Display</option>
                    <option value="'Poppins', sans-serif">Poppins</option>
                </select>

                <!-- Font Size Controls (- / +) -->
                <div class="flex items-center bg-slate-800/90 rounded-lg p-0.5 border border-slate-700">
                    <button type="button" @mousedown.prevent="changeFontSize(-2)" class="w-6 h-6 flex items-center justify-center text-xs font-bold text-slate-300 hover:text-white hover:bg-slate-700 rounded transition-colors" title="Perkecil Font (-2px)">
                        -
                    </button>
                    <span class="text-[11px] font-mono font-bold px-1.5 min-w-[32px] text-center text-blue-400" x-text="currentFontSize + 'px'">16px</span>
                    <button type="button" @mousedown.prevent="changeFontSize(2)" class="w-6 h-6 flex items-center justify-center text-xs font-bold text-slate-300 hover:text-white hover:bg-slate-700 rounded transition-colors" title="Perbesar Font (+2px)">
                        +
                    </button>
                </div>

                <div class="w-px h-5 bg-slate-700/80 mx-0.5"></div>

                <!-- Text Formats: Bold, Italic, Underline, Strikethrough -->
                <div class="flex items-center gap-0.5">
                    <button type="button" @mousedown.prevent="formatInline('bold')" class="p-1 hover:bg-slate-700 active:bg-blue-600 rounded-lg text-xs font-bold w-7 h-7 flex items-center justify-center transition-colors" title="Tebal (Bold)">
                        <strong>B</strong>
                    </button>
                    <button type="button" @mousedown.prevent="formatInline('italic')" class="p-1 hover:bg-slate-700 active:bg-blue-600 rounded-lg text-xs italic font-serif w-7 h-7 flex items-center justify-center transition-colors" title="Miring (Italic)">
                        <em>I</em>
                    </button>
                    <button type="button" @mousedown.prevent="formatInline('underline')" class="p-1 hover:bg-slate-700 active:bg-blue-600 rounded-lg text-xs underline w-7 h-7 flex items-center justify-center transition-colors" title="Garis Bawah (Underline)">
                        <u>U</u>
                    </button>
                    <button type="button" @mousedown.prevent="formatInline('strikeThrough')" class="p-1 hover:bg-slate-700 active:bg-blue-600 rounded-lg text-xs line-through w-7 h-7 flex items-center justify-center transition-colors text-slate-300" title="Coret (Strikethrough)">
                        <s>S</s>
                    </button>
                </div>

                <div class="w-px h-5 bg-slate-700/80 mx-0.5"></div>

                <!-- Alignments: Left, Center, Right, Justify -->
                <div class="flex items-center gap-0.5">
                    <button type="button" @mousedown.prevent="formatInline('justifyLeft')" class="p-1 hover:bg-slate-700 active:bg-blue-600 rounded-lg w-7 h-7 flex items-center justify-center transition-colors text-slate-300 hover:text-white" title="Rata Kiri">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h10M4 18h14"/></svg>
                    </button>
                    <button type="button" @mousedown.prevent="formatInline('justifyCenter')" class="p-1 hover:bg-slate-700 active:bg-blue-600 rounded-lg w-7 h-7 flex items-center justify-center transition-colors text-slate-300 hover:text-white" title="Rata Tengah">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M7 12h10M5 18h14"/></svg>
                    </button>
                    <button type="button" @mousedown.prevent="formatInline('justifyRight')" class="p-1 hover:bg-slate-700 active:bg-blue-600 rounded-lg w-7 h-7 flex items-center justify-center transition-colors text-slate-300 hover:text-white" title="Rata Kanan">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M10 12h10M6 18h14"/></svg>
                    </button>
                    <button type="button" @mousedown.prevent="formatInline('justifyFull')" class="p-1 hover:bg-slate-700 active:bg-blue-600 rounded-lg w-7 h-7 flex items-center justify-center transition-colors text-slate-300 hover:text-white" title="Rata Kiri-Kanan (Justify)">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>

                <div class="w-px h-5 bg-slate-700/80 mx-0.5"></div>

                <!-- Text Color -->
                <div class="relative flex items-center">
                    <label class="cursor-pointer p-1 hover:bg-slate-700 active:bg-blue-600 rounded-lg w-7 h-7 flex flex-col items-center justify-center transition-colors relative" title="Warna Teks">
                        <span class="text-xs font-bold leading-none">A</span>
                        <span class="w-3.5 h-1 rounded-xs mt-0.5 bg-blue-500" :style="{ backgroundColor: activeTextColor || '#3b82f6' }"></span>
                        <input type="color" @input="formatTextColor($event.target.value)" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                    </label>
                </div>

                <!-- Highlight Color (Stabilo) -->
                <div class="relative flex items-center">
                    <label class="cursor-pointer p-1 hover:bg-slate-700 active:bg-blue-600 rounded-lg w-7 h-7 flex flex-col items-center justify-center transition-colors relative" title="Warna Stabilo (Highlight)">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        <span class="w-3.5 h-1 rounded-xs mt-0.5 bg-yellow-400" :style="{ backgroundColor: activeHiliteColor || '#facc15' }"></span>
                        <input type="color" value="#fef08a" @input="formatHiliteColor($event.target.value)" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                    </label>
                </div>

                <div class="w-px h-5 bg-slate-700/80 mx-0.5"></div>

                <!-- Link & Unlink -->
                <button type="button" @mousedown.prevent="formatInline('createLink')" class="p-1 hover:bg-slate-700 active:bg-blue-600 rounded-lg text-xs w-7 h-7 flex items-center justify-center transition-colors text-blue-400 hover:text-blue-300" title="Sisipkan Tautan">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                </button>
                <button type="button" @mousedown.prevent="formatInline('unlink')" class="p-1 hover:bg-slate-700 active:bg-rose-600 rounded-lg text-xs w-7 h-7 flex items-center justify-center transition-colors text-slate-400 hover:text-rose-300" title="Hapus Tautan">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                </button>
            </div>

            <!-- Block Context Menu (Canva Style Dropdown) -->
            <div id="block-context-menu" style="display: none;" 
                 class="fixed z-50 bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-slate-200/90 py-1.5 w-56 text-slate-700 select-none">
                <div class="px-3.5 py-1.5 border-b border-slate-100 mb-1 flex items-center justify-between text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    <span>Opsi Blok</span>
                    <span id="context-menu-block-label" class="text-blue-600 font-semibold lowercase"></span>
                </div>

                <!-- [Ikon Copy] Duplikat -->
                <button type="button" @mousedown.prevent="duplicateFromContext()" class="w-full px-3.5 py-2 text-left text-xs font-semibold hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2.5 transition-colors group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    <span>Duplikat Blok</span>
                </button>

                <!-- [Ikon Panah Atas] Naikkan Layer -->
                <button type="button" @mousedown.prevent="moveUpFromContext()" class="w-full px-3.5 py-2 text-left text-xs font-semibold hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2.5 transition-colors group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                    <span>Naikkan Layer (Ke Atas)</span>
                </button>

                <!-- [Ikon Panah Bawah] Turunkan Layer -->
                <button type="button" @mousedown.prevent="moveDownFromContext()" class="w-full px-3.5 py-2 text-left text-xs font-semibold hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2.5 transition-colors group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    <span>Turunkan Layer (Ke Bawah)</span>
                </button>

                <!-- Edit di Sidebar -->
                <button type="button" @mousedown.prevent="editInSidebarFromContext()" class="w-full px-3.5 py-2 text-left text-xs font-semibold hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2.5 transition-colors group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span>Edit di Panel Sidebar</span>
                </button>

                <div class="h-px bg-slate-100 my-1"></div>

                <!-- [Ikon Trash] Hapus -->
                <button type="button" @mousedown.prevent="removeFromContext()" class="w-full px-3.5 py-2 text-left text-xs font-semibold text-rose-600 hover:bg-rose-50 flex items-center gap-2.5 transition-colors group">
                    <svg class="w-4 h-4 text-rose-500 group-hover:text-rose-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    <span>Hapus Blok</span>
                </button>
            </div>

            <div class="min-h-full w-full bg-white shadow-2xl relative builder-canvas-scope" id="preview-container">
                <!-- Live preview renders here -->
            </div>

            <!-- Toast Notification -->
            <div x-show="showToast" x-transition.opacity style="display: none;" class="fixed bottom-6 right-6 bg-slate-800 text-white px-6 py-3 rounded-xl shadow-2xl font-bold flex items-center gap-3 z-50">
                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Halaman berhasil disimpan!
            </div>
        </section>
    </main>

    <!-- Text Style Modal -->
    <div x-show="isTextSettingsOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm">
        <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]" @click.away="closeTextSettings()">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="font-bold text-lg text-slate-900" x-text="textSettingsTitle">Pengaturan Teks</h3>
                <button type="button" @click="closeTextSettings()" class="text-slate-400 hover:text-slate-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            
            <div class="p-6 overflow-y-auto">
                <template x-if="activeTextSettingsRef">
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Ukuran -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Ukuran (Size)</label>
                            <select x-model="activeTextSettingsRef.size" class="w-full text-sm rounded-lg border-slate-200">
                                <option value="">Default (Bawaan)</option>
                                <option value="text-xs">Sangat Kecil (xs)</option>
                                <option value="text-sm">Kecil (sm)</option>
                                <option value="text-base">Normal (base)</option>
                                <option value="text-lg">Sedikit Besar (lg)</option>
                                <option value="text-xl">Besar (xl)</option>
                                <option value="text-2xl">Sangat Besar (2xl)</option>
                                <option value="text-3xl">Lebih Besar (3xl)</option>
                                <option value="text-4xl">4XL (Judul)</option>
                                <option value="text-5xl">5XL (Judul Besar)</option>
                                <option value="text-6xl">6XL (Raksasa)</option>
                            </select>
                        </div>
                        
                        <!-- Ketebalan -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Ketebalan (Weight)</label>
                            <select x-model="activeTextSettingsRef.weight" class="w-full text-sm rounded-lg border-slate-200">
                                <option value="">Default (Bawaan)</option>
                                <option value="font-light">Light</option>
                                <option value="font-normal">Normal</option>
                                <option value="font-medium">Medium</option>
                                <option value="font-semibold">Semi Bold</option>
                                <option value="font-bold">Bold</option>
                                <option value="font-extrabold">Extra Bold</option>
                            </select>
                        </div>

                        <!-- Alignment -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Alignment</label>
                            <select x-model="activeTextSettingsRef.align" class="w-full text-sm rounded-lg border-slate-200">
                                <option value="">Default (Bawaan)</option>
                                <option value="text-left">Rata Kiri</option>
                                <option value="text-center">Tengah</option>
                                <option value="text-right">Rata Kanan</option>
                                <option value="text-justify">Rata Kiri Kanan</option>
                            </select>
                        </div>

                        <!-- Tag (Heading) -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Jenis Heading (Tag)</label>
                            <select x-model="activeTextSettingsRef.tag" class="w-full text-sm rounded-lg border-slate-200">
                                <option value="">Default (Bawaan)</option>
                                <option value="h1">Heading 1 (Utama)</option>
                                <option value="h2">Heading 2</option>
                                <option value="h3">Heading 3</option>
                                <option value="h4">Heading 4</option>
                                <option value="p">Paragraph (Biasa)</option>
                            </select>
                        </div>

                        <!-- Warna -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Warna Teks (Color Picker)</label>
                            <div class="flex items-center gap-3">
                                <input type="color" x-model="activeTextSettingsRef.color" class="w-10 h-10 rounded cursor-pointer border-0 p-0">
                                <input type="text" x-model="activeTextSettingsRef.color" placeholder="#000000" class="flex-1 text-sm rounded-lg border-slate-200 font-mono">
                                <button type="button" @click="activeTextSettingsRef.color = ''" class="text-xs text-slate-500 hover:text-red-500 px-2 py-1 rounded bg-slate-100">Reset</button>
                            </div>
                        </div>

                        <!-- Line Height -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Tinggi Baris (Line Height)</label>
                            <select x-model="activeTextSettingsRef.line_height" class="w-full text-sm rounded-lg border-slate-200">
                                <option value="">Default (Bawaan)</option>
                                <option value="leading-none">None</option>
                                <option value="leading-tight">Tight</option>
                                <option value="leading-snug">Snug</option>
                                <option value="leading-normal">Normal</option>
                                <option value="leading-relaxed">Relaxed</option>
                                <option value="leading-loose">Loose</option>
                            </select>
                        </div>

                        <!-- Toggles: Italic & Underline -->
                        <div class="flex gap-4 items-end pb-1">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" x-model="activeTextSettingsRef.italic" class="rounded text-blue-600 focus:ring-blue-500">
                                <span class="text-sm font-bold text-slate-700">Miring (Italic)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" x-model="activeTextSettingsRef.underline" class="rounded text-blue-600 focus:ring-blue-500">
                                <span class="text-sm font-bold text-slate-700">Garis Bawah (Underline)</span>
                            </label>
                        </div>

                        <!-- Spacing Top & Bottom -->
                        <div class="flex gap-3">
                            <div class="flex-1">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Jarak Atas (Margin Top)</label>
                                <select x-model="activeTextSettingsRef.mt" class="w-full text-sm rounded-lg border-slate-200">
                                    <option value="">Bawaan</option>
                                    <option value="mt-0">mt-0</option>
                                    <option value="mt-2">mt-2</option>
                                    <option value="mt-4">mt-4</option>
                                    <option value="mt-6">mt-6</option>
                                    <option value="mt-8">mt-8</option>
                                    <option value="mt-12">mt-12</option>
                                </select>
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Jarak Bawah (Margin Bot)</label>
                                <select x-model="activeTextSettingsRef.mb" class="w-full text-sm rounded-lg border-slate-200">
                                    <option value="">Bawaan</option>
                                    <option value="mb-0">mb-0</option>
                                    <option value="mb-2">mb-2</option>
                                    <option value="mb-4">mb-4</option>
                                    <option value="mb-6">mb-6</option>
                                    <option value="mb-8">mb-8</option>
                                    <option value="mb-12">mb-12</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <div class="p-4 border-t border-slate-100 bg-slate-50 flex justify-end">
                <button type="button" @click="closeTextSettings()" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition-colors">Terapkan / Selesai</button>
            </div>
        </div>
    </div>

    <!-- AI Generator Assistant Modal -->
    <div x-show="showAiModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-md p-4 sm:p-6" @keydown.escape.window="if (!isGeneratingAi) showAiModal = false">
        <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden border border-slate-200/80 flex flex-col max-h-[90vh] animate-in fade-in zoom-in-95 duration-200" @click.away="if (!isGeneratingAi) showAiModal = false">
            
            <!-- Modal Header with gradient glow -->
            <div class="relative px-6 py-5 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white flex justify-between items-center border-b border-indigo-900/40">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-indigo-500 to-pink-500 flex items-center justify-center shadow-lg shadow-indigo-500/30 text-white shrink-0">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-extrabold text-base text-white">AI Page Generator Assistant</h3>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-indigo-500/30 border border-indigo-400/30 text-indigo-200">v2.0 Neural</span>
                        </div>
                        <p class="text-xs text-indigo-200/80 mt-0.5">Ketik prompt instruksi layout dan AI akan merancang struktur blok HTML siap pakai secara instan.</p>
                    </div>
                </div>
                <button type="button" @click="showAiModal = false" :disabled="isGeneratingAi" class="p-2 text-slate-400 hover:text-white hover:bg-white/10 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto space-y-5">
                <!-- Textarea Prompt -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 flex items-center justify-between">
                        <span>Instruksi Prompt Desain</span>
                        <span class="text-[11px] font-normal text-indigo-600">Mendukung perintah spesifik (misal: "3 kolom profil")</span>
                    </label>
                    <div class="relative">
                        <textarea x-model="aiPrompt" rows="4" :disabled="isGeneratingAi"
                            placeholder="Contoh: Buatkan struktur section profil baru dengan 3 kolom lengkap dengan ikon modern, badge tugas pokok, dan tombol aksi..."
                            class="w-full text-sm rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 p-4 transition-all shadow-inner text-slate-800 placeholder:text-slate-400 font-sans"></textarea>
                        
                        <button type="button" x-show="aiPrompt" @click="aiPrompt = ''" class="absolute top-3 right-3 text-slate-400 hover:text-slate-600 p-1" title="Bersihkan">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Quick Preset Chips -->
                <div>
                    <span class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Preset Prompt Siap Pakai:</span>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" @click="applyAiPreset('Buatkan struktur section profil baru dengan 3 kolom')" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-xl text-xs font-semibold border border-indigo-200/80 transition-all flex items-center gap-1.5 hover:scale-[1.02]">
                            <span>🏛️</span> Struktur Profil 3 Kolom
                        </button>
                        <button type="button" @click="applyAiPreset('Buatkan struktur section visi, misi, dan sasaran strategis lembaga')" class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-xl text-xs font-semibold border border-blue-200/80 transition-all flex items-center gap-1.5 hover:scale-[1.02]">
                            <span>🎯</span> Visi, Misi & Sasaran
                        </button>
                        <button type="button" @click="applyAiPreset('Buatkan section statistik 4 indikator kinerja utama dan capaian mutu')" class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-xl text-xs font-semibold border border-emerald-200/80 transition-all flex items-center gap-1.5 hover:scale-[1.02]">
                            <span>📊</span> Statistik 4 Indikator Kinerja
                        </button>
                        <button type="button" @click="applyAiPreset('Buatkan katalog 6 kartu layanan unggulan dan maklumat pelayanan')" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-xl text-xs font-semibold border border-amber-200/80 transition-all flex items-center gap-1.5 hover:scale-[1.02]">
                            <span>🌟</span> 6 Layanan Unggulan
                        </button>
                        <button type="button" @click="applyAiPreset('Buatkan struktur tim pimpinan dan dewan penjamin mutu')" class="px-3 py-1.5 bg-purple-50 hover:bg-purple-100 text-purple-700 rounded-xl text-xs font-semibold border border-purple-200/80 transition-all flex items-center gap-1.5 hover:scale-[1.02]">
                            <span>👥</span> Struktur Tim Pimpinan
                        </button>
                        <button type="button" @click="applyAiPreset('Buatkan kotak kontak terpadu, aduan masyarakat, dan lokasi kantor')" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-xl text-xs font-semibold border border-rose-200/80 transition-all flex items-center gap-1.5 hover:scale-[1.02]">
                            <span>📍</span> Kontak Terpadu & Aduan
                        </button>
                    </div>
                </div>

                <!-- Style & Positioning Options -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Gaya Desain Komponen</label>
                        <select x-model="aiStyle" class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white">
                            <option value="glassmorphism">Glassmorphism Modern (Backdrop Blur & Card)</option>
                            <option value="card">Card Elegan & Kontras (Solid Border & Shadow)</option>
                            <option value="minimalis">Minimalis Resmi (Standar Kemendikbudristek)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Penempatan di Halaman</label>
                        <select x-model="aiPosition" class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white">
                            <option value="bottom">Tambah di Paling Bawah (Akhir Halaman)</option>
                            <option value="top">Tambah di Paling Atas (Awal Halaman)</option>
                            <option value="replace" x-show="activeBlockIndex !== null">Gantikan Blok yang Sedang Dipilih</option>
                        </select>
                    </div>
                </div>

                <!-- Loading State -->
                <div x-show="isGeneratingAi" style="display: none;" class="p-4 bg-indigo-50/80 rounded-2xl border border-indigo-100 flex items-center gap-3">
                    <svg class="animate-spin w-5 h-5 text-indigo-600 shrink-0" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <div class="min-w-0">
                        <span class="text-xs font-bold text-indigo-900 block" x-text="aiProgressText">Merancang struktur komponen...</span>
                        <span class="text-[11px] text-indigo-600">Menyusun grid responsif Tailwind CSS dan atribut interaktif...</span>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
                <button type="button" @click="showAiModal = false" :disabled="isGeneratingAi" class="px-4 py-2 text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors">
                    Batal
                </button>
                <button type="button" @click="generateWithAi()" :disabled="!aiPrompt.trim() || isGeneratingAi" class="px-6 py-2.5 bg-gradient-to-r from-violet-600 via-indigo-600 to-blue-600 hover:from-violet-700 hover:to-indigo-700 disabled:opacity-50 text-white rounded-xl text-xs font-bold transition-all shadow-md shadow-indigo-600/25 flex items-center gap-2">
                    <span x-show="!isGeneratingAi" class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-300" fill="currentColor" viewBox="0 0 24 24"><path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                        <span>Generate Struktur HTML</span>
                    </span>
                    <span x-show="isGeneratingAi" class="flex items-center gap-2">
                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                        <span>Sedang Merancang...</span>
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- Template Manager Modal (Database-driven & Alpine.js) -->
    <div x-show="showTemplateModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 sm:p-6" @keydown.escape.window="showTemplateModal = false">
        <div class="bg-white w-full max-w-3xl rounded-3xl shadow-2xl overflow-hidden border border-slate-200 flex flex-col max-h-[90vh]" @click.away="showTemplateModal = false">
            
            <!-- TEMPLATE MANAGER MODAL (Alpine.js) -->
            <div x-data="TemplateManager()" x-init="fetchTemplates()" class="p-6 md:p-8 flex flex-col h-full overflow-hidden">
                
                <!-- Header Modal -->
                <div class="flex justify-between items-start mb-6 shrink-0">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 text-[10px] font-extrabold uppercase tracking-wider border border-blue-100">Database-driven</span>
                        </div>
                        <h3 class="text-xl md:text-2xl font-bold text-slate-800">Manajemen Template</h3>
                        <p class="text-xs sm:text-sm text-slate-500">Pilih, urutkan (drag &amp; drop), atau buat template baru.</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <!-- Tombol Tambah Template -->
                        <button type="button" x-show="!isEditing" @click="openForm()" class="px-4 py-2 bg-blue-600 text-white font-bold rounded-xl shadow-md hover:bg-blue-700 transition-all flex items-center gap-2 text-xs sm:text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>Tambah Template</span>
                        </button>

                        <!-- Tombol Tutup Modal -->
                        <button type="button" @click="showTemplateModal = false" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-colors" title="Tutup">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                <!-- DAFTAR TEMPLATE (DRAG & DROP LIST) -->
                <div x-show="!isEditing" class="flex-1 overflow-y-auto pr-1 space-y-3" id="template-list">
                    
                    <!-- Loading Indicator -->
                    <div x-show="isLoading" class="text-center py-12 text-slate-400 text-sm">
                        <svg class="w-7 h-7 animate-spin mx-auto mb-2 text-blue-600" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Memuat daftar template...
                    </div>

                    <template x-for="(tpl, index) in templates" :key="tpl.id">
                        <!-- Item Template -->
                        <div :data-id="tpl.id" class="group flex items-center justify-between p-4 bg-white border border-slate-200 rounded-2xl shadow-xs hover:shadow-md hover:border-blue-300 transition-all cursor-move">
                            
                            <!-- Kiri: Handle Drag & Info -->
                            <div class="flex items-center gap-3.5 min-w-0 flex-1 pr-3">
                                <div class="text-slate-300 group-hover:text-blue-500 cursor-grab shrink-0 p-1" title="Tahan dan geser untuk mengubah urutan">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-bold text-slate-800 text-sm md:text-base leading-snug truncate" x-text="tpl.name"></h4>
                                        <span class="text-[10px] text-slate-400 font-semibold uppercase px-1.5 py-0.5 bg-slate-100 rounded-md shrink-0" x-text="'#' + (index + 1)"></span>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-1 line-clamp-2" x-text="tpl.description || 'Tidak ada deskripsi.'"></p>
                                </div>
                            </div>

                            <!-- Kanan: Aksi -->
                            <div class="flex items-center gap-2 shrink-0">
                                <!-- Tombol Gunakan Template -->
                                <button type="button" @click="useTemplate(tpl.content)" class="px-3.5 py-1.5 text-xs font-bold bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white rounded-xl transition-all border border-emerald-200 shadow-xs flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span>Gunakan</span>
                                </button>
                                
                                <!-- Tombol Edit -->
                                <button type="button" @click="editTemplate(tpl)" class="p-2 text-blue-500 hover:bg-blue-50 rounded-xl transition-colors border border-transparent hover:border-blue-100" title="Edit Template">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </button>
                                
                                <!-- Tombol Hapus -->
                                <button type="button" @click="deleteTemplate(tpl.id)" class="p-2 text-rose-500 hover:bg-rose-50 rounded-xl transition-colors border border-transparent hover:border-rose-100" title="Hapus Template">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                    </template>
                    
                    <!-- State Kosong -->
                    <div x-show="!isLoading && templates.length === 0" class="text-center py-12 text-slate-500 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                        <svg class="w-8 h-8 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                        <p class="font-bold text-slate-700 text-sm">Belum ada template. Silakan buat baru.</p>
                        <p class="text-xs text-slate-400 mt-1">Klik tombol "Tambah Template" untuk membuat template pertama Anda.</p>
                    </div>
                </div>

                <!-- FORM TAMBAH / EDIT TEMPLATE -->
                <div x-show="isEditing" style="display: none;" class="flex-1 overflow-y-auto pr-1 bg-slate-50/80 p-6 rounded-2xl border border-slate-200">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-200">
                        <h4 class="font-bold text-slate-800 text-base" x-text="form.id ? 'Edit Template' : 'Buat Template Baru'"></h4>
                        <span class="text-xs text-slate-400" x-text="form.id ? 'ID: #' + form.id : 'Template Baru'"></span>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-bold text-slate-600 block mb-1">Nama Template <span class="text-red-500">*</span></label>
                            <input type="text" x-model="form.name" placeholder="Misal: Halaman Pengumuman Resmi" class="w-full px-4 py-2 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-600 block mb-1">Deskripsi Singkat</label>
                            <input type="text" x-model="form.description" placeholder="Penjelasan singkat fungsi template..." class="w-full px-4 py-2 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white">
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="text-xs font-bold text-slate-600">Kode HTML / Struktur Builder <span class="text-red-500">*</span></label>
                                <span class="text-[10px] text-slate-400">Mendukung blok HTML custom &amp; Alpine.js</span>
                            </div>
                            <textarea x-model="form.content" rows="8" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 font-mono text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white placeholder-slate-400" placeholder="Paste kode HTML atau JSON block di sini..."></textarea>
                        </div>
                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="isEditing = false" class="px-4 py-2 font-bold text-xs text-slate-600 hover:bg-slate-200 rounded-xl transition-colors">Batal</button>
                            <button type="button" @click="saveTemplate()" class="px-5 py-2 bg-blue-600 text-white font-bold text-xs rounded-xl shadow-md hover:bg-blue-700 transition-colors flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>Simpan Template</span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Initial State Data (Safe JSON Escaping with JSON_HEX_TAG) -->
    <script id="builder-initial-data" type="application/json">
        {!! json_encode(json_decode($page->builder_data ?? '[]', true) ?: [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) !!}
    </script>

    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('TemplateManager', () => ({
            templates: [],
            isLoading: false,
            isEditing: false,
            form: { id: null, name: '', description: '', content: '' },
            sortableInstance: null,

            async fetchTemplates() {
                try {
                    this.isLoading = true;
                    const response = await fetch('/admin/api/templates', {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if (!response.ok) throw new Error('Gagal mengambil daftar template.');
                    this.templates = await response.json();
                    
                    this.$nextTick(() => {
                        this.initSortable();
                    });
                } catch (err) {
                    console.error('Fetch templates error:', err);
                } finally {
                    this.isLoading = false;
                }
            },

            initSortable() {
                let el = document.getElementById('template-list');
                if (!el || typeof Sortable === 'undefined') return;
                if (this.sortableInstance) {
                    this.sortableInstance.destroy();
                }
                this.sortableInstance = Sortable.create(el, {
                    animation: 150,
                    handle: '.cursor-grab',
                    ghostClass: 'sortable-ghost',
                    onEnd: (evt) => {
                        this.reorderTemplates();
                    }
                });
            },

            openForm() {
                this.form = { id: null, name: '', description: '', content: '' };
                this.isEditing = true;
            },

            editTemplate(tpl) {
                this.form = { 
                    id: tpl.id, 
                    name: tpl.name || '', 
                    description: tpl.description || '', 
                    content: tpl.content || '' 
                };
                this.isEditing = true;
            },

            async saveTemplate() {
                if (!this.form.name.trim()) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Nama template wajib diisi!',
                        customClass: {
                            popup: 'bg-white/95 backdrop-blur-xl border border-slate-200 shadow-2xl rounded-3xl',
                            confirmButton: 'bg-blue-600 font-bold rounded-xl shadow-md'
                        }
                    });
                    return;
                }
                if (!this.form.content.trim()) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Kode HTML / Konten template wajib diisi!',
                        customClass: {
                            popup: 'bg-white/95 backdrop-blur-xl border border-slate-200 shadow-2xl rounded-3xl',
                            confirmButton: 'bg-blue-600 font-bold rounded-xl shadow-md'
                        }
                    });
                    return;
                }

                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const isUpdate = Boolean(this.form.id);
                const url = isUpdate ? `/admin/api/templates/${this.form.id}` : '/admin/api/templates';
                const method = isUpdate ? 'PUT' : 'POST';

                try {
                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            name: this.form.name,
                            description: this.form.description,
                            content: this.form.content
                        })
                    });

                    const data = await response.json();
                    if (!response.ok) {
                        throw new Error(data.message || 'Gagal menyimpan template.');
                    }

                    this.isEditing = false;
                    await this.fetchTemplates();

                    // Ganti alert() dengan Toast Glassmorphism
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Template berhasil disimpan!',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        customClass: {
                            popup: 'bg-white/90 backdrop-blur-md border border-slate-100 shadow-xl rounded-2xl'
                        }
                    });
                } catch (err) {
                    console.error('Save template error:', err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan',
                        text: err.message || 'Terjadi kesalahan sistem.',
                        customClass: {
                            popup: 'bg-white/95 backdrop-blur-xl border border-slate-200 shadow-2xl rounded-3xl',
                            confirmButton: 'bg-red-600 font-bold rounded-xl shadow-md'
                        }
                    });
                }
            },

            async deleteTemplate(id) {
                // Ganti confirm() dengan Modal Glassmorphism
                const result = await Swal.fire({
                    title: 'Hapus Template?',
                    text: "Tindakan ini tidak dapat dibatalkan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'bg-white/95 backdrop-blur-xl border border-slate-200 shadow-2xl rounded-3xl',
                        title: 'text-slate-800 font-bold',
                        htmlContainer: 'text-slate-500',
                        confirmButton: 'font-bold rounded-xl shadow-md',
                        cancelButton: 'font-bold rounded-xl'
                    }
                });

                if (result.isConfirmed) {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    try {
                        const response = await fetch(`/admin/api/templates/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        const data = await response.json();
                        if (!response.ok) {
                            throw new Error(data.message || 'Gagal menghapus template.');
                        }

                        await this.fetchTemplates();

                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: 'Template berhasil dihapus dari sistem.',
                            customClass: {
                                popup: 'bg-white/95 backdrop-blur-xl border border-slate-200 shadow-2xl rounded-3xl',
                                confirmButton: 'bg-blue-600 font-bold rounded-xl shadow-md'
                            }
                        });
                    } catch (err) {
                        console.error('Delete template error:', err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Menghapus',
                            text: err.message || 'Gagal menghapus template.',
                            customClass: {
                                popup: 'bg-white/95 backdrop-blur-xl border border-slate-200 shadow-2xl rounded-3xl',
                                confirmButton: 'bg-red-600 font-bold rounded-xl shadow-md'
                            }
                        });
                    }
                }
            },

            async reorderTemplates() {
                const orderedIds = Array.from(document.querySelectorAll('#template-list > div[data-id]'))
                                        .map(el => Number(el.getAttribute('data-id')))
                                        .filter(id => !isNaN(id) && id > 0);
                
                if (orderedIds.length === 0) return;

                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                try {
                    const response = await fetch('/admin/api/templates/reorder', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ ids: orderedIds })
                    });

                    if (!response.ok) {
                        const data = await response.json();
                        throw new Error(data.message || 'Gagal memperbarui urutan.');
                    }
                } catch (err) {
                    console.error('Reorder error:', err);
                }
            },

            useTemplate(content) {
                if (!content) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Template Kosong',
                        text: 'Template ini tidak memiliki konten!',
                        customClass: {
                            popup: 'bg-white/95 backdrop-blur-xl border border-slate-200 shadow-2xl rounded-3xl',
                            confirmButton: 'bg-blue-600 font-bold rounded-xl shadow-md'
                        }
                    });
                    return;
                }

                try {
                    let parsed = null;
                    if (typeof content === 'string') {
                        let trimmed = content.trim();
                        if (trimmed.startsWith('[') || trimmed.startsWith('{')) {
                            try {
                                parsed = JSON.parse(trimmed);
                            } catch(e) {
                                parsed = null;
                            }
                        }
                    }

                    let newBlocks = [];
                    if (Array.isArray(parsed) && parsed.length > 0) {
                        newBlocks = parsed;
                    } else if (parsed && typeof parsed === 'object' && parsed.type) {
                        newBlocks = [parsed];
                    } else {
                        newBlocks = [
                            {
                                id: Date.now() + 1,
                                type: 'html_custom',
                                settings: { bg: 'transparent', padding: 'none', align: '', wrapper_class: '' },
                                content: {
                                    html: content
                                }
                            }
                        ];
                    }

                    if (window.pageBuilderApp) {
                        window.pageBuilderApp.blocks = newBlocks;
                        window.pageBuilderApp.activeBlockIndex = 0;
                        if (typeof window.pageBuilderApp.updatePreview === 'function') {
                            window.pageBuilderApp.updatePreview(true);
                        }
                        if (typeof window.pageBuilderApp.syncState === 'function') {
                            window.pageBuilderApp.syncState();
                        }
                        window.pageBuilderApp.showTemplateModal = false;
                    }

                    // Ganti alert() dengan Toast Glassmorphism
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Template berhasil diaplikasikan ke editor!',
                        showConfirmButton: false,
                        timer: 3000,
                        customClass: {
                            popup: 'bg-white/90 backdrop-blur-md border border-emerald-100 shadow-xl rounded-2xl text-emerald-800'
                        }
                    });
                } catch (err) {
                    console.error('Apply template error:', err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menerapkan',
                        text: err.message || 'Gagal menerapkan template ke editor.',
                        customClass: {
                            popup: 'bg-white/95 backdrop-blur-xl border border-slate-200 shadow-2xl rounded-3xl',
                            confirmButton: 'bg-red-600 font-bold rounded-xl shadow-md'
                        }
                    });
                }
            }
        }));

        Alpine.data('pageBuilder', () => ({
            blocks: JSON.parse(document.getElementById('builder-initial-data')?.textContent || '[]'),
            activeBlockIndex: null,
            showTemplateModal: false,
            isSaving: false,
            showToast: false,
            isInlineEditing: false,
            _sortableInstance: null,
            savedRange: null,
            currentFontSize: 16,
            activeTextColor: '#1e293b',
            activeHiliteColor: '#fef08a',
            contextMenuBlockIndex: null,

            // Quick Canvas Action State
            canvasTargetBlockIndex: null,

            // AI Assistant State
            showAiModal: false,
            aiPrompt: '',
            aiStyle: 'glassmorphism',
            aiPosition: 'bottom',
            isGeneratingAi: false,
            aiProgressText: 'Merancang struktur komponen...',

            // Text Settings state
            isTextSettingsOpen: false,
            textSettingsTitle: 'Pengaturan Teks',
            activeTextSettingsRef: null,

            init() {
                window.pageBuilderApp = this;
                if (Array.isArray(this.blocks)) {
                    this.blocks.forEach(block => {
                        if (block.type === 'text' || block.type === 'html' || block.type === 'html_custom') {
                            if (typeof block.content === 'string') {
                                block.content = block.content.replace(/\\r\\n|\\r|\\n/g, ' ');
                            } else if (block.content && typeof block.content === 'object' && block.content.html) {
                                block.content.html = block.content.html.replace(/\\r\\n|\\r|\\n/g, ' ');
                            }
                        }
                    });
                }
                this.$nextTick(() => {
                    this.initSortable();
                    this.initInlineEditing();
                    this.initMutationObserver();
                    this.syncState();
                    this.updatePreview(true);
                });

                this.$watch('blocks', () => {
                    this.syncState();
                    if (!this.isInlineEditing) {
                        this.updatePreview();
                    }
                });
            },

            syncState() {
                const input = document.getElementById('builder_data_input');
                if (input) {
                    input.value = JSON.stringify(this.blocks);
                }
            },

            initMutationObserver() {
                const preview = document.getElementById('preview-container');
                if (!preview || !window.MutationObserver) return;

                const observer = new MutationObserver((mutations) => {
                    let shouldSync = false;
                    for (const mutation of mutations) {
                        if (mutation.type === 'characterData' || mutation.type === 'childList') {
                            const targetNode = mutation.target.nodeType === 1 ? mutation.target : mutation.target.parentElement;
                            const editable = targetNode?.closest('.builder-editable');
                            if (editable) {
                                const blockId = Number(editable.dataset.blockId);
                                const field = editable.dataset.field;
                                const itemIdx = editable.dataset.itemIdx !== undefined ? Number(editable.dataset.itemIdx) : null;
                                const block = this.blocks.find(b => b.id === blockId);
                                if (block && field) {
                                    const val = editable.innerHTML;
                                    if (itemIdx !== null) {
                                        if (block.content.items && block.content.items[itemIdx]) {
                                            block.content.items[itemIdx][field] = val;
                                        } else if (block.content.details && block.content.details[itemIdx]) {
                                            block.content.details[itemIdx][field] = val;
                                        }
                                    } else {
                                        if (typeof block.content === 'string' || field === 'content') {
                                            block.content = val;
                                        } else if (block.content && typeof block.content === 'object') {
                                            block.content[field] = val;
                                        } else {
                                            block.content = val;
                                        }
                                    }
                                    shouldSync = true;
                                }
                            }
                        }
                    }
                    if (shouldSync) {
                        this.syncState();
                    }
                });

                observer.observe(preview, {
                    characterData: true,
                    childList: true,
                    subtree: true
                });
            },

            initSortable() {
                this.$nextTick(() => {
                    const el = document.getElementById('blocks-container');
                    if (!el || !window.Sortable) return;

                    if (this._sortableInstance) {
                        this._sortableInstance.destroy();
                    }

                    this._sortableInstance = new Sortable(el, {
                        animation: 200,
                        handle: '.drag-handle',
                        draggable: '.block-item',
                        ghostClass: 'sortable-ghost',
                        chosenClass: 'sortable-chosen',
                        dragClass: 'sortable-drag',
                        onEnd: (evt) => {
                            const oldIndex = evt.oldIndex;
                            const newIndex = evt.newIndex;
                            if (oldIndex === undefined || newIndex === undefined || oldIndex === newIndex) return;

                            // Revert Sortable DOM mutation so Alpine reconciles x-for without conflict
                            const item = evt.item;
                            const parent = item.parentNode;
                            const sibling = parent.children[oldIndex > newIndex ? oldIndex + 1 : oldIndex];
                            parent.removeChild(item);
                            if (sibling) {
                                parent.insertBefore(item, sibling);
                            } else {
                                parent.appendChild(item);
                            }

                            // Move in blocks array
                            const moved = this.blocks.splice(oldIndex, 1)[0];
                            this.blocks.splice(newIndex, 0, moved);

                            if (this.activeBlockIndex === oldIndex) {
                                this.activeBlockIndex = newIndex;
                            } else if (this.activeBlockIndex > oldIndex && this.activeBlockIndex <= newIndex) {
                                this.activeBlockIndex--;
                            } else if (this.activeBlockIndex < oldIndex && this.activeBlockIndex >= newIndex) {
                                this.activeBlockIndex++;
                            }

                            this.syncState();
                            this.updatePreview(true);
                        }
                    });
                });
            },

            initInlineEditing() {
                const preview = document.getElementById('preview-container');
                if (!preview) return;

                // Sync on input
                preview.addEventListener('input', (e) => {
                    const el = e.target.closest('.builder-editable');
                    if (!el) return;

                    this.isInlineEditing = true;
                    const blockId = Number(el.dataset.blockId);
                    const field = el.dataset.field;
                    const itemIdx = el.dataset.itemIdx !== undefined ? Number(el.dataset.itemIdx) : null;

                    const block = this.blocks.find(b => b.id === blockId);
                    if (!block || !field) return;

                    const val = el.innerHTML;

                    if (itemIdx !== null) {
                        if (block.content.items && block.content.items[itemIdx]) {
                            block.content.items[itemIdx][field] = val;
                        } else if (block.content.details && block.content.details[itemIdx]) {
                            block.content.details[itemIdx][field] = val;
                        }
                    } else {
                        if (typeof block.content === 'string' || field === 'content') {
                            block.content = val;
                        } else if (block.content && typeof block.content === 'object') {
                            block.content[field] = val;
                        } else {
                            block.content = val;
                        }
                    }

                    this.syncState();
                });

                // Reset flag on blur
                preview.addEventListener('blur', (e) => {
                    const el = e.target.closest('.builder-editable');
                    if (!el) return;
                    this.isInlineEditing = false;
                    this.syncState();
                }, true);

                // Floating Toolbar on selection
                const checkSelection = () => {
                    const toolbar = document.getElementById('inline-floating-toolbar');
                    if (!toolbar) return;

                    const sel = window.getSelection();
                    if (!sel || sel.isCollapsed || !sel.rangeCount) {
                        if (toolbar.contains(document.activeElement)) {
                            return;
                        }
                        toolbar.style.display = 'none';
                        return;
                    }

                    const range = sel.getRangeAt(0);
                    const container = range.commonAncestorContainer;
                    const compEl = (container.nodeType === 1 ? container : container.parentElement);
                    const editableEl = compEl?.closest('.builder-editable');
                    if (!editableEl) {
                        toolbar.style.display = 'none';
                        return;
                    }

                    const rect = range.getBoundingClientRect();
                    if (rect.width === 0 && rect.height === 0) {
                        toolbar.style.display = 'none';
                        return;
                    }

                    this.savedRange = range.cloneRange();
                    if (compEl) {
                        const computedSize = parseInt(window.getComputedStyle(compEl).fontSize);
                        if (computedSize) {
                            this.currentFontSize = computedSize;
                        }
                    }

                    toolbar.style.display = 'flex';
                    const top = Math.max(12, rect.top - 14);
                    const left = Math.min(Math.max(280, rect.left + (rect.width / 2)), window.innerWidth - 280);
                    toolbar.style.top = `${top}px`;
                    toolbar.style.left = `${left}px`;
                };

                document.addEventListener('selectionchange', checkSelection);
                document.addEventListener('mouseup', checkSelection);

                // Close context menu on outside click
                document.addEventListener('click', (e) => {
                    const menu = document.getElementById('block-context-menu');
                    if (menu && menu.style.display === 'block' && !menu.contains(e.target)) {
                        menu.style.display = 'none';
                        this.contextMenuBlockIndex = null;
                    }
                });

                const workspace = document.getElementById('preview-workspace');
                if (workspace) {
                    workspace.addEventListener('scroll', () => {
                        const menu = document.getElementById('block-context-menu');
                        if (menu && menu.style.display === 'block') {
                            menu.style.display = 'none';
                            this.contextMenuBlockIndex = null;
                        }
                        const toolbar = document.getElementById('inline-floating-toolbar');
                        if (toolbar && toolbar.style.display === 'flex') {
                            checkSelection();
                        }
                    });
                }
            },

            restoreSelection() {
                if (this.savedRange) {
                    const sel = window.getSelection();
                    sel.removeAllRanges();
                    sel.addRange(this.savedRange);
                }
            },

            triggerSelectionInput() {
                const sel = window.getSelection();
                if (sel && sel.anchorNode) {
                    const el = (sel.anchorNode.nodeType === 1 ? sel.anchorNode : sel.anchorNode.parentElement)?.closest('.builder-editable');
                    if (el) {
                        el.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                }
                this.syncState();
            },

            formatInline(cmd) {
                this.restoreSelection();
                if (cmd === 'createLink') {
                    const url = prompt('Masukkan URL tautan:', 'https://');
                    if (url) {
                        document.execCommand('createLink', false, url);
                    }
                } else {
                    document.execCommand(cmd, false, null);
                }
                this.triggerSelectionInput();
            },

            formatFontFamily(font) {
                this.restoreSelection();
                document.execCommand('styleWithCSS', false, true);
                document.execCommand('fontName', false, font);
                this.triggerSelectionInput();
            },

            formatTextColor(color) {
                this.activeTextColor = color;
                this.restoreSelection();
                document.execCommand('styleWithCSS', false, true);
                document.execCommand('foreColor', false, color);
                this.triggerSelectionInput();
            },

            formatHiliteColor(color) {
                this.activeHiliteColor = color;
                this.restoreSelection();
                document.execCommand('styleWithCSS', false, true);
                if (!document.execCommand('hiliteColor', false, color)) {
                    document.execCommand('backColor', false, color);
                }
                this.triggerSelectionInput();
            },

            changeFontSize(delta) {
                this.restoreSelection();
                const sel = window.getSelection();
                if (!sel || !sel.rangeCount || sel.isCollapsed) return;
                const range = sel.getRangeAt(0);

                const container = range.commonAncestorContainer;
                const el = (container.nodeType === 1 ? container : container.parentElement);
                let size = 16;
                if (el) {
                    size = parseInt(window.getComputedStyle(el).fontSize) || 16;
                }
                const newSize = Math.max(10, Math.min(80, size + delta));
                this.currentFontSize = newSize;

                document.execCommand('styleWithCSS', false, true);
                const span = document.createElement('span');
                span.style.fontSize = `${newSize}px`;
                span.appendChild(range.extractContents());
                range.insertNode(span);

                sel.removeAllRanges();
                const newRange = document.createRange();
                newRange.selectNodeContents(span);
                sel.addRange(newRange);
                this.savedRange = newRange.cloneRange();

                this.triggerSelectionInput();
            },

            toggleContextMenu(event, blockIndex) {
                event.stopPropagation();
                event.preventDefault();
                const menu = document.getElementById('block-context-menu');
                if (!menu) return;

                if (this.contextMenuBlockIndex === blockIndex && menu.style.display === 'block') {
                    menu.style.display = 'none';
                    this.contextMenuBlockIndex = null;
                    return;
                }

                this.contextMenuBlockIndex = blockIndex;
                const block = this.blocks[blockIndex];
                const labelEl = document.getElementById('context-menu-block-label');
                if (labelEl && block) {
                    labelEl.textContent = this.getBlockLabel(block.type);
                }

                const btn = event.currentTarget;
                const rect = btn.getBoundingClientRect();
                menu.style.display = 'block';

                const menuWidth = 224;
                let top = rect.bottom + 6;
                let left = rect.right - menuWidth;
                if (left < 16) left = 16;
                if (top + 230 > window.innerHeight) {
                    top = Math.max(12, rect.top - 230);
                }

                menu.style.top = `${top}px`;
                menu.style.left = `${left}px`;
            },

            closeContextMenu() {
                const menu = document.getElementById('block-context-menu');
                if (menu) menu.style.display = 'none';
                this.contextMenuBlockIndex = null;
            },

            duplicateFromContext() {
                if (this.contextMenuBlockIndex !== null) {
                    const idx = this.contextMenuBlockIndex;
                    this.closeContextMenu();
                    this.duplicateBlock(idx);
                }
            },

            moveUpFromContext() {
                if (this.contextMenuBlockIndex !== null) {
                    const idx = this.contextMenuBlockIndex;
                    this.closeContextMenu();
                    this.moveUp(idx);
                }
            },

            moveDownFromContext() {
                if (this.contextMenuBlockIndex !== null) {
                    const idx = this.contextMenuBlockIndex;
                    this.closeContextMenu();
                    this.moveDown(idx);
                }
            },

            removeFromContext() {
                if (this.contextMenuBlockIndex !== null) {
                    const idx = this.contextMenuBlockIndex;
                    this.closeContextMenu();
                    this.removeBlock(idx);
                }
            },

            editInSidebarFromContext() {
                if (this.contextMenuBlockIndex !== null) {
                    this.activeBlockIndex = this.contextMenuBlockIndex;
                    this.closeContextMenu();
                }
            },

            openTextSettings(contentObject, settingsKey, title) {
                if (!contentObject[settingsKey]) {
                    contentObject[settingsKey] = {
                        size: '', weight: '', align: '', tag: '', color: '',
                        line_height: '', letter_spacing: '', italic: false, underline: false, mt: '', mb: ''
                    };
                }
                this.activeTextSettingsRef = contentObject[settingsKey];
                this.textSettingsTitle = title;
                this.isTextSettingsOpen = true;
            },

            closeTextSettings() {
                this.isTextSettingsOpen = false;
                this.activeTextSettingsRef = null;
                this.updatePreview(true);
            },

            getBlockLabel(type) {
                const labels = {
                    'hero': 'Hero Banner',
                    'image_text': 'Img & Teks',
                    'cards': 'Cards (Grid Layanan)',
                    'list': 'Daftar List',
                    'lists': 'Daftar List',
                    'gallery_slider': 'Galeri Slider',
                    'slider': 'Galeri Slider',
                    'profile_table': 'Tabel Profil',
                    'table_profile': 'Tabel Profil',
                    'image': 'Gambar Saja',
                    'html': 'HTML Custom',
                    'text': 'HTML Custom',
                    'html_custom': 'HTML Custom',
                    'glass_split': 'Split Glass',
                    'glass_cards': 'Glass Cards'
                };
                return labels[type] || 'Section';
            },

            addBlock(type) {
                const newBlock = {
                    id: Date.now(),
                    type: type,
                    settings: { bg: 'transparent', padding: 'medium', align: 'left', wrapper_class: '' },
                    content: {}
                };

                if (type === 'hero') {
                    newBlock.settings.bg = 'white';
                    newBlock.content = {
                        title: 'Judul Hero Banner',
                        description: 'Deskripsi lengkap banner disajikan secara profesional dan menarik.',
                        button_text: 'Jelajahi Sekarang',
                        button_url: '#',
                        bg_image: ''
                    };
                } else if (type === 'text' || type === 'html' || type === 'html_custom') {
                    newBlock.type = type;
                    newBlock.settings.padding = 'none';
                    newBlock.content = { html: '<div class="w-full max-w-5xl mx-auto my-8 prose prose-blue prose-lg">\n    <p>Tuliskan teks paragraf atau kode HTML kustom di sini...</p>\n</div>' };
                } else if (type === 'image') {
                    newBlock.settings.align = 'center';
                    newBlock.content = {
                        image: '',
                        caption: '',
                        alt: '',
                        width: 'max-w-5xl',
                        rounded: 'rounded-3xl',
                        shadow: 'shadow-xl',
                        link: ''
                    };
                } else if (type === 'image_text') {
                    newBlock.settings.padding = 'none';
                    newBlock.settings.image_position = 'left';
                    newBlock.content = {
                        image: 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&fit=crop',
                        title: 'Judul Informasi &amp; Layanan',
                        description: '<p class="text-slate-600 leading-relaxed">Deskripsi lengkap mengenai topik ini disajikan secara komprehensif, ringkas, dan jelas bagi para pembaca.</p>',
                        button_text: 'Pelajari Selengkapnya',
                        button_url: '#'
                    };
                } else if (type === 'cards') {
                    newBlock.settings.padding = 'none';
                    newBlock.content = {
                        heading: 'Daftar Layanan &amp; Program Unggulan',
                        columns: 3,
                        items: [
                            {title: 'Penjaminan Mutu PAUD', description: 'Pendampingan dan advokasi satuan pendidikan usia dini.', image: 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=400&h=300&fit=crop', button_text: 'Lihat Detail', button_url: '#'},
                            {title: 'Pendidikan Dasar & Menengah', description: 'Fasilitasi kurikulum merdeka dan asesmen nasional.', image: 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=400&h=300&fit=crop', button_text: 'Lihat Detail', button_url: '#'},
                            {title: 'Tata Kelola & Kemitraan', description: 'Kolaborasi strategis dengan pemerintah daerah se-Sultra.', image: 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=400&h=300&fit=crop', button_text: 'Lihat Detail', button_url: '#'}
                        ]
                    };
                } else if (type === 'list' || type === 'lists') {
                    newBlock.type = 'list';
                    newBlock.content = {
                        heading: 'Poin Persyaratan &amp; Prosedur',
                        description: 'Berikut adalah poin-poin penting panduan layanan informasi.',
                        style: 'check',
                        columns: 1,
                        items: [
                            { title: 'Persyaratan administratif lengkap dan terverifikasi', description: 'Pastikan seluruh berkas telah memenuhi standar ketentuan resmi.', link: '' },
                            { title: 'Mengikuti alur konsultasi dan verifikasi dokumen', description: 'Proses verifikasi dilakukan maksimal dalam waktu 1x24 jam kerja.', link: '' },
                            { title: 'Penerbitan rekomendasi dan tindak lanjut penjaminan mutu', description: 'Hasil layanan dapat dipantau secara langsung melalui portal digital.', link: '' }
                        ]
                    };
                } else if (type === 'gallery_slider') {
                    newBlock.settings.padding = 'small';
                    newBlock.content = {
                        heading: 'Galeri Foto &amp; Direktori Pegawai',
                        subheading: 'Pegawai Balai Penjaminan Mutu Pendidikan Provinsi Sulawesi Tenggara',
                        items: [
                            { name: 'Dr. Ahmad, M.Pd.', role: 'Kepala BPMP', image: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=300&h=300&fit=crop' },
                            { name: 'La Ode Rudi, S.Pd.', role: 'Kasubbag Umum', image: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=300&fit=crop' },
                            { name: 'Siti Aminah, M.Si.', role: 'Widyaprada Madya', image: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=300&h=300&fit=crop' },
                            { name: 'Bambang Irawan, S.Kom.', role: 'Pranata Komputer', image: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&h=300&fit=crop' }
                        ]
                    };
                } else if (type === 'profile_table') {
                    newBlock.settings.padding = 'none';
                    newBlock.content = {
                        name: 'Dr. Pejabat Utama, M.Pd.',
                        role: 'Kepala Balai Penjaminan Mutu Pendidikan Sultra',
                        image: 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=600&h=500&fit=crop',
                        bio: 'Memimpin pelaksanaan penjaminan mutu pendidikan anak usia dini, dasar, menengah, dan masyarakat di Provinsi Sulawesi Tenggara.',
                        details: [
                            { label: 'NIP', value: '19750101 200003 1 001' },
                            { label: 'Pangkat / Gol', value: 'Pembina Utama Muda (IV/c)' },
                            { label: 'Jabatan Terakhir', value: 'Kepala Balai' },
                            { label: 'Unit Kerja', value: 'BPMP Provinsi Sulawesi Tenggara' },
                            { label: 'Pendidikan', value: 'S3 Manajemen Pendidikan' }
                        ],
                        button_text: 'Unduh Biodata Lengkap',
                        button_url: '#'
                    };
                } else if (type === 'glass_split') {
                    newBlock.settings.padding = 'none';
                    newBlock.content = {
                        tagline: 'KATA SAMBUTAN',
                        title: 'Peningkatan Mutu Pendidikan Sulawesi Tenggara',
                        description: '<p class="text-slate-600 leading-relaxed">Komitmen kami dalam mengawal penjaminan mutu dan peningkatan standar pendidikan di seluruh penjuru Sulawesi Tenggara secara berkelanjutan.</p>',
                        image_url: 'https://images.unsplash.com/photo-1577495508048-b635879837f1?w=800&fit=crop',
                        image_position: 'left',
                        button_text: 'BACA SEKARANG',
                        button_link: '#'
                    };
                } else if (type === 'glass_cards') {
                    newBlock.settings.padding = 'none';
                    newBlock.content = {
                        section_title: 'Profil Mutu per Daerah',
                        section_subtitle: 'Pilih Kabupaten/Kota untuk melihat laporan dan capaian mutu pendidikan.',
                        cards: [
                            { title: 'Kota Kendari', subtitle: 'Laporan Daerah • 1.8 MB', link: '#', image: '', icon: 'pdf' },
                            { title: 'Kota Baubau', subtitle: 'Laporan Daerah • 1.9 MB', link: '#', image: '', icon: 'pdf' },
                            { title: 'Kab. Konawe', subtitle: 'Laporan Daerah • 2.1 MB', link: '#', image: '', icon: 'pdf' },
                            { title: 'Kab. Kolaka', subtitle: 'Laporan Daerah • 1.7 MB', link: '#', image: '', icon: 'pdf' }
                        ]
                    };
                }

                this.blocks.push(newBlock);
                this.activeBlockIndex = this.blocks.length - 1;
                this.updatePreview(true);
                this.initSortable();
            },

            async uploadImage(event, targetBlockOrItem, fieldName = 'image') {
                const file = event.target.files[0];
                if (!file) return;

                const formData = new FormData();
                formData.append('image', file);

                const labelEl = event.target.closest('label');
                const textSpan = labelEl ? labelEl.querySelector('span.upload-label') : null;
                const prevText = textSpan ? textSpan.textContent : 'Upload';
                if (textSpan) textSpan.textContent = '...';

                try {
                    const response = await fetch('{{ route('admin.pages.builder.upload_image') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: formData
                    });

                    const data = await response.json();
                    if (response.ok && data.url) {
                        if (targetBlockOrItem.content) {
                            targetBlockOrItem.content[fieldName] = data.url;
                        } else {
                            targetBlockOrItem[fieldName] = data.url;
                        }
                        this.updatePreview(true);
                    } else {
                        alert(data.message || 'Gagal mengunggah gambar.');
                    }
                } catch (err) {
                    alert('Terjadi kesalahan saat mengunggah gambar.');
                } finally {
                    if (textSpan) textSpan.textContent = prevText;
                    event.target.value = '';
                }
            },

            removeBlock(index) {
                if (confirm('Hapus section ini?')) {
                    this.blocks.splice(index, 1);
                    if (this.activeBlockIndex === index) {
                        this.activeBlockIndex = null;
                    } else if (this.activeBlockIndex > index) {
                        this.activeBlockIndex--;
                    }
                    this.syncState();
                    this.updatePreview(true);
                    this.initSortable();
                }
            },

            duplicateBlock(index) {
                const copy = JSON.parse(JSON.stringify(this.blocks[index]));
                copy.id = Date.now();
                this.blocks.splice(index + 1, 0, copy);
                this.syncState();
                this.updatePreview(true);
                this.initSortable();
            },

            moveUp(index) {
                if (index > 0) {
                    const temp = this.blocks[index];
                    this.blocks[index] = this.blocks[index - 1];
                    this.blocks[index - 1] = temp;
                    if (this.activeBlockIndex === index) this.activeBlockIndex = index - 1;
                    else if (this.activeBlockIndex === index - 1) this.activeBlockIndex = index;
                    this.syncState();
                    this.updatePreview(true);
                    this.initSortable();
                }
            },

            moveDown(index) {
                if (index < this.blocks.length - 1) {
                    const temp = this.blocks[index];
                    this.blocks[index] = this.blocks[index + 1];
                    this.blocks[index + 1] = temp;
                    if (this.activeBlockIndex === index) this.activeBlockIndex = index + 1;
                    else if (this.activeBlockIndex === index + 1) this.activeBlockIndex = index;
                    this.syncState();
                    this.updatePreview(true);
                    this.initSortable();
                }
            },

            selectBlockFromCanvas(bIdx, event) {
                if (event) {
                    if (event.target.tagName === 'A') {
                        event.preventDefault();
                    }
                }
                if (this.activeBlockIndex === bIdx) return;
                this.activeBlockIndex = bIdx;
                this.updatePreview(true);

                this.$nextTick(() => {
                    const sidebarItems = document.querySelectorAll('#blocks-container .block-item');
                    if (sidebarItems[bIdx]) {
                        sidebarItems[bIdx].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }
                });
            },

            canvasActionEditText(bIdx, event) {
                if (event) event.stopPropagation();
                this.activeBlockIndex = bIdx;

                const section = document.querySelector(`[data-block-index="${bIdx}"]`);
                if (section) {
                    const editable = section.querySelector('.builder-editable') || section.querySelector('h1, h2, h3, h4, p, span');
                    if (editable) {
                        editable.setAttribute('contenteditable', 'true');
                        editable.focus();

                        try {
                            const range = document.createRange();
                            range.selectNodeContents(editable);
                            const sel = window.getSelection();
                            sel.removeAllRanges();
                            sel.addRange(range);
                        } catch (e) {}

                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'info',
                            title: 'Mode edit teks aktif! Anda dapat langsung mengetik di teks.',
                            showConfirmButton: false,
                            timer: 2500,
                            customClass: {
                                popup: 'bg-slate-900/90 text-white rounded-2xl shadow-xl border border-slate-700'
                            }
                        });
                        return;
                    }
                }

                this.$nextTick(() => {
                    const sidebarItems = document.querySelectorAll('#blocks-container .block-item');
                    if (sidebarItems[bIdx]) {
                        sidebarItems[bIdx].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        const input = sidebarItems[bIdx].querySelector('input[type="text"], textarea');
                        if (input) input.focus();
                    }
                });
            },

            canvasActionChangeImage(bIdx, event) {
                if (event) event.stopPropagation();
                this.canvasTargetBlockIndex = bIdx;
                const fileInput = document.getElementById('canvas-quick-image-input');
                if (fileInput) {
                    fileInput.click();
                }
            },

            async handleCanvasImageUpload(event) {
                const file = event.target.files[0];
                if (!file || this.canvasTargetBlockIndex === null) return;
                const bIdx = this.canvasTargetBlockIndex;
                const block = this.blocks[bIdx];
                if (!block) return;

                const formData = new FormData();
                formData.append('image', file);

                Swal.fire({
                    title: 'Mengunggah Gambar...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    customClass: {
                        popup: 'bg-white/95 backdrop-blur-xl border border-slate-200 shadow-2xl rounded-3xl'
                    }
                });

                try {
                    const response = await fetch('{{ route('admin.pages.builder.upload_image') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: formData
                    });

                    const data = await response.json();
                    if (response.ok && data.url) {
                        if (block.type === 'image') {
                            block.content.image = data.url;
                        } else if (block.type === 'hero') {
                            block.content.bg_image = data.url;
                        } else if (block.type === 'feature') {
                            block.content.image_url = data.url;
                        } else if (block.type === 'glass_cards' && block.content && block.content.cards && block.content.cards.length > 0) {
                            block.content.cards[0].image = data.url;
                        } else if (block.type === 'html_custom' || block.type === 'html' || block.type === 'text') {
                            let rawHtml = typeof block.content === 'string' ? block.content : (block.content.html || '');
                            if (/<img[^>]+src=["'][^"']*["']/i.test(rawHtml)) {
                                rawHtml = rawHtml.replace(/(<img[^>]+src=["'])[^"']*["']/i, `$1${data.url}"`);
                            } else {
                                rawHtml += `<div class="my-6 text-center"><img src="${data.url}" alt="Gambar Komponen" class="max-w-2xl mx-auto rounded-3xl shadow-xl w-full object-cover"></div>`;
                            }
                            if (typeof block.content === 'string') {
                                block.content = rawHtml;
                            } else {
                                block.content.html = rawHtml;
                            }
                        } else if (block.content && typeof block.content === 'object') {
                            block.content.image = data.url;
                        }

                        this.syncState();
                        this.updatePreview(true);
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Gambar berhasil diperbarui!',
                            showConfirmButton: false,
                            timer: 2500,
                            customClass: {
                                popup: 'bg-slate-900/90 text-white rounded-2xl shadow-xl border border-slate-700'
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Mengunggah',
                            text: data.message || 'Gagal mengunggah gambar ke server.',
                            customClass: {
                                popup: 'bg-white/95 backdrop-blur-xl border border-slate-200 shadow-2xl rounded-3xl'
                            }
                        });
                    }
                } catch (err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan Sistem',
                        text: 'Terjadi kesalahan jaringan saat mengunggah gambar.',
                        customClass: {
                            popup: 'bg-white/95 backdrop-blur-xl border border-slate-200 shadow-2xl rounded-3xl'
                        }
                    });
                } finally {
                    event.target.value = '';
                }
            },

            canvasActionDelete(bIdx, event) {
                if (event) event.stopPropagation();
                Swal.fire({
                    title: 'Hapus Section Ini?',
                    text: 'Komponen section ini akan dihapus dari halaman.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'bg-white/95 backdrop-blur-xl border border-slate-200 shadow-2xl rounded-3xl'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.removeBlock(bIdx);
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Section berhasil dihapus.',
                            showConfirmButton: false,
                            timer: 2000,
                            customClass: {
                                popup: 'bg-slate-900/90 text-white rounded-2xl shadow-xl border border-slate-700'
                            }
                        });
                    }
                });
            },

            openAiModal(defaultPrompt = '') {
                this.aiPrompt = defaultPrompt || this.aiPrompt;
                this.showAiModal = true;
            },

            applyAiPreset(presetText) {
                this.aiPrompt = presetText;
            },

            async generateWithAi() {
                const prompt = (this.aiPrompt || '').trim();
                if (!prompt) return;

                this.isGeneratingAi = true;
                this.aiProgressText = 'Menganalisis prompt instruksi tata letak...';

                await new Promise(r => setTimeout(r, 220));
                this.aiProgressText = 'Menyusun struktur kolom responsif Tailwind CSS...';

                await new Promise(r => setTimeout(r, 220));
                this.aiProgressText = 'Mengharmonisasikan estetika & elemen interaktif...';

                await new Promise(r => setTimeout(r, 200));

                let cardStyleClass = '';
                if (this.aiStyle === 'glassmorphism') {
                    cardStyleClass = 'bg-white/90 backdrop-blur-xl border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-blue-300 hover:-translate-y-1.5 transition-all duration-300';
                } else if (this.aiStyle === 'card') {
                    cardStyleClass = 'bg-white border border-slate-200 shadow-lg hover:shadow-2xl hover:border-indigo-400 hover:-translate-y-1.5 transition-all duration-300';
                } else {
                    cardStyleClass = 'bg-slate-50/90 border border-slate-200 hover:bg-white hover:border-slate-300 hover:shadow-md transition-all duration-200';
                }

                let generatedHtml = '';

                // Pattern 1: Profil / 3 Kolom
                if (/3\s*kolom|profil|profile|struktur\s*profil|tugas\s*pokok|pilar/i.test(prompt)) {
                    generatedHtml = `<!-- SECTION: STRUKTUR PROFIL 3 KOLOM BPMP SULTRA -->
<div class="w-full max-w-6xl mx-auto py-12 px-4 sm:px-6">
    <!-- Header Section -->
    <div class="text-center max-w-3xl mx-auto mb-12">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-widest bg-blue-50 text-blue-700 border border-blue-200/60 mb-3 shadow-xs">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
            Profil & Pilar Layanan
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight mb-4 builder-editable" contenteditable="true" data-field="title">
            Struktur Profil & Pilar Transformasi Mutu Pendidikan
        </h2>
        <p class="text-base text-slate-600 leading-relaxed builder-editable" contenteditable="true" data-field="subtitle">
            Balai Penjaminan Mutu Pendidikan (BPMP) Provinsi Sulawesi Tenggara berkomitmen mengawal peningkatan mutu dan pemerataan akses pendidikan di 17 Kabupaten/Kota.
        </p>
    </div>

    <!-- 3 Kolom Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Kolom 1 -->
        <div class="group relative ${cardStyleClass} rounded-3xl p-8 flex flex-col justify-between">
            <div>
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center mb-6 shadow-md shadow-blue-500/25 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <span class="text-[11px] font-bold text-blue-600 uppercase tracking-widest block mb-1">Pilar 01</span>
                <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-blue-600 transition-colors builder-editable" contenteditable="true">
                    Kedudukan & Tugas Pokok
                </h3>
                <p class="text-sm text-slate-600 leading-relaxed mb-6 builder-editable" contenteditable="true">
                    Sebagai Unit Pelaksana Teknis Kementerian Pendidikan Dasar dan Menengah yang menyelenggarakan penjaminan dan fasilitasi peningkatan mutu pendidikan dasar dan menengah.
                </p>
                <ul class="space-y-2.5 text-xs text-slate-600 mb-6 border-t border-slate-100 pt-4">
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> <span>Pemetaan Mutu Pendidikan Berkelanjutan</span></li>
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> <span>Supervisi Satuan Pendidikan Daerah</span></li>
                </ul>
            </div>
            <a href="#" class="inline-flex items-center justify-between px-4 py-2.5 bg-slate-50 group-hover:bg-blue-50 text-slate-700 group-hover:text-blue-700 rounded-xl text-xs font-bold transition-colors">
                <span>Pelajari Selengkapnya</span>
                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <!-- Kolom 2 -->
        <div class="group relative ${cardStyleClass} rounded-3xl p-8 flex flex-col justify-between">
            <div>
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-indigo-600 to-purple-600 text-white flex items-center justify-center mb-6 shadow-md shadow-indigo-500/25 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <span class="text-[11px] font-bold text-indigo-600 uppercase tracking-widest block mb-1">Pilar 02</span>
                <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-indigo-600 transition-colors builder-editable" contenteditable="true">
                    Fasilitasi & Pendampingan Mutu
                </h3>
                <p class="text-sm text-slate-600 leading-relaxed mb-6 builder-editable" contenteditable="true">
                    Mendampingi implementasi kebijakan kurikulum, asesmen nasional, dan digitalisasi pembelajaran untuk seluruh jenjang sekolah di wilayah Sulawesi Tenggara.
                </p>
                <ul class="space-y-2.5 text-xs text-slate-600 mb-6 border-t border-slate-100 pt-4">
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> <span>Peningkatan Kapasitas SDM Pendidik</span></li>
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> <span>Pemanfaatan Rapor Pendidikan</span></li>
                </ul>
            </div>
            <a href="#" class="inline-flex items-center justify-between px-4 py-2.5 bg-slate-50 group-hover:bg-indigo-50 text-slate-700 group-hover:text-indigo-700 rounded-xl text-xs font-bold transition-colors">
                <span>Pelajari Selengkapnya</span>
                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <!-- Kolom 3 -->
        <div class="group relative ${cardStyleClass} rounded-3xl p-8 flex flex-col justify-between">
            <div>
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-teal-600 to-emerald-600 text-white flex items-center justify-center mb-6 shadow-md shadow-teal-500/25 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <span class="text-[11px] font-bold text-teal-600 uppercase tracking-widest block mb-1">Pilar 03</span>
                <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-teal-600 transition-colors builder-editable" contenteditable="true">
                    Kemitraan & Advokasi Pemda
                </h3>
                <p class="text-sm text-slate-600 leading-relaxed mb-6 builder-editable" contenteditable="true">
                    Membangun kolaborasi strategis dengan 17 Pemerintah Daerah untuk mendorong alokasi anggaran dan regulasi yang mendukung Standar Pelayanan Minimal (SPM) Pendidikan.
                </p>
                <ul class="space-y-2.5 text-xs text-slate-600 mb-6 border-t border-slate-100 pt-4">
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> <span>Advokasi Kebijakan SPM Pendidikan</span></li>
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> <span>Forum Komunikasi Pemangku Kepentingan</span></li>
                </ul>
            </div>
            <a href="#" class="inline-flex items-center justify-between px-4 py-2.5 bg-slate-50 group-hover:bg-teal-50 text-slate-700 group-hover:text-teal-700 rounded-xl text-xs font-bold transition-colors">
                <span>Pelajari Selengkapnya</span>
                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</div>`;
                } else if (/visi|misi|sasaran/i.test(prompt)) {
                    generatedHtml = `<!-- SECTION: VISI MISI & SASARAN STRATEGIS -->
<div class="w-full max-w-6xl mx-auto py-12 px-4 sm:px-6">
    <div class="text-center max-w-3xl mx-auto mb-12">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-widest bg-indigo-50 text-indigo-700 border border-indigo-200/60 mb-3 shadow-xs">
            Arah & Kebijakan
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight mb-4 builder-editable" contenteditable="true">
            Visi, Misi & Sasaran Strategis BPMP Sultra
        </h2>
        <p class="text-base text-slate-600 leading-relaxed builder-editable" contenteditable="true">
            Landasan kerja dan komitmen utama dalam mewujudkan layanan penjaminan mutu pendidikan yang berkualitas, transparan, dan berdampak nyata bagi daerah.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Visi Card (5 Cols) -->
        <div class="lg:col-span-5 ${cardStyleClass} rounded-3xl p-8 flex flex-col justify-between border-t-4 border-t-indigo-600">
            <div>
                <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest block mb-2">Visi Lembaga</span>
                <h3 class="text-2xl font-extrabold text-slate-900 leading-snug mb-6 builder-editable" contenteditable="true">
                    "Terwujudnya Penjaminan Mutu Pendidikan yang Unggul, Berkarakter, dan Berkelanjutan di Seluruh Wilayah Sulawesi Tenggara."
                </h3>
            </div>
            <div class="p-4 bg-indigo-50/70 rounded-2xl border border-indigo-100 flex items-center gap-3">
                <svg class="w-8 h-8 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span class="text-xs font-semibold text-indigo-900">Mendorong percepatan mutu berbasis data terpadu asesmen nasional.</span>
            </div>
        </div>

        <!-- Misi Cards (7 Cols) -->
        <div class="lg:col-span-7 space-y-4">
            <div class="${cardStyleClass} rounded-2xl p-6 flex items-start gap-4">
                <span class="w-9 h-9 rounded-xl bg-blue-600 text-white font-bold text-sm flex items-center justify-center shrink-0 shadow-sm">1</span>
                <div>
                    <h4 class="text-base font-bold text-slate-900 mb-1 builder-editable" contenteditable="true">Pemetaan & Fasilitasi Mutu Terintegrasi</h4>
                    <p class="text-xs text-slate-600 leading-relaxed builder-editable" contenteditable="true">Melaksanakan pemetaan mutu pendidikan secara komprehensif untuk seluruh jenjang PAUD, SD, SMP, SMA, dan SMK di 17 Kab/Kota.</p>
                </div>
            </div>
            <div class="${cardStyleClass} rounded-2xl p-6 flex items-start gap-4">
                <span class="w-9 h-9 rounded-xl bg-indigo-600 text-white font-bold text-sm flex items-center justify-center shrink-0 shadow-sm">2</span>
                <div>
                    <h4 class="text-base font-bold text-slate-900 mb-1 builder-editable" contenteditable="true">Supervisi & Pendampingan Satuan Pendidikan</h4>
                    <p class="text-xs text-slate-600 leading-relaxed builder-editable" contenteditable="true">Memberikan pendampingan langsung bagi satuan pendidikan dalam perencanaan berbasis data dan perbaikan iklim pembelajaran.</p>
                </div>
            </div>
            <div class="${cardStyleClass} rounded-2xl p-6 flex items-start gap-4">
                <span class="w-9 h-9 rounded-xl bg-teal-600 text-white font-bold text-sm flex items-center justify-center shrink-0 shadow-sm">3</span>
                <div>
                    <h4 class="text-base font-bold text-slate-900 mb-1 builder-editable" contenteditable="true">Kemitraan Strategis dengan Pemerintah Daerah</h4>
                    <p class="text-xs text-slate-600 leading-relaxed builder-editable" contenteditable="true">Memperkuat kolaborasi multipihak untuk mendorong capaian Standar Pelayanan Minimal (SPM) Pendidikan di daerah.</p>
                </div>
            </div>
        </div>
    </div>
</div>`;
                } else if (/statistik|indikator|kpi|capaian|metrik/i.test(prompt)) {
                    generatedHtml = `<!-- SECTION: STATISTIK & INDIKATOR CAPAIAN -->
<div class="w-full max-w-6xl mx-auto py-12 px-4 sm:px-6">
    <div class="text-center max-w-3xl mx-auto mb-12">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-widest bg-emerald-50 text-emerald-700 border border-emerald-200/60 mb-3 shadow-xs">
            Capaian Kinerja
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight mb-4 builder-editable" contenteditable="true">
            Statistik & Indikator Kinerja Utama
        </h2>
        <p class="text-base text-slate-600 leading-relaxed builder-editable" contenteditable="true">
            Akumulasi capaian pendampingan mutu pendidikan di seluruh wilayah kerja BPMP Sulawesi Tenggara.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="${cardStyleClass} rounded-3xl p-6 text-center group">
            <span class="text-4xl font-extrabold text-blue-600 block mb-2 builder-editable" contenteditable="true">17</span>
            <span class="text-sm font-bold text-slate-900 block mb-1 builder-editable" contenteditable="true">Kabupaten / Kota</span>
            <p class="text-xs text-slate-500 builder-editable" contenteditable="true">Terjangkau advokasi dan supervisi SPM pendidikan.</p>
        </div>
        <div class="${cardStyleClass} rounded-3xl p-6 text-center group">
            <span class="text-4xl font-extrabold text-indigo-600 block mb-2 builder-editable" contenteditable="true">4.250+</span>
            <span class="text-sm font-bold text-slate-900 block mb-1 builder-editable" contenteditable="true">Satuan Pendidikan</span>
            <p class="text-xs text-slate-500 builder-editable" contenteditable="true">Sekolah terbina dalam perencanaan berbasis data.</p>
        </div>
        <div class="${cardStyleClass} rounded-3xl p-6 text-center group">
            <span class="text-4xl font-extrabold text-emerald-600 block mb-2 builder-editable" contenteditable="true">98.6%</span>
            <span class="text-sm font-bold text-slate-900 block mb-1 builder-editable" contenteditable="true">Indeks Kepuasan</span>
            <p class="text-xs text-slate-500 builder-editable" contenteditable="true">Tingkat kepuasan masyarakat terhadap layanan ULT.</p>
        </div>
        <div class="${cardStyleClass} rounded-3xl p-6 text-center group">
            <span class="text-4xl font-extrabold text-amber-600 block mb-2 builder-editable" contenteditable="true">100%</span>
            <span class="text-sm font-bold text-slate-900 block mb-1 builder-editable" contenteditable="true">Aduan Tuntas</span>
            <p class="text-xs text-slate-500 builder-editable" contenteditable="true">Penyelesaian permohonan dan aduan tepat waktu.</p>
        </div>
    </div>
</div>`;
                } else if (/layanan|program|katalog|maklumat/i.test(prompt)) {
                    generatedHtml = `<!-- SECTION: 6 LAYANAN UNGGULAN -->
<div class="w-full max-w-6xl mx-auto py-12 px-4 sm:px-6">
    <div class="text-center max-w-3xl mx-auto mb-12">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-widest bg-amber-50 text-amber-700 border border-amber-200/60 mb-3 shadow-xs">
            Katalog Layanan Publik
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight mb-4 builder-editable" contenteditable="true">
            Daftar Layanan Unggulan BPMP Sultra
        </h2>
        <p class="text-base text-slate-600 leading-relaxed builder-editable" contenteditable="true">
            Akses cepat permohonan layanan publik terpadu, konsultasi, dan fasilitasi mutu pendidikan secara transparan.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="${cardStyleClass} rounded-3xl p-6 flex flex-col justify-between">
            <div>
                <span class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold mb-4">01</span>
                <h3 class="text-base font-bold text-slate-900 mb-2 builder-editable" contenteditable="true">Konsultasi Rapor Pendidikan</h3>
                <p class="text-xs text-slate-600 mb-4 builder-editable" contenteditable="true">Pendampingan analisis capaian indikator mutu sekolah dan rekomendasi pembenahan.</p>
            </div>
            <a href="#" class="text-xs font-bold text-blue-600 hover:text-blue-800">Ajukan Layanan &rarr;</a>
        </div>
        <div class="${cardStyleClass} rounded-3xl p-6 flex flex-col justify-between">
            <div>
                <span class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold mb-4">02</span>
                <h3 class="text-base font-bold text-slate-900 mb-2 builder-editable" contenteditable="true">Fasilitasi Kurikulum Merdeka</h3>
                <p class="text-xs text-slate-600 mb-4 builder-editable" contenteditable="true">Bimbingan teknis dan workshop penguatan pembelajaran mendalam di satuan pendidikan.</p>
            </div>
            <a href="#" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">Ajukan Layanan &rarr;</a>
        </div>
        <div class="${cardStyleClass} rounded-3xl p-6 flex flex-col justify-between">
            <div>
                <span class="w-10 h-10 rounded-xl bg-teal-100 text-teal-600 flex items-center justify-center font-bold mb-4">03</span>
                <h3 class="text-base font-bold text-slate-900 mb-2 builder-editable" contenteditable="true">Pendampingan SPM Pendidikan</h3>
                <p class="text-xs text-slate-600 mb-4 builder-editable" contenteditable="true">Advokasi terpadu bagi Dinas Pendidikan daerah dalam pengalokasian anggaran prioritas.</p>
            </div>
            <a href="#" class="text-xs font-bold text-teal-600 hover:text-teal-800">Ajukan Layanan &rarr;</a>
        </div>
        <div class="${cardStyleClass} rounded-3xl p-6 flex flex-col justify-between">
            <div>
                <span class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center font-bold mb-4">04</span>
                <h3 class="text-base font-bold text-slate-900 mb-2 builder-editable" contenteditable="true">Unit Layanan Terpadu (ULT)</h3>
                <p class="text-xs text-slate-600 mb-4 builder-editable" contenteditable="true">Pelayanan informasi publik, penerimaan tamu kedinasan, dan registrasi konsultasi langsung.</p>
            </div>
            <a href="#" class="text-xs font-bold text-purple-600 hover:text-purple-800">Ajukan Layanan &rarr;</a>
        </div>
        <div class="${cardStyleClass} rounded-3xl p-6 flex flex-col justify-between">
            <div>
                <span class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center font-bold mb-4">05</span>
                <h3 class="text-base font-bold text-slate-900 mb-2 builder-editable" contenteditable="true">Permohonan Narasumber & Fasilitator</h3>
                <p class="text-xs text-slate-600 mb-4 builder-editable" contenteditable="true">Layanan penyediaan widyaprada dan tenaga ahli penjaminan mutu untuk kegiatan daerah.</p>
            </div>
            <a href="#" class="text-xs font-bold text-amber-600 hover:text-amber-800">Ajukan Layanan &rarr;</a>
        </div>
        <div class="${cardStyleClass} rounded-3xl p-6 flex flex-col justify-between">
            <div>
                <span class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center font-bold mb-4">06</span>
                <h3 class="text-base font-bold text-slate-900 mb-2 builder-editable" contenteditable="true">Pengaduan & Aspirasi Masyarakat</h3>
                <p class="text-xs text-slate-600 mb-4 builder-editable" contenteditable="true">Kanal pelaporan resmi gratifikasi, benturan kepentingan, serta aduan layanan publik.</p>
            </div>
            <a href="#" class="text-xs font-bold text-rose-600 hover:text-rose-800">Ajukan Layanan &rarr;</a>
        </div>
    </div>
</div>`;
                } else if (/tim|pimpinan|organisasi|pejabat/i.test(prompt)) {
                    generatedHtml = `<!-- SECTION: STRUKTUR PIMPINAN & TIM -->
<div class="w-full max-w-6xl mx-auto py-12 px-4 sm:px-6">
    <div class="text-center max-w-3xl mx-auto mb-12">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-widest bg-purple-50 text-purple-700 border border-purple-200/60 mb-3 shadow-xs">
            Organisasi & Kepemimpinan
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight mb-4 builder-editable" contenteditable="true">
            Pimpinan & Tim Pengembang Mutu
        </h2>
        <p class="text-base text-slate-600 leading-relaxed builder-editable" contenteditable="true">
            Para penggerak transformasi penjaminan mutu pendidikan di wilayah Provinsi Sulawesi Tenggara.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="${cardStyleClass} rounded-3xl p-8 text-center group">
            <div class="w-24 h-24 mx-auto rounded-full bg-slate-200 border-4 border-white shadow-md overflow-hidden mb-6">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=300&fit=crop" class="w-full h-full object-cover">
            </div>
            <h3 class="text-lg font-bold text-slate-900 mb-1 builder-editable" contenteditable="true">Kepala Balai</h3>
            <span class="text-xs font-semibold text-blue-600 uppercase tracking-widest block mb-3 builder-editable" contenteditable="true">BPMP Provinsi Sulawesi Tenggara</span>
            <p class="text-xs text-slate-500 leading-relaxed builder-editable" contenteditable="true">Memimpin penetapan arah strategis dan kebijakan mutu pendidikan di daerah.</p>
        </div>
        <div class="${cardStyleClass} rounded-3xl p-8 text-center group">
            <div class="w-24 h-24 mx-auto rounded-full bg-slate-200 border-4 border-white shadow-md overflow-hidden mb-6">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&fit=crop" class="w-full h-full object-cover">
            </div>
            <h3 class="text-lg font-bold text-slate-900 mb-1 builder-editable" contenteditable="true">Kasubbag Umum</h3>
            <span class="text-xs font-semibold text-indigo-600 uppercase tracking-widest block mb-3 builder-editable" contenteditable="true">Tata Usaha & Keuangan</span>
            <p class="text-xs text-slate-500 leading-relaxed builder-editable" contenteditable="true">Mengelola koordinasi ketatausahaan, kepegawaian, keuangan, dan BMN.</p>
        </div>
        <div class="${cardStyleClass} rounded-3xl p-8 text-center group">
            <div class="w-24 h-24 mx-auto rounded-full bg-slate-200 border-4 border-white shadow-md overflow-hidden mb-6">
                <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&fit=crop" class="w-full h-full object-cover">
            </div>
            <h3 class="text-lg font-bold text-slate-900 mb-1 builder-editable" contenteditable="true">Koordinator Widyaprada</h3>
            <span class="text-xs font-semibold text-teal-600 uppercase tracking-widest block mb-3 builder-editable" contenteditable="true">Penjaminan Mutu Pendidikan</span>
            <p class="text-xs text-slate-500 leading-relaxed builder-editable" contenteditable="true">Memimpin gugus tugas supervisi teknis dan fasilitasi satuan pendidikan.</p>
        </div>
    </div>
</div>`;
                } else {
                    const sanitizedTitle = prompt.length > 50 ? prompt.substring(0, 50) + '...' : prompt;
                    generatedHtml = `<!-- SECTION: ${sanitizedTitle.toUpperCase()} -->
<div class="w-full max-w-6xl mx-auto py-12 px-4 sm:px-6">
    <div class="text-center max-w-3xl mx-auto mb-12">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-widest bg-blue-50 text-blue-700 border border-blue-200/60 mb-3 shadow-xs">
            Komponen Khusus
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight mb-4 builder-editable" contenteditable="true">
            ${prompt}
        </h2>
        <p class="text-base text-slate-600 leading-relaxed builder-editable" contenteditable="true">
            Struktur konten section dibuat secara cerdas oleh AI Assistant. Anda dapat langsung mengklik teks apa saja untuk menyunting.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="${cardStyleClass} rounded-3xl p-8 flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-bold mb-6 shadow-md shadow-blue-500/20">01</div>
                <h3 class="text-xl font-bold text-slate-900 mb-3 builder-editable" contenteditable="true">Pilar Informasi Utama</h3>
                <p class="text-sm text-slate-600 leading-relaxed mb-6 builder-editable" contenteditable="true">Ketikkan uraian penjelasan atau detail program kerja pada bagian kartu ini secara leluasa.</p>
            </div>
            <a href="#" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800">Pelajari Selengkapnya &rarr;</a>
        </div>
        <div class="${cardStyleClass} rounded-3xl p-8 flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-bold mb-6 shadow-md shadow-indigo-500/20">02</div>
                <h3 class="text-xl font-bold text-slate-900 mb-3 builder-editable" contenteditable="true">Fasilitasi & Pelayanan</h3>
                <p class="text-sm text-slate-600 leading-relaxed mb-6 builder-editable" contenteditable="true">Lengkapi poin-poin penting, data pendukung, atau tahapan alur proses yang ingin disampaikan.</p>
            </div>
            <a href="#" class="inline-flex items-center text-xs font-bold text-indigo-600 hover:text-indigo-800">Pelajari Selengkapnya &rarr;</a>
        </div>
        <div class="${cardStyleClass} rounded-3xl p-8 flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 rounded-2xl bg-teal-600 text-white flex items-center justify-center font-bold mb-6 shadow-md shadow-teal-500/20">03</div>
                <h3 class="text-xl font-bold text-slate-900 mb-3 builder-editable" contenteditable="true">Kemitraan & Evaluasi</h3>
                <p class="text-sm text-slate-600 leading-relaxed mb-6 builder-editable" contenteditable="true">Tambahkan ringkasan capaian, dokumen regulasi, atau tautan kontak layanan instansi.</p>
            </div>
            <a href="#" class="inline-flex items-center text-xs font-bold text-teal-600 hover:text-teal-800">Pelajari Selengkapnya &rarr;</a>
        </div>
    </div>
</div>`;
                }

                const newBlock = {
                    id: Date.now(),
                    type: 'html_custom',
                    settings: {
                        bg: 'transparent',
                        padding: 'none',
                        align: 'left',
                        wrapper_class: ''
                    },
                    content: {
                        html: generatedHtml
                    }
                };

                if (this.aiPosition === 'top') {
                    this.blocks.unshift(newBlock);
                    this.activeBlockIndex = 0;
                } else if (this.aiPosition === 'replace' && this.activeBlockIndex !== null) {
                    this.blocks.splice(this.activeBlockIndex, 1, newBlock);
                } else {
                    this.blocks.push(newBlock);
                    this.activeBlockIndex = this.blocks.length - 1;
                }

                this.syncState();
                this.updatePreview(true);
                this.initSortable();

                this.isGeneratingAi = false;
                this.showAiModal = false;

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '✨ Struktur section berhasil dirancang oleh AI Assistant!',
                    showConfirmButton: false,
                    timer: 3500,
                    customClass: {
                        popup: 'bg-slate-900/90 text-white rounded-2xl shadow-xl border border-slate-700'
                    }
                });

                this.$nextTick(() => {
                    const targetEl = document.querySelector(`[data-block-index="${this.activeBlockIndex}"]`);
                    if (targetEl) {
                        targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                });
            },

            loadTemplate(type) {
                if (type === 'ult' || type === 'ult-terpadu' || type === 'unit-layanan-terpadu') {
                    this.blocks = [
                        {
                            id: Date.now() + 1,
                            type: 'html_custom',
                            settings: { bg: 'transparent', padding: 'none', align: '', wrapper_class: '' },
                            content: {
                                html: `<!-- Wrapper Utama ULT dengan Alpine.js State -->
<div x-data="{ activeTab: 'online' }" class="w-full max-w-6xl mx-auto space-y-8 mt-8">
    
    <!-- NAVIGASI TAB UTAMA -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <!-- Tab 1: Online -->
        <button @click="activeTab = 'online'" :class="activeTab === 'online' ? 'border-blue-500 bg-blue-50 shadow-md ring-1 ring-blue-500' : 'border-slate-200 bg-white hover:bg-slate-50'" class="flex flex-col items-center justify-center p-6 rounded-3xl border transition-all duration-300 group">
            <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="font-bold text-slate-800 text-sm">Layanan Online</h3>
        </button>

        <!-- Tab 2: Tatap Muka -->
        <button @click="activeTab = 'tatap-muka'" :class="activeTab === 'tatap-muka' ? 'border-indigo-500 bg-indigo-50 shadow-md ring-1 ring-indigo-500' : 'border-slate-200 bg-white hover:bg-slate-50'" class="flex flex-col items-center justify-center p-6 rounded-3xl border transition-all duration-300 group">
            <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <h3 class="font-bold text-slate-800 text-sm">Layanan Tatap Muka</h3>
        </button>

        <!-- Tab 3: Keliling -->
        <button @click="activeTab = 'keliling'" :class="activeTab === 'keliling' ? 'border-teal-500 bg-teal-50 shadow-md ring-1 ring-teal-500' : 'border-slate-200 bg-white hover:bg-slate-50'" class="flex flex-col items-center justify-center p-6 rounded-3xl border transition-all duration-300 group">
            <div class="w-12 h-12 rounded-full bg-teal-100 text-teal-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
            </div>
            <h3 class="font-bold text-slate-800 text-sm">Layanan Keliling</h3>
        </button>

        <!-- Tab 4: Tim ULT -->
        <button @click="activeTab = 'tim-ult'" :class="activeTab === 'tim-ult' ? 'border-purple-500 bg-purple-50 shadow-md ring-1 ring-purple-500' : 'border-slate-200 bg-white hover:bg-slate-50'" class="flex flex-col items-center justify-center p-6 rounded-3xl border transition-all duration-300 group">
            <div class="w-12 h-12 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
            <h3 class="font-bold text-slate-800 text-sm">Tim ULT</h3>
        </button>
    </div>

    <!-- AREA KONTEN TAB -->
    <div class="relative bg-white/80 backdrop-blur-xl border border-slate-100 shadow-sm rounded-[2.5rem] p-8 md:p-12 min-h-[500px]">
        
        <!-- 1. KONTEN ONLINE -->
        <div x-show="activeTab === 'online'" x-transition.opacity.duration.500ms>
            <div class="max-w-4xl mx-auto">
                <div class="mb-8 border-b border-slate-100 pb-6">
                    <h3 class="text-3xl font-extrabold text-slate-800">Permohonan Layanan Daring</h3>
                    <p class="text-slate-500 mt-2">Silakan lengkapi formulir di bawah ini dengan data yang valid.</p>
                </div>
                <!-- Native Form Online -->
                <form action="#" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Kategori *</label>
                            <select name="kategori" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all" required>
                                <option value="">-- Pilih Kategori Layanan --</option>
                                <option value="Pelayanan Permohonan Informasi">Pelayanan Permohonan Informasi</option>
                                <option value="Pelayanan Peminjaman Fasilitas">Pelayanan Peminjaman Fasilitas</option>
                                <option value="Pelayanan Data dan Informasi Mutu">Pelayanan Data dan Informasi Mutu</option>
                                <option value="Pelayanan Supervisi Mutu Pendidikan">Pelayanan Supervisi Mutu Pendidikan</option>
                                <option value="Pelayanan Kerja sama Peningkatan Mutu">Pelayanan Kerja sama Peningkatan Mutu</option>
                                <option value="Pelayanan Permohonan Narasumber">Pelayanan Permohonan Narasumber</option>
                                <option value="Pelayanan Pengaduan">Pelayanan Pengaduan</option>
                                <option value="Pelayanan Magang/Prakerin/Penelitian">Pelayanan Magang/Prakerin/Penelitian</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap *</label>
                            <input type="text" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all" placeholder="Masukkan nama..." required>
                        </div>
                    </div>
                    <button type="button" class="px-8 py-4 bg-blue-600 text-white font-bold rounded-2xl shadow-lg hover:bg-blue-700 hover:-translate-y-1 transition-all w-full md:w-auto">Kirim Permohonan Online</button>
                </form>
            </div>
        </div>

        <!-- 2. KONTEN TATAP MUKA (DENGAN LOCK SCREEN) -->
        <div x-show="activeTab === 'tatap-muka'" x-transition.opacity.duration.500ms x-data="{ isUnlocked: false, password: '', errorMsg: '' }">
            
            <!-- Lock Screen -->
            <div x-show="!isUnlocked" class="max-w-md mx-auto text-center py-10">
                <div class="w-20 h-20 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-2">Akses Terkunci</h3>
                <p class="text-slate-500 mb-8">Silakan minta kode akses kunjungan dari petugas Resepsionis ULT.</p>
                <input type="password" x-model="password" @keyup.enter="if(password === 'ULT2026') { isUnlocked = true; errorMsg = ''; } else { errorMsg = 'Kode akses tidak valid!'; }" class="w-full px-4 py-4 rounded-2xl bg-slate-50 border border-slate-200 text-center tracking-[0.5em] text-lg focus:ring-4 focus:ring-indigo-500/20 outline-none mb-3 font-bold text-slate-700" placeholder="••••••">
                <p x-show="errorMsg" x-text="errorMsg" class="text-red-500 text-sm font-semibold mb-4"></p>
                <button @click="if(password === 'ULT2026') { isUnlocked = true; errorMsg = ''; } else { errorMsg = 'Kode akses tidak valid!'; }" class="w-full py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-lg hover:bg-indigo-700 transition-colors">Buka Formulir Kunjungan</button>
            </div>

            <!-- Form Terbuka -->
            <div x-show="isUnlocked" style="display: none;" class="max-w-4xl mx-auto">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-slate-100 pb-6 gap-4">
                    <div>
                        <h3 class="text-3xl font-extrabold text-slate-800">Buku Tamu Front Office</h3>
                        <p class="text-slate-500 mt-2">Selamat datang di ruang pelayanan BPMP Sultra.</p>
                    </div>
                    <button @click="isUnlocked = false; password = '';" class="px-4 py-2 bg-rose-50 text-rose-600 font-bold rounded-xl hover:bg-rose-100 transition-colors text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg> Kunci Layar
                    </button>
                </div>
                <!-- Native Form Tatap Muka -->
                <form action="#" method="POST" class="space-y-6">
                    <!-- Isi field buku tamu -->
                    <div class="p-6 bg-slate-50 border border-slate-200 rounded-2xl text-center text-slate-500 font-semibold italic">Area Input Native Form Tatap Muka...</div>
                </form>
            </div>
        </div>

        <!-- 3. KONTEN KELILING -->
        <div x-show="activeTab === 'keliling'" x-transition.opacity.duration.500ms>
            <div class="max-w-4xl mx-auto text-center py-10">
                <h3 class="text-3xl font-extrabold text-slate-800 mb-4">Layanan Mobile Service</h3>
                <p class="text-slate-500 mb-8">Pengajuan tim layanan jemput bola ke daerah Kabupaten/Kota.</p>
                <!-- Native Form Keliling -->
                <div class="p-6 bg-slate-50 border border-slate-200 rounded-2xl text-center text-slate-500 font-semibold italic">Area Input Native Form Keliling...</div>
            </div>
        </div>

        <!-- 4. KONTEN TIM ULT -->
        <div x-show="activeTab === 'tim-ult'" x-transition.opacity.duration.500ms>
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-12">
                    <h3 class="text-3xl font-extrabold text-slate-800">Struktur Tim Pelayanan</h3>
                    <p class="text-slate-500 mt-2">Daftar petugas resmi Unit Layanan Terpadu BPMP Sultra.</p>
                </div>
                <!-- Grid Tim -->
                <div class="flex justify-center mb-8">
                    <div class="bg-blue-50 border-t-4 border-blue-600 rounded-2xl p-6 w-80 text-center shadow-sm">
                        <h4 class="text-xs font-bold text-blue-400 uppercase tracking-widest mb-2">Koordinator</h4>
                        <h3 class="text-lg font-extrabold text-blue-900">Sitti Samsuria, S.E.</h3>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 shadow-sm"><h4 class="font-bold text-slate-700 text-sm mb-3">Narasumber</h4><ul class="text-slate-600 text-sm space-y-1"><li>La Siara, S.Pd., M.Pd.</li><li>Elyati</li></ul></div>
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 shadow-sm"><h4 class="font-bold text-slate-700 text-sm mb-3">Data & Informasi</h4><ul class="text-slate-600 text-sm space-y-1"><li>Rohmad, S.E., M.Si.</li></ul></div>
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 shadow-sm"><h4 class="font-bold text-slate-700 text-sm mb-3">SarPras</h4><ul class="text-slate-600 text-sm space-y-1"><li>H. Usman N., S.Pd.</li><li>Asruddin</li><li>Novri Hardiansyah, S.IP.</li></ul></div>
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 shadow-sm"><h4 class="font-bold text-slate-700 text-sm mb-3">Magang</h4><ul class="text-slate-600 text-sm space-y-1"><li>H. Syamsul Bahri</li><li>Hariudin, S.E.</li></ul></div>
                </div>
            </div>
        </div>

    </div>
</div>`
                            }
                        }
                    ];
                } else if (type === 'skm-utama' || type === 'skm_utama' || type === 'skm') {
                    this.blocks = [
                        {
                            id: Date.now() + 1,
                            type: 'html_custom',
                            settings: { bg: 'transparent', padding: 'none', align: '', wrapper_class: '' },
                            content: {
                                html: `<!-- Wrapper Utama SKM dengan Alpine.js Lightbox State -->
<div x-data="{ showModal: false, modalImg: '', modalTitle: '' }" class="w-full max-w-7xl mx-auto">
    <div class="bg-white/95 backdrop-blur-xl rounded-[2.5rem] shadow-sm border border-slate-100 p-8 md:p-12 mb-8">
        
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-slate-800">Laporan Kepuasan Masyarakat (SKM)</h2>
            <p class="text-slate-500 mt-2">Publikasi hasil survei dan tindak lanjut performa pelayanan publik BPMP Sultra.</p>
        </div>

        <!-- Grid Kartu SKM -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- KARTU TRIWULAN I -->
            <div class="bg-slate-50 rounded-3xl border border-slate-200 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col group">
                <div class="relative h-56 overflow-hidden bg-slate-200 cursor-pointer" 
                     @click="showModal = true; modalImg = 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=1200&auto=format&fit=crop&q=80'; modalTitle = 'Infografis SKM Triwulan I'">
                    <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=600&auto=format&fit=crop&q=80" alt="Infografis TW 1" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-blue-900/0 group-hover:bg-blue-900/20 transition-colors flex items-center justify-center">
                        <div class="bg-white/90 backdrop-blur text-blue-600 px-4 py-2 rounded-full font-bold text-sm opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-4 group-hover:translate-y-0 shadow-lg">Lihat Infografis</div>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow text-center">
                    <span class="text-xs font-extrabold text-blue-500 uppercase tracking-widest mb-1">Tahun 2026</span>
                    <h3 class="text-xl font-bold text-slate-800 mb-6">Triwulan I</h3>
                    <div class="mt-auto">
                        <!-- URL ini diarahkan ke halaman detail yang dibuat terpisah -->
                        <a href="/halaman/skm-tw-1-2026" class="block w-full py-3 bg-white hover:bg-blue-600 text-blue-600 hover:text-white font-bold rounded-xl transition-colors border border-blue-100 hover:border-blue-600">Lihat Dokumen</a>
                    </div>
                </div>
            </div>

            <!-- KARTU TRIWULAN II -->
            <div class="bg-slate-50 rounded-3xl border border-slate-200 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col group">
                <div class="relative h-56 overflow-hidden bg-slate-200 cursor-pointer" @click="showModal = true; modalImg = 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1200&auto=format&fit=crop&q=80'; modalTitle = 'Infografis SKM Triwulan II'">
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&auto=format&fit=crop&q=80" alt="Infografis TW 2" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-blue-900/0 group-hover:bg-blue-900/20 transition-colors flex items-center justify-center">
                        <div class="bg-white/90 backdrop-blur text-blue-600 px-4 py-2 rounded-full font-bold text-sm opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-4 group-hover:translate-y-0 shadow-lg">Lihat Infografis</div>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow text-center">
                    <span class="text-xs font-extrabold text-blue-500 uppercase tracking-widest mb-1">Tahun 2026</span>
                    <h3 class="text-xl font-bold text-slate-800 mb-6">Triwulan II</h3>
                    <div class="mt-auto">
                        <a href="/halaman/skm-tw-2-2026" class="block w-full py-3 bg-white hover:bg-blue-600 text-blue-600 hover:text-white font-bold rounded-xl transition-colors border border-blue-100 hover:border-blue-600">Lihat Dokumen</a>
                    </div>
                </div>
            </div>

            <!-- KARTU TRIWULAN III -->
            <div class="bg-slate-50 rounded-3xl border border-slate-200 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col group">
                <div class="relative h-56 overflow-hidden bg-slate-200 cursor-pointer" @click="showModal = true; modalImg = 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=1200&auto=format&fit=crop&q=80'; modalTitle = 'Infografis SKM Triwulan III'">
                    <img src="https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=600&auto=format&fit=crop&q=80" alt="Infografis TW 3" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-blue-900/0 group-hover:bg-blue-900/20 transition-colors flex items-center justify-center">
                        <div class="bg-white/90 backdrop-blur text-blue-600 px-4 py-2 rounded-full font-bold text-sm opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-4 group-hover:translate-y-0 shadow-lg">Lihat Infografis</div>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow text-center">
                    <span class="text-xs font-extrabold text-blue-500 uppercase tracking-widest mb-1">Tahun 2026</span>
                    <h3 class="text-xl font-bold text-slate-800 mb-6">Triwulan III</h3>
                    <div class="mt-auto">
                        <a href="/halaman/skm-tw-3-2026" class="block w-full py-3 bg-white hover:bg-blue-600 text-blue-600 hover:text-white font-bold rounded-xl transition-colors border border-blue-100 hover:border-blue-600">Lihat Dokumen</a>
                    </div>
                </div>
            </div>

            <!-- KARTU TRIWULAN IV -->
            <div class="bg-slate-50 rounded-3xl border border-slate-200 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col group">
                <div class="relative h-56 overflow-hidden bg-slate-200 cursor-pointer" @click="showModal = true; modalImg = 'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=1200&auto=format&fit=crop&q=80'; modalTitle = 'Infografis SKM Triwulan IV'">
                    <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?w=600&auto=format&fit=crop&q=80" alt="Infografis TW 4" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-blue-900/0 group-hover:bg-blue-900/20 transition-colors flex items-center justify-center">
                        <div class="bg-white/90 backdrop-blur text-blue-600 px-4 py-2 rounded-full font-bold text-sm opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-4 group-hover:translate-y-0 shadow-lg">Lihat Infografis</div>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow text-center">
                    <span class="text-xs font-extrabold text-blue-500 uppercase tracking-widest mb-1">Tahun 2026</span>
                    <h3 class="text-xl font-bold text-slate-800 mb-6">Triwulan IV</h3>
                    <div class="mt-auto">
                        <a href="/halaman/skm-tw-4-2026" class="block w-full py-3 bg-white hover:bg-blue-600 text-blue-600 hover:text-white font-bold rounded-xl transition-colors border border-blue-100 hover:border-blue-600">Lihat Dokumen</a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <!-- MODAL POP-UP (LIGHTBOX) -->
    <div x-show="showModal" class="fixed inset-0 z-[999] flex items-center justify-center p-4 sm:p-6" style="display: none;" @keydown.escape.window="showModal = false">
        <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm" @click="showModal = false"></div>
        <div x-show="showModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-8"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-8"
             class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden z-10">
            <div class="flex justify-between items-center p-4 border-b border-slate-100 bg-slate-50/80 backdrop-blur">
                <h4 class="font-bold text-slate-800" x-text="modalTitle"></h4>
                <button type="button" @click="showModal = false" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-200 text-slate-600 hover:bg-red-100 hover:text-red-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="overflow-y-auto p-4 bg-slate-100 flex-grow flex items-center justify-center">
                <img :src="modalImg" class="w-full h-auto max-h-[75vh] object-contain rounded-xl shadow-sm">
            </div>
        </div>
    </div>
</div>`
                            }
                        }
                    ];
                } else if (type === 'skm-detail' || type === 'skm_detail' || type === 'skm-tindak-lanjut') {
                    this.blocks = [
                        {
                            id: Date.now() + 1,
                            type: 'html_custom',
                            settings: { bg: 'transparent', padding: 'none', align: '', wrapper_class: '' },
                            content: {
                                html: `<!-- Wrapper Halaman Detail SKM Terpadu (Laporan & Tindak Lanjut) -->
<div x-data="{ activeDocTab: 'skm' }" class="w-full max-w-6xl mx-auto mb-10">
    <div class="bg-white/95 backdrop-blur-xl rounded-[2rem] border border-slate-100 shadow-sm p-6 md:p-8">
        
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-slate-800 mb-2">Laporan SKM Triwulan I</h2>
            <p class="text-slate-500">Periode Januari - Maret 2026</p>
        </div>

        <!-- Switcher Tab -->
        <div class="flex justify-center mb-8">
            <div class="inline-flex bg-slate-100 p-1.5 rounded-2xl">
                <button type="button" @click="activeDocTab = 'skm'" :class="activeDocTab === 'skm' ? 'bg-white text-blue-600 shadow-sm font-bold' : 'text-slate-500 hover:text-slate-700 font-medium'" class="px-6 py-2.5 rounded-xl text-sm transition-all">
                    Dokumen Laporan SKM
                </button>
                <button type="button" @click="activeDocTab = 'tindak-lanjut'" :class="activeDocTab === 'tindak-lanjut' ? 'bg-white text-blue-600 shadow-sm font-bold' : 'text-slate-500 hover:text-slate-700 font-medium'" class="px-6 py-2.5 rounded-xl text-sm transition-all">
                    Tindak Lanjut Hasil SKM
                </button>
            </div>
        </div>

        <!-- Iframe Laporan SKM -->
        <div x-show="activeDocTab === 'skm'" x-transition.opacity class="w-full bg-slate-100 rounded-2xl overflow-hidden border border-slate-200">
            <iframe src="https://drive.google.com/file/d/YOUR_FILE_ID_HERE/preview" class="w-full h-[600px] md:h-[800px] border-0" allow="autoplay"></iframe>
        </div>

        <!-- Iframe Tindak Lanjut -->
        <div x-show="activeDocTab === 'tindak-lanjut'" x-transition.opacity class="w-full bg-slate-100 rounded-2xl overflow-hidden border border-slate-200" style="display: none;">
            <iframe src="https://drive.google.com/file/d/YOUR_FILE_ID_HERE/preview" class="w-full h-[600px] md:h-[800px] border-0" allow="autoplay"></iframe>
        </div>
    </div>
</div>`
                            }
                        }
                    ];
                } else if (type === 'profil-mutu' || type === 'profil_mutu' || type === 'mutu-pendidikan') {
                    this.blocks = [
                        {
                            id: Date.now() + 1,
                            type: 'html_custom',
                            settings: { bg: 'transparent', padding: 'none', align: '', wrapper_class: '' },
                            content: {
                                html: `<!-- Profil Mutu Pendidikan (Split Layout, 1 Giant Card, & Grid 5 Kolom) -->
<div x-data="{ 
        showModal: false, 
        pdfTitle: '', 
        pdfUrl: '', 
        fileInfo: '',
        openModal(title, url, info) {
            this.pdfTitle = title;
            this.pdfUrl = url;
            this.fileInfo = info;
            this.showModal = true;
        },
        copyLink() {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(this.pdfUrl).then(() => {
                    alert('Tautan berhasil disalin: ' + this.pdfUrl);
                }).catch(() => {
                    prompt('Salin tautan dokumen PDF:', this.pdfUrl);
                });
            } else {
                prompt('Salin tautan dokumen PDF:', this.pdfUrl);
            }
        }
    }" 
    class="w-full space-y-12"> <!-- Hapus batasan lebar di sini, ikuti Master Template -->
        
        <!-- 1. KATA SAMBUTAN PIMPINAN (Split Layout) -->
        <div class="flex flex-col lg:flex-row items-center gap-10 lg:gap-16">
            <!-- Foto Pimpinan -->
            <div class="w-full lg:w-1/3 shrink-0">
                <div class="relative rounded-[2rem] overflow-hidden shadow-md group">
                    <!-- Silakan ganti link gambar pimpinan -->
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=800&fit=crop" alt="Sambutan Pimpinan" class="w-full h-auto aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-blue-900/90 via-blue-900/10 to-transparent flex items-end p-6">
                        <div>
                            <h4 class="text-white font-bold text-xl md:text-2xl">Dr. Hendra Wijaya, M.Pd.</h4>
                            <p class="text-blue-200 text-sm md:text-base font-medium mt-1">Kepala BPMP Provinsi Sulawesi Tenggara</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Teks Sambutan -->
            <div class="w-full lg:w-2/3 space-y-6">
                <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-blue-50 text-blue-600 font-bold text-sm uppercase tracking-widest border border-blue-100">Kata Sambutan</div>
                <h2 class="text-3xl lg:text-5xl font-extrabold text-slate-800 leading-tight">Mewujudkan Layanan Pendidikan yang Adaptif &amp; Inklusif</h2>
                <div class="prose prose-slate prose-lg md:prose-xl max-w-none text-slate-600 leading-relaxed">
                    <p>Puji syukur ke hadirat Allah SWT, Buku Profil Mutu Pendidikan Provinsi Sulawesi Tenggara Tahun 2026 ini dapat terselesaikan. Rapor Pendidikan 2026 yang dirilis oleh Kemendikbudristek menjadi acuan utama kami dalam melaksanakan fungsi pemetaan mutu pendidikan.</p>
                    <p>Besar harapan kami, profil ini dapat memenuhi kebutuhan Pemerintah Daerah dalam membuat kebijakan pendidikan yang lebih terarah guna mewujudkan layanan pendidikan berkualitas yang kita cita-citakan.</p>
                </div>
            </div>
        </div>

        <!-- GARIS PEMISAH HALUS -->
        <div class="w-full h-px bg-slate-200 my-16"></div>

        <!-- 2. KATA PENGANTAR (Split Layout) -->
        <div class="flex flex-col-reverse lg:flex-row items-center gap-10 lg:gap-16">
            <!-- Teks Pengantar -->
            <div class="w-full lg:w-2/3 space-y-6">
                <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-amber-50 text-amber-600 font-bold text-sm uppercase tracking-widest border border-amber-100">Kata Pengantar</div>
                <h2 class="text-3xl lg:text-5xl font-extrabold text-slate-800 leading-tight">Referensi Utama Analisis Perencanaan Mutu</h2>
                <div class="prose prose-slate prose-lg md:prose-xl max-w-none text-slate-600 leading-relaxed">
                    <p>Buku Profil Mutu Pendidikan adalah publikasi tahunan yang diterbitkan oleh BPMP Provinsi Sulawesi Tenggara. Hasil Rapor Pendidikan didukung oleh berbagai sumber data kredibel seperti Asesmen Nasional (AN) dan Survei Karakter.</p>
                    <p>Profil Mutu Pendidikan 2026 dapat dibaca dan diunduh melalui website BPMP Sultra yang dilengkapi dengan detail data capaian daerah.</p>
                </div>
            </div>
            <!-- Foto Pengantar -->
            <div class="w-full lg:w-1/3 shrink-0">
                <div class="relative rounded-[2rem] overflow-hidden shadow-md group">
                    <!-- Silakan ganti link gambar pengantar -->
                    <img src="https://images.unsplash.com/photo-1497215728101-856f4ea42174?w=800&fit=crop" alt="Kata Pengantar" class="w-full h-auto aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-700">
                </div>
            </div>
        </div>

        <!-- GARIS PEMISAH HALUS -->
        <div class="w-full h-px bg-slate-200 my-16"></div>

        <!-- 3. GRID 18 KABUPATEN / KOTA -->
        <div class="text-center mb-12">
            <h3 class="text-3xl md:text-4xl font-extrabold text-slate-800">Profil Mutu per Daerah</h3>
            <p class="text-slate-500 mt-3 text-lg md:text-xl">Pilih Kabupaten/Kota untuk melihat dokumen profil mutu pendidikan secara spesifik.</p>
        </div>

        <!-- Layout Grid Proporsional untuk Layar Sangat Lebar (Up to 5 Kolom) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-5 lg:gap-6">
            
            <!-- 1. Provinsi Sulawesi Tenggara (Biru Utama) -->
            <button type="button" @click="openModal('Profil Mutu Provinsi Sulawesi Tenggara', 'https://drive.google.com/file/d/CONTOH_ID/preview', 'Provinsi Sulawesi Tenggara • PDF')" 
                    class="group relative bg-blue-50/80 backdrop-blur-md border border-blue-200 rounded-2xl p-5 shadow-sm hover:shadow-xl hover:border-blue-400 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-blue-500 group-hover:text-blue-700 shadow-sm transition-all group-hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-blue-500 font-extrabold uppercase tracking-widest block mb-1">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-blue-900 leading-tight">Prov. Sulawesi Tenggara</h4>
                    <span class="text-[11px] text-blue-400/80 mt-1 flex items-center gap-1 font-medium">Laporan Induk • 2.4 MB</span>
                </div>
            </button>

            <!-- 2. Kota Kendari -->
            <button type="button" @click="openModal('Profil Mutu Kota Kendari', 'https://drive.google.com/file/d/CONTOH_ID_KENDARI/preview', 'Kota Kendari • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kota Kendari</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.8 MB</span>
                </div>
            </button>

            <!-- 3. Kota Baubau -->
            <button type="button" @click="openModal('Profil Mutu Kota Baubau', 'https://drive.google.com/file/d/CONTOH_ID_BAUBAU/preview', 'Kota Baubau • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kota Baubau</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.7 MB</span>
                </div>
            </button>

            <!-- 4. Kab. Konawe -->
            <button type="button" @click="openModal('Profil Mutu Kab. Konawe', 'https://drive.google.com/file/d/CONTOH_ID_KONAWE/preview', 'Kab. Konawe • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Konawe</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.9 MB</span>
                </div>
            </button>

            <!-- 5. Kab. Konawe Selatan -->
            <button type="button" @click="openModal('Profil Mutu Kab. Konawe Selatan', 'https://drive.google.com/file/d/CONTOH_ID_KONSEL/preview', 'Kab. Konawe Selatan • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Konawe Selatan</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.8 MB</span>
                </div>
            </button>

            <!-- 6. Kab. Konawe Utara -->
            <button type="button" @click="openModal('Profil Mutu Kab. Konawe Utara', 'https://drive.google.com/file/d/CONTOH_ID_KONUT/preview', 'Kab. Konawe Utara • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Konawe Utara</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.6 MB</span>
                </div>
            </button>

            <!-- 7. Kab. Konawe Kepulauan -->
            <button type="button" @click="openModal('Profil Mutu Kab. Konawe Kepulauan', 'https://drive.google.com/file/d/CONTOH_ID_KONKEP/preview', 'Kab. Konawe Kepulauan • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Konawe Kepulauan</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.5 MB</span>
                </div>
            </button>

            <!-- 8. Kab. Kolaka -->
            <button type="button" @click="openModal('Profil Mutu Kab. Kolaka', 'https://drive.google.com/file/d/CONTOH_ID_KOLAKA/preview', 'Kab. Kolaka • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Kolaka</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.9 MB</span>
                </div>
            </button>

            <!-- 9. Kab. Kolaka Utara -->
            <button type="button" @click="openModal('Profil Mutu Kab. Kolaka Utara', 'https://drive.google.com/file/d/CONTOH_ID_KOLUT/preview', 'Kab. Kolaka Utara • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Kolaka Utara</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.7 MB</span>
                </div>
            </button>

            <!-- 10. Kab. Kolaka Timur -->
            <button type="button" @click="openModal('Profil Mutu Kab. Kolaka Timur', 'https://drive.google.com/file/d/CONTOH_ID_KOLTIM/preview', 'Kab. Kolaka Timur • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Kolaka Timur</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.6 MB</span>
                </div>
            </button>

            <!-- 11. Kab. Buton -->
            <button type="button" @click="openModal('Profil Mutu Kab. Buton', 'https://drive.google.com/file/d/CONTOH_ID_BUTON/preview', 'Kab. Buton • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Buton</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.9 MB</span>
                </div>
            </button>

            <!-- 12. Kab. Buton Selatan -->
            <button type="button" @click="openModal('Profil Mutu Kab. Buton Selatan', 'https://drive.google.com/file/d/CONTOH_ID_BUSEL/preview', 'Kab. Buton Selatan • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Buton Selatan</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.6 MB</span>
                </div>
            </button>

            <!-- 13. Kab. Buton Tengah -->
            <button type="button" @click="openModal('Profil Mutu Kab. Buton Tengah', 'https://drive.google.com/file/d/CONTOH_ID_BUTENG/preview', 'Kab. Buton Tengah • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Buton Tengah</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.7 MB</span>
                </div>
            </button>

            <!-- 14. Kab. Buton Utara -->
            <button type="button" @click="openModal('Profil Mutu Kab. Buton Utara', 'https://drive.google.com/file/d/CONTOH_ID_BUTUR/preview', 'Kab. Buton Utara • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Buton Utara</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.6 MB</span>
                </div>
            </button>

            <!-- 15. Kab. Muna -->
            <button type="button" @click="openModal('Profil Mutu Kab. Muna', 'https://drive.google.com/file/d/CONTOH_ID_MUNA/preview', 'Kab. Muna • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Muna</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 2.0 MB</span>
                </div>
            </button>

            <!-- 16. Kab. Muna Barat -->
            <button type="button" @click="openModal('Profil Mutu Kab. Muna Barat', 'https://drive.google.com/file/d/CONTOH_ID_MUBAR/preview', 'Kab. Muna Barat • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Muna Barat</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.7 MB</span>
                </div>
            </button>

            <!-- 17. Kab. Wakatobi -->
            <button type="button" @click="openModal('Profil Mutu Kab. Wakatobi', 'https://drive.google.com/file/d/CONTOH_ID_WAKATOBI/preview', 'Kab. Wakatobi • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Wakatobi</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.8 MB</span>
                </div>
            </button>

            <!-- 18. Kab. Bombana -->
            <button type="button" @click="openModal('Profil Mutu Kab. Bombana', 'https://drive.google.com/file/d/CONTOH_ID_BOMBANA/preview', 'Kab. Bombana • PDF')" 
                    class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 text-left overflow-hidden flex flex-col justify-center min-h-[120px]">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="relative z-10 pr-14">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-500 transition-colors">Buka Dokumen</span>
                    <h4 class="text-base lg:text-lg font-bold text-slate-700 leading-tight group-hover:text-blue-700 transition-colors">Kab. Bombana</h4>
                    <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">Laporan Daerah • 1.9 MB</span>
                </div>
            </button>

        </div>

    <!-- MODAL PDF VIEWER (UI Dark Mode Premium) -->
    <template x-teleport="body">
        <div x-show="showModal" class="fixed inset-0 z-[999] flex items-center justify-center p-4 sm:p-6" style="display: none;" @keydown.escape.window="showModal = false">
            
            <!-- Backdrop Overlay Gelap -->
            <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm" @click="showModal = false"></div>
            
            <!-- Container Modal -->
            <div x-show="showModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-8"
                 class="relative bg-[#1e2329] rounded-2xl shadow-2xl w-full max-w-5xl h-[85vh] flex flex-col overflow-hidden border border-slate-700 z-10">
                
                <!-- HEADER MODAL (Dark Mode UI) -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 border-b border-slate-700/50 bg-[#161b22] gap-4">
                    
                    <!-- Kiri: Judul & Info File -->
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-red-500/20 text-red-400 flex items-center justify-center shrink-0 border border-red-500/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-100 text-sm md:text-base leading-tight" x-text="pdfTitle"></h4>
                            <p class="text-xs text-slate-400 mt-0.5" x-text="fileInfo"></p>
                        </div>
                    </div>
                    
                    <!-- Kanan: Tombol Aksi -->
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <!-- Tombol Copy Link -->
                        <button type="button" @click="copyLink()" title="Salin Tautan Dokumen" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-3.5 py-2 rounded-xl bg-slate-800 text-slate-200 hover:bg-slate-700 hover:text-white transition-colors text-xs font-semibold border border-slate-600/70">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            <span>Salin Tautan</span>
                        </button>
                        
                        <!-- Tombol Download -->
                        <a :href="pdfUrl" target="_blank" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 text-white hover:bg-emerald-500 transition-colors text-xs font-bold shadow-lg shadow-emerald-900/30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Download</span>
                        </a>
                        
                        <!-- Tombol Close -->
                        <button type="button" @click="showModal = false" class="w-9 h-9 ml-1 flex items-center justify-center rounded-xl bg-slate-800 text-slate-400 hover:bg-red-500/20 hover:text-red-400 transition-colors border border-slate-700/60" title="Tutup Modal">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
                
                <!-- BODY MODAL (IFRAME PDF RESPONSIVE) -->
                <div class="flex-grow bg-[#525659] w-full relative min-h-[400px]">
                    <iframe :src="showModal ? pdfUrl : ''" class="absolute inset-0 w-full h-full border-0" allow="autoplay"></iframe>
                </div>
                
            </div>
        </div>
    </template>
</div>`
                            }
                        }
                    ];
                } else if (type === 'regulasi' || type === 'regulasi-dokumen' || type === 'regulasi_dokumen' || type === 'dokumen-regulasi') {
                    this.blocks = [
                        {
                            id: Date.now() + 1,
                            type: 'html_custom',
                            settings: { bg: 'transparent', padding: 'none', align: '', wrapper_class: '' },
                            content: {
                                html: `<!-- Direktori Regulasi & Dokumen Pendidikan (Live Search, Pagination 5 item, Light Glassmorphism, & Dark PDF Viewer) -->
<div x-data="{
    search: '',
    selectedCategory: 'all',
    currentPage: 1,
    perPage: 5,
    showModal: false,
    pdfTitle: '',
    pdfUrl: '',
    fileInfo: '',
    copied: false,
    openModal(title, url, info) {
        this.pdfTitle = title;
        this.pdfUrl = url;
        this.fileInfo = info;
        this.showModal = true;
    },
    copyLink() {
        if (this.pdfUrl) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(this.pdfUrl).then(() => {
                    this.copied = true;
                    setTimeout(() => { this.copied = false; }, 2500);
                });
            } else {
                const ta = document.createElement('textarea');
                ta.value = this.pdfUrl;
                document.body.appendChild(ta);
                ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
                this.copied = true;
                setTimeout(() => { this.copied = false; }, 2500);
            }
        }
    },
    docs: [
        { id: 1, title: 'Permendikdasmen Nomor 1 Tahun 2024 tentang OTK Kementerian Pendidikan Dasar dan Menengah', nomor: 'Permendikdasmen No. 1 / 2024', category: 'Permendikdasmen', year: '2024', size: '2.4 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_1_2024/preview', desc: 'Peraturan Organisasi dan Tata Kerja Kementerian Pendidikan Dasar dan Menengah Republik Indonesia.' },
        { id: 2, title: 'Permendikdasmen Nomor 2 Tahun 2025 tentang Pedoman Pengawasan Penggunaan Bahasa Indonesia', nomor: 'Permendikdasmen No. 2 / 2025', category: 'Permendikdasmen', year: '2025', size: '1.8 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_2_2025/preview', desc: 'Pedoman pengawasan serta pembinaan penggunaan bahasa Indonesia di lingkungan satuan pendidikan.' },
        { id: 3, title: 'Permendikdasmen Nomor 3 Tahun 2025 tentang Sistem Penerimaan Murid Baru', nomor: 'Permendikdasmen No. 3 / 2025', category: 'Permendikdasmen', year: '2025', size: '2.1 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_3_2025/preview', desc: 'Juknis dan regulasi resmi penerimaan murid baru (SPMB) yang akuntabel, objektif, dan berkeadilan.' },
        { id: 4, title: 'Permendikdasmen Nomor 4 Tahun 2025 tentang Juknis TP Guru ASN Daerah', nomor: 'Permendikdasmen No. 4 / 2025', category: 'Permendikdasmen', year: '2025', size: '3.2 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_4_2025/preview', desc: 'Petunjuk teknis penyaluran tunjangan profesi bagi guru aparatur sipil negara di daerah.' },
        { id: 5, title: 'Permendikdasmen Nomor 5 Tahun 2025 tentang OTK BGTK', nomor: 'Permendikdasmen No. 5 / 2025', category: 'Permendikdasmen', year: '2025', size: '1.9 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_5_2025/preview', desc: 'Organisasi dan tata kerja Balai Guru dan Tenaga Kependidikan pada tingkat pusat dan wilayah.' },
        { id: 6, title: 'Permendikdasmen Nomor 6 Tahun 2025 tentang Pengembangan Kompetensi ASN', nomor: 'Permendikdasmen No. 6 / 2025', category: 'Permendikdasmen', year: '2025', size: '2.5 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_6_2025/preview', desc: 'Kebijakan program berkelanjutan pengembangan kompetensi aparatur sipil negara di sektor pendidikan.' },
        { id: 7, title: 'Permendikdasmen Nomor 7 Tahun 2025 tentang Penugasan Guru Sebagai Kepala Sekolah', nomor: 'Permendikdasmen No. 7 / 2025', category: 'Permendikdasmen', year: '2025', size: '2.0 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_7_2025/preview', desc: 'Standar persyaratan, seleksi, serta mekanisme penugasan guru sebagai kepala sekolah di satuan pendidikan.' },
        { id: 8, title: 'Permendikdasmen Nomor 8 Tahun 2025 tentang Juknis BOSP 2025', nomor: 'Permendikdasmen No. 8 / 2025', category: 'Permendikdasmen', year: '2025', size: '4.1 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_8_2025/preview', desc: 'Petunjuk teknis pengelolaan dan pertanggungjawaban Bantuan Operasional Satuan Pendidikan (BOSP) tahun 2025.' },
        { id: 9, title: 'Permendikdasmen Nomor 9 Tahun 2025 tentang Tes Kemampuan Akademik', nomor: 'Permendikdasmen No. 9 / 2025', category: 'Permendikdasmen', year: '2025', size: '1.7 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_9_2025/preview', desc: 'Pelaksanaan dan standar evaluasi tes kemampuan akademik bagi peserta didik pendidikan dasar dan menengah.' },
        { id: 10, title: 'Permendikdasmen Nomor 10 Tahun 2025 tentang SKL PAUD Dikdasmen', nomor: 'Permendikdasmen No. 10 / 2025', category: 'Permendikdasmen', year: '2025', size: '2.8 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_10_2025/preview', desc: 'Standar Kompetensi Lulusan (SKL) pada Pendidikan Anak Usia Dini, Pendidikan Dasar, dan Pendidikan Menengah.' },
        { id: 11, title: 'Permendikdasmen Nomor 11 Tahun 2025 tentang Pemenuhan Beban Kerja Guru', nomor: 'Permendikdasmen No. 11 / 2025', category: 'Permendikdasmen', year: '2025', size: '2.2 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_11_2025/preview', desc: 'Ketentuan dan rincian pemenuhan beban kerja guru, kepala sekolah, dan pengawas sekolah.' },
        { id: 12, title: 'Permendikdasmen Nomor 12 Tahun 2025 tentang Standar Isi PAUD Dikdasmen', nomor: 'Permendikdasmen No. 12 / 2025', category: 'Permendikdasmen', year: '2025', size: '3.5 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_12_2025/preview', desc: 'Standar isi ruang lingkup materi dan tingkat kompetensi untuk jenjang PAUD, SD, SMP, dan SMA/SMK.' },
        { id: 13, title: 'Permendikdasmen Nomor 13 Tahun 2025 tentang Kurikulum PAUD Dikdasmen', nomor: 'Permendikdasmen No. 13 / 2025', category: 'Permendikdasmen', year: '2025', size: '4.8 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_13_2025/preview', desc: 'Kerangka dasar dan struktur kurikulum nasional untuk satuan pendidikan anak usia dini hingga menengah.' },
        { id: 14, title: 'Permendikdasmen Nomor 14 Tahun 2025 tentang Pelaksanaan Pemberian Tukin Pegawai Kemendikdasmen', nomor: 'Permendikdasmen No. 14 / 2025', category: 'Permendikdasmen', year: '2025', size: '2.6 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_14_2025/preview', desc: 'Mekanisme perhitungan dan penyaluran tunjangan kinerja aparatur sipil negara di lingkungan kementerian.' },
        { id: 15, title: 'Pedoman Pengelolaan Organisasi, Administrasi dan Personil', nomor: 'Pedoman Organisasi', category: 'Pedoman', year: '2025', size: '3.1 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PEDOMAN_ORG/preview', desc: 'Buku panduan tata kelola administrasi kepegawaian, persuratan, dan kelembagaan unit pelaksana teknis.' },
        { id: 16, title: 'Perpres Nomor 3 Tahun 2026 tentang Kebijakan Strategis Pendidikan Nasional', nomor: 'Perpres No. 3 / 2026', category: 'Perpres', year: '2026', size: '2.9 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERPRES_3_2026/preview', desc: 'Peraturan Presiden mengenai arah kebijakan prioritas pembangunan pendidikan nasional jangka menengah.' },
        { id: 17, title: 'SE Dirjen PAUD Dasmen Nomor 0301 Tahun 2026 tentang SPMB', nomor: 'SE Dirjen No. 0301 / 2026', category: 'Surat Edaran', year: '2026', size: '1.2 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_SE_DIRJEN_0301_2026/preview', desc: 'Surat Edaran Direktur Jenderal terkait kesiapan daerah dan satuan pendidikan dalam pelaksanaan SPMB 2026.' },
        { id: 18, title: 'SE KPK tentang Pencegahan Korupsi pada SPMB Tahun 2026', nomor: 'SE KPK SPMB / 2026', category: 'Surat Edaran', year: '2026', size: '1.5 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_SE_KPK_SPMB_2026/preview', desc: 'Himbauan integritas pencegahan suap, gratifikasi, dan pungutan liar dalam proses penerimaan peserta didik.' },
        { id: 19, title: 'Permendikdasmen Nomor 26 Tahun 2025 tentang Tata Kelola Sistem Penjaminan Mutu', nomor: 'Permendikdasmen No. 26 / 2025', category: 'Permendikdasmen', year: '2025', size: '3.0 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_26_2025/preview', desc: 'Siklus dan tata kelola penjaminan mutu pendidikan internal dan eksternal tingkat daerah dan provinsi.' },
        { id: 20, title: 'Permendikdasmen Nomor 3 Tahun 2025 (JDIH Salinan Resmi)', nomor: 'Salinan JDIH No. 3 / 2025', category: 'Permendikdasmen', year: '2025', size: '2.3 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_3_2025_JDIH/preview', desc: 'Salinan resmi JDIH Peraturan Menteri Pendidikan Dasar dan Menengah Nomor 3 Tahun 2025.' },
        { id: 21, title: 'Salinan Kepmen Nomor 14 Tahun 2026 JDIH', nomor: 'Kepmen No. 14 / 2026', category: 'Kepmen', year: '2026', size: '2.7 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_KEPMEN_14_2026/preview', desc: 'Salinan Keputusan Menteri Pendidikan Dasar dan Menengah terdaftar resmi pada JDIH kementerian.' },
        { id: 22, title: 'Salinan Permendikdasmen Nomor 14 Tahun 2026 CAP', nomor: 'Permendikdasmen No. 14 / 2026 CAP', category: 'Permendikdasmen', year: '2026', size: '3.4 MB', file: 'https://drive.google.com/file/d/CONTOH_ID_PERMEN_14_2026_CAP/preview', desc: 'Salinan naskah asli bertanda tangan dan cap basah resmi kementerian untuk arsip regulasi kepegawaian.' }
    ],
    get filteredDocs() {
        let q = this.search.toLowerCase().trim();
        return this.docs.filter(doc => {
            let matchSearch = !q || 
                doc.title.toLowerCase().includes(q) || 
                doc.nomor.toLowerCase().includes(q) || 
                doc.category.toLowerCase().includes(q) || 
                doc.year.includes(q);
            let matchCat = this.selectedCategory === 'all' || doc.category === this.selectedCategory;
            return matchSearch && matchCat;
        });
    },
    get totalPages() {
        return Math.ceil(this.filteredDocs.length / this.perPage) || 1;
    },
    get paginatedDocs() {
        let start = (this.currentPage - 1) * this.perPage;
        return this.filteredDocs.slice(start, start + this.perPage);
    },
    get startCount() {
        return this.filteredDocs.length === 0 ? 0 : (this.currentPage - 1) * this.perPage + 1;
    },
    get endCount() {
        return Math.min(this.currentPage * this.perPage, this.filteredDocs.length);
    },
    goToPage(page) {
        if (page >= 1 && page <= this.totalPages) {
            this.currentPage = page;
        }
    },
    nextPage() {
        if (this.currentPage < this.totalPages) {
            this.currentPage++;
        }
    },
    prevPage() {
        if (this.currentPage > 1) {
            this.currentPage--;
        }
    }
}" class="w-full space-y-8">

    <!-- HEADER / PENCARIAN REAL-TIME -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pb-6 border-b border-slate-100">
        <div>
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-50 border border-blue-100 text-blue-700 text-xs font-extrabold uppercase tracking-wider mb-2">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Bank Regulasi & Kebijakan
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight">Dokumen Regulasi Pendidikan</h2>
            <p class="text-slate-500 text-sm mt-1">Akses dan telusuri peraturan menteri, keputusan, serta pedoman resmi penjaminan mutu pendidikan.</p>
        </div>

        <!-- Kolom Pencarian Live Search -->
        <div class="w-full md:w-80 relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" x-model="search" @input="currentPage = 1" placeholder="Cari nomor, judul, atau tahun..." 
                   class="w-full pl-10 pr-10 py-2.5 bg-slate-50/80 hover:bg-slate-50 focus:bg-white border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 rounded-2xl text-xs sm:text-sm font-medium text-slate-700 placeholder:text-slate-400 transition-all outline-none">
            <button type="button" x-show="search" @click="search = ''; currentPage = 1" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <!-- FILTER KATEGORI (PILLS) & STATUS INFO -->
    <div class="flex flex-wrap items-center justify-between gap-3 pt-1">
        <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
            <button type="button" @click="selectedCategory = 'all'; currentPage = 1" 
                    :class="selectedCategory === 'all' ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30 font-bold' : 'bg-slate-100 hover:bg-slate-200/80 text-slate-600 font-medium'" 
                    class="px-3.5 py-1.5 rounded-xl text-xs transition-all">Semua Dokumen</button>
            <button type="button" @click="selectedCategory = 'Permendikdasmen'; currentPage = 1" 
                    :class="selectedCategory === 'Permendikdasmen' ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30 font-bold' : 'bg-slate-100 hover:bg-slate-200/80 text-slate-600 font-medium'" 
                    class="px-3.5 py-1.5 rounded-xl text-xs transition-all">Permendikdasmen</button>
            <button type="button" @click="selectedCategory = 'Surat Edaran'; currentPage = 1" 
                    :class="selectedCategory === 'Surat Edaran' ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30 font-bold' : 'bg-slate-100 hover:bg-slate-200/80 text-slate-600 font-medium'" 
                    class="px-3.5 py-1.5 rounded-xl text-xs transition-all">Surat Edaran</button>
            <button type="button" @click="selectedCategory = 'Pedoman'; currentPage = 1" 
                    :class="selectedCategory === 'Pedoman' ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30 font-bold' : 'bg-slate-100 hover:bg-slate-200/80 text-slate-600 font-medium'" 
                    class="px-3.5 py-1.5 rounded-xl text-xs transition-all">Pedoman</button>
            <button type="button" @click="selectedCategory = 'Perpres'; currentPage = 1" 
                    :class="selectedCategory === 'Perpres' ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30 font-bold' : 'bg-slate-100 hover:bg-slate-200/80 text-slate-600 font-medium'" 
                    class="px-3.5 py-1.5 rounded-xl text-xs transition-all">Perpres</button>
            <button type="button" @click="selectedCategory = 'Kepmen'; currentPage = 1" 
                    :class="selectedCategory === 'Kepmen' ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30 font-bold' : 'bg-slate-100 hover:bg-slate-200/80 text-slate-600 font-medium'" 
                    class="px-3.5 py-1.5 rounded-xl text-xs transition-all">Kepmen</button>
        </div>

        <div class="text-xs text-slate-400 font-medium">
            Menampilkan <span class="font-bold text-slate-700" x-text="startCount"></span> - <span class="font-bold text-slate-700" x-text="endCount"></span> dari <span class="font-bold text-blue-600" x-text="filteredDocs.length"></span> regulasi
        </div>
    </div>

    <!-- LIST DOKUMEN (5 ITEM PER HALAMAN) -->
    <div class="space-y-4">
        <template x-for="doc in paginatedDocs" :key="doc.id">
            <div class="group relative bg-white/90 hover:bg-white border border-slate-200/90 hover:border-blue-400 rounded-3xl p-5 sm:p-6 shadow-[0_4px_20px_rgb(0,0,0,0.02)] hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 flex flex-col md:flex-row md:items-center justify-between gap-5">
                
                <!-- Sisi Kiri: Ikon & Teks Informasi -->
                <div class="flex items-start gap-4 sm:gap-5 flex-1 min-w-0">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-red-50 text-red-500 border border-red-100 flex items-center justify-center shrink-0 group-hover:scale-105 group-hover:bg-red-500 group-hover:text-white transition-all duration-300 shadow-xs">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    
                    <div class="space-y-1.5 flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-[10px] sm:text-[11px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-100" x-text="doc.nomor"></span>
                            <span class="text-[10px] sm:text-[11px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600" x-text="'Tahun ' + doc.year"></span>
                            <span class="text-[10px] sm:text-[11px] text-slate-400 font-medium flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                <span x-text="doc.size"></span>
                            </span>
                        </div>
                        
                        <h3 class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-blue-700 transition-colors leading-snug" x-text="doc.title"></h3>
                        
                        <p class="text-xs sm:text-sm text-slate-500 line-clamp-2 leading-relaxed" x-text="doc.desc"></p>
                    </div>
                </div>

                <!-- Sisi Kanan: Tombol Aksi -->
                <div class="flex items-center gap-2.5 sm:gap-3 shrink-0 pt-3 md:pt-0 border-t md:border-t-0 border-slate-100">
                    <button type="button" @click="openModal(doc.title, doc.file, doc.nomor + ' • ' + doc.size)" 
                            class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-2xl bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white font-bold text-xs transition-all duration-200 border border-blue-100 hover:border-blue-600 shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>Lihat PDF</span>
                    </button>
                    
                    <a :href="doc.file" target="_blank" 
                       class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-all duration-200 border border-slate-200/80 shadow-xs" title="Unduh Dokumen">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span class="md:hidden lg:inline">Unduh</span>
                    </a>
                </div>
            </div>
        </template>

        <!-- Empty State (Ketika tidak ditemukan) -->
        <div x-show="filteredDocs.length === 0" class="text-center py-16 px-4 bg-slate-50/60 rounded-3xl border border-dashed border-slate-200">
            <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-3">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h4 class="font-bold text-slate-700 text-base">Tidak ada regulasi yang ditemukan</h4>
            <p class="text-slate-400 text-xs sm:text-sm mt-1 max-w-sm mx-auto">Kata kunci "<span class="font-semibold text-slate-600" x-text="search"></span>" tidak cocok dengan regulasi manapun.</p>
            <button type="button" @click="search = ''; selectedCategory = 'all'; currentPage = 1" class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition-all shadow-sm shadow-blue-500/25">
                Reset Pencarian
            </button>
        </div>
    </div>

    <!-- PAGINATION CONTROL (5 Item Per Halaman) -->
    <div x-show="totalPages > 1" class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="text-xs text-slate-400 font-medium">
            Halaman <span class="font-bold text-slate-700" x-text="currentPage"></span> dari <span class="font-bold text-slate-700" x-text="totalPages"></span>
        </div>
        
        <div class="flex items-center gap-1.5">
            <button type="button" @click="prevPage()" :disabled="currentPage === 1" 
                    :class="currentPage === 1 ? 'opacity-40 cursor-not-allowed text-slate-300' : 'hover:bg-slate-100 text-slate-600 hover:text-slate-900'" 
                    class="p-2 rounded-xl border border-slate-200 bg-white transition-all flex items-center justify-center w-9 h-9" title="Halaman Sebelumnya">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            
            <template x-for="page in totalPages" :key="page">
                <button type="button" @click="goToPage(page)" 
                        :class="currentPage === page ? 'bg-blue-600 text-white font-extrabold shadow-md shadow-blue-500/30 border-blue-600' : 'bg-white hover:bg-slate-50 text-slate-600 font-bold border-slate-200'" 
                        class="w-9 h-9 rounded-xl border text-xs transition-all flex items-center justify-center" 
                        x-text="page"></button>
            </template>
            
            <button type="button" @click="nextPage()" :disabled="currentPage === totalPages" 
                    :class="currentPage === totalPages ? 'opacity-40 cursor-not-allowed text-slate-300' : 'hover:bg-slate-100 text-slate-600 hover:text-slate-900'" 
                    class="p-2 rounded-xl border border-slate-200 bg-white transition-all flex items-center justify-center w-9 h-9" title="Halaman Berikutnya">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </div>

    <!-- MODAL PDF VIEWER (UI Dark Mode Premium) -->
    <template x-teleport="body">
        <div x-show="showModal" class="fixed inset-0 z-[999] flex items-center justify-center p-4 sm:p-6" style="display: none;" @keydown.escape.window="showModal = false">
            <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm" @click="showModal = false"></div>
            
            <div x-show="showModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-8"
                 class="relative bg-[#1e2329] rounded-2xl shadow-2xl w-full max-w-5xl h-[85vh] flex flex-col overflow-hidden border border-slate-700 z-10">
                
                <!-- HEADER MODAL (Dark Mode UI) -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 border-b border-slate-700/50 bg-[#161b22] gap-4">
                    <div class="flex items-center gap-3.5 min-w-0 flex-1">
                        <div class="w-10 h-10 rounded-xl bg-red-500/20 text-red-400 flex items-center justify-center shrink-0 border border-red-500/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h4 class="font-bold text-slate-100 text-sm md:text-base leading-tight truncate" x-text="pdfTitle"></h4>
                            <p class="text-xs text-slate-400 mt-0.5" x-text="fileInfo"></p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2 w-full sm:w-auto shrink-0">
                        <button type="button" @click="copyLink()" title="Salin Tautan Dokumen" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-3.5 py-2 rounded-xl bg-slate-800 text-slate-200 hover:bg-slate-700 hover:text-white transition-colors text-xs font-semibold border border-slate-600/70">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            <span x-text="copied ? 'Tersalin!' : 'Salin Tautan'">Salin Tautan</span>
                        </button>
                        
                        <a :href="pdfUrl" target="_blank" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 text-white hover:bg-emerald-500 transition-colors text-xs font-bold shadow-lg shadow-emerald-900/30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Download</span>
                        </a>
                        
                        <button type="button" @click="showModal = false" class="w-9 h-9 ml-1 flex items-center justify-center rounded-xl bg-slate-800 text-slate-400 hover:bg-red-500/20 hover:text-red-400 transition-colors border border-slate-700/60" title="Tutup Modal">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
                
                <!-- BODY MODAL (IFRAME PDF RESPONSIVE) -->
                <div class="flex-grow bg-[#525659] w-full relative min-h-[400px]">
                    <iframe :src="showModal ? pdfUrl : ''" class="absolute inset-0 w-full h-full border-0" allow="autoplay"></iframe>
                </div>
                
            </div>
        </div>
    </template>
</div>`
                            }
                        }
                    ];
                } else if (type === 'tim-kerja' || type === 'tim_kerja') {
                    this.blocks = [
                        {
                            id: Date.now() + 1,
                            type: 'text',
                            settings: { bg: 'transparent', padding: 'none', align: 'center', wrapper_class: '' },
                            content: {
                                html: '<div class="text-center max-w-3xl mx-auto my-10">\n    <h1 class="text-3xl font-extrabold text-slate-900 mb-3" contenteditable="true">Struktur Tim Kerja BPMP Sulawesi Tenggara</h1>\n    <p class="text-slate-600 text-base sm:text-lg" contenteditable="true">Susunan Tim Kerja Balai Penjaminan Mutu Pendidikan Provinsi Sulawesi Tenggara Tahun 2026 berdasarkan bidang layanan pokok.</p>\n</div>'
                            }
                        },
                        {
                            id: Date.now() + 2,
                            type: 'image_text',
                            settings: { bg: 'transparent', padding: 'none', align: 'left', image_position: 'bottom', wrapper_class: 'bg-white rounded-3xl p-6 md:p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] mb-8' },
                            content: {
                                title: '<div class="flex items-center gap-4"><div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center font-extrabold text-2xl border border-amber-100">P</div><div><h2 class="text-2xl font-bold text-slate-800 m-0">Tim Kerja PAUD</h2><p class="text-amber-600 font-semibold m-0 text-sm mt-1">Ketua: Rahmawati, S.Si., M.Si.</p></div></div>',
                                description: '<p class="text-slate-600">Fasilitasi penjaminan dan peningkatan mutu pendidikan anak usia dini, implementasi transisi PAUD ke SD yang menyenangkan, dan kemitraan Bunda PAUD se-Sulawesi Tenggara.</p>',
                                image: 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=900&fit=crop',
                                button_text: 'Lihat Detail Anggota',
                                button_url: '#'
                            }
                        },
                        {
                            id: Date.now() + 3,
                            type: 'image_text',
                            settings: { bg: 'transparent', padding: 'none', align: 'left', image_position: 'bottom', wrapper_class: 'bg-white rounded-3xl p-6 md:p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] mb-8' },
                            content: {
                                title: '<div class="flex items-center gap-4"><div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-extrabold text-2xl border border-blue-100">S</div><div><h2 class="text-2xl font-bold text-slate-800 m-0">Tim Kerja SD</h2><p class="text-blue-600 font-semibold m-0 text-sm mt-1">Ketua: La Siara, S.Pd., M.Pd.</p></div></div>',
                                description: '<p class="text-slate-600">Pendampingan pelaksanaan Program Sekolah Penggerak dan Implementasi Kurikulum Merdeka jenjang Sekolah Dasar di 17 Kabupaten/Kota se-Sultra.</p>',
                                image: 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=900&fit=crop',
                                button_text: 'Lihat Detail Anggota',
                                button_url: '#'
                            }
                        },
                        {
                            id: Date.now() + 4,
                            type: 'image_text',
                            settings: { bg: 'transparent', padding: 'none', align: 'left', image_position: 'bottom', wrapper_class: 'bg-white rounded-3xl p-6 md:p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] mb-8' },
                            content: {
                                title: '<div class="flex items-center gap-4"><div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-extrabold text-2xl border border-emerald-100">M</div><div><h2 class="text-2xl font-bold text-slate-800 m-0">Tim Kerja SMP</h2><p class="text-emerald-600 font-semibold m-0 text-sm mt-1">Ketua: Wahyu Falah, S.Si., M.Si.</p></div></div>',
                                description: '<p class="text-slate-600">Penguatan literasi dan numerasi serta pemanfaatan Platform Merdeka Mengajar (PMM) bagi guru dan tenaga kependidikan jenjang SMP.</p>',
                                image: 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=900&fit=crop',
                                button_text: 'Lihat Detail Anggota',
                                button_url: '#'
                            }
                        },
                        {
                            id: Date.now() + 5,
                            type: 'image_text',
                            settings: { bg: 'transparent', padding: 'none', align: 'left', image_position: 'bottom', wrapper_class: 'bg-white rounded-3xl p-6 md:p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] mb-8' },
                            content: {
                                title: '<div class="flex items-center gap-4"><div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-extrabold text-2xl border border-indigo-100">A</div><div><h2 class="text-2xl font-bold text-slate-800 m-0">Tim Kerja SMA</h2><p class="text-indigo-600 font-semibold m-0 text-sm mt-1">Ketua: Zuumi Kudus, S.Pd., M.Pd.</p></div></div>',
                                description: '<p class="text-slate-600">Fasilitasi penjaminan mutu jenjang SMA, pembinaan iklim keamanan sekolah, dan pendampingan Perencanaan Berbasis Data (PBD).</p>',
                                image: 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=900&fit=crop',
                                button_text: 'Lihat Detail Anggota',
                                button_url: '#'
                            }
                        }
                    ];
                } else if (type === 'profil-pegawai' || type === 'pegawai-scroll') {
                    this.blocks = [
                        {
                            id: Date.now() + 1,
                            type: 'gallery_slider',
                            settings: { bg: 'transparent', padding: 'medium', align: 'center', wrapper_class: '' },
                            content: {
                                heading: 'Galeri & Direktori Pegawai',
                                subheading: 'Pegawai Balai Penjaminan Mutu Pendidikan Provinsi Sulawesi Tenggara',
                                items: [
                                    { name: 'Dr. Ahmad, M.Pd.', role: 'Kepala BPMP Sultra', image: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=300&h=300&fit=crop' },
                                    { name: 'La Ode Rudi, S.Pd.', role: 'Kasubbag Umum', image: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=300&fit=crop' },
                                    { name: 'Siti Aminah, M.Si.', role: 'Widyaprada Madya', image: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=300&h=300&fit=crop' },
                                    { name: 'Bambang Irawan, S.Kom.', role: 'Pranata Komputer', image: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&h=300&fit=crop' },
                                    { name: 'Nurul Hidayah, M.Pd.', role: 'Widyaprada Muda', image: 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=300&h=300&fit=crop' },
                                    { name: 'Fajar Pratama, S.Si.', role: 'Pengembang Teknologi', image: 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=300&h=300&fit=crop' }
                                ]
                            }
                        },
                        {
                            id: Date.now() + 2,
                            type: 'image',
                            settings: { bg: 'transparent', padding: 'medium', align: 'center', wrapper_class: '' },
                            content: {
                                image: 'https://images.unsplash.com/photo-1497215728101-856f4ea42174?w=1200&h=600&fit=crop',
                                caption: 'Infografis Distribusi Jabatan Fungsional dan Tata Hubungan Kerja BPMP Sultra',
                                alt: 'Infografis Kepegawaian BPMP Sultra',
                                width: 'max-w-5xl',
                                rounded: 'rounded-3xl',
                                shadow: 'shadow-xl',
                                link: ''
                            }
                        }
                    ];
                } else if (type === 'detail-kepegawaian' || type === 'profil-detail') {
                    this.blocks = [
                        {
                            id: Date.now() + 1,
                            type: 'profile_table',
                            settings: { bg: 'transparent', padding: 'none', align: 'left', wrapper_class: '' },
                            content: {
                                name: 'Dr. Hendra Wijaya, M.Pd.',
                                role: 'Kepala Balai Penjaminan Mutu Pendidikan Provinsi Sulawesi Tenggara',
                                image: 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=600&h=500&fit=crop',
                                bio: 'Bertanggung jawab dalam memimpin pelaksanaan penjaminan dan peningkatan mutu pendidikan anak usia dini, pendidikan dasar, pendidikan menengah, dan pendidikan masyarakat di wilayah Provinsi Sulawesi Tenggara.',
                                details: [
                                    { label: 'NIP', value: '19750815 200003 1 002' },
                                    { label: 'Pangkat / Golongan', value: 'Pembina Utama Muda / IV c' },
                                    { label: 'Jabatan Terakhir', value: 'Kepala Balai' },
                                    { label: 'Unit Kerja', value: 'BPMP Provinsi Sulawesi Tenggara' },
                                    { label: 'Pendidikan Terakhir', value: 'S3 Manajemen Pendidikan' },
                                    { label: 'Email Kedinasan', value: 'kepala@bpmp-sultra.kemdikbud.go.id' }
                                ],
                                button_text: 'Unduh Biodata Lengkap',
                                button_url: '#'
                            }
                        },
                        {
                            id: Date.now() + 2,
                            type: 'cards',
                            settings: { bg: 'transparent', padding: 'none', align: 'left', wrapper_class: '' },
                            content: {
                                heading: 'Publikasi Terkait &amp; Rekan Kerja',
                                columns: 3,
                                items: [
                                    {
                                        title: 'Kasubbag Umum',
                                        description: 'Membidangi urusan perencanaan, keuangan, kepegawaian, ketatausahaan, dan rumah tangga.',
                                        image: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&h=300&fit=crop',
                                        button_text: 'Lihat Profil',
                                        button_url: '#'
                                    },
                                    {
                                        title: 'Ketua Tim Kerja PAUD',
                                        description: 'Fasilitasi penjaminan mutu dan pendampingan satuan pendidikan jenjang PAUD.',
                                        image: 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400&h=300&fit=crop',
                                        button_text: 'Lihat Profil',
                                        button_url: '#'
                                    },
                                    {
                                        title: 'Ketua Tim Kerja SD',
                                        description: 'Fasilitasi penjaminan mutu dan pendampingan program prioritas jenjang SD.',
                                        image: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=300&fit=crop',
                                        button_text: 'Lihat Profil',
                                        button_url: '#'
                                    }
                                ]
                            }
                        }
                    ];
                } else if (type === 'visi-misi' || type === 'visi_misi') {
                    this.blocks = [
                        {
                            id: Date.now() + 1,
                            type: 'image_text',
                            settings: { bg: 'transparent', padding: 'none', align: 'left', image_position: 'right', wrapper_class: '' },
                            content: {
                                title: '<div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 text-blue-600 font-bold text-sm uppercase tracking-widest border border-blue-100 mb-3"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>Visi Lembaga</div><h2 class="text-3xl md:text-4xl font-extrabold text-slate-800 leading-tight">Terwujudnya Penjaminan dan Peningkatan Mutu Pendidikan</h2>',
                                description: '<p class="text-lg text-slate-600 leading-relaxed border-l-4 border-blue-500 pl-4">Pendidikan Anak Usia Dini, Pendidikan Dasar, Pendidikan Menengah, dan Pendidikan Masyarakat di Provinsi Sulawesi Tenggara dengan semangat <strong>Kolaborasi</strong>.</p>',
                                image: 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=800&auto=format&fit=crop&q=80',
                                button_text: '',
                                button_url: ''
                            }
                        },
                        {
                            id: Date.now() + 2,
                            type: 'image_text',
                            settings: { bg: 'transparent', padding: 'none', align: 'left', image_position: 'left', wrapper_class: '' },
                            content: {
                                title: '<div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-50 text-amber-600 font-bold text-sm uppercase tracking-widest border border-amber-100 mb-3"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>Misi Utama BPMP</div><h2 class="text-3xl font-extrabold text-slate-800 leading-tight">Misi BPMP Sulawesi Tenggara</h2>',
                                description: '<ul class="space-y-3 text-slate-700 text-sm mt-4">\n    <li class="flex items-start gap-3"><span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center shrink-0 text-xs mt-0.5">1</span><span>Melaksanakan pemetaan mutu PAUD, Pendidikan Dasar, Pendidikan Menengah, dan Pendidikan Masyarakat.</span></li>\n    <li class="flex items-start gap-3"><span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center shrink-0 text-xs mt-0.5">2</span><span>Melaksanakan pengembangan model penjaminan dan peningkatan mutu pendidikan.</span></li>\n    <li class="flex items-start gap-3"><span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center shrink-0 text-xs mt-0.5">3</span><span>Melaksanakan supervisi dan fasilitasi penjaminan mutu pendidikan di kabupaten/kota se-Sultra.</span></li>\n    <li class="flex items-start gap-3"><span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center shrink-0 text-xs mt-0.5">4</span><span>Melaksanakan kemitraan dan advokasi peningkatan mutu pendidikan daerah.</span></li>\n    <li class="flex items-start gap-3"><span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center shrink-0 text-xs mt-0.5">5</span><span>Pelaksanaan urusan administrasi, tata kelola, dan layanan publik.</span></li>\n</ul>',
                                image: 'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=800&auto=format&fit=crop&q=80',
                                button_text: '',
                                button_url: ''
                            }
                        }
                    ];
                } else if (type === 'landing') {
                    this.blocks = [
                        { id: 1, type: 'hero', settings: {bg: 'white', padding: 'large', align:'center'}, content: {title: 'Selamat Datang di BPMP Sulawesi Tenggara', description: 'Mewujudkan penjaminan dan peningkatan mutu pendidikan berkualitas dan terintegrasi.', button_text: 'Jelajahi Layanan', button_url: '#'} },
                        { id: 2, type: 'image_text', settings: {bg: 'transparent', padding: 'none', align:'left', image_position: 'left'}, content: {title: 'Tentang Lembaga Kami', description: '<p>Balai Penjaminan Mutu Pendidikan Provinsi Sulawesi Tenggara merupakan Unit Pelaksana Teknis Kementerian Pendidikan Dasar dan Menengah.</p>', image: 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&fit=crop', button_text: 'Selengkapnya', button_url: '#'} },
                        { id: 3, type: 'cards', settings: {bg: 'transparent', padding: 'none', align:'left'}, content: {heading: 'Layanan Utama', columns: 3, items: [{title:'Penjaminan Mutu', description:'Pemetaan dan advokasi mutu sekolah', image: 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=400&fit=crop'}, {title:'Konsultasi & ULT', description:'Unit Layanan Terpadu digital', image: 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=400&fit=crop'}, {title:'Kemitraan Daerah', description:'Kolaborasi dengan pemda 17 kab/kota', image: 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=400&fit=crop'}]} }
                    ];
                } else if (type === 'about') {
                    this.blocks = [
                        { id: 1, type: 'hero', settings: {bg: 'white', padding: 'large', align:'center'}, content: {title: 'Tentang BPMP Sulawesi Tenggara', description: 'Visi dan Misi kami dalam melayani kemajuan mutu pendidikan.', button_text: '', button_url: ''} },
                        { id: 2, type: 'text', settings: {bg: 'transparent', padding: 'none', align:'left'}, content: {html: '<div class="w-full max-w-5xl mx-auto my-8 prose prose-blue prose-lg"><h2>Visi</h2><p>Mewujudkan pelayanan penjaminan mutu pendidikan yang berkualitas...</p><h2>Misi</h2><p>Meningkatkan akses dan efektivitas pembinaan pendidikan...</p></div>'} }
                    ];
                }
                
                this.syncState();
                this.updatePreview(true);
                this.initSortable();
            },

            async saveBuilder() {
                this.isSaving = true;
                this.syncState();
                
                try {
                    const payloadData = document.getElementById('builder_data_input')?.value || JSON.stringify(this.blocks);
                    const response = await fetch('{{ route('admin.pages.builder.save', $page->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            builder_data: payloadData,
                            editor_mode: 'visual'
                        })
                    });
                    
                    if (response.ok) {
                        this.showToast = true;
                        setTimeout(() => this.showToast = false, 3000);
                    } else {
                        alert('Gagal menyimpan halaman.');
                    }
                } catch (e) {
                    alert('Terjadi kesalahan koneksi.');
                } finally {
                    this.isSaving = false;
                }
            },

            updatePreview(force = false) {
                if (this.isInlineEditing && !force) return;
                const container = document.getElementById('preview-container');
                if (container) {
                    container.innerHTML = this.compilePreviewHtml();
                    this.$nextTick(() => {
                        if (window.Alpine && typeof window.Alpine.initTree === 'function') {
                            window.Alpine.initTree(container);
                        }
                    });
                }
            },

            compileTextHelper(text, settings, defaultClasses, defaultTag, blockId, field, itemIdx) {
                if (!text || text.trim() === '') return '';
                settings = settings || {};
                const tag = settings.tag || defaultTag;
                
                let classes = [defaultClasses, 'builder-editable', '!break-words', '!break-all'];
                if (settings.size) classes.push(settings.size);
                if (settings.weight) classes.push(settings.weight);
                if (settings.align) classes.push(settings.align);
                if (settings.line_height) classes.push(settings.line_height);
                if (settings.letter_spacing) classes.push(settings.letter_spacing);
                if (settings.italic) classes.push('italic');
                if (settings.underline) classes.push('underline');
                if (settings.mt) classes.push(settings.mt);
                if (settings.mb) classes.push(settings.mb);
                
                let style = '';
                if (settings.color) style = ` style="color: ${settings.color}"`;

                let classStr = classes.filter(Boolean).join(' ').trim();
                let itemAttr = itemIdx !== undefined && itemIdx !== null ? ` data-item-idx="${itemIdx}"` : '';
                
                let html = `<${tag} class="${classStr}"${style} contenteditable="true" data-block-id="${blockId}" data-field="${field}"${itemAttr} spellcheck="false">${text}</${tag}>`;
                if (settings.link) {
                    html = `<a href="${settings.link}" class="hover:opacity-80 transition-opacity">${html}</a>`;
                }
                return html;
            },

            compilePreviewHtml() {
                let html = '<style>@keyframes marquee { 0% { transform: translateX(0%); } 100% { transform: translateX(-50%); } } .animate-marquee { display: flex; width: max-content; animation: marquee 30s linear infinite; } .animate-marquee:hover { animation-play-state: paused; }</style>';
                
                if (this.blocks.length === 0) {
                    return html + '<div class="p-16 text-center text-slate-400 text-sm">Halaman masih kosong. Tambahkan blok komponen atau pilih template untuk memulai.</div>';
                }

                this.blocks.forEach((block, bIdx) => {
                    let bg = block.settings.bg === 'white' ? 'bg-white' : (block.settings.bg === 'gray' ? 'bg-gray-50' : (block.settings.bg === 'blue' ? 'bg-blue-50' : 'bg-transparent'));
                    let py = block.settings.padding === 'none' ? 'py-0' : (block.settings.padding === 'small' ? 'py-8' : (block.settings.padding === 'large' ? 'py-24' : 'py-16'));
                    let align = 'text-' + (block.settings.align || 'left');
                    let blockInnerHtml = '';
                    
                    if (block.type === 'hero') {
                        let titleColor = block.content.bg_image ? 'text-white' : 'text-slate-900';
                        let descColor = block.content.bg_image ? 'text-slate-200' : 'text-slate-600';

                        let compiledTitle = this.compileTextHelper(block.content.title, block.content.title_settings, `text-4xl md:text-5xl lg:text-6xl font-extrabold ${titleColor} leading-tight`, 'h1', block.id, 'title');
                        let compiledDesc = this.compileTextHelper(block.content.description, block.content.description_settings, `text-lg ${descColor}`, 'p', block.id, 'description');
                        
                        let btnHtml = block.content.button_text ? `<div class="pt-4"><a href="${block.content.button_url}" class="inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-full transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5"><span class="builder-editable" contenteditable="true" data-block-id="${block.id}" data-field="button_text" spellcheck="false">${block.content.button_text}</span></a></div>` : '';

                        if (block.content.bg_image) {
                            blockInnerHtml = `<div class="relative rounded-3xl overflow-hidden py-16 md:py-24 px-6 md:px-12 my-6 text-center shadow-xl">
                                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('${block.content.bg_image}');"></div>
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-900/80 via-slate-900/70 to-indigo-900/80 backdrop-blur-[2px]"></div>
                                <div class="relative z-10 max-w-4xl mx-auto space-y-6">
                                    ${compiledTitle}
                                    ${compiledDesc}
                                    ${btnHtml}
                                </div>
                            </div>`;
                        } else {
                            blockInnerHtml = `<div class="max-w-4xl mx-auto text-center space-y-6">
                                ${compiledTitle}
                                ${compiledDesc}
                                ${btnHtml}
                            </div>`;
                        }
                    } else if (block.type === 'text' || block.type === 'html' || block.type === 'html_custom') {
                        let rawContent = '';
                        if (typeof block.content === 'string') {
                            rawContent = block.content;
                        } else if (block.content && typeof block.content === 'object') {
                            rawContent = block.content.html || '';
                        } else if (block.html_output) {
                            rawContent = block.html_output;
                        } else if (block.html_content) {
                            rawContent = block.html_content;
                        }

                        // Jika HTML berupa full document dengan body, ekstrak isi body-nya di frontend juga
                        if (typeof rawContent === 'string' && /<body[^>]*>/i.test(rawContent)) {
                            let match = rawContent.match(/<body[^>]*class=["']([^"']*)["'][^>]*>([\s\S]*?)<\/body>/i);
                            if (match) {
                                rawContent = `<div class="${match[1]}">${match[2]}</div>`;
                            } else {
                                let matchNoClass = rawContent.match(/<body[^>]*>([\s\S]*?)<\/body>/i);
                                if (matchNoClass) rawContent = matchNoClass[1];
                            }
                        }

                        if (typeof rawContent === 'string') {
                            rawContent = rawContent.replace(/\\r\\n|\\r|\\n/g, ' ');
                        }

                        // Render Raw HTML utuh sesuai TAHAP 1 tanpa membuang div, grid, card, atau class Tailwind
                        blockInnerHtml = `<div class="block-content w-full" data-block-id="${block.id}">${rawContent}</div>`;
                    } else if (block.type === 'image') {
                        let imgUrl = block.content.image;
                        let altText = block.content.alt || '';
                        let caption = block.content.caption || '';
                        let width = block.content.width || 'max-w-5xl';
                        let rounded = block.content.rounded || 'rounded-3xl';
                        let shadow = block.content.shadow || 'shadow-xl';
                        let alignBlock = block.settings.align || 'center';

                        let widthClass = width === 'w-full' ? 'w-full max-w-6xl' : width;
                        let alignClass = alignBlock === 'left' ? 'mr-auto text-left' : (alignBlock === 'right' ? 'ml-auto text-right' : 'mx-auto text-center');

                        let displaySrc = imgUrl || 'https://via.placeholder.com/1200x600?text=Pilih+atau+Upload+Gambar';
                        let imgTag = `<img src="${displaySrc}" alt="${altText}" class="w-full h-auto ${rounded} ${shadow} object-cover">`;

                        if (block.content.link) {
                            imgTag = `<a href="${block.content.link}" target="_blank" class="block hover:opacity-95 transition-opacity">${imgTag}</a>`;
                        }

                        let captionHtml = caption ? `<figcaption class="mt-3 text-sm text-slate-500 italic text-center builder-editable" contenteditable="true" data-block-id="${block.id}" data-field="caption" spellcheck="false">${caption}</figcaption>` : '';

                        blockInnerHtml = `<div class="${widthClass} ${alignClass}"><figure class="inline-block w-full">${imgTag}${captionHtml}</figure></div>`;
                    } else if (block.type === 'image_text') {
                        let rawTitle = block.content.title || '';
                        let compiledTitle = rawTitle.includes('<') ? rawTitle : this.compileTextHelper(rawTitle, block.content.title_settings, 'text-2xl font-bold text-slate-800', 'h3', block.id, 'title');
                        let imgPos = block.settings.image_position || 'left';
                        let imgUrl = block.content.image || '';
                        let descHtml = block.content.description || '';
                        let btnHtml = block.content.button_text ? `<div class="pt-2"><a href="${block.content.button_url}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all shadow-md shadow-blue-600/20"><span class="builder-editable" contenteditable="true" data-block-id="${block.id}" data-field="button_text" spellcheck="false">${block.content.button_text}</span></a></div>` : '';

                        let descEditable = `<div class="prose prose-slate text-slate-600 leading-relaxed !break-words !break-all builder-editable" contenteditable="true" data-block-id="${block.id}" data-field="description" spellcheck="false">${descHtml}</div>`;

                        if (imgPos === 'bottom') {
                            let imgCol = imgUrl ? `<div class="w-full mt-6 overflow-hidden rounded-2xl border border-slate-100"><img src="${imgUrl}" class="w-full h-auto object-cover rounded-2xl shadow-sm"></div>` : `<div class="w-full mt-6 p-8 bg-slate-50 border border-dashed border-slate-200 rounded-2xl text-center text-slate-400 text-xs font-semibold">Area Gambar (Belum ada URL gambar)</div>`;
                            let txtCol = `<div class="w-full space-y-4 min-w-0">
                                ${compiledTitle}
                                ${descEditable}
                                ${btnHtml}
                            </div>`;
                            blockInnerHtml = `<div class="flex flex-col w-full">${txtCol}${imgCol}</div>`;
                        } else if (imgPos === 'top') {
                            let imgCol = imgUrl ? `<div class="w-full mb-6 overflow-hidden rounded-2xl border border-slate-100"><img src="${imgUrl}" class="w-full h-auto object-cover rounded-2xl shadow-sm"></div>` : `<div class="w-full mb-6 p-8 bg-slate-50 border border-dashed border-slate-200 rounded-2xl text-center text-slate-400 text-xs font-semibold">Area Gambar (Belum ada URL gambar)</div>`;
                            let txtCol = `<div class="w-full space-y-4 min-w-0">
                                ${compiledTitle}
                                ${descEditable}
                                ${btnHtml}
                            </div>`;
                            blockInnerHtml = `<div class="flex flex-col w-full">${imgCol}${txtCol}</div>`;
                        } else if (imgPos === 'right') {
                            let imgCol = imgUrl ? `<div class="w-full md:w-1/3 shrink-0 rounded-2xl overflow-hidden border-4 border-white shadow-md"><img src="${imgUrl}" class="w-full h-auto object-cover aspect-[4/3] hover:scale-105 transition-transform duration-500"></div>` : `<div class="w-full md:w-1/3 shrink-0 aspect-[4/3] bg-slate-100 border border-dashed border-slate-200 rounded-2xl flex items-center justify-center text-slate-400 text-xs font-semibold">Upload Gambar</div>`;
                            let txtCol = `<div class="w-full md:w-2/3 space-y-4 min-w-0">
                                ${compiledTitle}
                                ${descEditable}
                                ${btnHtml}
                            </div>`;
                            blockInnerHtml = `<div class="flex flex-col md:flex-row-reverse gap-8 bg-white/70 backdrop-blur-lg p-6 md:p-8 rounded-3xl shadow-sm border border-slate-100 my-8 items-center">${imgCol}${txtCol}</div>`;
                        } else {
                            // left
                            let imgCol = imgUrl ? `<div class="w-full md:w-1/3 shrink-0 rounded-2xl overflow-hidden border-4 border-white shadow-md"><img src="${imgUrl}" class="w-full h-auto object-cover aspect-[4/3] hover:scale-105 transition-transform duration-500"></div>` : `<div class="w-full md:w-1/3 shrink-0 aspect-[4/3] bg-slate-100 border border-dashed border-slate-200 rounded-2xl flex items-center justify-center text-slate-400 text-xs font-semibold">Upload Gambar</div>`;
                            let txtCol = `<div class="w-full md:w-2/3 space-y-4 min-w-0">
                                ${compiledTitle}
                                ${descEditable}
                                ${btnHtml}
                            </div>`;
                            blockInnerHtml = `<div class="flex flex-col md:flex-row gap-8 bg-white/70 backdrop-blur-lg p-6 md:p-8 rounded-3xl shadow-sm border border-slate-100 my-8 items-center">${imgCol}${txtCol}</div>`;
                        }
                    } else if (block.type === 'cards') {
                        let compiledHeading = this.compileTextHelper(block.content.heading, block.content.heading_settings, 'text-3xl font-bold text-slate-900', 'h2', block.id, 'heading');
                        let headingHtml = compiledHeading ? `<div class="text-center mb-8">${compiledHeading}</div>` : '';
                        
                        let cols = block.content.columns == 2 ? 'grid-cols-1 md:grid-cols-2' : (block.content.columns == 4 ? 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4' : 'grid-cols-1 md:grid-cols-3');
                        let cardsHtml = `<div class="grid ${cols} gap-6 my-8">`;
                        (block.content.items || []).forEach((item, cIdx) => {
                            let compiledItemTitle = this.compileTextHelper(item.title, item.title_settings, 'text-xl font-bold text-slate-800 mb-2', 'h3', block.id, 'title', cIdx);
                            let compiledItemDesc = this.compileTextHelper(item.description, item.description_settings, 'text-slate-600 mb-4 flex-grow leading-relaxed', 'p', block.id, 'description', cIdx);
                            let imgHtml = item.image ? `<div class="rounded-2xl overflow-hidden mb-4"><img src="${item.image}" class="w-full h-48 object-cover hover:scale-105 transition-transform duration-500"></div>` : '';
                            let btnHtml = item.button_text ? `<div class="mt-auto pt-2"><a href="${item.button_url}" class="text-blue-600 font-bold inline-flex items-center gap-1 text-sm"><span class="builder-editable" contenteditable="true" data-block-id="${block.id}" data-item-idx="${cIdx}" data-field="button_text" spellcheck="false">${item.button_text}</span> <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a></div>` : '';
                            
                            cardsHtml += `<div class="bg-white/80 backdrop-blur-xl border border-slate-100 shadow-sm hover:shadow-lg rounded-3xl p-6 transition-all duration-300 hover:-translate-y-1 flex flex-col">
                                ${imgHtml}
                                <div class="flex-grow flex flex-col">
                                    ${compiledItemTitle}
                                    ${compiledItemDesc}
                                    ${btnHtml}
                                </div>
                            </div>`;
                        });
                        cardsHtml += `</div>`;
                        blockInnerHtml = `${headingHtml}${cardsHtml}`;
                    } else if (block.type === 'list' || block.type === 'lists') {
                        let heading = block.content.heading || '';
                        let desc = block.content.description || '';
                        let style = block.content.style || 'check';
                        let cols = parseInt(block.content.columns || 1);
                        let items = block.content.items || [];

                        let compiledHeading = this.compileTextHelper(heading, block.content.heading_settings, 'text-2xl md:text-3xl font-bold text-slate-900', 'h2', block.id, 'heading');
                        let headingHtml = compiledHeading ? `<div class="mb-3">${compiledHeading}</div>` : '';
                        let descHtml = desc ? `<p class="text-slate-600 text-sm sm:text-base mb-6 max-w-3xl builder-editable" contenteditable="true" data-block-id="${block.id}" data-field="description" spellcheck="false">${desc}</p>` : '';

                        let gridClass = cols === 2 ? 'grid grid-cols-1 md:grid-cols-2 gap-3.5' : 'space-y-3';

                        let itemsHtml = '';
                        (items.length ? items : [{title: 'Contoh butir poin list...', description: ''}]).forEach((item, idx) => {
                            let iconHtml = '';
                            if (style === 'number') {
                                iconHtml = `<span class="flex-shrink-0 w-7 h-7 rounded-full bg-blue-100 text-blue-600 font-bold text-xs flex items-center justify-center mt-0.5">${idx + 1}</span>`;
                            } else if (style === 'arrow') {
                                iconHtml = `<span class="flex-shrink-0 w-7 h-7 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mt-0.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></span>`;
                            } else if (style === 'bullet') {
                                iconHtml = `<span class="flex-shrink-0 w-7 h-7 flex items-center justify-center mt-0.5 text-blue-600 font-extrabold text-xl leading-none">•</span>`;
                            } else {
                                iconHtml = `<span class="flex-shrink-0 w-7 h-7 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mt-0.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg></span>`;
                            }

                            let itemTitle = item.title || '';
                            let itemDesc = item.description || '';
                            let itemLink = item.link || '';

                            let titleHtml = `<span class="font-semibold text-slate-800 text-sm sm:text-base leading-snug builder-editable" contenteditable="true" data-block-id="${block.id}" data-item-idx="${idx}" data-field="title" spellcheck="false">${itemTitle}</span>`;
                            if (itemLink) {
                                titleHtml = `<a href="${itemLink}" target="_blank" class="hover:text-blue-600 hover:underline transition-colors">${titleHtml}</a>`;
                            }

                            let descItemHtml = item.description ? `<p class="text-xs text-slate-500 mt-1 leading-relaxed builder-editable" contenteditable="true" data-block-id="${block.id}" data-item-idx="${idx}" data-field="description" spellcheck="false">${item.description}</p>` : '';

                            itemsHtml += `<div class="flex items-start gap-3.5 p-3.5 rounded-xl bg-white/70 border border-slate-100 shadow-xs hover:border-blue-200 transition-colors">
                                ${iconHtml}
                                <div class="flex-1 min-w-0">
                                    ${titleHtml}
                                    ${descItemHtml}
                                </div>
                            </div>`;
                        });

                        blockInnerHtml = `<div class="max-w-4xl mx-auto">
                            ${headingHtml}
                            ${descHtml}
                            <div class="${gridClass}">
                                ${itemsHtml}
                            </div>
                        </div>`;
                    } else if (block.type === 'gallery_slider') {
                        let heading = block.content.heading || '';
                        let subheading = block.content.subheading || '';
                        let items = block.content.items || [];

                        let headingHtml = heading ? `<h2 class="text-3xl font-extrabold text-slate-800 builder-editable" contenteditable="true" data-block-id="${block.id}" data-field="heading" spellcheck="false">${heading}</h2>` : '';
                        let subheadingHtml = subheading ? `<p class="text-slate-500 mt-2 builder-editable" contenteditable="true" data-block-id="${block.id}" data-field="subheading" spellcheck="false">${subheading}</p>` : '';
                        let headerBlock = (headingHtml || subheadingHtml) ? `<div class="text-center max-w-2xl mx-auto mb-8">${headingHtml}${subheadingHtml}</div>` : '';

                        let cardsHtml = '';
                        let loopItems = items.length > 0 ? items.concat(items) : [];
                        loopItems.forEach((item, gIdx) => {
                            let realIdx = gIdx % items.length;
                            cardsHtml += `<div class="w-64 bg-white/80 backdrop-blur-xl border border-slate-100 shadow-sm rounded-3xl p-5 shrink-0 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                                <div class="w-24 h-24 mx-auto rounded-full overflow-hidden border-2 border-blue-500/20 mb-3">
                                    <img src="${item.image || 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=300&h=300&fit=crop'}" class="w-full h-full object-cover" alt="Pegawai">
                                </div>
                                <h4 class="font-bold text-slate-800 text-center text-sm builder-editable" contenteditable="true" data-block-id="${block.id}" data-item-idx="${realIdx}" data-field="name" spellcheck="false">${item.name}</h4>
                                <p class="text-xs text-blue-600 font-medium text-center builder-editable" contenteditable="true" data-block-id="${block.id}" data-item-idx="${realIdx}" data-field="role" spellcheck="false">${item.role}</p>
                            </div>`;
                        });

                        blockInnerHtml = `<div class="w-full max-w-6xl mx-auto my-8">
                            ${headerBlock}
                            <div class="relative w-full overflow-hidden py-4 [mask-image:_linear-gradient(to_right,transparent_0,_black_128px,_black_calc(100%-128px),transparent_100%)]">
                                <div class="animate-marquee flex gap-6 w-max">
                                    ${cardsHtml}
                                </div>
                            </div>
                        </div>`;
                    } else if (block.type === 'profile_table') {
                        let name = block.content.name || '';
                        let role = block.content.role || '';
                        let imgUrl = block.content.image || 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=600&h=500&fit=crop';
                        let bio = block.content.bio || '';
                        let details = block.content.details || [];
                        let btnText = block.content.button_text || '';
                        let btnUrl = block.content.button_url || '#';

                        let rowsHtml = '';
                        details.forEach((d, dIdx) => {
                            rowsHtml += `<tr>
                                <th class="py-2.5 px-4 font-semibold text-slate-500 w-1/3 bg-slate-50/60">${d.label}</th>
                                <td class="py-2.5 px-4 text-slate-800 font-medium builder-editable" contenteditable="true" data-block-id="${block.id}" data-item-idx="${dIdx}" data-field="value" spellcheck="false">${d.value}</td>
                            </tr>`;
                        });

                        let btnHtml = btnText ? `<div class="mt-4 text-center"><a href="${btnUrl}" class="inline-flex items-center gap-1.5 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-600/20 transition-all"><span class="builder-editable" contenteditable="true" data-block-id="${block.id}" data-field="button_text" spellcheck="false">${btnText}</span></a></div>` : '';

                        blockInnerHtml = `<div class="w-full max-w-5xl mx-auto my-8">
                            <div class="bg-white/80 backdrop-blur-xl border border-slate-200/80 rounded-3xl shadow-sm p-6 sm:p-8 flex flex-col md:flex-row gap-8 items-start">
                                <div class="w-full md:w-1/3 shrink-0 flex flex-col items-center">
                                    <div class="w-48 h-56 sm:w-56 sm:h-64 rounded-2xl overflow-hidden border-4 border-white shadow-md bg-slate-100 mb-4">
                                        <img src="${imgUrl}" class="w-full h-full object-cover" alt="${name}">
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-800 text-center builder-editable" contenteditable="true" data-block-id="${block.id}" data-field="name" spellcheck="false">${name}</h3>
                                    <p class="text-xs font-semibold text-blue-600 text-center mt-1 builder-editable" contenteditable="true" data-block-id="${block.id}" data-field="role" spellcheck="false">${role}</p>
                                    ${btnHtml}
                                </div>
                                <div class="w-full md:w-2/3 min-w-0 space-y-4">
                                    <div class="border-b border-slate-100 pb-3">
                                        <h4 class="text-lg font-bold text-slate-800">Biodata &amp; Informasi Pegawai</h4>
                                        <p class="text-xs text-slate-500 mt-0.5">Informasi resmi jabatan dan kepegawaian BPMP Sultra</p>
                                    </div>
                                    <div class="text-sm text-slate-600 leading-relaxed builder-editable" contenteditable="true" data-block-id="${block.id}" data-field="bio" spellcheck="false">${bio}</div>
                                    <div class="rounded-2xl border border-slate-100 overflow-hidden bg-white/50">
                                        <table class="w-full text-left text-xs sm:text-sm">
                                            <tbody class="divide-y divide-slate-100">
                                                ${rowsHtml}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    } else if (block.type === 'glass_split') {
                        let content = block.content || {};
                        let imgPos = content.image_position || 'left';
                        let tagline = content.tagline ? `<div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-blue-50 text-blue-600 font-bold text-sm uppercase tracking-widest border border-blue-100">${content.tagline}</div>` : '';
                        let title = content.title ? `<h2 class="text-3xl md:text-5xl font-extrabold text-slate-800 leading-tight">${content.title}</h2>` : '';
                        let desc = content.description ? `<div class="prose prose-slate prose-lg max-w-none text-slate-600 leading-relaxed">${content.description}</div>` : '';
                        let btn = content.button_text ? `<a href="${content.button_link || '#'}" class="inline-block mt-4 px-6 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-md hover:bg-blue-700 transition-colors">${content.button_text}</a>` : '';

                        let imgHtml = content.image_url ? `<img src="${content.image_url}" alt="Preview" class="w-full h-auto aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-700">` : `<div class="w-full aspect-[3/4] bg-slate-100 flex items-center justify-center text-slate-400 text-xs font-semibold">Area Gambar</div>`;

                        let imgCol = `<div class="w-full lg:w-1/3 shrink-0"><div class="relative rounded-[2rem] overflow-hidden shadow-lg border-4 border-slate-50 group">${imgHtml}</div></div>`;
                        let txtCol = `<div class="w-full lg:w-2/3 space-y-6">${tagline}${title}${desc}${btn}</div>`;

                        let reverseClass = imgPos === 'right' ? 'lg:flex-row-reverse' : '';
                        blockInnerHtml = `<div class="flex flex-col lg:flex-row gap-12 items-center mb-16 ${reverseClass}">${imgCol}${txtCol}</div>`;
                    } else if (block.type === 'glass_cards') {
                        let content = block.content || {};
                        let secTitle = content.section_title ? `<h3 class="text-3xl font-extrabold text-slate-800">${content.section_title}</h3>` : '';
                        let secSub = content.section_subtitle ? `<p class="text-slate-500 mt-2">${content.section_subtitle}</p>` : '';
                        let header = (secTitle || secSub) ? `<div class="text-center mb-10">${secTitle}${secSub}</div>` : '';

                        let cards = content.cards || [];
                        let cardsHtml = '';
                        cards.forEach((card) => {
                            let cTitle = card.title || 'Nama Daerah';
                            let cSub = card.subtitle || 'Unduh Profil';
                            cardsHtml += `<div class="group relative bg-slate-50/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-xl hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 min-h-[120px] flex flex-col justify-center overflow-hidden">
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:bg-blue-50 shadow-sm transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div class="relative z-10 pr-14">
                                    <span class="text-[10px] text-blue-500 font-extrabold uppercase tracking-widest block mb-1 group-hover:text-blue-600 transition-colors">${cSub}</span>
                                    <h4 class="text-base sm:text-lg font-bold text-slate-700 group-hover:text-blue-700 leading-snug transition-colors">${cTitle}</h4>
                                </div>
                            </div>`;
                        });

                        blockInnerHtml = `<div class="my-12">${header}<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">${cardsHtml}</div></div>`;
                    }

                    if (block.settings && block.settings.wrapper_class) {
                        blockInnerHtml = `<div class="${block.settings.wrapper_class}">${blockInnerHtml}</div>`;
                    }

                    let isBlockSelected = (this.activeBlockIndex === bIdx);
                    let selectedClass = isBlockSelected ? 'is-selected' : '';
                    let blockLabel = this.getBlockLabel(block.type);

                    // Canva / Figma 8-Anchor Handles (visible when selected)
                    let anchorHandlesHtml = isBlockSelected ? `
                        <span class="canvas-anchor-handle canvas-handle-tl"></span>
                        <span class="canvas-anchor-handle canvas-handle-tr"></span>
                        <span class="canvas-anchor-handle canvas-handle-bl"></span>
                        <span class="canvas-anchor-handle canvas-handle-br"></span>
                        <span class="canvas-anchor-handle canvas-handle-tc"></span>
                        <span class="canvas-anchor-handle canvas-handle-bc"></span>
                        <span class="canvas-anchor-handle canvas-handle-ml"></span>
                        <span class="canvas-anchor-handle canvas-handle-mr"></span>
                    ` : '';

                    // Canva / Figma Floating Action Menu
                    let blockActionsHtml = isBlockSelected ? `
                    <div class="canvas-action-toolbar absolute -top-5 left-4 z-40 flex items-center gap-1.5 bg-slate-900/95 text-white backdrop-blur-xl px-3 py-1.5 rounded-2xl shadow-2xl border border-slate-700/80 pointer-events-auto select-none" onclick="event.stopPropagation()">
                        <!-- Block Type Badge -->
                        <span class="text-[10px] font-extrabold text-blue-300 uppercase tracking-wider px-2 py-0.5 bg-blue-500/20 border border-blue-400/30 rounded-lg flex items-center gap-1 shrink-0">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                            ${blockLabel}
                        </span>
                        
                        <!-- 1. Edit Teks -->
                        <button type="button" onclick="window.pageBuilderApp.canvasActionEditText(${bIdx}, event)" class="flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold text-slate-100 hover:text-white hover:bg-slate-800 rounded-lg transition-colors" title="Edit teks di kanvas">
                            <svg class="w-3.5 h-3.5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            <span>Edit Teks</span>
                        </button>
                        
                        <!-- 2. Ganti Gambar / Upload -->
                        <button type="button" onclick="window.pageBuilderApp.canvasActionChangeImage(${bIdx}, event)" class="flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold text-slate-100 hover:text-white hover:bg-slate-800 rounded-lg transition-colors" title="Upload atau ganti gambar pada section ini">
                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Ganti Gambar</span>
                        </button>

                        <!-- 3. Pindah Posisi (Naik / Turun) -->
                        <div class="flex items-center bg-slate-800/90 rounded-lg p-0.5 border border-slate-700/60 mx-0.5">
                            <button type="button" onclick="window.pageBuilderApp.moveUp(${bIdx}); event.stopPropagation();" class="p-1 text-slate-300 hover:text-blue-400 hover:bg-slate-700 rounded transition-colors" title="Geser ke Atas (Naik)">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                            </button>
                            <span class="text-[9px] text-slate-400 font-bold px-1 uppercase tracking-wider">Posisi</span>
                            <button type="button" onclick="window.pageBuilderApp.moveDown(${bIdx}); event.stopPropagation();" class="p-1 text-slate-300 hover:text-blue-400 hover:bg-slate-700 rounded transition-colors" title="Geser ke Bawah (Turun)">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                        </div>

                        <!-- Duplikat -->
                        <button type="button" onclick="window.pageBuilderApp.duplicateBlock(${bIdx}); event.stopPropagation();" class="p-1.5 text-slate-300 hover:text-emerald-400 hover:bg-slate-800 rounded-lg transition-colors" title="Duplikasi Section">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </button>

                        <!-- 4. Hapus Elemen -->
                        <button type="button" onclick="window.pageBuilderApp.canvasActionDelete(${bIdx}, event)" class="flex items-center gap-1 px-2.5 py-1 text-xs font-semibold text-rose-300 hover:text-white hover:bg-rose-600/80 rounded-lg transition-colors ml-0.5" title="Hapus elemen section ini">
                            <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            <span>Hapus</span>
                        </button>
                    </div>` : `
                    <!-- Subtle Hover Badge when not selected -->
                    <div class="absolute top-2 right-4 z-20 opacity-0 group-hover/canvas-block:opacity-100 transition-all duration-150 pointer-events-none">
                        <span class="text-[10px] font-bold text-slate-600 bg-white/90 backdrop-blur-md border border-slate-200 px-2 py-1 rounded-md shadow-xs">${blockLabel}</span>
                    </div>`;

                    let innerWrapper = (block.type === 'html_custom' && (!block.settings.padding || block.settings.padding === 'none')) ? blockInnerHtml : `<div class="container mx-auto px-4 max-w-5xl">${blockInnerHtml}</div>`;
                    html += `<section class="canvas-block-section relative group/canvas-block ${bg} ${py} ${align} ${selectedClass}" data-block-index="${bIdx}" data-block-id="${block.id}" onclick="window.pageBuilderApp.selectBlockFromCanvas(${bIdx}, event)">
                        ${anchorHandlesHtml}
                        ${blockActionsHtml}
                        ${innerWrapper}
                    </section>`;
                });
                return html;
            }
        }));
    });
    </script>
</body>
</html>
