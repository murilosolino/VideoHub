<?php

declare(strict_types=1);

namespace VideoHub\Mvc\Controller;

use VideoHub\Mvc\Repository\RespositorioVideos;
use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use VideoHub\Mvc\Service\VideoService;

class ListaVideosControlador implements RequestHandlerInterface
{

    public function __construct(private VideoService $videoService, private Engine $template) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $listaVideos =  $this->videoService->listarVideos();
        return new Response(200, [], $this->template->render('lista-videos-html', ['listaVideos' => $listaVideos]));
    }
}
