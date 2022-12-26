<?php

namespace KieranFYI\Admin\Listeners;

use KieranFYI\Roles\Core\Services\Register\RegisterPermission;

class RegisterPermissionListener
{
    /**
     * Handle the event.
     *
     * @return array
     */
    public function handle(): array
    {
        return [
            RegisterPermission::register(
                'Administrator',
                'Provide Administrator functionality',
                99,
                'Ranks'
            )
        ];
    }
}