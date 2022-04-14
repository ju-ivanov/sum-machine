<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Token;
use Doctrine\Common\Collections\Selectable;
use Doctrine\Persistence\ObjectRepository;

/**
 * @template T of Token
 * @extends RepositoryInterface<T>
 */
interface TokenRepositoryInterface extends ObjectRepository, Selectable, RepositoryInterface
{
    /**
     * @param mixed $id
     *
     * @return null|Token
     */
    public function find($id);

    /**
     * @param null $limit
     * @param null $offset
     *
     * @return Token[]
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null);

    /**
     * @return null|Token
     */
    public function findOneBy(array $criteria);

    /**
     * @return Token[]
     */
    public function findAll();
}
