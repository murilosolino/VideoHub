<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

use Aluraplay\Mvc\Entity\Usuario;
use Aluraplay\Mvc\Repository\RepositorioUsuario;

class LoginValidacaoController implements Controller
{

    public function __construct(
        private RepositorioUsuario $repositorioUsuario,
    ) {}

    public function processaRequisicao(): void
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $senha = filter_input(INPUT_POST, 'password');

        if ($email === false || $email === null || $senha === false || $senha === null) {
            $_SESSION['error_message'] = 'E-mail ou senha inválidos. Verifique suas credenciais';
            header('Location: /login');
            return;
        }
        $usuario = new Usuario($email, $senha);
        $usuarioBanco = $this->repositorioUsuario->buscarPorEmail($usuario);

        if (is_null($usuarioBanco)) {
            $_SESSION['error_message'] = 'E-mail ou senha inválidos. Verifique suas credenciais';
            header('Location: /login');
            return;
        }

        if ($usuario->validaLogin($usuarioBanco)) {

            if (password_needs_rehash($usuarioBanco->password, PASSWORD_ARGON2ID)) {
                $novoHash = password_hash($senha, PASSWORD_ARGON2ID);
                $this->repositorioUsuario->atualizaSenha($novoHash, $usuarioBanco->id);
            }
            $_SESSION['logado'] = true;
            header('Location: /');
            return;
        } else {
            $_SESSION['error_message'] = 'E-mail ou senha inválidos. Verifique suas credenciais';
            header('Location: /login');
        }
    }
}
