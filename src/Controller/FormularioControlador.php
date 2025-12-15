<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

use Aluraplay\Mvc\Helper\RenderHtmlTrait;
use Aluraplay\Mvc\Repository\RespositorioVideos;

class FormularioControlador implements Controller
{
    use RenderHtmlTrait;
    public function __construct(private RespositorioVideos $respositorioVideos) {}

    public function processaRequisicao(): void
    {

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        $video = null;

        if ($id !== false && $id !== null) {
            $video = $this->respositorioVideos->buscarPorId($id);
        }

        echo $this->renderTemplate('formulario-html', ['video' => $video]);
    }
}
