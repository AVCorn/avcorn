<?php

declare(strict_types=1);

namespace App\Application\Watcher;

/**
 * Interface WatcherInterface
 *
 * @package    App\Application\Watcher
 * @phpversion >= 8.1
 */
interface WatcherInterface
{
    /**
     * Check for changes.
     *
     * @param string $dir
     *
     * @return string
     */
    public function check(string $dir = '.');
}
