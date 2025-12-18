<?php

declare(strict_types=1);

namespace VideoHub\Mvc\Service;

use League\Plates\Engine;
use VideoHub\Mvc\Entity\CheckUploadArquivo;
use VideoHub\Mvc\Entity\Video;
use VideoHub\Mvc\Helper\FlashMessageTrait;
use VideoHub\Mvc\Repository\RespositorioVideos;

class VideoService
{
    use FlashMessageTrait;
    public function __construct(
        private RespositorioVideos $respositorioVideos,
        private CheckUploadArquivo $checkUploadArquivo,
    ) {}

    public function listarVideos(): array
    {
        return $this->respositorioVideos->buscarTodos();
    }
    public function editarVideo(
        string $url,
        string $titulo,
        int $id
    ): void {

        $video = new Video($url, $titulo);
        $video->setId(intval($id));

        $uploadPathPublic = $this->checkUploadArquivo->moveUploadFile('image');

        if (!is_null($uploadPathPublic)) {
            $video->setFilePath($uploadPathPublic);
        }

        $videoSalvo = $this->respositorioVideos->buscarPorId($id);

        if (is_null($videoSalvo)) {
            $this->addFlashErrorMessage('Vídeo não encontrado para edição');
            return;
        }
        if (!is_null($videoSalvo->getFilePath()) && $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
            $video->setFilePath($videoSalvo->getFilePath());
        }

        $result = $this->respositorioVideos->atualizar($video);

        if (!$result) {
            $this->addFlashErrorMessage('Ocorreu um erro ao salvar as edições do vídeo. Tente novamente mais tarde');
        }
    }

    public function novoVideo(
        string $url,
        string $titulo
    ): bool {
        $video = new Video($url, $titulo);
        $uploadPathPublic = $this->checkUploadArquivo->moveUploadFile('image');

        if (!is_null($uploadPathPublic)) {
            $video->setFilePath($uploadPathPublic);
        }

        $result = $this->respositorioVideos->inserir($video);

        if (!$result) {
            $this->addFlashErrorMessage('Ocorreu um erro ao salvar o vídeo. Tente novamente mais tarde');
            return false;
        }

        return true;
    }

    public function removerCapaVideo(int $id): void
    {

        $result = $this->respositorioVideos->removerCapa($id);

        if (!$result) {
            $this->addFlashErrorMessage('Ocorreu um erro ao remover a capa do vídeo. Tente novamente mais tarde');
        }
    }

    public function excluirVideo(int $id): void
    {

        $videosDoUsuario = $this->respositorioVideos->buscarIdVideoDoUsuario();

        if (!in_array($id, $videosDoUsuario)) {
            $this->addFlashErrorMessage("Id de vídeo inválido, impossível de excluir o vídeo");
            return;
        }

        $video = $this->respositorioVideos->buscarPorId($id);

        if (is_null($video)) {
            $this->addFlashErrorMessage("Id de vídeo inválido, impossível de excluir");
            return;
        }

        $result = $this->respositorioVideos->remover($video->id);

        if (!$result) {
            $this->addFlashErrorMessage("Ocorreu um erro durante a exclusão do registro no banco de dados");
        }
    }

    public function capturaVideoPorId(int $id): ?Video
    {

        $videosDoUsuario = $this->respositorioVideos->buscarIdVideoDoUsuario();

        if (!in_array($id, $videosDoUsuario)) {
            $this->addFlashErrorMessage("Id de vídeo inválido, impossível de manipular o vídeo");
            return null;
        }

        return $this->respositorioVideos->buscarPorId($id);
    }
}
