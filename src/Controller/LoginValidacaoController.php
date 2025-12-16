<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

use Aluraplay\Mvc\Entity\Usuario;
use Aluraplay\Mvc\Helper\FlashMessageTrait;
use Aluraplay\Mvc\Repository\RepositorioUsuario;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginValidacaoController implements RequestHandlerInterface
{
    use FlashMessageTrait;
    public function __construct(
        private RepositorioUsuario $repositorioUsuario,
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
        $usuario = new Usuario($email, $senha);
        $usuarioBanco = $this->repositorioUsuario->buscarPorEmail($usuario);

        if (is_null($usuarioBanco)) {
            $this->addFlashErrorMessage('E-mail ou senha inválidos. Verifique suas credenciais');
            return new Response(302, ['Location' => '/login']);
        }

        if ($usuario->validaLogin($usuarioBanco)) {

            if (password_needs_rehash($usuarioBanco->password, PASSWORD_ARGON2ID)) {
                $novoHash = password_hash($senha, PASSWORD_ARGON2ID);
                $this->repositorioUsuario->atualizaSenha($novoHash, $usuarioBanco->id);
            }
            $_SESSION['logado'] = true;
            return new Response(302, ['Location' => '/']);
        } else {
            $this->addFlashErrorMessage('E-mail ou senha inválidos. Verifique suas credenciais');
            return new Response(302, ['Location' => '/login']);
        }
    }
}
