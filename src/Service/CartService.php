<?php

declare(strict_types=1);


namespace Raketa\BackendTestTask\Service;


use Exception;
use Raketa\BackendTestTask\Model\Cart\Cart;
use Raketa\BackendTestTask\Model\Cart\Item;
use Raketa\BackendTestTask\Model\Catalog\Product;
use Raketa\BackendTestTask\Repository\CartRepository;
use Raketa\BackendTestTask\Repository\ProductRepository;
use Raketa\BackendTestTask\View\CartAssembler;
use Raketa\BackendTestTask\View\DTO\CartDto;
use Ramsey\Uuid\Uuid;

readonly class CartService
{
    public function __construct(
        private CartRepository $cartRepository,
        private ProductRepository $productRepository,
        private CartAssembler $cartAssembler,
    ) {
    }

    /**
     * @throws Exception
     */
    public function getCart(string $cartId): ?CartDto
    {
        $cart = $this->cartRepository->get($cartId);
        if (!$cart) {
            return null;
        }

        $cartProductsUuids = array_map(static fn($item) => $item->getProductUuid(), $cart->getItems());
        $products = $this->productRepository->getListByUuids($cartProductsUuids);
        $this->ensureAllProductsFoundForCart($cartProductsUuids, $products, $cart);

        return $this->cartAssembler->toDto($cart, $products);
    }

    /**
     * @throws Exception
     */
    public function addProductToCart(string $cartId, string $productUuid): CartDto //type hint без null намеренно
    {
        $product = $this->productRepository->getByUuid($productUuid);
        if (!$product) {
            $message = sprintf('Product %s not found to add to cart', $productUuid);
            throw new \Exception($message);
        }

        $cart = $this->cartRepository->get($cartId);
        if (!$cart) {
            $message = sprintf('Cart %s not found to add product', $cart->getUuid());
            throw new \Exception($message);
        }

        $cart->addProduct($product->getUuid(), $product->getPrice());
        $this->cartRepository->save($cartId, $cart);

        return $this->getCart($cartId);
    }

    /**
     * @param string[] $expectedUuids
     * @param array<Product> $products
     * @throws Exception
     */
    private function ensureAllProductsFoundForCart(array $expectedUuids, array $products, Cart $cart): void
    {
        $actualUuids = array_map(
            static fn($product) => $product->getUuid(),
            $products
        );

        $missing = array_diff($expectedUuids, $actualUuids);

        if (!empty($missing)) {
            $message = sprintf('Missing products in cart %s: [%s]', $cart->getUuid(), implode(', ', $missing));
            throw new Exception($message);
        }
    }
}