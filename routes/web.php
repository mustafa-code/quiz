<?php

use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\TenantController;
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

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(base_path('routes/loginGuest.php'));
Route::middleware('auth')->group(base_path('routes/loginAuth.php'));

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(base_path('routes/profile.php'));

/*
|--------------------------------------------------------------------------
| Tenants, Quizzes, Questions, and Choices Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::resource('tenants', TenantController::class)->except([
        'show',
    ]);
    Route::resource('quizzes', QuizController::class)->except([
        'show',
    ]);
    Route::resource('questions', QuestionController::class)->except([
        'show',
    ]);
    Route::resource('questions/{question}/choices', ChoiceController::class)->except([
        'show',
    ])->names("questions.choices");
});
