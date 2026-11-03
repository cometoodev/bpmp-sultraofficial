@extends('layouts.admin')

@section('title', 'Standar Pelayanan')
@section('header_title', 'Standar Pelayanan')
@section('header_subtitle', 'Kelola daftar dokumen Standar Pelayanan publik (PDF) secara dinamis')

@section('content')
<div class="space-y-8" x-data="{ 
    showModal: false, 
    pdfTitle: '', 
    pdfUrl: '', 
    fileInfo: '',
    openModal(title, url, info) {
        this.pdfTitle = title;
        this.pdfUrl = url;
        this.fileInfo = info;
        this.showModal = true;
    }
}">

    <!-- FORM UPLOAD DOKUMEN BARU (Glassmorphic Card) -->
    <div class="bg-white/70 backdrop-blur-xl rounded-[2.5rem] shadow-lg border border-white p-6 sm:p-8 relative overflow-hidden">
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-indigo-400/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-800">Unggah Dokumen Standar Pelayanan</h2>
                    <p class="text-xs text-slate-500">Pilih file PDF, sistem backend akan otomatis mencatat ukuran file (KB/MB) dan waktu unggah.</p>
                </div>
            </div>

            <form action="{{ route('admin.standar-pelayanan.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-12 gap-5 items-end">
                @csrf

                <!-- Judul Dokumen -->
                <div class="md:col-span-6 space-y-1.5">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Judul Dokumen <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Standar Pelayanan Permohonan Informasi"
                        class="w-full bg-white/80 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 outline-none shadow-sm text-slate-800 font-medium">
                    @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- File PDF -->
                <div class="md:col-span-4 space-y-1.5">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">File Dokumen PDF <span class="text-red-500">*</span></label>
                    <input type="file" name="pdf_file" accept=".pdf,application/pdf" required
                        class="w-full bg-white/80 border border-slate-200 rounded-xl px-3 py-2.5 text-xs focus:ring-2 focus:ring-indigo-500 outline-none shadow-sm text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    @error('pdf_file') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Tombol Submit -->
                <div class="md:col-span-2">
                    <button type="submit" class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold shadow-md shadow-indigo-600/20 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        <span>Unggah</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- DAFTAR DOKUMEN STANDAR PELAYANAN SAAT INI -->
    <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-lg border border-white p-6 sm:p-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 pb-4 border-b border-slate-100">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Daftar Dokumen Standar Pelayanan Aktif</h3>
                <p class="text-xs text-slate-500">Tampil otomatis pada halaman publik <code>/standar-pelayanan</code></p>
            </div>
            <span class="px-3.5 py-1.5 rounded-full bg-indigo-50 text-indigo-700 font-bold text-xs border border-indigo-100 flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                Total: {{ $dokumens->count() }} Dokumen
            </span>
        </div>

        @if($dokumens->isEmpty())
            <div class="py-16 text-center text-slate-400">
                <svg class="w-16 h-16 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <p class="font-medium">Belum ada dokumen standar pelayanan yang diunggah.</p>
                <p class="text-xs text-slate-400 mt-1">Gunakan formulir di atas untuk mengunggah dokumen baru.</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach($dokumens as $index => $item)
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 hover:border-indigo-200 hover:shadow-md transition-all">
                        <div class="flex items-center gap-4 flex-1">
                            <span class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 font-bold text-xs flex items-center justify-center shrink-0">
                                {{ $index + 1 }}
                            </span>
                            <div class="w-11 h-11 rounded-xl bg-red-50 text-red-600 flex items-center justify-center font-extrabold text-xs shrink-0 border border-red-100">
                                PDF
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm md:text-base leading-snug">{{ $item->title }}</h4>
                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-500 mt-1">
                                    <span class="flex items-center gap-1 font-medium">
                                        📅 {{ \Carbon\Carbon::parse($item->uploaded_at)->translatedFormat('d F Y') }}
                                    </span>
                                    <span>•</span>
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 font-mono text-[11px] font-semibold">
                                        📁 {{ $item->file_size }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 self-end md:self-center">
                            <!-- Preview Button -->
                            <button @click="openModal('{{ $item->title }}', '{{ $item->file_path }}', 'Diperbarui: {{ \Carbon\Carbon::parse($item->uploaded_at)->translatedFormat('d M Y') }} • {{ $item->file_size }}')"
                                class="px-3.5 py-2 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white font-bold text-xs transition-all flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <span>Preview</span>
                            </button>

                            <!-- Direct Link / Download -->
                            <a href="{{ $item->file_path }}" target="_blank"
                                class="px-3.5 py-2 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 font-bold text-xs transition-all flex items-center gap-1.5" title="Buka File di Tab Baru">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>

                            <!-- Delete Form -->
                            <form action="{{ route('admin.standar-pelayanan.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini? File PDF juga akan dihapus dari server.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all" title="Hapus Dokumen">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- MODAL POP-UP PREVIEW PDF (Dark Mode Elegan) -->
    <template x-teleport="body">
        <div x-show="showModal" class="fixed inset-0 z-[999] flex items-center justify-center p-4 sm:p-6" style="display: none;">
            <div x-show="showModal" x-transition.opacity class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm" @click="showModal = false"></div>
            
            <div x-show="showModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-8"
                 class="relative bg-[#1e2329] rounded-2xl shadow-2xl w-full max-w-5xl h-[85vh] flex flex-col overflow-hidden border border-slate-700">
                
                <!-- Header Modal -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 border-b border-slate-700/50 bg-[#161b22] gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-indigo-500/20 text-indigo-400 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-100 text-sm md:text-base" x-text="pdfTitle"></h4>
                            <p class="text-xs text-slate-400 mt-0.5" x-text="fileInfo"></p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <a :href="pdfUrl" target="_blank" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-emerald-600 text-white hover:bg-emerald-500 transition-colors text-xs font-bold shadow-lg shadow-emerald-900/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Download
                        </a>
                        <button @click="showModal = false" class="w-9 h-9 ml-2 flex items-center justify-center rounded-lg bg-slate-800 text-slate-400 hover:bg-red-500/20 hover:text-red-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
                
                <!-- Body Modal (Iframe PDF Viewer) -->
                <div class="flex-grow bg-[#525659] w-full relative">
                    <template x-if="showModal">
                        <iframe :src="pdfUrl" class="absolute inset-0 w-full h-full border-0" allow="autoplay"></iframe>
                    </template>
                </div>
            </div>
        </div>
    </template>

</div>
@endsection

