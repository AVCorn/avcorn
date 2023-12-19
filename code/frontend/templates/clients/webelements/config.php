<?php

declare(strict_types=1);

require_once 'config/map.php';
require_once 'config/information.php';
require_once 'config/social.php';
require_once 'config/sitemap.php';
require_once 'config/trackers.php';

$config['map'] = $map;
$config['info'] = $information;
$config['social'] = $social;
$config['sitemap'] = $sitemap;
$config['trackers'] = $trackers;

$config['enable_params'] = false;
