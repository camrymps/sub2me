<?php

namespace Tests;

use Camrymps\Sub2Me\Subscription;

class FeatureTest extends TestCase
{
    public function test_subscribe_and_unsubscribe_on_different_model()
    {
        $user_1 = User::create(['username' => 'testing']);
        $post_1 = Post::create(['title' => 'Test 1']);

        // Subscribe
        $subscription = $user_1->subscribe($post_1);

        // Subscribe assertions
        $this->assertInstanceOf(Subscription::class, $subscription);
        $this->assertInstanceOf(Post::class, app($subscription->subscribable_type));
        $this->assertEquals($post_1->id, $subscription->subscribable_id);
        $this->assertTrue($user_1->has_subscribed_to($post_1));

        // Unsubscribe
        $user_1->unsubscribe($post_1);

        // Unsubscribe assertions
        $this->assertFalse($user_1->has_subscribed_to($post_1));
    }

    public function test_subscribe_and_unsubscribe_on_same_model()
    {
        $user_1 = User::create(['username' => 'testing1']);
        $user_2 = User::create(['username' => 'testing2']);

        // Subscribe
        $subscription = $user_2->subscribe($user_1);

        // Subscribe assertions
        $this->assertInstanceOf(Subscription::class, $subscription);
        $this->assertInstanceOf(User::class, app($subscription->subscribable_type));
        $this->assertEquals($user_1->id, $subscription->subscribable_id);
        $this->assertTrue($user_2->has_subscribed_to($user_1));

        // Unsubscribe
        $user_2->unsubscribe($user_1);

        // Unsubscribe assertions
        $this->assertFalse($user_1->has_subscribed_to($user_2));
    }

    public function test_subscribers()
    {
        $user_1 = User::create(['username' => 'testing1']);
        $user_2 = User::create(['username' => 'testing2']);
        $post_1 = Post::create(['title' => 'Test 1']);

        $subscription_1 = $user_1->subscribe($post_1);
        $subscription_2 = $user_2->subscribe($post_1);

        $this->assertInstanceOf(Subscription::class, $subscription_1);
        $this->assertInstanceOf(Subscription::class, $subscription_2);
        $this->assertInstanceOf(Post::class, app($subscription_1->subscribable_type));
        $this->assertInstanceOf(Post::class, app($subscription_2->subscribable_type));
        $this->assertTrue($user_1->has_subscribed_to($post_1));
        $this->assertTrue($user_2->has_subscribed_to($post_1));
        $this->assertEquals(2, $post_1->subscribers()->count());
    }
}
