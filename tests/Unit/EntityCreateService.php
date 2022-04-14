<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Entities\Number;
use App\Entities\Token;
use Faker\Factory;
use Faker\Generator;

class EntityCreateService
{
    private ?Generator $faker = null;

    public function token(): Token
    {
        return new Token();
    }

    public function number(Token $token, ?int $number = null): Number
    {
        return new Number(
            $token,
            $number ?? $this->getFaker()->numberBetween(-100, 100),
        );
    }

    protected function getFaker(): Generator
    {
        if ($this->faker === null) {
            $this->faker = Factory::create();
        }

        return $this->faker;
    }
}
