<?php

namespace App\Models\Books;

use Illuminate\Support\Arr;

trait BOokScopeTrait
{
    public function scopeFilters($query, array $filters = [])
    {
        if ($searchQuery = Arr::get($filters, 'searchQuery', null)) {
            $query
              ->where('title', 'LIKE', "%{$searchQuery}%")
              ->orWhere('description', 'LIKE', "%{$searchQuery}%");
        }
    }
}