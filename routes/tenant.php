<?php

declare(strict_types=1);

use App\Http\Controllers\Tenant\QuizController;
use App\Http\Controllers\Tenant\TenantController;
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

Route::middleware([
    'web',
    'set-auth-guard',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Auth Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('guest')->group(base_path('routes/loginGuest.php'));
    Route::middleware('auth:tenant')->group(base_path('routes/loginAuth.php'));

    /*
    |--------------------------------------------------------------------------
    | Dashboard Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/', [TenantController::class, 'home'])->name('home');
    Route::get('/dashboard', [TenantController::class, 'dashboard'])->middleware("auth:tenant")->name('dashboard');
    Route::get('/quiz/{quiz}/subscribe', [QuizController::class, 'subscribe'])->middleware("auth:tenant")->name('quiz.subscribe');

    /*
    |--------------------------------------------------------------------------
    | Profile Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth:tenant')->group(base_path('routes/profile.php'));

});
