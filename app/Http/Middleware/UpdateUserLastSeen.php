<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserLastSeen
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $userId = Auth::id();
            // Update only every 30 seconds to avoid too many DB writes
            if (!Cache::has('user_seen_' . $userId)) {
                Auth::user()->update(['last_seen_at' => now()]);
                Cache::put('user_seen_' . $userId, true, now()->addSeconds(30));
            }
        }

        return $next($request);
    }
}
