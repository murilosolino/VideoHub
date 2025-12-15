<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

use Aluraplay\Mvc\Entity\CheckUploadArquivo;
use Aluraplay\Mvc\Entity\Video;
use Aluraplay\Mvc\Helper\FlashMessageTrait;
use Aluraplay\Mvc\Repository\RespositorioVideos;
use Exception;

class EditaVideoControlador implements Controller
{
    use FlashMessageTrait;
    public function __construct(
        private RespositorioVideos $respositorioVideos,
        private CheckUploadArquivo $checkUploadArquivo,
    ) {}

    public function processaRequisicao(): void
    {

        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        $titulo = filter_input(INPUT_POST, 'titulo');
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (
            $url === false || $url === null || !preg_match('/^https?:\/\/[^\s]+$/', $url) ||
            empty(trim($titulo)) ||
            $id === false || $id === null
        ) {
            $this->addFlashErrorMessage('Dados para edição do vídeo inválidos');
            header('Location: /editar-video?id=' . (is_int($id) ? $id : ''));
            return;
        }

        $video = new Video($url, $titulo);
        $video->setId(intval($id));

        $uploadPathPublic = $this->checkUploadArquivo->moveUploadFile('image');

        if (!is_null($uploadPathPublic)) {
            $video->setFilePath($uploadPathPublic);
        }

        $videoSalvo = $this->respositorioVideos->buscarPorId($id);

        if (is_null($videoSalvo)) {
            $this->addFlashErrorMessage('Vídeo não encontrado para edição');
            header('Location: /editar-video?id=' . $id);
            return;
        }
        if (!is_null($videoSalvo->getFilePath()) && $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
            $video->setFilePath($videoSalvo->getFilePath());
        }

        $result = $this->respositorioVideos->atualizar($video);

        if (!$result) {
            $this->addFlashErrorMessage('Ocorreu um erro ao salvar as edições do vídeo. Tente novamente mais tarde');
        }
        header('Location: /');
    }
}
