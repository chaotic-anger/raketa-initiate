<?php

namespace Raketa\BackendTestTask\Controller\Cart;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\Controller\DefaultController;
use Raketa\BackendTestTask\Service\CartService;
use Raketa\BackendTestTask\View\DTO\AddProductToCartDto;

final class AddToCartController extends DefaultController
{
    public function __construct(
        private readonly CartService $cartService,
    ) {
    }

    public function __invoke(RequestInterface $request): ResponseInterface
    {
        $rawRequest = json_decode($request->getBody()->getContents(), true);
        $newCart = $this->cartService->addProductToCart($this->session->getId(), $rawRequest['productUuid']);

        return $this->responder->response(AddProductToCartDto::create($newCart));
    }
}
