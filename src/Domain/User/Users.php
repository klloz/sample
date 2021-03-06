<?php

namespace App\Domain\User;

/**
 * Interface Users
 */
interface Users
{
    /**
     * @param User $user
     */
    public function add(User $user): void;

    /**
     * @param string $email
     *
     * @return User|null
     */
    public function findByEmail(string $email): ?User;
}
