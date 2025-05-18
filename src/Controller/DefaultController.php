<?php

declare(strict_types=1);


namespace Raketa\BackendTestTask\Controller;


use Exception;
use Raketa\BackendTestTask\Infrastructure\Http\Responder\Responder;
use Raketa\BackendTestTask\Infrastructure\Http\Session\Session;

/**
 * Основа контроллеров
 *
 * Подразумевается поставка зависимостей через DI.
 */
abstract class DefaultController
{
    protected ?Responder $responder = null;
    protected ?Session $session = null;

    /**
     * @throws Exception
     */
    public function setResponder(Responder $responder): void
    {
        if ($this->responder !== null) {
            throw new Exception('Responder is already set');
        }

        $this->responder = $responder;
    }

    /**
     * @throws Exception
     */
    public function setSession(Session $session): void
    {
        if ($this->session !== null) {
            throw new Exception('Session is already set');
        }

        $this->session = $session;
    }
}