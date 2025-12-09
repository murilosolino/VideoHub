<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

use Aluraplay\Mvc\Entity\CheckUploadArquivo;
use Aluraplay\Mvc\Entity\Video;
use Aluraplay\Mvc\Repository\RespositorioVideos;
use Exception;

class NovoVideoControlador implements Controller
{

    public function __construct(
        private RespositorioVideos $respositorioVideos,
        private CheckUploadArquivo $checkUploadArquivo,
    ) {}

    public function processaRequisicao(): void
    {

        try {

            $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
            $titulo = filter_input(INPUT_POST, 'titulo');

            $video = new Video($url, $titulo);

            if (
                $url === false || $url === null || !preg_match('/^https?:\/\/[^\s]+$/', $url) ||
                empty(trim($titulo))
            ) {
                throw new Exception("Dados inválidos");
            }

            $uploadPathPublic = $this->checkUploadArquivo->moveUploadFile('image');

            if (!is_null($uploadPathPublic)) {
                $video->setFilePath($uploadPathPublic);
            }

            $result = $this->respositorioVideos->inserir($video);

            $result ? header('Location: /?success=1') : throw new Exception('Ocorreu um erro durante a inserção no banco de dados');
        } catch (\Throwable $th) {
            header('Location: /?success=0');
            exit();
        }
    }
}
