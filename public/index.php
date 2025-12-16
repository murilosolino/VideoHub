<?php

declare(strict_types=1);

use Aluraplay\Mvc\Controller\Controller;
use Aluraplay\Mvc\Controller\EditaVideoControlador;
use Aluraplay\Mvc\Controller\LoginValidacaoController;
use Aluraplay\Mvc\Controller\NovoVideoControlador;;

use Aluraplay\Mvc\Repository\RespositorioVideos;
use Aluraplay\Mvc\Repository\RepositorioUsuario;
use Aluraplay\Mvc\Entity\CheckUploadArquivo;

require_once __DIR__ . '/../vendor/autoload.php';
$routes = require_once __DIR__ . '/../config/routes.php';

$dbPath = __DIR__ . '/../bancosqlite.sqlite';
$pdo = new PDO("sqlite:$dbPath");
$repositorioVideo = new RespositorioVideos($pdo);
$repositorioUsuario = new RepositorioUsuario($pdo);
$checkUploadArquivo = new CheckUploadArquivo();

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$requestMethod = $_SERVER['REQUEST_METHOD'];

$key = "$requestMethod|$pathInfo";
$isLoginRoute = $pathInfo === '/login';
session_set_cookie_params([
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strinct'
]);
session_start();
if (isset($_SESSION['logado'])) {
    $originalInfo = $_SESSION['logado'];
    unset($_SESSION['logado']);
    session_regenerate_id();
    $_SESSION['logado'] = $originalInfo;
}

if (!array_key_exists("logado", $_SESSION) && !$isLoginRoute) {
    header("Location: /login");
    return;
}

if (array_key_exists($key, $routes)) {
    $controllerClass = $routes["$requestMethod|$pathInfo"];

    if ($controllerClass === LoginValidacaoController::class) {
        $controller = new $controllerClass($repositorioUsuario);
    } else if ($controllerClass === EditaVideoControlador::class || $controllerClass === NovoVideoControlador::class) {
        $controller = new $controllerClass($repositorioVideo, $checkUploadArquivo);
    } else {
        $controller = new $controllerClass($repositorioVideo);
    }
} else {
    http_response_code(404);
    exit();
}

$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

$creator = new \Nyholm\Psr7Server\ServerRequestCreator(
    $psr17Factory,
    $psr17Factory,
    $psr17Factory,
    $psr17Factory
);

$serverRequest = $creator->fromGlobals();

$response = $controller->processaRequisicao($serverRequest);

http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

echo $response->getBody();
