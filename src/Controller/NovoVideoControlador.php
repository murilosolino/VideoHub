<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

use Aluraplay\Mvc\Entity\Video;
use Aluraplay\Mvc\Repository\RespositorioVideos;

class NovoVideoControlador implements Controller
{

    public function __construct(private RespositorioVideos $respositorioVideos) {}

    public function processaRequisicao(): void
    {

        try {

            $video = new Video($_POST['url'], $_POST['titulo']);

            if (array_key_exists("image", $_FILES) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
                $fileName = basename($_FILES['image']['name']);
                $uploadPath = __DIR__ . "/../../public/img/uploads/" . $fileName;
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath);
                $video->setFilePath($uploadPath);
            }

            $result = $this->respositorioVideos->inserir($video);

            $result ? header('Location: /?success=1') : throw new \Exception('Ocorreu um erro durante a inserção no banco de dados');
        } catch (\Throwable $th) {
            header('Location: /?success=0');
            exit();
        }
    }
}
