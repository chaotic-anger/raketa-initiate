<?php

declare(strict_types=1);


namespace Raketa\BackendTestTask\Infrastructure\Redis\Repository;


use Raketa\BackendTestTask\Infrastructure\Redis\Assembler\CartAssembler;
use Raketa\BackendTestTask\Infrastructure\Redis\Connector;
use Raketa\BackendTestTask\Infrastructure\Redis\ConnectorProvider;
use Raketa\BackendTestTask\Model\Cart\Cart;
use Raketa\BackendTestTask\Repository\CartRepository;

final class RedisCartRepository implements CartRepository
{
    private const DATABASE_ID = 1;
    private const EXPIRE_TIME = 24 * 60 * 60;
    private Connector $storage;

    public function __construct(private readonly CartAssembler $assembler, ConnectorProvider $redisProvider)
    {
        $this->storage = $redisProvider->get(self::DATABASE_ID);
    }

    public function get(string $id): ?Cart
    {
        if (!$this->storage->has($id)) {
            return null; // тут мы гарантировано обеспечить создание сущности не можем
        }
        $raw = (array)$this->storage->get($id); // тут крайне условно вытаскиваем сырые данные

        return $this->assembler->assemble($raw); // из сырья собираем сущность
    }

    public function save(string $id, Cart $cart): void
    {
        $this->storage->set($id, $this->assembler->disassemble($cart), self::EXPIRE_TIME);
    }
}