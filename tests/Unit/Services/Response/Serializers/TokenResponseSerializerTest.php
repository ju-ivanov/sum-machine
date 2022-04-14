<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Response\Serializers;

use App\Services\Response\Serializers\TokenResponseSerializer;
use Tests\Unit\UnitTestCase;

class TokenResponseSerializerTest extends UnitTestCase
{
    public function testSerialize(): void
    {
        $token = $this->create()->token();
        $serializer = $this->app->make(TokenResponseSerializer::class);
        $result = $serializer->serialize($token);

        self::assertEquals($token->getId()->toString(), $result['token']);
    }
}
