<?php

declare(strict_types=1);

namespace App\Application\Settings;

class Settings implements SettingsInterface
{
    private array $_settings;

    public function __construct(array $settings)
    {
        $this->_settings = $settings;
    }

    /**
     * @return mixed
     */
    public function get(string $key = '')
    {
        return (empty($key)) ? $this->_settings : $this->_settings[$key];
    }
}
