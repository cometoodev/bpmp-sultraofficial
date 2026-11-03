<?php

namespace App\Services;

use App\Models\Guestbook;
use App\Models\UltSurveyResponse;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * ULT SKM Calculation Service.
 *
 * Menghitung Indeks Kepuasan Masyarakat (IKM) ULT berdasarkan data
 * Buku Tamu (guestbooks) dan Jawaban Kuisioner (ult_survey_responses)
 * sesuai Permenpan RB No. 14 Tahun 2017.
 */
class UltSkmService
{
    /** Bobot tertimbang per unsur: 1/9 = 0.111 */
    public const WEIGHT = 0.111;

    /** 9 Label Unsur Pelayanan (P1–P9) */
    public const UNSUR_LABELS = [
        'q1' => 'Kesesuaian Persyaratan',
        'q2' => 'Kemudahan Prosedur',
        'q3' => 'Kecepatan Waktu Pelayanan',
        'q4' => 'Bebas Biaya / Gratifikasi',
        'q5' => 'Kesesuaian Produk Layanan',
        'q6' => 'Kompetensi Petugas',
        'q7' => 'Sikap & Keramahan Petugas',
        'q8' => 'Kualitas Sarana & Prasarana',
        'q9' => 'Penanganan Pengaduan',
    ];

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
        if ($surveyResponses instanceof EloquentBuilder || $surveyResponses instanceof QueryBuilder) {
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
     * Terapkan filter tahun, triwulan, jenis layanan, dan kata kunci pencarian pada builder.
     */
    public function applyFilters(EloquentBuilder|QueryBuilder $query, ?int $tahun = null, ?int $triwulan = null, ?string $layanan = null, string $prefix = '', ?string $search = null): void
    {
        if ($tahun) {
            $query->whereYear("{$prefix}created_at", $tahun);
        }

        if ($triwulan) {
            match ((int) $triwulan) {
                1 => $query->whereMonth("{$prefix}created_at", '>=', 1)->whereMonth("{$prefix}created_at", '<=', 3),
                2 => $query->whereMonth("{$prefix}created_at", '>=', 4)->whereMonth("{$prefix}created_at", '<=', 6),
                3 => $query->whereMonth("{$prefix}created_at", '>=', 7)->whereMonth("{$prefix}created_at", '<=', 9),
                4 => $query->whereMonth("{$prefix}created_at", '>=', 10)->whereMonth("{$prefix}created_at", '<=', 12),
                default => null,
            };
        }

        if ($layanan) {
            $query->where("{$prefix}jenis_layanan", $layanan);
        }

        if ($search) {
            $query->where(function ($q) use ($search, $prefix) {
                $q->where("{$prefix}nama", 'like', "%{$search}%")
                    ->orWhere("{$prefix}asal_instansi", 'like', "%{$search}%")
                    ->orWhere("{$prefix}jenis_layanan", 'like', "%{$search}%");
            });
        }
    }

    /**
     * Ambil respons kuisioner ULT sesuai filter.
     *
     * @return Collection<int, UltSurveyResponse>
     */
    public function getResponses(?int $tahun = null, ?int $triwulan = null, ?string $layanan = null, ?string $search = null): Collection
    {
        $query = UltSurveyResponse::query();

        if ($tahun || $triwulan || $layanan || $search) {
            $query->whereHas('guestbook', function (EloquentBuilder $q) use ($tahun, $triwulan, $layanan, $search) {
                $this->applyFilters($q, $tahun, $triwulan, $layanan, '', $search);
            });
        }

        return $query->get();
    }

    /**
     * DEMOGRAFI: Menghitung distribusi responden berdasarkan
     * jenis kelamin, kelompok usia, pendidikan, dan pekerjaan.
     *
     * @return array{
     *     total: int,
     *     jenis_kelamin: array{labels: list<string>, data: list<int>},
     *     usia: array{labels: list<string>, data: list<int>},
     *     pendidikan: array{labels: list<string>, data: list<int>},
     *     pekerjaan: array{labels: list<string>, data: list<int>}
     * }
     */
    public function getDemographics(?int $tahun = null, ?int $triwulan = null, ?string $layanan = null, ?string $search = null): array
    {
        $query = Guestbook::query();
        $this->applyFilters($query, $tahun, $triwulan, $layanan, '', $search);

        /** @var Collection<int, Guestbook> */
        $guestbooks = $query->get();
        $total = $guestbooks->count();

        // Jenis Kelamin
        $genderCounts = $guestbooks->groupBy('jenis_kelamin')->map->count();

        // Kelompok Usia
        $usiaGroups = [
            '< 17 Tahun' => 0,
            '17 - 25 Th' => 0,
            '26 - 35 Th' => 0,
            '36 - 45 Th' => 0,
            '46 - 55 Th' => 0,
            '> 55 Tahun' => 0,
        ];
        foreach ($guestbooks as $g) {
            $usia = (int) $g->usia;
            if ($usia < 17) {
                $usiaGroups['< 17 Tahun']++;
            } elseif ($usia <= 25) {
                $usiaGroups['17 - 25 Th']++;
            } elseif ($usia <= 35) {
                $usiaGroups['26 - 35 Th']++;
            } elseif ($usia <= 45) {
                $usiaGroups['36 - 45 Th']++;
            } elseif ($usia <= 55) {
                $usiaGroups['46 - 55 Th']++;
            } else {
                $usiaGroups['> 55 Tahun']++;
            }
        }

        // Pendidikan (diurutkan jenjang)
        $pendidikanOrder = [
            'SD / Sederajat',
            'SMP / Sederajat',
            'SMA / SMK / Sederajat',
            'Diploma (D1 - D3)',
            'Sarjana (S1 / D4)',
            'Magister (S2)',
            'Doktoral (S3)',
        ];
        $pendidikanCounts = $guestbooks->groupBy('pendidikan')->map->count()->toArray();
        $pendidikanSorted = [];
        foreach ($pendidikanOrder as $p) {
            $pendidikanSorted[$p] = $pendidikanCounts[$p] ?? 0;
        }
        foreach ($pendidikanCounts as $key => $val) {
            if (! isset($pendidikanSorted[$key])) {
                $pendidikanSorted[$key] = $val;
            }
        }

        // Pekerjaan (top 10, sorted descending)
        $pekerjaanCounts = $guestbooks->groupBy('pekerjaan')->map->count()
            ->sortDesc()->take(10)->toArray();

        return [
            'total' => $total,
            'jenis_kelamin' => [
                'labels' => ['Laki-laki', 'Perempuan'],
                'data' => [$genderCounts['L'] ?? 0, $genderCounts['P'] ?? 0],
            ],
            'usia' => [
                'labels' => array_keys($usiaGroups),
                'data' => array_values($usiaGroups),
            ],
            'pendidikan' => [
                'labels' => array_keys($pendidikanSorted),
                'data' => array_values($pendidikanSorted),
            ],
            'pekerjaan' => [
                'labels' => array_keys($pekerjaanCounts),
                'data' => array_values($pekerjaanCounts),
            ],
        ];
    }

    /**
     * IKM PER UNSUR: Menghitung NR (Nilai Rata-rata) dan
     * NRT (Nilai Rata-rata Tertimbang) setiap unsur P1–P9.
     *
     * @return array<string, array{label: string, nr: float, nrt: float}>
     */
    public function calculateIkmPerUnsur(?int $tahun = null, ?int $triwulan = null, ?string $layanan = null, ?string $search = null): array
    {
        $responses = $this->getResponses($tahun, $triwulan, $layanan, $search);
        $total = $responses->count();
        $result = [];

        foreach (self::UNSUR_LABELS as $key => $label) {
            if ($total === 0) {
                $result[$key] = ['label' => $label, 'nr' => 0.0, 'nrt' => 0.0];

                continue;
            }

            $sum = $responses->sum($key);
            $nr = round($sum / $total, 3);
            $nrt = round($nr * self::WEIGHT, 4);

            $result[$key] = [
                'label' => $label,
                'nr' => $nr,
                'nrt' => $nrt,
            ];
        }

        return $result;
    }

    /**
     * IKM PER LAYANAN dari koleksi item buku tamu yang sedang tertampil (sesuai limit pagination).
     *
     * @param  iterable<int, mixed>  $guestbookItems
     * @return array<int, array{
     *     layanan: string,
     *     responden: int,
     *     ikm: float,
     *     grade: string,
     *     label: string,
     *     color: string
     * }>
     */
    public function calculateIkmPerLayananFromItems(iterable $guestbookItems): array
    {
        $grouped = [];
        foreach ($guestbookItems as $item) {
            $service = $item->jenis_layanan ?? 'Keperluan Lain';
            $survey = $item->ultSurveyResponse;
            if (! $survey) {
                continue;
            }

            if (! isset($grouped[$service])) {
                $grouped[$service] = [
                    'total' => 0,
                    'q' => array_fill(1, 9, 0.0),
                ];
            }

            $grouped[$service]['total']++;
            for ($i = 1; $i <= 9; $i++) {
                $qKey = "q{$i}";
                $grouped[$service]['q'][$i] += (float) ($survey->$qKey ?? 0);
            }
        }

        $result = [];
        foreach ($grouped as $svcName => $val) {
            $count = $val['total'];
            if ($count === 0) {
                continue;
            }

            $totalNrt = 0.0;
            for ($i = 1; $i <= 9; $i++) {
                $avgQ = $val['q'][$i] / $count;
                $nr = round($avgQ, 3);
                $totalNrt += round($nr * self::WEIGHT, 4);
            }

            $ikm = round($totalNrt * 25, 2);
            $mutu = $this->getMutuLayanan($ikm);

            $result[] = [
                'layanan' => $svcName,
                'responden' => $count,
                'ikm' => $ikm,
                'grade' => $mutu['grade'],
                'label' => $mutu['label'],
                'color' => $mutu['color'],
            ];
        }

        usort($result, fn ($a, $b) => $b['responden'] <=> $a['responden']);

        return $result;
    }

    /**
     * TOTAL IKM KONVERSI: Jumlahkan semua NRT lalu × 25 → skala 25–100.
     *
     * @param  array<string, array{label: string, nr: float, nrt: float}>  $ikmPerUnsur
     */
    public function calculateTotalIkm(array $ikmPerUnsur): float
    {
        $totalNrt = array_sum(array_column($ikmPerUnsur, 'nrt'));

        return round($totalNrt * 25, 2);
    }

    /**
     * MUTU LAYANAN: Predikat kategori berdasarkan IKM konversi (Permenpan RB 14/2017).
     *
     * @return array{grade: string, label: string, color: string}
     */
    public function getMutuLayanan(float $ikm): array
    {
        if ($ikm >= 88.31) {
            return ['grade' => 'A', 'label' => 'Sangat Baik', 'color' => 'emerald'];
        }

        if ($ikm >= 76.61) {
            return ['grade' => 'B', 'label' => 'Baik', 'color' => 'blue'];
        }

        if ($ikm >= 65.00) {
            return ['grade' => 'C', 'label' => 'Kurang Baik', 'color' => 'amber'];
        }

        return ['grade' => 'D', 'label' => 'Tidak Baik', 'color' => 'rose'];
    }

    /**
     * IKM PER LAYANAN: Grouping berdasarkan jenis_layanan di tabel guestbooks,
     * lalu hitung IKM masing-masing layanan sesuai filter.
     *
     * @return array<int, array{
     *     layanan: string,
     *     responden: int,
     *     ikm: float,
     *     grade: string,
     *     label: string,
     *     color: string
     * }>
     */
    public function calculateIkmPerLayanan(?int $tahun = null, ?int $triwulan = null, ?string $layanan = null, ?string $search = null): array
    {
        $query = DB::table('guestbooks')
            ->join('ult_survey_responses', 'guestbooks.id', '=', 'ult_survey_responses.guestbook_id')
            ->select(
                'guestbooks.jenis_layanan',
                DB::raw('COUNT(*) as total'),
                DB::raw('AVG(q1) as avg_q1'),
                DB::raw('AVG(q2) as avg_q2'),
                DB::raw('AVG(q3) as avg_q3'),
                DB::raw('AVG(q4) as avg_q4'),
                DB::raw('AVG(q5) as avg_q5'),
                DB::raw('AVG(q6) as avg_q6'),
                DB::raw('AVG(q7) as avg_q7'),
                DB::raw('AVG(q8) as avg_q8'),
                DB::raw('AVG(q9) as avg_q9'),
            );

        $this->applyFilters($query, $tahun, $triwulan, $layanan, 'guestbooks.', $search);

        $grouped = $query->groupBy('guestbooks.jenis_layanan')
            ->orderByDesc('total')
            ->get();

        $result = [];
        foreach ($grouped as $row) {
            $totalNrt = 0.0;
            for ($i = 1; $i <= 9; $i++) {
                $avgKey = "avg_q{$i}";
                $nr = round((float) $row->$avgKey, 3);
                $totalNrt += round($nr * self::WEIGHT, 4);
            }
            $ikm = round($totalNrt * 25, 2);
            $mutu = $this->getMutuLayanan($ikm);

            $result[] = [
                'layanan' => $row->jenis_layanan,
                'responden' => (int) $row->total,
                'ikm' => $ikm,
                'grade' => $mutu['grade'],
                'label' => $mutu['label'],
                'color' => $mutu['color'],
            ];
        }

        return $result;
    }

    /**
     * Aggregasi lengkap semua data untuk dashboard dengan filter tahun, triwulan, layanan, dan kata kunci pencarian.
     *
     * @return array{
     *     demographics: array,
     *     ikmPerUnsur: array,
     *     totalIkm: float,
     *     mutuLayanan: array,
     *     ikmPerLayanan: array,
     *     totalNrt: float,
     *     skm: array
     * }
     */
    public function getDashboardData(?int $tahun = null, ?int $triwulan = null, ?string $layanan = null, ?string $search = null, ?iterable $guestbookItems = null): array
    {
        $demographics = $this->getDemographics($tahun, $triwulan, $layanan, $search);
        $ikmPerUnsur = $this->calculateIkmPerUnsur($tahun, $triwulan, $layanan, $search);
        $responses = $this->getResponses($tahun, $triwulan, $layanan, $search);
        $skm = $this->calculateSkm($responses);

        $totalIkm = $skm['nilai_konversi'];
        $totalNrt = $skm['nilai_ikm'];
        $mutuLayanan = [
            'grade' => $skm['mutu'],
            'label' => $skm['kinerja'],
            'color' => match ($skm['mutu']) {
                'A' => 'emerald',
                'B' => 'blue',
                'C' => 'amber',
                default => 'rose',
            },
        ];
        $ikmPerLayanan = $guestbookItems !== null
            ? $this->calculateIkmPerLayananFromItems($guestbookItems)
            : $this->calculateIkmPerLayanan($tahun, $triwulan, $layanan, $search);

        return compact('demographics', 'ikmPerUnsur', 'totalIkm', 'mutuLayanan', 'ikmPerLayanan', 'totalNrt', 'skm');
    }
}
