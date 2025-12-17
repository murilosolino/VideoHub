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

class FormularioNovoVideoController implements RequestHandlerInterface
{
    use FlashMessageTrait;
    public function __construct(
        private RespositorioVideos $respositorioVideos,
        private Engine $template,
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getQueryParams();
        $id = filter_var($params['id'] ?? '', FILTER_VALIDATE_INT);

        $video = null;

        if ($id !== false && $id !== null) {
            $video = $this->respositorioVideos->buscarPorId($id);
        }

        return new Response(200, [], $this->template->render('formulario-html', ['video' => $video]));
    }
}
