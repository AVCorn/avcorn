<?php

declare(strict_types=1);

namespace App\Application\Watcher;

interface WatcherInterface
{
    /**
     * @param string $dir
     * @return string
     */
    public function check(string $dir = '.');
}
