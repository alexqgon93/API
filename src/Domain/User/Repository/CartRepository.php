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
        $sql = 'SELECT carts.id as cartId, carts.date as cartDate, carts.amount as cartAmount, users.name as userName, users.surname as userSurname, products.name as productName FROM ((carts INNER JOIN users ON users.id = carts.userId) INNER JOIN product_cart ON product_cart.cartId = carts.id) INNER JOIN products ON products.id = product_cart.productId';
        return array_values(R::getAll($sql));
    }
}
