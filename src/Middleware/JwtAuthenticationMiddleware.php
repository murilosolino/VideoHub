<?php

declare(strict_types=1);

namespace VideoHub\Mvc\Middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class JwtAuthenticationMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        $auth = $request->getHeader('Authorization');

        if (empty($auth)) {
            return new Response(
                400,
                ['Content-type: application:json'],
                json_encode(['error' => 'Token de autorizacao nao informado'])
            );
        }

        $token = $auth[0];
        $jwtToken = str_replace('Bearer ', '', $token);
        $jwtKey = $_ENV['JWT_KEY'];

        JWT::decode($jwtToken, new Key($jwtKey, 'HS256'));

        $response = $handler->handle($request);

        return $response;
    }
}
