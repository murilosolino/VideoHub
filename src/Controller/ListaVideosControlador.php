<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

use Aluraplay\Mvc\Helper\RenderHtmlTrait;
use Aluraplay\Mvc\Repository\RespositorioVideos;

class ListaVideosControlador implements Controller
{

    use RenderHtmlTrait;
    public function __construct(private RespositorioVideos $respositorioVideos) {}

    public function processaRequisicao(): void
    {

        $listaVideos = $this->respositorioVideos->buscarTodos();

        echo $this->renderTemplate('lista-videos-html', ['listaVideos' => $listaVideos]);
    }
}
