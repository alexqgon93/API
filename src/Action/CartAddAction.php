<?php

namespace App\Action;

use App\Domain\User\Service\CartService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RedBeanPHP\R;

/**
 * Action
 */
final class CartAddAction
{
    /**
     * @var CartService
     */
    private $cartService;

    /**
     * The constructor.
     *
     * @param CartService $userReader The user reader
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
        // First we create a Bean or row, empty
        $newCart = R::dispense('carts');
        $newProductCart = R::dispense('product_cart');
        $parsedBody = $request->getParsedBody();
        //$jwt = $request->getHeader('Authorization');
        //verify_idtoken
        //$verify = JWT::verify($jwt, "JWTToken", array('HS256'));

        // Now we fill the new row with the params
        $newCart->user_id = $parsedBody['userId'];
        $newCart->date = $parsedBody['date'];
        $newCart->amount = $parsedBody['amount'];
        // Invoke the Domain with inputs and retain the result
        $addCardList = R::store($newCart);

        $newProductCart->product_id = $parsedBody['productId'];
        $newProductCart->quantity = $parsedBody['quantity'];
        $newProductCart->cartId = $addCardList;
        $addProductCart = R::store($newProductCart);

        // Build the HTTP response
        $response->getBody()->write((string) json_encode($addCardList));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
