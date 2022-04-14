<?php

declare(strict_types=1);

namespace App\Services\SumMachine;

use App\Entities\Token;
use App\Repositories\TokenRepositoryInterface;

class ResetService extends BaseService
{
    public function __construct(TokenRepositoryInterface $tokenRepository)
    {
        parent::__construct($tokenRepository);
    }

    public function handle(): Token
    {
        $token = new Token();

        $this->tokenRepository->save($token);

        return $token;
    }
}
