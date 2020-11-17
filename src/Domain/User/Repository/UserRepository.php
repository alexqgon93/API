<?php

namespace App\Domain\User\Repository;

use PDO;
use RedBeanPHP\R;

/**
 * Repository.
 */
class UserRepository
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
    public function getUserById(int $userId)
    {
        return R::load('users', $userId);
    }

    /**
     * Get users
     *
     * @return Array The users data
     */
    public function getUsers()
    {
        return R::findAll('users');
    }

    /**
     * Get if the email exists on the DB
     *  */
    public function emailExists($email)
    {
        return array_values(R::getAll("select * from users where email = '$email' LIMIT 0,1"));
    }
}
