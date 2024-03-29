<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('locale')) {
            App::setLocale($request->session()->get('locale'));
        }

        else {
            $locale = $request->getPreferredLanguage(['en', 'ru']);

            App::setLocale($locale);
            $request->session()->put('locale', $locale);
        }

        return $next($request);
    }
}
