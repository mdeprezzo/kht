<?php

namespace App\Http\Controllers;

use App\Models\Books\Book;
use Illuminate\Http\Request;

class RemoveBookToFavoritesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Book $book)
    {
        $request
            ->user()
            ->favorites()
            ->detach($book->id); 

        return back();
    }
}
