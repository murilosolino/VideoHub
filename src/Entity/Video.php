<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Entity;

class Video
{

    public readonly string $url;
    public readonly int $id;
    private ?string $filePath;

    public function __construct(
        string $url,
        public readonly string $titulo,
    ) {
        $this->setUrl($url);
        $this->setFilePath(null);
    }

    public function setId(int $id): void
    {

        $id = filter_var($id, FILTER_VALIDATE_INT);

        if ($id === false || $id === null || $id < 1) {
            throw new \InvalidArgumentException('Id inválido: ' . $id);
        }

        $this->id = $id;
    }

    private function setUrl(string $url): void
    {

        $url = filter_var($url, FILTER_VALIDATE_URL);

        if ($url === false || $url === null) {
            throw new \InvalidArgumentException('URL inválida');
        }

        $this->url = $url;
    }

    public function setFilePath(?string $filePath): void
    {
        $this->filePath = $filePath;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }
}
