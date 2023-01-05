<?php

namespace KieranFYI\Admin\Listeners;

use Illuminate\Support\Collection;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use KieranFYI\Admin\Facades\Admin;
use KieranFYI\Admin\Services\Menu\AdminMenu;

class BuildingMenuListener
{
    /**
     * Handle the event.
     *
     * @param BuildingMenu $event
     * @return void
     */
    public function handle(BuildingMenu $event): void
    {
        $menus = Admin::menus();

        if (isset($menus['_default'])) {
            $event->menu->add(...$this->config($menus['_default']));
            unset($menus['_default']);
        }

        foreach ($menus as $header => $headerMenus) {
            $event->menu->add($header);
            $event->menu->add(...$this->config($headerMenus));
        }
    }

    /**
     * @param Collection $menus
     * @return array
     */
    private function config(array $menus): array
    {
        return collect($menus)
            ->map(function (AdminMenu $menu) {
                return $menu->config();
            })
            ->toArray();
    }
}