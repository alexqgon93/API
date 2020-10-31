<?php

namespace App\Action;

use App\Domain\User\Service\CategoryService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class CategoryAction
{
    /**
     * @var CategoryReaderData
     */
    private $categoryReader;

    /**
     * The constructor.
     *
     * @param CategoryReaderData $categoryReader The category reader
     */
    public function __construct(CategoryService $categoryReader)
    {
        $this->categoryReader = $categoryReader;
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
        $categoryId = (int) $args['id'];

        // Invoke the Domain with inputs and retain the result
        $categoryData = $this->categoryReader->getCategoryById($categoryId);

        // Build the HTTP response
        $response->getBody()->write((string) json_encode($categoryData));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
