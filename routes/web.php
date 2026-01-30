<?php

use App\Http\Controllers\ProfileController;
use App\Models\ShortUrl;
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

    Route::get('/shorturls',[ShortUrl::class, 'index'])->name('shorturls.index');
    Route::get('/shorturls/create',[ShortUrl::class, 'create'])->name('shorturls.create');
    Route::post('/shorturls/store',[ShortUrl::class, 'store'])->name('shorturls.store');
    Route::get('/shorturls/{shorturl}/edit',[ShortUrl::class, 'edit'])->name('shorturls.edit');
    Route::put('/shorturls/{shorturl}',[ShortUrl::class, 'update'])->name('shorturls.update');
    Route::delete('/shorturls/{shorturl}',[ShortUrl::class, 'destroy'])->name('shorturls.destroy');
});

require __DIR__.'/auth.php';
