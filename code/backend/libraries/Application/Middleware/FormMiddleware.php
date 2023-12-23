<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;

/**
 * Form middleware.
 *
 * PHP version 8.1
 *
 * @package App\Application\Middleware
 * @phpversion >= 8.1
 */
class FormMiddleware implements Middleware
{
    /**
     * Example middleware invokable class
     *
     * @param  Request        $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        // get the query parameters
        $params = $request->getParsedBody();

        // if a form is submitted
        if (isset($params['form']) && $params['form'] == 1) {
            // set sheet info
            $spreadsheetId = $params['form_id'];
            unset($params['form_id']);
            $range = $params['form_range'] ? $params['form_range'] : 'Sheet1';
            unset($params['form_range']);

            // configure the Google Client
            $client = new Google_Client();
            $client->setAuthConfig(__DIR__ . '/../../../../_env/google.private.key.json');
            $client->setApplicationName('Google Sheets API');
            $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);

            // configure the Sheets Service
            $service = new Google_Service_Sheets($client);

            // loop through $params
            foreach ($params as $key => $value) {
                // if the key is not a 'form-', unset it
                if (substr($key, 0, 5) !== 'form_') {
                    unset($params[$key]);
                }
            }

            // sort $params alphabetically
            ksort($params);

            // replace all keys of $params with integers
            $params = array_values($params);

            // build rows to insert
            $rows = [$params]; // you can append several rows at once
            $valueRange = new Google_Service_Sheets_ValueRange();
            $valueRange->setValues($rows);
            $options = ['valueInputOption' => 'USER_ENTERED'];

            $status = 2;
            try {
                // insert the row
                $service->spreadsheets_values->append($spreadsheetId, $range, $valueRange, $options);

                // get the request URI and redirect
                $uri = (string)$request->getUri()->withQuery($request->getUri()->getQuery() . '&form=' . $status);
                return $handler->handle($request)->withHeader('Location', $uri)->withStatus(302);
            } catch (\Exception $e) {
                return $handler->handle($request);
            }
        }

        return $handler->handle($request);
    }
}
