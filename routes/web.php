<?php

use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PublicPageController;
use App\Models\Announcement;
use App\Models\Banner;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Existing Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $banners = Banner::where('status', true)->orderBy('order', 'asc')->get();
    $announcements = Announcement::where('status', 'published')->latest('published_at')->take(5)->get();
    
    $latestPosts = \App\Models\Post::with('category', 'author')
        ->where('status', 'published')
        ->latest('published_at')
        ->take(3)
        ->get();

    return view('welcome', compact('banners', 'announcements', 'latestPosts'));
})->name('home');

Route::get('/berita', function () {
    return view('berita.index');
})->name('berita.index');

Route::get('/berita/{id}', function ($id) {
    return view('berita.show', ['id' => $id]);
})->name('berita.show');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| CMS Admin Protected Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', fn () => redirect()->route('admin.dashboard'));
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Pages Management
        Route::get('pages/{page}/preview', [PageController::class, 'preview'])->name('pages.preview');
        Route::get('pages/{page}/builder', [PageController::class, 'builder'])->name('pages.builder');
        Route::post('pages/{page}/builder', [PageController::class, 'saveBuilder'])->name('pages.builder.save');
        Route::resource('pages', PageController::class);

        // Posts / Berita
        Route::resource('posts', PostController::class);

        // Categories
        Route::resource('categories', CategoryController::class);

        // Media Library
        Route::resource('media', MediaController::class);

        // Menus
        Route::resource('menus', MenuController::class);

        // Banners
        Route::resource('banners', BannerController::class);

        // Announcements
        Route::resource('announcements', AnnouncementController::class);

        // SEO Dasar
        Route::get('seo', [SeoController::class, 'index'])->name('seo.index');
        Route::put('seo', [SeoController::class, 'update'])->name('seo.update');

        // Website Settings
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });

/*
|--------------------------------------------------------------------------
| Public Dynamic Pages (Must remain at the very end of web.php)
|--------------------------------------------------------------------------
*/
Route::get('/{slug}', [PublicPageController::class, 'show'])
    ->where('slug', '^[a-zA-Z0-9\-_]+$')
    ->name('pages.show');
