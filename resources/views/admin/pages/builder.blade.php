<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visual Builder - {{ $page->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-slate-100 font-sans text-slate-800 h-screen flex flex-col overflow-hidden" x-data="pageBuilder()">
    
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
                    <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden group">
                        <!-- Block Header -->
                        <div class="flex items-center justify-between p-3 bg-slate-50 cursor-pointer hover:bg-slate-100 transition-colors border-b border-slate-200" @click="activeBlockIndex = (activeBlockIndex === index ? null : index)">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-slate-400 cursor-move" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                <span class="font-bold text-slate-700 text-sm" x-text="getBlockLabel(block.type)"></span>
                            </div>
                            <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button type="button" @click.stop="moveUp(index)" x-show="index > 0" class="p-1 text-slate-400 hover:text-blue-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg></button>
                                <button type="button" @click.stop="moveDown(index)" x-show="index < blocks.length - 1" class="p-1 text-slate-400 hover:text-blue-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
                                <button type="button" @click.stop="duplicateBlock(index)" class="p-1 text-slate-400 hover:text-green-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg></button>
                                <button type="button" @click.stop="removeBlock(index)" class="p-1 text-slate-400 hover:text-red-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            </div>
                        </div>
                        
                        <!-- Block Form -->
                        <div x-show="activeBlockIndex === index" style="display: none;" class="p-4 bg-white">
                            
                            <!-- General Settings (Background, Spacing, Align) -->
                            <div class="flex gap-4 mb-4 pb-4 border-b border-slate-100">
                                <div class="flex-1">
                                    <label class="block text-[10px] uppercase font-bold text-slate-500 mb-1">Background</label>
                                    <select x-model="block.settings.bg" class="w-full text-xs border-slate-200 rounded-md">
                                        <option value="white">Putih</option>
                                        <option value="gray">Abu-abu Muda</option>
                                        <option value="blue">Biru Muda</option>
                                    </select>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-[10px] uppercase font-bold text-slate-500 mb-1">Padding</label>
                                    <select x-model="block.settings.padding" class="w-full text-xs border-slate-200 rounded-md">
                                        <option value="small">Kecil</option>
                                        <option value="medium">Sedang</option>
                                        <option value="large">Besar</option>
                                    </select>
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
                                </div>
                            </template>
                            
                            <template x-if="block.type === 'text'">
                                <div class="space-y-3">
                                    <div><label class="text-xs font-bold">HTML / Konten Teks</label><textarea x-model="block.content.html" rows="5" class="w-full font-mono text-xs rounded-md border-slate-200"></textarea></div>
                                </div>
                            </template>
                            
                            <template x-if="block.type === 'image_text'">
                                <div class="space-y-4">
                                    <div><label class="text-xs font-bold">URL Gambar</label><input type="text" x-model="block.content.image" placeholder="https://..." class="w-full text-sm rounded-md border-slate-200"></div>
                                    <div><label class="text-xs font-bold">Posisi Gambar</label>
                                        <select x-model="block.settings.image_position" class="w-full text-sm rounded-md border-slate-200">
                                            <option value="left">Kiri</option><option value="right">Kanan</option>
                                        </select>
                                    </div>
                                    <div>
                                        <div class="flex justify-between items-center mb-1">
                                            <label class="text-xs font-bold">Judul</label>
                                            <button type="button" @click="openTextSettings(block.content, 'title_settings', 'Pengaturan Judul')" class="text-[10px] bg-slate-100 px-2 py-1 rounded text-blue-600 hover:bg-blue-100 font-bold flex items-center gap-1">⚙️ Style Teks</button>
                                        </div>
                                        <input type="text" x-model="block.content.title" class="w-full text-sm rounded-md border-slate-200">
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
                        </div>
                    </div>
                </template>
                
                <div x-show="blocks.length === 0" class="text-center py-8 text-slate-400 text-sm">
                    Belum ada section.
                </div>

                <div class="mt-4 pt-4 border-t border-slate-200 grid grid-cols-2 gap-2">
                    <button type="button" @click="addBlock('hero')" class="px-3 py-2 bg-white border border-slate-200 shadow-sm text-xs font-bold text-slate-700 rounded-lg hover:bg-slate-50 hover:border-blue-300 flex items-center justify-center gap-1">+ Hero</button>
                    <button type="button" @click="addBlock('text')" class="px-3 py-2 bg-white border border-slate-200 shadow-sm text-xs font-bold text-slate-700 rounded-lg hover:bg-slate-50 hover:border-blue-300 flex items-center justify-center gap-1">+ HTML</button>
                    <button type="button" @click="addBlock('image_text')" class="px-3 py-2 bg-white border border-slate-200 shadow-sm text-xs font-bold text-slate-700 rounded-lg hover:bg-slate-50 hover:border-blue-300 flex items-center justify-center gap-1">+ Img&Txt</button>
                    <button type="button" @click="addBlock('cards')" class="px-3 py-2 bg-white border border-slate-200 shadow-sm text-xs font-bold text-slate-700 rounded-lg hover:bg-slate-50 hover:border-blue-300 flex items-center justify-center gap-1">+ Cards</button>
                </div>
            </div>
        </aside>

        <!-- Preview Workspace -->
        <section class="flex-1 bg-slate-200 relative overflow-y-auto">
            <div class="min-h-full w-full bg-white shadow-2xl" id="preview-container" x-html="compiledPreview()">
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

    <!-- Template Modal -->
    <div x-show="showTemplateModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm">
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl overflow-hidden" @click.away="showTemplateModal = false">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-bold text-lg text-slate-900">Pilih Template</h3>
                <button type="button" @click="showTemplateModal = false" class="text-slate-400 hover:text-slate-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <div class="p-6 grid grid-cols-1 gap-4">
                <button type="button" @click="loadTemplate('landing'); showTemplateModal = false" class="text-left p-4 rounded-xl border border-slate-200 hover:border-blue-500 hover:bg-blue-50 transition-all group">
                    <h4 class="font-bold text-slate-800 group-hover:text-blue-600">Landing Page Standard</h4>
                    <p class="text-xs text-slate-500 mt-1">Hero, Pengenalan (Image+Text), 3 Card Layanan.</p>
                </button>
                <button type="button" @click="loadTemplate('about'); showTemplateModal = false" class="text-left p-4 rounded-xl border border-slate-200 hover:border-blue-500 hover:bg-blue-50 transition-all group">
                    <h4 class="font-bold text-slate-800 group-hover:text-blue-600">Halaman Tentang Kami</h4>
                    <p class="text-xs text-slate-500 mt-1">Hero, Visi Misi (Text), Susunan Organisasi (Cards).</p>
                </button>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('pageBuilder', () => ({
            blocks: {!! $page->builder_data ?: '[]' !!},
            activeBlockIndex: null,
            showTemplateModal: false,
            isSaving: false,
            showToast: false,

            // Text Settings state
            isTextSettingsOpen: false,
            textSettingsTitle: 'Pengaturan Teks',
            activeTextSettingsRef: null,

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
            },

            getBlockLabel(type) {
                const labels = { 'hero': 'Hero Banner', 'text': 'Teks / HTML', 'image_text': 'Gambar & Teks', 'cards': 'Grid Cards' };
                return labels[type] || 'Section';
            },

            addBlock(type) {
                const newBlock = {
                    id: Date.now(),
                    type: type,
                    settings: { bg: 'white', padding: 'medium', align: 'left' },
                    content: {}
                };

                if (type === 'hero') {
                    newBlock.content = { title: 'Judul Baru', description: 'Deskripsi...', button_text: '', button_url: '' };
                } else if (type === 'text') {
                    newBlock.content = { html: '<p>Teks paragraf baru...</p>' };
                } else if (type === 'image_text') {
                    newBlock.content = { image: '', title: 'Judul Baru', description: 'Deskripsi...', button_text: '', button_url: '' };
                } else if (type === 'cards') {
                    newBlock.content = { heading: 'Layanan Kami', columns: 3, items: [{title: 'Card 1', description: 'Desc 1', image: '', button_text:'', button_url:''}] };
                }

                this.blocks.push(newBlock);
                this.activeBlockIndex = this.blocks.length - 1;
            },

            removeBlock(index) {
                if (confirm('Hapus section ini?')) {
                    this.blocks.splice(index, 1);
                    this.activeBlockIndex = null;
                }
            },

            duplicateBlock(index) {
                const copy = JSON.parse(JSON.stringify(this.blocks[index]));
                copy.id = Date.now();
                this.blocks.splice(index + 1, 0, copy);
            },

            moveUp(index) {
                if (index > 0) {
                    const temp = this.blocks[index];
                    this.blocks[index] = this.blocks[index - 1];
                    this.blocks[index - 1] = temp;
                    if (this.activeBlockIndex === index) this.activeBlockIndex = index - 1;
                    else if (this.activeBlockIndex === index - 1) this.activeBlockIndex = index;
                }
            },

            moveDown(index) {
                if (index < this.blocks.length - 1) {
                    const temp = this.blocks[index];
                    this.blocks[index] = this.blocks[index + 1];
                    this.blocks[index + 1] = temp;
                    if (this.activeBlockIndex === index) this.activeBlockIndex = index + 1;
                    else if (this.activeBlockIndex === index + 1) this.activeBlockIndex = index;
                }
            },

            loadTemplate(type) {
                if (type === 'landing') {
                    this.blocks = [
                        { id: 1, type: 'hero', settings: {bg: 'blue', padding: 'large', align:'center'}, content: {title: 'Selamat Datang', description: 'Ini adalah halaman landing page baru', button_text: 'Mulai', button_url: '#'} },
                        { id: 2, type: 'image_text', settings: {bg: 'white', padding: 'medium', align:'left', image_position: 'left'}, content: {title: 'Tentang Kami', description: '<p>Penjelasan singkat tentang kami...</p>', image: 'https://via.placeholder.com/600x400', button_text: 'Selengkapnya', button_url: '#'} },
                        { id: 3, type: 'cards', settings: {bg: 'gray', padding: 'medium', align:'left'}, content: {heading: 'Layanan Utama', columns: 3, items: [{title:'Layanan 1', description:'Desc 1'}, {title:'Layanan 2', description:'Desc 2'}, {title:'Layanan 3', description:'Desc 3'}]} }
                    ];
                } else if (type === 'about') {
                    this.blocks = [
                        { id: 1, type: 'hero', settings: {bg: 'gray', padding: 'large', align:'center'}, content: {title: 'Tentang Kami', description: 'Visi dan Misi kami dalam melayani.', button_text: '', button_url: ''} },
                        { id: 2, type: 'text', settings: {bg: 'white', padding: 'medium', align:'left'}, content: {html: '<h2>Visi</h2><p>Mewujudkan pelayanan...</p>'} }
                    ];
                }
            },

            async saveBuilder() {
                this.isSaving = true;
                
                try {
                    const response = await fetch('{{ route('admin.pages.builder.save', $page->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            builder_data: JSON.stringify(this.blocks),
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

            compileTextHelper(text, settings, defaultClasses, defaultTag) {
                if (!text || text.trim() === '') return '';
                settings = settings || {};
                const tag = settings.tag || defaultTag;
                
                let classes = [defaultClasses, '!break-words', '!break-all'];
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
                
                let html = `<${tag} class="${classStr}"${style}>${text}</${tag}>`;
                if (settings.link) {
                    html = `<a href="${settings.link}" class="hover:opacity-80 transition-opacity">${html}</a>`;
                }
                return html;
            },

            compiledPreview() {
                let html = '<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">';
                this.blocks.forEach(block => {
                    let bg = block.settings.bg === 'white' ? 'bg-white' : (block.settings.bg === 'gray' ? 'bg-gray-50' : 'bg-blue-50');
                    let py = block.settings.padding === 'small' ? 'py-8' : (block.settings.padding === 'large' ? 'py-24' : 'py-16');
                    let align = 'text-' + (block.settings.align || 'left');
                    
                    html += `<section class="${bg} ${py} ${align}"><div class="container mx-auto px-4">`;
                    
                    if (block.type === 'hero') {
                        let compiledTitle = this.compileTextHelper(block.content.title, block.content.title_settings, 'text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight', 'h1');
                        let compiledDesc = this.compileTextHelper(block.content.description, block.content.description_settings, 'text-lg text-slate-600', 'p');
                        
                        html += `<div class="max-w-4xl mx-auto text-center space-y-6">
                            ${compiledTitle}
                            ${compiledDesc}
                            ${block.content.button_text ? `<div class="pt-4"><a href="${block.content.button_url}" class="inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-full transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">${block.content.button_text}</a></div>` : ''}
                        </div>`;
                    } else if (block.type === 'text') {
                        html += `<div class="prose max-w-4xl mx-auto !break-words !break-all overflow-hidden">${block.content.html || ''}</div>`;
                    } else if (block.type === 'image_text') {
                        let compiledTitle = this.compileTextHelper(block.content.title, block.content.title_settings, 'text-3xl lg:text-4xl font-bold text-slate-900', 'h2');
                        
                        let imgCol = `<div class="w-full lg:w-1/2"><img src="${block.content.image || 'https://via.placeholder.com/600x400'}" class="w-full rounded-2xl shadow-lg"></div>`;
                        let txtCol = `<div class="w-full lg:w-1/2 space-y-6 min-w-0">
                            ${compiledTitle}
                            <div class="prose prose-lg prose-blue !break-words !break-all text-slate-600">${block.content.description || ''}</div>
                            ${block.content.button_text ? `<div class="pt-2"><a href="${block.content.button_url}" class="inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all">${block.content.button_text}</a></div>` : ''}
                        </div>`;
                        let dir = block.settings.image_position === 'left' ? imgCol + txtCol : txtCol + imgCol;
                        html += `<div class="flex flex-col lg:flex-row items-center gap-12">${dir}</div>`;
                    } else if (block.type === 'cards') {
                        let compiledHeading = this.compileTextHelper(block.content.heading, block.content.heading_settings, 'text-3xl font-bold text-slate-900', 'h2');
                        if (compiledHeading) html += `<div class="text-center mb-12">${compiledHeading}</div>`;
                        
                        let cols = block.content.columns == 2 ? 'grid-cols-2' : (block.content.columns == 4 ? 'grid-cols-4' : 'grid-cols-3');
                        html += `<div class="grid ${cols} gap-6">`;
                        (block.content.items || []).forEach(item => {
                            let compiledItemTitle = this.compileTextHelper(item.title, item.title_settings, 'text-xl font-bold text-slate-900 mb-2', 'h3');
                            let compiledItemDesc = this.compileTextHelper(item.description, item.description_settings, 'text-slate-600 mb-4 flex-grow', 'p');
                            
                            html += `<div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow border border-slate-100 overflow-hidden flex flex-col">
                                ${item.image ? `<img src="${item.image}" class="w-full h-48 object-cover">` : ''}
                                <div class="p-6 flex-grow flex flex-col">
                                    ${compiledItemTitle}
                                    ${compiledItemDesc}
                                    ${item.button_text ? `<div class="mt-auto"><a href="${item.button_url}" class="text-blue-600 font-bold inline-flex items-center gap-1">${item.button_text} <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a></div>` : ''}
                                </div>
                            </div>`;
                        });
                        html += `</div>`;
                    }
                    
                    html += `</div></section>`;
                });
                return html;
            }
        }));
    });
    </script>
</body>
</html>
