<?php

declare(strict_types=1);

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="tokens")
 */
class Token extends AbstractEntity
{
    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private UuidInterface $id;

    public function __construct()
    {
        $this->id = $this->generateId();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }
}
