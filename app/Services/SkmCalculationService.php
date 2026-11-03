<?php

namespace App\Services;

use App\Models\Survey;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class SkmCalculationService
{
    /**
     * Bobot tertimbang per unsur (1/9 unsur = 0.111 sesuai Permenpan RB No 14 Tahun 2017).
     */
    public const WEIGHT = 0.111;

    /**
     * Hitung IKM standar PERMENPAN RB No. 14 Tahun 2017.
     *
     * @param  Collection|iterable  $surveyResponses
     * @return array{
     *     total_responden: int,
     *     nrr_per_unsur: array<string, float>,
     *     nilai_ikm: float,
     *     nilai_konversi: float,
     *     mutu: string,
     *     kinerja: string,
     *     unsur_terbaik: array{nama: string, nilai: float}|null,
     *     unsur_terendah: array{nama: string, nilai: float}|null
     * }
     */
    public function calculateSkm($surveyResponses): array
    {
        if ($surveyResponses instanceof Builder || $surveyResponses instanceof \Illuminate\Database\Query\Builder) {
            $surveyResponses = $surveyResponses->get();
        } elseif (! ($surveyResponses instanceof Collection)) {
            $surveyResponses = collect($surveyResponses);
        }

        $totalResponden = $surveyResponses->count();

        // Jika tidak ada data, return 0 untuk menghindari Division by Zero
        if ($totalResponden === 0) {
            return [
                'total_responden' => 0,
                'nrr_per_unsur' => [
                    'q1' => 0, 'q2' => 0, 'q3' => 0, 'q4' => 0, 'q5' => 0,
                    'q6' => 0, 'q7' => 0, 'q8' => 0, 'q9' => 0,
                ] + array_fill(1, 9, 0),
                'nilai_ikm' => 0,
                'nilai_konversi' => 0,
                'mutu' => 'D',
                'kinerja' => 'Tidak Baik',
                'unsur_terbaik' => null,
                'unsur_terendah' => null,
            ];
        }

        // 1. Hitung total nilai masing-masing unsur (U1 - U9)
        $totalUnsur = [
            'q1' => $surveyResponses->sum('q1'),
            'q2' => $surveyResponses->sum('q2'),
            'q3' => $surveyResponses->sum('q3'),
            'q4' => $surveyResponses->sum('q4'),
            'q5' => $surveyResponses->sum('q5'),
            'q6' => $surveyResponses->sum('q6'),
            'q7' => $surveyResponses->sum('q7'),
            'q8' => $surveyResponses->sum('q8'),
            'q9' => $surveyResponses->sum('q9'),
        ];

        // 2. Hitung NRR (Nilai Rata-Rata) Per Unsur
        $nrrPerUnsur = [];
        $ikmTertimbang = 0;
        // Sesuai Permenpan, Bobot = 1 / Jumlah Unsur (1/9)
        $bobot = 1 / 9;

        foreach ($totalUnsur as $key => $total) {
            // NRR = Total Nilai Unsur / Total Responden
            $nrr = $total / $totalResponden;
            $nrrPerUnsur[$key] = round($nrr, 3);
            // NRR Tertimbang = NRR x Bobot
            $ikmTertimbang += ($nrr * $bobot);
        }

        // 3. Konversi nilai ke skala 25 - 100
        $ikmKonversi = round($ikmTertimbang * 25, 2);

        // 4. Tentukan Mutu & Kinerja berdasarkan Tabel Permenpan RB No 14/2017
        $mutu = 'D';
        $kinerja = 'Tidak Baik';

        if ($ikmKonversi >= 88.31) {
            $mutu = 'A';
            $kinerja = 'Sangat Baik';
        } elseif ($ikmKonversi >= 76.61) {
            $mutu = 'B';
            $kinerja = 'Baik';
        } elseif ($ikmKonversi >= 65.00) {
            $mutu = 'C';
            $kinerja = 'Kurang Baik';
        }

        // 5. Cari Unsur Terbaik (NRR Tertinggi) & Perlu Ditingkatkan (NRR Terendah)
        $unsurNames = [
            'q1' => 'Kesesuaian Persyaratan',
            'q2' => 'Kemudahan Prosedur',
            'q3' => 'Kecepatan Waktu',
            'q4' => 'Biaya/Tarif',
            'q5' => 'Kesesuaian Produk',
            'q6' => 'Kompetensi Pelaksana',
            'q7' => 'Perilaku Pelaksana',
            'q8' => 'Kualitas Sarana & Prasarana',
            'q9' => 'Penanganan Pengaduan',
        ];

        $tertinggi = array_keys($nrrPerUnsur, max($nrrPerUnsur))[0];
        $terendah = array_keys($nrrPerUnsur, min($nrrPerUnsur))[0];

        return [
            'total_responden' => $totalResponden,
            'nrr_per_unsur' => $nrrPerUnsur,
            'nilai_ikm' => round($ikmTertimbang, 3),
            'nilai_konversi' => $ikmKonversi,
            'mutu' => $mutu,
            'kinerja' => $kinerja,
            'unsur_terbaik' => [
                'nama' => $unsurNames[$tertinggi],
                'nilai' => $nrrPerUnsur[$tertinggi],
            ],
            'unsur_terendah' => [
                'nama' => $unsurNames[$terendah],
                'nilai' => $nrrPerUnsur[$terendah],
            ],
        ];
    }

    /**
     * Hitung nilai SKM dari query Builder atau Collection respons yang sudah difilter.
     *
     * @param  Builder|Collection  $queryOrResponses
     */
    public function calculateFiltered($queryOrResponses): array
    {
        $responses = $queryOrResponses instanceof Builder
            ? $queryOrResponses->get()
            : $queryOrResponses;

        return $this->calculateFromResponses($responses);
    }

    /**
     * Hitung nilai SKM lengkap dari koleksi response.
     *
     * @param  Collection<int, mixed>  $responses
     * @return array{
     *     total_respondents: int,
     *     nrr_elements: array<string, float>,
     *     nrt_elements: array<string, float>,
     *     total_nrt: float,
     *     ikm_score: float,
     *     ikm_service_quality: string,
     *     ikm_performance_category: string,
     *     elements_detail: array<string, array{label: string, nrr: float, nrt: float}>
     * }
     */
    public function calculateFromResponses(Collection $responses): array
    {
        $totalRespondents = $responses->count();
        $labels = Survey::elementLabels();

        if ($totalRespondents === 0) {
            $emptyNrr = [];
            $emptyNrt = [];
            $emptyDetails = [];

            foreach ($labels as $key => $label) {
                $emptyNrr[$key] = 0.0;
                $emptyNrt[$key] = 0.0;
                $emptyDetails[$key] = [
                    'label' => $label,
                    'nrr' => 0.0,
                    'nrt' => 0.0,
                ];
            }

            return [
                'total_respondents' => 0,
                'nrr_elements' => $emptyNrr,
                'nrt_elements' => $emptyNrt,
                'total_nrt' => 0.0,
                'ikm_score' => 0.0,
                'ikm_service_quality' => 'D',
                'ikm_performance_category' => 'Tidak Baik',
                'elements_detail' => $emptyDetails,
            ];
        }

        $nrrElements = [];
        $nrtElements = [];
        $elementsDetail = [];
        $totalNrt = 0.0;

        foreach ($labels as $key => $label) {
            // 1. Hitung Nilai Rata-Rata (NRR) per unsur = Total Nilai / Jumlah Responden
            $sumValue = $responses->sum($key);
            $nrr = round($sumValue / $totalRespondents, 3);

            // 2. Hitung Nilai Rata-Rata Tertimbang (NRT) = NRR * 0.111
            $nrt = round($nrr * self::WEIGHT, 4);

            $nrrElements[$key] = $nrr;
            $nrtElements[$key] = $nrt;
            $totalNrt += $nrt;

            $elementsDetail[$key] = [
                'label' => $label,
                'nrr' => $nrr,
                'nrt' => $nrt,
            ];
        }

        // 3. Hitung Nilai Akhir SKM = Total NRT * 25 (skala 100)
        $ikmScore = round($totalNrt * 25, 2);

        // Tentukan Kategori Mutu Pelayanan
        $grade = $this->determineQualityGrade($ikmScore);

        return [
            'total_respondents' => $totalRespondents,
            'nrr_elements' => $nrrElements,
            'nrt_elements' => $nrtElements,
            'total_nrt' => round($totalNrt, 4),
            'ikm_score' => $ikmScore,
            'ikm_service_quality' => $grade['quality'],
            'ikm_performance_category' => $grade['category'],
            'elements_detail' => $elementsDetail,
        ];
    }

    /**
     * Tentukan Mutu Pelayanan dan Kinerja Kategori berdasarkan Permenpan RB 14/2017.
     *
     * @return array{quality: string, category: string}
     */
    public function determineQualityGrade(float $score): array
    {
        if ($score >= 88.31) {
            return ['quality' => 'A', 'category' => 'Sangat Baik'];
        }

        if ($score >= 76.61) {
            return ['quality' => 'B', 'category' => 'Baik'];
        }

        if ($score >= 65.00) {
            return ['quality' => 'C', 'category' => 'Kurang Baik'];
        }

        return ['quality' => 'D', 'category' => 'Tidak Baik'];
    }

    /**
     * Hitung nilai SKM dari nilai rata-rata (NRR) masing-masing 9 unsur (untuk input manual per triwulan).
     *
     * @param  array<string, float|int|numeric-string>  $nrrInput
     * @return array{
     *     total_respondents: int,
     *     nrr_elements: array<string, float>,
     *     nrt_elements: array<string, float>,
     *     total_nrt: float,
     *     ikm_score: float,
     *     ikm_service_quality: string,
     *     ikm_performance_category: string,
     *     elements_detail: array<string, array{label: string, nrr: float, nrt: float}>
     * }
     */
    public function calculateFromNrr(array $nrrInput, int $totalRespondents = 0): array
    {
        $labels = Survey::elementLabels();
        $nrrElements = [];
        $nrtElements = [];
        $elementsDetail = [];
        $totalNrt = 0.0;

        foreach ($labels as $key => $label) {
            $nrr = isset($nrrInput[$key]) ? round((float) $nrrInput[$key], 3) : 0.0;
            $nrt = round($nrr * self::WEIGHT, 4);

            $nrrElements[$key] = $nrr;
            $nrtElements[$key] = $nrt;
            $totalNrt += $nrt;

            $elementsDetail[$key] = [
                'label' => $label,
                'nrr' => $nrr,
                'nrt' => $nrt,
            ];
        }

        $ikmScore = round($totalNrt * 25, 2);
        $grade = $this->determineQualityGrade($ikmScore);

        return [
            'total_respondents' => $totalRespondents,
            'nrr_elements' => $nrrElements,
            'nrt_elements' => $nrtElements,
            'total_nrt' => round($totalNrt, 4),
            'ikm_score' => $ikmScore,
            'ikm_service_quality' => $grade['quality'],
            'ikm_performance_category' => $grade['category'],
            'elements_detail' => $elementsDetail,
        ];
    }

    /**
     * Hitung ulang dan perbarui record Survey di database.
     */
    public function recalculateAndSave(Survey $survey): Survey
    {
        $responses = $survey->responses()->get();

        if ($responses->count() > 0) {
            $calc = $this->calculateFromResponses($responses);
        } else {
            $calc = $this->calculateFromNrr(
                $survey->nrr_elements ?? [],
                (int) $survey->total_respondents
            );
        }

        $survey->update([
            'total_respondents' => $calc['total_respondents'],
            'nrr_elements' => $calc['nrr_elements'],
            'nrt_elements' => $calc['nrt_elements'],
            'ikm_score' => $calc['ikm_score'],
            'ikm_service_quality' => $calc['ikm_service_quality'],
            'ikm_performance_category' => $calc['ikm_performance_category'],
        ]);

        return $survey->fresh();
    }
}
