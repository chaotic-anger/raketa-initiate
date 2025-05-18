<?php

declare(strict_types=1);


namespace Raketa\BackendTestTask\View;


use Raketa\BackendTestTask\Model\Cart\Cart;
use Raketa\BackendTestTask\Model\Cart\Item;
use Raketa\BackendTestTask\Model\Catalog\Product;
use Raketa\BackendTestTask\View\DTO\CartDto;
use Raketa\BackendTestTask\View\DTO\CartItemDto;
use Raketa\BackendTestTask\View\DTO\CustomerDto;
use Raketa\BackendTestTask\View\DTO\ProductDto;
use RuntimeException;

final readonly class CartAssembler
{
    public function __construct(
        private ProductAssembler $productAssembler
    )
    {
    }

    /**
     * @param Cart $cart
     * @param array<Product> $products
     * @return CartDto
     */
    public function toDto(Cart $cart, array $products): CartDto
    {
        $dto = new CartDto();

        $dto->uuid = $cart->getUuid();
        $dto->paymentMethod = $cart->getPaymentMethod()->value;
        $dto->customer = $this->buildCustomerDto($cart);

        $productUuidMap = $this->makeProductUuidMap($products);
        $dto->items = $this->buildItemsFromSource($cart, $productUuidMap);

        return $dto;
    }

    protected function buildCustomerDto(Cart $cart): CustomerDto
    {
        $customerDto = new CustomerDto();
        $customerDto->id = $cart->getCustomer()->getId();
        $customerDto->name = $cart->getCustomer()->getFullName();
        $customerDto->email = $cart->getCustomer()->getEmail();

        return $customerDto;
    }

    private function makeProductUuidMap(array $products): array
    {
        $productMap = [];
        foreach ($products as $product) {
            $productMap[$product->getUuid()] = $product;
        }

        return $productMap;
    }

    /**
     * @param array<string, Product> $productUuidMap
     * @param Cart $cart
     * @return array<CartItemDto>
     */
    protected function buildItemsFromSource(Cart $cart, array $productUuidMap): array
    {
        return array_map(function ($item) use ($productUuidMap) {
            $product = $productUuidMap[$item->getProductUuid()];

            return $this->buildCardItemDto($item, $product);
        }, $cart->getItems());
    }

    function buildCardItemDto(Item $item, Product $product): CartItemDto
    {
        $itemDto = new CartItemDto();
        $itemDto->uuid = $item->getUuid();
        $itemDto->price = $item->getPrice();
        $itemDto->quantity = $item->getQuantity();
        $itemDto->total = $item->getTotal();
        $itemDto->product = $this->productAssembler->toDto($product);

        return $itemDto;
    }
}