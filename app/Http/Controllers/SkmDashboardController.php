<?php

namespace App\Http\Controllers;

use App\Exports\SkmExport;
use App\Imports\SkmImport;
use App\Models\Guestbook;
use App\Models\UltSurveyResponse;
use App\Services\UltSkmService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SkmDashboardController extends Controller
{
    public function __construct(private readonly UltSkmService $skmService) {}

    /**
     * Dashboard Analitik SKM ULT BPMP Sultra dengan filter tahun, triwulan, dan layanan.
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

        $search = $request->filled('search') ? (string) $request->search : null;

        $query = Guestbook::with('ultSurveyResponse')->latest();
        $this->skmService->applyFilters($query, $tahun, $triwulan, $layanan, '', $search);

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

        // Sinkronisasi Tabel Akumulasi IKM agar hanya menghitung dari data yang sedang tertampil
        $data = $this->skmService->getDashboardData($tahun, $triwulan, $layanan, $search, $guestbooks->items());

        $allIkmPerLayanan = $data['ikmPerLayanan'];
        $currentPage = Paginator::resolveCurrentPage('layanan_page');
        $perPageLayanan = $rawPerPage === 'all' ? (count($allIkmPerLayanan) ?: 1) : $perPage;
        $collection = collect($allIkmPerLayanan);
        $ikmSlice = $collection->slice(($currentPage - 1) * $perPageLayanan, $perPageLayanan)->values();
        $ikmPaginator = new LengthAwarePaginator(
            $ikmSlice,
            $collection->count(),
            $perPageLayanan,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
                'pageName' => 'layanan_page',
            ]
        );

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

        // Standardized SKM calculation per PERMENPAN RB No. 14 Tahun 2017
        $surveyResponses = $this->skmService->getResponses($tahun, $triwulan, $layanan, $search);
        $skm = $this->skmService->calculateSkm($surveyResponses);

        $total_responden = $skm['total_responden'];
        $nrr_per_unsur = $skm['nrr_per_unsur'];
        $nilai_ikm = $skm['nilai_ikm'];
        $nilai_konversi = $skm['nilai_konversi'];
        $mutu = $skm['mutu'];
        $kinerja = $skm['kinerja'];
        $unsur_terbaik = $skm['unsur_terbaik'];
        $unsur_terendah = $skm['unsur_terendah'];

        $demographics = $data['demographics'];
        $ikmPerUnsur = $data['ikmPerUnsur'];
        $totalIkm = $nilai_konversi;
        $totalNrt = $nilai_ikm;
        $mutuLayanan = $data['mutuLayanan'];
        $ikmPerLayanan = $ikmPaginator;

        return view('admin.skm.dashboard', compact(
            'total_responden',
            'nrr_per_unsur',
            'nilai_ikm',
            'nilai_konversi',
            'mutu',
            'kinerja',
            'unsur_terbaik',
            'unsur_terendah',
            'demographics',
            'ikmPerUnsur',
            'totalIkm',
            'mutuLayanan',
            'ikmPerLayanan',
            'allIkmPerLayanan',
            'totalNrt',
            'guestbooks',
            'perPage',
            'duplicateCount',
            'originalIds',
            'duplicateIds',
            'tahun',
            'triwulan',
            'layanan',
            'search',
            'availableYears',
            'availableServices',
            'importLogs'
        ));
    }

    /**
     * Export rekap analitik SKM (excel, csv, pdf) sesuai filter yang aktif.
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

        $search = $request->filled('search') ? (string) $request->search : null;

        $query = Guestbook::with('ultSurveyResponse')->latest();
        $this->skmService->applyFilters($query, $tahun, $triwulan, $layanan, '', $search);

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

        // Sinkronisasi Tabel Akumulasi IKM agar hanya menghitung dari data yang diekspor
        $data = $this->skmService->getDashboardData($tahun, $triwulan, $layanan, $search, $guestbooks);

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('exports.skm', [
                'demographics' => $data['demographics'],
                'ikmPerUnsur' => $data['ikmPerUnsur'],
                'totalIkm' => $data['totalIkm'],
                'mutuLayanan' => $data['mutuLayanan'],
                'ikmPerLayanan' => $data['ikmPerLayanan'],
                'totalNrt' => $data['totalNrt'],
                'nilai_konversi' => $data['totalIkm'],
                'mutu' => $data['mutuLayanan']['grade'],
                'kinerja' => $data['mutuLayanan']['label'],
                'guestbooks' => $guestbooks,
                'perPage' => $rawPerPage,
                'type' => 'pdf',
                'tahun' => $tahun,
                'triwulan' => $triwulan,
                'layanan' => $layanan,
                'search' => $search,
            ])->setPaper('a4', 'portrait');

            return $pdf->download('Laporan_SKM_BPMP_Sultra.pdf');
        }

        $fileName = $format === 'csv' ? 'Laporan_SKM_BPMP_Sultra.csv' : 'Laporan_SKM_BPMP_Sultra.xlsx';
        $writerType = $format === 'csv' ? \Maatwebsite\Excel\Excel::CSV : \Maatwebsite\Excel\Excel::XLSX;

        return Excel::download(
            new SkmExport($guestbooks),
            $fileName,
            $writerType
        );
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

        return back()->with('success', "Data import untuk sesi {$batchId} berhasil dibatalkan/dihapus.");
    }

    /**
     * Reset / kosongkan seluruh data buku tamu dan kuisioner SKM.
     */
    public function resetData(): RedirectResponse
    {
        UltSurveyResponse::query()->delete();
        Guestbook::query()->delete();

        return back()->with('success', 'Semua data Buku Tamu dan SKM berhasil dikosongkan.');
    }
}
