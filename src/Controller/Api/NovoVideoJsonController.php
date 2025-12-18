<?php

declare(strict_types=1);

namespace VideoHub\Mvc\Controller\Api;

use VideoHub\Mvc\Controller\Controller;
use VideoHub\Mvc\Entity\Video;
use VideoHub\Mvc\Repository\RespositorioVideos;
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

        $content = $request->getBody()->getContents();
        $content = file_get_contents("php://input");
        $arrayVideo = json_decode($content, true);
        $this->videoService->novoVideo($arrayVideo['url'], $arrayVideo['titulo']);
        return new Response(201);
    }
}
