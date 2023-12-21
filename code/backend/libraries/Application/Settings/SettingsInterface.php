<?php

declare(strict_types=1);

namespace App\Application\Settings;

/**
 * Interface SettingsInterface
 *
 * @phpversion >= 8.1
 * @package App\Application\Settings
 */
interface SettingsInterface
{
    /**
     * Get settings by key.
     *
     * @param   string $key
     *
     * @return  mixed
     */
    public function get(string $key = '');
}
