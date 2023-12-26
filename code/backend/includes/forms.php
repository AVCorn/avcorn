<?php

/**
 * Form configuration
 *
 * PHP version 8.2
 *
 * @param App $app
 *
 * @return void
 *
 * @phpversion >= 8.2
 * @category   CMS
 * @package    AVCorn
 * @subpackage Includes
 * @author     Benjamin J. Young <ben@blaher.me>
 * @license    GNU General Public License, version 3
 * @link       https://github.com/avcorn/avcorn
 */

declare(strict_types=1);

use App\Application\Middleware\FormMiddleware;
use Slim\App;

return function (App $app) {
    $app->add(FormMiddleware::class);
};
