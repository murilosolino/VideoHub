<?php

declare(strict_types=1);

namespace VideoHub\Mvc\Service;

use Firebase\JWT\JWT;
use VideoHub\Mvc\Entity\Usuario;
use VideoHub\Mvc\Helper\FlashMessageTrait;
use VideoHub\Mvc\Repository\RepositorioUsuario;

class UserService
{

    use FlashMessageTrait;
    public function __construct(private RepositorioUsuario $repositorioUsuario) {}

    public function criarConta(string $email, string $senha): bool
    {
        $userExists = $this->repositorioUsuario->buscarPorEmail($email);

        if ($userExists) {
            $this->addFlashErrorMessage('Já existe um cadastro com este email');
            return false;
        }

        $this->repositorioUsuario->criarUsuario($email, $senha);
        $this->addFlashSuccessMessage('Usuário cadastrado com sucesso! Efetue o login!');
        return true;
    }

    public function validaLogin(string $email, string $senha): bool
    {
        $usuario = new Usuario($email, $senha);
        $usuarioBanco = $this->repositorioUsuario->buscarPorEmail($usuario->email);

        if (is_null($usuarioBanco)) {
            $this->addFlashErrorMessage('E-mail ou senha inválidos. Verifique suas credenciais');
            return false;
        }

        if ($usuario->validaLogin($usuarioBanco)) {

            if (password_needs_rehash($usuarioBanco->password, PASSWORD_ARGON2ID)) {
                $novoHash = password_hash($senha, PASSWORD_ARGON2ID);
                $this->repositorioUsuario->atualizaSenha($novoHash, $usuarioBanco->id);
            }
            $_SESSION['logado'] = true;
            $_SESSION['id_usuario_sessao'] = $usuarioBanco->id;
            return true;
        }

        $this->addFlashErrorMessage('E-mail ou senha inválidos. Verifique suas credenciais');
        return false;
    }

    public function logout(): void
    {
        unset($_SESSION['logado']);
    }

    public function checaUsuarioLogado(): bool
    {
        if (($_SESSION['logado'] ?? false) == true) {
            return true;
        }

        return false;
    }

    public function generateJWTToken(string $email): string
    {

        $key = $_ENV['JWT_KEY'];
        $payload = [
            'iss' => 'VideoHub',
            'sub' => 'video-huB-api',
            'exp' => time() + 3600,
            'user_email' => $email,
        ];

        $jwt = 'Bearer ' . JWT::encode($payload, $key, 'HS256');
        return $jwt;
    }
}
