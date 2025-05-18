<?php

declare(strict_types=1);


namespace Raketa\BackendTestTask\Infrastructure\Http\Middleware;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\Controller\DefaultController;

/**
 * Сервис обработки промежуточных слоёв.
 *
 * Подразумевается, что есть ядро, пройдена маршрутизация и через DI поставлены слои и нужный контроллер.
 */
class MiddlewareRunner
{
    /** @var Middleware[] */
    private array $middlewareStack;

    private DefaultController $controller;

    public function __construct(array $middlewareStack, DefaultController $controller)
    {
        $this->middlewareStack = $middlewareStack;
        $this->controller = $controller;
    }

    public function handle(RequestInterface $request): ResponseInterface
    {
        $middleware = array_reduce(
            array_reverse($this->middlewareStack),
            fn (callable $next, Middleware $middleware) => fn (RequestInterface $request) =>
            $middleware->process($request, $next),
            fn (RequestInterface $request) => ($this->controller)($request)
        );

        return $middleware($request);
    }
}