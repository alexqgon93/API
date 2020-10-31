<?php

namespace App\Domain\User\Repository;

use PDO;
use RedBeanPHP\R;

/**
 * Repository.
 */
class CartRepository
{
    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Get user by the given user id.
     *
     * @param int $userId The user id
     *
     * @return SingleObject The user data
     */
    public function getCartById(int $userId)
    {
        return R::load('carts', $userId);
    }

    /**
     * Get users
     *
     * @return Array The users data
     */
    public function getCarts()
    {
        return R::findAll('carts');
    }
}
