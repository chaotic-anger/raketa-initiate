<?php

declare(strict_types=1);


namespace Raketa\BackendTestTask\Infrastructure\Http\Middleware\Concrete;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Raketa\BackendTestTask\Infrastructure\Http\Middleware\Middleware;
use Raketa\BackendTestTask\Infrastructure\Http\Responder\Responder;

final readonly class ErrorMiddleware implements Middleware
{
    public function __construct(
        private Responder $responder,
        private LoggerInterface $logger,
    ) {
    }

    public function process(RequestInterface $request, callable $next): ResponseInterface
    {
        try {
            return $next($request);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
            return $this->responder->response(['error' => $e->getMessage()], 500);
        }
    }
}