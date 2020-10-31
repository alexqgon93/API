<?php

namespace App\Action;

use App\Domain\User\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RedBeanPHP\R;

/**
 * Action
 */
final class UserDeleteAction
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
     * @return The number of rows that has been deleted
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
    {
        // Collect input from the HTTP request
        $userId = (int) $args['id'];

        // Invoke the Domain with inputs and retain the result
        $userData = $this->userService->getUserDetails($userId);

        // Invoke the Domain with inputs and retain the result
        $deleteUser = R::trash($userData);
        // Build the HTTP response
        $response->getBody()->write((string) json_encode($deleteUser));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
