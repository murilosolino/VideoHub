<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

use Aluraplay\Mvc\Entity\CheckUploadArquivo;
use Aluraplay\Mvc\Entity\Video;
use Aluraplay\Mvc\Helper\FlashMessageTrait;
use Aluraplay\Mvc\Repository\RespositorioVideos;

class NovoVideoControlador implements Controller
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

        if (
            $url === false || $url === null || !preg_match('/^https?:\/\/[^\s]+$/', $url) ||
            empty(trim($titulo))
        ) {
            $this->addFlashErrorMessage('Dados para cadastro de vídeo inválidos');
            header('Location: /novo-video');
            return;
        }

        $video = new Video($url, $titulo);
        $uploadPathPublic = $this->checkUploadArquivo->moveUploadFile('image');

        if (!is_null($uploadPathPublic)) {
            $video->setFilePath($uploadPathPublic);
        }

        $result = $this->respositorioVideos->inserir($video);

        if (!$result) {
            $this->addFlashErrorMessage('Ocorreu um erro ao salvar o vídeo. Tente novamente mais tarde');
            header('Location: /novo-video');
            return;
        }
        header('Location: /');
    }
}
