<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

use Aluraplay\Mvc\Helper\FlashMessageTrait;
use Aluraplay\Mvc\Repository\RespositorioVideos;

class RemoveCapaController implements Controller
{
    use FlashMessageTrait;
    public function __construct(private RespositorioVideos $respositorio) {}

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            $this->addFlashErrorMessage('ID de vídeo inválido.');
            header('Location: /');
            return;
        }
        $result = $this->respositorio->removerCapa($id);

        if (!$result) {
            $this->addFlashErrorMessage('Ocorreu um erro ao remover a capa do vídeo. Tente novamente mais tarde');
        }
        header('Location: /');
    }
}
