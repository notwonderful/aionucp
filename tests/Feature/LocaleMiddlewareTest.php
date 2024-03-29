<?php

use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

beforeEach(function () {
    Session::start();
    Session::flush();
});

it('sets locale from session', function () {
    Session::put('locale', 'ru');

    $request = Request::create('/', 'GET');
    $request->setLaravelSession(app('session.store'));

    $middleware = new LocaleMiddleware();
    $middleware->handle($request, function () {});

    expect(Session::get('locale'))->toBe('ru');
});

it('sets locale from browser for russian', function () {
    $request = Request::create('/', 'GET', [], [], [], [
        'HTTP_ACCEPT_LANGUAGE' => 'ru,en-US;q=0.9,en;q=0.8',
    ]);
    $request->setLaravelSession(app('session.store'));

    $middleware = new LocaleMiddleware();
    $middleware->handle($request, function () {});

    expect(Session::get('locale'))->toBe('ru');
});

it('sets locale from browser for other languages', function () {
    $request = Request::create('/', 'GET', [], [], [], [
        'HTTP_ACCEPT_LANGUAGE' => 'fr,en-US;q=0.9,en;q=0.8',
    ]);
    $request->setLaravelSession(app('session.store'));

    $middleware = new LocaleMiddleware();
    $middleware->handle($request, function () {});

    expect(Session::get('locale'))->toBe('en');
});

it('switches locale via route', function () {
    $this->get(route('lang.switch', ['locale' => 'ru']))
        ->assertSessionHas('locale', 'ru');

    $this->get(route('lang.switch', ['locale' => 'en']))
        ->assertSessionHas('locale', 'en');
});
