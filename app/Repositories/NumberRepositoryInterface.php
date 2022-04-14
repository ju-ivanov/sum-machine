<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Number;
use App\Entities\Token;
use Doctrine\Common\Collections\Selectable;
use Doctrine\Persistence\ObjectRepository;

/**
 * @template T of Number
 * @extends RepositoryInterface<T>
 */
interface NumberRepositoryInterface extends ObjectRepository, Selectable, RepositoryInterface
{
    /**
     * @param mixed $id
     *
     * @return null|Number
     */
    public function find($id);

    /**
     * @param null $limit
     * @param null $offset
     *
     * @return Number[]
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null);

    /**
     * @return null|Number
     */
    public function findOneBy(array $criteria);

    public function findLastOneByToken(Token $token): ?Number;

    /**
     * @return Number[]
     */
    public function findAll();

    public function countByToken(Token $token): int;

    public function sumByToken(Token $token): int;
}
