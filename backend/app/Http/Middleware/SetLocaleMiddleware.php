<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

final class SetLocaleMiddleware
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var list<string> $supportedLocales */
        $supportedLocales = config('app.locales', ['en']);

        /** @var string $fallback */
        $fallback = config('app.locale', 'en');

        $locale = $request->getPreferredLanguage($supportedLocales) ?? $fallback;

        App::setLocale($locale);

        return $next($request);
    }
}
