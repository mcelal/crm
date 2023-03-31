<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
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
//    'prefix'     => '/{tenant}',
    'middleware' => [
        'web',
        InitializeTenancyByDomain::class,
//        PreventAccessFromCentralDomains::class,
    ]
], function () {
    Route::get('/', function () {
        return 'Tenant <b>' . tenant('id') . '</b>';
    });
});
