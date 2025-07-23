<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Books\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Books\BookRequest;
use App\Http\Resources\Books\BookCollection;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $books = Book::filters($request->all())->with('media')->paginate($request->get('per_page') ?? 20);

        return Inertia::render(
            component: 'Admin/Books/Index', 
            props: [
                'books' => new BookCollection($books)
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        $book = Book::create($request->validated());   

        if ($file = $request->file('cover')) {
            $book
                ->addMedia($file)
                ->usingFileName($file->getClientOriginalName())
                ->toMediaCollection('cover');
        }

        return redirect()->route('admin.books.index');
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, Book $book)
    {
        $book->update($request->validated());

        if ($file = $request->file('cover')) {
            $book->clearMediaCollection('cover');
            
            $book
                ->addMedia($file)
                ->usingFileName($file->getClientOriginalName())
                ->toMediaCollection('cover');
        }        

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return back();
    }
}
