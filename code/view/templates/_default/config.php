<?php

declare(strict_types=1);

require_once 'config/map.php';
require_once 'config/navigation.php';
require_once 'config/navigation-footer.php';
require_once 'config/information.php';
require_once 'config/themes.php';
require_once 'config/sitemap.php';

$config = [
	'map' => $map,
	'navigation' => $navigation,
	'navigationFooter' => $navigationFooter,
	'info' => $information,
	'themes' => $themes,
	'sitemap' => $sitemap,
];
