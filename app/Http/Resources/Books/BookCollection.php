<?php

namespace App\Http\Resources\Books;

use App\Http\Resources\Books\BookResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BookCollection extends ResourceCollection
{
    public $collects = BookResource::class;
}
