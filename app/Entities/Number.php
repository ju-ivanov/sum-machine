<?php

declare(strict_types=1);

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="numbers")
 */
class Number extends AbstractEntity
{
    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private UuidInterface $id;

    /**
     * @ORM\ManyToOne(targetEntity="Token")
     */
    private Token $token;

    /**
     * @ORM\Column(type="integer")
     */
    private int $number;

    public function __construct(Token $token, int $number)
    {
        $this->id = $this->generateId();

        $this->token = $token;
        $this->number = $number;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getToken(): Token
    {
        return $this->token;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setToken(Token $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }
}
