<?php

declare(strict_types=1);

namespace VideoHub\Mvc\Controller\Api\Auth;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use VideoHub\Mvc\Service\UserService;

class AutenticacaoApiController implements RequestHandlerInterface
{
    public function __construct(private UserService $userService) {}
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $content = $request->getBody()->getContents();
        $content = file_get_contents("php://input");
        $parsedBody = json_decode($content, true);
        $email = filter_var($parsedBody['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $senha = filter_var($parsedBody['senha'] ?? '');

        if ($email === false || $email === null || $senha === false || $senha === null) {
            return new Response(
                400,
                ['Content-Type: application/json'],
                json_encode(['error' => "Usuario ou senha inválidos, Verifique suas credenciais"])
            );
        }

        if (!$this->userService->validaLogin($email, $senha)) {
            return new Response(
                400,
                ['Content-Type: application/json'],
                json_encode(['error' => "Usuario ou senha invalidos"])
            );
        }

        $jwtToken = $this->userService->generateJWTToken($email);

        return new Response(200, ['Content-Type: application/json'], json_encode(['access_token' => $jwtToken]));
    }
}
