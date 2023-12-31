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
            'title' => 'Our Site',
            'link' => '/',
            'pages' => [
                'home',
                'about',
                'contact',
            ],
        ],
        'secondary' => [
            'title' => 'Resources',
            'description' => 'Find out more about us.',
            'link' => '/about',
            'pages' => [
                'sitemap',
            ],
        ],
        'other' => [
            'title' => 'Other',
            'description' => 'Additional information.',
            'link' => '/sitemap',
            'pages' => [
                'terms',
                'privacy',
                'cookies',
            ],
        ],
    ],
    'pages' => [
        'home' => [
            'title' => 'Home',
            'link' => '/',
        ],
        'about' => [
            'title' => 'About Us',
            'description' => 'Information and history of AVCorn.',
            'link' => '/about',
        ],
        'contact' => [
            'title' => 'Contact Us',
            'description' => 'How to contact us.',
            'link' => '/contact',
        ],
        'terms' => [
            'title' => 'Terms of Use',
            'description' => 'Terms of use of the website.',
            'link' => '/terms-of-use',
        ],
        'privacy' => [
            'title' => 'Privacy Policy',
            'description' => 'Privacy policy of the website.',
            'link' => '/privacy-policy',
        ],
        'cookies' => [
            'title' => 'Cookies Usage',
            'description' => 'Our cookie usage.',
            'link' => '/cookies',
        ],
        'sitemap' => [
            'title' => 'Sitemap',
            'description' => 'Navigation map of the website.',
            'link' => '/sitemap',
        ],
    ],
];
