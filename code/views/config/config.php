<?php

declare(strict_types=1);

require_once('map.php');
require_once('navigation.php');
require_once('navigation-footer.php');
require_once('information.php');
require_once('themes.php');

$config = [
  'map' => $map,
  'navigation' => $navigation,
  'navigationFooter' => $navigationFooter,
  'info' => $information,
  'themes' => $themes,
];
