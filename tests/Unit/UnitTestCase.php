<?php

declare(strict_types=1);

namespace Tests\Unit;

use Faker\Factory;
use Faker\Generator;
use Tests\TestCase;

class UnitTestCase extends TestCase
{
    private ?Generator $faker = null;
    private ?EntityCreateService $entityCreateService = null;

    public function create(): EntityCreateService
    {
        if ($this->entityCreateService === null) {
            $this->entityCreateService = $this->app->make(EntityCreateService::class);
        }

        return $this->entityCreateService;
    }

    protected function getFaker(): Generator
    {
        if ($this->faker === null) {
            $this->faker = Factory::create();
        }

        return $this->faker;
    }
}
