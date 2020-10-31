<?php

namespace App\Action;

use App\Domain\User\Service\RoleService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class RoleAction
{
    /**
     * @var RoleService
     */
    private $roleService;

    /**
     * The constructor.
     *
     * @param RoleService $userReader The user reader
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
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
        $roleId = (int) $args['id'];
        // Invoke the Domain with inputs and retain the result
        $roleList = $this->roleService->getRoleDetails($roleId);
        // Build the HTTP response
        $response->getBody()->write((string) json_encode($roleList));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}