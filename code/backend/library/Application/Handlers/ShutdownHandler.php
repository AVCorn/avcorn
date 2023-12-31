<?php

/**
 * Shutdown Handler
 *
 * PHP version 8.2
 *
 * @phpversion >= 8.2
 * @category   CMS
 * @package    AVCorn
 * @subpackage App\Application\Handlers
 * @author     Benjamin J. Young <ben@blaher.me>
 * @license    GNU General Public License, version 3
 * @link       https://github.com/avcorn/avcorn
 */

 declare(strict_types=1);

namespace App\Application\Handlers;

use App\Application\ResponseEmitter\ResponseEmitter;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpInternalServerErrorException;

/**
 * Shutdown Handler Class
 *
 * @category Handler
 */
class ShutdownHandler
{
    private Request $request;
    private HttpErrorHandler $errorHandler;
    private bool $displayErrorDetails;

    /**
     * Constructor.
     *
     * @param Request          $request             The request
     * @param HttpErrorHandler $errorHandler        The error handler
     * @param bool             $displayErrorDetails Display error details
     *
     * @return void
     */
    public function __construct(
        Request $request,
        HttpErrorHandler $errorHandler,
        bool $displayErrorDetails
    ) {
        $this->request = $request;
        $this->errorHandler = $errorHandler;
        $this->displayErrorDetails = $displayErrorDetails;
    }

    /**
     * Invoke shutdown handler.
     *
     * @return void
     */
    public function __invoke()
    {
        $error = error_get_last();
        if ($error) {
            $errorFile = $error['file'];
            $errorLine = $error['line'];
            $errorMessage = $error['message'];
            $errorType = $error['type'];
            $message = '
                An error while processing your request.
                Please try again later.
            ';

            if ($this->displayErrorDetails) {
                switch ($errorType) {
                    case E_USER_ERROR:
                        $message = "FATAL ERROR: {$errorMessage}. ";
                        $message .= " on line {$errorLine} in file {$errorFile}.";
                        break;

                    case E_USER_WARNING:
                        $message = "WARNING: {$errorMessage}";
                        break;

                    case E_USER_NOTICE:
                        $message = "NOTICE: {$errorMessage}";
                        break;

                    default:
                        $message = "ERROR: {$errorMessage}";
                        $message .= " on line {$errorLine} in file {$errorFile}.";
                        break;
                }
            }

            $exception = new HttpInternalServerErrorException(
                $this->request,
                $message
            );
            $response = $this->errorHandler->__invoke(
                $this->request,
                $exception,
                $this->displayErrorDetails,
                false,
                false,
            );

            $responseEmitter = new ResponseEmitter();
            $responseEmitter->emit($response);
        }
    }
}
