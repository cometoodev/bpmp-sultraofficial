<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Category;
use App\Models\Media;
use App\Models\Page;
use App\Models\Post;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_pages' => Page::count(),
            'published_pages' => Page::where('status', 'published')->count(),
            'draft_pages' => Page::where('status', 'draft')->count(),
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'total_categories' => Category::count(),
            'total_media' => Media::count(),
            'total_announcements' => Announcement::count(),
        ];

        $recentPages = Page::latest()->take(5)->get();
        $recentPosts = Post::with('category')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPages', 'recentPosts'));
    }
}
