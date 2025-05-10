<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\Infrastructure\Responder\JsonResponder;
use Raketa\BackendTestTask\Infrastructure\Responder\Responder;
use Raketa\BackendTestTask\View\ProductsView;

readonly class GetProductsByCategoryController extends DefaultController
{
    public function __construct(
        private Responder $responder,
        private ProductsView $productsView
    ) {
        parent::__construct($responder);
    }

    public function get(RequestInterface $request): ResponseInterface
    {
        $rawRequest = json_decode($request->getBody()->getContents(), true);

        return $this->responder->response($this->productsView->toArray($rawRequest['category']));
    }
}
