<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Admin\BooksController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\AddBookToFavoritesController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\RemoveBookToFavoritesController;

Route::get('/', WelcomeController::class)->name('home');

Route::middleware('auth')->group(function() {
    Route::get('dettaglio/{book}', BookController::class)->name('book.show');

    Route::get('favorites', FavoritesController::class)->name('favorites.index');
    Route::post('favorites/{book}', AddBookToFavoritesController::class)->name('favorites.store');
    Route::delete('favorites/{book}', RemoveBookToFavoritesController::class)->name('favorites.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');      
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::get('/', function () {
            return Inertia::render('Admin/Dashboard');
        })->name('dashboard');    

        Route::resource('books', BooksController::class);
        Route::resource('users', UsersController::class);
    });  
});

require __DIR__.'/auth.php';
