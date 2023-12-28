<?php

/**
 * Interface WatcherInterface
 *
 * PHP version 8.2
 *
 * @phpversion >= 8.2
 * @category   CMS
 * @package    AVCorn
 * @subpackage App\Application\Watcher
 * @author     Benjamin J. Young <ben@blaher.me>
 * @license    GNU General Public License, version 3
 * @link       https://github.com/avcorn/avcorn
 */

declare(strict_types=1);

namespace App\Application\Watcher;

/**
 * Watcher Interface
 */
interface WatcherInterface
{
    /**
     * Check for changes.
     *
     * @param string $dir Directory to check
     *
     * @return string
     */
    public function check(string $dir = '.');
}
