<?php

declare(strict_types=1);

namespace App\Services\Response\Serializers;

class NumbersCountResponseSerializer
{
    public function serialize(int $numbersCount): array
    {
        return [
            'count' => $numbersCount,
        ];
    }
}
