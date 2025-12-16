<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

use Aluraplay\Mvc\Helper\FlashMessageTrait;
use Aluraplay\Mvc\Repository\RespositorioVideos;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RemoveCapaController implements Controller
{
    use FlashMessageTrait;
    public function __construct(private RespositorioVideos $respositorio) {}

    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        $queryParam =  $request->getQueryParams();
        $id = filter_var($queryParam['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            $this->addFlashErrorMessage('ID de vídeo inválido.');
            return new Response(302, ['Location' => '/']);
        }
        $result = $this->respositorio->removerCapa($id);

        if (!$result) {
            $this->addFlashErrorMessage('Ocorreu um erro ao remover a capa do vídeo. Tente novamente mais tarde');
        }
        return new Response(302, ['Location' => '/']);
    }
}
