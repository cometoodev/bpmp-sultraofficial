<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StandarPelayanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class StandarPelayananController extends Controller
{
    public function index(): View
    {
        $dokumens = StandarPelayanan::orderBy('id', 'asc')->get();

        return view('admin.standar-pelayanan.index', compact('dokumens'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'pdf_file' => 'required|mimes:pdf|max:20480', // Maksimal 20MB
        ]);

        $file = $request->file('pdf_file');
        $path = $file->store('standar-pelayanan', 'public');

        // Hitung ukuran file secara otomatis murni dari backend (KB / MB)
        $bytes = $file->getSize();
        $size = $bytes >= 1048576
            ? number_format($bytes / 1048576, 2).' MB'
            : number_format($bytes / 1024, 2).' KB';

        StandarPelayanan::create([
            'title' => $request->title,
            'file_path' => asset('storage/'.$path),
            'file_size' => $size,
            'uploaded_at' => now(), // Tanggal murni dari sistem backend
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil diunggah!');
    }

    public function destroy(StandarPelayanan $standarPelayanan): RedirectResponse
    {
        // Hapus file fisik dari storage jika ada
        $relativePath = str_replace(asset('storage/'), '', $standarPelayanan->file_path);
        $relativePath = ltrim(str_replace('/storage/', '', $relativePath), '/');

        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }

        $standarPelayanan->delete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus!');
    }
}
