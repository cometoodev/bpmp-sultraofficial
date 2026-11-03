<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UltRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UltRequestController extends Controller
{
    /**
     * Tampilkan daftar permohonan layanan ULT.
     */
    public function index(Request $request): View
    {
        $query = UltRequest::query()->latest();

        // Filter tipe layanan
        $activeTab = $request->input('tab', 'all');
        if (in_array($activeTab, ['online', 'tatap_muka', 'keliling'], true)) {
            $query->where('layanan_type', $activeTab);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Pencarian (Nomor Tiket, Nama, Instansi, Kontak)
        if ($request->filled('search')) {
            $keyword = trim($request->input('search'));
            $query->where(function ($q) use ($keyword) {
                $q->where('ticket_number', 'like', "%{$keyword}%")
                    ->orWhere('nama', 'like', "%{$keyword}%")
                    ->orWhere('instansi', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->orWhere('no_hp', 'like', "%{$keyword}%")
                    ->orWhere('kategori', 'like', "%{$keyword}%");
            });
        }

        $requests = $query->paginate(15)->withQueryString();

        // Hitung total counter
        $stats = [
            'all' => UltRequest::count(),
            'online' => UltRequest::where('layanan_type', 'online')->count(),
            'tatap_muka' => UltRequest::where('layanan_type', 'tatap_muka')->count(),
            'keliling' => UltRequest::where('layanan_type', 'keliling')->count(),
            'pending' => UltRequest::where('status', 'pending')->count(),
            'diproses' => UltRequest::where('status', 'diproses')->count(),
            'selesai' => UltRequest::where('status', 'selesai')->count(),
        ];

        return view('admin.ult.index', compact('requests', 'stats', 'activeTab'));
    }

    /**
     * Update status pemrosesan permohonan ULT.
     */
    public function updateStatus(Request $request, UltRequest $ultRequest): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,diproses,selesai,ditolak',
            'catatan_petugas' => 'nullable|string|max:2000',
        ]);

        $ultRequest->update([
            'status' => $validated['status'],
            'catatan_petugas' => $validated['catatan_petugas'] ?? $ultRequest->catatan_petugas,
        ]);

        return back()->with('success', "Status tiket {$ultRequest->ticket_number} berhasil diperbarui menjadi {$ultRequest->status_label}.");
    }

    /**
     * Hapus data permohonan ULT.
     */
    public function destroy(UltRequest $ultRequest): RedirectResponse
    {
        if ($ultRequest->dokumen_path && Storage::disk('public')->exists($ultRequest->dokumen_path)) {
            Storage::disk('public')->delete($ultRequest->dokumen_path);
        }

        $ticket = $ultRequest->ticket_number;
        $ultRequest->delete();

        return back()->with('success', "Permohonan tiket {$ticket} berhasil dihapus.");
    }

    /**
     * Export data permohonan ke format CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $filename = 'rekap_permohonan_ult_'.date('Ymd_His').'.csv';

        $query = UltRequest::query()->latest();
        if ($request->filled('tab') && in_array($request->input('tab'), ['online', 'tatap_muka', 'keliling'], true)) {
            $query->where('layanan_type', $request->input('tab'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $records = $query->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($records) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF"); // UTF-8 BOM

            fputcsv($file, [
                'No',
                'Nomor Tiket',
                'Tipe Layanan',
                'Tanggal Masuk',
                'Nama Pemohon',
                'Instansi',
                'No HP / WhatsApp',
                'Email',
                'Kategori Layanan',
                'Keperluan',
                'Status',
                'Catatan Petugas',
            ]);

            $no = 1;
            foreach ($records as $item) {
                fputcsv($file, [
                    $no++,
                    $item->ticket_number,
                    $item->type_label,
                    $item->created_at->format('d/m/Y H:i'),
                    $item->nama,
                    $item->instansi ?? '-',
                    $item->no_hp,
                    $item->email ?? '-',
                    $item->kategori,
                    $item->keperluan,
                    $item->status_label,
                    $item->catatan_petugas ?? '-',
                ]);
            }

            fclose($file);
        }, 200, $headers);
    }
}
