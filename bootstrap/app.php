<?php

use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Hanya reverse proxy di loopback/jaringan privat (Nginx host, jaringan Docker, cloudflared)
        // yang dipercaya; klien publik tidak bisa memalsukan IP lewat X-Forwarded-For.
        $middleware->trustProxies(at: ['127.0.0.1', '::1', '10.0.0.0/8', '172.16.0.0/12', '192.168.0.0/16']);
        $middleware->web(append: [SecurityHeaders::class]);
        $middleware->redirectGuestsTo(fn (Request $request) => route('apanel.login'));
        $middleware->redirectUsersTo(fn (Request $request) => route('apanel.dashboard'));
        $middleware->alias([
            'prevent.back' => PreventBackHistory::class,
            'admin' => EnsureUserIsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
