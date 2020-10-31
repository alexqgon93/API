<?php

namespace App\Domain\User\Repository;

use PDO;
use RedBeanPHP\R;

/**
 * Repository.
 */
class RoleRepository
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
     * Get role by the given role id.
     *
     * @param int $roleId The role id
     *
     * @return SingleObject The role data
     */
    public function getRoleById(int $roleId)
    {
        return R::load('roles', $roleId);
    }

    /**
     * Get roles.
     *
     * @return Array The roles data
     */
    public function getRoles()
    {
        return R::findAll('roles');
    }
}
