<?php

namespace KieranFYI\Admin\Facades;

use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Facade;

/**
 * @method static RouteRegistrar route()
 */
class Admin extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'admin';
    }
}