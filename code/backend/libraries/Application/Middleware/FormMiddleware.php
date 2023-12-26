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
 * PHP version 8.2
 *
 * @phpversion >= 8.2
 * @category   CMS
 * @package    AVCorn
 * @subpackage App\Application\Middleware
 * @author     Benjamin J. Young <ben@blaher.me>
 * @license    GNU General Public License, version 3
 * @link       https://github.com/avcorn/avcorn
 */
class FormMiddleware implements Middleware
{
    /**
     * Example middleware invokable class
     *
     * @param Request        $request PSR-7 request
     * @param RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        // get the query parameters
        $params = $request->getParsedBody();

        // if a form is submitted
        if (isset($params['form']) && $params['form'] == 1) {
            // set status for later
            $status = 2;

            // TODO: split up cases in to seperate classes

            // for SES emails
            if (isset($params['form_email_to'])) {
                // email here using SES
            }

            // for google sheets
            if (isset($params['form_sheet_id'])) {
                // set sheet info
                $spreadsheetId = $params['form_sheet_id'];
                unset($params['form_sheet_id']);
                $range = $params['form_sheet_range']
                    ? $params['form_sheet_range']
                    : 'Sheet1';
                unset($params['form_sheet_range']);

                // configure the Google Client
                $client = new Google_Client();
                $client->setAuthConfig(
                    __DIR__
                    . '/../../../../_env/google.private.key.json'
                );
                $client->setApplicationName('Google Sheets API');
                $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);

                // configure the Sheets Service
                $service = new Google_Service_Sheets($client);

                // loop through $params
                foreach ($params as $key => $pval) {
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

                // insert the row
                try {
                    $service->spreadsheets_values->append(
                        $spreadsheetId,
                        $range,
                        $valueRange,
                        $options
                    );
                } catch (\Exception $e) {
                    $status = 0;
                }
            }

            if ($status > 1) {
                // get the request URI and redirect
                $uri = (string)$request
                    ->getUri()
                    ->withQuery(
                        $request->getUri()->getQuery()
                            . '&form='
                            . $status
                    );

                return $handler->handle($request)
                    ->withHeader('Location', $uri)
                    ->withStatus(302);
            }

            // continue to load form to handle erro
            return $handler->handle($request);
        }

        // no form handling was found, so continue
        return $handler->handle($request);
    }
}
