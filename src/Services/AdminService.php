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
            ->middleware(config('admin.middleware'))
            ->name('admin.');
    }

    /**
     * @param string|null $text
     * @return AdminMenu
     */
    public function header(string $text = null): AdminMenu
    {
        $text = empty($text) ? '_default' : ucwords(strtolower($text));
        if (!isset($this->menus[$text])) {
            $this->menus[$text] = new AdminMenu($text);
        }
        return $this->menus[$text];
    }

    /**
     * @return array
     */
    public function menus(): array
    {
        return $this->menus;
    }

    /**
     * @return bool
     */
    public function isService(): bool
    {
        return config('admin.service', false);
    }
}