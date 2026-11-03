<?php

use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PageTemplateController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StandarPelayananController;
use App\Http\Controllers\Admin\SurveyController;
use App\Http\Controllers\Admin\UltRequestController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GratificationController;
use App\Http\Controllers\GuestbookController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\SkmDashboardController;
use App\Http\Controllers\SpmbAdminController;
use App\Http\Controllers\UltPublicController;
use App\Http\Controllers\UltSurveyController;
use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\Award;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Event;
use App\Models\Guestbook;
use App\Models\Post;
use App\Models\Survey;
use App\Services\UltSkmService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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
    $totalGuestbook = Guestbook::count();
    $totalPosts = Post::where('status', 'published')->count();
    $awards = Award::orderBy('order', 'asc')->orderBy('created_at', 'desc')->get();
    $events = Event::orderBy('event_date', 'desc')->take(6)->get();
    $agendas = Agenda::orderBy('agenda_date', 'asc')->orderBy('time_start', 'asc')->get();

    $agendaJsonList = $agendas->map(function ($item) {
        $date = Carbon::parse($item->agenda_date);

        return [
            'id' => $item->id,
            'day' => (int) $date->format('j'),
            'month' => (int) $date->format('n') - 1,
            'year' => (int) $date->format('Y'),
            'title' => $item->title,
            'time' => $item->time_start.' - '.$item->time_end.' WITA',
            'description' => $item->description ?? 'Agenda kegiatan resmi BPMP Sultra.',
            'type' => 'primary',
        ];
    });

    if ($agendaJsonList->isEmpty()) {
        $agendaJsonList = collect([
            [
                'id' => 0,
                'day' => (int) date('j'),
                'month' => (int) date('n') - 1,
                'year' => (int) date('Y'),
                'title' => 'Rapat Koordinasi Mingguan BPMP Sultra',
                'time' => '09.00 - 11.30 WITA',
                'description' => 'Koordinasi berkala evaluasi capaian program dan layanan BPMP Sultra.',
                'type' => 'primary',
            ],
        ]);
    }

    $surveys = Survey::orderBy('year', 'desc')->orderBy('period', 'asc')->get();
    $activeSurvey = null;
    if (request()->filled('survey_id')) {
        $activeSurvey = Survey::find(request('survey_id'));
    } else {
        $reqYear = request('skm_tahun', request('survey_year'));
        $reqTwNum = request('skm_triwulan');
        $reqPeriod = $reqTwNum ? ('Triwulan '.$reqTwNum) : request('survey_period');

        if ($reqYear && $reqPeriod) {
            $activeSurvey = Survey::where('year', $reqYear)->where('period', $reqPeriod)->first();
        } elseif ($reqYear) {
            $activeSurvey = Survey::where('year', $reqYear)->where('is_active', true)->first()
                ?? Survey::where('year', $reqYear)->first();
        }
    }
    if (! $activeSurvey) {
        $activeSurvey = Survey::where('is_active', true)->first() ?? $surveys->first();
    }

    // 1. Tangkap Parameter Filter dari URL (Default: Tahun ini, Triwulan 1)
    $tahunSkm = (int) request('skm_tahun', request('survey_year', date('Y')));
    $triwulanSkm = (int) request('skm_triwulan', 1);
    if (! in_array($triwulanSkm, [1, 2, 3, 4], true)) {
        $triwulanSkm = 1;
    }

    // 2. Helper untuk query berdasarkan Triwulan
    $getSurveyByTriwulan = function ($tahun, $triwulan) {
        $query = Guestbook::with('ultSurveyResponse')->whereYear('created_at', $tahun);
        if ($triwulan == 1) {
            $query->whereMonth('created_at', '>=', 1)->whereMonth('created_at', '<=', 3);
        }
        if ($triwulan == 2) {
            $query->whereMonth('created_at', '>=', 4)->whereMonth('created_at', '<=', 6);
        }
        if ($triwulan == 3) {
            $query->whereMonth('created_at', '>=', 7)->whereMonth('created_at', '<=', 9);
        }
        if ($triwulan == 4) {
            $query->whereMonth('created_at', '>=', 10)->whereMonth('created_at', '<=', 12);
        }

        // Ambil data yang memiliki relasi kuisioner saja
        return $query->whereHas('ultSurveyResponse')->get()->pluck('ultSurveyResponse');
    };

    // 4. Hitung juga nilai IKM untuk ke-4 Triwulan (untuk preview angka di tombol tab)
    $skmTabs = [];
    $activeWithData = null;
    $ultSkmService = app(UltSkmService::class);

    for ($i = 1; $i <= 4; $i++) {
        $tabResponses = $getSurveyByTriwulan($tahunSkm, $i);
        $tabCalc = $ultSkmService->calculateSkm($tabResponses);
        $tabScore = $tabCalc['nilai_konversi'];

        // Jika kuisioner buku tamu kosong pada periode ini, fallback ke data survei manual jika tersedia
        if ($tabScore == 0 && isset($surveys)) {
            $matchManualSurvey = $surveys->first(function ($s) use ($tahunSkm, $i) {
                return (int) $s->year === (int) $tahunSkm && (string) $s->period === ('Triwulan '.$i);
            });
            if ($matchManualSurvey && $matchManualSurvey->ikm_score > 0) {
                $tabScore = (float) $matchManualSurvey->ikm_score;
            }
        }

        $skmTabs[$i] = $tabScore;
        if ($tabCalc['total_responden'] > 0 && $activeWithData === null) {
            $activeWithData = $i;
        }
    }

    // Jika user belum memilih triwulan secara spesifik dan triwulan default kosong, pilih triwulan yang memiliki data
    if (! request()->filled('skm_triwulan') && ($skmTabs[$triwulanSkm] ?? 0) == 0 && $activeWithData !== null) {
        $triwulanSkm = $activeWithData;
    }

    // 3. Ambil data utama sesuai filter yang aktif
    $surveyResponses = $getSurveyByTriwulan($tahunSkm, $triwulanSkm);
    $dataSkmUtama = $ultSkmService->calculateSkm($surveyResponses);

    // Fallback harmonis: Jika buku tamu pada periode ini belum ada responden, gunakan record survei manual
    if ($dataSkmUtama['total_responden'] === 0 && $activeSurvey && ! empty($activeSurvey->nrr_elements)) {
        $nrrConverted = [];
        for ($k = 1; $k <= 9; $k++) {
            $uKey = 'u'.$k;
            $qKey = 'q'.$k;
            $val = (float) ($activeSurvey->nrr_elements[$uKey] ?? $activeSurvey->nrr_elements[$qKey] ?? 0);
            $nrrConverted[$qKey] = $val;
            $nrrConverted[$k] = $val;
        }

        $dataSkmUtama = [
            'total_responden' => (int) $activeSurvey->total_respondents,
            'nrr_per_unsur' => $nrrConverted,
            'nilai_ikm' => (float) ($activeSurvey->total_nrt ?? round(($activeSurvey->ikm_score / 25), 3)),
            'nilai_konversi' => (float) $activeSurvey->ikm_score,
            'mutu' => $activeSurvey->ikm_service_quality ?? 'B',
            'kinerja' => $activeSurvey->ikm_performance_category ?? 'Baik',
            'unsur_terbaik' => null,
            'unsur_terendah' => null,
        ];
    }

    // Ambil daftar tahun unik dari buku tamu untuk selector tahun dinamis
    $availableSkmYears = Guestbook::selectRaw('YEAR(created_at) as year')
        ->distinct()
        ->pluck('year')
        ->filter()
        ->map(fn ($y) => (int) $y)
        ->toArray();

    if (empty($availableSkmYears)) {
        $availableSkmYears = [(int) date('Y'), (int) date('Y') - 1, (int) date('Y') - 2];
    } elseif (! in_array((int) date('Y'), $availableSkmYears, true)) {
        array_unshift($availableSkmYears, (int) date('Y'));
    }
    rsort($availableSkmYears);

    return view('welcome', compact(
        'banners',
        'announcements',
        'featuredPosts',
        'sidePosts',
        'settings',
        'activeSurvey',
        'surveys',
        'tahunSkm',
        'triwulanSkm',
        'dataSkmUtama',
        'skmTabs',
        'availableSkmYears',
        'totalGuestbook',
        'totalPosts',
        'awards',
        'events',
        'agendas',
        'agendaJsonList'
    ));
})->name('home');

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

        // Pages Management
        Route::get('pages/{page}/preview', [PageController::class, 'preview'])->name('pages.preview');
        Route::get('pages/{page}/builder', [PageController::class, 'builder'])->name('pages.builder');
        Route::post('pages/{page}/builder', [PageController::class, 'saveBuilder'])->name('pages.builder.save');
        Route::post('pages/builder/upload-image', [PageController::class, 'uploadImage'])->name('pages.builder.upload_image');
        Route::resource('pages', PageController::class);

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

        // Standar Pelayanan (Dokumen PDF)
        Route::resource('standar-pelayanan', StandarPelayananController::class)->only(['index', 'store', 'destroy']);

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
