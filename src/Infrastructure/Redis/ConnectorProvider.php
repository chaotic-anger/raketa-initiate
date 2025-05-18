<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Infrastructure\Redis;

use Exception;
use Redis;
use RedisException;
use Throwable;

class ConnectorProvider
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    /**
     * @throws Exception
     */
    public function get(int $dbIndex): Connector
    {
        try {
            $redis = new Redis();
            $this->checkAccess($redis);

            return $this->initializeConnector($redis, $dbIndex);
        } catch (Throwable $e) {
            throw new Exception('Redis connection failed', $e->getCode(), $e);
        }
    }

    private function checkAccess(Redis $redis): bool
    {
        $isConnected = $redis->isConnected();
        if (!$isConnected && $redis->ping('Pong')) {
            $isConnected = $redis->connect(
                $this->connection->host,
                $this->connection->port,
            );
        }

        return $isConnected;
    }

    private function initializeConnector(Redis $redis, int $dbIndex): Connector
    {
        $redis->auth($this->connection->password);
        $redis->select($dbIndex);

        return new Connector($redis);
    }
}
