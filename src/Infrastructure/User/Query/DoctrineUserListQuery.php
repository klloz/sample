<?php

namespace App\Infrastructure\User\Query;

use App\Application\User\Query\UserList\UserListParams;
use App\Application\User\Query\UserList\UserListView;
use App\Application\User\Query\UserList\UserView;
use App\Domain\User\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DoctrineUserListQuery
 */
class DoctrineUserListQuery
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param UserListParams $parameters
     *
     * @return UserListView
     */
    public function execute(UserListParams $parameters): UserListView
    {
        $mappings = [
            'u.uuid',
            'u.name',
            'u.surname',
            'u.email',
            'GROUP_CONCAT(l.name)',
            'u.birthDate',
            'u.registrationDate',
        ];

        $qb = $this->entityManager->createQueryBuilder()
            ->from(User::class, 'u')
            ->leftJoin('u.langs', 'l')
            ->select('new ' . UserView::class . '(' . implode(', ', $mappings) . ')')
            ->groupBy('u.uuid')
            ->orderBy('u.registrationDate')
        ;

        if ($parameters->registeredSince) {
            $qb->where('u.registrationDate >= :registeredSince')
                ->setParameter('registeredSince', $parameters->registeredSince);
        }

        $items = $qb->getQuery()->execute();

        return new UserListView($items);
    }
}
