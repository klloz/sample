<?php

namespace App\Infrastructure\User\Query;

use App\Application\User\Query\LangList\LangListView;
use App\Application\User\Query\LangList\LangView;
use App\Domain\User\Language;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DoctrineLangListQuery
 */
class DoctrineLangListQuery
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
     * @return LangListView
     */
    public function execute(): LangListView
    {
        $mappings = [
            'l.uuid',
            'l.name',
            'COUNT(u.uuid)',
        ];

        $qb = $this->entityManager->createQueryBuilder()
            ->from(Language::class, 'l')
            ->leftJoin('l.users', 'u')
            ->select('new ' . LangView::class . '(' . implode(', ', $mappings) . ')')
            ->groupBy('l.uuid')
        ;

        $items = $qb->getQuery()->execute();

        return new LangListView($items);
    }
}
