<?php

namespace JeroenG\GuestPass;

use Illuminate\Support\Facades\Facade;

class GuestPassFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'guestpass';
    }
}
