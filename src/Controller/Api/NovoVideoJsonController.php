<?php

declare(strict_types=1);

namespace VideoHub\Mvc\Controller\Api;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use VideoHub\Mvc\Service\VideoService;

class NovoVideoJsonController implements RequestHandlerInterface
{

    public function __construct(
        private VideoService $videoService
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $parsed = $request->getParsedBody();
        if ($parsed === null) {
            $body = $request->getBody();
            $body->rewind();
            $parsed = json_decode($body->getContents(), true) ?? [];
        }

        $url = filter_var($parsed['url'] ?? '', FILTER_VALIDATE_URL);
        $titulo = trim((string)($parsed['titulo'] ?? ''));

        if ($url === false || $titulo === '') {
            return new Response(
                400,
                ['Content-Type' => 'application/json'],
                json_encode(['error' => 'Dados inválidos: url ou titulo ausente'])
            );
        }

        $this->videoService->novoVideo($url, $titulo);

        return new Response(201, ['Content-Type' => 'application/json'], json_encode(['status' => 'created']));
    }
}
