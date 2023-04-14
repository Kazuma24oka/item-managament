<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteController;


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('items')->group(function () {
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index'])->name('items.index');

    Route::middleware(['admin'])->group(function () {
        Route::get('/add', [App\Http\Controllers\ItemController::class, 'add']);
        Route::post('/add', [App\Http\Controllers\ItemController::class, 'add']);
        Route::get('/{id}/edit', [App\Http\Controllers\ItemController::class, 'edit'])->name('items.edit');
        Route::put('/{id}', [App\Http\Controllers\ItemController::class, 'update'])->name('items.update');
        Route::delete('/{id}', [App\Http\Controllers\ItemController::class, 'destroy'])->name('items.destroy');
    });
});

Route::post('/favorite/{item}', [FavoriteController::class, 'store'])->name('favorite.store');
Route::delete('/favorite/{item}', [FavoriteController::class, 'destroy'])->name('favorite.destroy');
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
