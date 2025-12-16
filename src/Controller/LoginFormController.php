<?php

declare(strict_types=1);

namespace VideoHub\Mvc\Controller;

use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginFormController implements RequestHandlerInterface
{
    public function __construct(private Engine $template) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (($_SESSION['logado'] ?? false) == true) {
            return new Response(302, ['Location' => '/']);
        }

        return new Response(200, [], $this->template->render('login-form'));
    }
}
