@extends('layouts.admin')

@section('title', 'Media Library')
@section('header_title', 'Media Library')
@section('header_subtitle', 'Kelola berkas media, gambar, dan dokumen website')

@section('header_action')
    <button type="button" @click="$dispatch('open-upload-modal')" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-md transition-all inline-flex items-center gap-1.5 cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
        <span>+ Unggah File</span>
    </button>
@endsection

@section('content')
<div class="space-y-6" x-data="{ 
    uploadModalOpen: false, 
    copyToClipboard(text) { 
        navigator.clipboard.writeText(text).then(() => { 
            alert('URL disalin ke clipboard!'); 
        }); 
    } 
}" @open-upload-modal.window="uploadModalOpen = true">

    @error('file')
        <div class="bg-red-50 text-red-700 p-4 rounded-xl text-sm font-medium border border-red-100 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ $message }}
        </div>
    @enderror

    <!-- Media Grid -->
    @if($media->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center text-slate-500 shadow-xs">
            <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <p class="font-medium text-slate-600">Belum ada file media yang diunggah.</p>
            <p class="text-sm mt-1">Klik tombol "Unggah File" untuk memulai.</p>
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($media as $item)
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-xs hover:shadow-md transition-shadow group relative flex flex-col">
                    <div class="h-32 bg-slate-100 flex items-center justify-center overflow-hidden relative">
                        @if(Str::startsWith($item->mime_type, 'image/'))
                            <img src="{{ Storage::url($item->path) }}" alt="{{ $item->filename }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        @endif

                        <!-- Hover overlay -->
                        <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                            <button @click="copyToClipboard('{{ url(Storage::url($item->path)) }}')" class="p-2 bg-white text-slate-800 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors tooltip" title="Salin URL">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            </button>
                            <a href="{{ Storage::url($item->path) }}" target="_blank" class="p-2 bg-white text-slate-800 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors tooltip" title="Buka File">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </a>
                            <form action="{{ route('admin.media.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus file ini permanen?');" class="inline-block">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 bg-white text-slate-800 rounded-lg hover:bg-red-50 hover:text-red-600 transition-colors tooltip" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="p-2.5 border-t border-slate-100 flex-grow flex flex-col justify-between">
                        <p class="text-[11px] font-semibold text-slate-700 truncate mb-1" title="{{ $item->filename }}">{{ $item->filename }}</p>
                        <p class="text-[10px] text-slate-500 uppercase">{{ round($item->size / 1024, 1) }} KB</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $media->links() }}
        </div>
    @endif

    <!-- Upload Modal -->
    <div x-show="uploadModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-0" style="display: none;">
        <div x-show="uploadModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="uploadModalOpen = false"></div>

        <div x-show="uploadModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg mx-auto border border-slate-200 overflow-hidden">
            
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-800">Unggah File Media</h3>
                <button @click="uploadModalOpen = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <div class="relative w-full h-40 rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 hover:bg-slate-100 transition-colors flex flex-col items-center justify-center">
                    <input type="file" name="file" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" id="file-upload">
                    
                    <div class="text-center pointer-events-none">
                        <svg class="mx-auto h-10 w-10 text-slate-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                        <p class="text-sm font-medium text-slate-700">Pilih File</p>
                        <p class="text-xs text-slate-500 mt-1">PNG, JPG, PDF, DOCX (Maks 5MB)</p>
                    </div>
                </div>

                <!-- Display selected filename -->
                <p id="file-name-display" class="mt-3 text-sm text-blue-600 font-medium text-center truncate"></p>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="uploadModalOpen = false" class="px-5 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-colors">Mulai Unggah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('file-upload').addEventListener('change', function(e) {
        var fileName = e.target.files[0] ? e.target.files[0].name : '';
        document.getElementById('file-name-display').textContent = fileName;
    });
</script>
@endpush
