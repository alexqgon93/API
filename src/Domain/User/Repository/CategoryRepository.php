<?php

namespace App\Domain\User\Repository;

use DomainException;
use PDO;
use RedBeanPHP\R;

/**
 * Repository.
 */
class CategoryRepository
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
     * @param int $categoryId The category id
     *
     * @throws DomainException
     *
     * @return CategoiryReaderRepository The category data
     */
    public function getCategoryById(int $categoryId)
    {
        return R::load('categories', $categoryId);
    }

    /**
     * Get all categories.
     *
     * @return CategoryReaderData The category data
     */
    public function getCategories()
    {
        return array_values(R::findAll('categories'));
    }
}
