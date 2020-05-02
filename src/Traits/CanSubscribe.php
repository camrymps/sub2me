<?php

namespace Camrymps\Sub2Me\Traits;

use Illuminate\Database\Eloquent\Model;

use Camrymps\Sub2Me\Subscription;

trait CanSubscribe
{

    /**
     * Subscribes to a model. If this entity is already subscribed to the specified
     * model, unsubscribe.
     *
     * @param Model $model
     */
    public function subscribe(Model $model)
    {
        $subscription = new Subscription;

        $subscription->{config('sub2me.user_foreign_key')} = $this->getKey();

        return $model->publisher_subscriptions()->save($subscription);
    }

    /**
     * Gets all of the subscriptions this entity has subscribed to.
     */
    public function subscriber_subscriptions()
    {
        return $this->hasMany(
            Subscription::class,
            config('sub2me.user_foreign_key'),
            $this->getKeyName()
        );
    }

    /**
     * Checks if this entity has already subscribed to a specific model.
     *
     * @param Model $model
     */
    public function has_subscribed_to(Model $model)
    {
        return !is_null($this->subscriber_subscriptions()) ?
            $this->subscriber_subscriptions()
                ->where('subscribable_id', $model->getKey())
                ->where('subscribable_type', $model->getMorphClass())
                ->exists() :
            false;
    }

    /**
     * Unsubscribe this entity from a specific model.
     *
     * @param Model $model
     */
    public function unsubscribe(Model $model)
    {
        $subscription = $model->publisher_subscriptions()
            ->where('subscribable_id', $model->getKey())
            ->where('subscribable_type', $model->getMorphClass())
            ->where(config('sub2me.user_foreign_key'), $this->getKey())
            ->first();

        if (!is_null($subscription)) {
            $subscription->delete();
        }
    }
}
