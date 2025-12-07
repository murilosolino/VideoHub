<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

class LogoutController implements Controller
{

    public function processaRequisicao(): void
    {
        unset($_SESSION['logado']);
        header("Location: /login");
    }
}
