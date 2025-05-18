<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Model\Cart;

use Exception;
use Ramsey\Uuid\Uuid;

final class Cart
{
    /**
     * @throws Exception
     */
    public function __construct(
        readonly private string $uuid,
        private readonly Customer $customer,
        /** @var array<Item> */
        private readonly PaymentMethod $paymentMethod = PaymentMethod::CARD,
        private array $items = [],
    ) {
        $this->ensureItemsValid($this->items);
    }

    /**
     * @param array $items
     * @return void
     * @throws Exception
     */
    private function ensureItemsValid(array $items): void
    {
        foreach ($items as $item) {
            if (!$item instanceof Item) {
                $error = sprintf(
                    'Invalid data passed to Cart constructor: got %s instead of Item.',
                    is_object($item) ? get_class($item) : gettype($item)
                );
                throw new Exception($error);
            }
        }
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getPaymentMethod(): PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param string $productUuid
     * @param float $price
     * @param int $quantity
     * @return void
     */
    public function addProduct(string $productUuid, float $price, int $quantity = 1): void
    {
        foreach ($this->items as $index => $item) {
            if ($item->getProductUuid() === $productUuid) {
                $newItem = new Item(
                    uuid: $item->getUuid(),
                    productUuid: $productUuid,
                    price: $price, // на случай, если цена изменилась
                    quantity: $item->getQuantity() + $quantity
                );
                $this->items[$index] = $newItem;
                return;
            }
        }

        $this->items[] = new Item(
            uuid: Uuid::uuid4()->toString(),
            productUuid: $productUuid,
            price: $price,
            quantity: $quantity
        );
    }
}
