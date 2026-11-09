<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $throttleKey = Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());

        // Maksimal 3 kali percobaan gagal -> Kunci form login selama 15 menit (900 detik)
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = ceil($seconds / 60);

            throw ValidationException::withMessages([
                'email' => "Akses login ditangguhkan demi keamanan sistem siber. Terlalu banyak percobaan gagal. Silakan coba kembali dalam {$minutes} menit.",
            ]);
        }

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            // Hitungan penalti 15 menit (900 detik)
            RateLimiter::hit($throttleKey, 900);

            $remaining = RateLimiter::retriesLeft($throttleKey, 3);
            $message = $remaining > 0
                ? "Email atau kata sandi salah. Sisa kesempatan mencoba: {$remaining} kali sebelum akun ditangguhkan 15 menit."
                : 'Email atau kata sandi salah. Batas percobaan habis, akun/IP Anda ditangguhkan selama 15 menit.';

            throw ValidationException::withMessages([
                'email' => __($message),
            ]);
        }

        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}
