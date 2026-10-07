<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function index(Request $request): View
    {
        $media = Media::latest()->paginate(24);

        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|max:5120', // Max 5MB
        ]);

        $file = $request->file('file');

        $originalName = $file->getClientOriginalName();
        $mimeType = $file->getMimeType();
        $size = $file->getSize();

        // Ensure safe filename
        $safeName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)).'-'.time().'.'.$file->getClientOriginalExtension();

        $path = $file->storeAs('media', $safeName, 'public');

        Media::create([
            'filename' => $originalName,
            'path' => $path,
            'mime_type' => $mimeType,
            'size' => $size,
            'uploaded_by' => Auth::id(),
        ]);

        return redirect()->route('admin.media.index')
            ->with('success', 'File berhasil diunggah.');
    }

    public function destroy(Media $medium): RedirectResponse
    {
        if (Storage::disk('public')->exists($medium->path)) {
            Storage::disk('public')->delete($medium->path);
        }

        $medium->delete();

        return redirect()->route('admin.media.index')
            ->with('success', 'File berhasil dihapus.');
    }
}
