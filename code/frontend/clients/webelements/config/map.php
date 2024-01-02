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
 * @copyright  2023 Web Elements
 * @license    GNU General Public License, version 3
 * @link       http://webelements.agency/
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
    '/clients'        => 'clients',
    '/contact'        => 'contact',
    '/cookies'        => 'cookies',
    '/evaluation'     => 'evaluation',
    '/designs'        => 'clients',
    '/get-a-website'  => 'lander',
    '/privacy-policy' => 'privacy',
    '/services'       => 'services',
    '/sitemap'        => 'sitemap',
    '/sitemap.xml'    => 'sitemap.xml',
    '/terms-of-use'   => 'terms',
];
