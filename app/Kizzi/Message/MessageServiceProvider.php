<?php namespace Biotrent\Message;

use Illuminate\Support\ServiceProvider;

class MessageServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['menu'] = $this->app->share(function($app)
        {
            return new \Biotrent\Message\Message();
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Message', '\Biotrent\Message\MessageFacade');
        });
    }
}