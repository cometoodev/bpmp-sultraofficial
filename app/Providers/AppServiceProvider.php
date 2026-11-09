<?php

namespace App\Providers;

use App\Models\VisitorLog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('components.footer', function ($view): void {
            $stats = Cache::remember('visitor_stats_footer', 30, function () {
                $now = now();
                $fiveMinutesAgo = $now->copy()->subMinutes(5);
                $todayDate = $now->toDateString();

                // Pengunjung aktif dalam 5 menit terakhir
                $liveCount = VisitorLog::where('last_activity', '>=', $fiveMinutesAgo)
                    ->distinct('ip_address')
                    ->count('ip_address');

                // Total kunjungan hari ini
                $todayCount = VisitorLog::where('visited_date', $todayDate)
                    ->count();

                // Akumulasi baseline pengunjung lembaga resmi + pencatatan log
                $baselineVisitors = 52480;
                $totalCount = $baselineVisitors + VisitorLog::count();

                return [
                    'liveVisitors' => max(1, $liveCount),
                    'visitorsToday' => max(1, $todayCount),
                    'totalVisitors' => $totalCount,
                ];
            });

            $view->with($stats);
        });
    }
}
