<?php

declare(strict_types=1);


namespace Raketa\BackendTestTask\Infrastructure\Http\Session;

/**
 * Примитивнейшая реализация
 */
class SessionManager implements Session
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function getId(): string
    {
        return session_id();
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function clear(): void
    {
        $_SESSION = [];
    }
}