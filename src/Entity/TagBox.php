<?php

namespace App\Entity;

use App\Repository\TagBoxRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagBoxRepository::class)]
class TagBox
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $box;

    #[ORM\Column(type: 'string', length: 255)]
    private $clearomiser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBox(): ?string
    {
        return $this->box;
    }

    public function setBox(string $box): self
    {
        $this->box = $box;

        return $this;
    }

    public function getClearomiser(): ?string
    {
        return $this->clearomiser;
    }

    public function setClearomiser(string $clearomiser): self
    {
        $this->clearomiser = $clearomiser;

        return $this;
    }
}
