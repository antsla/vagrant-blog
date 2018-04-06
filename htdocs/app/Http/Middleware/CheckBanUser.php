<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class CheckBanUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->flag_banned == 1) {
            return response()->view('admin/errors/banned', ['sTitle' => Lang::get('admin/layout.title_banned')], 403);
        }
        return $next($request);
    }
}
