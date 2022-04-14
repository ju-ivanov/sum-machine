<?php

declare(strict_types=1);

namespace App\Doctrine\Repository;

use App\Entities\Number;
use App\Entities\Token;
use App\Repositories\NumberRepositoryInterface;

/**
 * @method Number[] findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)
 * @method ?Number  findOneBy(array $criteria)
 */
class NumberRepository extends AbstractRepository implements NumberRepositoryInterface
{
    public function findLastOneByToken(Token $token): ?Number
    {
        $numbers = $this->findBy(['token' => $token], ['createdAt' => 'desc'], 1);
        if (count($numbers) > 0) {
            return $numbers[0];
        }

        return null;
    }

    public function countByToken(Token $token): int
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        return (int) $qb->select('count(n.id)')
            ->from(Number::class, 'n')
            ->where($qb->expr()->eq('n.token', ':token'))
            ->setParameter('token', $token)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function sumByToken(Token $token): int
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        return (int) $qb->select('sum(n.number)')
            ->from(Number::class, 'n')
            ->where($qb->expr()->eq('n.token', ':token'))
            ->setParameter('token', $token)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
