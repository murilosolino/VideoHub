<?php

declare(strict_types=1);

namespace VideoHub\Mvc\Controller;

use VideoHub\Mvc\Helper\FlashMessageTrait;
use VideoHub\Mvc\Repository\RespositorioVideos;
use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use VideoHub\Mvc\Service\VideoService;

class FormularioEditaVideoControlador implements RequestHandlerInterface
{
    use FlashMessageTrait;
    public function __construct(
        private VideoService $videoService,
        private Engine $template,
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getQueryParams();
        $id = filter_var($params['id'] ?? '', FILTER_VALIDATE_INT);

        if ($id === false || $id === null) {
            $this->addFlashErrorMessage("Id de vídeo inválido, impossível de manipular o vídeo");
            return new Response(302, ['Location' => '/']);
        }

        $video = $this->videoService->capturaVideoPorId($id);

        return is_null($video) ?  new Response(302, ['Location' => '/']) : new Response(200, [], $this->template->render('formulario-html', ['video' => $video]));
    }
}
