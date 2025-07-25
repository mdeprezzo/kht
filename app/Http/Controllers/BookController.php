<?php

namespace App\Http\Controllers;

use App\Http\Resources\Books\BookResource;
use Inertia\Inertia;
use App\Models\Books\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Book $book)
    {
        return Inertia::render(
            component: 'Books/Show', 
            props: [
                'book' => new BookResource($book->load('media')),
                'isInFavoritesList' => !is_null($request->user()->favorites()->where('book_id', $book->id)->first())
            ]
        );
    }
}
