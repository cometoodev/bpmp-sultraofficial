<?php

namespace App\Services;

use App\Models\Survey;
use Illuminate\Support\Collection;

class SkmCalculationService
{
    /**
     * Bobot tertimbang per unsur (1/9 unsur = 0.111 sesuai Permenpan RB No 14 Tahun 2017).
     */
    public const WEIGHT = 0.111;

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

        if ($score >= 65.31) {
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
