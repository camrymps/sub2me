<?php

namespace Camrymps\Sub2Me;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    /**
     * Get all of the models that own subscriptions.
     */
    public function subscribable()
    {
        return $this->morphTo();
    }
}
