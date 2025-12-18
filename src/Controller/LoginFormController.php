<?php

declare(strict_types=1);

namespace VideoHub\Mvc\Controller;

use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use VideoHub\Mvc\Service\UserService;

class LoginFormController implements RequestHandlerInterface
{
    public function __construct(private Engine $template, private UserService $userService) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $result = $this->userService->checaUsuarioLogado();
        return $result ? new Response(302, ['Location' => '/']) : new Response(200, [], $this->template->render('login-form'));
    }
}
