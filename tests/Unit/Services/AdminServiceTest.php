<?php

namespace KieranFYI\Tests\Admin\Unit\Services;

use Illuminate\Support\Facades\Config;
use KieranFYI\Admin\Services\AdminService;
use KieranFYI\Admin\Services\Menu\AdminMenu;
use KieranFYI\Tests\Admin\TestCase;

class AdminServiceTest extends TestCase
{
    /**
     * @var AdminService
     */
    private AdminService $service;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->service = new AdminService();
        Config::set('admin.service', false);
        Config::set('admin.route.enabled', true);
        Config::set('admin.api.enabled', true);
    }

    public function testRoute()
    {
        $this->service->route(function () {
            $this->assertTrue(true);
        });
    }

    public function testRouteService()
    {
        Config::set('admin.service', true);
        $this->service->route(function () {
            $this->assertTrue(false);
        });
        $this->assertTrue(true);
    }

    public function testRouteRouteDisabled()
    {
        Config::set('admin.route.enabled', false);
        $this->service->route(function () {
            $this->assertTrue(false);
        });
        $this->assertTrue(true);
    }

    public function testAPI()
    {
        $this->service->api(function () {
            $this->assertTrue(true);
        });
    }

    public function testAPIService()
    {
        Config::set('admin.service', true);
        $this->service->api(function () {
            $this->assertTrue(false);
        });
        $this->assertTrue(true);
    }

    public function testRouteAPIDisabled()
    {
        Config::set('admin.api.enabled', false);
        $this->service->api(function () {
            $this->assertTrue(false);
        });
        $this->assertTrue(true);
    }

    public function testHeader()
    {
        $menu = $this->service->header('test');
        $this->assertInstanceOf(AdminMenu::class, $menu);
        $this->assertEquals('Test', $menu->config()['text']);
    }

    public function testMenus()
    {
        $this->service->header('test');
        $menus = $this->service->menus();
        $this->assertIsArray($menus);
        $title = 'Test';
        $this->assertArrayHasKey($title, $menus);
        $this->assertInstanceOf(AdminMenu::class, $menus[$title]);
        $this->assertEquals($title, $menus[$title]->config()['text']);
    }

    public function testIsService()
    {
        $this->assertFalse($this->service->isService());
    }

    public function testRouteEnabled()
    {
        $this->assertTrue($this->service->routeEnabled());
    }

    public function testAPIEnabled()
    {
        $this->assertTrue($this->service->apiEnabled());
    }

}