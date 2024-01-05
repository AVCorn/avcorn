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
 * @link       https://webelements.agency/
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
            'modified'    => filemtime(__DIR__ . '/../pages/about.html'),
        ],
        'services' => [
            'title'       => 'Services',
            'description' => 'Services we offer.',
            'link'        => '/services',
            'modified'    => filemtime(__DIR__ . '/../pages/services.html'),
        ],
        'clients' => [
            'title'       => 'Our Clients',
            'description' => 'List of our clients.',
            'link'        => '/clients',
            'modified'    => filemtime(__DIR__ . '/../pages/clients.html'),
        ],
        'contact' => [
            'title'       => 'Contact Us',
            'description' => 'How to contact us.',
            'link'        => '/contact',
            'modified'    => filemtime(__DIR__ . '/../pages/contact.html'),
        ],
        'lander' => [
            'title'       => 'Get a Website',
            'description' => '
                Need a website for your small business?
                We\'ve got you!
            ',
            'link'        => '/get-a-website',
            'modified'    => filemtime(__DIR__ . '/../pages/lander.html'),
        ],
        'terms' => [
            'title'       => 'Terms of Use',
            'description' => 'Terms of use of the website.',
            'link'        => '/terms-of-use',
            'modified'    => filemtime(__DIR__ . '/../pages/terms.html'),
        ],
        'privacy' => [
            'title'       => 'Privacy Policy',
            'description' => 'Privacy policy of the website.',
            'link'        => '/privacy-policy',
            'modified'    => filemtime(__DIR__ . '/../pages/privacy.html'),
        ],
        'cookies' => [
            'title'       => 'Cookies Usage',
            'description' => 'Our cookie usage.',
            'link'        => '/cookies',
            'modified'    => filemtime(__DIR__ . '/../pages/cookies.html'),
        ],
        'sitemap' => [
            'title'       => 'Sitemap',
            'description' => 'Navigation map of the website.',
            'link'        => '/sitemap',
        ],

        // These are only included in sitemap.xml
        'website-design' => [
            'link'        => '/website-design',
            'modified'    => filemtime(__DIR__ . '/../pages/landers/website-design.html'),
        ],
        'lead-generation' => [
            'link'        => '/lead-generation',
            'modified'    => filemtime(__DIR__ . '/../pages/landers/lead-generation.html'),
        ],
        'marketing-analytics' => [
            'link'        => '/marketing-analytics',
            'modified'    => filemtime(__DIR__ . '/../pages/landers/marketing-analytics.html'),
        ],
        'search-engine-optimization' => [
            'link'        => '/search-engine-optimization',
            'modified'    => filemtime(__DIR__ . '/../pages/landers/search-engine-optimization.html'),
        ],
        'search-engine-marketing' => [
            'link'        => '/search-engine-marketing',
            'modified'    => filemtime(__DIR__ . '/../pages/landers/search-engine-marketing.html'),
        ],
        'social-media-marketing' => [
            'link'        => '/social-media-marketing',
            'modified'    => filemtime(__DIR__ . '/../pages/landers/social-media-marketing.html'),
        ],
        'content-marketing' => [
            'link'        => '/content-marketing',
            'modified'    => filemtime(__DIR__ . '/../pages/landers/content-marketing.html'),
        ],
        'social-media-management' => [
            'link'        => '/social-media-management',
            'modified'    => filemtime(__DIR__ . '/../pages/landers/social-media-management.html'),
        ],
        'email-marketing' => [
            'link'        => '/email-marketing',
            'modified'    => filemtime(__DIR__ . '/../pages/landers/email-marketing.html'),
        ],
        'online-footprint' => [
            'link'        => '/online-footprint',
            'modified'    => filemtime(__DIR__ . '/../pages/landers/online-footprint.html'),
        ],
        'web-hosting' => [
            'link'        => '/web-hosting',
            'modified'    => filemtime(__DIR__ . '/../pages/landers/web-hosting.html'),
        ],
        'security-management' => [
            'link'        => '/security-management',
            'modified'    => filemtime(__DIR__ . '/../pages/landers/security-management.html'),
        ],
        'technology-automation' => [
            'link'        => '/technology-automation',
            'modified'    => filemtime(__DIR__ . '/../pages/landers/technology-automation.html'),
        ],
    ],
];
