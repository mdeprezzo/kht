<?php

namespace App\Http\Controllers\API;

use App\Models\Users\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Books\BookCollection;
use App\Http\Resources\Users\UserCollection;

class UsersController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, User $user)
    {
        $books = $user->favorites()->with('media')->filters($request->all())->paginate($request->get('per_page') ?? 20);

        return response()->json([
            'user' => $user->load('roles'),
            'books' => new BookCollection($books)
        ]);
    }
}
