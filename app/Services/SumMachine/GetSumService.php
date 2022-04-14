<?php

declare(strict_types=1);

namespace App\Services\SumMachine;

use App\Exceptions\DataSourceException;
use App\Exceptions\TokenNotFoundException;
use App\Repositories\NumberRepositoryInterface;
use App\Repositories\TokenRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class GetSumService extends BaseService
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
     * @throws TokenNotFoundException
     */
    public function handle(UuidInterface $tokenId): int
    {
        $token = $this->getToken($tokenId);

        return $this->numberRepository->sumByToken($token);
    }
}
