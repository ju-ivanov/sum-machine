<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Exceptions\DataSourceException;

/**
 * @template T of object
 */
interface RepositoryInterface
{
    /**
     * @return int
     */
    public function count(array $criteria);

    /**
     * @param T ...$objects
     *
     * @throws DataSourceException
     */
    public function refresh(object ...$objects): void;

    /**
     * @param T ...$objects
     */
    public function remove(object ...$objects): void;

    /**
     * @param T ...$objects
     *
     * @throws DataSourceException
     */
    public function save(object ...$objects): void;
}
