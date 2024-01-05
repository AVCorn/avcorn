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
 * @license    GNU General Public License, version 3
 * @link       https://github.com/avcorn/avcorn
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
            'title'       => 'AVCorn',
            'link'        => '/',
            'pages'       => [
                'home',
                'about',
                'services',
                'gallery',
                'testimonials',
                'contact',
            ],
        ],
        'secondary' => [
            'title'       => 'Resources',
            'description' => 'Find out more about us.',
            'link'        => '/about',
            'pages'       => [
                'guide',
                'designs',
                'playground',
                'contribute',
            ],
        ],
        'other' => [
            'title'       => 'Other Details',
            'description' => 'Additional information.',
            'link'        => '/sitemap',
            'pages'       => [
                'terms',
                'privacy',
                'cookies',
                'sitemap',
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
            'modified'    => filemtime(__DIR__ . '/../../../pages/about.html'),
        ],
        'contact' => [
            'title'       => 'Contact Us',
            'description' => 'How to contact us.',
            'link'        => '/contact',
            'modified'    => filemtime(__DIR__ . '/../../../pages/contact.html'),
        ],
        'contribute' => [
            'title'       => 'Contribute',
            'description' => 'How you can contribute to AVCorn.',
            'link'        => '/contribute',
            'modified'    => filemtime(__DIR__ . '/../../../pages/contribute.html'),
        ],
        'cookies' => [
            'title'       => 'Cookies',
            'description' => 'Our cookie usage.',
            'link'        => '/cookies',
            'modified'    => filemtime(__DIR__ . '/../../../pages/cookies.html'),
        ],
        'guide' => [
            'title'       => 'Guide',
            'description' => 'Walkthrough of how to use AVCorn.',
            'link'        => '/guide',
            'modified'    => filemtime(__DIR__ . '/../../../pages/guide.html'),
        ],
        'designs' => [
            'title'       => 'Designs',
            'description' => 'List of our designs.',
            'link'        => '/designs',
            'modified'    => filemtime(__DIR__ . '/../../../pages/designs.html'),
        ],
        'gallery' => [
            'title'       => 'Gallery',
            'description' => 'Photo gallery.',
            'link'        => '/gallery',
        ],
        'playground' => [
            'title'       => 'Styles Playground',
            'description' => 'Everything on demo, but the kitchen sink.',
            'link'        => '/playground',
            'modified'    => filemtime(__DIR__ . '/../../../pages/playground.html'),
        ],
        'services' => [
            'title'       => 'Services',
            'description' => 'Services we offer.',
            'link'        => '/services',
            'modified'    => filemtime(__DIR__ . '/../../../pages/services.html'),
        ],
        'testimonials' => [
            'title'       => 'Testimonials',
            'description' => 'Testimonials of our customers.',
            'link'        => '/testimonials',
            'modified'    => filemtime(__DIR__ . '/../../../pages/testimonials.html'),
        ],
        'terms' => [
            'title'       => 'Terms of Use',
            'description' => 'Terms of use of the website.',
            'link'        => '/terms-of-use',
            'modified'    => filemtime(__DIR__ . '/../../../pages/terms.html'),
        ],
        'privacy' => [
            'title'       => 'Privacy Policy',
            'description' => 'Privacy policy of the website.',
            'link'        => '/privacy-policy',
            'modified'    => filemtime(__DIR__ . '/../../../pages/privacy.html'),
        ],
        'sitemap' => [
            'title'       => 'Sitemap',
            'description' => 'Navigation map of the website.',
            'link'        => '/sitemap',
        ],
    ],
];
