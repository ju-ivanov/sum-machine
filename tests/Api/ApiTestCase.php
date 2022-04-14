<?php

declare(strict_types=1);

namespace Tests\Api;

use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Faker\Generator;
use Tests\TestCase;

abstract class ApiTestCase extends TestCase
{
    protected const TOKEN_HEADER = 'Token';

    private ?Generator $faker = null;
    private ?StructureFactory $structureFactory = null;
    private ?EntityPersistService $entityPersistService = null;

    public function create(): EntityPersistService
    {
        if ($this->entityPersistService === null) {
            $this->entityPersistService = $this->app->make(EntityPersistService::class);
        }

        return $this->entityPersistService;
    }

    protected function getFaker(): Generator
    {
        if ($this->faker === null) {
            $this->faker = Factory::create();
        }

        return $this->faker;
    }

    protected function structure(): StructureFactory
    {
        if ($this->structureFactory === null) {
            $this->structureFactory = $this->app->make(StructureFactory::class);
        }

        return $this->structureFactory;
    }

    protected function truncate(): TruncateService
    {
        return $this->app->make(TruncateService::class);
    }

    protected function truncateAll(): void
    {
        $this->truncate()->numbers();
        $this->truncate()->tokens();
    }

    protected function clearEntityManager(): void
    {
        $this->app->make(EntityManagerInterface::class)->clear();
    }

    protected function generateToken(): string
    {
        $token = $this->create()->token();

        return $token->getId()->toString();
    }
}
