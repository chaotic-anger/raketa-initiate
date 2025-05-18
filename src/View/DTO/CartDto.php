<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\View\DTO;

use JsonSerializable;

class CartDto implements JsonSerializable
{
    public string $uuid;
    public CustomerDto $customer;
    public string $paymentMethod;
    /**
     * @var array<CartItemDto>
     */
    public array $items;


    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->uuid,
            'customer' => $this->customer,
            'payment_method' => $this->paymentMethod, // соблюдение старого вывода API
            'items' => $this->items,
        ];
    }
}