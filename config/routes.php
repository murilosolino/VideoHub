<?php

declare(strict_types=1);

use VideoHub\Mvc\Controller\Api\Auth\AutenticacaoApiController;
use VideoHub\Mvc\Controller\Api\NovoVideoJsonController;
use VideoHub\Mvc\Controller\EditaVideoControlador;
use VideoHub\Mvc\Controller\ListaVideosControlador;
use VideoHub\Mvc\Controller\LoginFormController;
use VideoHub\Mvc\Controller\LoginValidacaoController;
use VideoHub\Mvc\Controller\LogoutController;
use VideoHub\Mvc\Controller\NovoVideoControlador;
use VideoHub\Mvc\Controller\RemoveCapaController;
use VideoHub\Mvc\Controller\RemoveVideoControlador;
use VideoHub\Mvc\Controller\Api\VideosJsonController;
use VideoHub\Mvc\Controller\CriarContaController;
use VideoHub\Mvc\Controller\FormularioCriarContaController;
use VideoHub\Mvc\Controller\FormularioEditaVideoControlador;
use VideoHub\Mvc\Controller\FormularioNovoVideoController;

return [
    //rotas publicas
    'POST|/auth' => AutenticacaoApiController::class,
    'GET|/criar-conta' => FormularioCriarContaController::class,
    'POST|/criar-conta' => CriarContaController::class,
    'GET|/login' => LoginFormController::class,
    'POST|/login' => LoginValidacaoController::class,

    //rotas protegidas por login web
    'GET|/' => ListaVideosControlador::class,
    'GET|/novo-video' => FormularioNovoVideoController::class,
    'POST|/novo-video' => NovoVideoControlador::class,
    'GET|/editar-video' => FormularioEditaVideoControlador::class,
    'POST|/editar-video' => EditaVideoControlador::class,
    'GET|/remover-video' => RemoveVideoControlador::class,
    'GET|/logout' => LogoutController::class,
    'GET|/remover-capa' => RemoveCapaController::class,

    //rotas de api protejidas com JWT
    'GET|/api/videos-json' => VideosJsonController::class,
    'POST|/api/novo-video' => NovoVideoJsonController::class,



];
