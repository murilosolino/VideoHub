<?php

declare(strict_types=1);

namespace VideoHub\Mvc\Entity;

class Usuario
{
    public readonly int $id;

    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {}

    public function validaLogin(Usuario $usuarioBanco): bool
    {

        return password_verify($this->password, $usuarioBanco->password)
            && $this->email === $usuarioBanco->email
            ? true : false;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
