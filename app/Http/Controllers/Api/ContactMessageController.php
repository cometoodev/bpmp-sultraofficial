<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreContactMessageRequest;
use App\Http\Resources\ContactMessageResource;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{
    /**
     * Menampilkan daftar pesan masuk (untuk admin/monitoring via API).
     */
    public function index(Request $request): JsonResponse
    {
        $query = ContactMessage::query()->latest('id');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
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
            'data' => ContactMessageResource::collection($paginated->items()),
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
     * Menyimpan pesan masuk baru dari form Hubungi Kami di aplikasi mobile.
     */
    public function store(StoreContactMessageRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $message = ContactMessage::create($validated);

        // Kirim notifikasi email ke email resmi instansi
        try {
            $targetEmail = config('mail.from.address', 'bpmpsultra@kemdikbud.go.id');
            Mail::to($targetEmail)->send(new ContactMessageMail($validated));
        } catch (\Throwable $e) {
            Log::warning('Gagal mengirim email notifikasi kontak API: '.$e->getMessage());
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Pesan Anda berhasil dikirim dan diteruskan ke sekretariat BPMP Provinsi Sulawesi Tenggara.',
            'data' => new ContactMessageResource($message),
        ], 201);
    }

    /**
     * Menampilkan detail satu pesan masuk.
     */
    public function show(ContactMessage $contact): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => new ContactMessageResource($contact),
        ]);
    }

    /**
     * Mengembalikan informasi profil kontak instansi BPMP Sultra untuk layar Hubungi Kami di mobile.
     */
    public function info(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'institution' => 'Balai Penjaminan Mutu Pendidikan (BPMP) Provinsi Sulawesi Tenggara',
                'ministry' => 'Kementerian Pendidikan Dasar dan Menengah',
                'address' => 'Jl. DI Panjaitan No. 1, Wundudopi, Kec. Baruga, Kota Kendari, Sulawesi Tenggara 93116',
                'phone' => '(0401) 3195277',
                'whatsapp' => '+62 822-9014-9988',
                'email' => 'bpmp.sultra@kemdikbud.go.id',
                'operating_hours' => [
                    'days' => 'Senin - Jumat',
                    'hours' => '08.00 - 16.00 WITA',
                    'break_time' => '12.00 - 13.00 WITA (Jumat: 11.30 - 13.00 WITA)',
                    'holidays' => 'Sabtu, Minggu & Hari Libur Nasional Tutup',
                ],
                'social_media' => [
                    'instagram' => 'https://www.instagram.com/bpmp.sultra/',
                    'facebook' => 'https://www.facebook.com/bpmpsultra/',
                    'youtube' => 'https://www.youtube.com/@bpmpsultra',
                    'website' => 'https://bpmpsultra.kemdikbud.go.id',
                ],
            ],
        ]);
    }
}
