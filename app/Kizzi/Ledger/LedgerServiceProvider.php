<?php namespace Biotrent\Ledger;

use Illuminate\Support\ServiceProvider;

class LedgerServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['ledger'] = $this->app->share(function($app)
        {
            return new \Biotrent\Ledger\Ledger();
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Jurnal', '\Biotrent\Ledger\LedgerFacade');
        });
    }
}