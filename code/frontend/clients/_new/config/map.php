<?php

/**
 * Map configuration
 *
 * PHP version 8.2
 *
 * @phpversion >= 8.2
 * @category   CMS
 * @package    AVCorn
 * @subpackage Configuration
 * @author     Benjamin J. Young <ben@blaher.me>
 * @license    GNU General Public License, version 3
 * @link       https://github.com/avcorn/avcorn
 */

declare(strict_types=1);

/**
 * Routing configuration
 *
 * @var array $map Routing configuration
 */
$map = [
    '/' => 'home',
    '/about' => 'about',
    '/contact' => 'contact',
    '/cookies' => 'cookies',
    '/privacy-policy' => 'privacy',
    '/sitemap' => 'sitemap',
    '/sitemap.xml' => 'sitemap.xml',
    '/terms-of-use' => 'terms',
];
