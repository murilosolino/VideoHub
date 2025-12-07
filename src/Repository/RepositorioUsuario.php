<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Repository;

use Aluraplay\Mvc\Entity\Usuario;
use Aluraplay\Mvc\Repository\Interface\InterfaceRepositorio;
use InvalidArgumentException;
use PDO;

class RepositorioUsuario
{

    public function __construct(private PDO $pdo) {}

    public function buscarPorEmail(Usuario $usuario): Usuario
    {

        $sql = "SELECT email, password FROM usuarios WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $usuario->email);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            throw new InvalidArgumentException();
        }

        return $this->hydrateUsuario($result);
    }

    private function hydrateUsuario(array $usuario): Usuario
    {

        return new Usuario($usuario['email'], $usuario['password']);
    }
}
