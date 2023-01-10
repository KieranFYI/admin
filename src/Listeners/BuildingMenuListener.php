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
        /** @var Collection $menus */
        $menus = collect(Admin::menus());

        if ($menus->contains('_default')) {
            $config = $menus->get('_default')->config();
            if (!is_null($config)) {
                $event->menu->add(...$config['submenu']);
            }
        }

        $menus->each(function (AdminMenu $header, string $key) use ($event) {
            if ($key === '_default') {
                return;
            }
            $config = $header->config();
            if (!is_null($config)) {
                $event->menu->add($config['text']);
                $event->menu->add(...$config['submenu']);
            }
        });
    }

    /**
     * @param array $menus
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