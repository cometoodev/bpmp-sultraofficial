<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageAttachment;
use App\Models\Post;
use App\Models\StandarPelayanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PublicPageController extends Controller
{
    public function show(string $slug): View
    {
        $slug = trim($slug, '/');

        // Cari halaman dengan pencocokan fleksibel (slug tepat, lowercase, slugified, atau format spasi/tanda hubung)
        $page = Page::where('slug', $slug)
            ->orWhere('slug', strtolower($slug))
            ->orWhere('slug', Str::slug($slug))
            ->orWhereRaw('LOWER(slug) = ?', [strtolower($slug)])
            ->first();

        if (! $page) {
            $altSlug = str_replace(['_', ' '], '-', strtolower($slug));
            $page = Page::where('slug', $altSlug)
                ->orWhereRaw('LOWER(slug) = ?', [$altSlug])
                ->first();
        }

        if ($slug === 'standar-pelayanan') {
            $dokumens = StandarPelayanan::where('is_active', true)
                ->orderBy('order_position', 'asc')
                ->orderBy('id', 'asc')
                ->get();

            $otherPages = $page ? Page::published()->where('id', '!=', $page->id)->latest()->take(6)->get() : collect();

            return view('pages.standar-pelayanan', [
                'page' => $page,
                'dokumens' => $dokumens,
                'otherPages' => $otherPages,
                'isPreview' => $page ? ! $page->isPublished() : false,
            ]);
        }

        if (! $page) {
            abort(404, 'Halaman tidak ditemukan');
        }

        $page->load(['activeAttachments']);

        // If draft, only allow authenticated admin preview
        if (! $page->isPublished()) {
            if (! Auth::check() || ! Auth::user()->isAdmin()) {
                abort(404, 'Halaman belum dipublikasikan');
            }
        }

        $otherPages = Page::published()
            ->where('id', '!=', $page->id)
            ->latest()
            ->take(6)
            ->get();

        if ($page->slug === 'profil-lembaga') {
            return view('profil.index', [
                'page' => $page,
                'otherPages' => $otherPages,
                'isPreview' => ! $page->isPublished(),
            ]);
        }

        if ($page->slug === 'kisah-inspiratif') {
            $kisahList = Post::with('category', 'author')
                ->whereHas('category', function ($q) {
                    $q->where('name', 'Kisah Inspiratif')
                        ->orWhere('slug', 'kisah-inspiratif');
                })
                ->published()
                ->latest('published_at')
                ->take(8)
                ->get();

            return view('pages.kisah-inspiratif', [
                'page' => $page,
                'kisahList' => $kisahList,
                'otherPages' => $otherPages,
                'isPreview' => ! $page->isPublished(),
            ]);
        }

        $viewName = view()->exists("pages.{$page->slug}") ? "pages.{$page->slug}" : 'pages.show';

        return view($viewName, [
            'page' => $page,
            'otherPages' => $otherPages,
            'isPreview' => ! $page->isPublished(),
        ]);
    }

    public function profilLembaga(): View
    {
        $page = Page::where('slug', 'profil-lembaga')->where('status', 'published')->firstOrFail();

        return view('profil.index', compact('page'));
    }

    public function downloadAttachment(PageAttachment $attachment): BinaryFileResponse|RedirectResponse
    {
        if (! $attachment->is_active && (! Auth::check() || ! Auth::user()->isAdmin())) {
            abort(404, 'Dokumen tidak ditemukan atau belum dipublikasikan.');
        }

        $attachment->increment('download_count');

        if ($attachment->isDriveLink()) {
            return redirect()->away($attachment->file_path);
        }

        if (! Storage::disk('public')->exists($attachment->file_path)) {
            abort(404, 'Berkas fisik dokumen tidak ditemukan di server.');
        }

        $filePath = Storage::disk('public')->path($attachment->file_path);
        $downloadName = $attachment->file_name ?: basename($attachment->file_path);

        return response()->download($filePath, $downloadName);
    }
}
