@extends('layouts.admin')

@section('title', 'Ubah Data Pengguna')
@section('header_title', 'Ubah Data Pengguna')
@section('header_subtitle', 'Perbarui informasi profil atau hak akses akun pengguna')

@section('header_action')
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 bg-white/80 hover:bg-white text-slate-700 px-4 py-2 rounded-xl text-xs font-bold border border-slate-200/80 shadow-xs transition-all">
        &larr; Kembali
    </a>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-800 text-base">Edit Akun: {{ $user->name }}</h3>
                <p class="text-xs text-slate-500 mt-1">Ubah informasi akun di bawah ini.</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-gradient-to-tr {{ in_array($user->role, ['superadmin', 'admin']) ? 'from-blue-600 to-sky-500' : 'from-indigo-600 to-purple-500' }} text-white font-bold flex items-center justify-center text-sm shadow-xs">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        </div>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6 md:p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Pengguna -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    Nama Lengkap <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                @error('name')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    Alamat Email (Digunakan untuk Login) <span class="text-rose-500">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                @error('email')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role Selection -->
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    Peran &amp; Hak Akses <span class="text-rose-500">*</span>
                </label>
                @php
                    $currentRole = old('role', in_array($user->role, ['superadmin', 'admin']) ? 'superadmin' : 'editor');
                @endphp
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <label class="relative flex flex-col p-4 border rounded-2xl cursor-pointer hover:bg-slate-50 transition-all {{ $currentRole === 'editor' ? 'border-indigo-600 bg-indigo-50/20 ring-1 ring-indigo-600' : 'border-slate-200' }}">
                        <div class="flex items-center gap-2 mb-1.5">
                            <input type="radio" name="role" value="editor" {{ $currentRole === 'editor' ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500">
                            <span class="text-xs font-extrabold text-slate-800">Admin Berita &amp; Konten</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed pl-5">
                            Hanya mengelola Berita, Kategori, Media Library, dan Standar Pelayanan/Dokumen.
                        </p>
                    </label>

                    <label class="relative flex flex-col p-4 border rounded-2xl cursor-pointer hover:bg-slate-50 transition-all {{ $currentRole === 'superadmin' ? 'border-blue-600 bg-blue-50/20 ring-1 ring-blue-600' : 'border-slate-200' }}">
                        <div class="flex items-center gap-2 mb-1.5">
                            <input type="radio" name="role" value="superadmin" {{ $currentRole === 'superadmin' ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500">
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

            <!-- Ganti Password (Opsional) -->
            <div class="pt-4 border-t border-slate-100">
                <div class="mb-3">
                    <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Ubah Kata Sandi (Opsional)</h4>
                    <p class="text-[11px] text-slate-500">Kosongkan jika tidak ingin mengubah kata sandi akun ini.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Kata Sandi Baru</label>
                        <input type="password" name="password" placeholder="Minimal 8 karakter" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                        @error('password')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Ulangi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation" placeholder="Ketik ulang kata sandi baru" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                    </div>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-xs font-bold hover:bg-slate-50 transition-all">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-500/20 transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

