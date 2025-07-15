<?php

namespace App\Models\Users;

use Attribute;
use App\Models\Books\Book;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait UserRelationshipsTrait
{
    /**
     * The relationships to eager load in the model.
     * 
     * Be careful when adding relationships here as they will be loaded on every query.
     * Only add relationships that are strictly needed and frequently used.
     *
     * @var list<string>
     */
    protected $with = [
        // Add here the relationships to eager load
    ];
    
    /*
    * The favorite books that belong to the UserRelationshipsTrait
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }
}