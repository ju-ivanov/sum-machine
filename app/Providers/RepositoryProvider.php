<?php

declare(strict_types=1);

namespace App\Providers;

use App\Doctrine\Repository\NumberRepository;
use App\Doctrine\Repository\TokenRepository;
use App\Entities\Number;
use App\Entities\Token;
use App\Repositories\NumberRepositoryInterface;
use App\Repositories\TokenRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    private ?EntityManagerInterface $em = null;

    public function register()
    {
        $this->app->bind(Connection::class, function () {
            return $this->em()->getConnection();
        });

        $this->app->bind(TokenRepositoryInterface::class, function () {
            return new TokenRepository($this->em(), $this->em()->getClassMetadata(Token::class));
        });

        $this->app->bind(NumberRepositoryInterface::class, function () {
            return new NumberRepository($this->em(), $this->em()->getClassMetadata(Number::class));
        });
    }

    private function em(): EntityManagerInterface
    {
        if (!$this->em instanceof EntityManagerInterface) {
            $this->em = $this->app->make(EntityManagerInterface::class);
        }

        return $this->em;
    }
}
