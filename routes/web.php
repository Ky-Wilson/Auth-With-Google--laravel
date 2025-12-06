<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialliteController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

    // Google Socialite Routes
   /*  Route::get('/auth/google', [SocialliteController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google-callback', [SocialliteController::class, 'handleGoogleCallback'])->name('auth.google-callback');
 */
Route::middleware('web')->group(function () {
    Route::get('/auth/google', [SocialliteController::class, 'redirectToGoogle'])
        ->name('auth.google');

    Route::get('/auth/google-callback', [SocialliteController::class, 'handleGoogleCallback']);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
