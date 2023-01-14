<?php

namespace KieranFYI\Admin\Facades;

use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Facade;
use KieranFYI\Admin\Services\Menu\AdminMenu;

/**
 * @method static RouteRegistrar route()
 * @method static AdminMenu header(string $text = null)
 * @method static array menus()
 * @method static bool isService()
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