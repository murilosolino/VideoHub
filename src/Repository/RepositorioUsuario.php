<?php

declare(strict_types=1);

namespace VideoHub\Mvc\Repository;

use VideoHub\Mvc\Entity\Usuario;
use VideoHub\Mvc\Repository\Interface\InterfaceRepositorio;
use InvalidArgumentException;
use PDO;

class RepositorioUsuario
{
    public function __construct(private PDO $pdo) {}

    public function buscarPorEmail(Usuario $usuario): ?Usuario
    {

        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $usuario->email);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            return null;
        }

        return $this->hydrateUsuario($result);
    }

    public function atualizaSenha(string $senha, int $id): void
    {
        $stmt = $this->pdo->prepare("UPDATE usuario SET password = ? WHERE id = ?");
        $stmt->bindValue(1, $senha);
        $stmt->bindValue(2, $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    private function hydrateUsuario(array $usuario): Usuario
    {
        $usuarioHidratado =  new Usuario($usuario['email'], $usuario['password']);
        $usuarioHidratado->setId($usuario['id']);
        return $usuarioHidratado;
    }
}
