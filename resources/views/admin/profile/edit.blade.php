@extends('layouts.admin')

@section('title', 'Profil & Kredensial Akun')
@section('header_title', 'Profil & Kredensial Akun')
@section('header_subtitle', 'Kelola informasi nama pengguna, email login, dan perbarui kata sandi akun Anda')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <!-- Header Profil Singkat -->
        <div class="p-6 md:p-8 bg-gradient-to-r from-blue-600 to-indigo-700 text-white flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-md border border-white/30 text-white font-extrabold text-2xl flex items-center justify-center shadow-lg">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold">{{ $user->name }}</h2>
                    <p class="text-xs text-blue-100 font-mono mt-0.5">{{ $user->email }}</p>
                    <div class="mt-2 flex items-center gap-2">
                        @if(in_array($user->role, ['superadmin', 'admin']))
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-white/20 text-white backdrop-blur-xs">
                                Super Admin / Utama
                            </span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-white/20 text-white backdrop-blur-xs">
                                Admin Berita &amp; Konten (Editor)
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST" class="p-6 md:p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Informasi Akun -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2">
                    Informasi Akun &amp; Identitas
                </h3>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                    @error('name')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Email Login (Username Akun)</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block p-3">
                    @error('email')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Ganti Password -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div>
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Perbarui Kata Sandi</h3>
                    <p class="text-[11px] text-slate-500">Kosongkan jika Anda tidak bermaksud mengganti kata sandi.</p>
                </div>

                <div class="space-y-1.5 bg-amber-50/60 border border-amber-100 rounded-xl p-3.5">
                    <label class="block text-xs font-bold text-amber-900">Kata Sandi Saat Ini</label>
                    <input type="password" name="current_password" placeholder="Masukkan kata sandi lama Anda untuk verifikasi" class="w-full bg-white border border-amber-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 block p-3">
                    <p class="text-[10px] text-amber-700/80 mt-1">Wajib diisi jika Anda mengubah email atau ingin menetapkan kata sandi baru.</p>
                    @error('current_password')
                        <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
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
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-500/20 transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

