<?php

namespace App\Http\Controllers;

use App\Models\GratificationReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GratificationController extends Controller
{
    /**
     * Menyimpan data formulir multi-step Lapor Gratifikasi dari publik.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'activity_name' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'activity_location' => 'required|string|max:255',
            'evidence_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240', // Maksimal 10MB
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'name.required' => 'Nama pegawai wajib diisi.',
            'position.required' => 'Jabatan wajib diisi.',
            'activity_name.required' => 'Nama kegiatan wajib diisi.',
            'activity_date.required' => 'Tanggal kegiatan wajib diisi.',
            'activity_location.required' => 'Tempat kegiatan wajib diisi.',
            'evidence_file.mimes' => 'Format file bukti harus berupa PDF, JPG, JPEG, atau PNG.',
            'evidence_file.max' => 'Ukuran file bukti maksimal 10 MB.',
        ]);

        $filePath = null;
        if ($request->hasFile('evidence_file')) {
            $filePath = $request->file('evidence_file')->store('gratification-evidences', 'public');
        }

        GratificationReport::create([
            'email' => $request->email,
            'name' => $request->name,
            'nip' => $request->nip ?: '0',
            'position' => $request->position,
            'activity_name' => $request->activity_name,
            'activity_date' => $request->activity_date,
            'activity_location' => $request->activity_location,
            'free_services' => json_encode($request->free_services ?? []),
            'service_date' => $request->service_date,
            'service_provider_name' => $request->service_provider_name ?: '0',
            'service_provider_position' => $request->service_provider_position ?: '0',
            'gift_consumable_types' => json_encode($request->gift_consumable_types ?? []),
            'gift_non_consumable_desc' => $request->gift_non_consumable_desc ?: 'tidak menerima',
            'gift_giver_name' => $request->gift_giver_name,
            'gift_giver_position' => $request->gift_giver_position,
            'gift_received_date' => $request->gift_received_date,
            'follow_up_action' => $request->follow_up_action,
            'evidence_file' => $filePath,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Laporan Pengendalian Gratifikasi berhasil dikirimkan! Terima kasih atas komitmen Anda mendukung integritas lembaga.');
    }

    /**
     * Menampilkan daftar rekapitulasi laporan gratifikasi di Admin CMS.
     */
    public function index(Request $request): View
    {
        $query = GratificationReport::query()->latest();

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('activity_name', 'like', "%{$search}%")
                    ->orWhere('activity_location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => GratificationReport::count(),
            'pending' => GratificationReport::where('status', 'pending')->count(),
            'verified' => GratificationReport::where('status', 'verified')->count(),
            'recorded' => GratificationReport::where('status', 'recorded')->count(),
        ];

        return view('admin.gratification.index', compact('reports', 'stats'));
    }

    /**
     * Menampilkan detail lengkap laporan gratifikasi di Admin CMS.
     */
    public function show(int|string $id): View
    {
        $report = GratificationReport::findOrFail($id);

        return view('admin.gratification.show', compact('report'));
    }

    /**
     * Memperbarui status verifikasi laporan gratifikasi.
     */
    public function updateStatus(Request $request, int|string $id): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,verified,recorded',
        ]);

        $report = GratificationReport::findOrFail($id);
        $report->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status laporan gratifikasi berhasil diperbarui!');
    }

    /**
     * Menghapus data laporan gratifikasi di Admin CMS beserta file bukti fisik.
     */
    public function destroy(int|string $id): RedirectResponse
    {
        $report = GratificationReport::findOrFail($id);

        if ($report->evidence_file && Storage::disk('public')->exists($report->evidence_file)) {
            Storage::disk('public')->delete($report->evidence_file);
        }

        $report->delete();

        return redirect()->route('admin.gratification.index')->with('success', 'Data laporan gratifikasi berhasil dihapus.');
    }
}
