<?php

namespace Camrymps\Sub2Me;

use Illuminate\Support\ServiceProvider;

class Sub2MeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Merge configuration
        $this->mergeConfigFrom(
            \dirname(__DIR__) . '/config/sub2me.php', 'sub2me'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish configuration
        $this->publishes([
            \dirname(__DIR__) . '/config/sub2me.php' => config_path('sub2me.php'),
        ], 'config');

        // Publish migration(s)
        $this->publishes([
            \dirname(__DIR__) . '/migrations' => database_path('migrations'),
        ], 'migrations');

        // Load migration(s)
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(\dirname(__DIR__) . '/migrations');
        }
    }
}
