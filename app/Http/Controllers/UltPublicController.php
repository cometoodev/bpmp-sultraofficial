<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\UltRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UltPublicController extends Controller
{
    /**
     * Tampilkan halaman portal Unit Layanan Terpadu (ULT).
     */
    public function index(Request $request): View
    {
        $page = Page::where('slug', 'ult-unit-layanan-terpadu')->first();

        $trackedTicket = null;
        if ($request->filled('ticket')) {
            $trackedTicket = UltRequest::where('ticket_number', trim($request->input('ticket')))->first();
        }

        return view('pages.ult', compact('page', 'trackedTicket'));
    }

    /**
     * Cek status tiket permohonan via JSON (AJAX).
     */
    public function checkStatus(Request $request)
    {
        $ticket = trim($request->input('ticket', ''));
        if (empty($ticket)) {
            return response()->json([
                'found' => false,
                'message' => 'Silakan masukkan nomor tiket.',
            ], 422);
        }

        $item = UltRequest::where('ticket_number', $ticket)->first();
        if (! $item) {
            return response()->json([
                'found' => false,
                'message' => 'Nomor tiket tidak ditemukan. Pastikan format nomor tiket benar (contoh: ULT-20261031-ABCD).',
            ], 404);
        }

        return response()->json([
            'found' => true,
            'ticket_number' => $item->ticket_number,
            'nama' => $item->nama,
            'kategori' => $item->kategori,
            'type_label' => $item->type_label,
            'status' => $item->status,
            'status_label' => $item->status_label,
            'created_at' => $item->created_at->format('d M Y, H:i').' WITA',
            'catatan_petugas' => $item->catatan_petugas,
        ]);
    }

    /**
     * Simpan pengajuan Layanan Online.
     */
    public function storeOnline(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'required|string|max:30',
            'profesi' => 'nullable|string|max:100',
            'instansi' => 'nullable|string|max:255',
            'kategori' => 'required|string|max:255',
            'keperluan' => 'required|string|max:3000',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'no_hp.required' => 'Nomor HP / WhatsApp wajib diisi.',
            'kategori.required' => 'Silakan pilih kategori layanan.',
            'keperluan.required' => 'Maksud dan tujuan permohonan wajib diisi.',
            'dokumen.max' => 'Ukuran berkas dokumen pendukung maksimal 5MB.',
        ]);

        $dokumenPath = null;
        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $safeName = 'online-'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'-'.time().'.'.$file->getClientOriginalExtension();
            $dokumenPath = $file->storeAs('ult_documents', $safeName, 'public');
        }

        $ticket = UltRequest::generateTicketNumber('online');

        $ultRequest = UltRequest::create([
            'ticket_number' => $ticket,
            'layanan_type' => 'online',
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
            'profesi' => $validated['profesi'] ?? null,
            'instansi' => $validated['instansi'] ?? null,
            'kategori' => $validated['kategori'],
            'keperluan' => $validated['keperluan'],
            'dokumen_path' => $dokumenPath,
            'status' => 'pending',
            'details' => [
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ],
        ]);

        return redirect()->route('ult.index', ['tab' => 'online'])
            ->with('success', "Permohonan Layanan Online berhasil dikirim! Nomor Tiket Anda: {$ticket}. Simpan nomor ini untuk tracking permohonan Anda.");
    }

    /**
     * Simpan registrasi Layanan Tatap Muka (Buku Tamu).
     */
    public function storeTatapMuka(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:30',
            'email' => 'nullable|email|max:255',
            'instansi' => 'required|string|max:255',
            'profesi' => 'nullable|string|max:100',
            'tujuan_kunjungan' => 'required|string|max:255',
            'keperluan' => 'required|string|max:3000',
            'jumlah_orang' => 'nullable|integer|min:1|max:100',
        ], [
            'nama.required' => 'Nama pengunjung wajib diisi.',
            'no_hp.required' => 'Nomor HP / WhatsApp wajib diisi.',
            'instansi.required' => 'Asal instansi / lembaga wajib diisi.',
            'tujuan_kunjungan.required' => 'Tujuan unit layanan wajib dipilih.',
            'keperluan.required' => 'Maksud dan keperluan kunjungan wajib diisi.',
        ]);

        $ticket = UltRequest::generateTicketNumber('tatap_muka');

        UltRequest::create([
            'ticket_number' => $ticket,
            'layanan_type' => 'tatap_muka',
            'nama' => $validated['nama'],
            'email' => $validated['email'] ?? null,
            'no_hp' => $validated['no_hp'],
            'profesi' => $validated['profesi'] ?? null,
            'instansi' => $validated['instansi'],
            'kategori' => $validated['tujuan_kunjungan'],
            'keperluan' => $validated['keperluan'],
            'status' => 'selesai', // Registrasi tatap muka langsung berstatus selesai atau diproses
            'details' => [
                'jumlah_orang' => $validated['jumlah_orang'] ?? 1,
                'ip_address' => $request->ip(),
            ],
        ]);

        return redirect()->route('ult.index', ['tab' => 'tatap-muka'])
            ->with('success', "Registrasi Kunjungan Tatap Muka berhasil! Nomor Antrean/Tiket Anda: {$ticket}. Selamat datang di Unit Layanan Terpadu BPMP Sultra.");
    }

    /**
     * Simpan permohonan Layanan Keliling (Mobile Service).
     */
    public function storeKeliling(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'required|string|max:30',
            'profesi' => 'nullable|string|max:100',
            'instansi' => 'required|string|max:255',
            'kabupaten_kota' => 'nullable|string|max:100',
            'kategori' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_pelaksanaan' => 'nullable|date',
            'keperluan' => 'nullable|string|max:3000',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ], [
            'nama.required' => 'Nama pemohon wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'no_hp.required' => 'Nomor HP / WhatsApp wajib diisi.',
            'instansi.required' => 'Asal instansi pemohon wajib diisi.',
            'dokumen.max' => 'Ukuran berkas surat permohonan maksimal 5MB.',
        ]);

        $dokumenPath = null;
        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $safeName = 'keliling-'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'-'.time().'.'.$file->getClientOriginalExtension();
            $dokumenPath = $file->storeAs('ult_documents', $safeName, 'public');
        }

        $ticket = UltRequest::generateTicketNumber('keliling');

        UltRequest::create([
            'ticket_number' => $ticket,
            'layanan_type' => 'keliling',
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
            'profesi' => $validated['profesi'] ?? null,
            'instansi' => $validated['instansi'],
            'kategori' => $validated['kategori'] ?? 'Layanan Keliling',
            'keperluan' => $validated['keperluan'] ?? null,
            'dokumen_path' => $dokumenPath,
            'status' => 'pending',
            'details' => [
                'kabupaten_kota' => $validated['kabupaten_kota'] ?? null,
                'lokasi' => $validated['lokasi'] ?? null,
                'tanggal_pelaksanaan' => $validated['tanggal_pelaksanaan'] ?? null,
                'ip_address' => $request->ip(),
            ],
        ]);

        return redirect()->route('ult.index', ['tab' => 'keliling'])
            ->with('success', "Permohonan Layanan Keliling berhasil diajukan! Nomor Tiket Anda: {$ticket}. Tim ULT akan segera mengonfirmasi jadwal.");
    }
}
