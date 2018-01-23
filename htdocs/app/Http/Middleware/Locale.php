<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\App;

class Locale
{
    public function handle($request, Closure $next)
    {
        $sLocale = Cookie::get('locale');
        if (in_array($sLocale, Config::get('settings.user.locales'))) {
            $sRetLocale = $sLocale;
        } else {
            $sRetLocale = Config::get('app.locale');
            Cookie::queue('locale', $sRetLocale, 0);
        }
        App::setLocale($sRetLocale);
        return $next($request);
    }
}