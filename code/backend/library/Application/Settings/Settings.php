<?php

/**
 * Class Settings
 *
 * PHP version 8.2
 *
 * @phpversion >= 8.2
 * @category   CMS
 * @package    AVCorn
 * @subpackage App\Application\Settings
 * @author     Benjamin J. Young <ben@blaher.me>
 * @license    GNU General Public License, version 3
 * @link       https://github.com/avcorn/avcorn
 */

declare(strict_types=1);

namespace App\Application\Settings;

/**
 * Settings Class
 *
 * @category Settings
 */
class Settings implements SettingsInterface
{
    private array $settings;

    /**
     * Settings constructor.
     *
     * @param array $settings Settings array
     *
     * @return void
     */
    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Get settings by key.
     *
     * @param string $key Settings key
     *
     * @return mixed
     */
    public function get(string $key = '')
    {
        return (empty($key)) ? $this->settings : $this->settings[$key];
    }
}
