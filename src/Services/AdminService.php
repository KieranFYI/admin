<?php

namespace KieranFYI\Admin\Services;

use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Route;

class AdminService
{
    /**
     * @return RouteRegistrar
     */
    public static function route(): RouteRegistrar
    {
        return Route::prefix(config('admin.path'))
            ->middleware('perm:Administrator')
            ->name('admin.');
    }
}