<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TrackVisitors
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Abaikan request backend admin, API, aset statis, atau request internal
        if ($request->is('admin*', 'api*', 'livewire*', '_debugbar*') || $request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('DELETE')) {
            return $response;
        }

        try {
            $ip = $request->ip();

            if ($ip) {
                VisitorLog::updateOrCreate(
                    [
                        'ip_address' => $ip,
                        'visited_date' => today()->toDateString(),
                    ],
                    [
                        'last_activity' => now(),
                        'user_agent' => substr((string) $request->userAgent(), 0, 255),
                    ]
                );
            }
        } catch (Throwable $e) {
            // Log silently without breaking user request
        }

        return $response;
    }
}
