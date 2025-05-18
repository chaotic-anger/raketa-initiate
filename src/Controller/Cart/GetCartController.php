<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Controller\Cart;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\Controller\DefaultController;
use Raketa\BackendTestTask\Service\CartService;
use Raketa\BackendTestTask\View\DTO\ErrorDto;

final class GetCartController extends DefaultController
{
    public function __construct(
        private readonly CartService $cartService,
    ) {
    }

    public function __invoke(RequestInterface $request): ResponseInterface
    {
        $cart = $this->cartService->getCart($this->session->getId());
        if (!$cart) {
            return $this->responder->response(ErrorDto::create('Cart not found'), 404);
        }

        return $this->responder->response($cart);
    }
}
