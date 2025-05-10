<?php

declare(strict_types=1);


namespace Raketa\BackendTestTask\Infrastructure\Responder;


use Psr\Http\Message\ResponseInterface;

interface Responder
{
    public function response(array $data, int $statusCode): ResponseInterface;
}