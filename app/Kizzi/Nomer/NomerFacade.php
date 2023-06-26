<?php namespace Biotrent\Nomer;

use Illuminate\Support\Facades\Facade;

class NomerFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
    	return 'nomer';
    }

}