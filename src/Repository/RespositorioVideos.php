<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Repository;

use Aluraplay\Mvc\Entity\Video;
use Aluraplay\Mvc\Repository\Interface\InterfaceRepositorio;
use PDO;

class RespositorioVideos implements InterfaceRepositorio
{

    public function __construct(private PDO $pdo) {}

    public function inserir(Video $video): bool
    {
        $stmt =  $this->pdo->prepare("INSERT INTO videos (url, title, path_documents) VALUES (?,?,?)");
        $stmt->bindValue(1, $video->url);
        $stmt->bindValue(2, $video->titulo);
        $stmt->bindValue(3, $video->getFilePath());
        $result = $stmt->execute();

        $video->setId(intval($this->pdo->lastInsertId()));
        return $result;
    }

    public function atualizar(Video $video): bool
    {
        $stmt =  $this->pdo->prepare("UPDATE videos SET
        url = :url, 
        title = :title,
        path_documents = :path_documents
        WHERE id = :id");
        $stmt->bindValue(':url', $video->url);
        $stmt->bindValue(':title', $video->titulo);
        $stmt->bindValue(':path_documents', $video->getFilePath());
        $stmt->bindValue(':id', $video->id, PDO::PARAM_INT);
        return $stmt->execute();
    }


    /**
     * Summary of buscarTodos
     * @return Video[]
     */
    public function buscarTodos(): array
    {
        $stmt =  $this->pdo->query('SELECT * FROM videos');
        $listaVideos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map($this->hydrateVideo(...), $listaVideos);
    }

    public function buscarPorId(int $id): ?Video
    {
        $stmt  = $this->pdo->prepare('SELECT * FROM videos WHERE id = :id');
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $videoDados = $stmt->fetch(PDO::FETCH_ASSOC);


        if (!$videoDados) {
            return null;
        }

        return $this->hydrateVideo($videoDados);
    }

    public function remover(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM videos WHERE id = ?");
        $stmt->bindValue(1, $id);
        return $stmt->execute();
    }

    public function removerCapa(int $id): bool
    {
        $stmt = $this->pdo->prepare("UPDATE videos SET path_documents = null WHERE id = ?");
        $stmt->bindValue(1, $id);
        return $stmt->execute();
    }


    private function hydrateVideo(array $videoData): Video
    {

        $video =  new Video($videoData['url'], $videoData['title']);
        $video->setId($videoData['id']);
        $video->setFilePath($videoData['path_documents']);

        return $video;
    }
}
