<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialliteController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

// Socialite – Google + Facebook (et autres)
Route::prefix('auth')->group(function () {
    Route::get('/{provider}', [SocialliteController::class, 'authProviderRedirect'])
        ->where('provider', 'google|facebook|github')
        ->name('social.redirect');

    Route::get('/{provider}/callback', [SocialliteController::class, 'socialAuthentication'])
        ->where('provider', 'google|facebook|github')
        ->name('social.callback');
});

Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';