<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\View\DTO;

use JsonSerializable;

class CartItemDto implements JsonSerializable
{
    public string $uuid;
    public float $price;
    public float $total;
    public int $quantity;
    public ProductDto $product;

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->uuid,
            'price' => $this->price,
            'total' => $this->total,
            'quantity' => $this->quantity,
            'product' => [ // соблюдение старого вывода API
                'id' => $this->product->id,
                'uuid' => $this->product->uuid,
                'name' => $this->product->name,
                'thumbnail' => $this->product->thumbnail,
                'price' => $this->product->price,
            ],
        ];
    }
}