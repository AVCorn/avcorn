<?php

declare(strict_types=1);

require_once('map.php');
require_once('information.php');
require_once('sitemap.php');
require_once('trackers.php');

$config['map'] = $map;
$config['info'] = $information;
$config['sitemap'] = $sitemap;
$config['trackers'] = $trackers;

$config['enable_params'] = false;
