<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller\Api;

use Aluraplay\Mvc\Controller\Controller;
use Aluraplay\Mvc\Entity\Video;
use Aluraplay\Mvc\Repository\RespositorioVideos;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class NovoVideoJsonController implements Controller
{

    public function __construct(
        private RespositorioVideos $respositorioVideos
    ) {}

    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {

        $content = $request->getBody()->getContents();
        $content = file_get_contents("php://input");
        $arrayVideo = json_decode($content, true);
        $video = new Video($arrayVideo['url'], $arrayVideo['titulo']);
        $this->respositorioVideos->inserir($video);
        return new Response(201);
    }
}
