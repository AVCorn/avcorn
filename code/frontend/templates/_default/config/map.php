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
    '/'               => 'home',
    '/about'          => 'about',
    '/admin'          => 'admin',
    '/contact'        => 'contact',
    '/contribute'     => 'contribute',
    '/cookies'        => 'cookies',
    '/designs'        => 'designs',
    '/gallery'        => 'gallery',
    '/guide'          => 'guide',
    '/playground'     => 'playground',
    '/privacy-policy' => 'privacy',
    '/services'       => 'services',
    '/sitemap'        => 'sitemap',
    '/sitemap.xml'    => 'sitemap.xml',
    '/terms-of-use'   => 'terms',
    '/testimonials'   => 'testimonials',
];
