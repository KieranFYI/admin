<?php

namespace KieranFYI\Admin\Listeners;

use KieranFYI\Roles\Core\Services\Register\RegisterRole;

class RegisterRolesListener
{
    /**
     * Handle the event.
     *
     * @return array
     */
    public function handle(): array
    {
        return [
            RegisterRole::register('Administrator')
                ->displayOrder(99)
                ->colour('#F1B828')
                ->permission('Administrator'),
        ];
    }
}