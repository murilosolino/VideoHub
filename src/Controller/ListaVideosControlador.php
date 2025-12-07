<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

use Aluraplay\Mvc\Repository\RespositorioVideos;

class ListaVideosControlador implements Controller
{


    public function __construct(private RespositorioVideos $respositorioVideos) {}

    public function processaRequisicao(): void
    {

        $listaVideos = $this->respositorioVideos->buscarTodos();

        require_once __DIR__ . '/../../views/lista-videos-html.php';
    }
}
