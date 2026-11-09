<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreSpmbReportRequest;
use App\Http\Resources\SpmbReportResource;
use App\Models\SpmbReport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SpmbReportController extends Controller
{
    /**
     * Menampilkan daftar laporan / pengaduan SPMB dengan filter dan paginasi.
     */
    public function index(Request $request): JsonResponse
    {
        $query = SpmbReport::query()->latest('id');

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->input('per_page', $request->input('limit', 15));
        if ($perPage < 1 || $perPage > 100) {
            $perPage = 15;
        }

        $paginated = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => SpmbReportResource::collection($paginated->items()),
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
     * Menyimpan laporan / pengaduan SPMB dari aplikasi React Native.
     */
    public function store(StoreSpmbReportRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $filePath = null;
        if ($request->hasFile('evidence_file')) {
            $filePath = $request->file('evidence_file')->store('spmb-evidences', 'public');
        }

        $report = SpmbReport::create([
            'category' => $validated['category'] ?? 'spmb',
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'message' => $validated['message'],
            'evidence_file' => $filePath,
            'status' => 'pending',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Laporan pengaduan SPMB Anda berhasil dikirim dan akan segera ditindaklanjuti oleh tim BPMP Sultra.',
            'data' => new SpmbReportResource($report),
        ], 201);
    }

    /**
     * Menampilkan detail satu laporan SPMB.
     */
    public function show(SpmbReport $spmbReport): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => new SpmbReportResource($spmbReport),
        ]);
    }

    /**
     * Mengembalikan daftar opsi kategori & status SPMB untuk aplikasi mobile.
     */
    public function options(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'categories' => [
                    ['value' => 'spmb', 'label' => 'Pengaduan Umum SPMB'],
                    ['value' => 'zonasi', 'label' => 'Jalur Zonasi'],
                    ['value' => 'afirmasi', 'label' => 'Jalur Afirmasi'],
                    ['value' => 'perpindahan', 'label' => 'Jalur Perpindahan Tugas Orang Tua'],
                    ['value' => 'prestasi', 'label' => 'Jalur Prestasi'],
                    ['value' => 'pungli', 'label' => 'Dugaan Pungutan Liar / Suap'],
                ],
                'statuses' => [
                    ['value' => 'pending', 'label' => 'Menunggu Tindak Lanjut'],
                    ['value' => 'processed', 'label' => 'Sedang Diproses'],
                    ['value' => 'completed', 'label' => 'Selesai Ditindaklanjuti'],
                ],
            ],
        ]);
    }
}
