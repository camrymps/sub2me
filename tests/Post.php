<?php

namespace Tests;

use Illuminate\Database\Eloquent\Model;

use Camrymps\Sub2Me\Subscription;
use Camrymps\Sub2Me\Traits\CanBeSubscribedTo;

class Post extends Model
{
    use CanBeSubscribedTo;

    protected $fillable = ['title'];
}
