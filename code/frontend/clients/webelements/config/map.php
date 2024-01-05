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
 * @link       https://webelements.agency/
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

    // landers
    '/website-design'             => 'landers/website-design',
    '/lead-generation'            => 'landers/lead-generation',
    '/marketing-analytics'        => 'landers/marketing-analytics',
    '/search-engine-optimization' => 'landers/search-engine-optimization',
    '/search-engine-marketing'    => 'landers/search-engine-marketing',
    '/social-media-marketing'     => 'landers/social-media-marketing',
    '/content-marketing'          => 'landers/content-marketing',
    '/social-media-management'    => 'landers/social-media-management',
    '/email-marketing'            => 'landers/email-marketing',
    '/online-footprint'           => 'landers/online-footprint',
    '/web-hosting'                => 'landers/web-hosting',
    '/security-management'        => 'landers/security-management',
    '/technology-automation'      => 'landers/technology-automation',
];
