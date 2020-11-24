<?php

namespace App\Action;

use App\Domain\User\Service\CartService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RedBeanPHP\R;
include_once '/Applications/XAMPP/xamppfiles/htdocs/API/lib/php-jwt-master/src/BeforeValidException.php';
include_once '/Applications/XAMPP/xamppfiles/htdocs/API/lib/php-jwt-master/src/ExpiredException.php';
include_once '/Applications/XAMPP/xamppfiles/htdocs/API/lib/php-jwt-master/src/SignatureInvalidException.php';
include_once '/Applications/XAMPP/xamppfiles/htdocs/API/lib/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

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
        $key = "JWTToken";
        $parsedBody = $request->getParsedBody();
        $products = $parsedBody['products'];
        $jwt = $request->getHeader('Authorization');
        $jwt = str_replace('Bearer ', '', $jwt[0]);
        $decoded = JWT::decode($jwt, $key, ['HS256']);

        if ($decoded) {
            // First we create a Bean or row, empty
            $newCart = R::dispense('carts');
            $beans = array();
            // Now we fill the new row with the params
            $newCart->user_id = $parsedBody['userId'];
            $newCart->date = $parsedBody['date'];
            $newCart->amount = $parsedBody['amount'];

            // Invoke the Domain with inputs and retain the result
            $addCardList = R::store($newCart);
            for ($i = 0; $i < count($products); $i++) {
                $beans[] = R::dispense('product_cart');
                $beans[$i]->product_id = $products[$i]['id'];
                $beans[$i]->quantity = $products[$i]['quantity'];
                $beans[$i]->cartId = $addCardList;
            }
            $addProductCart = R::storeAll($beans);
            // Build the HTTP response
            if (!empty($addCardList) && !empty($addProductCart)) {
                $response->getBody()->write((string) json_encode(array("message" => "Carrito creado correctamente.")));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
            } else { $response->getBody()->write((string) json_encode(array("message" => "No se ha podido introducir carrito, pruebelo más tarde.")));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }
        } else {
            $response->getBody()->write((string) json_encode(array("message" => "Token no valido")));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}
