<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Config;
use Cookie;

class SetLocalization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $rawLocale = $request->cookie('locale');

        if (in_array($rawLocale, Config::get('app.locales'), true)) {
            $locale = $rawLocale;
        } else {
            $locale = Config::get('app.locale');
            Cookie::queue('locale', $locale, 525600);
        }

        App::setLocale($locale);
        return $next($request);
    }
}
