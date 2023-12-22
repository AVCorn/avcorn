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
        $params = $request->getQueryParams();

        // if a form is submitted
        if (isset($params['form'])) {
            // configure the Google Client
            $client = new Google_Client();
            $client->setAuthConfig(
                [
                    "type" => "service_account",
                    "client_id" => '193056668279-qiij1j5edquktpnpanbf88mp79ade20d.apps.googleusercontent.com',
                    "client_email" => 'google-sheets@contact-form-sheet-408920.iam.gserviceaccount.com',
                    "client_secret" => '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',
                    "signing_algorithm" => "HS256",
                ]
            );
            $client->setApplicationName('Google Sheets API');
            $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);

            // configure the Sheets Service
            $service = new Google_Service_Sheets($client);

            // loop through $params
            foreach ($params as $key => $value) {
                // if the key is not a 'col?-', unset it
                if (substr($key, 0, 3) !== 'col' || !strpos($key, '-')) {
                    unset($params[$key]);
                }
            }

            // sort $params alphabetically
            ksort($params);

            // insert row
            $spreadsheetId = '13xyVNGE1axQ9vu148DbuD3SBYq0brkaOmiVir3TIIsQ';
            $rows = [$params]; // you can append several rows at once
            $valueRange = new Google_Service_Sheets_ValueRange();
            $valueRange->setValues($rows);
            $range = 'Sheet1'; // the service will detect the last row of this sheet
            $options = ['valueInputOption' => 'USER_ENTERED'];
            $service->spreadsheets_values->append($spreadsheetId, $range, $valueRange, $options);
        }
    
        return $handler->handle($request);
    }
}