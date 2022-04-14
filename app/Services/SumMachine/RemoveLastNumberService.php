<?php

declare(strict_types=1);

namespace App\Services\SumMachine;

use App\Entities\Number;
use App\Exceptions\DataSourceException;
use App\Exceptions\EmptyNumberStackException;
use App\Exceptions\TokenNotFoundException;
use App\Repositories\NumberRepositoryInterface;
use App\Repositories\TokenRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class RemoveLastNumberService extends BaseService
{
    private NumberRepositoryInterface $numberRepository;

    public function __construct(
        TokenRepositoryInterface $tokenRepository,
        NumberRepositoryInterface $numberRepository
    ) {
        parent::__construct($tokenRepository);

        $this->numberRepository = $numberRepository;
    }

    /**
     * @throws DataSourceException
     * @throws EmptyNumberStackException
     * @throws TokenNotFoundException
     */
    public function handle(UuidInterface $tokenId): int
    {
        $token = $this->getToken($tokenId);

        $lastNumber = $this->numberRepository->findLastOneByToken($token);
        if (!($lastNumber instanceof Number)) {
            throw new EmptyNumberStackException(EmptyNumberStackException::MESSAGE);
        }

        $this->numberRepository->remove($lastNumber);

        return $this->numberRepository->countByToken($token);
    }
}
