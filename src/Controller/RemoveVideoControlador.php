<?php

declare(strict_types=1);

namespace VideoHub\Mvc\Controller;

use VideoHub\Mvc\Helper\FlashMessageTrait;
use VideoHub\Mvc\Repository\RespositorioVideos;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RemoveVideoControlador implements RequestHandlerInterface
{
    use FlashMessageTrait;

    public function __construct(private RespositorioVideos $respositorioVideos) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $queryParam =  $request->getQueryParams();
        $id = filter_var($queryParam['id'], FILTER_VALIDATE_INT);

        if ($id === false || $id === null || $id < 1) {
            $this->addFlashErrorMessage("Id de vídeo inválido, impossível de excluir");
            return new Response(302, ['Location' => '/']);
        }

        $video = $this->respositorioVideos->buscarPorId($id);

        if (is_null($video)) {
            $this->addFlashErrorMessage("Id de vídeo inválido, impossível de excluir");
            return new Response(302, ['Location' => '/']);
        }

        $result = $this->respositorioVideos->remover($video->id);

        if (!$result) {
            $this->addFlashErrorMessage("Ocorreu um erro durante a exclusão do registro no banco de dados");
        }

        return new Response(302, ['Location' => '/']);
    }
}
