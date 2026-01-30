<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/shorturls',[ShortUrlController::class, 'index'])->name('shorturls.index');
    Route::get('/shorturls/create',[ShortUrlController::class, 'create'])->name('shorturls.create');
    Route::post('/shorturls',[ShortUrlController::class, 'store'])->name('shorturls.store');
    Route::get('/shorturls/{shorturl}/edit',[ShortUrlController::class, 'edit'])->name('shorturls.edit');
    Route::put('/shorturls/{shorturl}',[ShortUrlController::class, 'update'])->name('shorturls.update');
    Route::delete('/shorturls/{shorturl}',[ShortUrlController::class, 'destroy'])->name('shorturls.destroy');
});

Route::get('/r/{code}', [RedirectController::class, 'redirect'])->name('shorturls.redirect');

require __DIR__.'/auth.php';
