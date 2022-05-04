<?php

namespace App\Entity;

use App\Repository\HobbieRepository;
use App\traits\TimeStampTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HobbieRepository::class)]

/**
 * @ORM\HasLifecycleCallbacks()
 */
class Hobbie
{
    use TimeStampTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 70)]
    private $designiation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesigniation(): ?string
    {
        return $this->designiation;
    }

    public function setDesigniation(string $designiation): self
    {
        $this->designiation = $designiation;

        return $this;
    }
    public function __toString(): string
    {
        return $this->designiation;
    }
}
