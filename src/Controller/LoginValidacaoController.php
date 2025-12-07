<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

use Aluraplay\Mvc\Entity\Usuario;
use Aluraplay\Mvc\Repository\RepositorioUsuario;
use Exception;

class LoginValidacaoController implements Controller
{

    public function __construct(
        private RepositorioUsuario $repositorioUsuario,
    ) {}

    public function processaRequisicao(): void
    {
        try {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $senha = filter_input(INPUT_POST, 'password');

            if (empty($email) || empty($senha)) {
                header('Location: /login?success=0');
                exit();
            }

            $usuario = new Usuario($email, $senha);

            $usuarioBanco = $this->repositorioUsuario->buscarPorEmail($usuario);

            if ($usuario->validaLogin($usuarioBanco)) {
                $_SESSION['logado'] = true;

                header('Location: /');
                return;
            } else {
                throw new Exception();
            }
        } catch (\Throwable $th) {
            header('Location: /login?success=0');
            exit();
        }
    }
}
