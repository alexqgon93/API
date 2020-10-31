<?php

namespace App\Action;

use App\Domain\User\Service\ProductService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class ProductAction
{
    /**
     * @var ProductService
     */
    private $productService;

    /**
     * The constructor.
     *
     * @param ProductService $userReader The user reader
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Invoke.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     * @param array $args The route arguments
     *
     * @return ResponseInterface The response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
    {
        // Collect input from the HTTP request
        $productId = (int) $args['id'];
        // Invoke the Domain with inputs and retain the result
        $productList = $this->productService->getProductDetails($productId);
        // Build the HTTP response
        $response->getBody()->write((string) json_encode($productList));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}