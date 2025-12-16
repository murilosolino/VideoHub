<?php

declare(strict_types=1);

namespace VideoHub\Mvc\Controller;

use VideoHub\Mvc\Entity\CheckUploadArquivo;
use VideoHub\Mvc\Entity\Video;
use VideoHub\Mvc\Helper\FlashMessageTrait;
use VideoHub\Mvc\Repository\RespositorioVideos;
use Exception;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EditaVideoControlador implements RequestHandlerInterface
{
    use FlashMessageTrait;
    public function __construct(
        private RespositorioVideos $respositorioVideos,
        private CheckUploadArquivo $checkUploadArquivo,
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parsedBody = $request->getParsedBody();
        $params = $request->getQueryParams();

        $url = filter_var($parsedBody['url'], FILTER_VALIDATE_URL);
        $titulo = filter_var($parsedBody['titulo']);
        $id = filter_var($params['id'], FILTER_VALIDATE_INT);

        if (
            $url === false || $url === null || !preg_match('/^https?:\/\/[^\s]+$/', $url) ||
            empty(trim($titulo)) ||
            $id === false || $id === null
        ) {
            $this->addFlashErrorMessage('Dados para edição do vídeo inválidos');
            return new Response(302, ['Location' => '/editar-video?id=' . (is_int($id) ? $id : '')]);
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
            return new Response(302, ['Location' => '/']);
        }
        if (!is_null($videoSalvo->getFilePath()) && $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
            $video->setFilePath($videoSalvo->getFilePath());
        }

        $result = $this->respositorioVideos->atualizar($video);

        if (!$result) {
            $this->addFlashErrorMessage('Ocorreu um erro ao salvar as edições do vídeo. Tente novamente mais tarde');
        }
        return new Response(302, ['Location' => '/']);
    }
}
