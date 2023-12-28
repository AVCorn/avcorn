<?php

/**
 * Settings Interface
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
 * Settings Interface
 */
interface SettingsInterface
{
    /**
     * Get settings by key.
     *
     * @param string $key Settings key
     *
     * @return mixed
     */
    public function get(string $key = '');
}
