<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUmkmIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'admin_umkm') {
            $umkm = \App\Models\Umkm::where('owner_id', auth()->id())->first();
            
            // If UMKM doesn't exist or is not active, redirect to verification page
            if (!$umkm || $umkm->status !== 'active') {
                return redirect()->route('umkm.verification');
            }
        }

        return $next($request);
    }
}
