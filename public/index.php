<?php

declare(strict_types=1);

use Aluraplay\Mvc\Controller\Controller;
use Aluraplay\Mvc\Controller\LoginValidacaoController;;

use Aluraplay\Mvc\Repository\RespositorioVideos;
use Aluraplay\Mvc\Repository\RepositorioUsuario;

require_once __DIR__ . '/../vendor/autoload.php';
$routes = require_once __DIR__ . '/../config/routes.php';

$dbPath = __DIR__ . '/../bancosqlite.sqlite';
$pdo = new PDO("sqlite:$dbPath");
$repositorioVideo = new RespositorioVideos($pdo);
$repositorioUsuario = new RepositorioUsuario($pdo);

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$requestMethod = $_SERVER['REQUEST_METHOD'];

$key = "$requestMethod|$pathInfo";
$isLoginRoute = $pathInfo === '/login';

session_start();
if (!array_key_exists("logado", $_SESSION) && !$isLoginRoute) {
    header("Location: /login");
    return;
}

if (array_key_exists($key, $routes)) {
    $controllerClass = $routes["$requestMethod|$pathInfo"];

    if ($controllerClass === LoginValidacaoController::class) {
        $controller = new $controllerClass($repositorioUsuario);
    } else {
        $controller = new $controllerClass($repositorioVideo);
    }
} else {
    http_response_code(404);
    exit();
}
/** @var Controller */
$controller->processaRequisicao();
