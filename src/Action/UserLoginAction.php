<?php

namespace App\Action;

use App\Domain\User\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RedBeanPHP\R;

include_once '/Applications/XAMPP/xamppfiles/htdocs/API/config/core.php';
include_once '/Applications/XAMPP/xamppfiles/htdocs/API/lib/php-jwt-master/src/BeforeValidException.php';
include_once '/Applications/XAMPP/xamppfiles/htdocs/API/lib/php-jwt-master/src/ExpiredException.php';
include_once '/Applications/XAMPP/xamppfiles/htdocs/API/lib/php-jwt-master/src/SignatureInvalidException.php';
include_once '/Applications/XAMPP/xamppfiles/htdocs/API/lib/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

/**
 * Action
 */
final class UserLoginAction
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * The constructor.
     *
     * @param UserService $userReader The user reader
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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
        $parsedBody = $request->getParsedBody();

        // Now we get the email to check if the user is already in the database
        $email = $parsedBody['email'];
        $email_exists = $this->userService->getEmail($email);

        if (!empty($email_exists) && ($email_exists[0]['password'] == $parsedBody['password'])) {
            $userData = $this->userService->getUserDetails($email_exists[0]['id']);
            $key = "JWTToken";
            $issued_at = time();
            $expiration_time = $issued_at + (60 * 60); // valid for 1 hour
            $issuer = "http://local.api.localhost/";
            $token = array(
                "iat" => $issued_at,
                "exp" => $expiration_time,
                "iss" => $issuer,
                "data" => array(
                    "id" => $userData->id,
                    "firstname" => $userData->firstname,
                    "lastname" => $userData->lastname,
                    "email" => $userData->email,
                ),
            );
            $jwt = JWT::encode($token, $key);
            // Build the HTTP response
            $response->getBody()->write((string) json_encode(array("message" => "Login hecho correctamente", "jwt" => $jwt)));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } else {
            $response->getBody()->write((string) json_encode(array("message" => "Login failed.")));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }
}
