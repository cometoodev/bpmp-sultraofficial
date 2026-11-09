<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreUltRequestApiRequest;
use App\Http\Resources\UltRequestResource;
use App\Models\UltRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UltRequestController extends Controller
{
    /**
     * Menampilkan daftar permohonan layanan ULT dengan filter dan paginasi.
     */
    public function index(Request $request): JsonResponse
    {
        $query = UltRequest::query()->latest('id');

        if ($request->filled('layanan_type')) {
            $query->type($request->input('layanan_type'));
        }

        if ($request->filled('status')) {
            $query->status($request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search): void {
                $q->where('ticket_number', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('instansi', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->input('per_page', $request->input('limit', 15));
        if ($perPage < 1 || $perPage > 100) {
            $perPage = 15;
        }

        $paginated = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => UltRequestResource::collection($paginated->items()),
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
     * Menyimpan permohonan layanan ULT baru dari aplikasi React Native.
     */
    public function store(StoreUltRequestApiRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $layananType = $validated['layanan_type'] ?? 'online';

        $dokumenPath = null;
        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $safeName = 'ult-'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'-'.time().'.'.$file->getClientOriginalExtension();
            $dokumenPath = $file->storeAs('ult_documents', $safeName, 'public');
        }

        $ticket = UltRequest::generateTicketNumber($layananType);

        $ultRequest = UltRequest::create([
            'ticket_number' => $ticket,
            'layanan_type' => $layananType,
            'nama' => $validated['nama'],
            'email' => $validated['email'] ?? null,
            'no_hp' => $validated['no_hp'],
            'profesi' => $validated['profesi'] ?? null,
            'instansi' => $validated['instansi'] ?? null,
            'kategori' => $validated['kategori'],
            'keperluan' => $validated['keperluan'],
            'dokumen_path' => $dokumenPath,
            'status' => 'pending',
            'details' => [
                'platform' => 'mobile_react_native',
                'ip_address' => $request->ip(),
            ],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => "Permohonan Layanan ULT berhasil dikirim. Nomor tiket Anda: {$ticket}.",
            'ticket_number' => $ticket,
            'data' => new UltRequestResource($ultRequest),
        ], 201);
    }

    /**
     * Menampilkan detail satu tiket permohonan layanan.
     */
    public function show(UltRequest $ultRequest): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => new UltRequestResource($ultRequest),
        ]);
    }

    /**
     * Melakukan tracking status permohonan berdasarkan nomor tiket.
     */
    public function track(string $ticket): JsonResponse
    {
        $item = UltRequest::where('ticket_number', trim($ticket))->first();

        if (! $item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nomor tiket tidak ditemukan. Pastikan format nomor tiket benar (contoh: ULT-ON-261104-ABCD).',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => new UltRequestResource($item),
        ]);
    }

    /**
     * Mengembalikan daftar opsi/kategori layanan ULT untuk form picker mobile.
     */
    public function options(): JsonResponse
    {
        $kategoriOptions = [
            'Konsultasi Kurikulum Merdeka & Pembelajaran',
            'Pengelolaan & Pemutakhiran Data Pokok Pendidikan (Dapodik)',
            'Pemanfaatan Rapor Pendidikan & Perencanaan Berbasis Data (PBD)',
            'Bantuan Operasional Sekolah (BOS) & BOSP',
            'Program Guru Penggerak (PGP) & Sekolah Penggerak (PSP)',
            'Layanan NUPTK, Info GTK & Kualifikasi Guru',
            'Peminjaman Fasilitas & Sarana Prasarana Gedung Diklat',
            'Informasi Publik, Audiensi & Pengaduan Layanan',
            'Layanan Lainnya',
        ];

        return response()->json([
            'status' => 'success',
            'data' => [
                'layanan_types' => [
                    ['value' => 'online', 'label' => 'Layanan Online'],
                    ['value' => 'tatap_muka', 'label' => 'Layanan Tatap Muka'],
                    ['value' => 'keliling', 'label' => 'Layanan Keliling'],
                ],
                'kategori' => $kategoriOptions,
                'statuses' => [
                    ['value' => 'pending', 'label' => 'Menunggu Verifikasi'],
                    ['value' => 'diproses', 'label' => 'Sedang Diproses'],
                    ['value' => 'selesai', 'label' => 'Selesai'],
                    ['value' => 'ditolak', 'label' => 'Ditolak'],
                ],
            ],
        ]);
    }
}
