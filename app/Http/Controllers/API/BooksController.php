<?php

namespace App\Http\Controllers\API;

use App\Models\Books\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Books\BookResource;

class BooksController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Book $book)
    {
        return new BookResource($book->load('media'));
    }
}
