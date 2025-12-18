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
        try {
            $auth = $request->getHeader('Authorization');

            if (empty($auth)) {
                return new Response(
                    401,
                    ['Content-type: application:json'],
                    json_encode(['error' => 'Token de autorizacao nao informado'])
                );
            }

            $token = $auth[0];
            $jwtToken = preg_replace('/^Bearer\s+/i', '', $token);
            $jwtKey = $_ENV['JWT_KEY'] ?? '';
            if (!$_ENV['JWT_KEY']) {
                return new Response(500, [], null);
            }

            JWT::decode($jwtToken, new Key($jwtKey, 'HS256'));

            $response = $handler->handle($request);

            return $response;
        } catch (\Throwable $th) {
            return new Response(
                401,
                ['Content-Type: application/json'],
                json_encode(['error' => 'Token de acesso invalido'])
            );
        }
    }
}
