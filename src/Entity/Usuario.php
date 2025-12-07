<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Entity;

class Usuario
{

    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {}

    public function validaLogin(Usuario $usuarioBanco): bool
    {

        return password_verify($this->password, $usuarioBanco->password)
            && $this->email === $usuarioBanco->email
            ? true : false;
    }
}
