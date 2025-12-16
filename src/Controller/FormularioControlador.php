<?php

declare(strict_types=1);

namespace Aluraplay\Mvc\Controller;

use Aluraplay\Mvc\Helper\RenderHtmlTrait;
use Aluraplay\Mvc\Repository\RespositorioVideos;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class FormularioControlador implements Controller
{
    use RenderHtmlTrait;
    public function __construct(private RespositorioVideos $respositorioVideos) {}

    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getQueryParams();
        $id = filter_var($params['id'], FILTER_VALIDATE_INT);

        $video = null;

        if ($id !== false && $id !== null) {
            $video = $this->respositorioVideos->buscarPorId($id);
        }

        return new Response(200, [], $this->renderTemplate('formulario-html', ['video' => $video]));
    }
}
