<?php

declare(strict_types=1);


namespace Raketa\BackendTestTask\Infrastructure\Redis;


final readonly class Connection
{
    public function __construct(
        public string $host,
        public int $port = 6379,
        public ?string $password = null,
    ) {
    }
}