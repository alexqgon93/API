<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\RoleRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class RoleService
{
    /**
     * @var RoleRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param RoleRepository $repository The repository
     */
    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a role by the given role id.
     *
     * @param int $roleId The role id
     *
     * @throws ValidationException
     *
     * @return SingleObject The role data
     */
    public function getRoleDetails(int $roleId)
    {
        // Validation
        if (empty($roleId)) {
            throw new ValidationException('Role ID required');
        }
        return $this->repository->getRoleById($roleId);
    }

    /**
     * Get all roles.
     *
     * @return Array The roles data
     */
    public function getRoles()
    {
        return $this->repository->getRoles();
    }
}
