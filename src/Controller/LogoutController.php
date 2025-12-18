<?php

declare(strict_types=1);

namespace VideoHub\Mvc\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use VideoHub\Mvc\Service\UserService;

class LogoutController implements RequestHandlerInterface
{
    public function __construct(private UserService $userService) {}
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->userService->logout();
        return new Response(302, ['Location' => '/login']);
    }
}
