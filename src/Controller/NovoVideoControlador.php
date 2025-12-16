<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

use Aluraplay\Mvc\Entity\CheckUploadArquivo;
use Aluraplay\Mvc\Entity\Video;
use Aluraplay\Mvc\Helper\FlashMessageTrait;
use Aluraplay\Mvc\Repository\RespositorioVideos;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class NovoVideoControlador implements Controller
{
    use FlashMessageTrait;
    public function __construct(
        private RespositorioVideos $respositorioVideos,
        private CheckUploadArquivo $checkUploadArquivo,
    ) {}

    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {

        $parsedBody =  $request->getParsedBody();
        $url = filter_var($parsedBody['url'], FILTER_VALIDATE_URL);
        $titulo = filter_var($parsedBody['titulo'],);

        if (
            $url === false || $url === null || !preg_match('/^https?:\/\/[^\s]+$/', $url) ||
            empty(trim($titulo))
        ) {
            $this->addFlashErrorMessage('Dados para cadastro de vídeo inválidos');
            return new Response(302, ['Location' => '/novo-video']);
        }

        $video = new Video($url, $titulo);
        $uploadPathPublic = $this->checkUploadArquivo->moveUploadFile('image');

        if (!is_null($uploadPathPublic)) {
            $video->setFilePath($uploadPathPublic);
        }

        $result = $this->respositorioVideos->inserir($video);

        if (!$result) {
            $this->addFlashErrorMessage('Ocorreu um erro ao salvar o vídeo. Tente novamente mais tarde');
            return new Response(302, ['Location' => '/novo-video']);
        }
        return new Response(302, ['Location' => '/']);
    }
}
