<?php

namespace KieranFYI\Admin\Services\Menu;

class AdminMenu
{

    /**
     * @var array
     */
    private array $config = [];

    /**
     * @var array
     */
    private array $submenus = [];

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
    public static function create(string $text): static
    {
        return new static($text);
    }

    /**
     * @return array
     */
    public function config(): array
    {
        $config = $this->config;
        if (!empty($this->submenus)) {
            $config['submenus'] = [];

            /** @var AdminMenu $submenu */
            foreach ($this->submenus as $submenu) {
                $config['submenus'][] = $submenu->config();
            }
        }
        return $config;
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
     * @param AdminMenu $menu
     * @return $this
     */
    public function submenu(AdminMenu $menu): static
    {
        $this->submenus[] = $menu;
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