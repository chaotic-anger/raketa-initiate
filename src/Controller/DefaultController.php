<?php

declare(strict_types=1);


namespace Raketa\BackendTestTask\Controller;


use Raketa\BackendTestTask\Infrastructure\Responder\Responder;

/**
 * Контроллер по-умолчанию
 */
abstract readonly class DefaultController
{
    public function __construct(Responder $responder)
    {
    }
}