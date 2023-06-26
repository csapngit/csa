<?php namespace Kizzi\Autorisasi;

use Illuminate\Support\Facades\Facade;

class AutorisasiFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Autorisasi';
    }

}