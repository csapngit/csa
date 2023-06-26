<?php namespace Biotrent\Menu;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['menu'] = $this->app->singleton('Menu', function($app)
        {
            return new \Biotrent\Menu\Menu();
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Menu', '\Biotrent\Menu\MenuFacade');
        });
    }
}