<?php

declare(strict_types=1);


namespace Raketa\BackendTestTask\View;


use Raketa\BackendTestTask\Model\Catalog\Product;
use Raketa\BackendTestTask\View\DTO\ProductDto;

final readonly class ProductAssembler
{
    public function toDto(Product $product): ProductDto
    {
        $dto = new ProductDto();

        $dto->id = $product->getId();
        $dto->uuid = $product->getUuid();
        $dto->name = $product->getName();
        $dto->thumbnail = $product->getThumbnail();
        $dto->price = $product->getPrice();
        $dto->description = $product->getDescription();
        $dto->category = $product->getCategory();

        return $dto;
    }
}