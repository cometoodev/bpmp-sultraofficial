<?php

use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PageAttachmentController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PageTemplateController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SocialIntegrationController;
use App\Http\Controllers\Admin\StandarPelayananController;
use App\Http\Controllers\Admin\SurveyController;
use App\Http\Controllers\Admin\UltRequestController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GratificationController;
use App\Http\Controllers\GuestbookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\SkmDashboardController;
use App\Http\Controllers\SpmbAdminController;
use App\Http\Controllers\UltPublicController;
use App\Http\Controllers\UltSurveyController;
use App\Models\Agenda;
use App\Models\Category;
use App\Models\Guestbook;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Existing Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/berita', [NewsController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('berita.show');
Route::get('/kisah-inspiratif', [NewsController::class, 'kisahInspiratif'])->name('pages.kisah-inspiratif');
Route::get('/events-webinar', [EventController::class, 'index'])->name('events.index');

// API Endpoint Kisah Inspiratif
Route::get('/api/kisah-inspiratif', function () {
    $category = Category::where('name', 'Kisah Inspiratif')
        ->orWhere('slug', 'kisah-inspiratif')
        ->first();

    if (! $category) {
        return response()->json([]);
    }

    $posts = Post::where('category_id', $category->id)
        ->whereIn('status', ['published', 'Published'])
        ->latest('published_at')
        ->latest('id')
        ->take(8)
        ->get()
        ->map(function ($post) {
            $imageUrl = null;
            if ($post->thumbnail) {
                $imageUrl = filter_var($post->thumbnail, FILTER_VALIDATE_URL)
                    ? $post->thumbnail
                    : asset('storage/'.ltrim($post->thumbnail, '/'));
            }

            return [
                'id' => $post->id,
                'title' => $post->title,
                'url' => route('berita.show', $post->slug),
                'image' => $imageUrl,
                'date' => Carbon::parse($post->published_at ?? $post->created_at)->format('d M Y'),
                'excerpt' => Str::limit(strip_tags($post->content ?? $post->excerpt), 100),
            ];
        });

    return response()->json($posts);
})->name('api.kisah-inspiratif');

Route::get('/news/{slug}', function ($slug) {
    return redirect()->route('berita.show', $slug);
})->name('news.show');

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

        // Profile & Akun Admin
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

        // Modul Khusus Super Admin / Admin Utama
        Route::middleware('superadmin')->group(function () {
            Route::resource('users', UserController::class);
        });

        // Pages Management
        Route::get('pages/{page}/preview', [PageController::class, 'preview'])->name('pages.preview');
        Route::get('pages/{page}/builder', [PageController::class, 'builder'])->name('pages.builder');
        Route::post('pages/{page}/builder', [PageController::class, 'saveBuilder'])->name('pages.builder.save');
        Route::post('pages/builder/upload-image', [PageController::class, 'uploadImage'])->name('pages.builder.upload_image');
        Route::resource('pages', PageController::class);

        // Page Attachments / Dokumen Terlampir
        Route::get('pages/{page}/attachments', [PageAttachmentController::class, 'index'])->name('pages.attachments');
        Route::post('pages/{page}/attachments', [PageAttachmentController::class, 'store'])->name('pages.attachments.store');
        Route::put('pages/{page}/attachments/{attachment}', [PageAttachmentController::class, 'update'])->name('pages.attachments.update');
        Route::delete('pages/{page}/attachments/{attachment}', [PageAttachmentController::class, 'destroy'])->name('pages.attachments.destroy');
        Route::post('pages/{page}/attachments/reorder', [PageAttachmentController::class, 'reorder'])->name('pages.attachments.reorder');
        Route::patch('pages/{page}/attachments/{attachment}/toggle-status', [PageAttachmentController::class, 'toggleStatus'])->name('pages.attachments.toggle-status');

        // Page Templates API
        Route::prefix('api/templates')->name('api.templates.')->group(function () {
            Route::get('/', [PageTemplateController::class, 'index'])->name('index');
            Route::post('/', [PageTemplateController::class, 'store'])->name('store');
            Route::post('reorder', [PageTemplateController::class, 'reorder'])->name('reorder');
            Route::put('{id}', [PageTemplateController::class, 'update'])->name('update');
            Route::delete('{id}', [PageTemplateController::class, 'destroy'])->name('destroy');
        });

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

        // Integrasi Media Sosial
        Route::get('social-integrations', [SocialIntegrationController::class, 'index'])->name('social.index');
        Route::put('social-integrations/{socialIntegration}', [SocialIntegrationController::class, 'update'])->name('social.update');

        // Announcements
        Route::resource('announcements', AnnouncementController::class);

        // Manajemen Agenda Kegiatan
        Route::resource('agendas', AgendaController::class)->only(['index', 'store', 'update', 'destroy']);

        // Manajemen Events & Webinar
        Route::get('events', [EventController::class, 'adminIndex'])->name('events.index');
        Route::post('events', [EventController::class, 'store'])->name('events.store');
        Route::put('events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

        // Manajemen Maklumat Pelayanan & Penghargaan
        Route::get('awards', [AwardController::class, 'index'])->name('awards.index');
        Route::post('awards', [AwardController::class, 'store'])->name('awards.store');
        Route::put('awards/{award}', [AwardController::class, 'update'])->name('awards.update');
        Route::delete('awards/{award}', [AwardController::class, 'destroy'])->name('awards.destroy');

        // Standar Pelayanan (Dokumen Fleksibel: PDF, Word, & Google Drive)
        Route::post('standar-pelayanan/reorder', [StandarPelayananController::class, 'reorder'])->name('standar-pelayanan.reorder');
        Route::patch('standar-pelayanan/{standarPelayanan}/toggle-status', [StandarPelayananController::class, 'toggleStatus'])->name('standar-pelayanan.toggle-status');
        Route::resource('standar-pelayanan', StandarPelayananController::class)->only(['index', 'store', 'update', 'destroy']);

        // Manajemen Pengaduan Masyarakat (SPMB)
        Route::get('spmb', [SpmbAdminController::class, 'index'])->name('spmb.index');
        Route::get('spmb/{id}', [SpmbAdminController::class, 'show'])->name('spmb.show');
        Route::patch('spmb/{id}/status', [SpmbAdminController::class, 'updateStatus'])->name('spmb.status');
        Route::delete('spmb/{id}', [SpmbAdminController::class, 'destroy'])->name('spmb.destroy');

        // Manajemen Lapor Gratifikasi
        Route::get('gratifikasi', [GratificationController::class, 'index'])->name('gratification.index');
        Route::get('gratifikasi/{id}', [GratificationController::class, 'show'])->name('gratification.show');
        Route::patch('gratifikasi/{id}/status', [GratificationController::class, 'updateStatus'])->name('gratification.status');
        Route::delete('gratifikasi/{id}', [GratificationController::class, 'destroy'])->name('gratification.destroy');

        // Manajemen Pesan Masuk (Hubungi Kami)
        Route::get('pesan-masuk', [ContactController::class, 'index'])->name('contacts.index');
        Route::delete('pesan-masuk/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');

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
| Admin Rekap Buku Tamu ULT (Protected Route)
|--------------------------------------------------------------------------
*/
Route::get('/admin/buku-tamu', [GuestbookController::class, 'index'])
    ->middleware('auth')
    ->name('admin.guestbook.index');

Route::put('/admin/buku-tamu/{id}', [GuestbookController::class, 'update'])
    ->middleware('auth')
    ->name('admin.guestbook.update');

Route::delete('/admin/buku-tamu/{id}', [GuestbookController::class, 'destroy'])
    ->middleware('auth')
    ->name('admin.guestbook.destroy');

Route::get('/admin/buku-tamu/export/{type}', [GuestbookController::class, 'export'])
    ->middleware('auth')
    ->name('admin.guestbook.export');

Route::post('/admin/buku-tamu/import', [GuestbookController::class, 'import'])
    ->middleware('auth')
    ->name('admin.guestbook.import');

Route::post('/admin/buku-tamu/undo-import', [GuestbookController::class, 'undoImport'])
    ->middleware('auth')
    ->name('admin.guestbook.undo-import');

Route::post('/admin/buku-tamu/reset', [GuestbookController::class, 'resetData'])
    ->middleware('auth')
    ->name('admin.guestbook.reset');

Route::get('/admin/buku-tamu/check-duplicates', [GuestbookController::class, 'checkDuplicates'])
    ->middleware('auth')
    ->name('admin.guestbook.check-duplicates');

Route::post('/admin/buku-tamu/remove-duplicates', [GuestbookController::class, 'removeDuplicates'])
    ->middleware('auth')
    ->name('admin.guestbook.remove-duplicates');

Route::post('/admin/buku-tamu/clean-duplicates', [GuestbookController::class, 'cleanDuplicates'])
    ->middleware('auth')
    ->name('admin.guestbook.clean-duplicates');

Route::get('/admin/dashboard-skm', [SkmDashboardController::class, 'index'])
    ->middleware('auth')
    ->name('admin.skm.dashboard');

Route::get('/admin/dashboard-skm/export/{type}', [SkmDashboardController::class, 'export'])
    ->middleware('auth')
    ->name('admin.skm.export');

Route::post('/admin/dashboard-skm/import', [SkmDashboardController::class, 'import'])
    ->middleware('auth')
    ->name('admin.skm.import');

Route::post('/admin/dashboard-skm/undo-import', [SkmDashboardController::class, 'undoImport'])
    ->middleware('auth')
    ->name('admin.skm.undo-import');

Route::post('/admin/dashboard-skm/reset', [SkmDashboardController::class, 'resetData'])
    ->middleware('auth')
    ->name('admin.skm.reset');

Route::get('/admin/dashboard-skm/check-duplicates', [SkmDashboardController::class, 'checkDuplicates'])
    ->middleware('auth')
    ->name('admin.skm.check-duplicates');

Route::post('/admin/dashboard-skm/remove-duplicates', [SkmDashboardController::class, 'removeDuplicates'])
    ->middleware('auth')
    ->name('admin.skm.remove-duplicates');

Route::post('/admin/clean-duplicates', [SkmDashboardController::class, 'cleanDuplicates'])
    ->middleware('auth')
    ->name('admin.skm.clean-duplicates');

Route::post('/admin/dashboard-skm/clean-duplicates', [SkmDashboardController::class, 'cleanDuplicates'])
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin Manajemen Permohonan & Tiket Layanan ULT
|--------------------------------------------------------------------------
*/
Route::prefix('admin/ult-requests')->name('admin.ult.')->middleware('auth')->group(function () {
    Route::get('/', [UltRequestController::class, 'index'])->name('index');
    Route::put('/{ultRequest}/status', [UltRequestController::class, 'updateStatus'])->name('status.update');
    Route::delete('/{ultRequest}', [UltRequestController::class, 'destroy'])->name('destroy');
    Route::get('/export', [UltRequestController::class, 'export'])->name('export');
});

/*
|--------------------------------------------------------------------------
| Portal Unit Layanan Terpadu (ULT) Publik & Form Native
|--------------------------------------------------------------------------
*/
Route::get('/ult', [UltPublicController::class, 'index'])->name('ult.index');
Route::get('/ult-unit-layanan-terpadu', [UltPublicController::class, 'index']);
Route::get('/ult/status-tiket', [UltPublicController::class, 'checkStatus'])->name('ult.track');
Route::post('/ult/online', [UltPublicController::class, 'storeOnline'])->name('ult.online.store');
Route::post('/ult/tatap-muka', [UltPublicController::class, 'storeTatapMuka'])->name('ult.tatapmuka.store');
Route::post('/ult/keliling', [UltPublicController::class, 'storeKeliling'])->name('ult.keliling.store');

/*
|--------------------------------------------------------------------------
| ULT Buku Tamu & Kuisioner Layanan
|--------------------------------------------------------------------------
*/
Route::get('/buku-tamu', [GuestbookController::class, 'create'])->name('guestbook.create');
Route::post('/buku-tamu', [GuestbookController::class, 'store'])->name('guestbook.store');
Route::get('/buku-tamu/sukses/{id}', function (int $id) {
    $guestbook = Guestbook::findOrFail($id);

    return view('guestbook.success', compact('guestbook'));
})->name('guestbook.success');

Route::get('/kuisioner/{guestbook_id}', [UltSurveyController::class, 'create'])->name('survey.create');
Route::post('/kuisioner/{guestbook_id}', [UltSurveyController::class, 'store'])->name('survey.store');
Route::get('/kuisioner-terima-kasih', function () {
    return view('survey.thanks');
})->name('survey.thanks');

// Route untuk Publik (Simpan Form Pengaduan SPMB)
Route::post('/spmb/store', [SpmbAdminController::class, 'store'])->name('spmb.store');
Route::post('/spmb', [SpmbAdminController::class, 'store']);

// Route untuk Publik (Simpan Form Lapor Gratifikasi)
Route::post('/lapor-gratifikasi/store', [GratificationController::class, 'store'])->name('gratification.store');
Route::post('/lapor-gratifikasi', [GratificationController::class, 'store']);

// Route untuk Publik (Simpan Form Kontak / Hubungi Kami)
Route::post('/hubungi-kami/store', [ContactController::class, 'store'])->name('contact.store');
Route::post('/hubungi-kami', [ContactController::class, 'store']);
Route::post('/kontak/store', [ContactController::class, 'store']);
Route::post('/kontak', [ContactController::class, 'store']);

// Route untuk Download / Akses Lampiran Halaman Publik
Route::get('/unduh-lampiran/{attachment}', [PublicPageController::class, 'downloadAttachment'])->name('pages.attachments.download');

/*
|--------------------------------------------------------------------------
| Public Dynamic Pages (Must remain at the very end of web.php)
|--------------------------------------------------------------------------
*/
Route::get('/profil-lembaga', [PublicPageController::class, 'profilLembaga'])->name('profil.index');

Route::get('/halaman/{slug}', [PublicPageController::class, 'show'])
    ->where('slug', '.*')
    ->name('pages.show.halaman');

Route::get('/{slug}', [PublicPageController::class, 'show'])
    ->where('slug', '.*')
    ->name('pages.show');
