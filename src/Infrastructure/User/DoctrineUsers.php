<?php

namespace App\Infrastructure\User;

use App\Domain\User\User;
use App\Domain\User\Users;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DoctrineUsers
 */
class DoctrineUsers implements Users
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ObjectRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(User::class);
    }

    /**
     * @param User $user
     */
    public function add(User $user): void
    {
        $this->entityManager->persist($user);
    }

    /**
     * @param string $email
     *
     * @return User|Object|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this->repository->findOneBy([
            'email' => $email
        ]);
    }
}
