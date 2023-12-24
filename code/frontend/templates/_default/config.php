<?php

/**
 * Default Template Configuration
 *
 * PHP version 8.1
 *
 * @phpversion >= 8.1
 * @package    Application
 * @subpackage Configuration
 */

declare(strict_types=1);

require_once 'config/map.php';
require_once 'config/navigation.php';
require_once 'config/navigation-footer.php';
require_once 'config/information.php';
require_once 'config/social.php';
require_once 'config/themes.php';
require_once 'config/sitemap.php';

/**
 * Overriding default configuration.
 *
 * @var array $map
 * @var array $navigation
 * @var array $navigationFooter
 * @var array $information
 * @var array $social
 * @var array $themes
 * @var array $sitemap
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
