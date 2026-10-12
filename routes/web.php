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
use App\Http\Controllers\Admin\SurveyController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PublicPageController;
use App\Models\Announcement;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Post;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Existing Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $banners = Banner::where('status', true)->orderBy('order', 'asc')->get();
    $announcements = Announcement::where('status', 'published')->latest('published_at')->take(5)->get();

    $featuredPosts = Post::with('category', 'author')
        ->where('status', 'published')
        ->latest('published_at')
        ->take(3)
        ->get();

    $sidePosts = Post::with('category', 'author')
        ->where('status', 'published')
        ->latest('published_at')
        ->skip(3)
        ->take(3)
        ->get();

    $settings = DB::table('settings')->where('group', 'general')->pluck('value', 'key');

    $surveys = Survey::orderBy('year', 'desc')->orderBy('period', 'asc')->get();
    $activeSurvey = null;
    if (request()->filled('survey_id')) {
        $activeSurvey = Survey::find(request('survey_id'));
    } elseif (request()->filled('survey_year') && request()->filled('survey_period')) {
        $activeSurvey = Survey::where('year', request('survey_year'))
            ->where('period', request('survey_period'))
            ->first();
    } elseif (request()->filled('survey_year')) {
        $activeSurvey = Survey::where('year', request('survey_year'))->where('is_active', true)->first()
            ?? Survey::where('year', request('survey_year'))->first();
    }
    if (! $activeSurvey) {
        $activeSurvey = Survey::where('is_active', true)->first() ?? $surveys->first();
    }

    return view('welcome', compact('banners', 'announcements', 'featuredPosts', 'sidePosts', 'settings', 'activeSurvey', 'surveys'));
})->name('home');

Route::get('/berita', function (Request $request) {
    $query = Post::with('category', 'author')->where('status', 'published');

    if ($request->filled('kategori')) {
        $query->whereHas('category', function ($q) use ($request) {
            $q->where('slug', $request->kategori);
        });
    }

    if ($request->filled('q')) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%'.$request->q.'%')
                ->orWhere('content', 'like', '%'.$request->q.'%');
        });
    }

    $posts = $query->latest('published_at')->paginate(9)->withQueryString();
    $categories = Category::where('is_active', true)->get();

    return view('berita.index', compact('posts', 'categories'));
})->name('berita.index');

Route::get('/berita/{slug}', function ($slug) {
    $post = Post::with('category', 'author')
        ->where('slug', $slug)
        ->orWhere('id', $slug)
        ->first();

    if (! $post) {
        return view('berita.show', ['id' => $slug, 'post' => null]);
    }

    $relatedPosts = Post::with('category')
        ->where('id', '!=', $post->id)
        ->where('status', 'published')
        ->latest('published_at')
        ->take(3)
        ->get();

    return view('berita.show', compact('post', 'relatedPosts'));
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
        Route::post('pages/builder/upload-image', [PageController::class, 'uploadImage'])->name('pages.builder.upload_image');
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

        // Survei Kepuasan Masyarakat (SKM)
        Route::get('surveys/template', [SurveyController::class, 'downloadTemplate'])->name('surveys.template');
        Route::post('surveys/{survey}/active', [SurveyController::class, 'setActive'])->name('surveys.active');
        Route::post('surveys/{survey}/recalculate', [SurveyController::class, 'recalculate'])->name('surveys.recalculate');
        Route::resource('surveys', SurveyController::class);
    });

/*
|--------------------------------------------------------------------------
| Public Dynamic Pages (Must remain at the very end of web.php)
|--------------------------------------------------------------------------
*/
Route::get('/{slug}', [PublicPageController::class, 'show'])
    ->where('slug', '^[a-zA-Z0-9\-_]+$')
    ->name('pages.show');
