<?php

/**
 * Sitemap configuration
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
 * Sitemap configuration
 *
 * @var array $sitemap Sitemap configuration
 */
$sitemap = [
    'sections' => [
        'main' => [
            'title' => 'AVCorn',
            'link'  => '/',
            'pages' => [
                'home',
                'about',
                'contact',
                'lander',
            ],
        ],
        'secondary' => [
            'title'       => 'Resources',
            'description' => 'Find out more about us.',
            'link'        => '/about',
            'pages'       => [
                'services',
                'clients',
                'sitemap',
            ],
        ],
        'other' => [
            'title'       => 'Other',
            'description' => 'Additional information.',
            'link'        => '/sitemap',
            'pages'       => [
                'terms',
                'privacy',
                'cookies',
            ],
        ],
    ],
    'pages' => [
        'home' => [
            'title'       => 'Home',
            'link'        => '/',
        ],
        'about' => [
            'title'       => 'About Us',
            'description' => 'Information and history of AVCorn.',
            'link'        => '/about',
        ],
        'services' => [
            'title'       => 'Services',
            'description' => 'Services we offer.',
            'link'        => '/services',
        ],
        'clients' => [
            'title'       => 'Our Clients',
            'description' => 'List of our clients.',
            'link'        => '/clients',
        ],
        'contact' => [
            'title'       => 'Contact Us',
            'description' => 'How to contact us.',
            'link'        => '/contact',
        ],
        'lander' => [
            'title'       => 'Get a Website',
            'description' => '
                Need a website for your small business?
                We\'ve got you!
            ',
            'link'        => '/get-a-website',
        ],
        'terms' => [
            'title'       => 'Terms of Use',
            'description' => 'Terms of use of the website.',
            'link'        => '/terms-of-use',
        ],
        'privacy' => [
            'title'       => 'Privacy Policy',
            'description' => 'Privacy policy of the website.',
            'link'        => '/privacy-policy',
        ],
        'cookies' => [
            'title'       => 'Cookies Usage',
            'description' => 'Our cookie usage.',
            'link'        => '/cookies',
        ],
        'sitemap' => [
            'title'       => 'Sitemap',
            'description' => 'Navigation map of the website.',
            'link'        => '/sitemap',
        ],

        // These are only included in sitemap.xml
        'website-design' => [
            'link'        => '/website-design',
        ],
        'lead-generation' => [
            'link'        => '/lead-generation',
        ],
        'marketing-analytics' => [
            'link'        => '/marketing-analytics',
        ],
        'search-engine-optimization' => [
            'link'        => '/search-engine-optimization',
        ],
        'search-engine-marketing' => [
            'link'        => '/search-engine-marketing',
        ],
        'social-media-marketing' => [
            'link'        => '/social-media-marketing',
        ],
        'content-marketing' => [
            'link'        => '/content-marketing',
        ],
        'social-media-management' => [
            'link'        => '/social-media-management',
        ],
        'email-marketing' => [
            'link'        => '/email-marketing',
        ],
        'online-footprint' => [
            'link'        => '/online-footprint',
        ],
        'web-hosting' => [
            'link'        => '/web-hosting',
        ],
        'security-management' => [
            'link'        => '/security-management',
        ],
        'technology-automation' => [
            'link'        => '/technology-automation',
        ],
    ],
];
