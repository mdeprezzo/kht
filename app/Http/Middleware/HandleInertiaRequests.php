<?php

namespace App\Http\Middleware;

use App\Enums\RolesEnum;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user?->load('roles'),
            ],
            'isAdmin' => $user?->hasRole(RolesEnum::ADMIN->value) ?? false,
            'can' => [
                'see_favorites' => $user?->can('see_favorites') ?? false,
                'toggle_favorites' => $user?->can('toggle_favorites') ?? false,
            ] 
        ];
    }
}
