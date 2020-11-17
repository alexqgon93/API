<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class UserService
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param UserRepository $repository The repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a user by the given user id.
     *
     * @param int $userId The user id
     *
     * @throws ValidationException
     *
     * @return SingleObject The user data
     */
    public function getUserDetails(int $userId)
    {
        // Validation
        if (empty($userId)) {
            throw new ValidationException('User ID required');
        }
        return $this->repository->getUserById($userId);
    }

    /**
     * Get all users.
     *
     * @return Array The users data
     */
    public function getUsers()
    {
        return $this->repository->getUsers();
    }

    /**
     * User already exists
     *
     * @return Array The user data
     */
    public function getEmail($email)
    {
        // Validation
        if (empty($email)) {
            throw new ValidationException('Email required');
        }
        return $this->repository->emailExists($email);
    }
}
