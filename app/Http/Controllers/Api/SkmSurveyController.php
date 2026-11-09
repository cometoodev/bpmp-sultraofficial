<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreSkmSurveyRequest;
use App\Http\Resources\SkmSurveyResource;
use App\Models\Guestbook;
use App\Models\UltSurveyResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SkmSurveyController extends Controller
{
    /**
     * Menampilkan daftar tanggapan survey SKM dengan paginasi.
     */
    public function index(Request $request): JsonResponse
    {
        $query = UltSurveyResponse::with('guestbook')->latest('id');

        if ($request->filled('guestbook_id')) {
            $query->where('guestbook_id', (int) $request->input('guestbook_id'));
        }

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', (int) $request->input('tahun'));
        }

        $perPage = (int) $request->input('per_page', $request->input('limit', 15));
        if ($perPage < 1 || $perPage > 100) {
            $perPage = 15;
        }

        $paginated = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => SkmSurveyResource::collection($paginated->items()),
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
     * Menyimpan respon kuisioner SKM dari aplikasi React Native.
     */
    public function store(StoreSkmSurveyRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $guestbook = Guestbook::findOrFail($validated['guestbook_id']);

        $response = UltSurveyResponse::updateOrCreate(
            ['guestbook_id' => $guestbook->id],
            $validated
        );

        $response->load('guestbook');

        return response()->json([
            'status' => 'success',
            'message' => 'Terima kasih! Penilaian survey kepuasan masyarakat berhasil dicatat.',
            'data' => new SkmSurveyResource($response),
        ], 201);
    }

    /**
     * Menampilkan detail satu respon survey.
     */
    public function show(int $id): JsonResponse
    {
        $response = UltSurveyResponse::with('guestbook')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => new SkmSurveyResource($response),
        ]);
    }

    /**
     * Mengembalikan 9 pertanyaan resmi SKM Permenpan beserta opsi skor & emoji untuk aplikasi mobile.
     */
    public function questions(): JsonResponse
    {
        $questions = [
            [
                'key' => 'q1',
                'number' => 1,
                'title' => 'Kesesuaian Persyaratan',
                'description' => 'Bagaimana kesesuaian persyaratan pelayanan yang dipersyaratkan dengan jenis layanan yang Anda terima?',
            ],
            [
                'key' => 'q2',
                'number' => 2,
                'title' => 'Kemudahan Prosedur',
                'description' => 'Bagaimana kemudahan prosedur dan alur pelayanan di loket Unit Layanan Terpadu?',
            ],
            [
                'key' => 'q3',
                'number' => 3,
                'title' => 'Kecepatan Waktu Pelayanan',
                'description' => 'Bagaimana kecepatan dan ketepatan waktu petugas dalam memberikan respon serta penyelesaian layanan?',
            ],
            [
                'key' => 'q4',
                'number' => 4,
                'title' => 'Tidak Ada Biaya / Bebas Pungli',
                'description' => 'Apakah pelayanan yang diberikan bebas dari pungutan biaya tambahan, gratifikasi, atau imbalan apapun?',
            ],
            [
                'key' => 'q5',
                'number' => 5,
                'title' => 'Kesesuaian Produk Layanan',
                'description' => 'Bagaimana kesesuaian hasil/produk pelayanan yang Anda terima dengan standar yang telah dijanjikan?',
            ],
            [
                'key' => 'q6',
                'number' => 6,
                'title' => 'Kompetensi Petugas',
                'description' => 'Bagaimana kecakapan, pengetahuan, dan keahlian petugas dalam melayani kebutuhan konsultasi/permohonan Anda?',
            ],
            [
                'key' => 'q7',
                'number' => 7,
                'title' => 'Sikap & Keramahan Petugas',
                'description' => 'Bagaimana kesopanan, keramahan, dan kepedulian petugas ULT saat menyambut dan melayani Anda?',
            ],
            [
                'key' => 'q8',
                'number' => 8,
                'title' => 'Kualitas Sarana & Prasarana',
                'description' => 'Bagaimana kebersihan, kenyamanan ruang tunggu, fasilitas, dan kelengkapan sarana pendukung di ULT?',
            ],
            [
                'key' => 'q9',
                'number' => 9,
                'title' => 'Penanganan Pengaduan Layanan',
                'description' => 'Bagaimana kejelasan informasi dan penanganan tindak lanjut apabila ada pertanyaan, kritik, atau pengaduan?',
            ],
        ];

        $ratingScales = [
            ['value' => 1, 'emoji' => '😡', 'label' => 'Sangat Tidak Puas'],
            ['value' => 2, 'emoji' => '🙁', 'label' => 'Tidak Puas'],
            ['value' => 3, 'emoji' => '😊', 'label' => 'Puas'],
            ['value' => 4, 'emoji' => '😍', 'label' => 'Sangat Puas'],
        ];

        return response()->json([
            'status' => 'success',
            'data' => [
                'rating_scales' => $ratingScales,
                'questions' => $questions,
            ],
        ]);
    }
}
