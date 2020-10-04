<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class check
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (isset($request->event)) {
            if ($request->event->organizer->id != Auth::user()->id)
                return abort('404');
        }
        return $next($request)
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate,  pre-check=0, post-check=0, max-age=0')
            ->header('Pragma', 'no-cache');
    }
}
