<?php

namespace KieranFYI\Admin\Facades;

use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Facade;
use KieranFYI\Admin\Services\AdminService;
use KieranFYI\Admin\Services\Menu\AdminMenu;

/**
 * @method static RouteRegistrar route(callable $callback)
 * @method static RouteRegistrar api(callable $callback)
 * @method static AdminMenu header(string $text = null)
 * @method static array menus()
 * @method static bool isService()
 * @method static bool routeEnabled()
 * @method static bool apiEnabled()
 *
 * @see AdminService
 */
class Admin extends Facade
{
    /**
     * @var bool
     */
    protected static $cached = true;

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return AdminService::class;
    }
}