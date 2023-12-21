<?php

declare(strict_types=1);

namespace App\Application\Handlers;

use App\Application\ResponseEmitter\ResponseEmitter;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpInternalServerErrorException;

/**
 * Shutdown handler.
 *
 * PHP version 8.1
 * @phpversion >= 8.1
 *
 * @package App\Application\Handlers
 */
class ShutdownHandler
{
    private Request $request;
    private HttpErrorHandler $errorHandler;
    private bool $displayErrorDetails;

    /**
     * Constructor.
     *
     * @param   Request             $request
     * @param   HttpErrorHandler    $errorHandler
     * @param   bool                $displayErrorDetails
     *
     * @return  void
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
     * @return  void
     */
    public function __invoke()
    {
        $error = error_get_last();
        if ($error) {
            $errorFile = $error['file'];
            $errorLine = $error['line'];
            $errorMessage = $error['message'];
            $errorType = $error['type'];
            $message = 'An error while processing your request. Please try again later.';

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

            $exception = new HttpInternalServerErrorException($this->request, $message);
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
