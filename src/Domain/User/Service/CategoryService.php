<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\CategoryRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class CategoryService
{
    /**
     * @var CategoryRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param CategoryRepository $repository The repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get category by the given category id.
     *
     * @param int $categoryId The category id
     *
     * @throws DomainException
     *
     * @return CategoiryReaderRepository The category data
     */
    public function getCategoryById(int $categoryId)
    {
        // Validation
        if (empty($categoryId)) {
            throw new ValidationException('Category ID required');
        }
        return $this->repository->getCategoryById($categoryId);
    }

    /**
     * Get all categories.
     *
     * @return CategoriesData The category data
     */
    public function getCategories()
    {
        return $this->repository->getCategories();
    }
}
