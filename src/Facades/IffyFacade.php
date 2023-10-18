<?php

namespace Iffy\Facades;

use Illuminate\Support\Facades\Facade;

class IffyFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Iffy';
    }
}
