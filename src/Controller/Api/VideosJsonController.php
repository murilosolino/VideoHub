<?php

declare(strict_types=1);

namespace VideoHub\Mvc\Controller\Api;

use VideoHub\Mvc\Entity\Video;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use VideoHub\Mvc\Service\VideoService;

class VideosJsonController implements RequestHandlerInterface
{

    public function __construct(
        private VideoService $videoService
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $listaVideos =  array_map(function (Video $video): array {
            return [
                "id" => $video->id,
                "url" => $video->url,
                "file_path" => $video->getFilePath()
            ];
        }, $this->videoService->listarVideos());
        return new Response(200, ['Content-Type: application/json'], json_encode($listaVideos));
    }
}
