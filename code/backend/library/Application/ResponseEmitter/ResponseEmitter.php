<?php

/**
 * Response Emitter
 *
 * PHP version 8.2
 *
 * @phpversion >= 8.2
 * @category   CMS
 * @package    AVCorn
 * @subpackage App\Application\ResponseEmitter
 * @author     Benjamin J. Young <ben@blaher.me>
 * @license    GNU General Public License, version 3
 * @link       https://github.com/avcorn/avcorn
 */

declare(strict_types=1);

namespace App\Application\ResponseEmitter;

use Psr\Http\Message\ResponseInterface;
use Slim\ResponseEmitter as SlimResponseEmitter;

/**
 * Response Emitter Class
 *
 * @category Emitter
 */
class ResponseEmitter extends SlimResponseEmitter
{
    /**
     * Emit response.
     *
     * {@inheritdoc}
     *
     * @param ResponseInterface $response The response
     *
     * @return void
     */
    public function emit(ResponseInterface $response): void
    {
        // This variable should be set to the allowed host
        // from which your API can be accessed with.
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

        $response = $response
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader(
                'Access-Control-Allow-Headers',
                'X-Requested-With, Content-Type, Accept, Origin, Authorization',
            )
            ->withHeader(
                'Access-Control-Allow-Methods',
                'GET, POST, PUT, PATCH, DELETE, OPTIONS'
            )
            ->withHeader(
                'Cache-Control',
                'no-store, no-cache, must-revalidate, max-age=0'
            )
            ->withAddedHeader(
                'Cache-Control',
                'post-check=0, pre-check=0'
            )
            ->withHeader('Pragma', 'no-cache');

        if (ob_get_contents()) {
            ob_clean();
        }

        parent::emit($response);
    }
}
