<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

use Aluraplay\Mvc\Repository\RespositorioVideos;
use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ListaVideosControlador implements RequestHandlerInterface
{

    public function __construct(
        private RespositorioVideos $respositorioVideos,
        private Engine $template,
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $listaVideos = $this->respositorioVideos->buscarTodos();

        return new Response(200, [], $this->template->render('lista-videos-html', ['listaVideos' => $listaVideos]));
    }
}
