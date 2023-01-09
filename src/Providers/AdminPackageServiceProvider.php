<?php

namespace KieranFYI\Admin\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use KieranFYI\Admin\Events\RegisterAdminNavigationEvent;
use KieranFYI\Admin\Listeners\BuildingMenuListener;
use KieranFYI\Admin\Listeners\RegisterPermissionListener;
use KieranFYI\Admin\Listeners\RegisterRolesListener;
use KieranFYI\Admin\Services\AdminService;
use KieranFYI\Roles\Core\Events\Register\RegisterPermissionEvent;
use KieranFYI\Roles\Core\Events\Register\RegisterRoleEvent;

class AdminPackageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $root = __DIR__ . '/../..';

        $this->publishes([
            $root . '/config/admin.php' => config_path('admin.php'),
        ], 'admin');

        $this->mergeConfigFrom($root . '/config/admin.php', 'admin');

        $this->app->bind('admin', AdminService::class);

        Event::listen(RegisterPermissionEvent::class, RegisterPermissionListener::class);
        Event::listen(RegisterRoleEvent::class, RegisterRolesListener::class);
        Event::listen(BuildingMenu::class, BuildingMenuListener::class);

        $this->app->afterResolving('view', function () {
            View::composer('adminlte::page', function () use (&$executed) {
                Event::dispatch(RegisterAdminNavigationEvent::class);
            });
        });
    }
}
