<?php

namespace App\Models\Books;

use Spatie\MediaLibrary\HasMedia;
use App\Models\Books\BookScopeTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Book extends Model implements HasMedia
{
    use InteractsWithMedia, BookScopeTrait;
    
    protected $fillable = [
        'title',
        'description',
        'price'
    ];
}
