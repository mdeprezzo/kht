<?php

namespace App\Http\Controllers;

use App\Http\Resources\Books\BookCollection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FavoritesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $books = $request->user()
            ->favorites()
            ->with('media')
            ->filters($request->all())
            ->paginate($request->get('per_page') ?? 20);

        return Inertia::render(
            component: 'Favorites/Index',
            props: [
                'books' => new BookCollection($books)
            ]
        );
    }
}
