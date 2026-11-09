<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', Rule::in(['superadmin', 'admin', 'editor'])],
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Email pengguna wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini telah digunakan oleh akun lain.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'role.required' => 'Peran / Hak akses wajib dipilih.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna baru berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', Rule::in(['superadmin', 'admin', 'editor'])],
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Email pengguna wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini telah digunakan oleh akun lain.',
            'password.min' => 'Kata sandi baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'role.required' => 'Peran / Hak akses wajib dipilih.',
        ]);

        // Cegah Super Admin mencabut role superadmin dari dirinya sendiri jika ia adalah satu-satunya super admin
        if ($user->id === Auth::id() && $user->role !== $validated['role'] && ! in_array($validated['role'], ['superadmin', 'admin'])) {
            return back()->with('error', 'Anda tidak dapat mencabut hak akses Super Admin dari akun Anda sendiri.');
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Data akun pengguna berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        // 1. Cegah menghapus akun yang sedang login
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        // 2. Cegah menghapus admin terakhir
        if ($user->isSuperAdmin()) {
            $totalSuperAdmin = User::whereIn('role', ['superadmin', 'admin'])->count();
            if ($totalSuperAdmin <= 1) {
                return back()->with('error', 'Akun tidak dapat dihapus karena merupakan satu-satunya Admin Utama / Super Admin di sistem.');
            }
        }

        // 3. FITUR AMAN DATA: Alihkan relasi konten (berita & media) ke akun Super Admin yang aktif
        $fallbackAdminId = Auth::id();
        Post::where('author_id', $user->id)->update(['author_id' => $fallbackAdminId]);
        Media::where('uploaded_by', $user->id)->update(['uploaded_by' => $fallbackAdminId]);

        // 4. Hapus pengguna dengan aman
        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "Akun '{$userName}' berhasil dihapus. Seluruh data & konten yang pernah dibuat telah dialihkan dengan aman ke Admin Utama.");
    }
}
