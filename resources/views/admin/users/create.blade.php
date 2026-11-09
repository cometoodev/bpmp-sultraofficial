@extends('layouts.admin')

@section('title', 'Tambah Pengguna Baru')
@section('header_title', 'Tambah Pengguna Baru')
@section('header_subtitle', 'Buat akun administrator baru dan tentukan hak akses peran')

@section('header_action')
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 bg-white/80 hover:bg-white text-slate-700 px-4 py-2 rounded-xl text-xs font-bold border border-slate-200/80 shadow-xs transition-all">
        &larr; Kembali
    </a>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 text-base">Formulir Pendaftaran Akun</h3>
            <p class="text-xs text-slate-500 mt-1">Lengkapi informasi akun di bawah ini dengan benar.</p>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 md:p-8 space-y-6">
            @csrf

            <!-- Nama Pengguna -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    Nama Lengkap <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Ahmad Fauzan, S.Pd." class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                @error('name')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    Alamat Email (Digunakan untuk Login) <span class="text-rose-500">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@bpmp.kemdikbud.go.id" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                @error('email')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role Selection -->
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    Peran &amp; Hak Akses <span class="text-rose-500">*</span>
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <label class="relative flex flex-col p-4 border rounded-2xl cursor-pointer hover:bg-slate-50 transition-all {{ old('role', 'editor') === 'editor' ? 'border-indigo-600 bg-indigo-50/20 ring-1 ring-indigo-600' : 'border-slate-200' }}">
                        <div class="flex items-center gap-2 mb-1.5">
                            <input type="radio" name="role" value="editor" {{ old('role', 'editor') === 'editor' ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500">
                            <span class="text-xs font-extrabold text-slate-800">Admin Berita &amp; Konten</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed pl-5">
                            Hanya mengelola Berita, Kategori, Media Library, dan Standar Pelayanan/Dokumen.
                        </p>
                    </label>

                    <label class="relative flex flex-col p-4 border rounded-2xl cursor-pointer hover:bg-slate-50 transition-all {{ old('role') === 'superadmin' ? 'border-blue-600 bg-blue-50/20 ring-1 ring-blue-600' : 'border-slate-200' }}">
                        <div class="flex items-center gap-2 mb-1.5">
                            <input type="radio" name="role" value="superadmin" {{ old('role') === 'superadmin' ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500">
                            <span class="text-xs font-extrabold text-slate-800">Super Admin / Utama</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed pl-5">
                            Kendali penuh seluruh menu, manajemen pengguna, dan pengaturan sistem.
                        </p>
                    </label>
                </div>
                @error('role')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kata Sandi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Kata Sandi <span class="text-rose-500">*</span>
                    </label>
                    <input type="password" name="password" required placeholder="Minimal 8 karakter" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                    @error('password')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Ulangi Kata Sandi <span class="text-rose-500">*</span>
                    </label>
                    <input type="password" name="password_confirmation" required placeholder="Ketik ulang kata sandi" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-xs font-bold hover:bg-slate-50 transition-all">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-500/20 transition-all">
                    Simpan Akun
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

