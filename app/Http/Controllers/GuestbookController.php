<?php

namespace App\Http\Controllers;

use App\Exports\GuestbookExport;
use App\Imports\SkmImport;
use App\Models\Guestbook;
use App\Models\UltSurveyResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class GuestbookController extends Controller
{
    /**
     * Tampilkan rekap data buku tamu untuk admin dengan filter tahun, triwulan, dan layanan.
     */
    public function index(Request $request): View
    {
        $tahun = $request->input('tahun', date('Y'));
        if ($tahun === '' || $tahun === 'all') {
            $tahun = null;
        } elseif ($tahun !== null) {
            $tahun = (int) $tahun;
        }

        $triwulan = $request->filled('triwulan') && in_array((int) $request->triwulan, [1, 2, 3, 4])
            ? (int) $request->triwulan
            : null;

        $layanan = $request->filled('layanan') && $request->layanan !== 'all'
            ? (string) $request->layanan
            : null;

        $query = Guestbook::with('ultSurveyResponse')->latest();

        if ($tahun) {
            $query->whereYear('created_at', $tahun);
        }

        if ($triwulan) {
            match ($triwulan) {
                1 => $query->whereMonth('created_at', '>=', 1)->whereMonth('created_at', '<=', 3),
                2 => $query->whereMonth('created_at', '>=', 4)->whereMonth('created_at', '<=', 6),
                3 => $query->whereMonth('created_at', '>=', 7)->whereMonth('created_at', '<=', 9),
                4 => $query->whereMonth('created_at', '>=', 10)->whereMonth('created_at', '<=', 12),
                default => null,
            };
        }

        if ($layanan) {
            $query->where('jenis_layanan', $layanan);
        }

        $query->when($request->search, function ($q, $search) {
            $q->where(function ($sub) use ($search) {
                $sub->where('nama', 'like', "%{$search}%")
                    ->orWhere('asal_instansi', 'like', "%{$search}%")
                    ->orWhere('jenis_layanan', 'like', "%{$search}%");
            });
        });

        $rawPerPage = $request->input('per_page', 10);
        if ($rawPerPage === 'all') {
            $perPage = $query->count() > 0 ? $query->count() : 1;
        } else {
            $perPage = (int) $rawPerPage;
            if (! in_array($perPage, [10, 25, 50, 100], true)) {
                $perPage = 10;
            }
        }

        $guestbooks = $query->paginate($perPage)->appends($request->query());

        $availableYears = Guestbook::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->filter()
            ->map(fn ($y) => (int) $y)
            ->values()
            ->toArray();

        if (empty($availableYears)) {
            $availableYears = [(int) date('Y')];
        } elseif (! in_array((int) date('Y'), $availableYears, true)) {
            array_unshift($availableYears, (int) date('Y'));
        }

        $availableServices = Guestbook::select('jenis_layanan')
            ->distinct()
            ->whereNotNull('jenis_layanan')
            ->orderBy('jenis_layanan')
            ->pluck('jenis_layanan')
            ->filter()
            ->values()
            ->toArray();

        $search = $request->input('search');

        $importLogs = Guestbook::whereNotNull('import_batch_id')
            ->select('import_batch_id', DB::raw('count(id) as total'), DB::raw('MAX(created_at) as import_time'))
            ->groupBy('import_batch_id')
            ->orderBy('import_batch_id', 'desc')
            ->get();

        // Cari kelompok data dengan nama & waktu yang persis sama
        $duplicateGroups = Guestbook::select('nama', 'created_at', DB::raw('COUNT(*) as total'))
            ->groupBy('nama', 'created_at')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        $originalIds = [];  // Array untuk 1 data asli (tertua)
        $duplicateIds = []; // Array untuk sisa data duplikat

        foreach ($duplicateGroups as $group) {
            $records = Guestbook::where('nama', $group->nama)
                ->where('created_at', $group->created_at)
                ->orderBy('id', 'asc') // Urutkan dari yang pertama kali masuk
                ->pluck('id')->toArray();

            // Ambil ID pertama sebagai data Asli
            $originalIds[] = array_shift($records);

            // Sisa ID dimasukkan sebagai data Duplikat (yang harus dihapus)
            $duplicateIds = array_merge($duplicateIds, $records);
        }

        $duplicateCount = count($duplicateIds);

        return view('guestbook.index', [
            'guestbooks' => $guestbooks,
            'tahun' => $tahun,
            'triwulan' => $triwulan,
            'layanan' => $layanan,
            'search' => $search,
            'perPage' => $rawPerPage,
            'availableYears' => $availableYears,
            'availableServices' => $availableServices,
            'importLogs' => $importLogs,
            'duplicateCount' => $duplicateCount,
            'originalIds' => $originalIds,
            'duplicateIds' => $duplicateIds,
        ]);
    }

    /**
     * Tampilkan form buku tamu.
     */
    public function create(): View
    {
        return view('guestbook.create');
    }

    /**
     * Simpan data buku tamu dan redirect ke halaman sukses.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'usia' => ['required', 'integer', 'min:1', 'max:120'],
            'telepon' => ['nullable', 'string', 'max:20'],
            'pendidikan' => ['required', 'string', 'max:30'],
            'pekerjaan' => ['required', 'string', 'max:50'],
            'status_kepegawaian' => ['required', 'string', 'max:30'],
            'asal_instansi' => ['required', 'string', 'max:255'],
            'asal_kabupaten' => ['required', 'string', 'max:100'],
            'jenis_layanan' => ['required', 'string', 'max:255'],
        ]);

        $guestbook = Guestbook::create($validated);

        return redirect()->route('guestbook.success', $guestbook->id);
    }

    /**
     * Export rekap data buku tamu (excel, csv, pdf) sesuai filter yang aktif.
     */
    public function export(Request $request, string $type): Response|BinaryFileResponse
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '300');

        $format = strtolower($type);

        $tahun = $request->input('tahun', date('Y'));
        if ($tahun === '' || $tahun === 'all') {
            $tahun = null;
        } elseif ($tahun !== null) {
            $tahun = (int) $tahun;
        }

        $triwulan = $request->filled('triwulan') && in_array((int) $request->triwulan, [1, 2, 3, 4])
            ? (int) $request->triwulan
            : null;

        $layanan = $request->filled('layanan') && $request->layanan !== 'all'
            ? (string) $request->layanan
            : null;

        $query = Guestbook::with('ultSurveyResponse')->latest();

        if ($tahun) {
            $query->whereYear('created_at', $tahun);
        }

        if ($triwulan) {
            match ($triwulan) {
                1 => $query->whereMonth('created_at', '>=', 1)->whereMonth('created_at', '<=', 3),
                2 => $query->whereMonth('created_at', '>=', 4)->whereMonth('created_at', '<=', 6),
                3 => $query->whereMonth('created_at', '>=', 7)->whereMonth('created_at', '<=', 9),
                4 => $query->whereMonth('created_at', '>=', 10)->whereMonth('created_at', '<=', 12),
                default => null,
            };
        }

        if ($layanan) {
            $query->where('jenis_layanan', $layanan);
        }

        $query->when($request->search, function ($q, $search) {
            $q->where(function ($sub) use ($search) {
                $sub->where('nama', 'like', "%{$search}%")
                    ->orWhere('asal_instansi', 'like', "%{$search}%")
                    ->orWhere('jenis_layanan', 'like', "%{$search}%");
            });
        });

        $rawPerPage = $request->input('per_page');
        if ($rawPerPage && $rawPerPage !== 'all') {
            $perPage = (int) $rawPerPage;
            if (! in_array($perPage, [10, 25, 50, 100], true)) {
                $perPage = 10;
            }
            $guestbooks = $query->take($perPage)->get();
        } else {
            $guestbooks = $query->get();
        }

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('exports.guestbook', [
                'guestbooks' => $guestbooks,
                'tahun' => $tahun,
                'triwulan' => $triwulan,
                'layanan' => $layanan,
                'search' => $request->search,
                'perPage' => $rawPerPage,
                'type' => 'pdf',
            ])->setPaper('a4', 'landscape');

            return $pdf->download('Laporan_Buku_Tamu.pdf');
        }

        $fileName = $format === 'csv' ? 'Laporan_Buku_Tamu.csv' : 'Laporan_Buku_Tamu.xlsx';
        $writerType = $format === 'csv' ? \Maatwebsite\Excel\Excel::CSV : \Maatwebsite\Excel\Excel::XLSX;

        return Excel::download(new GuestbookExport($guestbooks), $fileName, $writerType);
    }

    /**
     * Perbarui data buku tamu (koreksi typo / perbaikan informasi).
     */
    public function update(Request $request, int|string $id): RedirectResponse
    {
        $guestbook = Guestbook::findOrFail($id);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'usia' => ['required', 'integer', 'min:1', 'max:120'],
            'asal_instansi' => ['required', 'string', 'max:255'],
            'jenis_layanan' => ['required', 'string', 'max:255'],
            'pekerjaan' => ['nullable', 'string', 'max:50'],
            'telepon' => ['nullable', 'string', 'max:20'],
            'pendidikan' => ['nullable', 'string', 'max:30'],
            'status_kepegawaian' => ['nullable', 'string', 'max:30'],
            'asal_kabupaten' => ['nullable', 'string', 'max:100'],
        ]);

        $guestbook->update($validated);

        return back()->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Hapus satu data buku tamu beserta data survei SKM terkait.
     */
    public function destroy(int|string $id): RedirectResponse
    {
        $guestbook = Guestbook::findOrFail($id);
        UltSurveyResponse::where('guestbook_id', $guestbook->id)->delete();
        $guestbook->delete();

        // Redirect kembali ke URL sebelumnya secara persis (termasuk query parameters ?search=...&per_page=...)
        return redirect()->to(url()->previous())->with('success', 'Data pengunjung berhasil dihapus.');
    }

    /**
     * Import data buku tamu dan kuisioner SKM dari file Excel / CSV.
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,csv,xls',
        ]);

        try {
            $batchId = 'IMPORT-'.date('Ymd-His');
            $import = new SkmImport($batchId);

            Excel::import($import, $request->file('file_excel'));

            // Buat pesan feedback yang sangat informatif
            $msg = "Proses Selesai! {$import->importedCount} data baru berhasil ditambahkan.";
            if ($import->skippedCount > 0) {
                $msg .= " Terdapat {$import->skippedCount} data yang DILEWATI karena terdeteksi sebagai duplikat.";
            }

            return back()->with('success', $msg);
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal memproses file import: '.$e->getMessage());
        }
    }

    /**
     * Batalkan dan hapus data hasil import untuk batch tertentu.
     */
    public function undoImport(Request $request): RedirectResponse
    {
        $batchId = $request->import_batch_id;
        $guestbooks = Guestbook::where('import_batch_id', $batchId)->get();
        UltSurveyResponse::whereIn('guestbook_id', $guestbooks->pluck('id'))->delete();
        Guestbook::where('import_batch_id', $batchId)->delete();

        return redirect()->route('admin.guestbook.index')
            ->with('success', "Data import untuk sesi {$batchId} berhasil dibatalkan/dihapus.");
    }

    /**
     * Reset / kosongkan seluruh data buku tamu dan kuisioner SKM.
     */
    public function resetData(): RedirectResponse
    {
        UltSurveyResponse::query()->delete();
        Guestbook::query()->delete();

        return redirect()->route('admin.guestbook.index')
            ->with('success', 'Semua data Buku Tamu dan SKM berhasil dikosongkan.');
    }

    /**
     * Cek dan hitung data duplikat (AJAX / JSON response).
     */
    public function checkDuplicates(): JsonResponse
    {
        $duplicateGroups = Guestbook::select('nama', 'created_at', DB::raw('MIN(id) as keep_id'))
            ->groupBy('nama', 'created_at')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        $duplicateIds = [];
        foreach ($duplicateGroups as $group) {
            $ids = Guestbook::where('nama', $group->nama)
                ->where('created_at', $group->created_at)
                ->where('id', '!=', $group->keep_id)
                ->pluck('id')
                ->all();
            $duplicateIds = array_merge($duplicateIds, $ids);
        }

        return response()->json([
            'count' => count($duplicateIds),
            'duplicate_ids' => $duplicateIds,
        ]);
    }

    /**
     * Bersihkan data duplikat secara otomatis (menyisakan 1 data asli terlama).
     */
    public function cleanDuplicates(): RedirectResponse
    {
        $duplicateGroups = Guestbook::select('nama', 'created_at', DB::raw('COUNT(*) as total'))
            ->groupBy('nama', 'created_at')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        $idsToClean = [];
        foreach ($duplicateGroups as $group) {
            $records = Guestbook::where('nama', $group->nama)
                ->where('created_at', $group->created_at)
                ->orderBy('id', 'asc')
                ->pluck('id')
                ->toArray();

            array_shift($records); // Buang 1 ID pertama (sebagai data asli/original)
            $idsToClean = array_merge($idsToClean, $records);
        }

        if (! empty($idsToClean)) {
            UltSurveyResponse::whereIn('guestbook_id', $idsToClean)->delete();
            Guestbook::whereIn('id', $idsToClean)->delete();
        }

        return back()->with('success', count($idsToClean).' data duplikat berhasil dibersihkan!');
    }

    /**
     * Alias untuk backward compatibility.
     */
    public function removeDuplicates(): RedirectResponse
    {
        return $this->cleanDuplicates();
    }
}
