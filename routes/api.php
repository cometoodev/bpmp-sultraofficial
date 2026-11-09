<?php

use App\Http\Controllers\Api\ContactMessageController;
use App\Http\Controllers\Api\GuestbookController;
use App\Http\Controllers\Api\SkmSurveyController;
use App\Http\Controllers\Api\SpmbReportController;
use App\Http\Controllers\Api\UltRequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes (Mobile React Native & External Integrations)
|--------------------------------------------------------------------------
|
| Stateless RESTful API routes loaded by Laravel with "api" middleware.
| Does not require CSRF token and returns JSON responses.
|
*/

$registerServices = function (): void {
    // 1. Buku Tamu (Guestbook)
    Route::get('guestbooks/options', [GuestbookController::class, 'options'])->name('guestbooks.options');
    Route::apiResource('guestbooks', GuestbookController::class)->only(['index', 'store', 'show']);

    // 2. Survey Kepuasan Masyarakat (SKM)
    Route::get('skm/questions', [SkmSurveyController::class, 'questions'])->name('skm.questions');
    Route::apiResource('skm', SkmSurveyController::class)->only(['index', 'store', 'show']);

    // 3. Unit Layanan Terpadu (ULT)
    Route::get('ult/options', [UltRequestController::class, 'options'])->name('ult.options');
    Route::get('ult/track/{ticket}', [UltRequestController::class, 'track'])->name('ult.track');
    Route::apiResource('ult/requests', UltRequestController::class)->names('ult.requests')->only(['index', 'store', 'show']);

    // 4. SPMB (Sistem Penerimaan / Layanan Pengaduan SPMB)
    Route::get('spmb/options', [SpmbReportController::class, 'options'])->name('spmb.options');
    Route::apiResource('spmb/reports', SpmbReportController::class)->names('spmb.reports')->only(['index', 'store', 'show']);

    // 5. Hubungi Kami / Pesan Masuk (Contact Messages)
    Route::get('contacts/info', [ContactMessageController::class, 'info'])->name('contacts.info');
    Route::apiResource('contacts', ContactMessageController::class)->only(['index', 'store', 'show']);
};

// API Version 1 (Recommended for mobile app endpoints)
Route::prefix('v1')->name('api.v1.')->group($registerServices);

// Default API routes (Direct aliases without /v1)
Route::name('api.')->group($registerServices);
