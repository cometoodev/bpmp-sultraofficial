<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PublicPageController extends Controller
{
    public function show(string $slug): View
    {
        $page = Page::where('slug', $slug)->first();

        if (! $page) {
            abort(404, 'Halaman tidak ditemukan');
        }

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

        return view('pages.show', [
            'page' => $page,
            'otherPages' => $otherPages,
            'isPreview' => ! $page->isPublished(),
        ]);
    }
}
