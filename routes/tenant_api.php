<?php

declare(strict_types=1);

use App\Domains\Auth\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\InitializeTenancyByRequestData;

/*
|--------------------------------------------------------------------------
| Tenant API Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::name('tenancy.')
    ->middleware([
        'web',
        'api',
        InitializeTenancyByRequestData::class,
//        InitializeTenancyByDomain::class
    ])
    ->prefix('/api/v1')
    ->group(static function () {
        Route::name('auth.')
            ->prefix('/auth')
            ->group(static function () {
                Route::post('login', [AuthController::class, 'login'])->name('login');
                Route::post('register', [AuthController::class, 'register'])->name('register');

                Route::middleware([
                    'auth',
                    'verified',
                ])
                    ->group(static function () {
                        Route::get('/me', fn () => response()->json([
                            'user' => auth()->user()
                        ]))
                            ->name('me');
                    });

            });

        Route::get('/users', fn() => response()->json(\App\Models\User::all()));
        Route::post('/users', [\App\Http\Controllers\UserController::class, 'store']);
    });
