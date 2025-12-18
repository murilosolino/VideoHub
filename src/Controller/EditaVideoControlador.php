<?php

declare(strict_types=1);

namespace VideoHub\Mvc\Controller;

use VideoHub\Mvc\Helper\FlashMessageTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use VideoHub\Mvc\Service\VideoService;

class EditaVideoControlador implements RequestHandlerInterface
{
    use FlashMessageTrait;
    public function __construct(
        private VideoService $videoService
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parsedBody = $request->getParsedBody();
        $params = $request->getQueryParams();

        $url = filter_var($parsedBody['url'], FILTER_VALIDATE_URL);
        $titulo = filter_var($parsedBody['titulo']);
        $id = filter_var($params['id'], FILTER_VALIDATE_INT);

        if (
            $url === false || $url === null || !preg_match('/^https?:\/\/[^\s]+$/', $url) ||
            empty(trim($titulo)) ||
            $id === false || $id === null
        ) {
            $this->addFlashErrorMessage('Dados para edição do vídeo inválidos');
            return new Response(302, ['Location' => '/editar-video?id=' . (is_int($id) ? $id : '')]);
        }

        $this->videoService->editarVideo($url, $titulo, $id);

        return new Response(302, ['Location' => '/']);
    }
}
