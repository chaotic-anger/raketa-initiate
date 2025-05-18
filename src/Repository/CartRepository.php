<?php

declare(strict_types=1);


namespace Raketa\BackendTestTask\Repository;

use Raketa\BackendTestTask\Model\Cart\Cart;

interface CartRepository
{
    public function get(string $id): ?Cart;
    public function save(string $id, Cart $cart): void;
}