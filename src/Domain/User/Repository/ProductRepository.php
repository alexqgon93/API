<?php

namespace App\Domain\User\Repository;

use PDO;
use RedBeanPHP\R;

/**
 * Repository.
 */
class ProductRepository
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
     * Get product by the given product id.
     *
     * @param int $userId The product id
     *
     * @return SingleObject The product data
     */
    public function getProductById(int $productId)
    {
        return R::load('products', $productId);
    }

    /**
     * Get products
     *
     * @return Array The products data
     */
    public function getProducts()
    {
        return array_values(R::findAll('products'));
    }

    /**
     * Get products of a specific category
     *
     * @return Array The products data
     */
    public function getProductsByCategory(int $categoryId)
    {
        return array_values(R::getAll("select * from products where category = $categoryId"));
    }

    /**
     * Get products featured
     *
     * @return Array The products data
     */
    public function getProductsFeatured(int $featured)
    {
        return array_values(R::getAll("select * from products where featured = $featured"));
    }

}
