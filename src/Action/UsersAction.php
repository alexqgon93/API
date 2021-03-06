<?php

namespace App\Action;

use App\Domain\User\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class UsersAction
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * The constructor.
     *
     * @param UserService $userService The user reader
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
        // Invoke the Domain with inputs and retain the result
        $userList = $this->userService->getUsers();
        // Build the HTTP response
        $response->getBody()->write((string) json_encode($userList));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
