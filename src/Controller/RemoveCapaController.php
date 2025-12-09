<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

use Aluraplay\Mvc\Repository\RespositorioVideos;

class RemoveCapaController implements Controller
{

    public function __construct(private RespositorioVideos $respositorio) {}

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $result = $this->respositorio->removerCapa($id);

        $result ? header('Location: /?success=1') : header("Location: /success=0");
    }
}
