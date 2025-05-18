<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Infrastructure\Redis;

use Redis;

class Connector
{
    private Redis $redis;

    public function __construct($redis)
    {
        return $this->redis = $redis;
    }

    public function get($key)
    {
        return unserialize($this->redis->get($key));
    }

    public function set(string $key, mixed $value, ?int $expire = null)
    {
        $this->redis->setex($key, $expire, $value);
    }

    public function has($key): bool
    {
        return $this->redis->exists($key);
    }
}
