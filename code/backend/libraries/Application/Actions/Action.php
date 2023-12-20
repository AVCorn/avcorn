<?php

declare(strict_types=1);

namespace App\Application\Actions;

use App\Domain\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

/**
 * Abstract action.
 * 
 * @phpversion  >= 8.1
 * @package     App\Application\Actions
 */
abstract class Action
{
    protected LoggerInterface $logger;
    protected Request $request;
    protected Response $response;
    protected array $args;

    /**
     * @codeCoverageIgnore
     * 
     * @param   LoggerInterface $logger
     * 
     * @return  void
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param   Request $req
     * @param   Response $res
     * @param   array $args
     * 
     * @return  Response
     * @throws  HttpNotFoundException
     * @throws  HttpBadRequestException
     */
    public function __invoke(Request $req, Response $res, array $args): Response
    {
        $this->request = $req;
        $this->response = $res;
        $this->args = $args;

        try {
            return $this->action();
        } catch (DomainRecordNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }
    }

    /**
     * @throws  DomainRecordNotFoundException
     * @throws  HttpBadRequestException
     */
    abstract protected function action(): Response;

    /**
     * @return array|object
     */
    protected function getFormData()
    {
        return $this->request->getParsedBody();
    }

    /**
     * @param   string $name
     * 
     * @return  mixed
     * @throws  HttpBadRequestException
     */
    protected function resolveArg(string $name)
    {
        if (!isset($this->args[$name])) {
            throw new HttpBadRequestException($this->request, "Could not resolve argument `{$name}`.");
        }

        return $this->args[$name];
    }

    /**
     * @param   array|object|null $data
     * @param   int $statusCode
     * 
     * @return  Response
     */
    protected function respondWithData($data = null, int $statusCode = 200): Response
    {
        $payload = new ActionPayload($statusCode, $data);

        return $this->respond($payload);
    }

    /**
     * @param   ActionPayload $payload
     * 
     * @return  Response
     */
    protected function respond(ActionPayload $payload): Response
    {
        $json = json_encode($payload, JSON_PRETTY_PRINT);
        $this->response->getBody()->write($json);

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($payload->getStatusCode());
    }
}
