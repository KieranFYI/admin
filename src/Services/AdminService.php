<?php

namespace KieranFYI\Admin\Services;

use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Route;
use KieranFYI\Admin\Services\Menu\AdminMenu;

class AdminService
{
    /**
     * @var array
     */
    private array $menus = [];

    /**
     * @return RouteRegistrar
     */
    public static function route(): RouteRegistrar
    {
        return Route::prefix(config('admin.path'))
            ->middleware(['web', 'auth', 'perm:Administrator'])
            ->name('admin.');
    }

    /**
     * @param string $text
     * @param string|null $header
     * @return AdminMenu
     */
    public function menu(string $text, string $header = null): AdminMenu
    {
        $header = is_null($header) ? '_default' : ucwords(strtolower($header));
        if (!isset($this->menus[$header])) {
            $this->menus[$header] = [];
        }

        $menu = AdminMenu::create($text);
        $this->menus[$header][] = $menu;
        return $menu;
    }

    /**
     * @return array
     */
    public function menus(): array
    {
        return $this->menus;
    }
}