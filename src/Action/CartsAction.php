<?php

namespace App\Action;

use App\Domain\User\Service\CartService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class CartsAction
{
    /**
     * @var CartService
     */
    private $cartService;

    /**
     * The constructor.
     *
     * @param UserService $userReader The user reader
     */
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
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
        // Invoke the Domain with inputs and retain the result
        $cartList = $this->cartService->getCarts();
        // Build the HTTP response
        $response->getBody()->write((string) json_encode($cartList));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}