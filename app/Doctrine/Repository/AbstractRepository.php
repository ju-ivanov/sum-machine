<?php

declare(strict_types=1);

namespace App\Doctrine\Repository;

use App\Exceptions\DataSourceException;
use App\Repositories\RepositoryInterface;
use Doctrine\ORM\EntityRepository;
use Exception;
use LogicException;

/**
 * @template T of object
 * @extends EntityRepository<T>
 */
abstract class AbstractRepository extends EntityRepository implements RepositoryInterface
{
    /**
     * @throws DataSourceException
     */
    public function save(object ...$objects): void
    {
        $classname = $this->getClassName();

        foreach ($objects as $object) {
            if (!($object instanceof $classname)) {
                throw new LogicException('Object must be instance of ' . $classname);
            }

            try {
                $this->getEntityManager()->persist($object);
            } catch (Exception $e) {
                throw new DataSourceException($e->getMessage(), $e->getCode(), $e);
            }
        }

        try {
            $this->getEntityManager()->flush();
        } catch (Exception $e) {
            throw new DataSourceException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @throws DataSourceException
     */
    public function refresh(object ...$objects): void
    {
        $classname = $this->getClassName();

        foreach ($objects as $object) {
            if (!($object instanceof $classname)) {
                throw new LogicException('Object must be instance of ' . $classname);
            }

            try {
                $this->getEntityManager()->refresh($object);
            } catch (Exception $e) {
                throw new DataSourceException($e->getMessage(), $e->getCode(), $e);
            }
        }
    }

    /**
     * @throws DataSourceException
     */
    public function remove(object ...$objects): void
    {
        $classname = $this->getClassName();

        foreach ($objects as $object) {
            if (!($object instanceof $classname)) {
                throw new LogicException('Object must be instance of ' . $classname);
            }

            try {
                $this->getEntityManager()->remove($object);
            } catch (Exception $e) {
                throw new DataSourceException($e->getMessage(), $e->getCode(), $e);
            }
        }

        try {
            $this->getEntityManager()->flush();
        } catch (Exception $e) {
            throw new DataSourceException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
