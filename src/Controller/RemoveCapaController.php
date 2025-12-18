<?php

declare(strict_types=1);

namespace VideoHub\Mvc\Controller;

use VideoHub\Mvc\Helper\FlashMessageTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use VideoHub\Mvc\Service\VideoService;

class RemoveCapaController implements RequestHandlerInterface
{
    use FlashMessageTrait;
    public function __construct(private VideoService $videoService) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParam =  $request->getQueryParams();
        $id = filter_var($queryParam['id'] ?? '', FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            $this->addFlashErrorMessage('ID de vídeo inválido.');
            return new Response(302, ['Location' => '/']);
        }

        $this->videoService->removerCapaVideo($id);

        return new Response(302, ['Location' => '/']);
    }
}
