<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsController extends Controller
{
    /**
     * Menampilkan halaman Berita dengan filter kategori dinamis & pencarian.
     */
    public function index(Request $request): View
    {
        $query = Post::with('category', 'author')->published();

        $categoryParam = $request->input('category') ?? $request->input('kategori');

        if (! empty($categoryParam) && ! in_array(strtolower($categoryParam), ['semua', 'semua kategori', 'all'])) {
            $query->whereHas('category', function ($q) use ($categoryParam) {
                $q->where('slug', $categoryParam)
                    ->orWhere('name', $categoryParam)
                    ->orWhere('slug', Str::slug($categoryParam));
            });
        }

        $searchTerm = $request->input('q') ?? $request->input('search');
        if (! empty($searchTerm)) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%'.$searchTerm.'%')
                    ->orWhere('content', 'like', '%'.$searchTerm.'%');
            });
        }

        $posts = $query->latest('published_at')->paginate(9)->withQueryString();
        $newsList = $posts;
        $categories = Category::where('is_active', true)->get();
        $category = $categoryParam;

        return view('berita.index', compact('posts', 'newsList', 'categories', 'category'));
    }

    /**
     * Menampilkan detail halaman Berita.
     */
    public function show(string $slug): View
    {
        $post = Post::with('category', 'author')
            ->where('slug', $slug)
            ->orWhere('id', $slug)
            ->first();

        if (! $post) {
            return view('berita.show', ['id' => $slug, 'post' => null]);
        }

        $relatedPosts = Post::with('category')
            ->where('id', '!=', $post->id)
            ->published()
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('berita.show', compact('post', 'relatedPosts'));
    }

    /**
     * Menampilkan halaman khusus Kisah Inspiratif secara otomatis dari database Berita.
     */
    public function kisahInspiratif(): View
    {
        $kisahList = Post::with('category', 'author')
            ->whereHas('category', function ($q) {
                $q->where('name', 'Kisah Inspiratif')
                    ->orWhere('slug', 'kisah-inspiratif');
            })
            ->published()
            ->latest('published_at')
            ->take(8)
            ->get();

        return view('pages.kisah-inspiratif', compact('kisahList'));
    }
}
