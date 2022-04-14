<?php

declare(strict_types=1);

namespace App\Services\SumMachine;

use App\Entities\Number;
use App\Exceptions\DataSourceException;
use App\Exceptions\TokenNotFoundException;
use App\Repositories\NumberRepositoryInterface;
use App\Repositories\TokenRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class AddNumberService extends BaseService
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
    public function handle(UuidInterface $tokenId, int $number): int
    {
        $token = $this->getToken($tokenId);

        $number = new Number($token, $number);
        $this->numberRepository->save($number);

        return $this->numberRepository->countByToken($token);
    }
}
