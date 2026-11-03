<?php

namespace App\Http\Controllers;

use App\Models\SpmbReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SpmbAdminController extends Controller
{
    /**
     * Menyimpan data pengaduan dari formulir publik SPMB.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:25',
            'address' => 'required|string',
            'message' => 'required|string',
            'evidence_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'phone.required' => 'Nomor HP / WhatsApp wajib diisi.',
            'phone.max' => 'Nomor HP / WhatsApp maksimal 25 karakter.',
            'address.required' => 'Alamat Anda wajib diisi.',
            'message.required' => 'Uraian isi pengaduan wajib diisi.',
            'evidence_file.mimes' => 'File bukti harus berformat PDF, JPG, JPEG, atau PNG.',
            'evidence_file.max' => 'Ukuran file bukti lampiran maksimal 5 MB.',
        ]);

        $filePath = null;
        if ($request->hasFile('evidence_file')) {
            $filePath = $request->file('evidence_file')->store('spmb-evidences', 'public');
        }

        SpmbReport::create([
            'category' => $request->input('category', 'spmb'),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'message' => $request->message,
            'evidence_file' => $filePath,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Pengaduan Anda berhasil dikirim! Tim BPMP Provinsi Sulawesi Tenggara akan segera menindaklanjuti laporan Anda.');
    }

    /**
     * Menampilkan daftar pengaduan masyarakat di panel admin CMS.
     */
    public function index(Request $request): View
    {
        $query = SpmbReport::query()->latest();

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => SpmbReport::count(),
            'pending' => SpmbReport::where('status', 'pending')->count(),
            'processed' => SpmbReport::where('status', 'processed')->count(),
            'completed' => SpmbReport::where('status', 'completed')->count(),
        ];

        return view('admin.spmb.index', compact('reports', 'stats'));
    }

    /**
     * Menampilkan rincian detail pengaduan.
     */
    public function show(int|string $id): View
    {
        $report = SpmbReport::findOrFail($id);

        return view('admin.spmb.show', compact('report'));
    }

    /**
     * Memperbarui status penanganan pengaduan.
     */
    public function updateStatus(Request $request, int|string $id): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,processed,completed',
        ]);

        $report = SpmbReport::findOrFail($id);
        $report->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui!');
    }

    /**
     * Menghapus data pengaduan beserta file bukti lampiran.
     */
    public function destroy(int|string $id): RedirectResponse
    {
        $report = SpmbReport::findOrFail($id);

        if ($report->evidence_file && Storage::disk('public')->exists($report->evidence_file)) {
            Storage::disk('public')->delete($report->evidence_file);
        }

        $report->delete();

        return redirect()->route('admin.spmb.index')->with('success', 'Data pengaduan berhasil dihapus.');
    }
}
