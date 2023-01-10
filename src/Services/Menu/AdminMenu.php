<?php

namespace KieranFYI\Admin\Services\Menu;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter;
use TypeError;

class AdminMenu
{

    /**
     * @var array
     */
    private array $config = [];

    /**
     * @var array
     */
    private array $menus = [];

    /**
     * @param string $text
     */
    public function __construct(string $text)
    {
        $this->config['text'] = $text;
    }

    /**
     * @param string $text
     * @return AdminMenu
     */
    public function menu(string $text): static
    {
        $slug = Str::slug($text);
        if (!isset($this->menus[$slug])) {
            $this->menus[$slug] = new AdminMenu($text);
        }
        return $this->menus[$slug];
    }

    /**
     * @return array|null
     * @throws BindingResolutionException
     */
    public function config(): ?array
    {
        /** @var GateFilter $filter */
        $filter = app()->make(GateFilter::class);
        $config = $filter->transform($this->config);
        if (isset($config['restricted'])) {
            return null;
        }

        if (!empty($this->menus)) {
            $submenu = collect();
            /** @var AdminMenu $menus */
            foreach ($this->menus as $menus) {
                $menuConfig = $menus->config();

                if (is_null($menuConfig)) {
                    continue;
                }

                $submenu->add($menuConfig);
            }

            if ($submenu->isNotEmpty()) {
                $config['submenu'] = $submenu->sortBy('text');
            }
        }

        if (isset($config['route'])) {
            $bits = explode('.', $config['route']);
            array_pop($bits);
            $config['active'] = isset($config['route']) && Route::is(implode('.', $bits) . '.*');
        }

        return $config;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function can(string $value): static
    {
        $this->config['can'] = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function model(string $value): static
    {
        if (!is_a($value, Model::class, true)) {
            throw new TypeError(self::class . '::model(): $value must be of type ' . Model::class);
        }

        $this->config['model'] = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function classes(string $value): static
    {
        $this->config['classes'] = $value;
        return $this;
    }

    /**
     * @param string $index
     * @param mixed $value
     * @return $this
     */
    public function data(string $index, mixed $value): static
    {
        if (!isset($this->config['data'])) {
            $this->config['data'] = [];
        }

        $this->config['data'][$index] = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function icon(string $value): static
    {
        $this->config['icon'] = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function iconColour(string $value): static
    {
        $this->config['icon_color'] = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function id(string $value): static
    {
        $this->config['id'] = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function key(string $value): static
    {
        $this->config['key'] = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function label(string $value): static
    {
        $this->config['label'] = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function labelColour(string $value): static
    {
        $this->config['label_color'] = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function route(string $value): static
    {
        $this->config['route'] = $value;
        return $this;
    }


    /**
     * @param string $value
     * @return $this
     */
    public function target(string $value): static
    {
        $this->config['target'] = $value;
        return $this;
    }

    /**
     * @return $this
     */
    public function topnav(): static
    {
        $this->config['topnav'] = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function topnavRight(): static
    {
        $this->config['topnav_right '] = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function topnavUser(): static
    {
        $this->config['topnav_user'] = true;
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function url(string $value): static
    {
        $this->config['url'] = $value;
        return $this;
    }

}