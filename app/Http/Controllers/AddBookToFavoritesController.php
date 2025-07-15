<?php

namespace App\Http\Controllers;

use App\Models\Books\Book;
use Illuminate\Http\Request;

class AddBookToFavoritesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Book $book)
    {
        $request
            ->user()
            ->favorites()
            ->attach($book->id, [
                'added_at' => now()
            ]); 

        return back();
    }
}
