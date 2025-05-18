<?php

declare(strict_types=1);


namespace Raketa\BackendTestTask\Repository;


use Raketa\BackendTestTask\Model\Catalog\Product;

interface ProductRepository
{
    public function getByUuid(string $uuid): ?Product;

    /**
     * @param string $categoryUuid
     * @return array<Product>
     */
    public function getListByCategory(string $categoryUuid): array;

    /**
     * @param array<string> $uuids
     * @return Product
     */
    public function getListByUuids(array $uuids): array;
}