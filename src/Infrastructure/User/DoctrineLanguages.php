<?php

namespace App\Infrastructure\User;

use App\Domain\User\Language;
use App\Domain\User\Languages;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DoctrineLanguages
 */
class DoctrineLanguages implements Languages
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
        $this->repository = $entityManager->getRepository(Language::class);
    }

    /**
     * @param Language $language
     */
    public function add(Language $language): void
    {
        $this->entityManager->persist($language);
    }

    /**
     * @param string $name
     *
     * @return Language|Object|null
     */
    public function findByName(string $name): ?Language
    {
        return $this->repository->findOneBy([
            'name' => $name
        ]);
    }
}
