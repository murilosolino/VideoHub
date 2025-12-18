<?php

declare(strict_types=1);

namespace VideoHub\Mvc\Controller;

use VideoHub\Mvc\Entity\Usuario;
use VideoHub\Mvc\Helper\FlashMessageTrait;
use VideoHub\Mvc\Repository\RepositorioUsuario;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use VideoHub\Mvc\Service\UserService;

class LoginValidacaoController implements RequestHandlerInterface
{
    use FlashMessageTrait;
    public function __construct(
        private UserService $userService,
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parsedBody = $request->getParsedBody();
        $email = filter_var($parsedBody['email'], FILTER_VALIDATE_EMAIL);
        $senha = filter_var($parsedBody['password']);

        if ($email === false || $email === null || $senha === false || $senha === null) {
            $this->addFlashErrorMessage('E-mail ou senha inválidos. Verifique suas credenciais');
            return new Response(302, ['Location' => '/login']);
        }

        $result = $this->userService->validaLogin($email, $senha);

        return $result ? new Response(302, ['Location' => '/']) : new Response(302, ['Location' => '/login']);
    }
}
