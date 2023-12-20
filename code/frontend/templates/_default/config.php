<?php

declare(strict_types=1);

require_once 'config/map.php';
require_once 'config/navigation.php';
require_once 'config/navigation-footer.php';
require_once 'config/information.php';
require_once 'config/social.php';
require_once 'config/themes.php';
require_once 'config/sitemap.php';

/**
 * Configuration
 *
 * @phpversion >= 8.1
 * @package     Application
 * @subpackage  Configuration
 */
$config = [
    'map' => $map,
    'navigation' => $navigation,
    'navigationFooter' => $navigationFooter,
    'info' => $information,
    'social' => $social,
    'themes' => $themes,
    'sitemap' => $sitemap,
];
