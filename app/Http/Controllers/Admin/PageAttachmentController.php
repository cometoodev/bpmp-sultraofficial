<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageAttachment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PageAttachmentController extends Controller
{
    public function index(Page $page, Request $request): View
    {
        $query = $page->attachments();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('file_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('status')) {
            if ($request->input('status') === 'active') {
                $query->where('is_active', true);
            } elseif ($request->input('status') === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $attachments = $query->orderBy('order_position', 'asc')->orderBy('id', 'asc')->get();

        $categories = $page->attachments()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->reorder()
            ->distinct()
            ->pluck('category');

        $totalCount = $page->attachments()->count();
        $activeCount = $page->attachments()->where('is_active', true)->count();

        return view('admin.pages.attachments.index', compact(
            'page',
            'attachments',
            'categories',
            'totalCount',
            'activeCount'
        ));
    }

    public function store(Request $request, Page $page): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'source_type' => 'required|in:file,drive,drive_link',
            'file' => 'nullable|required_if:source_type,file|file|max:25600|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,csv',
            'drive_url' => 'nullable|required_if:source_type,drive,drive_link|url|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $orderPosition = ($page->attachments()->max('order_position') ?? 0) + 1;
        $isActive = $request->boolean('is_active', true);
        $sourceType = in_array($validated['source_type'], ['drive', 'drive_link']) ? 'drive' : 'file';

        $attachmentData = [
            'page_id' => $page->id,
            'title' => $validated['title'],
            'category' => $validated['category'] ?? null,
            'source_type' => $sourceType,
            'order_position' => $orderPosition,
            'is_active' => $isActive,
            'download_count' => 0,
            'uploaded_at' => now(),
        ];

        if ($sourceType === 'file' && $request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $originalName = $uploadedFile->getClientOriginalName();
            $extension = strtolower($uploadedFile->getClientOriginalExtension());
            $sizeFormatted = $this->formatBytes($uploadedFile->getSize());

            $filePath = $uploadedFile->store("page-attachments/{$page->id}", 'public');

            $attachmentData['file_path'] = $filePath;
            $attachmentData['file_name'] = $originalName;
            $attachmentData['file_extension'] = $extension;
            $attachmentData['file_size'] = $sizeFormatted;
        } else {
            $attachmentData['file_path'] = $validated['drive_url'];
            $attachmentData['file_name'] = $validated['title'];
            $attachmentData['file_extension'] = 'drive';
            $attachmentData['file_size'] = 'Google Drive';
        }

        $attachment = PageAttachment::create($attachmentData);

        return redirect()->route('admin.pages.attachments', $page)
            ->with('success', "Dokumen '{$attachment->title}' berhasil ditambahkan ke halaman {$page->title}.");
    }

    public function update(Request $request, Page $page, PageAttachment $attachment): RedirectResponse|JsonResponse
    {
        if ($attachment->page_id !== $page->id) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'source_type' => 'required|in:file,drive,drive_link',
            'file' => 'nullable|file|max:25600|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,csv',
            'drive_url' => 'nullable|url|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $newSourceType = in_array($validated['source_type'], ['drive', 'drive_link']) ? 'drive' : 'file';
        $attachment->title = $validated['title'];
        $attachment->category = $validated['category'] ?? null;
        $attachment->is_active = $request->boolean('is_active', true);

        if ($newSourceType === 'file') {
            if ($request->hasFile('file')) {
                // Delete previous file if local
                if ($attachment->source_type === 'file' && $attachment->file_path && Storage::disk('public')->exists($attachment->file_path)) {
                    Storage::disk('public')->delete($attachment->file_path);
                }

                $uploadedFile = $request->file('file');
                $filePath = $uploadedFile->store("page-attachments/{$page->id}", 'public');

                $attachment->source_type = 'file';
                $attachment->file_path = $filePath;
                $attachment->file_name = $uploadedFile->getClientOriginalName();
                $attachment->file_extension = strtolower($uploadedFile->getClientOriginalExtension());
                $attachment->file_size = $this->formatBytes($uploadedFile->getSize());
                $attachment->uploaded_at = now();
            }
        } else {
            // Switched or updated Google Drive link
            if ($request->filled('drive_url')) {
                if ($attachment->source_type === 'file' && $attachment->file_path && Storage::disk('public')->exists($attachment->file_path)) {
                    Storage::disk('public')->delete($attachment->file_path);
                }

                $attachment->source_type = 'drive';
                $attachment->file_path = $validated['drive_url'];
                $attachment->file_name = $validated['title'];
                $attachment->file_extension = 'drive';
                $attachment->file_size = 'Google Drive';
                $attachment->uploaded_at = now();
            }
        }

        $attachment->save();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Dokumen berhasil diperbarui.',
                'attachment' => $attachment,
            ]);
        }

        return redirect()->route('admin.pages.attachments', $page)
            ->with('success', "Dokumen '{$attachment->title}' berhasil diperbarui.");
    }

    public function destroy(Page $page, PageAttachment $attachment): RedirectResponse
    {
        if ($attachment->page_id !== $page->id) {
            abort(404);
        }

        $title = $attachment->title;

        if ($attachment->source_type === 'file' && $attachment->file_path && Storage::disk('public')->exists($attachment->file_path)) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        $attachment->delete();

        return redirect()->route('admin.pages.attachments', $page)
            ->with('success', "Dokumen '{$title}' berhasil dihapus dari halaman {$page->title}.");
    }

    public function reorder(Request $request, Page $page): JsonResponse
    {
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:page_attachments,id',
        ]);

        foreach ($validated['order'] as $position => $id) {
            PageAttachment::where('id', $id)
                ->where('page_id', $page->id)
                ->update(['order_position' => $position + 1]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Urutan dokumen berhasil diperbarui.',
        ]);
    }

    public function toggleStatus(Page $page, PageAttachment $attachment): JsonResponse
    {
        if ($attachment->page_id !== $page->id) {
            return response()->json(['status' => 'error', 'message' => 'Dokumen tidak cocok dengan halaman ini.'], 404);
        }

        $attachment->is_active = ! $attachment->is_active;
        $attachment->save();

        return response()->json([
            'status' => 'success',
            'is_active' => $attachment->is_active,
            'message' => 'Status publikasi dokumen berhasil diperbarui.',
        ]);
    }

    private function formatBytes(int $bytes, int $precision = 1): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision).' '.$units[$pow];
    }
}
