<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\InitializeTenancyByRequestData;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::group([
    'prefix' => config('sanctum.prefix', 'sanctum')
], static function () {
    Route::get('/csrf-cookie', [CsrfCookieController::class, 'show'])
        ->middleware([
            'web',
            InitializeTenancyByRequestData::class,
        ])->name('sanctum.csrf-cookie');
});

Route::group([
    'middleware' => [
        'web',
        InitializeTenancyByRequestData::class,
    ]
], function () {
    Route::get('/', fn() => 'Tenant: <b>' . tenant('id') . '</b>')->name('tenant.index');

    Route::get('/ping', fn() => response()->json(['pong' => time()]))->name('ping');
});

require __DIR__ . '/tenant_api.php';
