<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BooksController;
use App\Http\Controllers\API\UsersController;

Route::prefix('api')->name('api.')->group(function () {
    Route::get('users/{user}', UsersController::class)->name('users.show');
    Route::get('books/{book}', BooksController::class)->name('books.show');
});