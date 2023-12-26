<?php

/**
 * Sitemap configuration
 *
 * PHP version 8.1
 *
 * @phpversion >= 8.1
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
                'services',
                'clients',
            ],
        ],
        'other' => [
            'title' => 'Other Details',
            'description' => 'Additional information.',
            'link' => '/sitemap',
            'pages' => [
                'terms',
                'privacy',
                'sitemap',
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
        'services' => [
            'title' => 'Services',
            'description' => 'Services we offer.',
            'link' => '/services',
        ],
        'clients' => [
            'title' => 'Our Clients',
            'description' => 'List of our clients.',
            'link' => '/clients',
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
        'sitemap' => [
            'title' => 'Sitemap',
            'description' => 'Navigation map of the website.',
            'link' => '/sitemap',
        ],
    ],
];