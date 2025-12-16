<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

use Aluraplay\Mvc\Helper\RenderHtmlTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoginFormController implements Controller
{
    use RenderHtmlTrait;

    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        if (($_SESSION['logado'] ?? false) == true) {
            return new Response(302, ['Location' => '/']);
        }

        return new Response(200, [], $this->renderTemplate('login-form'));
    }
}
