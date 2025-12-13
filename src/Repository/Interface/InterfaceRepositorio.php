<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Repository\Interface;

use Aluraplay\Mvc\Entity\Video;

interface InterfaceRepositorio
{

    public function inserir(Video $video): bool;
    public function atualizar(Video $video): bool;

    public function buscarTodos(): array;

    public function remover(int $id): bool;

    public function buscarPorId(int $id): ?Video;
}
