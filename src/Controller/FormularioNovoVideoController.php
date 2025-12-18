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
use VideoHub\Mvc\Entity\Video;
use VideoHub\Mvc\Service\VideoService;

class FormularioNovoVideoController implements RequestHandlerInterface
{
    use FlashMessageTrait;
    public function __construct(
        private Engine $template
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new Response(200, [], $this->template->render('formulario-html', ['video' => null]));
    }
}
