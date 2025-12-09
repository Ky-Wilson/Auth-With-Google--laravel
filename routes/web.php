<?php

use App\Http\Controllers\Dashboard\BrandController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\GlassesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SocialliteController;
use Illuminate\Support\Facades\Route;





// Vitrine publique
Route::get('/', [ShopController::class, 'index'])->name('home');
Route::get('/lunettes/{glass:slug}', [ShopController::class, 'show'])->name('glasses.show');
// Socialite – Google + Facebook + GitHub
Route::prefix('auth')->group(function () {
    Route::get('/{provider}', [SocialliteController::class, 'authProviderRedirect'])
        ->where('provider', 'google|facebook|github')
        ->name('social.redirect');

    Route::get('/{provider}/callback', [SocialliteController::class, 'socialAuthentication'])
        ->where('provider', 'google|facebook|github')
        ->name('social.callback');
});


Route::middleware(['auth', 'verified'])->prefix('dashboard')->name('user.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Brands CRUD – routes écrites à la main
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Glasses
    Route::get('/glasses', [GlassesController::class, 'index'])->name('glasses.index');
    Route::get('/glasses/create', [GlassesController::class, 'create'])->name('glasses.create');
    Route::post('/glasses', [GlassesController::class, 'store'])->name('glasses.store');
    Route::get('/glasses/{glass}/edit', [GlassesController::class, 'edit'])->name('glasses.edit');
    Route::put('/glasses/{glass}', [GlassesController::class, 'update'])->name('glasses.update');
    Route::delete('/glasses/{glass}', [GlassesController::class, 'destroy'])->name('glasses.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';