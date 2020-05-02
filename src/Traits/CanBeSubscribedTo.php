<?php

namespace Camrymps\Sub2Me\Traits;

use Illuminate\Database\Eloquent\Model;

use Camrymps\Sub2Me\Subscription;

trait CanBeSubscribedTo
{
    /**
     * Get all of the subscriptions linked to this model.
     */
    public function publisher_subscriptions()
    {
        return $this->morphMany(Subscription::class, 'subscribable');
    }

    /**
     * Get all of the subscribers linked to this model.
     */
    public function subscribers()
    {
        return $this->belongsToMany(
            config('sub2me.user_model'),
            'subscriptions',
            'subscribable_id',
            config('sub2me.user_foreign_key')
        );
    }
}
