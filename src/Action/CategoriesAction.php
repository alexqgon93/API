<?php

namespace App\Action;

use App\Domain\User\Service\CategoryService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class CategoriesAction
{
    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * The constructor.
     *
     * @param CategoryService $categoryService The category reader
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
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
        $categoryData = $this->categoryService->getCategories();

        // Build the HTTP response
        $response->getBody()->write((string) json_encode($categoryData));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
