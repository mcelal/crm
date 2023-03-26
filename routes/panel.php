<?php

use App\Domains\Panel\Controllers\TenantController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/dashboard', 'dashboard')->name('dashboard');

/*
 * Profile page routes
 */
Route::prefix('/profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

/*
 * Tenant page routes
 */
Route::prefix('/tenants')->name('tenants.')->group(function () {
    Route::get('/', [TenantController::class, 'index'])->name('index');
});



