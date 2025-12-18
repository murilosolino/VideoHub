<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use League\Plates\Engine;
use VideoHub\Mvc\Middleware\JwtAuthenticationMiddleware;

$builder = new ContainerBuilder();
$builder->addDefinitions(
    [
        PDO::class => function (): PDO {
            $dbPath = __DIR__ . '/../bancosqlite.sqlite';
            return new PDO("sqlite:$dbPath");
        },
        Engine::class => function (): Engine {
            return new Engine(__DIR__ . '/../views');
        }
    ]
);

$container = $builder->build();
$container->set(JwtAuthenticationMiddleware::class, function (): JwtAuthenticationMiddleware {
    return new JwtAuthenticationMiddleware();
});
return $container;
