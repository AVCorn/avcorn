<?php

/**
 * Navigation configuration
 *
 * PHP version 8.1
 *
 * @package    Application
 * @subpackage Configuration
 * @phpversion >= 8.1
 */

declare(strict_types=1);

/**
 * Navigation configuration
 *
 * @var array $navigation Navigation configuration
 */
$navigation = [
    [
        'href' => '/about',
        'label' => '<i class="show-for-medium fa fa-users"></i> Who We Are',
    ],
    [
        'href' => '/clients',
        'label' => '<i class="show-for-medium fa fa-briefcase"></i> Our Work',
    ],
    [
        'href' => '/services',
        'label' => '<i class="show-for-medium fa fa-globe"></i> What We Offer',
    ],
    [
        'href' => '/contact',
        'label' => '
            <span class="show-for-medium">
                <i class="fa fa-phone"></i> Contact Us
            </span>
            <span class="button show-for-small-only">Connect</span>
        ',
    ],
];
