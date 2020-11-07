<?php

namespace App\Action;

use App\Domain\User\Service\CartService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RedBeanPHP\R;

/**
 * Action
 */
final class CartDeleteAction
{
    /**
     * @var CartService
     */
    private $cartService;

    /**
     * The constructor.
     *
     * @param CartService $cartReader The cart reader
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
     * @return The number of rows that has been deleted
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
    {
        // Collect input from the HTTP request
        $cartId = (int) $args['id'];

        // Invoke the Domain with inputs and retain the result
        $cartData = $this->cartService->getCartDetails($cartId);

        // Invoke the Domain with inputs and retain the result
        $deleteCart = R::trash($cartData);
        // Build the HTTP response
        $response->getBody()->write((string) json_encode($deleteCart));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
