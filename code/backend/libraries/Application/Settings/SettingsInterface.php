<?php

declare(strict_types=1);

namespace App\Application\Settings;

/**
 * Interface SettingsInterface
 *
 * PHP version 8.1
 * @phpversion >= 8.1
 *
 * @package App\Application\Settings
 */
interface SettingsInterface
{
    /**
     * Get settings by key.
     *
     * @param   string  $key    Settings key
     *
     * @return  mixed
     */
    public function get(string $key = '');
}
