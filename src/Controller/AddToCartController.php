<?php

namespace Raketa\BackendTestTask\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\Domain\CartItem;
use Raketa\BackendTestTask\Infrastructure\Responder\JsonResponder;
use Raketa\BackendTestTask\Infrastructure\Responder\Responder;
use Raketa\BackendTestTask\Repository\CartManager;
use Raketa\BackendTestTask\Repository\ProductRepository;
use Raketa\BackendTestTask\View\CartView;
use Ramsey\Uuid\Uuid;

readonly class AddToCartController extends DefaultController
{
    public function __construct(
        private Responder $responder,
        private ProductRepository $productRepository,
        private CartManager $cartManager,
        private CartView $cartView,
    ) {
        parent::__construct($responder);
    }

    public function add(RequestInterface $request): ResponseInterface
    {
        $rawRequest = json_decode($request->getBody()->getContents(), true);
        $product = $this->productRepository->getByUuid($rawRequest['productUuid']);

        $cart = $this->cartManager->getCart();
        $cart->addItem(
            new CartItem(
                Uuid::uuid4()->toString(),
                $product->getUuid(),
                $product->getPrice(),
                $rawRequest['quantity'],
            )
        );

        return $this->responder->response([
            'status' => 'success',
            'cart' => $this->cartView->toArray($cart)
        ]);
    }
}
