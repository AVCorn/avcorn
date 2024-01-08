<?php

/**
 * Client Web Elements Configuration
 *
 * PHP version 8.2
 *
 * @phpversion >= 8.2
 * @category   CMS
 * @package    AVCorn
 * @subpackage Client
 * @author     Benjamin J. Young <ben@blaher.me>
 * @copyright  2023 Web Elements
 * @license    GNU General Public License, version 3
 * @link       https://webelements.agency/
 */

declare(strict_types=1);

require_once 'config/map.php';
require_once 'config/information.php';
require_once 'config/navigation.php';
require_once 'config/social.php';
require_once 'config/sitemap.php';
require_once 'config/trackers.php';

/**
 * Overriding default configuration.
 *
 * @var array $map
 * @var array $information
 * @var array $navigation
 * @var array $social
 * @var array $sitemap
 * @var array $trackers
 */
$config['map']           = $map;
$config['info']          = $information;
$config['navigation']    = $navigation;
$config['social']        = $social;
$config['sitemap']       = $sitemap;
$config['trackers']      = $trackers;

$config['home']          = '/';
$config['enable_params'] = false;
