<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    public $collects = UserResource::class;
}
