<?php

namespace Facades;

use KieranFYI\Admin\Facades\Admin;
use KieranFYI\Tests\Admin\TestCase;

class AdminTest extends TestCase
{

    public function testFacade()
    {
        $this->assertFalse(Admin::isService());
    }
}