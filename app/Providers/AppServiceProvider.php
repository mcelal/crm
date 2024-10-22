<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Livewire\Features\SupportFileUploads\FilePreviewController;
use Livewire\Livewire;
use Stancl\Tenancy\Controllers\TenantAssetsController;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('viewPulse', function (User $user) {
            return $user->email_verified_at;
        });

        FilePreviewController::$middleware = ['web', 'universal', InitializeTenancyBySubdomain::class];
        TenantAssetsController::$tenancyMiddleware = InitializeTenancyBySubdomain::class;

        Livewire::setUpdateRoute(function ($handle) {
            return \Illuminate\Support\Facades\Route::post('/livewire/update', $handle)
                ->middleware(
                    'web',
                    'universal',
                    InitializeTenancyBySubdomain::class, // or whatever tenancy middleware you use
                );
        });
    }
}
