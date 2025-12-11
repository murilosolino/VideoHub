<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller\Api;

use Aluraplay\Mvc\Controller\Controller;
use Aluraplay\Mvc\Entity\Video;
use Aluraplay\Mvc\Repository\RespositorioVideos;

class NovoVideoJsonController implements Controller
{

    public function __construct(
        private RespositorioVideos $respositorioVideos
    ) {}

    public function processaRequisicao(): void
    {
        $content = file_get_contents("php://input");
        $arrayVideo = json_decode($content, true);
        $video = new Video($arrayVideo['url'], $arrayVideo['titulo']);
        $this->respositorioVideos->inserir($video);
        http_response_code(201);
    }
}
