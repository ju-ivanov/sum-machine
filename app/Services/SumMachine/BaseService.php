<?php

declare(strict_types=1);

namespace App\Services\SumMachine;

use App\Entities\Token;
use App\Exceptions\DataSourceException;
use App\Exceptions\TokenNotFoundException;
use App\Repositories\TokenRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class BaseService
{
    protected TokenRepositoryInterface $tokenRepository;

    public function __construct(TokenRepositoryInterface $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * @throws DataSourceException
     * @throws TokenNotFoundException
     */
    protected function getToken(UuidInterface $tokenId): Token
    {
        $token = $this->tokenRepository->find($tokenId);
        if (!($token instanceof Token)) {
            throw new TokenNotFoundException(TokenNotFoundException::MESSAGE);
        }

        return $token;
    }
}
