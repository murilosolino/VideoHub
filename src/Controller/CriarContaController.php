<?php

declare(strict_types=1);

namespace VideoHub\Mvc\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use VideoHub\Mvc\Entity\Usuario;
use VideoHub\Mvc\Helper\FlashMessageTrait;
use VideoHub\Mvc\Repository\RepositorioUsuario;

class CriarContaController implements RequestHandlerInterface
{
    use FlashMessageTrait;
    public function __construct(private RepositorioUsuario $repositorio) {}
    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $parsedBody = $request->getParsedBody();
        $email =  filter_var($parsedBody['email'], FILTER_VALIDATE_EMAIL);
        $senha = filter_var($parsedBody['password']);

        if ($email === false || $email === null || $senha === false || $senha === null) {
            $this->addFlashErrorMessage('Não foi possível criar usuário, valores inválidos');
            return new Response(302, ['Location' => '/criar-conta']);
        }
        $userExists = $this->repositorio->buscarPorEmail($email);

        if ($userExists) {
            $this->addFlashErrorMessage('Já existe um cadastro com este email');
            return new Response(302, ['Location' => '/criar-conta']);
        }

        $this->repositorio->criarUsuario($email, $senha);
        $this->addFlashSuccessMessage('Usuário cadastrado com sucesso! Efetue o login!');
        return new Response(302, ['Location' => '/login']);
    }
}
