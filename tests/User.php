<?php

namespace Tests;

use Illuminate\Database\Eloquent\Model;

use Camrymps\Sub2Me\Traits\CanBeSubscribedTo;
use Camrymps\Sub2Me\Traits\CanSubscribe;

class User extends Model
{
    use CanBeSubscribedTo, CanSubscribe;

    protected $fillable = ['username'];
}
