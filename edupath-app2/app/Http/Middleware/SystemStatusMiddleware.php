<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SystemStatusMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $status = Setting::get('system_status', 'online');

        if ($status === 'offline') {
            if (auth()->check() && method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin()) {
                return $next($request);
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'The system is currently under maintenance. Please try again later.',
                ], 503);
            }

            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}

