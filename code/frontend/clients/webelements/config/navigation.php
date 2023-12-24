<?php

/**
 * Navigation configuration
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
