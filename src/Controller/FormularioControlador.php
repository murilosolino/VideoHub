<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

use Aluraplay\Mvc\Entity\Video;
use Aluraplay\Mvc\Repository\RespositorioVideos;
use InvalidArgumentException;

class FormularioControlador implements Controller
{

    public function __construct(private RespositorioVideos $respositorioVideos) {}

    public function processaRequisicao(): void
    {

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        $video = null;

        if ($id !== false && $id !== null) {
            $video = $this->respositorioVideos->buscarPorId($id);
        }

        require_once __DIR__ . '/../../views/formulario-html.php';
    }
}
