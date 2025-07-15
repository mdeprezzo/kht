<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RolesEnum;
use Inertia\Inertia;
use App\Models\Users\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserRequest;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::filters($request->all())->with('roles')->paginate($request->get('per_page') ?? 20);

        return Inertia::render(
            component: 'Admin/Users/Index',
            props: [
                'users' => $users,
                'roles' => RolesEnum::cases()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());
        $user->assignRole($request->get('role'));

        return redirect()->route('admin.users.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());
        $user->syncRoles(Arr::wrap($request->get('role')));

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return back();
    }
}
