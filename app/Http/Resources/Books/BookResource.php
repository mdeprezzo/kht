<?php

namespace App\Http\Resources\Books;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ?? null,
            'title' => $this->title ?? '',
            'description' => $this->description ?? '',
            'price' => $this->price ?? '',
            'cover' => $this->getFirstMedia('cover')?->getUrl() ?? null
        ]; 
    }
}
