<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreGuestbookRequest;
use App\Http\Resources\GuestbookResource;
use App\Models\Guestbook;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GuestbookController extends Controller
{
    /**
     * Menampilkan daftar buku tamu dengan filter dan paginasi (untuk React Native).
     */
    public function index(Request $request): JsonResponse
    {
        $query = Guestbook::query()->latest('id');

        // Filter pencarian (Nama, Asal Instansi, Jenis Layanan)
        $search = $request->input('search', $request->input('q'));
        if (! empty($search)) {
            $query->where(function ($q) use ($search): void {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('asal_instansi', 'like', "%{$search}%")
                    ->orWhere('jenis_layanan', 'like', "%{$search}%");
            });
        }

        // Filter Tahun
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', (int) $request->input('tahun'));
        }

        // Filter Triwulan (1 - 4)
        if ($request->filled('triwulan') && in_array((int) $request->input('triwulan'), [1, 2, 3, 4], true)) {
            $triwulan = (int) $request->input('triwulan');
            match ($triwulan) {
                1 => $query->whereMonth('created_at', '>=', 1)->whereMonth('created_at', '<=', 3),
                2 => $query->whereMonth('created_at', '>=', 4)->whereMonth('created_at', '<=', 6),
                3 => $query->whereMonth('created_at', '>=', 7)->whereMonth('created_at', '<=', 9),
                4 => $query->whereMonth('created_at', '>=', 10)->whereMonth('created_at', '<=', 12),
                default => null,
            };
        }

        // Filter Jenis Layanan
        if ($request->filled('layanan')) {
            $query->where('jenis_layanan', $request->input('layanan'));
        }

        // Filter Asal Kabupaten
        if ($request->filled('asal_kabupaten')) {
            $query->where('asal_kabupaten', $request->input('asal_kabupaten'));
        }

        // Filter Jenis Kelamin
        if ($request->filled('jenis_kelamin') && in_array(strtoupper($request->input('jenis_kelamin')), ['L', 'P'], true)) {
            $query->where('jenis_kelamin', strtoupper($request->input('jenis_kelamin')));
        }

        // Paginasi
        $perPage = (int) $request->input('per_page', $request->input('limit', 15));
        if ($perPage < 1 || $perPage > 100) {
            $perPage = 15;
        }

        $paginated = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => GuestbookResource::collection($paginated->items()),
            'pagination' => [
                'total' => $paginated->total(),
                'count' => $paginated->count(),
                'per_page' => $paginated->perPage(),
                'current_page' => $paginated->currentPage(),
                'total_pages' => $paginated->lastPage(),
                'has_more_pages' => $paginated->hasMorePages(),
            ],
        ]);
    }

    /**
     * Menyimpan data kunjungan buku tamu baru dari aplikasi React Native.
     */
    public function store(StoreGuestbookRequest $request): JsonResponse
    {
        $guestbook = Guestbook::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Data kunjungan buku tamu berhasil dicatat.',
            'data' => new GuestbookResource($guestbook),
        ], 201);
    }

    /**
     * Menampilkan detail satu entri buku tamu.
     */
    public function show(Guestbook $guestbook): JsonResponse
    {
        $guestbook->load('ultSurveyResponse');

        return response()->json([
            'status' => 'success',
            'data' => new GuestbookResource($guestbook),
        ]);
    }

    /**
     * Mengembalikan daftar opsi form (dropdown/picker) untuk aplikasi React Native.
     */
    public function options(): JsonResponse
    {
        $pendidikanOptions = [
            'SD / Sederajat',
            'SMP / Sederajat',
            'SMA / SMK / Sederajat',
            'Diploma (D1 - D3)',
            'Sarjana (S1 / D4)',
            'Magister (S2)',
            'Doktoral (S3)',
        ];

        $statusKepegawaianOptions = [
            'PNS',
            'PPPK',
            'Non-ASN / Honorer',
            'Pegawai Swasta / Yayasan',
            'Masyarakat Umum',
        ];

        $pekerjaanOptions = [
            'Guru / Pendidik',
            'Kepala Sekolah',
            'Pengawas Sekolah',
            'Operator Sekolah / Dapodik',
            'Pejabat / Staf Dinas Pendidikan',
            'Aparatur Sipil Negara (ASN)',
            'Dosen / Akademisi',
            'Mahasiswa / Pelajar',
            'Pegawai Swasta',
            'Wiraswasta / Usaha',
            'Lainnya',
        ];

        $kabupatenOptions = [
            'Kota Kendari',
            'Kota Baubau',
            'Kab. Konawe',
            'Kab. Konawe Selatan',
            'Kab. Konawe Utara',
            'Kab. Konawe Kepulauan',
            'Kab. Kolaka',
            'Kab. Kolaka Utara',
            'Kab. Kolaka Timur',
            'Kab. Muna',
            'Kab. Muna Barat',
            'Kab. Buton',
            'Kab. Buton Utara',
            'Kab. Buton Selatan',
            'Kab. Buton Tengah',
            'Kab. Bombana',
            'Kab. Wakatobi',
            'Luar Sulawesi Tenggara',
        ];

        $defaultLayananOptions = [
            'Konsultasi & Advokasi Program Prioritas Kemendikdasmen',
            'Layanan Data Pokok Pendidikan (Dapodik) & PDM',
            'Penjaminan Mutu & Rekomendasi Rapor Pendidikan',
            'Penerbitan Rekomendasi / Keterangan Dinas',
            'Pemanfaatan Sarana, Prasarana & Fasilitas Diklat',
            'Informasi Publik & Penanganan Pengaduan Layanan',
            'Koordinasi / Audiensi Kedinasan',
        ];

        // Ambil opsi layanan tambahan yang sudah pernah tersimpan di database
        $dbLayanan = Guestbook::select('jenis_layanan')
            ->distinct()
            ->whereNotNull('jenis_layanan')
            ->orderBy('jenis_layanan')
            ->pluck('jenis_layanan')
            ->filter()
            ->toArray();

        $mergedLayanan = array_values(array_unique(array_merge($defaultLayananOptions, $dbLayanan)));

        return response()->json([
            'status' => 'success',
            'data' => [
                'jenis_kelamin' => [
                    ['value' => 'L', 'label' => 'Laki-laki'],
                    ['value' => 'P', 'label' => 'Perempuan'],
                ],
                'pendidikan' => $pendidikanOptions,
                'status_kepegawaian' => $statusKepegawaianOptions,
                'pekerjaan' => $pekerjaanOptions,
                'asal_kabupaten' => $kabupatenOptions,
                'jenis_layanan' => $mergedLayanan,
            ],
        ]);
    }
}
