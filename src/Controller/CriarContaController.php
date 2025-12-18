<?php

declare(strict_types=1);

namespace VideoHub\Mvc\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use VideoHub\Mvc\Helper\FlashMessageTrait;
use VideoHub\Mvc\Service\UserService;

class CriarContaController implements RequestHandlerInterface
{
    use FlashMessageTrait;
    public function __construct(private UserService $userService) {}
    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $parsedBody = $request->getParsedBody();
        $email =  filter_var($parsedBody['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $senha = filter_var($parsedBody['password'] ?? '');

        if ($email === false || $email === null || $senha === false || $senha === null) {
            $this->addFlashErrorMessage('Não foi possível criar usuário, valores inválidos');
            return new Response(302, ['Location' => '/criar-conta']);
        }

        $result = $this->userService->criarConta($email, $senha);

        return $result ? new Response(302, ['Location' => '/login']) : new Response(302, ['Location' => '/criar-conta']);
    }
}
