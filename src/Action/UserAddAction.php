<?php

namespace App\Action;

use App\Domain\User\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RedBeanPHP\R;

/**
 * Action
 */
final class UserAddAction
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
        // First we create a Bean or row, empty
        $newUser = R::dispense('users');

        $parsedBody = $request->getParsedBody();

        // Now we fill the new row with the params
        $newUser->name = $parsedBody['name'];
        $newUser->surname = $parsedBody['surname'];
        $newUser->dateBirth = $parsedBody['dateBirth'];
        $newUser->username = $parsedBody['username'];
        $newUser->password = $parsedBody['password'];
        $newUser->email = $parsedBody['email'];

        // Invoke the Domain with inputs and retain the result
        $addUserList = R::store($newUser);
        // Build the HTTP response
        $response->getBody()->write((string) json_encode($addUserList));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
