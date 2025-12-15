<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

use Aluraplay\Mvc\Helper\RenderHtmlTrait;

class LoginFormController implements Controller
{
    use RenderHtmlTrait;

    public function processaRequisicao(): void
    {
        if (($_SESSION['logado'] ?? false) == true) {
            header('Location: /');
            return;
        }

        echo $this->renderTemplate('login-form');
    }
}
