<?php

declare(strict_types=1);


namespace Raketa\BackendTestTask\Infrastructure\Redis\Assembler;


use Raketa\BackendTestTask\Model\Cart\Cart;
use Raketa\BackendTestTask\Model\Cart\Item;
use Raketa\BackendTestTask\Model\Cart\Customer;
use Raketa\BackendTestTask\Model\Cart\PaymentMethod;
use Raketa\BackendTestTask\Repository\ProductRepository;

/**
 * Сборщик сущности из данных, полученных из Redis.
 *
 * ОЧЕНЬ упрощен, так как не знаю тонкости работы Redis и настоящей реализации.
 *
 * В идеале его надо разбить на ассемблеры для каждой сущности. Здесь для простоты ассемблер один.
 */
final readonly class CartAssembler
{

    public function assemble($data): ?Cart
    {
        return new Cart(
            $data['uuid'],
            $this->assembleCustomer($data['customer']),
            PaymentMethod::from($data['paymentMethod']),
            $this->assembleItems($data['items']),
        );
    }

    public function disassemble(Cart $cart): mixed
    {
        return serialize($cart); // примитивнейший вариант
    }

    private function assembleCustomer(mixed $data): Customer
    {
        return new Customer(
            $data['uuid'],
            $data['firstName'],
            $data['lastName'],
            $data['middleName'],
            $data['email'],
        );
    }

    /**
     * @param mixed $data
     * @return array<Item>
     */
    private function assembleItems(mixed $data): array
    {
        $items = [];
        foreach ($data as $datum) {
            $items[] = new Item(
                $datum['uuid'],
                $datum['productUuid'],
                $datum['price'],
                $datum['quantity'],
            );
        }

        return $items;
    }
}