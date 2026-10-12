<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SurveyTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\SurveyResponseImport;
use App\Models\Survey;
use App\Services\SkmCalculationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SurveyController extends Controller
{
    public function __construct(
        protected SkmCalculationService $skmService
    ) {}

    /**
     * Tampilkan daftar periode survei kepuasan masyarakat di CMS Admin.
     */
    public function index(Request $request): View
    {
        $query = Survey::withCount('responses');

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->q.'%')
                    ->orWhere('period', 'like', '%'.$request->q.'%')
                    ->orWhere('year', 'like', '%'.$request->q.'%');
            });
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $surveys = $query->orderBy('year', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $activeSurvey = Survey::where('is_active', true)->first();

        $stats = [
            'total_surveys' => Survey::count(),
            'total_respondents' => (int) Survey::sum('total_respondents'),
            'average_score' => round((float) (Survey::avg('ikm_score') ?? 0), 2),
            'active_period' => $activeSurvey ? "{$activeSurvey->period} {$activeSurvey->year}" : 'Belum Ditentukan',
        ];

        $availableYears = Survey::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');

        return view('admin.surveys.index', compact('surveys', 'activeSurvey', 'stats', 'availableYears'));
    }

    /**
     * Form unggah Excel dan tambah periode survei baru.
     */
    public function create(): View
    {
        return view('admin.surveys.create');
    }

    /**
     * Tangani pengisian data SKM (baik input manual per triwulan maupun import file Excel).
     */
    public function store(Request $request): RedirectResponse
    {
        $isExcel = $request->input('entry_type') === 'excel' || $request->hasFile('file');

        if ($isExcel) {
            $request->validate([
                'title' => 'required|string|max:255',
                'period' => 'required|string|max:100',
                'year' => 'required|integer|min:2000|max:2099',
                'description' => 'nullable|string',
                'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
                'is_active' => 'nullable|boolean',
            ], [
                'file.required' => 'File Excel kuesioner wajib diunggah.',
                'file.mimes' => 'Format file harus berupa Excel (.xlsx, .xls) atau CSV (.csv).',
                'file.max' => 'Ukuran file maksimal 10 MB.',
            ]);

            $shouldBeActive = $request->boolean('is_active') || Survey::where('is_active', true)->doesntExist();

            if ($shouldBeActive) {
                Survey::where('is_active', true)->update(['is_active' => false]);
            }

            $survey = Survey::create([
                'title' => $request->input('title'),
                'period' => $request->input('period'),
                'year' => (int) $request->input('year'),
                'description' => $request->input('description'),
                'is_active' => $shouldBeActive,
            ]);

            // 1. Import Data Responden ke MySQL via Maatwebsite/Laravel-Excel
            $import = new SurveyResponseImport($survey->id);
            Excel::import($import, $request->file('file'));

            // 2. Hitung Nilai SKM Permenpan RB No 14 Tahun 2017
            $this->skmService->recalculateAndSave($survey);

            $warning = '';
            if (! empty($import->getImportErrors())) {
                $warning = ' Namun terdapat beberapa baris yang diabaikan karena format tidak valid: '.count($import->getImportErrors()).' baris.';
            }

            return redirect()->route('admin.surveys.show', $survey)
                ->with('success', "Data survei berhasil diimpor ({$import->getImportedCount()} responden). Nilai SKM berhasil dihitung: {$survey->ikm_score} ({$survey->ikm_performance_category}).{$warning}");
        }

        // Pengisian Manual per Triwulan
        $request->validate([
            'title' => 'required|string|max:255',
            'period' => 'required|string|max:100',
            'year' => 'required|integer|min:2000|max:2099',
            'total_respondents' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'u1' => 'required|numeric|min:1|max:4',
            'u2' => 'required|numeric|min:1|max:4',
            'u3' => 'required|numeric|min:1|max:4',
            'u4' => 'required|numeric|min:1|max:4',
            'u5' => 'required|numeric|min:1|max:4',
            'u6' => 'required|numeric|min:1|max:4',
            'u7' => 'required|numeric|min:1|max:4',
            'u8' => 'required|numeric|min:1|max:4',
            'u9' => 'required|numeric|min:1|max:4',
        ], [
            'total_respondents.required' => 'Jumlah responden survei wajib diisi.',
            'u1.required' => 'Nilai Unsur 1 (Persyaratan) wajib diisi.',
            'u2.required' => 'Nilai Unsur 2 (Prosedur) wajib diisi.',
            'u3.required' => 'Nilai Unsur 3 (Waktu Pelayanan) wajib diisi.',
            'u4.required' => 'Nilai Unsur 4 (Biaya/Tarif) wajib diisi.',
            'u5.required' => 'Nilai Unsur 5 (Produk Pelayanan) wajib diisi.',
            'u6.required' => 'Nilai Unsur 6 (Kompetensi) wajib diisi.',
            'u7.required' => 'Nilai Unsur 7 (Perilaku) wajib diisi.',
            'u8.required' => 'Nilai Unsur 8 (Penanganan Pengaduan) wajib diisi.',
            'u9.required' => 'Nilai Unsur 9 (Sarana & Prasarana) wajib diisi.',
        ]);

        $shouldBeActive = $request->boolean('is_active') || Survey::where('is_active', true)->doesntExist();

        if ($shouldBeActive) {
            Survey::where('is_active', true)->update(['is_active' => false]);
        }

        $nrrInput = [
            'u1' => (float) $request->input('u1'),
            'u2' => (float) $request->input('u2'),
            'u3' => (float) $request->input('u3'),
            'u4' => (float) $request->input('u4'),
            'u5' => (float) $request->input('u5'),
            'u6' => (float) $request->input('u6'),
            'u7' => (float) $request->input('u7'),
            'u8' => (float) $request->input('u8'),
            'u9' => (float) $request->input('u9'),
        ];

        $calc = $this->skmService->calculateFromNrr($nrrInput, (int) $request->input('total_respondents'));

        $survey = Survey::create([
            'title' => $request->input('title'),
            'period' => $request->input('period'),
            'year' => (int) $request->input('year'),
            'description' => $request->input('description'),
            'is_active' => $shouldBeActive,
            'total_respondents' => $calc['total_respondents'],
            'nrr_elements' => $calc['nrr_elements'],
            'nrt_elements' => $calc['nrt_elements'],
            'ikm_score' => $calc['ikm_score'],
            'ikm_service_quality' => $calc['ikm_service_quality'],
            'ikm_performance_category' => $calc['ikm_performance_category'],
        ]);

        return redirect()->route('admin.surveys.show', $survey)
            ->with('success', "Data survei {$survey->period} Tahun {$survey->year} berhasil disimpan. Nilai SKM: {$survey->ikm_score} ({$survey->ikm_performance_category}).");
    }

    /**
     * Tampilkan detail perhitungan SKM, 9 unsur NRR/NRT, dan tabel responden.
     */
    public function show(Survey $survey): View
    {
        $responses = $survey->responses()->paginate(15);
        $labels = Survey::elementLabels();

        // Ambil kalkulasi rinci
        $calculation = $this->calculateSkmSummary($survey);

        return view('admin.surveys.show', compact('survey', 'responses', 'labels', 'calculation'));
    }

    /**
     * Form edit/perbarui data survei SKM per triwulan.
     */
    public function edit(Survey $survey): View
    {
        $labels = Survey::elementLabels();

        return view('admin.surveys.edit', compact('survey', 'labels'));
    }

    /**
     * Update data survei SKM per triwulan di database.
     */
    public function update(Request $request, Survey $survey): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'period' => 'required|string|max:100',
            'year' => 'required|integer|min:2000|max:2099',
            'total_respondents' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'u1' => 'required|numeric|min:1|max:4',
            'u2' => 'required|numeric|min:1|max:4',
            'u3' => 'required|numeric|min:1|max:4',
            'u4' => 'required|numeric|min:1|max:4',
            'u5' => 'required|numeric|min:1|max:4',
            'u6' => 'required|numeric|min:1|max:4',
            'u7' => 'required|numeric|min:1|max:4',
            'u8' => 'required|numeric|min:1|max:4',
            'u9' => 'required|numeric|min:1|max:4',
        ]);

        $shouldBeActive = $request->boolean('is_active');
        if ($shouldBeActive && ! $survey->is_active) {
            Survey::where('is_active', true)->update(['is_active' => false]);
        }

        $nrrInput = [
            'u1' => (float) $request->input('u1'),
            'u2' => (float) $request->input('u2'),
            'u3' => (float) $request->input('u3'),
            'u4' => (float) $request->input('u4'),
            'u5' => (float) $request->input('u5'),
            'u6' => (float) $request->input('u6'),
            'u7' => (float) $request->input('u7'),
            'u8' => (float) $request->input('u8'),
            'u9' => (float) $request->input('u9'),
        ];

        $calc = $this->skmService->calculateFromNrr($nrrInput, (int) $request->input('total_respondents'));

        $survey->update([
            'title' => $request->input('title'),
            'period' => $request->input('period'),
            'year' => (int) $request->input('year'),
            'description' => $request->input('description'),
            'is_active' => $shouldBeActive,
            'total_respondents' => $calc['total_respondents'],
            'nrr_elements' => $calc['nrr_elements'],
            'nrt_elements' => $calc['nrt_elements'],
            'ikm_score' => $calc['ikm_score'],
            'ikm_service_quality' => $calc['ikm_service_quality'],
            'ikm_performance_category' => $calc['ikm_performance_category'],
        ]);

        return redirect()->route('admin.surveys.show', $survey)
            ->with('success', "Data survei {$survey->period} Tahun {$survey->year} berhasil diperbarui. Nilai SKM: {$survey->ikm_score} ({$survey->ikm_performance_category}).");
    }

    /**
     * Method untuk menghitung rumus Permenpan RB 14/2017 dan mengembalikan array
     * berisi NRR per unsur dan Nilai Akhir SKM skala 100 untuk Dashboard/Web.
     *
     * @return array{
     *     survey_id: int,
     *     survey_title: string,
     *     period: string,
     *     year: int,
     *     total_respondents: int,
     *     nrr_per_unsur: array<string, float>,
     *     nrt_per_unsur: array<string, float>,
     *     total_nrt: float,
     *     nilai_skm: float,
     *     mutu_pelayanan: string,
     *     kategori_kinerja: string,
     *     unsur_labels: array<string, string>,
     *     elements_detail: array<string, array{label: string, nrr: float, nrt: float}>
     * }
     */
    public function calculateSkmSummary(Survey $survey): array
    {
        $responses = $survey->responses()->get();

        if ($responses->count() > 0) {
            $calc = $this->skmService->calculateFromResponses($responses);
        } else {
            $calc = $this->skmService->calculateFromNrr(
                $survey->nrr_elements ?? [],
                (int) $survey->total_respondents
            );
        }

        return [
            'survey_id' => $survey->id,
            'survey_title' => $survey->title,
            'period' => $survey->period,
            'year' => $survey->year,
            'total_respondents' => $calc['total_respondents'],
            'nrr_per_unsur' => $calc['nrr_elements'],
            'nrt_per_unsur' => $calc['nrt_elements'],
            'total_nrt' => $calc['total_nrt'],
            'nilai_skm' => $calc['ikm_score'],
            'mutu_pelayanan' => $calc['ikm_service_quality'],
            'kategori_kinerja' => $calc['ikm_performance_category'],
            'unsur_labels' => Survey::elementLabels(),
            'elements_detail' => $calc['elements_detail'],
        ];
    }

    /**
     * Hitung ulang data survei yang sudah ada.
     */
    public function recalculate(Survey $survey): RedirectResponse
    {
        $this->skmService->recalculateAndSave($survey);

        return redirect()->route('admin.surveys.show', $survey)
            ->with('success', 'Nilai SKM berhasil dihitung ulang.');
    }

    /**
     * Set survei ini sebagai survei aktif yang ditampilkan di halaman publik welcome.
     */
    public function setActive(Survey $survey): RedirectResponse
    {
        Survey::where('is_active', true)->update(['is_active' => false]);
        $survey->update(['is_active' => true]);

        return redirect()->back()
            ->with('success', "Survei '{$survey->title}' sekarang aktif dan ditampilkan pada halaman beranda.");
    }

    /**
     * Hapus survei beserta seluruh data jawaban respondennya.
     */
    public function destroy(Survey $survey): RedirectResponse
    {
        $survey->delete();

        return redirect()->route('admin.surveys.index')
            ->with('success', 'Data survei berhasil dihapus.');
    }

    /**
     * Unduh template file Excel untuk format kuesioner responden.
     */
    public function downloadTemplate(): BinaryFileResponse
    {
        return Excel::download(new SurveyTemplateExport, 'template_kuesioner_skm_bpmp.xlsx');
    }
}
