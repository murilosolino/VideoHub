<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller\Api;

use Aluraplay\Mvc\Controller\Controller;
use Aluraplay\Mvc\Entity\Video;
use Aluraplay\Mvc\Repository\RespositorioVideos;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class VideosJsonController implements Controller
{

    public function __construct(
        private RespositorioVideos $respositorioVideos
    ) {}

    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        $listaVideos =  array_map(function (Video $video): array {
            return [
                "id" => $video->id,
                "url" => $video->url,
                "file_path" => $video->getFilePath()
            ];
        }, $this->respositorioVideos->buscarTodos());
        return new Response(200, ['Content-Type: application/json'], json_encode($listaVideos, JSON_PRETTY_PRINT));
    }
}
