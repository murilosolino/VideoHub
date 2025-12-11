<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller\Api;

use Aluraplay\Mvc\Controller\Controller;
use Aluraplay\Mvc\Entity\Video;
use Aluraplay\Mvc\Repository\RespositorioVideos;

class VideosJsonController implements Controller
{

    public function __construct(
        private RespositorioVideos $respositorioVideos
    ) {}

    public function processaRequisicao(): void
    {
        $listaVideos =  array_map(function (Video $video): array {
            return [
                "id" => $video->id,
                "url" => $video->url,
                "file_path" => $video->getFilePath()
            ];
        }, $this->respositorioVideos->buscarTodos());
        echo json_encode($listaVideos);
        header('Content-Type: application/json');
    }
}
