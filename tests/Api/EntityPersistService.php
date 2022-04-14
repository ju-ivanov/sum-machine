<?php

declare(strict_types=1);

namespace Tests\Api;

use App\Entities\Number;
use App\Entities\Token;
use App\Repositories\NumberRepositoryInterface;
use App\Repositories\TokenRepositoryInterface;
use Tests\Unit\EntityCreateService;

class EntityPersistService
{
    private EntityCreateService $entityCreateService;
    private TokenRepositoryInterface $tokenRepository;
    private NumberRepositoryInterface $numberRepository;

    public function __construct(
        EntityCreateService $entityCreateService,
        TokenRepositoryInterface $tokenRepository,
        NumberRepositoryInterface $numberRepository
    ) {
        $this->entityCreateService = $entityCreateService;
        $this->tokenRepository = $tokenRepository;
        $this->numberRepository = $numberRepository;
    }

    public function token(): Token
    {
        $token = $this->entityCreateService->token();

        $this->tokenRepository->save($token);

        return $token;
    }

    public function number(Token $token, ?int $number = null): Number
    {
        $number = $this->entityCreateService->number($token, $number);

        $this->numberRepository->save($number);

        return $number;
    }
}
