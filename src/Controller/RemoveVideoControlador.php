<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

use Aluraplay\Mvc\Helper\FlashMessageTrait;
use Aluraplay\Mvc\Repository\RespositorioVideos;

class RemoveVideoControlador implements Controller
{
    use FlashMessageTrait;

    public function __construct(private RespositorioVideos $respositorioVideos) {}

    public function processaRequisicao(): void
    {


        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id === false || $id === null || $id < 1) {
            $this->addFlashErrorMessage("Id de vídeo inválido, impossível de excluir");
            header('Location: /');
            return;
        }

        $video = $this->respositorioVideos->buscarPorId($id);

        if (is_null($video)) {
            $this->addFlashErrorMessage("Id de vídeo inválido, impossível de excluir");
            header('Location: /');
            return;
        }

        $result = $this->respositorioVideos->remover($video->id);

        if (!$result) {
            $this->addFlashErrorMessage("Ocorreu um erro durante a exclusão do registro no banco de dados");
        }

        header('Location: /');
    }
}
