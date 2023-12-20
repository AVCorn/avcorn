<?php

declare(strict_types=1);

namespace App\Application\Settings;

/**
 * Class Settings
 *
 * @phpversion >= 8.1
 * @package App\Application\Settings
 */
class Settings implements SettingsInterface
{
    private array $settings;

    /**
     * Settings constructor.
     *
     * @param   array $settings
     *
     * @return  void
     */
    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @param   string $key
     *
     * @return  mixed
     */
    public function get(string $key = '')
    {
        return (empty($key)) ? $this->settings : $this->settings[$key];
    }
}
