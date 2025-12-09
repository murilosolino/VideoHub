<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

use Aluraplay\Mvc\Entity\CheckUploadArquivo;
use Aluraplay\Mvc\Entity\Video;
use Aluraplay\Mvc\Repository\RespositorioVideos;
use Exception;

class EditaVideoControlador implements Controller
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
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

            if (
                $url === false || $url === null || !preg_match('/^https?:\/\/[^\s]+$/', $url) ||
                empty(trim($titulo)) ||
                $id === false || $id === null
            ) {
                throw new Exception("Dados inválidos");
            }

            $video = new Video($url, $titulo);
            $video->setId(intval($id));

            $uploadPathPublic = $this->checkUploadArquivo->moveUploadFile('image');

            if (!is_null($uploadPathPublic)) {
                $video->setFilePath($uploadPathPublic);
            }

            $videoSalvo = $this->respositorioVideos->buscarPorId($id);

            if (!is_null($videoSalvo->getFilePath()) && $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
                $video->setFilePath($videoSalvo->getFilePath());
            }

            $result = $this->respositorioVideos->atualizar($video);

            $result ? header('Location: /?success=1') : throw new Exception(
                'Ocorreu um erro durante a atualização do registro no banco de dados'
            );
        } catch (\Throwable $th) {
            header('Location: /?success=0');
            exit();
        }
    }
}
