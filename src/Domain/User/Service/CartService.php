<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\CartRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class CartService
{
    /**
     * @var CartRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param UserRepository $repository The repository
     */
    public function __construct(CartRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a cart by the given user id.
     *
     * @param int $userId The user id
     *
     * @throws ValidationException
     *
     * @return SingleObject The cart data
     */
    public function getCartDetails(int $cartId)
    {
        // Validation
        if (empty($cartId)) {
            throw new ValidationException('Cart ID required');
        }
        return $this->repository->getCartById($cartId);
    }

    /**
     * Get all users.
     *
     * @return Array The carts data
     */
    public function getCarts()
    {
        return $this->repository->getCarts();
    }
}
