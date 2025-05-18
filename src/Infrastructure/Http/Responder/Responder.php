<?php

declare(strict_types=1);


namespace Raketa\BackendTestTask\Infrastructure\Http\Responder;


use Psr\Http\Message\ResponseInterface;

interface Responder
{
    public function response(mixed $data, int $statusCode): ResponseInterface;
}