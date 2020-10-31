<?php

namespace App\Action;

use App\Domain\User\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RedBeanPHP\R;

/**
 * Action
 */
final class UserUpdateAction
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
        // Collect input from the HTTP request
        $userId = (int) $args['id'];

        // Invoke the Domain with inputs and retain the result
        $userData = $this->userService->getUserDetails($userId);

        $parsedBody = $request->getParsedBody();

        // Now we fill the new row with the params
        $userData->name = $parsedBody['name'];
        $userData->surname = $parsedBody['surname'];
        $userData->dateBirth = $parsedBody['dateBirth'];
        $userData->username = $parsedBody['username'];
        $userData->password = $parsedBody['password'];
        $userData->email = $parsedBody['email'];

        // Invoke the Domain with inputs and retain the result
        $addUserList = R::store($userData);
        // Build the HTTP response
        $response->getBody()->write((string) json_encode($addUserList));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
