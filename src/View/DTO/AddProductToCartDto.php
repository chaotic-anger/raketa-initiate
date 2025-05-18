<?php

declare(strict_types=1);


namespace Raketa\BackendTestTask\View\DTO;


class AddProductToCartDto
{
    public string $status;
    public CartDto $cart;

    public static function create(CartDto $cart): self
    {
        $dto = new self();
        $dto->status = 'success';
        $dto->cart = $cart;

        return $dto;
    }
}