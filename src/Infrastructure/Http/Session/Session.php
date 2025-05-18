<?php

declare(strict_types=1);


namespace Raketa\BackendTestTask\Infrastructure\Http\Session;

/**
 * Контракт сессии
 */
interface Session
{
    public function getId(): string;
    public function set(string $key, mixed $value): void;
    public function get(string $key, mixed $default = null): mixed;
    public function remove(string $key): void;
    public function clear(): void;
}