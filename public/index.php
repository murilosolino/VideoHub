<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
$routes = require_once __DIR__ . '/../config/routes.php';
$container = require_once __DIR__ . '/../config/dependencies.php';

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$requestMethod = $_SERVER['REQUEST_METHOD'];
$key = "$requestMethod|$pathInfo";
$isLoginRoute = $pathInfo === '/login';
$createAccountRout = $pathInfo === '/criar-conta';

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

if (!array_key_exists("logado", $_SESSION) && !$isLoginRoute && !$createAccountRout) {
    header("Location: /login");
    return;
}

if (array_key_exists($key, $routes)) {
    $controllerClass = $routes["$requestMethod|$pathInfo"];
    $controller = $container->get($controllerClass);
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

$response = $controller->handle($serverRequest);

http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

echo $response->getBody();
