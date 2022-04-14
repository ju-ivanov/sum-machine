<?php

declare(strict_types=1);

namespace App\Services\Response\Serializers;

class SumResponseSerializer
{
    public function serialize(int $sum): array
    {
        return [
            'sum' => $sum,
        ];
    }
}
