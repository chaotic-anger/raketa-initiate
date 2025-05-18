<?php

declare(strict_types=1);


namespace Raketa\BackendTestTask\Service;


use Raketa\BackendTestTask\Model\Catalog\Product;
use Raketa\BackendTestTask\Repository\ProductRepository;
use Raketa\BackendTestTask\View\DTO\ProductDto;
use Raketa\BackendTestTask\View\ProductAssembler;

readonly class CatalogService
{
    public function __construct(
        private ProductRepository $productRepository,
        private ProductAssembler $productAssembler,
    ) {
    }

    /**
     * @param string $categoryUuid
     * @return array<ProductDto>
     */
    public function getProductsByCategory(string $categoryUuid): array
    {
        $products = $this->productRepository->getListByCategory($categoryUuid);

        return array_map(
            fn (Product $product) => $this->productAssembler->toDto($product),
            $products
        );
    }
}