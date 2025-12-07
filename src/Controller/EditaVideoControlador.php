<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

use Aluraplay\Mvc\Entity\Video;
use Aluraplay\Mvc\Repository\RespositorioVideos;
use Exception;

class EditaVideoControlador implements Controller
{

    public function __construct(private RespositorioVideos $respositorioVideos) {}

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

            if (array_key_exists("image", $_FILES) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
                $uploadPath = __DIR__ . "/../../public/img/uploads";
                move_uploaded_file($_FILES['tmp_name'], $uploadPath);
                $video->setFilePath($uploadPath);
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
