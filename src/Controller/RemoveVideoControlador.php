<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

use Aluraplay\Mvc\Repository\RespositorioVideos;

class RemoveVideoControlador implements Controller
{

    public function __construct(private RespositorioVideos $respositorioVideos) {}

    public function processaRequisicao(): void
    {

        try {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

            if ($id === false || $id === null || $id < 1) {
                throw new \InvalidArgumentException('Id inválido');
            }

            $result = $this->respositorioVideos->remover($id);

            $result ? header('Location: /?success=1') : throw new \Exception('Ocorreu um erro durante a exclusão do registro no banco de dados');
        } catch (\Throwable $th) {
            header('Location: /?success=0');
            exit();
        }
    }
}
