<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\ProductRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class ProductService
{
    /**
     * @var ProductRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param ProductRepository $repository The repository
     */
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a product by the given product id.
     *
     * @param int $productId The user id
     *
     * @throws ValidationException
     *
     * @return SingleObject The user data
     */
    public function getProductDetails(int $productId)
    {
        // Validation
        if (empty($productId)) {
            throw new ValidationException('Product ID required');
        }
        return $this->repository->getProductById($productId);
    }

    /**
     * Get all users.
     *
     * @return Array The products data
     */
    public function getProducts()
    {
        return $this->repository->getProducts();
    }
}
