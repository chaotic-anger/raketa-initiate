<?php

declare(strict_types=1);


namespace Raketa\BackendTestTask\Infrastructure\Http\Middleware;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface Middleware
{
    public function process(RequestInterface $request, callable $next): ResponseInterface;
}