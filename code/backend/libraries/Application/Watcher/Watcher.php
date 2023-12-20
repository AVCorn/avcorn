<?php

declare(strict_types=1);

namespace App\Application\Watcher;

/**
 * Class Watcher
 *
 * @phpversion >= 8.1
 * @package App\Application\Watcher
 */
class Watcher implements WatcherInterface
{
    /**
     * @param   string $dir
     *
     * @return  string
     */
    public function check(string $dir = '.'): ?string
    {
        if (!is_dir($dir)) {
            throw new \ValueError('Expecting a valid directory!');
        }

        $latest = null;
        $latestTime = 0;
        foreach (scandir($dir) as $path) {
            if (!in_array($path, ['.', '..', 'cache', 'tests'], true)) {
                $filename = $dir . DIRECTORY_SEPARATOR . $path;

                if (is_dir($filename)) {
                    $fileCheck = $this->check($filename);

                    if (null === $fileCheck) {
                        continue;
                    }

                    $filename = $fileCheck;
                }

                $lastModified = filemtime($filename);
                if ($lastModified > $latestTime) {
                    $latestTime = $lastModified;
                    $latest = $filename;
                }
            }
        }

        return $latest;
    }
}
