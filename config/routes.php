<?php

declare(strict_types=1);

use Aluraplay\Mvc\Controller\EditaVideoControlador;
use Aluraplay\Mvc\Controller\FormularioControlador;
use Aluraplay\Mvc\Controller\ListaVideosControlador;
use Aluraplay\Mvc\Controller\LoginFormController;
use Aluraplay\Mvc\Controller\LoginValidacaoController;
use Aluraplay\Mvc\Controller\LogoutController;
use Aluraplay\Mvc\Controller\NovoVideoControlador;
use Aluraplay\Mvc\Controller\RemoveCapaController;
use Aluraplay\Mvc\Controller\RemoveVideoControlador;

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
    'GET|/remover-capa' => RemoveCapaController::class
];
