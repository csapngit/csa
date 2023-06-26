<?php namespace Biotrent\Nomer;

use Illuminate\Support\ServiceProvider;

class NomerServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['nomer'] = $this->app->singleton('Nomer', function($app)
        {
            return new \Biotrent\Nomer\Nomer();
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Nomer', '\Biotrent\Nomer\NomerFacade');
        });
    }
}