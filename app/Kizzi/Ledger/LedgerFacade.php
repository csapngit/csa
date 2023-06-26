<?php namespace Biotrent\Ledger;

use Illuminate\Support\Facades\Facade;

class LedgerFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
    	return 'ledger';
    }

}