<?php

namespace Larke\Auth\Facades;

use Illuminate\Support\Facades\Facade;

class AuthUser extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'larke.auth.user';
    }
}
