<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register alias middleware
        $middleware->alias([
            'is.admin' => \App\Http\Middleware\IsAdmin::class,
            'is.user' => \App\Http\Middleware\IsUser::class,
            'muzakki.session' => \App\Http\Middleware\CheckMuzakkiSession::class, // BARU
            'mustahik.session' => \App\Http\Middleware\CheckMustahikSession::class, // BARU
        ]);
        
        // Middleware groups (pastikan default group 'web' sudah sesuai)
        $middleware->group('web', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
        
        // Exclude CSRF validation from login attempt (prevent token expired issues)
        $middleware->validateCsrfTokens(except: [
            'login',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();