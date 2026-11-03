<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Menyimpan data pesan kontak dan mengirimkan notifikasi email ke instansi.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'subject.required' => 'Subjek pesan wajib diisi.',
            'subject.max' => 'Subjek pesan maksimal 255 karakter.',
            'message.required' => 'Uraian isi pesan wajib diisi.',
            'message.max' => 'Isi pesan maksimal 5000 karakter.',
        ]);

        // 1. Simpan ke Database
        ContactMessage::create($validated);

        // 2. Kirim Notifikasi Email ke Instansi / Email Penanggung Jawab
        try {
            $targetEmail = config('mail.from.address', 'bpmpsultra@kemendikdasmen.go.id');
            Mail::to($targetEmail)->send(new ContactMessageMail($validated));
        } catch (\Throwable $e) {
            Log::warning('Notifikasi email pesan kontak gagal dikirim: '.$e->getMessage());
        }

        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim dan diteruskan ke email instansi!');
    }

    /**
     * Menampilkan daftar pesan masuk di panel admin CMS.
     */
    public function index(Request $request): View
    {
        $query = ContactMessage::query()->latest();

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $messages = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => ContactMessage::count(),
            'today' => ContactMessage::whereDate('created_at', today())->count(),
            'this_month' => ContactMessage::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
        ];

        return view('admin.contacts.index', compact('messages', 'stats'));
    }

    /**
     * Menghapus pesan masuk dari panel admin CMS.
     */
    public function destroy(int|string $id): RedirectResponse
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Pesan berhasil dihapus.');
    }
}
