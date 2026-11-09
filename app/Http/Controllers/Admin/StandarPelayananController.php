<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StandarPelayanan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class StandarPelayananController extends Controller
{
    public function index(Request $request): View
    {
        $query = StandarPelayanan::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('is_active', $request->status === 'active');
        }

        $dokumens = $query->orderBy('order_position', 'asc')->orderBy('id', 'asc')->get();

        $categories = [
            'Umum',
            'Pendidikan',
            'Perizinan',
            'Pengaduan',
            'Kepegawaian',
            'Informasi Publik',
            'Sarana Prasarana',
        ];

        return view('admin.standar-pelayanan.index', compact('dokumens', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'source_type' => 'required|in:file,drive_link',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:30720',
            'pdf_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:30720',
            'drive_url' => 'nullable|url|max:2048',
        ]);

        $sourceType = $request->input('source_type', 'file');
        $file = $request->file('file_dokumen') ?: $request->file('pdf_file');

        if ($sourceType === 'file' && ! $file) {
            return redirect()->back()->withErrors(['file_dokumen' => 'File dokumen wajib dipilih jika menggunakan tipe file lokal.'])->withInput();
        }

        if ($sourceType === 'drive_link' && ! $request->filled('drive_url')) {
            return redirect()->back()->withErrors(['drive_url' => 'Tautan Google Drive wajib diisi jika memilih opsi link eksternal.'])->withInput();
        }

        $filePath = '';
        $fileSize = '';
        $fileExt = 'pdf';

        if ($sourceType === 'file' && $file) {
            $path = $file->store('standar-pelayanan', 'public');
            $filePath = asset('storage/'.$path);
            $fileExt = strtolower($file->getClientOriginalExtension());

            $bytes = $file->getSize();
            $fileSize = $bytes >= 1048576
                ? number_format($bytes / 1048576, 2).' MB'
                : number_format($bytes / 1024, 2).' KB';
        } else {
            $filePath = $request->input('drive_url');
            $fileSize = 'Google Drive';
            $fileExt = 'link';
        }

        $maxOrder = StandarPelayanan::max('order_position') ?? 0;

        StandarPelayanan::create([
            'title' => $request->title,
            'source_type' => $sourceType,
            'file_extension' => $fileExt,
            'category' => $request->input('category', 'Umum') ?: 'Umum',
            'order_position' => $maxOrder + 1,
            'is_active' => $request->boolean('is_active', true),
            'download_count' => 0,
            'file_path' => $filePath,
            'file_size' => $fileSize,
            'uploaded_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Dokumen standar pelayanan berhasil ditambahkan!');
    }

    public function update(Request $request, StandarPelayanan $standarPelayanan): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'source_type' => 'required|in:file,drive_link',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:30720',
            'drive_url' => 'nullable|url|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $sourceType = $request->input('source_type', 'file');
        $file = $request->file('file_dokumen');

        $filePath = $standarPelayanan->file_path;
        $fileSize = $standarPelayanan->file_size;
        $fileExt = $standarPelayanan->file_extension;

        if ($sourceType === 'file') {
            if ($file) {
                // Hapus file lama jika disimpan di storage lokal
                $this->deletePhysicalFile($standarPelayanan->file_path);

                $path = $file->store('standar-pelayanan', 'public');
                $filePath = asset('storage/'.$path);
                $fileExt = strtolower($file->getClientOriginalExtension());

                $bytes = $file->getSize();
                $fileSize = $bytes >= 1048576
                    ? number_format($bytes / 1048576, 2).' MB'
                    : number_format($bytes / 1024, 2).' KB';
            }
        } else {
            // Jika beralih ke link drive, hapus file lama jika ada di lokal
            if ($standarPelayanan->source_type === 'file') {
                $this->deletePhysicalFile($standarPelayanan->file_path);
            }

            if ($request->filled('drive_url')) {
                $filePath = $request->input('drive_url');
            }
            $fileSize = 'Google Drive';
            $fileExt = 'link';
        }

        $standarPelayanan->update([
            'title' => $request->title,
            'source_type' => $sourceType,
            'file_extension' => $fileExt,
            'category' => $request->input('category', 'Umum') ?: 'Umum',
            'file_path' => $filePath,
            'file_size' => $fileSize,
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : $standarPelayanan->is_active,
        ]);

        return redirect()->back()->with('success', 'Dokumen standar pelayanan berhasil diperbarui!');
    }

    public function destroy(StandarPelayanan $standarPelayanan): RedirectResponse
    {
        $this->deletePhysicalFile($standarPelayanan->file_path);

        $standarPelayanan->delete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus!');
    }

    public function reorder(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:standar_pelayanans,id',
        ]);

        foreach ($request->ids as $position => $id) {
            StandarPelayanan::where('id', $id)->update([
                'order_position' => $position + 1,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan dokumen berhasil diperbarui!',
        ]);
    }

    public function toggleStatus(StandarPelayanan $standarPelayanan): JsonResponse|RedirectResponse
    {
        $standarPelayanan->is_active = ! $standarPelayanan->is_active;
        $standarPelayanan->save();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'is_active' => $standarPelayanan->is_active,
                'message' => 'Status publikasi dokumen berhasil diperbarui!',
            ]);
        }

        return redirect()->back()->with('success', 'Status publikasi dokumen berhasil diperbarui!');
    }

    private function deletePhysicalFile(?string $filePath): void
    {
        if (! $filePath || filter_var($filePath, FILTER_VALIDATE_URL) === false && ! str_contains($filePath, 'storage/')) {
            return;
        }

        $relativePath = str_replace(asset('storage/'), '', $filePath);
        $relativePath = ltrim(str_replace('/storage/', '', $relativePath), '/');

        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}
