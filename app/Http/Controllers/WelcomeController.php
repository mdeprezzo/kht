<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Books\Book;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $books = Book::filters($request->all())->with('media')->paginate($request->get('per_page') ?? 20);

        return Inertia::render(
            component: 'Welcome',
            props: [
                'books' => $books
            ]
        );
    }
}
