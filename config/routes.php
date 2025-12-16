<?php

declare(strict_types=1);

use VideoHub\Mvc\Controller\Api\NovoVideoJsonController;
use VideoHub\Mvc\Controller\EditaVideoControlador;
use VideoHub\Mvc\Controller\FormularioControlador;
use VideoHub\Mvc\Controller\ListaVideosControlador;
use VideoHub\Mvc\Controller\LoginFormController;
use VideoHub\Mvc\Controller\LoginValidacaoController;
use VideoHub\Mvc\Controller\LogoutController;
use VideoHub\Mvc\Controller\NovoVideoControlador;
use VideoHub\Mvc\Controller\RemoveCapaController;
use VideoHub\Mvc\Controller\RemoveVideoControlador;
use VideoHub\Mvc\Controller\Api\VideosJsonController;

return [
    'GET|/' => ListaVideosControlador::class,
    'GET|/novo-video' => FormularioControlador::class,
    'POST|/novo-video' => NovoVideoControlador::class,
    'GET|/editar-video' => FormularioControlador::class,
    'POST|/editar-video' => EditaVideoControlador::class,
    'GET|/remover-video' => RemoveVideoControlador::class,
    'GET|/login' => LoginFormController::class,
    'POST|/login' => LoginValidacaoController::class,
    'GET|/logout' => LogoutController::class,
    'GET|/remover-capa' => RemoveCapaController::class,
    'GET|/videos-json' => VideosJsonController::class,
    'POST|/videos-json' => NovoVideoJsonController::class
];
