<?php

namespace App\Models\Users;

use Illuminate\Support\Facades\Auth;

trait UserScopeTrait
{
    public function scopeFilters($query, array $filters = [])
    {
        $query->where('id', '<>', Auth::id());
    }
}