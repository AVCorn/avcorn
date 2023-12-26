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
        'label' => '
            <span class="show-for-medium">
                <i class="show-for-medium fa fa-users"></i> Who We Are
            </span>
            <span class="show-for-small-only">About</span>
        ',
    ],
    [
        'href' => '/clients',
        'label' => '
            <span class="show-for-medium">
                <i class="show-for-medium fa fa-briefcase"></i> Our Work
            </span>
            <span class="show-for-small-only">Clients</span>
        ',
    ],
    [
        'href' => '/services',
        'label' => '
            <span class="show-for-medium">
                <i class="show-for-medium fa fa-globe"></i> What We Offer
            </span>
            <span class="show-for-small-only">Services</span>
        ',
    ],
    [
        'href' => '/contact',
        'label' => '
            <br class="show-for-small-only" />
            <span class="show-for-medium">
                <i class="fa fa-phone"></i> Contact Us
            </span>
            <span class="button show-for-small-only">Connect</span>
        ',
    ],
];
