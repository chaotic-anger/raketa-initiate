<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Controller\Catalog;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\Controller\DefaultController;
use Raketa\BackendTestTask\Infrastructure\Http\Responder\JsonResponder;
use Raketa\BackendTestTask\Infrastructure\Http\Responder\Responder;
use Raketa\BackendTestTask\Service\CatalogService;
use Raketa\BackendTestTask\View\Backup\ProductsView;
use Raketa\BackendTestTask\View\ProductAssembler;

final class GetProductsByCategoryController extends DefaultController
{
    public function __construct(
        private readonly CatalogService $catalogService,
    ) {
    }

    public function __invoke(RequestInterface $request): ResponseInterface
    {
        $rawRequest = json_decode($request->getBody()->getContents(), true);

        return $this->responder->response($this->catalogService->getProductsByCategory($rawRequest['category']));
    }
}
