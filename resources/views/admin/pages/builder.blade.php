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
                        </div>
                    </div>
                </template>
                
                <div x-show="blocks.length === 0" class="text-center py-8 text-slate-400 text-sm">
                    Belum ada section.
                </div>

                <div class="mt-4 pt-4 border-t border-slate-200 grid grid-cols-2 gap-2">
                    <button type="button" @click="addBlock('hero')" class="px-3 py-2 bg-white border border-slate-200 shadow-sm text-xs font-bold text-slate-700 rounded-lg hover:bg-slate-50 hover:border-blue-300 flex items-center justify-center gap-1">+ Hero</button>
                    <button type="button" @click="addBlock('text')" class="px-3 py-2 bg-white border border-slate-200 shadow-sm text-xs font-bold text-slate-700 rounded-lg hover:bg-slate-50 hover:border-blue-300 flex items-center justify-center gap-1">+ HTML</button>
                    <button type="button" @click="addBlock('image')" class="px-3 py-2 bg-white border border-slate-200 shadow-sm text-xs font-bold text-slate-700 rounded-lg hover:bg-slate-50 hover:border-blue-300 flex items-center justify-center gap-1">+ Gambar Saja</button>
                    <button type="button" @click="addBlock('image_text')" class="px-3 py-2 bg-white border border-slate-200 shadow-sm text-xs font-bold text-slate-700 rounded-lg hover:bg-slate-50 hover:border-blue-300 flex items-center justify-center gap-1">+ Img & Teks</button>
                    <button type="button" @click="addBlock('cards')" class="px-3 py-2 bg-white border border-slate-200 shadow-sm text-xs font-bold text-slate-700 rounded-lg hover:bg-slate-50 hover:border-blue-300 flex items-center justify-center gap-1">+ Cards</button>
                    <button type="button" @click="addBlock('list')" class="px-3 py-2 bg-blue-50 border border-blue-200 shadow-sm text-xs font-bold text-blue-700 rounded-lg hover:bg-blue-100 hover:border-blue-300 flex items-center justify-center gap-1">+ Daftar List</button>
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
                const labels = { 'hero': 'Hero Banner', 'text': 'Teks / HTML', 'image': 'Gambar Saja', 'image_text': 'Gambar & Teks', 'cards': 'Grid Cards', 'list': 'Daftar List', 'lists': 'Daftar List' };
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
                } else if (type === 'image') {
                    newBlock.settings.align = 'center';
                    newBlock.content = {
                        image: '',
                        caption: '',
                        alt: '',
                        width: 'max-w-5xl',
                        rounded: 'rounded-2xl',
                        shadow: 'shadow-lg',
                        link: ''
                    };
                } else if (type === 'image_text') {
                    newBlock.content = { image: '', title: 'Judul Baru', description: 'Deskripsi...', button_text: '', button_url: '' };
                } else if (type === 'cards') {
                    newBlock.content = { heading: 'Layanan Kami', columns: 3, items: [{title: 'Card 1', description: 'Desc 1', image: '', button_text:'', button_url:''}] };
                } else if (type === 'list' || type === 'lists') {
                    newBlock.type = 'list';
                    newBlock.content = {
                        heading: 'Daftar Poin & Layanan',
                        description: 'Berikut ini adalah poin-poin penting informasi.',
                        style: 'check',
                        columns: 1,
                        items: [
                            { title: 'Persyaratan atau poin pertama', description: 'Penjelasan ringkas mengenai poin ini', link: '' },
                            { title: 'Persyaratan atau poin kedua', description: 'Penjelasan ringkas mengenai poin ini', link: '' },
                            { title: 'Persyaratan atau poin ketiga', description: 'Penjelasan ringkas mengenai poin ini', link: '' }
                        ]
                    };
                }

                this.blocks.push(newBlock);
                this.activeBlockIndex = this.blocks.length - 1;
            },

            async uploadImage(event, targetBlockOrItem) {
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
                            targetBlockOrItem.content.image = data.url;
                        } else {
                            targetBlockOrItem.image = data.url;
                        }
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
                    } else if (block.type === 'image') {
                        let imgUrl = block.content.image;
                        let altText = block.content.alt || '';
                        let caption = block.content.caption || '';
                        let width = block.content.width || 'max-w-5xl';
                        let rounded = block.content.rounded || 'rounded-2xl';
                        let shadow = block.content.shadow || 'shadow-lg';
                        let align = block.settings.align || 'center';

                        let widthClass = width === 'w-full' ? 'w-full max-w-6xl' : width;
                        let alignClass = align === 'left' ? 'mr-auto text-left' : (align === 'right' ? 'ml-auto text-right' : 'mx-auto text-center');

                        let displaySrc = imgUrl || 'https://via.placeholder.com/1200x600?text=Pilih+atau+Upload+Gambar';
                        let imgTag = `<img src="${displaySrc}" alt="${altText}" class="w-full h-auto ${rounded} ${shadow} object-cover">`;

                        if (block.content.link) {
                            imgTag = `<a href="${block.content.link}" target="_blank" class="block hover:opacity-95 transition-opacity">${imgTag}</a>`;
                        }

                        let captionHtml = caption ? `<figcaption class="mt-3 text-sm text-slate-500 italic text-center">${caption}</figcaption>` : '';

                        html += `<div class="${widthClass} ${alignClass}"><figure class="inline-block w-full">${imgTag}${captionHtml}</figure></div>`;
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
                    } else if (block.type === 'list' || block.type === 'lists') {
                        let heading = block.content.heading || '';
                        let desc = block.content.description || '';
                        let style = block.content.style || 'check';
                        let cols = parseInt(block.content.columns || 1);
                        let items = block.content.items || [];

                        let compiledHeading = this.compileTextHelper(heading, block.content.heading_settings, 'text-2xl md:text-3xl font-bold text-slate-900', 'h2');
                        let headingHtml = compiledHeading ? `<div class="mb-3">${compiledHeading}</div>` : '';
                        let descHtml = desc ? `<p class="text-slate-600 text-sm sm:text-base mb-6 max-w-3xl">${desc}</p>` : '';

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

                            let titleHtml = `<span class="font-semibold text-slate-800 text-sm sm:text-base leading-snug">${item.title || 'Poin list baru'}</span>`;
                            if (item.link) {
                                titleHtml = `<a href="${item.link}" target="_blank" class="hover:text-blue-600 hover:underline transition-colors">${titleHtml}</a>`;
                            }

                            let descItemHtml = item.description ? `<p class="text-xs text-slate-500 mt-1 leading-relaxed">${item.description}</p>` : '';

                            itemsHtml += `<div class="flex items-start gap-3.5 p-3.5 rounded-xl bg-white/70 border border-slate-100 shadow-xs hover:border-blue-200 transition-colors">
                                ${iconHtml}
                                <div class="flex-1 min-w-0">
                                    ${titleHtml}
                                    ${descItemHtml}
                                </div>
                            </div>`;
                        });

                        html += `<div class="max-w-4xl mx-auto">
                            ${headingHtml}
                            ${descHtml}
                            <div class="${gridClass}">
                                ${itemsHtml}
                            </div>
                        </div>`;
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
