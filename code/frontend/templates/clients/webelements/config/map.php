<?php

/**
 * Map configuration
 *
 * PHP version 8.1
 * @phpversion >= 8.1
 *
 * @package    Application
 * @subpackage Configuration
 */

declare(strict_types=1);

/**
 * Routing configuration
 *
 * @var array   $map    Routing configuration
 */
$map = [
    '/' => 'home',
    '/about' => 'about',
    '/admin' => 'admin',
    '/clients' => 'clients',
    '/contact' => 'contact',
    '/designs' => 'clients',
    '/privacy-policy' => 'privacy',
    '/services' => 'services',
    '/sitemap' => 'sitemap',
    '/sitemap.xml' => 'sitemap.xml',
    '/terms-of-use' => 'terms',
];
