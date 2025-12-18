<?php

declare(strict_types=1);

namespace VideoHub\Mvc\Controller;

use VideoHub\Mvc\Helper\FlashMessageTrait;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use VideoHub\Mvc\Service\VideoService;

class NovoVideoControlador implements RequestHandlerInterface
{
    use FlashMessageTrait;
    public function __construct(
        private VideoService $videoService
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $parsedBody =  $request->getParsedBody();
        $url = filter_var($parsedBody['url'], FILTER_VALIDATE_URL);
        $titulo = filter_var($parsedBody['titulo'],);

        if (
            $url === false || $url === null || !preg_match('/^https?:\/\/[^\s]+$/', $url) ||
            empty(trim($titulo))
        ) {
            $this->addFlashErrorMessage('Dados para cadastro de vídeo inválidos');
            return new Response(302, ['Location' => '/novo-video']);
        }

        $result = $this->videoService->novoVideo($url, $titulo);

        return $result ?  new Response(302, ['Location' => '/']) :  new Response(302, ['Location' => '/novo-video']);
    }
}
