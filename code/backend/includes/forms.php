<?php

/**
 * Form configuration
 *
 * PHP version 8.1
 *
 * @param App $app
 *
 * @return void
 *
 * @phpversion >= 8.1
 * @category   CMS
 * @package    AVCorn
 * @subpackage Backend Includes
 * @author     Benjamin J. Young
 * @copyright  2023 Web Elements
 * @license    GPLv3
 * @link       https://github.com/avcorn/avcorn
 */

declare(strict_types=1);

use App\Application\Middleware\FormMiddleware;
use Slim\App;

return function (App $app) {
    $app->add(FormMiddleware::class);
};
