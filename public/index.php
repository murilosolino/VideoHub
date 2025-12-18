<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use VideoHub\Mvc\Middleware\JwtAuthenticationMiddleware;

require_once __DIR__ . '/../vendor/autoload.php';
$routes = require_once __DIR__ . '/../config/routes.php';
$container = require_once __DIR__ . '/../config/dependencies.php';

$env = Dotenv::createImmutable(__DIR__ . '/..');
$env->load();

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$requestMethod = $_SERVER['REQUEST_METHOD'];
$key = "$requestMethod|$pathInfo";
$publicRoutes = ['/login', '/criar-conta', '/auth'];
$isPublicRoute = in_array($pathInfo, $publicRoutes);
$isApiRoute = strpos($pathInfo, '/api');

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

if (!array_key_exists("logado", $_SESSION) && !$isPublicRoute) {
    header("Location: /login");
    return;
}

if (array_key_exists($key, $routes)) {
    $controllerClass = $routes["$requestMethod|$pathInfo"];
    $controller = $container->get($controllerClass);
    $middleware = $container->get(JwtAuthenticationMiddleware::class);
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

if (!$isPublicRoute && $isApiRoute === 0) {
    $response = $middleware->process($serverRequest, $controller);
} else {
    $response = $controller->handle($serverRequest);
}


http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

echo $response->getBody();
