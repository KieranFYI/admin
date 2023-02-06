<?php

namespace KieranFYI\Admin\Services;

use Illuminate\Support\Facades\Route;
use KieranFYI\Admin\Services\Menu\AdminMenu;

class AdminService
{
    /**
     * @var array
     */
    private array $menus = [];

    /**
     * @param callable $callback
     * @return void
     */
    public function route(callable $callback): void
    {
        if ($this->isService() || !$this->routeEnabled()) {
            return;
        }

        Route::prefix(config('admin.route.path'))
            ->middleware(config('admin.route.middleware'))
            ->name('admin.')
            ->group(function () use ($callback) {
                $callback();
            });
    }

    /**
     * @param callable $callback
     * @return void
     */
    public function api(callable $callback): void
    {
        if ($this->isService() || !$this->apiEnabled()) {
            return;
        }

        Route::prefix(config('admin.api.path'))
            ->middleware(config('admin.api.middleware'))
            ->name('admin.api.')
            ->group(function () use ($callback) {
                $callback();
            });
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

    /**
     * @return bool
     */
    public function routeEnabled(): bool
    {
        return config('admin.route', true);
    }

    /**
     * @return bool
     */
    public function apiEnabled(): bool
    {
        return config('admin.api', true);
    }
}